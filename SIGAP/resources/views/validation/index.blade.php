@extends('layouts.app')

@section('title', 'Validasi Laporan - Pemeriksaan & Disposisi Aduan Warga')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- BREADCRUMB & HEADER -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 pb-6 border-b border-slate-200">
        <div>
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-slate-700 transition-colors">Halaman Utama</a>
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
            <form action="{{ route('validation.index') }}" method="GET" class="relative">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}" 
                           placeholder="Cari nomor aduan, jalan, pelapor..." 
                           class="w-full pl-9 pr-4 py-2 text-xs font-semibold text-slate-800 bg-white border border-slate-200 rounded-xl shadow-2xs focus:outline-none focus:border-brand-500">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </form>

            <!-- Filter Tabs Pills -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 custom-scrollbar text-xs">
                <a href="{{ route('validation.index', ['tab' => 'all', 'search' => $search]) }}" 
                   class="px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $tab == 'all' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100' }}">
                    Semua Antrean ({{ $allCount }})
                </a>
                <a href="{{ route('validation.index', ['tab' => 'high', 'search' => $search]) }}" 
                   class="px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $tab == 'high' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100' }}">
                    Kategori Tinggi ({{ $highCount }})
                </a>
                <a href="{{ route('validation.index', ['tab' => 'pending', 'search' => $search]) }}" 
                   class="px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $tab == 'pending' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100' }}">
                    Perlu Verifikasi ({{ $pendingCount }})
                </a>
                <a href="{{ route('validation.index', ['tab' => 'resolved', 'search' => $search]) }}" 
                   class="px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $tab == 'resolved' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100' }}">
                    Selesai ({{ $resolvedCount }})
                </a>
            </div>

            <!-- TICKET QUEUE LIST -->
            <div class="flex flex-col gap-3 max-h-[750px] overflow-y-auto pr-1 custom-scrollbar">
                @forelse($tickets as $t)
                @php
                    $isActive = $activeTicket && $activeTicket->id === $t->id;
                @endphp
                <a href="{{ route('validation.index', ['ticket' => $t->ticket_number, 'tab' => $tab, 'search' => $search]) }}" 
                   class="p-4 rounded-2xl border transition-all text-left block relative {{ $isActive ? 'bg-emerald-50/40 border-emerald-500 shadow-sm ring-1 ring-emerald-500' : 'bg-white border-slate-200 hover:border-slate-300 hover:shadow-2xs' }}">
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <span class="font-mono text-xs font-bold text-slate-900">{{ $t->ticket_number }}</span>
                            <span class="text-[10px] text-slate-400 font-medium">({{ $t->road_class }})</span>
                        </div>
                        <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-full {{ $t->urgency_badge }}">
                            {{ $t->urgency_label }}
                        </span>
                    </div>

                    <h4 class="text-xs font-bold text-slate-900 mt-2 truncate">
                        {{ $t->road_name }}
                    </h4>

                    <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">
                        {{ $t->title }}
                    </p>

                    <div class="flex items-center justify-between text-[10px] text-slate-400 font-medium mt-2.5 pt-2 border-t border-slate-100">
                        <span class="truncate max-w-[130px]"><i class="fa-regular fa-user mr-1"></i>{{ $t->reporter_name }}</span>
                        <span>{{ $t->created_at ? $t->created_at->format('d M Y, H:i') . ' WIB' : 'Hari ini' }}</span>
                    </div>

                    @if($isActive)
                        <div class="absolute -left-1 top-4 bottom-4 w-1 bg-emerald-600 rounded-r"></div>
                    @endif
                </a>
                @empty
                <div class="p-6 bg-white rounded-2xl border border-slate-200 text-center text-xs text-slate-500">
                    Tidak ada tiket pada antrean ini.
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
                            Detail Tiket <span class="font-mono text-brand-600">#{{ $activeTicket->ticket_number }}</span>
                        </h2>
                        <span class="text-[10px] font-bold uppercase px-2.5 py-0.5 rounded-full {{ $activeTicket->status == 'diteruskan_pupr' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : ($activeTicket->status == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800 border border-amber-300') }}">
                            {{ $activeTicket->status_label }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium mt-1">
                        Kategori: <strong class="text-slate-700">{{ $activeTicket->category }}</strong> • Ruas: {{ $activeTicket->road_class }}
                    </p>
                </div>

                <!-- Print & Share Actions -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('reports.print-bap', $activeTicket->id) }}" 
                       target="_blank"
                       class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition-colors" 
                       title="Cetak Berita Acara Pemeriksaan (BAP)">
                        <i class="fa-solid fa-print text-sm"></i>
                    </a>
                    <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan tiket berhasil disalin ke clipboard!');" 
                            class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition-colors" 
                            title="Bagikan Tautan Tiket">
                        <i class="fa-solid fa-share-nodes text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- SECTION 1: PEMERIKSAAN BUKTI LAPANGAN & VALIDASI WARGA -->
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
                        <span>GPS Akurat: Radius {{ $activeTicket->gps_accuracy_m }}m (99%)</span>
                    </span>
                </div>

                <!-- Media Comparison: Photo Evidence + Interactive GIS Map -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- Left: Citizen Photo Evidence -->
                    <div class="relative rounded-xl overflow-hidden bg-slate-100 border border-slate-200 group h-64">
                        <img src="{{ $activeTicket->photo_path }}" 
                             alt="Bukti foto jalan rusak" 
                             class="w-full h-full object-cover">
                        <div class="absolute bottom-2 left-2 right-2 bg-slate-950/80 backdrop-blur-xs text-white text-[10px] font-mono px-2.5 py-1.5 rounded flex items-center justify-between">
                            <span>{{ $activeTicket->created_at ? $activeTicket->created_at->format('d M Y - H:i') : 'Hari ini' }} WIB</span>
                            <span class="text-emerald-400 font-bold">Geo-tag Valid (Radius {{ $activeTicket->gps_accuracy_m }}m)</span>
                        </div>
                    </div>

                    <!-- Right: Interactive Leaflet GIS Map -->
                    <div class="relative rounded-xl overflow-hidden border border-slate-200 h-64">
                        <div id="ticketMap" class="w-full h-full z-10"></div>
                        <div class="absolute top-2 right-2 z-20">
                            <a href="{{ route('reports.gis-map') }}" 
                               class="bg-white/95 hover:bg-white text-slate-800 text-[10px] font-bold px-2.5 py-1 rounded shadow border border-slate-300 flex items-center gap-1 transition-all">
                                <i class="fa-solid fa-up-right-from-square"></i>
                                <span>Buka di Peta GIS Sepenuhnya</span>
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Reporter Identity Card -->
                <div class="mt-4 p-4 bg-slate-50 border border-slate-200 rounded-xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-800 text-white font-bold flex items-center justify-center shrink-0 text-xs">
                            {{ strtoupper(substr($activeTicket->reporter_name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="text-xs font-bold text-slate-900">{{ $activeTicket->reporter_name }}</h4>
                                <span class="text-[9px] font-semibold bg-emerald-100 text-emerald-800 px-1.5 py-0.2 rounded border border-emerald-300">
                                    Warga Terverifikasi NIK
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-500 font-mono mt-0.5">
                                NIK: {{ $activeTicket->masked_nik }} • No. Telp: {{ $activeTicket->reporter_phone }} • {{ $activeTicket->reporter_address }}
                            </p>
                        </div>
                    </div>

                    <div class="text-left sm:text-right shrink-0">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Skor Reputasi</span>
                        <span class="text-xs font-extrabold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 inline-block mt-0.5">
                            {{ $activeTicket->reporter_reputation }}/100 (Pelapor Sangat Valid)
                        </span>
                    </div>
                </div>

                <!-- Citizen Description Text -->
                <div class="mt-4">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                        DESKRIPSI LAPORAN MASUK OLEH WARGA
                    </span>
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 italic leading-relaxed">
                        "{{ $activeTicket->description }}"
                    </div>
                </div>

            </div>

            <!-- SECTION 2: KEPUTUSAN VERIFIKATOR KECAMATAN (FORM DISPOSISI) -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs" x-data="{ decisionAction: '{{ $activeTicket->decision ?? 'acc' }}', charCount: {{ strlen($activeTicket->verifier_notes ?? '') }} }">
                
                <div class="border-b border-slate-200 pb-3">
                    <h3 class="text-sm font-extrabold text-slate-900">Keputusan Verifikator Kecamatan</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Tentukan disposisi status aduan ini untuk diteruskan ke Dinas PUPR Kabupaten Jember.</p>
                </div>

                <form action="{{ route('validation.update', $activeTicket->id) }}" method="POST" class="mt-4 flex flex-col gap-5">
                    @csrf
                    <input type="hidden" name="action" :value="decisionAction">

                    <!-- Option Cards (ACC vs REJECT) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <!-- Option 1: ACC Teruskan ke PUPR -->
                        <div @click="decisionAction = 'acc'" 
                             :class="decisionAction === 'acc' ? 'border-emerald-500 bg-emerald-50/50 ring-2 ring-emerald-500' : 'border-slate-200 bg-white hover:border-slate-300'"
                             class="p-4 rounded-xl border cursor-pointer transition-all flex flex-col justify-between">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold" :class="decisionAction === 'acc' ? 'text-emerald-900' : 'text-slate-800'">
                                    ACC — Diteruskan: Teruskan ke PUPR
                                </span>
                                <div class="w-5 h-5 rounded-full flex items-center justify-center border" 
                                     :class="decisionAction === 'acc' ? 'bg-emerald-600 border-emerald-600 text-white' : 'border-slate-300 bg-white'">
                                    <i class="fa-solid fa-check text-[10px]" x-show="decisionAction === 'acc'"></i>
                                </div>
                            </div>
                            <p class="text-[11px] text-slate-500 leading-relaxed mt-2">
                                Laporan valid, memenuhi syarat teknis, dan direkomendasikan Masuk Pemeliharaan Cepat UPT PUPR Kab. Jember.
                            </p>
                        </div>

                        <!-- Option 2: Reject Aduan Warga -->
                        <div @click="decisionAction = 'reject'" 
                             :class="decisionAction === 'reject' ? 'border-red-500 bg-red-50/50 ring-2 ring-red-500' : 'border-slate-200 bg-white hover:border-slate-300'"
                             class="p-4 rounded-xl border cursor-pointer transition-all flex flex-col justify-between">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold" :class="decisionAction === 'reject' ? 'text-red-900' : 'text-slate-800'">
                                    REJECT — Tolak: Tolak Aduan Warga
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

                    <!-- Dropdowns Row -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Tingkat Prioritas Penanganan PUPR
                            </label>
                            <select name="pupr_priority" 
                                    class="w-full text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl px-3 py-2.5 focus:outline-none focus:border-brand-500">
                                <option value="PRIORITAS 1 - DARURAT (SLA Penanganan 48 Jam)" {{ ($activeTicket->pupr_priority == 'PRIORITAS 1 - DARURAT (SLA Penanganan 48 Jam)') ? 'selected' : '' }}>
                                    PRIORITAS 1 — DARURAT (SLA Penanganan 48 Jam)
                                </option>
                                <option value="PRIORITAS 2 - TINGGI (SLA Penanganan 5 Hari)" {{ ($activeTicket->pupr_priority == 'PRIORITAS 2 - TINGGI (SLA Penanganan 5 Hari)') ? 'selected' : '' }}>
                                    PRIORITAS 2 — TINGGI (SLA Penanganan 5 Hari)
                                </option>
                                <option value="PRIORITAS 3 - SEDANG (SLA Penanganan 14 Hari)" {{ ($activeTicket->pupr_priority == 'PRIORITAS 3 - SEDANG (SLA Penanganan 14 Hari)') ? 'selected' : '' }}>
                                    PRIORITAS 3 — SEDANG (SLA Penanganan 14 Hari)
                                </option>
                                <option value="PRIORITAS 4 - RUTIN/PEMELIHARAAN BERKALA" {{ ($activeTicket->pupr_priority == 'PRIORITAS 4 - RUTIN/PEMELIHARAAN BERKALA') ? 'selected' : '' }}>
                                    PRIORITAS 4 — RUTIN / PEMELIHARAAN BERKALA
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Estimasi Penanganan Teknis
                            </label>
                            <select name="technical_estimate" 
                                    class="w-full text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl px-3 py-2.5 focus:outline-none focus:border-brand-500">
                                <option value="Penambalan Aspal Dingin/Hotmix (Patching)" {{ ($activeTicket->technical_estimate == 'Penambalan Aspal Dingin/Hotmix (Patching)') ? 'selected' : '' }}>
                                    Penambalan Aspal Dingin/Hotmix (Patching)
                                </option>
                                <option value="Rekonstruksi Badan Jalan / Overlay" {{ ($activeTicket->technical_estimate == 'Rekonstruksi Badan Jalan / Overlay') ? 'selected' : '' }}>
                                    Rekonstruksi Badan Jalan / Overlay
                                </option>
                                <option value="Perbaikan Saluran Drainase & Gorong-gorong" {{ ($activeTicket->technical_estimate == 'Perbaikan Saluran Drainase & Gorong-gorong') ? 'selected' : '' }}>
                                    Perbaikan Saluran Drainase & Gorong-gorong
                                </option>
                                <option value="Pembersihan Material Longsor / Alat Berat" {{ ($activeTicket->technical_estimate == 'Pembersihan Material Longsor / Alat Berat') ? 'selected' : '' }}>
                                    Pembersihan Material Longsor / Alat Berat
                                </option>
                            </select>
                        </div>

                    </div>

                    <!-- Textarea Catatan Verifikator -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700">
                                Catatan Verifikator Kecamatan (Disposisi Resmi)
                            </label>
                            <span class="text-[10px] text-slate-400 font-mono">
                                <span x-text="charCount"></span> karakter | Sesuai SOP PUPR
                            </span>
                        </div>
                        <textarea name="verifier_notes" 
                                  rows="3" 
                                  @input="charCount = $el.value.length"
                                  class="w-full text-xs font-medium text-slate-800 bg-white border border-slate-300 rounded-xl p-3 focus:outline-none focus:border-brand-500 leading-relaxed"
                                  placeholder="Tuliskan catatan teknis dan arahan penanganan untuk tim lapangan UPT PUPR...">{{ $activeTicket->verifier_notes ?? 'Laporan valid. Titik koordinat sesuai dengan ruas jalan kabupaten kelas 3B. Prioritas penambalan aspal hotmix darurat untuk mencegah korban kecelakaan lalu lintas lanjutan UPTD.' }}</textarea>
                    </div>

                    <!-- Digital Verification Badge -->
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-certificate text-emerald-600"></i>
                            <span class="text-slate-700">
                                Divalidasi secara digital oleh: <strong>Hendra Wijaya, S.Sos</strong> — NIP. 19790623 200501 1 004 (Kasi Ekbang Kec. Jember)
                            </span>
                        </div>
                        <span class="text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded border border-emerald-300 shrink-0">
                            Otoritas Terverifikasi
                        </span>
                    </div>

                    <!-- Form Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-2">
                        
                        <button type="submit" 
                                @click="decisionAction = 'draft'" 
                                class="w-full sm:w-auto px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl border border-slate-300 shadow-2xs transition-colors">
                            Simpan Draf Pemeriksaan
                        </button>

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
            @endif

        </div>

    </div>

</div>
@endsection

@push('scripts')
@if($activeTicket)
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

        // Custom red marker
        const marker = L.circleMarker([lat, lng], {
            radius: 9,
            fillColor: "#ef4444",
            color: "#ffffff",
            weight: 2,
            opacity: 1,
            fillOpacity: 0.95
        }).addTo(map);

        marker.bindPopup("<strong class='font-sans text-xs'>{{ $activeTicket->ticket_number }}</strong><br><span class='text-[11px]'>{{ $activeTicket->road_name }}</span>").openPopup();
    });
</script>
@endif
@endpush
