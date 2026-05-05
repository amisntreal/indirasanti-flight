@extends('layouts.app')
@section('title', 'Pemesanan Saya - Indirasanti Flight')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="mb-8">
        <p class="text-amber-600 text-xs uppercase tracking-widest mb-1">Riwayat</p>
        <h1 class="font-display text-3xl font-semibold text-amber-900">Pemesanan Saya</h1>
    </div>

    <div class="bg-white rounded-xl border border-amber-100 overflow-hidden">
        @if($bookings->count() > 0)
        <div class="divide-y divide-amber-50">
            @foreach($bookings as $booking)
            <div class="p-5 hover:bg-amber-50/40 transition-colors">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0 mt-1" style="background: linear-gradient(135deg,#C8A97E,#A8855A);">
                            {{ $booking->flight->airline->code }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <p class="font-semibold text-amber-900">{{ $booking->booking_code }}</p>
                                @php
                                $sc = ['confirmed'=>'bg-green-100 text-green-700','pending'=>'bg-amber-100 text-amber-700','pending_verification'=>'bg-blue-100 text-blue-700','cancelled'=>'bg-red-100 text-red-700'];
                                $sl = ['confirmed'=>'Dikonfirmasi','pending'=>'Menunggu','pending_verification'=>'Menunggu Verifikasi','cancelled'=>'Dibatalkan'];
                                @endphp
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $sc[$booking->status] }}">{{ $sl[$booking->status] }}</span>
                            </div>
                            <p class="text-sm text-amber-700">{{ $booking->flight->departureAirport->city }} → {{ $booking->flight->arrivalAirport->city }}</p>
                            <p class="text-xs text-amber-500">{{ $booking->flight->airline->name }} • {{ $booking->flight->flight_number }}</p>
                            <p class="text-xs text-amber-400">{{ $booking->flight->departure_time->format('d M Y, H:i') }} • {{ $booking->total_passengers }} penumpang</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 sm:text-right">
                        <div>
                            <p class="font-display text-lg font-bold text-amber-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            @if($booking->payment)
                            @php $psc=['paid'=>'text-green-600','pending'=>'text-amber-600','pending_verification'=>'text-blue-600','failed'=>'text-red-600']; $psl=['paid'=>'Lunas','pending'=>'Belum Dibayar','pending_verification'=>'Menunggu Verifikasi','failed'=>'Gagal']; @endphp
                            <p class="text-xs {{ $psc[$booking->payment->payment_status] }}">{{ $psl[$booking->payment->payment_status] }}</p>
                            @endif
                        </div>
                        <a href="{{ route('bookings.show', $booking->id) }}" class="px-4 py-2 border border-amber-300 text-amber-700 text-xs font-medium rounded-lg hover:bg-amber-50 transition-all flex-shrink-0">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="px-5 py-4 border-t border-amber-100">
            {{ $bookings->links() }}
        </div>
        @else
        <div class="text-center py-16 text-amber-400">
            <svg class="w-14 h-14 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p class="font-display text-xl mb-2">Belum ada pemesanan</p>
            <a href="{{ route('home') }}" class="text-sm text-amber-600 underline">Cari penerbangan sekarang</a>
        </div>
        @endif
    </div>
</div>
@endsection
