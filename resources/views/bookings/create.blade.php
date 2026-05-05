@extends('layouts.app')
@section('title', 'Pesan Tiket - Indirasanti Flight')

@push('styles')
<style>
    .seat { width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold; cursor: pointer; transition: all 0.2s; border: 2px solid transparent; }
    .seat.economy { background-color: #fef3c7; color: #b45309; border-color: #fde68a; } /* amber-100 */
    .seat.business { background-color: #dbeafe; color: #1d4ed8; border-color: #bfdbfe; } /* blue-100 */
    .seat.first_class { background-color: #f3e8ff; color: #7e22ce; border-color: #e9d5ff; } /* purple-100 */
    
    .seat:hover:not(.taken) { filter: brightness(0.9); }
    .seat.taken { background-color: #e5e7eb; color: #9ca3af; border-color: #e5e7eb; cursor: not-allowed; text-decoration: line-through; }
    .seat.selected { background-color: #10b981; color: white; border-color: #059669; } /* emerald-500 */
    
    .passenger-card.active-seat-selection { border-color: #10b981; box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2); }
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="mb-8">
        <p class="text-amber-600 text-xs uppercase tracking-widest mb-1">Langkah 1 dari 2</p>
        <h1 class="font-display text-3xl font-semibold text-amber-900">Isi Data Penumpang & Kursi</h1>
    </div>

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
        <p class="text-red-700 text-sm">{{ session('error') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                @csrf
                <input type="hidden" name="flight_id" value="{{ $flight->id }}">

                @php $pIndex = 0; @endphp

                {{-- Adults --}}
                @for($i = 0; $i < $adults; $i++)
                <div class="passenger-card bg-white rounded-xl border border-amber-200 p-6 mb-5 transition-all" data-pid="{{ $pIndex }}" data-type="adult">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="font-display text-lg font-semibold text-amber-900">Dewasa {{ $i + 1 }}</h3>
                        <div class="text-right">
                            <span class="seat-badge hidden px-2 py-1 text-xs font-bold rounded bg-emerald-100 text-emerald-700">Kursi: <span class="seat-display"></span></span>
                            <button type="button" class="btn-select-seat px-3 py-1.5 text-xs font-medium text-amber-700 bg-amber-50 border border-amber-200 rounded hover:bg-amber-100" onclick="activateSeatSelection({{ $pIndex }})">Pilih Kursi</button>
                        </div>
                    </div>
                    
                    <input type="hidden" name="passengers[{{ $pIndex }}][passenger_type]" value="adult">
                    <input type="hidden" name="passengers[{{ $pIndex }}][seat_number]" class="input-seat-number" required>
                    <input type="hidden" name="passengers[{{ $pIndex }}][seat_class]" class="input-seat-class" required>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-amber-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="passengers[{{ $pIndex }}][full_name]" required class="w-full px-3 py-2 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-amber-700 mb-1.5">Jenis Kelamin</label>
                            <select name="passengers[{{ $pIndex }}][gender]" required class="w-full px-3 py-2 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-amber-700 mb-1.5">Tanggal Lahir (>12 thn)</label>
                            <input type="date" name="passengers[{{ $pIndex }}][birth_date]" required class="w-full px-3 py-2 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                        </div>
                    </div>
                </div>
                @php $pIndex++; @endphp
                @endfor

                {{-- Children --}}
                @for($i = 0; $i < $children; $i++)
                <div class="passenger-card bg-white rounded-xl border border-amber-200 p-6 mb-5 transition-all" data-pid="{{ $pIndex }}" data-type="child">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="font-display text-lg font-semibold text-amber-900">Anak {{ $i + 1 }} <span class="text-xs font-normal text-amber-500">(2-11 thn)</span></h3>
                        <div class="text-right">
                            <span class="seat-badge hidden px-2 py-1 text-xs font-bold rounded bg-emerald-100 text-emerald-700">Kursi: <span class="seat-display"></span></span>
                            <button type="button" class="btn-select-seat px-3 py-1.5 text-xs font-medium text-amber-700 bg-amber-50 border border-amber-200 rounded hover:bg-amber-100" onclick="activateSeatSelection({{ $pIndex }})">Pilih Kursi</button>
                        </div>
                    </div>
                    
                    <input type="hidden" name="passengers[{{ $pIndex }}][passenger_type]" value="child">
                    <input type="hidden" name="passengers[{{ $pIndex }}][seat_number]" class="input-seat-number" required>
                    <input type="hidden" name="passengers[{{ $pIndex }}][seat_class]" class="input-seat-class" required>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-amber-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="passengers[{{ $pIndex }}][full_name]" required class="w-full px-3 py-2 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-amber-700 mb-1.5">Jenis Kelamin</label>
                            <select name="passengers[{{ $pIndex }}][gender]" required class="w-full px-3 py-2 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-amber-700 mb-1.5">Tanggal Lahir (2-11 thn)</label>
                            <input type="date" name="passengers[{{ $pIndex }}][birth_date]" required class="w-full px-3 py-2 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                        </div>
                    </div>
                </div>
                @php $pIndex++; @endphp
                @endfor

                {{-- Infants --}}
                @for($i = 0; $i < $infants; $i++)
                <div class="passenger-card bg-amber-50 rounded-xl border border-amber-200 p-6 mb-5" data-pid="{{ $pIndex }}" data-type="infant">
                    <h3 class="font-display text-lg font-semibold text-amber-900 mb-5">Bayi {{ $i + 1 }} <span class="text-xs font-normal text-amber-500">(<2 thn, tanpa kursi)</span></h3>
                    
                    <input type="hidden" name="passengers[{{ $pIndex }}][passenger_type]" value="infant">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-amber-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="passengers[{{ $pIndex }}][full_name]" required class="w-full px-3 py-2 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-amber-700 mb-1.5">Jenis Kelamin</label>
                            <select name="passengers[{{ $pIndex }}][gender]" required class="w-full px-3 py-2 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 bg-white">
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-amber-700 mb-1.5">Tanggal Lahir (<2 thn)</label>
                            <input type="date" name="passengers[{{ $pIndex }}][birth_date]" required class="w-full px-3 py-2 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 bg-white">
                        </div>
                    </div>
                </div>
                @php $pIndex++; @endphp
                @endfor

                <div class="flex items-center justify-between mt-8">
                    <a href="javascript:history.back()" class="px-6 py-2.5 border border-amber-300 text-amber-700 text-sm font-medium rounded-lg hover:bg-amber-50 transition-all">Kembali</a>
                    <button type="submit" id="btnSubmit" class="px-8 py-2.5 text-white text-sm font-medium rounded-lg opacity-50 cursor-not-allowed transition-all" style="background: linear-gradient(135deg,#C8A97E,#A8855A);" disabled>
                        Lanjutkan ke Pembayaran →
                    </button>
                </div>
            </form>
        </div>

        {{-- Sidebar: Seat Map & Price --}}
        <div class="space-y-6">
            {{-- Price Summary --}}
            <div class="bg-white rounded-xl border border-amber-200 p-5 sticky top-4">
                <p class="text-xs font-medium text-amber-600 uppercase tracking-wide mb-3">Total Biaya</p>
                <div id="priceBreakdown" class="space-y-2 text-sm text-amber-800 mb-4 pb-4 border-b border-amber-100">
                    <!-- Javascript will populate this -->
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-bold text-amber-900">Total Harga</span>
                    <span class="font-display text-2xl font-bold text-amber-800" id="totalPriceDisplay">Rp 0</span>
                </div>
            </div>

            {{-- Seat Map --}}
            <div class="bg-white rounded-xl border border-amber-200 p-5">
                <div class="flex justify-between items-center mb-4">
                    <p class="text-xs font-medium text-amber-600 uppercase tracking-wide">Pilih Kursi</p>
                    <span id="activeSelectionLabel" class="text-xs font-bold text-emerald-600 hidden">Memilih untuk: Dewasa 1</span>
                </div>

                {{-- Legend --}}
                <div class="flex flex-wrap gap-2 mb-6 text-[10px] uppercase font-bold text-amber-800">
                    <div class="flex items-center gap-1"><div class="w-3 h-3 rounded bg-[#fef3c7] border border-[#fde68a]"></div> Economy (1x)</div>
                    <div class="flex items-center gap-1"><div class="w-3 h-3 rounded bg-[#dbeafe] border border-[#bfdbfe]"></div> Business (1.25x)</div>
                    <div class="flex items-center gap-1"><div class="w-3 h-3 rounded bg-[#f3e8ff] border border-[#e9d5ff]"></div> First Class (1.75x)</div>
                    <div class="flex items-center gap-1"><div class="w-3 h-3 rounded bg-[#e5e7eb]"></div> Taken</div>
                </div>

                {{-- Plane Body --}}
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
                                    <div class="w-6 flex items-center justify-center text-xs text-slate-400 font-bold">{{ $r }}</div>
                                    @foreach($group['layout'] as $col)
                                        @if($col === '')
                                            <div class="w-4"></div> {{-- Aisle --}}
                                        @else
                                            @php 
                                                $seatId = $r . $col; 
                                                $isTaken = in_array($seatId, $occ);
                                            @endphp
                                            <div class="seat {{ $group['class'] }} {{ $isTaken ? 'taken' : '' }}" 
                                                 data-seat="{{ $seatId }}" 
                                                 data-class="{{ $group['class'] }}"
                                                 onclick="selectSeat(this)">
                                                {{ $col }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endfor
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const basePrice = {{ $flight->price }};
    const multipliers = { economy: 1.0, business: 1.25, first_class: 1.75 };
    const ageMultipliers = { adult: 1.0, child: 0.75, infant: 0.10 }; // infant uses basePrice * 0.10 directly
    
    let activePid = null;
    let passengerData = {}; // pid -> { type, seat, class, price }

    // Initialize passenger data
    document.querySelectorAll('.passenger-card').forEach(card => {
        let pid = card.dataset.pid;
        let type = card.dataset.type;
        passengerData[pid] = { type: type, seat: null, class: null, price: 0 };
        
        if(type === 'infant') {
            passengerData[pid].price = basePrice * ageMultipliers.infant; // Infant fixed price
        }
    });

    function activateSeatSelection(pid) {
        document.querySelectorAll('.passenger-card').forEach(c => c.classList.remove('active-seat-selection'));
        document.querySelector(`.passenger-card[data-pid="${pid}"]`).classList.add('active-seat-selection');
        
        activePid = pid;
        let typeText = passengerData[pid].type === 'adult' ? 'Dewasa' : 'Anak';
        document.getElementById('activeSelectionLabel').textContent = `Memilih untuk: ${typeText}`;
        document.getElementById('activeSelectionLabel').classList.remove('hidden');
    }

    function selectSeat(element) {
        if(element.classList.contains('taken')) return;
        if(activePid === null) {
            alert('Pilih penumpang terlebih dahulu dengan klik tombol "Pilih Kursi" di form penumpang.');
            return;
        }

        let seatId = element.dataset.seat;
        let seatClass = element.dataset.class;

        // Check if seat already selected by another passenger
        for(let p in passengerData) {
            if(passengerData[p].seat === seatId && p !== activePid) {
                // Clear old owner
                passengerData[p].seat = null;
                passengerData[p].class = null;
                passengerData[p].price = 0;
                updatePassengerCard(p);
            }
        }

        // Assign to active passenger
        passengerData[activePid].seat = seatId;
        passengerData[activePid].class = seatClass;
        passengerData[activePid].price = basePrice * multipliers[seatClass] * ageMultipliers[passengerData[activePid].type];

        // Update UI
        document.querySelectorAll('.seat').forEach(s => {
            if(s.dataset.seat === seatId) s.classList.add('selected');
            else {
                // check if owned by someone else
                let owned = false;
                for(let p in passengerData) {
                    if(passengerData[p].seat === s.dataset.seat) owned = true;
                }
                if(!owned) s.classList.remove('selected');
            }
        });

        updatePassengerCard(activePid);
        updatePriceDisplay();
        checkFormValidity();
        
        // Auto select next passenger without seat
        let nextPid = null;
        for(let p in passengerData) {
            if(passengerData[p].type !== 'infant' && !passengerData[p].seat) {
                nextPid = p; break;
            }
        }
        if(nextPid !== null) activateSeatSelection(nextPid);
        else {
            activePid = null;
            document.querySelectorAll('.passenger-card').forEach(c => c.classList.remove('active-seat-selection'));
            document.getElementById('activeSelectionLabel').classList.add('hidden');
        }
    }

    function updatePassengerCard(pid) {
        let card = document.querySelector(`.passenger-card[data-pid="${pid}"]`);
        let seat = passengerData[pid].seat;
        let sClass = passengerData[pid].class;
        
        if(seat) {
            card.querySelector('.input-seat-number').value = seat;
            card.querySelector('.input-seat-class').value = sClass;
            card.querySelector('.seat-badge').classList.remove('hidden');
            card.querySelector('.seat-display').textContent = seat + ' (' + sClass.toUpperCase() + ')';
            card.querySelector('.btn-select-seat').textContent = 'Ubah Kursi';
        } else {
            card.querySelector('.input-seat-number').value = '';
            card.querySelector('.input-seat-class').value = '';
            card.querySelector('.seat-badge').classList.add('hidden');
            card.querySelector('.btn-select-seat').textContent = 'Pilih Kursi';
        }
    }

    function updatePriceDisplay() {
        let breakdownHTML = '';
        let total = 0;
        
        for(let p in passengerData) {
            let pd = passengerData[p];
            if(pd.type === 'infant') {
                breakdownHTML += `<div class="flex justify-between"><span>Bayi</span><span>Rp ${new Intl.NumberFormat('id-ID').format(pd.price)}</span></div>`;
                total += pd.price;
            } else if(pd.seat) {
                let typeLabel = pd.type === 'adult' ? 'Dewasa' : 'Anak';
                breakdownHTML += `<div class="flex justify-between"><span>${typeLabel} (${pd.class})</span><span>Rp ${new Intl.NumberFormat('id-ID').format(pd.price)}</span></div>`;
                total += pd.price;
            }
        }
        
        document.getElementById('priceBreakdown').innerHTML = breakdownHTML || '<p class="text-slate-400 italic">Pilih kursi untuk melihat harga</p>';
        document.getElementById('totalPriceDisplay').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }

    function checkFormValidity() {
        let allValid = true;
        for(let p in passengerData) {
            if(passengerData[p].type !== 'infant' && !passengerData[p].seat) {
                allValid = false;
            }
        }
        
        const btn = document.getElementById('btnSubmit');
        if(allValid) {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    // Init
    updatePriceDisplay();
    // Auto active first adult
    for(let p in passengerData) {
        if(passengerData[p].type !== 'infant') {
            activateSeatSelection(p); break;
        }
    }
</script>
@endpush
