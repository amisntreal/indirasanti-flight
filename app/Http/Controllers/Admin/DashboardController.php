<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Flight;
use App\Models\User;
use App\Models\Airline;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'total_revenue' => Payment::where('payment_status', 'paid')->sum('amount'),
            'total_flights' => Flight::count(),
            'total_users' => User::where('role', 'customer')->count(),
            'total_airlines' => Airline::count(),
        ];

        $recentBookings = Booking::with(['user', 'flight.airline', 'flight.departureAirport', 'flight.arrivalAirport', 'payment'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $upcomingFlights = Flight::with(['airline', 'departureAirport', 'arrivalAirport'])
            ->where('departure_time', '>', now())
            ->orderBy('departure_time')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'upcomingFlights'));
    }
}
