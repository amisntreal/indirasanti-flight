@extends('layouts.admin')
@section('title','Detail Pemesanan')
@section('page-title','Detail Pemesanan')
@section('content')
<div class="max-w-4xl">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <h2 class="font-display text-xl font-semibold text-amber-900">{{ $booking->booking_code }}</h2>
            @php 
                $sc=['confirmed'=>'bg-green-100 text-green-700','pending'=>'bg-amber-100 text-amber-700','pending_verification'=>'bg-blue-100 text-blue-700','cancelled'=>'bg-red-100 text-red-700']; 
                $sl=['confirmed'=>'Dikonfirmasi','pending'=>'Menunggu','pending_verification'=>'Menunggu Verifikasi','cancelled'=>'Dibatalkan']; 
            @endphp
            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $sc[$booking->status] }}">{{ $sl[$booking->status] }}</span>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="text-sm text-amber-600 hover:underline">← Kembali</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-xl border border-amber-100 p-5">
                <p class="text-xs font-medium text-amber-600 uppercase tracking-wide mb-4">Info Penumpang & Pengguna</p>
                <div class="mb-3 pb-3 border-b border-amber-50">
                    <p class="text-sm font-medium text-amber-900">{{ $booking->user->name }}</p>
                    <p class="text-xs text-amber-500">{{ $booking->user->email }}</p>
                </div>
                <div class="space-y-2">
                    @foreach($booking->passengers as $i => $p)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-amber-700">{{ $i+1 }}. {{ $p->full_name }}</span>
                        <span class="text-amber-500 text-xs">{{ $p->gender === 'male' ? 'Laki-laki' : 'Perempuan' }} • Kursi {{ $p->seat_number }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-xl border border-amber-100 p-5">
                <p class="text-xs font-medium text-amber-600 uppercase tracking-wide mb-4">Detail Penerbangan</p>
                <div class="flex items-center gap-4">
                    <div>
                        <p class="font-display text-2xl font-semibold text-amber-900">{{ $booking->flight->departure_time->format('H:i') }}</p>
                        <p class="text-xs text-amber-600">{{ $booking->flight->departureAirport->city }}</p>
                    </div>
                    <div class="flex-1 text-center">
                        <p class="text-xs text-amber-400">{{ $booking->flight->duration }}</p>
                        <div class="h-px bg-amber-200 my-1"></div>
                        <p class="text-xs text-amber-400">{{ $booking->flight->flight_number }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-display text-2xl font-semibold text-amber-900">{{ $booking->flight->arrival_time->format('H:i') }}</p>
                        <p class="text-xs text-amber-600">{{ $booking->flight->arrivalAirport->city }}</p>
                    </div>
                </div>
                <p class="text-xs text-amber-500 mt-3">{{ $booking->flight->airline->name }} • {{ $booking->flight->departure_time->format('d M Y') }}</p>
            </div>
        </div>

        <div class="space-y-5">
            <div class="bg-white rounded-xl border border-amber-100 p-5">
                <p class="text-xs font-medium text-amber-600 uppercase tracking-wide mb-4">Pembayaran</p>
                @if($booking->payment)
                <div class="space-y-2 text-sm mb-4">
                    <div class="flex justify-between"><span class="text-amber-600">Metode</span><span class="font-medium uppercase">{{ $booking->payment->payment_method }}</span></div>
                    <div class="flex justify-between"><span class="text-amber-600">Jumlah</span><span class="font-medium">Rp {{ number_format($booking->payment->amount,0,',','.') }}</span></div>
                    @php 
                        $psc=['paid'=>'text-green-600','pending'=>'text-amber-600','pending_verification'=>'text-blue-600','failed'=>'text-red-600']; 
                        $psl=['paid'=>'Lunas','pending'=>'Belum Dibayar','pending_verification'=>'Menunggu Verifikasi','failed'=>'Gagal']; 
                    @endphp
                    <div class="flex justify-between"><span class="text-amber-600">Status</span><span class="font-medium {{ $psc[$booking->payment->payment_status] }}">{{ $psl[$booking->payment->payment_status] }}</span></div>
                </div>
                
                @if($booking->payment->proof_of_payment)
                <div class="mt-4 pt-4 border-t border-amber-50 text-center">
                    <p class="text-xs text-amber-600 mb-2">Bukti Transfer</p>
                    <a href="{{ \Illuminate\Support\Facades\Storage::url($booking->payment->proof_of_payment) }}" target="_blank" class="inline-block p-1 border border-slate-200 rounded">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($booking->payment->proof_of_payment) }}" class="h-32 object-contain" alt="Bukti Transfer">
                    </a>
                </div>
                @endif
                
                @if($booking->status === 'pending_verification')
                <div class="mt-5 pt-4 border-t border-amber-50 flex gap-2">
                    <form action="{{ route('admin.bookings.verify', $booking) }}" method="POST" class="flex-1">
                        @csrf @method('PUT')
                        <button type="submit" class="w-full py-2 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold rounded-lg transition" onclick="return confirm('Verifikasi pembayaran ini dan set lunas?')">✓ Terima</button>
                    </form>
                    <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST" class="flex-1">
                        @csrf @method('PUT')
                        <button type="submit" class="w-full py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition" onclick="return confirm('Tolak pembayaran dan batalkan pesanan?')">✗ Tolak</button>
                    </form>
                </div>
                @endif
                
                @else
                <p class="text-sm text-amber-400">Belum ada pembayaran</p>
                @endif
            </div>

            <div class="bg-white rounded-xl border border-amber-100 p-5">
                <p class="text-xs font-medium text-amber-600 uppercase tracking-wide mb-4">Update Status</p>
                <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST">
                    @csrf @method('PUT')
                    <select name="status" class="w-full px-3 py-2.5 border border-amber-200 rounded-lg text-sm mb-3 bg-white">
                        <option value="pending" {{ $booking->status=='pending'?'selected':'' }}>Menunggu</option>
                        <option value="confirmed" {{ $booking->status=='confirmed'?'selected':'' }}>Konfirmasi</option>
                        <option value="cancelled" {{ $booking->status=='cancelled'?'selected':'' }}>Batalkan</option>
                    </select>
                    <button type="submit" class="w-full py-2.5 text-white text-sm font-medium rounded-lg hover:opacity-90" style="background:linear-gradient(135deg,#C8A97E,#A8855A);">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
