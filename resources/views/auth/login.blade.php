@extends('layouts.app')
@section('title', 'Masuk - Indirasanti Flight')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4" style="background: linear-gradient(135deg, #1A1410, #2C2318);">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Indirasanti Flight" class="h-20 w-auto mx-auto mb-4">
            <h1 class="font-display text-3xl font-semibold text-amber-300">Selamat Datang</h1>
            <p class="text-amber-100/50 text-sm mt-1">Masuk ke akun Anda</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="block text-xs font-medium text-amber-800 mb-1.5 uppercase tracking-wide">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 border rounded-lg text-sm focus:outline-none focus:ring-1 transition {{ $errors->has('email') ? 'border-red-400 focus:border-red-400 focus:ring-red-400' : 'border-amber-200 focus:border-amber-400 focus:ring-amber-400' }}"
                        placeholder="email@contoh.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-medium text-amber-800 mb-1.5 uppercase tracking-wide">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 transition"
                        placeholder="••••••••">
                </div>
                <div class="flex items-center mb-6">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-amber-600">
                    <label for="remember" class="ml-2 text-sm text-amber-700">Ingat saya</label>
                </div>
                <button type="submit" class="w-full py-3 text-white font-medium text-sm rounded-lg transition-all hover:opacity-90" style="background: linear-gradient(135deg, #C8A97E, #A8855A);">
                    Masuk
                </button>
            </form>
            <p class="text-center text-sm text-amber-600 mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-medium text-amber-800 hover:underline">Daftar sekarang</a>
            </p>
        </div>
    </div>
</div>
@endsection
