@extends('layouts.admin')
@section('title','Pemesanan')
@section('page-title','Pemesanan')
@section('content')
<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex gap-2 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode pemesanan..." class="px-4 py-2 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 w-48">
        <select name="status" class="px-4 py-2 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 bg-white">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Menunggu</option>
            <option value="pending_verification" {{ request('status')=='pending_verification'?'selected':'' }}>Menunggu Verifikasi</option>
            <option value="confirmed" {{ request('status')=='confirmed'?'selected':'' }}>Dikonfirmasi</option>
            <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Dibatalkan</option>
        </select>
        <button type="submit" class="px-4 py-2 border border-amber-300 text-amber-700 text-sm rounded-lg hover:bg-amber-50">Filter</button>
    </form>
    <p class="text-sm text-amber-600">{{ $bookings->total() }} pemesanan</p>
</div>
<div class="bg-white rounded-xl border border-amber-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-amber-100 bg-amber-50/60">
                <th class="text-left px-5 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Kode</th>
                <th class="text-left px-5 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Pengguna</th>
                <th class="text-left px-5 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Rute</th>
                <th class="text-left px-5 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Tgl Pesan</th>
                <th class="text-left px-5 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Total</th>
                <th class="text-left px-5 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Pembayaran</th>
                <th class="text-left px-5 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Status</th>
                <th class="text-left px-5 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-amber-50">
                @foreach($bookings as $booking)
                <tr class="hover:bg-amber-50/40 transition-colors">
                    <td class="px-5 py-3 font-mono text-xs font-medium text-amber-800">{{ $booking->booking_code }}</td>
                    <td class="px-5 py-3 text-amber-700">{{ $booking->user->name }}</td>
                    <td class="px-5 py-3 text-amber-700 text-xs">
                        {{ $booking->flight->departureAirport->iata_code }} → {{ $booking->flight->arrivalAirport->iata_code }}
                    </td>
                    <td class="px-5 py-3 text-amber-500 text-xs">{{ $booking->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3 font-medium text-amber-800 text-xs">Rp {{ number_format($booking->total_price,0,',','.') }}</td>
                    <td class="px-5 py-3">
                        @if($booking->payment)
                        @php $psc=['paid'=>'text-green-600','pending'=>'text-amber-600','pending_verification'=>'text-blue-600','failed'=>'text-red-600']; $psl=['paid'=>'Lunas','pending'=>'Pending','pending_verification'=>'Menunggu Verifikasi','failed'=>'Gagal']; @endphp
                        <span class="text-xs font-medium {{ $psc[$booking->payment->payment_status] }}">{{ $psl[$booking->payment->payment_status] }}</span>
                        @else
                        <span class="text-xs text-amber-400">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-3">
                        @php $sc=['confirmed'=>'bg-green-100 text-green-700','pending'=>'bg-amber-100 text-amber-700','pending_verification'=>'bg-blue-100 text-blue-700','cancelled'=>'bg-red-100 text-red-700']; $sl=['confirmed'=>'Konfirmasi','pending'=>'Menunggu','pending_verification'=>'Verifikasi','cancelled'=>'Batal']; @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $sc[$booking->status] }}">{{ $sl[$booking->status] }}</span>
                    </td>
                    <td class="px-5 py-3">
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="text-xs text-amber-700 hover:underline">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-amber-100">{{ $bookings->links() }}</div>
</div>
@endsection
