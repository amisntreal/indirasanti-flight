<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'flight.airline', 'flight.departureAirport', 'flight.arrivalAirport', 'payment']);

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $query->where('booking_code', 'like', '%' . $request->search . '%');
        }

        $bookings = $query->orderByDesc('created_at')->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'flight.airline', 'flight.departureAirport', 'flight.arrivalAirport', 'passengers', 'payment']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate(['status' => 'required|in:pending,pending_verification,confirmed,cancelled']);
        $booking->update(['status' => $request->status]);
        return back()->with('success', 'Status booking diperbarui.');
    }

    public function verifyPayment(Booking $booking)
    {
        if ($booking->status !== 'pending_verification') {
            return back()->with('error', 'Booking tidak dalam status menunggu verifikasi.');
        }

        $booking->update(['status' => 'confirmed']);
        
        if ($booking->payment) {
            $booking->payment->update([
                'payment_status' => 'paid',
                'verified_at' => now(),
                'verified_by' => auth()->id(),
            ]);
        }

        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function rejectPayment(Booking $booking)
    {
        if ($booking->status !== 'pending_verification') {
            return back()->with('error', 'Booking tidak dalam status menunggu verifikasi.');
        }

        $booking->update(['status' => 'cancelled']);
        
        if ($booking->payment) {
            $booking->payment->update([
                'payment_status' => 'failed',
                'verified_at' => now(),
                'verified_by' => auth()->id(),
            ]);
        }

        // Return seats
        $booking->flight->increment('available_seats', $booking->total_passengers);

        return back()->with('success', 'Pembayaran ditolak dan booking dibatalkan.');
    }
}
