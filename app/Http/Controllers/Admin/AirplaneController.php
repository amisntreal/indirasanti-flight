<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Airplane;
use App\Models\Airline;
use Illuminate\Http\Request;

class AirplaneController extends Controller
{
    public function index()
    {
        $airplanes = Airplane::with('airline')->paginate(15);
        return view('admin.airplanes.index', compact('airplanes'));
    }

    public function create()
    {
        $airlines = Airline::all();
        return view('admin.airplanes.create', compact('airlines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'model' => 'required|string|max:255',
            'registration_number' => 'required|string|unique:airplanes',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Airplane::create($request->all());
        return redirect()->route('admin.airplanes.index')->with('success', 'Pesawat berhasil ditambahkan.');
    }

    public function edit(Airplane $airplane)
    {
        $airlines = Airline::all();
        return view('admin.airplanes.edit', compact('airplane', 'airlines'));
    }

    public function update(Request $request, Airplane $airplane)
    {
        $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'model' => 'required|string|max:255',
            'registration_number' => 'required|string|unique:airplanes,registration_number,' . $airplane->id,
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $airplane->update($request->all());
        return redirect()->route('admin.airplanes.index')->with('success', 'Pesawat berhasil diperbarui.');
    }

    public function destroy(Airplane $airplane)
    {
        $airplane->delete();
        return redirect()->route('admin.airplanes.index')->with('success', 'Pesawat berhasil dihapus.');
    }
}
