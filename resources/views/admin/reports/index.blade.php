@extends('layouts.admin')
@section('title','Laporan Keuangan')
@section('page-title','Laporan Keuangan')

@section('content')
<div class="mb-6 bg-white p-5 rounded-xl border border-amber-100">
    <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-xs font-medium text-amber-600 mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="px-3 py-2 border border-amber-200 rounded-lg text-sm bg-slate-50">
        </div>
        <div>
            <label class="block text-xs font-medium text-amber-600 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="px-3 py-2 border border-amber-200 rounded-lg text-sm bg-slate-50">
        </div>
        <div>
            <label class="block text-xs font-medium text-amber-600 mb-1">Metode Bayar</label>
            <select name="payment_method" class="px-3 py-2 border border-amber-200 rounded-lg text-sm bg-slate-50">
                <option value="">Semua Metode</option>
                <option value="bca" {{ request('payment_method')=='bca'?'selected':'' }}>BCA</option>
                <option value="mandiri" {{ request('payment_method')=='mandiri'?'selected':'' }}>Mandiri</option>
                <option value="bni" {{ request('payment_method')=='bni'?'selected':'' }}>BNI</option>
                <option value="bri" {{ request('payment_method')=='bri'?'selected':'' }}>BRI</option>
                <option value="cash" {{ request('payment_method')=='cash'?'selected':'' }}>Tunai (Offline)</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-amber-100 text-amber-800 font-medium text-sm rounded-lg hover:bg-amber-200">Filter</button>
            <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 border border-amber-200 text-amber-600 font-medium text-sm rounded-lg hover:bg-slate-50">Reset</a>
        </div>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="bg-gradient-to-r from-amber-600 to-amber-800 rounded-xl p-5 text-white">
        <p class="text-amber-200/80 text-sm font-medium mb-1">Total Pendapatan (Selesai)</p>
        <p class="font-display text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-xl border border-amber-100 p-5">
        <p class="text-amber-600 text-sm font-medium mb-1">Total Pemesanan Berhasil</p>
        <p class="font-display text-3xl font-bold text-amber-900">{{ $totalBookings }}</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-amber-100 overflow-hidden">
    <div class="p-5 border-b border-amber-50 flex justify-between items-center">
        <h3 class="font-medium text-amber-900">Rincian Transaksi</h3>
        <div class="flex gap-2">
            <a href="{{ route('admin.reports.exportPdf', request()->all()) }}" target="_blank" class="px-3 py-1.5 bg-red-50 text-red-600 text-xs font-semibold rounded hover:bg-red-100">Cetak PDF</a>
            <a href="{{ route('admin.reports.exportCsv', request()->all()) }}" class="px-3 py-1.5 bg-green-50 text-green-600 text-xs font-semibold rounded hover:bg-green-100">Export Excel</a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-amber-50/50 text-amber-800 text-xs uppercase tracking-wide">
                    <th class="p-4 border-b border-amber-100 font-medium">Tanggal</th>
                    <th class="p-4 border-b border-amber-100 font-medium">Kode</th>
                    <th class="p-4 border-b border-amber-100 font-medium">Pelanggan</th>
                    <th class="p-4 border-b border-amber-100 font-medium">Metode</th>
                    <th class="p-4 border-b border-amber-100 font-medium">Total Harga</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($bookings as $booking)
                <tr class="border-b border-slate-50 hover:bg-slate-50/50">
                    <td class="p-4 text-slate-500">{{ $booking->created_at->format('d M Y, H:i') }}</td>
                    <td class="p-4 font-medium text-amber-900">{{ $booking->booking_code }}</td>
                    <td class="p-4">{{ $booking->user->name }}</td>
                    <td class="p-4"><span class="px-2 py-1 rounded bg-slate-100 text-xs font-semibold uppercase">{{ $booking->payment->payment_method ?? '-' }}</span></td>
                    <td class="p-4 font-semibold text-amber-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-400">Tidak ada data transaksi untuk filter ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
