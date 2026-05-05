@extends('layouts.app')
@section('title', 'Cari Penerbangan - Indirasanti Flight')

@section('content')
<div class="bg-amber-900 py-6">
    <div class="max-w-7xl mx-auto px-4">
        <form action="{{ route('flights.search') }}" method="GET">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3 items-end">
                <div>
                    <label class="block text-xs font-medium text-amber-300 mb-1 uppercase tracking-wide">Dari</label>
                    <select name="from" class="w-full px-3 py-2.5 border border-amber-700 rounded-lg text-sm focus:outline-none focus:border-amber-500 bg-amber-800/50 text-amber-100">
                        @foreach($airports as $airport)
                            <option value="{{ $airport->id }}" {{ $request->from == $airport->id ? 'selected' : '' }}>{{ $airport->city }} ({{ $airport->iata_code }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-amber-300 mb-1 uppercase tracking-wide">Ke</label>
                    <select name="to" class="w-full px-3 py-2.5 border border-amber-700 rounded-lg text-sm focus:outline-none focus:border-amber-500 bg-amber-800/50 text-amber-100">
                        @foreach($airports as $airport)
                            <option value="{{ $airport->id }}" {{ $request->to == $airport->id ? 'selected' : '' }}>{{ $airport->city }} ({{ $airport->iata_code }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-amber-300 mb-1 uppercase tracking-wide">Tanggal</label>
                    <input type="date" name="date" value="{{ $request->date }}" class="w-full px-3 py-2.5 border border-amber-700 rounded-lg text-sm focus:outline-none bg-amber-800/50 text-amber-100">
                </div>
                <div class="flex gap-1">
                    <div class="w-1/3">
                        <label class="block text-[10px] font-medium text-amber-300 mb-1 uppercase tracking-wide">Dws</label>
                        <input type="number" name="adults" min="1" max="9" value="{{ $adults }}" class="w-full px-2 py-2.5 border border-amber-700 rounded-lg text-sm focus:outline-none bg-amber-800/50 text-amber-100">
                    </div>
                    <div class="w-1/3">
                        <label class="block text-[10px] font-medium text-amber-300 mb-1 uppercase tracking-wide">Ank</label>
                        <input type="number" name="children" min="0" max="9" value="{{ $children }}" class="w-full px-2 py-2.5 border border-amber-700 rounded-lg text-sm focus:outline-none bg-amber-800/50 text-amber-100">
                    </div>
                    <div class="w-1/3">
                        <label class="block text-[10px] font-medium text-amber-300 mb-1 uppercase tracking-wide">Byi</label>
                        <input type="number" name="infants" min="0" max="9" value="{{ $infants }}" class="w-full px-2 py-2.5 border border-amber-700 rounded-lg text-sm focus:outline-none bg-amber-800/50 text-amber-100">
                    </div>
                </div>
                <button type="submit" class="px-6 py-2.5 text-white text-sm font-medium rounded-lg hover:opacity-90 transition-all" style="background: linear-gradient(135deg, #C8A97E, #A8855A);">Cari</button>
            </div>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="font-display text-2xl font-semibold text-amber-900">
                @if($flights->count() > 0)
                    {{ $flights->count() }} Penerbangan Ditemukan
                @else
                    Tidak Ada Penerbangan
                @endif
            </h2>
            <p class="text-amber-600 text-sm">Tanggal: {{ \Carbon\Carbon::parse($request->date)->format('d F Y') }} • {{ $adults }} Dewasa, {{ $children }} Anak, {{ $infants }} Bayi</p>
        </div>
    </div>

    @if($flights->count() > 0)
    <div class="space-y-4">
        @foreach($flights as $flight)
        <div class="bg-white rounded-xl border border-amber-100 hover:border-amber-300 hover:shadow-md transition-all overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    {{-- Airline --}}
                    <div class="flex items-center gap-3 w-36 flex-shrink-0">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0" style="background: linear-gradient(135deg, #C8A97E, #A8855A);">
                            {{ $flight->airline->code }}
                        </div>
                        <div>
                            <p class="text-xs font-medium text-amber-900">{{ $flight->airline->name }}</p>
                            <p class="text-xs text-amber-500">{{ $flight->flight_number }}</p>
                        </div>
                    </div>

                    {{-- Route --}}
                    <div class="flex items-center flex-1 gap-4">
                        <div class="text-center">
                            <p class="font-display text-2xl font-semibold text-amber-900">{{ $flight->departure_time->format('H:i') }}</p>
                            <p class="text-xs font-medium text-amber-700">{{ $flight->departureAirport->iata_code }}</p>
                            <p class="text-xs text-amber-500">{{ $flight->departureAirport->city }}</p>
                        </div>
                        <div class="flex flex-col items-center flex-1">
                            <p class="text-xs text-amber-400 mb-1">{{ $flight->duration }}</p>
                            <div class="flex items-center w-full gap-1">
                                <div class="w-2 h-2 rounded-full border border-amber-400 flex-shrink-0"></div>
                                <div class="h-px flex-1 border-t border-dashed border-amber-300"></div>
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </div>
                            <p class="text-xs text-amber-400 mt-1">Langsung</p>
                        </div>
                        <div class="text-center">
                            <p class="font-display text-2xl font-semibold text-amber-900">{{ $flight->arrival_time->format('H:i') }}</p>
                            <p class="text-xs font-medium text-amber-700">{{ $flight->arrivalAirport->iata_code }}</p>
                            <p class="text-xs text-amber-500">{{ $flight->arrivalAirport->city }}</p>
                        </div>
                    </div>

                    {{-- Seats info --}}
                    <div class="text-center hidden md:block">
                        <p class="text-xs text-amber-500 mb-1">Kursi Tersisa</p>
                        <p class="font-semibold text-amber-800 text-lg">{{ $flight->available_seats }}</p>
                        <p class="text-xs text-amber-400">{{ $flight->airplane->model }}</p>
                    </div>

                    {{-- Price & Book --}}
                    <div class="flex flex-row md:flex-col items-center md:items-end justify-between md:justify-start gap-3 w-full md:w-auto">
                        <div class="text-right">
                            <p class="font-display text-2xl font-bold text-amber-800">Rp {{ number_format($flight->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-amber-500">per dewasa (economy)</p>
                            @php
                                $est_total = ($flight->price * $adults) + ($flight->price * 0.75 * $children) + ($flight->price * 0.1 * $infants);
                            @endphp
                            @if($adults + $children + $infants > 1)
                            <p class="text-xs text-amber-600 font-medium mt-1">Est. Total: Rp {{ number_format($est_total, 0, ',', '.') }}</p>
                            @endif
                        </div>
                        <a href="{{ route('bookings.create') }}?flight_id={{ $flight->id }}&adults={{ $adults }}&children={{ $children }}&infants={{ $infants }}"
                           class="px-6 py-2.5 text-white text-sm font-medium rounded-lg hover:opacity-90 transition-all whitespace-nowrap"
                           style="background: linear-gradient(135deg, #C8A97E, #A8855A);">
                            Pilih
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-20">
        <svg class="w-16 h-16 text-amber-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
        <h3 class="font-display text-2xl text-amber-700 mb-2">Tidak Ada Penerbangan</h3>
        <p class="text-amber-500 text-sm">Tidak ditemukan penerbangan untuk rute dan tanggal yang dipilih.</p>
        <p class="text-amber-400 text-sm mt-1">Coba pilih tanggal lain atau rute berbeda.</p>
    </div>
    @endif
</div>
@endsection
