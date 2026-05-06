@extends('layouts.app')
@section('title', 'Menunggu Verifikasi - Indirasanti Flight')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="bg-white rounded-2xl border border-amber-100 shadow-lg overflow-hidden">
        <div class="p-8 text-center" style="background: linear-gradient(135deg,#1A1410,#2C2318);">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4" style="background: rgba(200,169,126,0.2);">
                <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="font-display text-3xl font-semibold text-amber-300 mb-2">Bukti Terkirim</h1>
            <p class="text-amber-100/60 text-sm">Pembayaran Anda sedang dalam proses verifikasi oleh Admin.</p>
        </div>

        <div class="p-6">
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm text-center">
                {{ session('success') }}
            </div>
            @endif

            {{-- Booking Code --}}
            <div class="bg-amber-50 rounded-xl p-5 mb-6 text-center">
                <p class="text-xs text-amber-600 uppercase tracking-wide mb-1">Kode Pemesanan</p>
                <p class="font-display text-3xl font-bold text-amber-900">{{ $booking->booking_code }}</p>
            </div>

            {{-- Uploaded Proof --}}
            @if($booking->payment && $booking->payment->proof_of_payment)
            <div class="border border-amber-200 rounded-xl p-5 mb-6 text-center">
                <p class="text-xs text-amber-600 uppercase tracking-wide mb-3">Bukti Transfer Anda</p>
                <div class="inline-block p-2 bg-slate-50 border border-slate-200 rounded-lg">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($booking->payment->proof_of_payment) }}" alt="Bukti Transfer" class="max-h-64 object-contain rounded">
                </div>
                <p class="text-xs text-amber-500 mt-3">Bank Tujuan: <span class="font-semibold uppercase">{{ $booking->payment->payment_method }}</span></p>
            </div>
            @endif

            {{-- Status Box --}}
            <div class="rounded-xl p-4 mb-6 border border-amber-200 bg-amber-50 text-center">
                <div class="flex flex-col items-center justify-center gap-2 text-amber-700">
                    <span class="text-sm font-semibold">Status: Menunggu Verifikasi Admin</span>
                    <p class="text-xs text-amber-600">Proses verifikasi maksimal 1x24 jam. Silakan cek halaman detail pemesanan secara berkala.</p>
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('bookings.show', $booking->id) }}" class="inline-block px-6 py-2.5 bg-white border border-amber-300 text-amber-700 text-sm font-medium rounded-lg hover:bg-amber-50 transition-all">Lihat Detail Pemesanan</a>
            </div>
        </div>
    </div>
</div>
@endsection
