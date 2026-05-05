@extends('layouts.admin')
@section('title','Edit Pesawat')
@section('page-title','Edit Pesawat')
@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-amber-100 p-6">
        <form action="{{ route('admin.airplanes.update', $airplane) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Maskapai</label>
                <select name="airline_id" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 bg-white">
                    @foreach($airlines as $airline)
                    <option value="{{ $airline->id }}" {{ old('airline_id', $airplane->airline_id) == $airline->id ? 'selected' : '' }}>{{ $airline->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Model Pesawat</label>
                <input type="text" name="model" value="{{ old('model', $airplane->model) }}" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Nomor Registrasi</label>
                <input type="text" name="registration_number" value="{{ old('registration_number', $airplane->registration_number) }}" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Kapasitas Kursi</label>
                <input type="number" name="capacity" value="{{ old('capacity', $airplane->capacity) }}" required min="1" class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
            </div>
            <div class="mb-6">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">{{ old('description', $airplane->description) }}</textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2.5 text-white text-sm font-medium rounded-lg hover:opacity-90" style="background:linear-gradient(135deg,#C8A97E,#A8855A);">Update</button>
                <a href="{{ route('admin.airplanes.index') }}" class="px-6 py-2.5 border border-amber-300 text-amber-700 text-sm font-medium rounded-lg hover:bg-amber-50">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
