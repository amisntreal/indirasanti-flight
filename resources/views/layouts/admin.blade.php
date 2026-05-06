<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - @yield('title', 'Indirasanti Flight')</title>
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
            --color-sidebar: #1E1812;
        }
        body { font-family: 'Jost', sans-serif; }
        h1, h2, h3, h4, h5, .font-display { font-family: 'Cormorant Garamond', serif; }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover, .sidebar-link.active { background-color: rgba(200,169,126,0.15); color: #C8A97E; }
        .sidebar-link.active { border-left: 3px solid #C8A97E; }
    </style>
    @stack('styles')
</head>
<body class="bg-amber-50/30">
    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        <aside class="w-64 flex-shrink-0 flex flex-col" style="background: var(--color-sidebar);">
            <div class="flex items-center space-x-2 px-6 py-5 border-b border-amber-800/20">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-auto">
                <div>
                    <p class="font-display text-amber-300 font-semibold leading-tight text-sm">Indirasanti</p>
                    <p class="text-amber-500/60 text-xs">Admin Panel</p>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-amber-200/70">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v0"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"/></svg>
                    Dashboard
                </a>
                @if(auth()->user()->isAdmin())
                <div class="pt-4 pb-1 px-3">
                    <p class="text-amber-600/40 text-xs font-medium uppercase tracking-wider">Master Data</p>
                </div>
                <a href="{{ route('admin.airlines.index') }}" class="sidebar-link {{ request()->routeIs('admin.airlines*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-amber-200/70">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Maskapai
                </a>
                <a href="{{ route('admin.airports.index') }}" class="sidebar-link {{ request()->routeIs('admin.airports*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-amber-200/70">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Bandara
                </a>
                <div class="pt-4 pb-1 px-3">
                    <p class="text-amber-600/40 text-xs font-medium uppercase tracking-wider">Pengguna</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-amber-200/70">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Manajemen Pengguna
                </a>
                @endif

                @if(auth()->user()->isManager())
                <div class="pt-4 pb-1 px-3">
                    <p class="text-amber-600/40 text-xs font-medium uppercase tracking-wider">Manajemen Armada</p>
                </div>
                <a href="{{ route('admin.airplanes.index') }}" class="sidebar-link {{ request()->routeIs('admin.airplanes*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-amber-200/70">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Pesawat
                </a>
                <a href="{{ route('admin.flights.index') }}" class="sidebar-link {{ request()->routeIs('admin.flights*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-amber-200/70">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Penerbangan
                </a>
                <div class="pt-4 pb-1 px-3">
                    <p class="text-amber-600/40 text-xs font-medium uppercase tracking-wider">Laporan</p>
                </div>
                <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-amber-200/70">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Laporan Keuangan
                </a>
                @endif

                @if(auth()->user()->isStaff())
                <div class="pt-4 pb-1 px-3">
                    <p class="text-amber-600/40 text-xs font-medium uppercase tracking-wider">Operasional</p>
                </div>
                <a href="{{ route('admin.bookings.index') }}" class="sidebar-link {{ request()->routeIs('admin.bookings*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-amber-200/70">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Pemesanan
                </a>
                <a href="{{ route('admin.offline-bookings.create') }}" class="sidebar-link {{ request()->routeIs('admin.offline-bookings*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-amber-200/70">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Pemesanan Offline
                </a>
                @endif
            </nav>

            <div class="px-4 py-4 border-t border-amber-800/20">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold text-amber-900" style="background: var(--color-primary);">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-amber-200 text-xs font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-amber-500/50 text-xs">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full text-left text-xs text-amber-500/60 hover:text-amber-400 transition-colors">Keluar</button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white border-b border-amber-100 px-6 py-4 flex items-center justify-between">
                <h1 class="font-display text-2xl font-semibold text-amber-900">@yield('page-title', 'Dashboard')</h1>
                <div class="flex items-center gap-2 text-sm text-amber-700">
                    <a href="{{ route('home') }}" target="_blank" class="hover:text-amber-900 transition-colors">Lihat Website</a>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
