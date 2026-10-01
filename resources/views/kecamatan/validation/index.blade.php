@extends('kecamatan.layouts.app')

@section('title', 'Validasi Laporan - Pemeriksaan & Disposisi Aduan Warga')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- BREADCRUMB & HEADER -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 pb-6 border-b border-slate-200">
        <div>
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1">
                <a href="{{ route('kecamatan.dashboard') }}" class="hover:text-slate-700 transition-colors">Halaman Utama</a>
                <span>/</span>
                <span class="text-slate-800">Validasi Laporan Masuk</span>
            </nav>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Pemeriksaan & Disposisi Aduan Warga
                </h1>
                <span class="text-[10px] font-extrabold uppercase px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-300">
                    UNIT KONTROL EKBANG
                </span>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Validasi kelayakan data laporan, keabsahan foto bukti lapangan, dan koordinasi disposisi teknis perbaikan ke UPT Dinas PUPR.
            </p>
        </div>

        <!-- Top Right KPI Badges -->
        <div class="flex items-center gap-3 shrink-0">
            <div class="bg-white border border-slate-200 rounded-xl px-4 py-2 text-right shadow-2xs">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Skor Akurasi Validasi</p>
                <p class="text-lg font-black text-emerald-600">{{ $accuracyScore }}%</p>
            </div>
            <div class="bg-white border border-red-200 rounded-xl px-4 py-2 text-right shadow-2xs bg-red-50/40">
                <p class="text-[10px] font-bold uppercase tracking-wider text-red-500">Antrean Aktif Hari Ini</p>
                <p class="text-lg font-black text-red-600">{{ $activeQueueToday }} Aduan</p>
            </div>
        </div>
    </div>

    <!-- MAIN TWO-COLUMN VALIDATION WORKSPACE -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 mt-6">
        
        <!-- ==================== LEFT COLUMN: QUEUE & FILTERS (4 COLS) ==================== -->
        <div class="lg:col-span-4 flex flex-col gap-4">
            
            <!-- Live Search Bar -->
            <form action="{{ route('kecamatan.validation.index') }}" method="GET" class="relative">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}" 
                           placeholder="Cari id laporan, jalan, pelapor..." 
                           class="w-full pl-9 pr-4 py-2 text-xs font-semibold text-slate-800 bg-white border border-slate-200 rounded-xl shadow-2xs focus:outline-none focus:border-brand-500">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </form>

            <!-- Filter Tabs Pills -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 custom-scrollbar text-xs">
                <a href="{{ route('kecamatan.validation.index', ['tab' => 'all', 'search' => $search]) }}" 
                   class="px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $tab == 'all' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100' }}">
                    Semua ({{ $allCount }})
                </a>
                <a href="{{ route('kecamatan.validation.index', ['tab' => 'high', 'search' => $search]) }}" 
                   class="px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $tab == 'high' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100' }}">
                    Bahaya Tinggi ({{ $highCount }})
                </a>
                <a href="{{ route('kecamatan.validation.index', ['tab' => 'pending', 'search' => $search]) }}" 
                   class="px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $tab == 'pending' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100' }}">
                    Perlu Verifikasi ({{ $pendingCount }})
                </a>
                <a href="{{ route('kecamatan.validation.index', ['tab' => 'resolved', 'search' => $search]) }}" 
                   class="px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $tab == 'resolved' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100' }}">
                    Selesai/Ditolak ({{ $resolvedCount }})
                </a>
            </div>

            <!-- TICKET QUEUE LIST -->
            <div class="flex flex-col gap-3 max-h-[750px] overflow-y-auto pr-1 custom-scrollbar">
                @forelse($tickets as $t)
                @php
                    $isActive = $activeTicket && $activeTicket->id_laporan === $t->id_laporan;
                    $badgeClass = $t->tingkat_bahaya === 'Bahaya Tinggi'
                        ? 'bg-red-500 text-white'
                        : ($t->tingkat_bahaya === 'Sedang' ? 'bg-amber-500 text-white' : 'bg-emerald-600 text-white');
                @endphp
                <a href="{{ route('kecamatan.validation.index', ['ticket' => $t->id_laporan, 'tab' => $tab, 'search' => $search]) }}" 
                   class="p-4 rounded-2xl border transition-all text-left block relative {{ $isActive ? 'bg-emerald-50/40 border-emerald-500 shadow-sm ring-1 ring-emerald-500' : 'bg-white border-slate-200 hover:border-slate-300 hover:shadow-2xs' }}">
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <span class="font-mono text-xs font-bold text-slate-900">#{{ $t->id_laporan }}</span>
                            <span class="text-[10px] text-slate-400 font-medium">
                                {{ $t->kategori->nama_kategori ?? '-' }}
                            </span>
                        </div>
                        <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-full {{ $badgeClass }}">
                            {{ $t->tingkat_bahaya }}
                        </span>
                    </div>

                    <h4 class="text-xs font-bold text-slate-900 mt-2 truncate">
                        {{ $t->jalan->nama_jalan ?? 'Jalan tidak diketahui' }}
                    </h4>

                    <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">
                        {{ Str::limit($t->deskripsi, 60) }}
                    </p>

                    <div class="flex items-center justify-between text-[10px] text-slate-400 font-medium mt-2.5 pt-2 border-t border-slate-100">
                        <span class="truncate max-w-[130px]">
                            <i class="fa-regular fa-user mr-1"></i>{{ $t->pengguna->nama_lengkap ?? '-' }}
                        </span>
                        <span>{{ $t->created_at ? $t->created_at->format('d M Y, H:i') . ' WIB' : 'Hari ini' }}</span>
                    </div>

                    @if($isActive)
                        <div class="absolute -left-1 top-4 bottom-4 w-1 bg-emerald-600 rounded-r"></div>
                    @endif
                </a>
                @empty
                <div class="p-6 bg-white rounded-2xl border border-slate-200 text-center text-xs text-slate-500">
                    Tidak ada laporan pada antrean ini.
                </div>
                @endforelse
            </div>

            <!-- SLA POLICY HELPER BOX -->
            <div class="bg-amber-50 border border-amber-200/80 rounded-2xl p-4 text-xs">
                <div class="flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-info text-amber-600 mt-0.5 text-sm"></i>
                    <div>
                        <h4 class="font-bold text-amber-900 leading-tight">Kebijakan Respon Cepat Kecamatan:</h4>
                        <p class="text-amber-800 text-[11px] leading-relaxed mt-1">
                            Laporan berstatus Bahaya Tinggi wajib diputuskan dalam tempo <span class="font-bold underline">&lt; 2 jam</span> sejak laporan masuk guna menjamin respon darurat pemeliharaan PUPR.
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- ==================== RIGHT COLUMN: TICKET INSPECTION & DISPOSITION (8 COLS) ==================== -->
        <div class="lg:col-span-8 flex flex-col gap-6">
            
            @if($activeTicket)
            <!-- TICKET HEADER -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="text-lg sm:text-xl font-extrabold text-slate-900">
                            Detail Laporan <span class="font-mono text-brand-600">#{{ $activeTicket->id_laporan }}</span>
                        </h2>
                        @php
                            $statusClass = match($activeTicket->id_status) {
                                2 => 'bg-emerald-100 text-emerald-800 border border-emerald-300',
                                4 => 'bg-red-100 text-red-800',
                                default => 'bg-amber-100 text-amber-800 border border-amber-300',
                            };
                        @endphp
                        <span class="text-[10px] font-bold uppercase px-2.5 py-0.5 rounded-full {{ $statusClass }}">
                            {{ $activeTicket->status->nama_status ?? 'Menunggu Validasi' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium mt-1">
                        Kategori: <strong class="text-slate-700">{{ $activeTicket->kategori->nama_kategori ?? '-' }}</strong>
                        • Jalan: {{ $activeTicket->jalan->nama_jalan ?? '-' }}
                        • Desa: {{ $activeTicket->jalan->desa->nama_desa ?? '-' }}
                    </p>
                </div>

                <!-- Share Actions -->
                <div class="flex items-center gap-2">
                    <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan berhasil disalin!');" 
                            class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition-colors" 
                            title="Bagikan Tautan">
                        <i class="fa-solid fa-share-nodes text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- SECTION 1: PEMERIKSAAN BUKTI LAPANGAN -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
                
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-md bg-blue-100 text-blue-600 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-camera-retro"></i>
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900">Pemeriksaan Bukti Lapangan & Validasi Warga</h3>
                    </div>
                    <span class="text-[10px] font-mono font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded-full flex items-center gap-1">
                        <i class="fa-solid fa-circle-check text-[10px]"></i>
                        <span>{{ $activeTicket->tingkat_bahaya }}</span>
                    </span>
                </div>

                <!-- Media Comparison: Photo Evidence + Interactive GIS Map -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- Left: Citizen Photo Evidence -->
                    <div class="relative rounded-xl overflow-hidden bg-slate-100 border border-slate-200 group h-64">
                        @if($activeTicket->url_foto)
                            <img src="{{ asset('storage/' . $activeTicket->url_foto) }}" 
                                 alt="Bukti foto jalan rusak" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 flex-col gap-2">
                                <i class="fa-solid fa-image text-3xl"></i>
                                <span class="text-xs font-semibold">Tidak ada foto</span>
                            </div>
                        @endif
                        <div class="absolute bottom-2 left-2 right-2 bg-slate-950/80 backdrop-blur-xs text-white text-[10px] font-mono px-2.5 py-1.5 rounded flex items-center justify-between">
                            <span>{{ $activeTicket->created_at ? $activeTicket->created_at->format('d M Y - H:i') : 'Hari ini' }} WIB</span>
                            @if($activeTicket->latitude && $activeTicket->longitude)
                                <span class="text-emerald-400 font-bold">GPS Valid</span>
                            @else
                                <span class="text-amber-400 font-bold">Tanpa GPS</span>
                            @endif
                        </div>
                    </div>

                    <!-- Right: Interactive Leaflet GIS Map -->
                    <div class="relative rounded-xl overflow-hidden border border-slate-200 h-64">
                        @if($activeTicket->latitude && $activeTicket->longitude)
                            <div id="ticketMap" class="w-full h-full z-10"></div>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 flex-col gap-2 bg-slate-50">
                                <i class="fa-solid fa-map-location-dot text-3xl"></i>
                                <span class="text-xs font-semibold">Koordinat GPS tidak tersedia</span>
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Reporter Identity Card -->
                <div class="mt-4 p-4 bg-slate-50 border border-slate-200 rounded-xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-800 text-white font-bold flex items-center justify-center shrink-0 text-xs">
                            {{ strtoupper(substr($activeTicket->pengguna->nama_lengkap ?? 'WA', 0, 2)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="text-xs font-bold text-slate-900">{{ $activeTicket->pengguna->nama_lengkap ?? '-' }}</h4>
                                <span class="text-[9px] font-semibold bg-emerald-100 text-emerald-800 px-1.5 py-0.2 rounded border border-emerald-300">
                                    Warga Terdaftar
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-0.5">
                                Email: {{ $activeTicket->pengguna->email ?? '-' }} 
                                • Telepon: {{ $activeTicket->pengguna->telepon ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="text-left sm:text-right shrink-0">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Dilaporkan</span>
                        <span class="text-xs font-extrabold text-slate-700 bg-slate-100 px-2 py-0.5 rounded border border-slate-200 inline-block mt-0.5">
                            {{ $activeTicket->created_at ? $activeTicket->created_at->format('d M Y, H:i') . ' WIB' : '-' }}
                        </span>
                    </div>
                </div>

                <!-- Citizen Description Text -->
                <div class="mt-4">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                        DESKRIPSI LAPORAN MASUK OLEH WARGA
                    </span>
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 italic leading-relaxed">
                        "{{ $activeTicket->deskripsi }}"
                    </div>
                </div>

            </div>

            <!-- SECTION 2: KEPUTUSAN VERIFIKATOR KECAMATAN (FORM DISPOSISI) -->
            @if($activeTicket->id_status == 1)
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs" x-data="{ decisionAction: 'acc', charCount: 0 }">
                
                <div class="border-b border-slate-200 pb-3">
                    <h3 class="text-sm font-extrabold text-slate-900">Keputusan Verifikator Kecamatan</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Tentukan disposisi status aduan ini untuk diteruskan ke Dinas PUPR Kabupaten Jember.</p>
                </div>

                <form action="{{ route('kecamatan.validation.update', $activeTicket->id_laporan) }}" method="POST" class="mt-4 flex flex-col gap-5">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="action" :value="decisionAction">

                    <!-- Option Cards (ACC vs REJECT) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <!-- Option 1: ACC -->
                        <div @click="decisionAction = 'acc'" 
                             :class="decisionAction === 'acc' ? 'border-emerald-500 bg-emerald-50/50 ring-2 ring-emerald-500' : 'border-slate-200 bg-white hover:border-slate-300'"
                             class="p-4 rounded-xl border cursor-pointer transition-all flex flex-col justify-between">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold" :class="decisionAction === 'acc' ? 'text-emerald-900' : 'text-slate-800'">
                                    ACC — Teruskan ke PUPR
                                </span>
                                <div class="w-5 h-5 rounded-full flex items-center justify-center border" 
                                     :class="decisionAction === 'acc' ? 'bg-emerald-600 border-emerald-600 text-white' : 'border-slate-300 bg-white'">
                                    <i class="fa-solid fa-check text-[10px]" x-show="decisionAction === 'acc'"></i>
                                </div>
                            </div>
                            <p class="text-[11px] text-slate-500 leading-relaxed mt-2">
                                Laporan valid dan memenuhi syarat teknis. Diteruskan ke UPT PUPR Kabupaten Jember.
                            </p>
                        </div>

                        <!-- Option 2: Reject -->
                        <div @click="decisionAction = 'reject'" 
                             :class="decisionAction === 'reject' ? 'border-red-500 bg-red-50/50 ring-2 ring-red-500' : 'border-slate-200 bg-white hover:border-slate-300'"
                             class="p-4 rounded-xl border cursor-pointer transition-all flex flex-col justify-between">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold" :class="decisionAction === 'reject' ? 'text-red-900' : 'text-slate-800'">
                                    REJECT — Tolak Aduan Warga
                                </span>
                                <div class="w-5 h-5 rounded-full flex items-center justify-center border" 
                                     :class="decisionAction === 'reject' ? 'bg-red-600 border-red-600 text-white' : 'border-slate-300 bg-white'">
                                    <i class="fa-solid fa-xmark text-[10px]" x-show="decisionAction === 'reject'"></i>
                                </div>
                            </div>
                            <p class="text-[11px] text-slate-500 leading-relaxed mt-2">
                                Laporan duplikat, tidak relevan, di luar kewenangan kabupaten, atau data bukti tidak konklusif.
                            </p>
                        </div>

                    </div>

                    <!-- Textarea Catatan -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700">
                                Catatan Verifikator Kecamatan
                            </label>
                            <span class="text-[10px] text-slate-400 font-mono">
                                <span x-text="charCount"></span> karakter
                            </span>
                        </div>
                        <textarea name="catatan" 
                                  rows="3" 
                                  @input="charCount = $el.value.length"
                                  class="w-full text-xs font-medium text-slate-800 bg-white border border-slate-300 rounded-xl p-3 focus:outline-none focus:border-brand-500 leading-relaxed"
                                  placeholder="Tuliskan catatan teknis dan arahan penanganan..."></textarea>
                    </div>

                    <!-- Digital Verification Badge -->
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-certificate text-emerald-600"></i>
                            <span class="text-slate-700">
                                Divalidasi oleh: <strong>{{ session('kecamatan_name', 'Admin Kecamatan') }}</strong>
                            </span>
                        </div>
                        <span class="text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded border border-emerald-300 shrink-0">
                            Otoritas Terverifikasi
                        </span>
                    </div>

                    <!-- Form Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-2">
                        
                        <button type="submit" 
                                @click="decisionAction = 'reject'" 
                                class="w-full sm:w-auto px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold rounded-xl border border-red-200 shadow-2xs transition-colors flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-xmark text-xs"></i>
                            <span>Tolak & Kembalikan ke Warga</span>
                        </button>

                        <button type="submit" 
                                @click="decisionAction = 'acc'" 
                                class="w-full sm:w-auto px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                            <span>Kirim Disposisi ACC ke Dinas PUPR</span>
                        </button>

                    </div>

                </form>

            </div>
            @else
            <!-- Sudah Divalidasi -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
                <div class="text-center py-6">
                    @if($activeTicket->id_status == 2)
                        <div class="w-14 h-14 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-2xl"></i>
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900">Laporan Telah Divalidasi & Diteruskan ke PUPR</h3>
                        <p class="text-xs text-slate-500 mt-1">Catatan: {{ $activeTicket->validasi->catatan ?? '-' }}</p>
                    @elseif($activeTicket->id_status == 4)
                        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-circle-xmark text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900">Laporan Ditolak</h3>
                        <p class="text-xs text-slate-500 mt-1">Alasan: {{ $activeTicket->validasi->catatan ?? '-' }}</p>
                    @else
                        <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-clock text-slate-500 text-2xl"></i>
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900">Status: {{ $activeTicket->status->nama_status ?? '-' }}</h3>
                    @endif
                </div>
            </div>
            @endif

            @else
            <!-- Empty State -->
            <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-xs flex flex-col items-center justify-center py-20 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fa-solid fa-inbox text-slate-400 text-2xl"></i>
                </div>
                <h3 class="text-base font-extrabold text-slate-700">Tidak ada laporan yang perlu divalidasi</h3>
                <p class="text-xs text-slate-400 mt-1">Semua laporan warga sudah diproses atau belum ada laporan masuk.</p>
            </div>
            @endif

        </div>

    </div>

</div>
@endsection

@push('scripts')
@if($activeTicket && $activeTicket->latitude && $activeTicket->longitude)
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const lat = {{ $activeTicket->latitude }};
        const lng = {{ $activeTicket->longitude }};
        
        const map = L.map('ticketMap', {
            zoomControl: false,
            attributionControl: false
        }).setView([lat, lng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        L.control.zoom({ position: 'bottomright' }).addTo(map);

        const marker = L.circleMarker([lat, lng], {
            radius: 9,
            fillColor: "#ef4444",
            color: "#ffffff",
            weight: 2,
            opacity: 1,
            fillOpacity: 0.95
        }).addTo(map);

        marker.bindPopup("<strong class='font-sans text-xs'>Laporan #{{ $activeTicket->id_laporan }}</strong><br><span class='text-[11px]'>{{ $activeTicket->jalan->nama_jalan ?? '' }}</span>").openPopup();
    });
</script>
@endif
@endpush
