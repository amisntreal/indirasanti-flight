@extends('layouts.app')
@section('title', 'Pembayaran - Indirasanti Flight')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <div class="mb-8">
        <p class="text-amber-600 text-xs uppercase tracking-widest mb-1">Langkah 2 dari 2</p>
        <h1 class="font-display text-3xl font-semibold text-amber-900">Pembayaran Manual</h1>
    </div>

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
        <p class="text-red-700 text-sm">{{ session('error') }}</p>
    </div>
    @endif

    {{-- Booking Summary --}}
    <div class="bg-amber-50 rounded-xl border border-amber-200 p-5 mb-6">
        <p class="text-xs font-medium text-amber-700 uppercase tracking-wide mb-3">Ringkasan Pemesanan</p>
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-amber-700">Kode Pemesanan</span>
            <span class="text-sm font-semibold text-amber-900">{{ $booking->booking_code }}</span>
        </div>
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-amber-700">Rute</span>
            <span class="text-sm font-medium text-amber-900">
                {{ $booking->flight->departureAirport->city }} → {{ $booking->flight->arrivalAirport->city }}
            </span>
        </div>
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-amber-700">Tanggal Penerbangan</span>
            <span class="text-sm text-amber-900">{{ $booking->flight->departure_time->format('d M Y, H:i') }}</span>
        </div>
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-amber-700">Jumlah Penumpang</span>
            <span class="text-sm text-amber-900">{{ $booking->total_passengers }} orang</span>
        </div>
        <div class="border-t border-amber-200 pt-3 mt-3 flex items-center justify-between">
            <span class="font-medium text-amber-800">Total Pembayaran</span>
            <span class="font-display text-2xl font-bold text-amber-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Payment Method & Upload --}}
    <div class="bg-white rounded-xl border border-amber-100 p-6 shadow-sm">
        <p class="text-sm font-medium text-amber-800 mb-4">Transfer Bank Manual</p>
        <form action="{{ route('bookings.payment.process', $booking->id) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                @php
                $banks = [
                    ['value' => 'bca', 'label' => 'BCA', 'acc' => '1234 5678 90', 'name' => 'PT Indirasanti Flight', 'color' => '#003087'],
                    ['value' => 'mandiri', 'label' => 'Mandiri', 'acc' => '0987 6543 21', 'name' => 'PT Indirasanti Flight', 'color' => '#003D7C'],
                    ['value' => 'bni', 'label' => 'BNI', 'acc' => '1122 3344 55', 'name' => 'PT Indirasanti Flight', 'color' => '#F47920'],
                    ['value' => 'bri', 'label' => 'BRI', 'acc' => '5544 3322 11', 'name' => 'PT Indirasanti Flight', 'color' => '#00529B'],
                ];
                @endphp
                @foreach($banks as $bank)
                <label class="flex items-start gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all hover:border-amber-300 has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                    <input type="radio" name="payment_method" value="{{ $bank['value'] }}" class="w-4 h-4 mt-1 text-amber-600" required>
                    <div>
                        <p class="text-sm font-bold" style="color: {{ $bank['color'] }}">{{ strtoupper($bank['label']) }}</p>
                        <p class="text-lg font-mono tracking-wider text-slate-800 my-1">{{ $bank['acc'] }}</p>
                        <p class="text-xs text-amber-600">a.n {{ $bank['name'] }}</p>
                    </div>
                </label>
                @endforeach
            </div>

            <div class="border-t border-amber-100 pt-6 mb-6">
                <p class="text-sm font-medium text-amber-800 mb-4">Unggah Bukti Transfer</p>
                
                <div class="mb-4">
                    <label class="block text-xs font-medium text-amber-700 mb-1.5">File Bukti Transfer (JPG, PNG, max 5MB)</label>
                    <input type="file" name="proof_of_payment" accept="image/jpeg,image/png,image/jpg" required
                        class="w-full px-3 py-2 border border-amber-200 rounded-lg text-sm bg-slate-50 text-slate-600 focus:outline-none focus:border-amber-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-amber-100 file:text-amber-700 hover:file:bg-amber-200">
                    @error('proof_of_payment')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-amber-50 rounded-lg p-4 mb-6 text-sm text-amber-700">
                <p class="font-medium mb-1">Informasi Penting</p>
                <ul class="text-xs text-amber-600 space-y-1 list-disc list-inside">
                    <li>Pastikan nominal transfer tepat hingga 3 digit terakhir.</li>
                    <li>Pastikan bukti transfer terlihat jelas (tidak buram).</li>
                    <li>Proses verifikasi membutuhkan waktu maksimal 1x24 jam kerja.</li>
                </ul>
            </div>

            <button type="submit" id="payBtn" class="w-full py-3 text-white font-medium text-sm rounded-lg hover:opacity-90 transition-all" style="background: linear-gradient(135deg,#C8A97E,#A8855A);">
                Kirim Bukti Pembayaran
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('paymentForm').addEventListener('submit', function(e) {
    if(!this.checkValidity()) return;
    const btn = document.getElementById('payBtn');
    btn.disabled = true;
    btn.textContent = 'Mengunggah...';
});
</script>
@endpush
@endsection
