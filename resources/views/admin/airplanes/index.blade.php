@extends('layouts.admin')
@section('title','Pesawat')
@section('page-title','Pesawat')
@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-amber-600">{{ $airplanes->total() }} pesawat terdaftar</p>
    <a href="{{ route('admin.airplanes.create') }}" class="px-4 py-2 text-white text-sm font-medium rounded-lg hover:opacity-90" style="background:linear-gradient(135deg,#C8A97E,#A8855A);">+ Tambah Pesawat</a>
</div>
<div class="bg-white rounded-xl border border-amber-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="border-b border-amber-100 bg-amber-50/60">
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Model</th>
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Registrasi</th>
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Maskapai</th>
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Kapasitas</th>
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-amber-50">
            @foreach($airplanes as $airplane)
            <tr class="hover:bg-amber-50/40 transition-colors">
                <td class="px-6 py-4 font-medium text-amber-900">{{ $airplane->model }}</td>
                <td class="px-6 py-4 text-amber-700 font-mono text-xs">{{ $airplane->registration_number }}</td>
                <td class="px-6 py-4 text-amber-600">{{ $airplane->airline->name }}</td>
                <td class="px-6 py-4 text-amber-600">{{ $airplane->capacity }} kursi</td>
                <td class="px-6 py-4 flex gap-3">
                    <a href="{{ route('admin.airplanes.edit', $airplane) }}" class="text-xs text-amber-700 hover:underline">Edit</a>
                    <form action="{{ route('admin.airplanes.destroy', $airplane) }}" method="POST" onsubmit="return confirm('Hapus pesawat ini?')">
                        @csrf @method('DELETE')
                        <button class="text-xs text-red-500 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-amber-100">{{ $airplanes->links() }}</div>
</div>
@endsection
