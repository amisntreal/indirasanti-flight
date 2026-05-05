<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Indirasanti Flight')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --color-primary: #C8A97E;
            --color-primary-dark: #A8855A;
            --color-primary-light: #E8D5B5;
            --color-dark: #1A1410;
            --color-dark-2: #2C2318;
            --color-dark-3: #3D3020;
            --color-gold: #C8A97E;
            --color-cream: #F5EDD8;
            --color-text: #4A3728;
        }
        body { font-family: 'Jost', sans-serif; background-color: #FAF6EF; color: var(--color-text); }
        h1, h2, h3, h4, h5, .font-display { font-family: 'Cormorant Garamond', serif; }
    </style>
    @stack('styles')
</head>
<body>
    {{-- Navbar --}}
    <nav class="bg-white shadow-sm border-b border-amber-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Indirasanti Flight" class="h-10 w-auto">
                    <span class="font-display text-xl font-semibold text-amber-800 hidden sm:block">Indirasanti Flight</span>
                </a>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-amber-800 hover:text-amber-600 transition-colors">Beranda</a>
                    <a href="{{ route('flights.search') }}?from=1&to=2&date={{ now()->addDays(3)->format('Y-m-d') }}&passengers=1" class="text-sm font-medium text-amber-800 hover:text-amber-600 transition-colors">Cari Penerbangan</a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-amber-800 hover:text-amber-600 transition-colors">Admin</a>
                        @endif
                        <a href="{{ route('customer.dashboard') }}" class="text-sm font-medium text-amber-800 hover:text-amber-600 transition-colors">Dashboard</a>
                        <a href="{{ route('bookings.index') }}" class="text-sm font-medium text-amber-800 hover:text-amber-600 transition-colors">Pemesanan Saya</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-amber-800 hover:text-amber-600 transition-colors">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-amber-800 hover:text-amber-600 transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white rounded-lg transition-all" style="background: var(--color-primary);">Daftar</a>
                    @endauth
                </div>
                {{-- Mobile menu button --}}
                <button id="mobileMenuBtn" class="md:hidden p-2 text-amber-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
        {{-- Mobile menu --}}
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-amber-100 px-4 py-3 space-y-2">
            <a href="{{ route('home') }}" class="block text-sm font-medium text-amber-800 py-2">Beranda</a>
            @auth
                <a href="{{ route('customer.dashboard') }}" class="block text-sm font-medium text-amber-800 py-2">Dashboard</a>
                <a href="{{ route('bookings.index') }}" class="block text-sm font-medium text-amber-800 py-2">Pemesanan Saya</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block text-sm font-medium text-amber-800 py-2">Admin Panel</a>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block text-sm font-medium text-amber-800 py-2">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-sm font-medium text-amber-800 py-2">Masuk</a>
                <a href="{{ route('register') }}" class="block text-sm font-medium text-amber-800 py-2">Daftar</a>
            @endauth
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 pt-4">
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 pt-4">
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="mt-16" style="background: var(--color-dark);">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Indirasanti Flight" class="h-12 w-auto">
                        <span class="font-display text-2xl font-semibold text-amber-300">Indirasanti Flight</span>
                    </div>
                    <p class="text-amber-100/60 text-sm leading-relaxed max-w-xs">Layanan penerbangan premium yang menghubungkan destinasi terbaik di Indonesia dan mancanegara dengan kenyamanan dan keamanan terjamin.</p>
                </div>
                <div>
                    <h4 class="font-display text-amber-300 font-semibold mb-4 text-lg">Layanan</h4>
                    <ul class="space-y-2 text-sm text-amber-100/60">
                        <li><a href="{{ route('flights.search') }}?from=1&to=2&date={{ now()->addDays(3)->format('Y-m-d') }}&passengers=1" class="hover:text-amber-300 transition-colors">Cari Penerbangan</a></li>
                        <li><a href="{{ route('bookings.index') }}" class="hover:text-amber-300 transition-colors">Cek Pemesanan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-display text-amber-300 font-semibold mb-4 text-lg">Kontak</h4>
                    <ul class="space-y-2 text-sm text-amber-100/60">
                        <li>info@indirasanti.com</li>
                        <li>+62 21 1234 5678</li>
                        <li>Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-amber-800/30 mt-8 pt-6 text-center text-amber-100/40 text-xs">
                &copy; {{ date('Y') }} Indirasanti Flight. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>
