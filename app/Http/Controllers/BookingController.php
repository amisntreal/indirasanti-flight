<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Flight;
use App\Models\Passenger;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'adults' => 'required|integer|min:1|max:9',
            'children' => 'nullable|integer|min:0|max:9',
            'infants' => 'nullable|integer|min:0|max:9',
        ]);

        $adults = $request->adults ?? 1;
        $children = $request->children ?? 0;
        $infants = $request->infants ?? 0;
        $totalSeats = $adults + $children;

        $flight = Flight::with(['airline', 'departureAirport', 'arrivalAirport', 'airplane'])->findOrFail($request->flight_id);

        if ($flight->available_seats < $totalSeats) {
            return back()->with('error', 'Kursi tidak cukup tersedia.');
        }
        
        if ($infants > $adults) {
            return back()->with('error', 'Jumlah bayi tidak boleh melebihi jumlah orang dewasa.');
        }

        $occupiedSeats = Passenger::whereHas('booking', function ($q) use ($flight) {
            $q->where('flight_id', $flight->id)->whereIn('status', ['pending', 'confirmed']);
        })->pluck('seat_number')->filter()->toArray();

        return view('bookings.create', compact('flight', 'adults', 'children', 'infants', 'occupiedSeats'));
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
            $q->where('flight_id', $flight->id)->whereIn('status', ['pending', 'confirmed']);
        })->pluck('seat_number')->filter()->toArray();

        foreach ($request->passengers as $p) {
            if ($p['passenger_type'] === 'adult') $adults++;
            elseif ($p['passenger_type'] === 'child') $children++;
            elseif ($p['passenger_type'] === 'infant') $infants++;
            
            $age = \Carbon\Carbon::parse($p['birth_date'])->age;
            if ($p['passenger_type'] === 'infant' && $age >= 2) {
                return back()->withInput()->with('error', 'Usia bayi harus di bawah 2 tahun.');
            }
            if ($p['passenger_type'] === 'child' && ($age < 2 || $age > 11)) {
                return back()->withInput()->with('error', 'Usia anak harus antara 2 hingga 11 tahun.');
            }
            
            if ($p['passenger_type'] !== 'infant') {
                if (empty($p['seat_number']) || empty($p['seat_class'])) {
                    return back()->withInput()->with('error', 'Dewasa dan Anak wajib memilih kursi.');
                }
                if (in_array($p['seat_number'], $occupiedSeats)) {
                    return back()->withInput()->with('error', 'Kursi ' . $p['seat_number'] . ' sudah dipesan.');
                }
            } else {
                if (!empty($p['seat_number'])) {
                    return back()->withInput()->with('error', 'Bayi tidak memiliki kursi sendiri.');
                }
            }
        }
        
        if ($adults == 0 && ($children > 0 || $infants > 0)) {
            return back()->withInput()->with('error', 'Pesanan wajib menyertakan minimal 1 orang dewasa.');
        }
        if ($infants > $adults) {
            return back()->withInput()->with('error', 'Satu orang dewasa maksimal membawa satu bayi.');
        }

        $totalSeatsNeeded = $adults + $children;
        if ($flight->available_seats < $totalSeatsNeeded) {
            return back()->with('error', 'Ketersediaan kursi tidak mencukupi.');
        }

        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'flight_id' => $flight->id,
                'booking_code' => 'IF-' . strtoupper(Str::random(8)),
                'total_passengers' => $adults + $children + $infants,
                'total_price' => 0, 
                'status' => 'pending',
            ]);

            $totalPrice = 0;
            foreach ($request->passengers as $p) {
                $basePrice = $flight->price;
                $seatClass = $p['seat_class'] ?? null;
                $multiplierClass = 1.0;
                
                if ($seatClass === 'business') $multiplierClass = 1.25;
                elseif ($seatClass === 'first_class') $multiplierClass = 1.75;
                
                $price = 0;
                if ($p['passenger_type'] === 'adult') {
                    $price = $basePrice * $multiplierClass;
                } elseif ($p['passenger_type'] === 'child') {
                    $price = $basePrice * $multiplierClass * 0.75;
                } elseif ($p['passenger_type'] === 'infant') {
                    $price = $basePrice * 0.10;
                }
                
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

            DB::commit();
            return redirect()->route('bookings.payment', $booking->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan.');
        }
    }

    public function payment(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) abort(403);
        if ($booking->status !== 'pending') {
            return redirect()->route('bookings.show', $booking->id);
        }

        $booking->load(['flight.airline', 'flight.departureAirport', 'flight.arrivalAirport', 'passengers']);
        return view('bookings.payment', compact('booking'));
    }

    public function processPayment(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) abort(403);

        $request->validate([
            'payment_method' => 'required|in:bca,bni,bri,mandiri',
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
        ]);

        if ($request->hasFile('proof_of_payment')) {
            $file = $request->file('proof_of_payment');
            $filename = time() . '_' . $booking->booking_code . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payments', $filename, 'public');

            Payment::updateOrCreate(
                ['booking_id' => $booking->id],
                [
                    'payment_method' => $request->payment_method,
                    'amount' => $booking->total_price,
                    'payment_status' => 'pending_verification',
                    'proof_of_payment' => $path,
                ]
            );

            $booking->update(['status' => 'pending_verification']);

            return redirect()->route('bookings.waitingPayment', $booking->id)
                ->with('success', 'Bukti pembayaran berhasil diunggah. Silakan tunggu verifikasi admin.');
        }

        return back()->with('error', 'Gagal mengunggah bukti pembayaran.');
    }

    public function waitingPayment(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) abort(403);
        
        if (!in_array($booking->status, ['pending', 'pending_verification'])) {
            return redirect()->route('bookings.show', $booking->id);
        }

        $booking->load(['flight.airline', 'flight.departureAirport', 'flight.arrivalAirport', 'payment']);
        return view('bookings.waiting-payment', compact('booking'));
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id() && !auth()->user()->isStaff()) abort(403);
        $booking->load(['flight.airline', 'flight.departureAirport', 'flight.arrivalAirport', 'passengers', 'payment', 'user']);
        return view('bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) abort(403);
        
        if ($booking->status === 'pending') {
            DB::beginTransaction();
            try {
                $booking->update(['status' => 'cancelled']);
                if ($booking->payment) {
                    $booking->payment->update(['payment_status' => 'failed']);
                }
                
                $booking->flight->increment('available_seats', $booking->total_passengers);
                
                DB::commit();
                return back()->with('success', 'Pesanan berhasil dibatalkan.');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Terjadi kesalahan saat membatalkan pesanan.');
            }
        }
        
        return back()->with('error', 'Pesanan ini tidak dapat dibatalkan.');
    }

    public function index()
    {
        $bookings = Booking::with(['flight.airline', 'flight.departureAirport', 'flight.arrivalAirport', 'payment'])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('customer.bookings', compact('bookings'));
    }

    private function generateSeatNumber(int $index): string
    {
        $row = intdiv($index, 6) + 1;
        $col = chr(65 + ($index % 6));
        return $row . $col;
    }
}
