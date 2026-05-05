@extends('layouts.app')
@section('title', 'Profil - Indirasanti Flight')

@section('content')
<div class="max-w-xl mx-auto px-4 py-10">
    <div class="mb-8">
        <p class="text-amber-600 text-xs uppercase tracking-widest mb-1">Akun</p>
        <h1 class="font-display text-3xl font-semibold text-amber-900">Profil Saya</h1>
    </div>

    <div class="bg-white rounded-xl border border-amber-100 p-6">
        <form action="{{ route('customer.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-5">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                    class="w-full px-4 py-3 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 @error('name') border-red-400 @enderror">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-6">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                    class="w-full px-4 py-3 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 @error('email') border-red-400 @enderror">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="w-full py-3 text-white font-medium text-sm rounded-lg hover:opacity-90 transition-all" style="background: linear-gradient(135deg,#C8A97E,#A8855A);">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
