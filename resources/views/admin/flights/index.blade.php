@extends('layouts.admin')
@section('title','Penerbangan')
@section('page-title','Penerbangan')
@section('content')
<div class="flex items-center justify-between mb-6">
    <form action="{{ route('admin.flights.index') }}" method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor penerbangan..." class="px-4 py-2 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 w-56">
        <button type="submit" class="px-4 py-2 border border-amber-300 text-amber-700 text-sm rounded-lg hover:bg-amber-50">Cari</button>
    </form>
    <a href="{{ route('admin.flights.create') }}" class="px-4 py-2 text-white text-sm font-medium rounded-lg hover:opacity-90" style="background:linear-gradient(135deg,#C8A97E,#A8855A);">+ Tambah Penerbangan</a>
</div>
<div class="bg-white rounded-xl border border-amber-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-amber-100 bg-amber-50/60">
                <th class="text-left px-5 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">No. Penerbangan</th>
                <th class="text-left px-5 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Maskapai</th>
                <th class="text-left px-5 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Rute</th>
                <th class="text-left px-5 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Keberangkatan</th>
                <th class="text-left px-5 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Harga</th>
                <th class="text-left px-5 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Kursi</th>
                <th class="text-left px-5 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-amber-50">
                @foreach($flights as $flight)
                <tr class="hover:bg-amber-50/40 transition-colors">
                    <td class="px-5 py-3 font-medium text-amber-900">{{ $flight->flight_number }}</td>
                    <td class="px-5 py-3 text-amber-700">{{ $flight->airline->name }}</td>
                    <td class="px-5 py-3 text-amber-700">
                        <span class="font-semibold">{{ $flight->departureAirport->iata_code }}</span>
                        <span class="text-amber-400 mx-1">→</span>
                        <span class="font-semibold">{{ $flight->arrivalAirport->iata_code }}</span>
                    </td>
                    <td class="px-5 py-3 text-amber-600 text-xs">{{ $flight->departure_time->format('d M Y H:i') }}</td>
                    <td class="px-5 py-3 font-medium text-amber-800">Rp {{ number_format($flight->price, 0, ',', '.') }}</td>
                    <td class="px-5 py-3">
                        <span class="{{ $flight->available_seats > 10 ? 'text-green-600' : 'text-red-500' }} font-medium">{{ $flight->available_seats }}</span>
                    </td>
                    <td class="px-5 py-3 flex gap-3">
                        <a href="{{ route('admin.flights.edit', $flight) }}" class="text-xs text-amber-700 hover:underline">Edit</a>
                        <form action="{{ route('admin.flights.destroy', $flight) }}" method="POST" onsubmit="return confirm('Hapus penerbangan ini?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-amber-100">{{ $flights->links() }}</div>
</div>
@endsection
