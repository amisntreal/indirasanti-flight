@extends('layouts.admin')
@section('title','Bandara')
@section('page-title','Bandara')
@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-amber-600">{{ $airports->total() }} bandara terdaftar</p>
    <a href="{{ route('admin.airports.create') }}" class="px-4 py-2 text-white text-sm font-medium rounded-lg hover:opacity-90" style="background:linear-gradient(135deg,#C8A97E,#A8855A);">+ Tambah Bandara</a>
</div>
<div class="bg-white rounded-xl border border-amber-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="border-b border-amber-100 bg-amber-50/60">
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Nama</th>
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Kota</th>
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Negara</th>
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">IATA</th>
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-amber-50">
            @foreach($airports as $airport)
            <tr class="hover:bg-amber-50/40 transition-colors">
                <td class="px-6 py-4 text-amber-900">{{ $airport->name }}</td>
                <td class="px-6 py-4 text-amber-700">{{ $airport->city }}</td>
                <td class="px-6 py-4 text-amber-600">{{ $airport->country }}</td>
                <td class="px-6 py-4"><span class="px-2 py-0.5 rounded text-xs font-bold text-amber-800" style="background:rgba(200,169,126,0.2)">{{ $airport->iata_code }}</span></td>
                <td class="px-6 py-4 flex gap-3">
                    <a href="{{ route('admin.airports.edit', $airport) }}" class="text-xs text-amber-700 hover:underline">Edit</a>
                    <form action="{{ route('admin.airports.destroy', $airport) }}" method="POST" onsubmit="return confirm('Hapus bandara ini?')">
                        @csrf @method('DELETE')
                        <button class="text-xs text-red-500 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-amber-100">{{ $airports->links() }}</div>
</div>
@endsection
