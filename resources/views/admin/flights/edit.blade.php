@extends('layouts.admin')
@section('title','Edit Penerbangan')
@section('page-title','Edit Penerbangan')
@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl border border-amber-100 p-6">
        <form action="{{ route('admin.flights.update', $flight) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Maskapai</label>
                    <select name="airline_id" id="airlineSelect" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 bg-white">
                        @foreach($airlines as $airline)
                        <option value="{{ $airline->id }}" {{ old('airline_id', $flight->airline_id) == $airline->id ? 'selected' : '' }}>{{ $airline->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Pesawat</label>
                    <select name="airplane_id" id="airplaneSelect" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 bg-white">
                        @foreach($airplanes as $airplane)
                        <option value="{{ $airplane->id }}" {{ old('airplane_id', $flight->airplane_id) == $airplane->id ? 'selected' : '' }}>{{ $airplane->model }} ({{ $airplane->registration_number }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Bandara Keberangkatan</label>
                    <select name="departure_airport_id" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 bg-white">
                        @foreach($airports as $airport)
                        <option value="{{ $airport->id }}" {{ old('departure_airport_id', $flight->departure_airport_id) == $airport->id ? 'selected' : '' }}>{{ $airport->city }} ({{ $airport->iata_code }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Bandara Tujuan</label>
                    <select name="arrival_airport_id" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 bg-white">
                        @foreach($airports as $airport)
                        <option value="{{ $airport->id }}" {{ old('arrival_airport_id', $flight->arrival_airport_id) == $airport->id ? 'selected' : '' }}>{{ $airport->city }} ({{ $airport->iata_code }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Nomor Penerbangan</label>
                    <input type="text" name="flight_number" value="{{ old('flight_number', $flight->flight_number) }}" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                </div>
                <div>
                    <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Waktu Keberangkatan</label>
                    <input type="datetime-local" name="departure_time" value="{{ old('departure_time', $flight->departure_time->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                </div>
                <div>
                    <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Waktu Kedatangan</label>
                    <input type="datetime-local" name="arrival_time" value="{{ old('arrival_time', $flight->arrival_time->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                </div>
                <div>
                    <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', $flight->price) }}" required min="0" class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                </div>
                <div>
                    <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Kursi Tersedia</label>
                    <input type="number" name="available_seats" value="{{ old('available_seats', $flight->available_seats) }}" required min="0" class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="px-6 py-2.5 text-white text-sm font-medium rounded-lg hover:opacity-90" style="background:linear-gradient(135deg,#C8A97E,#A8855A);">Update</button>
                <a href="{{ route('admin.flights.index') }}" class="px-6 py-2.5 border border-amber-300 text-amber-700 text-sm font-medium rounded-lg hover:bg-amber-50">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.getElementById('airlineSelect').addEventListener('change', function() {
    const airlineId = this.value;
    const airplaneSelect = document.getElementById('airplaneSelect');
    if (!airlineId) return;
    fetch(`/admin/airlines/${airlineId}/airplanes`)
        .then(r => r.json())
        .then(data => {
            airplaneSelect.innerHTML = '<option value="">Pilih Pesawat</option>';
            data.forEach(p => {
                airplaneSelect.innerHTML += `<option value="${p.id}">${p.model} (${p.registration_number})</option>`;
            });
        });
});
</script>
@endpush
