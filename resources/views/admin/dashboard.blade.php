@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
{{-- Stats Grid --}}
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    @php
    $statCards = [
        ['label' => 'Total Pemesanan', 'value' => $stats['total_bookings'], 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'color' => 'text-amber-600', 'bg' => 'bg-amber-50'],
        ['label' => 'Dikonfirmasi', 'value' => $stats['confirmed_bookings'], 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'text-green-600', 'bg' => 'bg-green-50'],
        ['label' => 'Pendapatan', 'value' => 'Rp '.number_format($stats['total_revenue'],0,',','.'), 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'text-amber-700', 'bg' => 'bg-amber-50'],
        ['label' => 'Penerbangan', 'value' => $stats['total_flights'], 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => 'text-blue-600', 'bg' => 'bg-blue-50'],
        ['label' => 'Pengguna', 'value' => $stats['total_users'], 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'color' => 'text-purple-600', 'bg' => 'bg-purple-50'],
        ['label' => 'Maskapai', 'value' => $stats['total_airlines'], 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'color' => 'text-rose-600', 'bg' => 'bg-rose-50'],
    ];
    @endphp
    @foreach($statCards as $card)
    <div class="bg-white rounded-xl border border-amber-100 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs text-amber-500 uppercase tracking-wide mb-1">{{ $card['label'] }}</p>
                <p class="font-display text-2xl font-semibold text-amber-900">{{ $card['value'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $card['bg'] }}">
                <svg class="w-5 h-5 {{ $card['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $card['icon'] }}"/>
                </svg>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    {{-- Recent Bookings --}}
    <div class="xl:col-span-2 bg-white rounded-xl border border-amber-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-amber-100 flex items-center justify-between">
            <h2 class="font-display text-lg font-semibold text-amber-900">Pemesanan Terbaru</h2>
            <a href="{{ route('admin.bookings.index') }}" class="text-xs text-amber-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-amber-50">
                        <th class="text-left px-6 py-3 text-xs text-amber-500 font-medium uppercase tracking-wide">Kode</th>
                        <th class="text-left px-6 py-3 text-xs text-amber-500 font-medium uppercase tracking-wide">Penumpang</th>
                        <th class="text-left px-6 py-3 text-xs text-amber-500 font-medium uppercase tracking-wide">Rute</th>
                        <th class="text-left px-6 py-3 text-xs text-amber-500 font-medium uppercase tracking-wide">Total</th>
                        <th class="text-left px-6 py-3 text-xs text-amber-500 font-medium uppercase tracking-wide">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-50">
                    @foreach($recentBookings as $booking)
                    <tr class="hover:bg-amber-50/40 transition-colors">
                        <td class="px-6 py-3">
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="font-medium text-amber-800 hover:underline text-xs">{{ $booking->booking_code }}</a>
                        </td>
                        <td class="px-6 py-3 text-amber-700">{{ $booking->user->name }}</td>
                        <td class="px-6 py-3 text-amber-600 text-xs">
                            {{ $booking->flight->departureAirport->iata_code }} → {{ $booking->flight->arrivalAirport->iata_code }}
                        </td>
                        <td class="px-6 py-3 font-medium text-amber-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-3">
                            @php 
                                $sc=['confirmed'=>'bg-green-100 text-green-700','pending'=>'bg-amber-100 text-amber-700','pending_verification'=>'bg-blue-100 text-blue-700','cancelled'=>'bg-red-100 text-red-700']; 
                                $sl=['confirmed'=>'Konfirmasi','pending'=>'Menunggu','pending_verification'=>'Verifikasi','cancelled'=>'Batal']; 
                            @endphp
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $sc[$booking->status] }}">{{ $sl[$booking->status] }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Upcoming Flights --}}
    <div class="bg-white rounded-xl border border-amber-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-amber-100 flex items-center justify-between">
            <h2 class="font-display text-lg font-semibold text-amber-900">Penerbangan Mendatang</h2>
            <a href="{{ route('admin.flights.index') }}" class="text-xs text-amber-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-amber-50">
            @foreach($upcomingFlights as $flight)
            <div class="px-5 py-4">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-semibold text-amber-800">{{ $flight->flight_number }}</span>
                    <span class="text-xs text-amber-500">{{ $flight->departure_time->format('d M') }}</span>
                </div>
                <p class="text-sm text-amber-700">{{ $flight->departureAirport->iata_code }} → {{ $flight->arrivalAirport->iata_code }}</p>
                <div class="flex items-center justify-between mt-1">
                    <span class="text-xs text-amber-500">{{ $flight->airline->name }}</span>
                    <span class="text-xs text-amber-500">{{ $flight->available_seats }} kursi</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
