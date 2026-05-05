@extends('layouts.app')
@section('title', 'Dashboard - Indirasanti Flight')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="mb-8">
        <p class="text-amber-600 text-xs uppercase tracking-widest mb-1">Selamat datang kembali</p>
        <h1 class="font-display text-3xl font-semibold text-amber-900">{{ auth()->user()->name }}</h1>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-amber-100 p-5 text-center">
            <p class="font-display text-3xl font-semibold text-amber-800">{{ $stats['total'] }}</p>
            <p class="text-xs text-amber-500 mt-1">Total Pemesanan</p>
        </div>
        <div class="bg-white rounded-xl border border-amber-100 p-5 text-center">
            <p class="font-display text-3xl font-semibold text-green-700">{{ $stats['confirmed'] }}</p>
            <p class="text-xs text-amber-500 mt-1">Dikonfirmasi</p>
        </div>
        <div class="bg-white rounded-xl border border-amber-100 p-5 text-center">
            <p class="font-display text-3xl font-semibold text-amber-600">{{ $stats['pending'] }}</p>
            <p class="text-xs text-amber-500 mt-1">Menunggu</p>
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="flex gap-3 mb-8">
        <a href="{{ route('home') }}" class="px-5 py-2.5 text-white text-sm font-medium rounded-lg hover:opacity-90 transition-all flex items-center gap-2" style="background: linear-gradient(135deg,#C8A97E,#A8855A);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Cari Penerbangan
        </a>
        <a href="{{ route('bookings.index') }}" class="px-5 py-2.5 border border-amber-300 text-amber-700 text-sm font-medium rounded-lg hover:bg-amber-50 transition-all">
            Semua Pemesanan
        </a>
        <a href="{{ route('customer.profile') }}" class="px-5 py-2.5 border border-amber-300 text-amber-700 text-sm font-medium rounded-lg hover:bg-amber-50 transition-all">
            Profil Saya
        </a>
    </div>

    {{-- Recent bookings --}}
    <div class="bg-white rounded-xl border border-amber-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-amber-100">
            <h2 class="font-display text-xl font-semibold text-amber-900">Pemesanan Terbaru</h2>
        </div>
        @if($bookings->count() > 0)
        <div class="divide-y divide-amber-50">
            @foreach($bookings as $booking)
            <div class="px-6 py-4 flex items-center justify-between hover:bg-amber-50/50 transition-colors">
                <div class="flex items-center gap-4">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0" style="background: linear-gradient(135deg,#C8A97E,#A8855A);">
                        {{ $booking->flight->airline->code }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-amber-900">{{ $booking->booking_code }}</p>
                        <p class="text-xs text-amber-600">{{ $booking->flight->departureAirport->city }} → {{ $booking->flight->arrivalAirport->city }}</p>
                        <p class="text-xs text-amber-400">{{ $booking->flight->departure_time->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-amber-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        <p class="text-xs text-amber-500">{{ $booking->total_passengers }} penumpang</p>
                    </div>
                    @php
                    $sc = ['confirmed' => 'bg-green-100 text-green-700', 'pending' => 'bg-amber-100 text-amber-700', 'pending_verification' => 'bg-blue-100 text-blue-700', 'cancelled' => 'bg-red-100 text-red-700'];
                    $sl = ['confirmed' => 'Dikonfirmasi', 'pending' => 'Menunggu', 'pending_verification' => 'Verifikasi', 'cancelled' => 'Dibatalkan'];
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $sc[$booking->status] }}">{{ $sl[$booking->status] }}</span>
                    <a href="{{ route('bookings.show', $booking->id) }}" class="text-amber-600 hover:text-amber-800 text-xs underline">Detail</a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 text-amber-400">
            <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p class="text-sm">Belum ada pemesanan. <a href="{{ route('home') }}" class="underline text-amber-600">Pesan sekarang</a></p>
        </div>
        @endif
    </div>
</div>
@endsection
