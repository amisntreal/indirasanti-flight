@extends('layouts.admin')
@section('title','Tambah Bandara')
@section('page-title','Tambah Bandara')
@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-amber-100 p-6">
        <form action="{{ route('admin.airports.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="col-span-2">
                    <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Nama Bandara</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Kota</label>
                    <input type="text" name="city" value="{{ old('city') }}" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                    @error('city')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Negara</label>
                    <input type="text" name="country" value="{{ old('country') }}" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                    @error('country')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Kode IATA</label>
                    <input type="text" name="iata_code" value="{{ old('iata_code') }}" required maxlength="5" class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 uppercase" placeholder="CGK">
                    @error('iata_code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="flex gap-3 mt-2">
                <button type="submit" class="px-6 py-2.5 text-white text-sm font-medium rounded-lg hover:opacity-90" style="background:linear-gradient(135deg,#C8A97E,#A8855A);">Simpan</button>
                <a href="{{ route('admin.airports.index') }}" class="px-6 py-2.5 border border-amber-300 text-amber-700 text-sm font-medium rounded-lg hover:bg-amber-50">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
