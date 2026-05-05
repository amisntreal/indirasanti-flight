@extends('layouts.admin')
@section('title','Edit Maskapai')
@section('page-title','Edit Maskapai')
@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-amber-100 p-6">
        <form action="{{ route('admin.airlines.update', $airline) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Nama Maskapai</label>
                <input type="text" name="name" value="{{ old('name', $airline->name) }}" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Kode IATA</label>
                <input type="text" name="code" value="{{ old('code', $airline->code) }}" required maxlength="10" class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">{{ old('description', $airline->description) }}</textarea>
            </div>
            <div class="mb-6">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Logo Baru (opsional)</label>
                <input type="file" name="logo" accept="image/*" class="w-full text-sm text-amber-700">
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2.5 text-white text-sm font-medium rounded-lg hover:opacity-90" style="background:linear-gradient(135deg,#C8A97E,#A8855A);">Update</button>
                <a href="{{ route('admin.airlines.index') }}" class="px-6 py-2.5 border border-amber-300 text-amber-700 text-sm font-medium rounded-lg hover:bg-amber-50">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
