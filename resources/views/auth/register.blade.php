@extends('layouts.app')
@section('title', 'Daftar - Indirasanti Flight')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4" style="background: linear-gradient(135deg, #1A1410, #2C2318);">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Indirasanti Flight" class="h-20 w-auto mx-auto mb-4">
            <h1 class="font-display text-3xl font-semibold text-amber-300">Buat Akun Baru</h1>
            <p class="text-amber-100/50 text-sm mt-1">Bergabung dengan Indirasanti Flight</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="block text-xs font-medium text-amber-800 mb-1.5 uppercase tracking-wide">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 @error('name') border-red-400 @enderror"
                        placeholder="Nama Lengkap Anda">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-5">
                    <label class="block text-xs font-medium text-amber-800 mb-1.5 uppercase tracking-wide">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 @error('email') border-red-400 @enderror"
                        placeholder="email@contoh.com">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-5">
                    <label class="block text-xs font-medium text-amber-800 mb-1.5 uppercase tracking-wide">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 @error('password') border-red-400 @enderror"
                        placeholder="Minimal 8 karakter">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-medium text-amber-800 mb-1.5 uppercase tracking-wide">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-3 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400"
                        placeholder="Ulangi password">
                </div>
                <button type="submit" class="w-full py-3 text-white font-medium text-sm rounded-lg transition-all hover:opacity-90" style="background: linear-gradient(135deg, #C8A97E, #A8855A);">
                    Buat Akun
                </button>
            </form>
            <p class="text-center text-sm text-amber-600 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-amber-800 hover:underline">Masuk</a>
            </p>
        </div>
    </div>
</div>
@endsection
