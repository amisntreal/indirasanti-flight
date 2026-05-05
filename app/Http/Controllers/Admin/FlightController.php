<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Models\Airline;
use App\Models\Airplane;
use App\Models\Airport;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $query = Flight::with(['airline', 'departureAirport', 'arrivalAirport']);

        if ($request->search) {
            $query->where('flight_number', 'like', '%' . $request->search . '%');
        }

        $flights = $query->orderByDesc('departure_time')->paginate(15);
        return view('admin.flights.index', compact('flights'));
    }

    public function create()
    {
        $airlines = Airline::all();
        $airports = Airport::orderBy('city')->get();
        return view('admin.flights.create', compact('airlines', 'airports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'airplane_id' => 'required|exists:airplanes,id',
            'departure_airport_id' => 'required|exists:airports,id',
            'arrival_airport_id' => 'required|exists:airports,id|different:departure_airport_id',
            'flight_number' => 'required|string',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:1',
        ]);

        Flight::create($request->all());
        return redirect()->route('admin.flights.index')->with('success', 'Penerbangan berhasil ditambahkan.');
    }

    public function edit(Flight $flight)
    {
        $airlines = Airline::all();
        $airports = Airport::orderBy('city')->get();
        $airplanes = Airplane::where('airline_id', $flight->airline_id)->get();
        return view('admin.flights.edit', compact('flight', 'airlines', 'airports', 'airplanes'));
    }

    public function update(Request $request, Flight $flight)
    {
        $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'airplane_id' => 'required|exists:airplanes,id',
            'departure_airport_id' => 'required|exists:airports,id',
            'arrival_airport_id' => 'required|exists:airports,id',
            'flight_number' => 'required|string',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:0',
        ]);

        $flight->update($request->all());
        return redirect()->route('admin.flights.index')->with('success', 'Penerbangan berhasil diperbarui.');
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();
        return redirect()->route('admin.flights.index')->with('success', 'Penerbangan berhasil dihapus.');
    }

    public function getAirplanes(Airline $airline)
    {
        return response()->json($airline->airplanes);
    }
}
