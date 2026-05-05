@extends('layouts.app')
@section('title', 'Detail Pemesanan - Indirasanti Flight')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-amber-600 text-xs uppercase tracking-widest mb-1">Detail Pemesanan</p>
            <h1 class="font-display text-3xl font-semibold text-amber-900">{{ $booking->booking_code }}</h1>
        </div>
        @php
        $statusClasses = [
            'confirmed' => 'bg-green-100 text-green-800 border-green-200',
            'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
            'pending_verification' => 'bg-blue-100 text-blue-800 border-blue-200',
            'cancelled' => 'bg-red-100 text-red-800 border-red-200',
        ];
        $statusLabels = [
            'confirmed' => 'Dikonfirmasi', 
            'pending' => 'Menunggu', 
            'pending_verification' => 'Menunggu Verifikasi',
            'cancelled' => 'Dibatalkan'
        ];
        @endphp
        <span class="px-4 py-1.5 rounded-full text-sm font-medium border {{ $statusClasses[$booking->status] }}">
            {{ $statusLabels[$booking->status] }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-5">
            {{-- Flight Detail --}}
            <div class="bg-white rounded-xl border border-amber-100 p-6">
                <p class="text-xs font-medium text-amber-600 uppercase tracking-wide mb-4">Detail Penerbangan</p>
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0" style="background: linear-gradient(135deg,#C8A97E,#A8855A);">
                        {{ $booking->flight->airline->code }}
                    </div>
                    <div>
                        <p class="font-medium text-amber-900">{{ $booking->flight->airline->name }}</p>
                        <p class="text-xs text-amber-500">{{ $booking->flight->flight_number }} • {{ $booking->flight->airplane->model ?? '' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div>
                        <p class="font-display text-3xl font-semibold text-amber-900">{{ $booking->flight->departure_time->format('H:i') }}</p>
                        <p class="text-sm font-medium text-amber-800">{{ $booking->flight->departureAirport->iata_code }}</p>
                        <p class="text-xs text-amber-500">{{ $booking->flight->departureAirport->city }}</p>
                        <p class="text-xs text-amber-400">{{ $booking->flight->departure_time->format('d M Y') }}</p>
                    </div>
                    <div class="flex flex-col items-center flex-1">
                        <p class="text-xs text-amber-400">{{ $booking->flight->duration }}</p>
                        <div class="flex items-center w-full gap-1 my-1">
                            <div class="h-px flex-1 border-t border-dashed border-amber-300"></div>
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </div>
                        <p class="text-xs text-amber-400">Langsung</p>
                    </div>
                    <div class="text-right">
                        <p class="font-display text-3xl font-semibold text-amber-900">{{ $booking->flight->arrival_time->format('H:i') }}</p>
                        <p class="text-sm font-medium text-amber-800">{{ $booking->flight->arrivalAirport->iata_code }}</p>
                        <p class="text-xs text-amber-500">{{ $booking->flight->arrivalAirport->city }}</p>
                        <p class="text-xs text-amber-400">{{ $booking->flight->arrival_time->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Passengers --}}
            <div class="bg-white rounded-xl border border-amber-100 p-6">
                <p class="text-xs font-medium text-amber-600 uppercase tracking-wide mb-4">Data Penumpang</p>
                <div class="space-y-3">
                    @foreach($booking->passengers as $i => $passenger)
                    <div class="flex items-center justify-between py-3 border-b border-amber-50 last:border-0">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold text-white" style="background: linear-gradient(135deg,#C8A97E,#A8855A);">
                                {{ $i + 1 }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-amber-900">{{ $passenger->full_name }} <span class="text-[10px] uppercase bg-amber-100 text-amber-800 px-1.5 py-0.5 rounded">{{ $passenger->passenger_type }}</span></p>
                                <p class="text-xs text-amber-500">{{ $passenger->gender === 'male' ? 'Laki-laki' : 'Perempuan' }} • {{ $passenger->birth_date->format('d M Y') }}</p>
                                @if($passenger->passport_number)
                                <p class="text-xs text-amber-400">Paspor: {{ $passenger->passport_number }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            @if($passenger->seat_number)
                            <p class="text-xs text-amber-500">Kursi <span class="uppercase font-semibold">({{ $passenger->seat_class }})</span></p>
                            <p class="font-semibold text-amber-800">{{ $passenger->seat_number }}</p>
                            @else
                            <p class="text-xs text-amber-500 italic mt-2">Tanpa kursi</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Summary sidebar --}}
        <div class="space-y-5">
            <div class="bg-white rounded-xl border border-amber-100 p-5">
                <p class="text-xs font-medium text-amber-600 uppercase tracking-wide mb-4">Ringkasan Biaya</p>
                <div class="space-y-2 text-sm mb-4">
                    @foreach($booking->passengers as $passenger)
                    <div class="flex justify-between text-amber-700">
                        <span>{{ $passenger->full_name }} <span class="text-[10px] uppercase text-amber-500">({{ $passenger->passenger_type }}{{ $passenger->seat_class ? ' - '.$passenger->seat_class : '' }})</span></span>
                        <span>Rp {{ number_format($passenger->price, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="border-t border-amber-100 pt-3">
                    <div class="flex justify-between font-semibold">
                        <span class="text-amber-800">Total</span>
                        <span class="font-display text-xl text-amber-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            @if($booking->payment)
            <div class="bg-white rounded-xl border border-amber-100 p-5">
                <p class="text-xs font-medium text-amber-600 uppercase tracking-wide mb-4">Info Pembayaran</p>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-amber-700">Metode</span>
                        <span class="font-medium text-amber-900 uppercase">{{ $booking->payment->payment_method }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-amber-700">Status</span>
                        @php
                        $psc = ['paid' => 'text-green-700', 'pending' => 'text-amber-700', 'pending_verification' => 'text-blue-700', 'failed' => 'text-red-700'];
                        $psl = ['paid' => 'Lunas', 'pending' => 'Belum Dibayar', 'pending_verification' => 'Menunggu Verifikasi', 'failed' => 'Gagal'];
                        @endphp
                        <span class="font-medium {{ $psc[$booking->payment->payment_status] }}">{{ $psl[$booking->payment->payment_status] }}</span>
                    </div>
                    @if($booking->payment->transaction_code)
                    <div class="flex justify-between">
                        <span class="text-amber-700">Kode Transaksi</span>
                        <span class="text-xs font-mono text-amber-800 truncate ml-2">{{ Str::limit($booking->payment->transaction_code, 16) }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            @if($booking->status === 'pending')
            <div class="bg-white rounded-xl border border-amber-100 p-5 space-y-3">
                @if($booking->payment && $booking->payment->payment_status === 'pending')
                    <a href="{{ route('bookings.waitingPayment', $booking->id) }}" class="block w-full py-2.5 text-center text-white font-medium text-sm rounded-lg hover:opacity-90 transition-all" style="background: linear-gradient(135deg,#C8A97E,#A8855A);">
                        Lanjutkan Pembayaran
                    </a>
                @elseif(!$booking->payment)
                    <a href="{{ route('bookings.payment', $booking->id) }}" class="block w-full py-2.5 text-center text-white font-medium text-sm rounded-lg hover:opacity-90 transition-all" style="background: linear-gradient(135deg,#C8A97E,#A8855A);">
                        Pilih Pembayaran
                    </a>
                @endif
                
                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                    @csrf
                    <button type="submit" class="w-full py-2.5 text-center text-red-600 font-medium text-sm rounded-lg border border-red-200 hover:bg-red-50 transition-all">
                        Batalkan Pesanan
                    </button>
                </form>
            </div>
            @endif

            <div class="text-center">
                <a href="{{ route('bookings.index') }}" class="text-sm text-amber-600 hover:text-amber-800 underline">← Kembali ke Daftar Pemesanan</a>
            </div>
        </div>
    </div>
</div>
@endsection
