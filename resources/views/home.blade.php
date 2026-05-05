@extends('layouts.app')
@section('title', 'Indirasanti Flight - Penerbangan Premium Indonesia')

@push('styles')
<style>
.hero-section {
    background: linear-gradient(135deg, #1A1410 0%, #2C2318 40%, #3D3020 100%);
    min-height: 88vh;
    position: relative;
    overflow: hidden;
}
.hero-pattern {
    position: absolute;
    inset: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(200,169,126,0.08) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(200,169,126,0.06) 0%, transparent 40%);
}
.search-card {
    background: rgba(255,255,255,0.97);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(200,169,126,0.3);
}
.carousel-item { transition: opacity 0.8s ease-in-out; }
.gold-badge {
    background: linear-gradient(135deg, #C8A97E, #A8855A);
    color: white;
}
.flight-card {
    border: 1px solid rgba(200,169,126,0.2);
    transition: all 0.3s ease;
}
.flight-card:hover {
    border-color: rgba(200,169,126,0.5);
    box-shadow: 0 8px 30px rgba(200,169,126,0.15);
    transform: translateY(-2px);
}
.stat-card {
    background: linear-gradient(135deg, #2C2318, #3D3020);
    border: 1px solid rgba(200,169,126,0.2);
}
</style>
@endpush

@section('content')
{{-- Hero Section with Carousel --}}
<section class="hero-section flex items-center">
    <div class="hero-pattern"></div>
    
    {{-- Carousel Background Images --}}
    <div class="absolute inset-0 overflow-hidden">
        <div id="carousel" class="relative h-full">
            @php
            $heroImages = [
                ['url' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1920&q=80', 'label' => 'Jelajahi Dunia'],
                ['url' => 'https://images.unsplash.com/photo-1542296332-2e4473faf563?w=1920&q=80', 'label' => 'Penerbangan Premium'],
                ['url' => 'https://images.unsplash.com/photo-1500835556837-99ac94a94552?w=1920&q=80', 'label' => 'Destinasi Terbaik'],
            ];
            @endphp
            @foreach($heroImages as $index => $image)
            <div class="carousel-item absolute inset-0 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" data-index="{{ $index }}">
                <img src="{{ $image['url'] }}" alt="{{ $image['label'] }}" class="w-full h-full object-cover opacity-25">
            </div>
            @endforeach
        </div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full">
        <div class="max-w-2xl mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-medium text-amber-300 border border-amber-700/50 mb-6" style="background: rgba(200,169,126,0.1);">
                <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                Penerbangan Premium & Terpercaya
            </div>
            <h1 class="font-display text-5xl md:text-6xl lg:text-7xl font-light text-white leading-tight mb-4">
                Terbang ke <span style="color: var(--color-primary);">Mana Saja</span><br>
                Kapan Saja
            </h1>
            <p class="text-amber-100/60 text-lg leading-relaxed">
                Pesan tiket penerbangan domestik dan internasional dengan mudah, cepat, dan aman bersama Indirasanti Flight.
            </p>
        </div>

        {{-- Search Form --}}
        <div class="search-card rounded-2xl p-6 shadow-2xl max-w-4xl">
            <form action="{{ route('flights.search') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-amber-800 mb-1.5 uppercase tracking-wide">Dari</label>
                        <select name="from" required class="w-full px-3 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 bg-white text-amber-900">
                            <option value="">Pilih Bandara</option>
                            @foreach($airports as $airport)
                                <option value="{{ $airport->id }}">{{ $airport->city }} ({{ $airport->iata_code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-amber-800 mb-1.5 uppercase tracking-wide">Ke</label>
                        <select name="to" required class="w-full px-3 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 bg-white text-amber-900">
                            <option value="">Pilih Bandara</option>
                            @foreach($airports as $airport)
                                <option value="{{ $airport->id }}">{{ $airport->city }} ({{ $airport->iata_code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-amber-800 mb-1.5 uppercase tracking-wide">Tanggal</label>
                        <input type="date" name="date" required min="{{ now()->addDay()->format('Y-m-d') }}" value="{{ now()->addDays(3)->format('Y-m-d') }}" class="w-full px-3 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 bg-white text-amber-900">
                    </div>
                    <div class="col-span-1 md:col-span-4 grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-amber-800 mb-1.5 uppercase tracking-wide">Dewasa</label>
                            <input type="number" name="adults" min="1" max="9" value="1" required class="w-full px-3 py-2 border border-amber-200 rounded-lg text-sm bg-white text-amber-900 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-amber-800 mb-1.5 uppercase tracking-wide">Anak (2-11)</label>
                            <input type="number" name="children" min="0" max="9" value="0" class="w-full px-3 py-2 border border-amber-200 rounded-lg text-sm bg-white text-amber-900 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-amber-800 mb-1.5 uppercase tracking-wide">Bayi (<2)</label>
                            <input type="number" name="infants" min="0" max="9" value="0" class="w-full px-3 py-2 border border-amber-200 rounded-lg text-sm bg-white text-amber-900 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="px-8 py-3 text-white font-medium text-sm rounded-lg transition-all hover:opacity-90 flex items-center gap-2" style="background: linear-gradient(135deg, #C8A97E, #A8855A);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Cari Penerbangan
                    </button>
                </div>
            </form>
        </div>

        {{-- Carousel indicators --}}
        <div class="flex gap-2 mt-6">
            @foreach($heroImages as $index => $image)
            <button onclick="goToSlide({{ $index }})" class="carousel-dot h-1 rounded-full transition-all {{ $index === 0 ? 'w-6 bg-amber-400' : 'w-2 bg-amber-700' }}"></button>
            @endforeach
        </div>
    </div>
</section>

{{-- Stats Section --}}
<section style="background: var(--color-dark-2);">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
            $stats = [
                ['number' => '50+', 'label' => 'Rute Penerbangan'],
                ['number' => '5', 'label' => 'Maskapai Mitra'],
                ['number' => '12', 'label' => 'Bandara Terlayani'],
                ['number' => '10K+', 'label' => 'Penumpang Puas'],
            ];
            @endphp
            @foreach($stats as $stat)
            <div class="stat-card rounded-xl p-6 text-center">
                <p class="font-display text-3xl font-semibold mb-1" style="color: var(--color-primary);">{{ $stat['number'] }}</p>
                <p class="text-amber-200/50 text-xs">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Flights --}}
<section class="py-16 bg-amber-50/50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-amber-600 text-xs uppercase tracking-widest mb-2">Pilihan Terbaik</p>
                <h2 class="font-display text-4xl font-semibold text-amber-900">Penerbangan Unggulan</h2>
            </div>
        </div>

        @if($featuredFlights->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($featuredFlights as $flight)
            <div class="flight-card bg-white rounded-xl overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full" style="background: rgba(200,169,126,0.15); color: #A8855A;">{{ $flight->airline->name }}</span>
                        <span class="text-xs text-amber-600">{{ $flight->flight_number }}</span>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="font-display text-2xl font-semibold text-amber-900">{{ $flight->departureAirport->iata_code }}</p>
                            <p class="text-xs text-amber-600">{{ $flight->departureAirport->city }}</p>
                            <p class="text-xs text-amber-500 mt-1">{{ $flight->departure_time->format('H:i') }}</p>
                        </div>
                        <div class="flex flex-col items-center flex-1 px-4">
                            <p class="text-xs text-amber-400 mb-1">{{ $flight->duration }}</p>
                            <div class="flex items-center w-full">
                                <div class="h-px bg-amber-200 flex-1"></div>
                                <svg class="w-4 h-4 text-amber-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                <div class="h-px bg-amber-200 flex-1"></div>
                            </div>
                            <p class="text-xs text-amber-400 mt-1">{{ $flight->departure_time->format('d M') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-display text-2xl font-semibold text-amber-900">{{ $flight->arrivalAirport->iata_code }}</p>
                            <p class="text-xs text-amber-600">{{ $flight->arrivalAirport->city }}</p>
                            <p class="text-xs text-amber-500 mt-1">{{ $flight->arrival_time->format('H:i') }}</p>
                        </div>
                    </div>
                    <div class="border-t border-amber-100 pt-4 flex items-center justify-between">
                        <div>
                            <p class="font-display text-xl font-semibold text-amber-800">Rp {{ number_format($flight->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-amber-500">per orang • {{ $flight->available_seats }} kursi tersisa</p>
                        </div>
                        <a href="{{ route('bookings.create') }}?flight_id={{ $flight->id }}&adults=1&children=0&infants=0" class="px-4 py-2 text-white text-xs font-medium rounded-lg transition-all hover:opacity-90" style="background: linear-gradient(135deg, #C8A97E, #A8855A);">
                            Pesan
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 text-amber-400">
            <p>Belum ada penerbangan tersedia.</p>
        </div>
        @endif
    </div>
</section>

{{-- Airlines Section --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <p class="text-amber-600 text-xs uppercase tracking-widest mb-2">Maskapai Mitra</p>
            <h2 class="font-display text-4xl font-semibold text-amber-900">Didukung Maskapai Terbaik</h2>
        </div>
        <div class="flex flex-wrap justify-center gap-6">
            @foreach($airlines as $airline)
            <div class="flex items-center gap-3 px-6 py-3 rounded-xl border border-amber-100 hover:border-amber-300 transition-colors">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white" style="background: var(--color-primary);">
                    {{ $airline->code }}
                </div>
                <span class="text-sm font-medium text-amber-800">{{ $airline->name }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Features Section --}}
<section class="py-16" style="background: var(--color-dark);">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <p class="text-amber-500 text-xs uppercase tracking-widest mb-2">Mengapa Kami</p>
            <h2 class="font-display text-4xl font-semibold text-white">Keunggulan Indirasanti</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
            $features = [
                ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Aman & Terpercaya', 'desc' => 'Setiap transaksi diverifikasi secara manual oleh admin untuk menjamin keamanan dan kenyamanan Anda.'],
                ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Pemesanan Cepat', 'desc' => 'Proses pemesanan tiket hanya dalam hitungan menit dengan antarmuka yang intuitif dan mudah digunakan.'],
                ['icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z', 'title' => 'Dukungan 24/7', 'desc' => 'Tim layanan pelanggan kami siap membantu Anda kapan saja melalui berbagai saluran komunikasi.'],
            ];
            @endphp
            @foreach($features as $feature)
            <div class="p-6 rounded-xl border border-amber-800/20" style="background: rgba(200,169,126,0.05);">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background: rgba(200,169,126,0.15);">
                    <svg class="w-6 h-6" style="color: var(--color-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $feature['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="font-display text-xl font-semibold text-amber-300 mb-2">{{ $feature['title'] }}</h3>
                <p class="text-amber-100/50 text-sm leading-relaxed">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-item');
const dots = document.querySelectorAll('.carousel-dot');

function goToSlide(index) {
    slides[currentSlide].classList.replace('opacity-100', 'opacity-0');
    dots[currentSlide].classList.remove('w-6', 'bg-amber-400');
    dots[currentSlide].classList.add('w-2', 'bg-amber-700');
    
    currentSlide = index;
    slides[currentSlide].classList.replace('opacity-0', 'opacity-100');
    dots[currentSlide].classList.remove('w-2', 'bg-amber-700');
    dots[currentSlide].classList.add('w-6', 'bg-amber-400');
}

setInterval(() => goToSlide((currentSlide + 1) % slides.length), 5000);
</script>
@endpush
