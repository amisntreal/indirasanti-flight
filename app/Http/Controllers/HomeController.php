<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\Flight;
use App\Models\Airline;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $airports = Airport::orderBy('city')->get();
        $airlines = Airline::all();
        $featuredFlights = Flight::with(['airline', 'departureAirport', 'arrivalAirport'])
            ->where('departure_time', '>', now())
            ->where('available_seats', '>', 0)
            ->orderBy('price')
            ->take(6)
            ->get();

        return view('home', compact('airports', 'airlines', 'featuredFlights'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'from' => 'required',
            'to' => 'required',
            'date' => 'required|date',
            'adults' => 'required|integer|min:1|max:9',
            'children' => 'nullable|integer|min:0|max:9',
            'infants' => 'nullable|integer|min:0|max:9',
        ]);

        $adults = $request->adults ?? 1;
        $children = $request->children ?? 0;
        $infants = $request->infants ?? 0;
        $seats_needed = $adults + $children;

        if ($infants > $adults) {
            return back()->with('error', 'Jumlah bayi tidak boleh melebihi jumlah orang dewasa.');
        }

        $flights = Flight::with(['airline', 'airplane', 'departureAirport', 'arrivalAirport'])
            ->where('departure_airport_id', $request->from)
            ->where('arrival_airport_id', $request->to)
            ->whereDate('departure_time', $request->date)
            ->where('available_seats', '>=', $seats_needed)
            ->orderBy('departure_time')
            ->get();

        $airports = Airport::orderBy('city')->get();

        return view('flights.search', compact('flights', 'airports', 'adults', 'children', 'infants', 'request'));
    }
}
