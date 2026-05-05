<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Flight;
use App\Models\Passenger;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OfflineBookingController extends Controller
{
    public function create(Request $request)
    {
        $flights = Flight::with(['airline', 'departureAirport', 'arrivalAirport'])
            ->where('departure_time', '>', now())
            ->orderBy('departure_time')
            ->get();

        $selectedFlight = null;
        $occupiedSeats = [];
        
        if ($request->flight_id) {
            $selectedFlight = Flight::with('airplane')->find($request->flight_id);
            if ($selectedFlight) {
                $occupiedSeats = Passenger::whereHas('booking', function ($q) use ($selectedFlight) {
                    $q->where('flight_id', $selectedFlight->id)->whereIn('status', ['pending', 'pending_verification', 'confirmed']);
                })->pluck('seat_number')->filter()->toArray();
            }
        }

        return view('admin.offline-bookings.create', compact('flights', 'selectedFlight', 'occupiedSeats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'passengers' => 'required|array|min:1',
            'passengers.*.passenger_type' => 'required|in:adult,child,infant',
            'passengers.*.full_name' => 'required|string|max:255',
            'passengers.*.gender' => 'required|in:male,female',
            'passengers.*.birth_date' => 'required|date',
            'passengers.*.passport_number' => 'nullable|string',
            'passengers.*.seat_number' => 'nullable|string',
            'passengers.*.seat_class' => 'nullable|in:economy,business,first_class',
        ]);

        $flight = Flight::findOrFail($request->flight_id);
        
        $adults = 0; $children = 0; $infants = 0;
        $occupiedSeats = Passenger::whereHas('booking', function ($q) use ($flight) {
            $q->where('flight_id', $flight->id)->whereIn('status', ['pending', 'pending_verification', 'confirmed']);
        })->pluck('seat_number')->filter()->toArray();

        foreach ($request->passengers as $p) {
            if ($p['passenger_type'] === 'adult') $adults++;
            elseif ($p['passenger_type'] === 'child') $children++;
            elseif ($p['passenger_type'] === 'infant') $infants++;
            
            if ($p['passenger_type'] !== 'infant') {
                if (empty($p['seat_number']) || empty($p['seat_class'])) {
                    return back()->withInput()->with('error', 'Dewasa dan Anak wajib memilih kursi.');
                }
                if (in_array($p['seat_number'], $occupiedSeats)) {
                    return back()->withInput()->with('error', 'Kursi ' . $p['seat_number'] . ' sudah dipesan.');
                }
            }
        }
        
        if ($adults == 0) return back()->withInput()->with('error', 'Pesanan wajib menyertakan minimal 1 orang dewasa.');
        if ($infants > $adults) return back()->withInput()->with('error', 'Satu orang dewasa maksimal membawa satu bayi.');

        $totalSeatsNeeded = $adults + $children;
        if ($flight->available_seats < $totalSeatsNeeded) {
            return back()->with('error', 'Ketersediaan kursi tidak mencukupi.');
        }

        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'user_id' => auth()->id(), // Admin as the user, or maybe null if guest? But user_id is required. We'll use auth()->id().
                'flight_id' => $flight->id,
                'booking_code' => 'OFF-' . strtoupper(Str::random(8)),
                'total_passengers' => $adults + $children + $infants,
                'total_price' => 0, 
                'status' => 'confirmed', // Auto confirmed for offline
            ]);

            $totalPrice = 0;
            foreach ($request->passengers as $p) {
                $basePrice = $flight->price;
                $seatClass = $p['seat_class'] ?? null;
                $multiplierClass = 1.0;
                
                if ($seatClass === 'business') $multiplierClass = 1.25;
                elseif ($seatClass === 'first_class') $multiplierClass = 1.75;
                
                $price = 0;
                if ($p['passenger_type'] === 'adult') $price = $basePrice * $multiplierClass;
                elseif ($p['passenger_type'] === 'child') $price = $basePrice * $multiplierClass * 0.75;
                elseif ($p['passenger_type'] === 'infant') $price = $basePrice * 0.10;
                
                Passenger::create([
                    'booking_id' => $booking->id,
                    'full_name' => $p['full_name'],
                    'gender' => $p['gender'],
                    'passenger_type' => $p['passenger_type'],
                    'birth_date' => $p['birth_date'],
                    'passport_number' => $p['passport_number'] ?? null,
                    'seat_number' => $p['seat_number'] ?? null,
                    'seat_class' => $seatClass,
                    'price' => $price,
                ]);
                $totalPrice += $price;
            }

            $booking->update(['total_price' => $totalPrice]);
            $flight->decrement('available_seats', $totalSeatsNeeded);

            // Auto create payment as 'cash' and 'paid'
            Payment::create([
                'booking_id' => $booking->id,
                'payment_method' => 'cash',
                'amount' => $totalPrice,
                'payment_status' => 'paid',
                'verified_at' => now(),
                'verified_by' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('admin.bookings.show', $booking->id)->with('success', 'Pesanan offline berhasil dibuat dan lunas.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem saat membuat pesanan offline.');
        }
    }
}
