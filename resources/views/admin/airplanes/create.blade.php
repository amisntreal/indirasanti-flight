@extends('layouts.admin')
@section('title','Tambah Pesawat')
@section('page-title','Tambah Pesawat')
@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-amber-100 p-6">
        <form action="{{ route('admin.airplanes.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Maskapai</label>
                <select name="airline_id" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 bg-white">
                    <option value="">Pilih Maskapai</option>
                    @foreach($airlines as $airline)
                    <option value="{{ $airline->id }}" {{ old('airline_id') == $airline->id ? 'selected' : '' }}>{{ $airline->name }}</option>
                    @endforeach
                </select>
                @error('airline_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Model Pesawat</label>
                <input type="text" name="model" value="{{ old('model') }}" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400" placeholder="Contoh: Boeing 737-800">
                @error('model')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Nomor Registrasi</label>
                <input type="text" name="registration_number" value="{{ old('registration_number') }}" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400" placeholder="Contoh: PK-GFX">
                @error('registration_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Kapasitas Kursi</label>
                <input type="number" name="capacity" value="{{ old('capacity') }}" required min="1" class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                @error('capacity')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-6">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">{{ old('description') }}</textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2.5 text-white text-sm font-medium rounded-lg hover:opacity-90" style="background:linear-gradient(135deg,#C8A97E,#A8855A);">Simpan</button>
                <a href="{{ route('admin.airplanes.index') }}" class="px-6 py-2.5 border border-amber-300 text-amber-700 text-sm font-medium rounded-lg hover:bg-amber-50">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
