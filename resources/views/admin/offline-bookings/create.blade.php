@extends('layouts.admin')
@section('title','Pemesanan Offline')
@section('page-title','Buat Pemesanan Offline')

@push('styles')
<style>
    .seat { width: 30px; height: 30px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold; cursor: pointer; transition: all 0.2s; border: 2px solid transparent; }
    .seat.economy { background-color: #fef3c7; color: #b45309; border-color: #fde68a; }
    .seat.business { background-color: #dbeafe; color: #1d4ed8; border-color: #bfdbfe; }
    .seat.first_class { background-color: #f3e8ff; color: #7e22ce; border-color: #e9d5ff; }
    .seat:hover:not(.taken) { filter: brightness(0.9); }
    .seat.taken { background-color: #e5e7eb; color: #9ca3af; border-color: #e5e7eb; cursor: not-allowed; text-decoration: line-through; }
    .seat.selected { background-color: #10b981; color: white; border-color: #059669; }
</style>
@endpush

@section('content')
<div class="mb-6 bg-white p-5 rounded-xl border border-amber-100">
    <form action="{{ route('admin.offline-bookings.create') }}" method="GET" class="flex gap-4 items-end">
        <div class="flex-1">
            <label class="block text-xs font-medium text-amber-600 mb-1">Pilih Jadwal Penerbangan</label>
            <select name="flight_id" class="w-full px-3 py-2 border border-amber-200 rounded-lg text-sm bg-slate-50" required onchange="this.form.submit()">
                <option value="">-- Pilih Penerbangan --</option>
                @foreach($flights as $f)
                <option value="{{ $f->id }}" {{ (request('flight_id') == $f->id) ? 'selected' : '' }}>
                    {{ $f->departure_time->format('d M Y H:i') }} | {{ $f->departureAirport->iata_code }} ➔ {{ $f->arrivalAirport->iata_code }} ({{ $f->airline->name }}) - Rp {{ number_format($f->price,0,',','.') }}
                </option>
                @endforeach
            </select>
        </div>
    </form>
</div>

@if($selectedFlight)
<form action="{{ route('admin.offline-bookings.store') }}" method="POST" id="offlineForm">
    @csrf
    <input type="hidden" name="flight_id" value="{{ $selectedFlight->id }}">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white p-5 rounded-xl border border-amber-100 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-medium text-amber-900">Data Penumpang</h3>
                    <button type="button" onclick="addPassenger()" class="px-3 py-1.5 bg-amber-100 text-amber-700 text-xs font-semibold rounded hover:bg-amber-200">+ Tambah Penumpang</button>
                </div>
                
                <div id="passengerContainer">
                    <!-- Passengers injected by JS -->
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="px-8 py-2.5 bg-amber-600 text-white text-sm font-medium rounded-lg hover:bg-amber-700 transition">Buat Pesanan (Lunas)</button>
            </div>
        </div>
        
        <div class="bg-white p-5 rounded-xl border border-amber-100">
            <p class="text-xs font-medium text-amber-600 uppercase tracking-wide mb-4">Pilih Kursi</p>
            <p class="text-xs text-slate-500 mb-4">Klik 'Pilih Kursi' pada form penumpang, lalu klik kursi di bawah ini.</p>
            
            <div class="bg-slate-50 p-4 rounded-3xl border-2 border-slate-200 flex flex-col items-center max-h-[500px] overflow-y-auto">
                <div class="w-16 h-16 rounded-t-full bg-slate-200 mb-8 border-t-4 border-slate-300"></div>

                @php
                    $occ = $occupiedSeats;
                    $rows = [
                        ['range' => [1,2], 'class' => 'first_class', 'layout' => ['A', 'C', '', 'D', 'F']],
                        ['range' => [3,5], 'class' => 'business', 'layout' => ['A', 'C', '', 'D', 'F']],
                        ['range' => [6,15], 'class' => 'economy', 'layout' => ['A', 'B', 'C', '', 'D', 'E', 'F']],
                    ];
                @endphp

                @foreach($rows as $group)
                    <div class="w-full mb-6">
                        <p class="text-center text-[10px] text-slate-400 font-bold uppercase mb-2">{{ $group['class'] }}</p>
                        @for($r = $group['range'][0]; $r <= $group['range'][1]; $r++)
                            <div class="flex justify-center gap-1 mb-2">
                                <div class="w-5 flex items-center justify-center text-[10px] text-slate-400 font-bold">{{ $r }}</div>
                                @foreach($group['layout'] as $col)
                                    @if($col === '')
                                        <div class="w-3"></div>
                                    @else
                                        @php $seatId = $r . $col; $isTaken = in_array($seatId, $occ); @endphp
                                        <div class="seat {{ $group['class'] }} {{ $isTaken ? 'taken' : '' }}" 
                                             data-seat="{{ $seatId }}" 
                                             data-class="{{ $group['class'] }}"
                                             onclick="selectSeat(this)">{{ $col }}</div>
                                    @endif
                                @endforeach
                            </div>
                        @endfor
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</form>
@endif

@endsection

@if($selectedFlight)
@push('scripts')
<script>
    let pCount = 0;
    let activePid = null;
    let pData = {};

    function addPassenger() {
        let pid = pCount++;
        pData[pid] = { seat: null, class: null };
        
        let html = `
        <div class="p-4 border border-slate-200 rounded-lg mb-4 bg-slate-50 passenger-item" data-pid="${pid}">
            <div class="flex justify-between items-center mb-3">
                <select name="passengers[${pid}][passenger_type]" class="px-2 py-1 border border-slate-300 rounded text-xs font-semibold bg-white" onchange="toggleSeatReq(${pid}, this.value)">
                    <option value="adult">Dewasa</option>
                    <option value="child">Anak</option>
                    <option value="infant">Bayi</option>
                </select>
                <div>
                    <span class="seat-badge hidden px-2 py-1 text-xs font-bold rounded bg-emerald-100 text-emerald-700 mr-2">Kursi: <span class="seat-display"></span></span>
                    <button type="button" class="btn-seat px-2 py-1 bg-amber-100 text-amber-700 text-xs rounded" onclick="activateSeat(${pid})">Pilih Kursi</button>
                    <button type="button" class="px-2 py-1 text-red-500 text-xs hover:bg-red-50 rounded ml-2" onclick="removePassenger(${pid})">Hapus</button>
                </div>
            </div>
            
            <input type="hidden" name="passengers[${pid}][seat_number]" class="input-seat">
            <input type="hidden" name="passengers[${pid}][seat_class]" class="input-class">

            <div class="grid grid-cols-2 gap-3">
                <input type="text" name="passengers[${pid}][full_name]" placeholder="Nama Lengkap" required class="px-3 py-1.5 border border-slate-200 rounded text-sm w-full">
                <select name="passengers[${pid}][gender]" required class="px-3 py-1.5 border border-slate-200 rounded text-sm w-full">
                    <option value="male">Laki-laki</option>
                    <option value="female">Perempuan</option>
                </select>
                <input type="date" name="passengers[${pid}][birth_date]" required class="px-3 py-1.5 border border-slate-200 rounded text-sm w-full">
                <input type="text" name="passengers[${pid}][passport_number]" placeholder="Paspor (Opsional)" class="px-3 py-1.5 border border-slate-200 rounded text-sm w-full">
            </div>
        </div>`;
        
        document.getElementById('passengerContainer').insertAdjacentHTML('beforeend', html);
    }

    function toggleSeatReq(pid, type) {
        let card = document.querySelector(`.passenger-item[data-pid="${pid}"]`);
        if(type === 'infant') {
            card.querySelector('.btn-seat').style.display = 'none';
            card.querySelector('.seat-badge').classList.add('hidden');
            card.querySelector('.input-seat').value = '';
            card.querySelector('.input-class').value = '';
            if(pData[pid].seat) {
                document.querySelector(`.seat[data-seat="${pData[pid].seat}"]`).classList.remove('selected');
                pData[pid].seat = null;
            }
        } else {
            card.querySelector('.btn-seat').style.display = 'inline-block';
        }
    }

    function removePassenger(pid) {
        if(pData[pid].seat) {
            document.querySelector(`.seat[data-seat="${pData[pid].seat}"]`).classList.remove('selected');
        }
        delete pData[pid];
        document.querySelector(`.passenger-item[data-pid="${pid}"]`).remove();
    }

    function activateSeat(pid) {
        activePid = pid;
        document.querySelectorAll('.passenger-item').forEach(el => el.classList.remove('border-amber-500', 'ring-1', 'ring-amber-500'));
        document.querySelector(`.passenger-item[data-pid="${pid}"]`).classList.add('border-amber-500', 'ring-1', 'ring-amber-500');
    }

    function selectSeat(el) {
        if(el.classList.contains('taken')) return;
        if(activePid === null) return alert('Pilih penumpang dulu!');

        let sId = el.dataset.seat;
        let sClass = el.dataset.class;

        for(let p in pData) {
            if(pData[p].seat === sId && p != activePid) {
                pData[p].seat = null;
                updateCard(p);
            }
        }

        pData[activePid].seat = sId;
        pData[activePid].class = sClass;
        updateCard(activePid);

        document.querySelectorAll('.seat').forEach(s => {
            let owned = Object.values(pData).find(x => x.seat === s.dataset.seat);
            if(owned) s.classList.add('selected');
            else s.classList.remove('selected');
        });
    }

    function updateCard(pid) {
        let card = document.querySelector(`.passenger-item[data-pid="${pid}"]`);
        if(pData[pid].seat) {
            card.querySelector('.input-seat').value = pData[pid].seat;
            card.querySelector('.input-class').value = pData[pid].class;
            card.querySelector('.seat-badge').classList.remove('hidden');
            card.querySelector('.seat-display').textContent = pData[pid].seat;
        } else {
            card.querySelector('.input-seat').value = '';
            card.querySelector('.input-class').value = '';
            card.querySelector('.seat-badge').classList.add('hidden');
        }
    }

    // Add first default passenger
    addPassenger();
</script>
@endpush
@endif
