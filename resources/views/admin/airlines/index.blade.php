@extends('layouts.admin')
@section('title','Maskapai')
@section('page-title','Maskapai')
@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-amber-600">{{ $airlines->total() }} maskapai terdaftar</p>
    <a href="{{ route('admin.airlines.create') }}" class="px-4 py-2 text-white text-sm font-medium rounded-lg hover:opacity-90" style="background:linear-gradient(135deg,#C8A97E,#A8855A);">+ Tambah Maskapai</a>
</div>
<div class="bg-white rounded-xl border border-amber-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="border-b border-amber-100 bg-amber-50/60">
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Nama</th>
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Kode</th>
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Pesawat</th>
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Penerbangan</th>
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-amber-50">
            @foreach($airlines as $airline)
            <tr class="hover:bg-amber-50/40 transition-colors">
                <td class="px-6 py-4 font-medium text-amber-900">{{ $airline->name }}</td>
                <td class="px-6 py-4"><span class="px-2 py-0.5 rounded text-xs font-semibold text-amber-800" style="background:rgba(200,169,126,0.2)">{{ $airline->code }}</span></td>
                <td class="px-6 py-4 text-amber-600">{{ $airline->airplanes_count }}</td>
                <td class="px-6 py-4 text-amber-600">{{ $airline->flights_count }}</td>
                <td class="px-6 py-4 flex gap-3">
                    <a href="{{ route('admin.airlines.edit', $airline) }}" class="text-xs text-amber-700 hover:underline">Edit</a>
                    <form action="{{ route('admin.airlines.destroy', $airline) }}" method="POST" onsubmit="return confirm('Hapus maskapai ini?')">
                        @csrf @method('DELETE')
                        <button class="text-xs text-red-500 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-amber-100">{{ $airlines->links() }}</div>
</div>
@endsection
