@extends('kecamatan.layouts.app')

@section('title', 'Dashboard Admin Kecamatan - Desktop')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- SUB-HEADER / WELCOME BANNER -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 pb-6 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-amber-600 tracking-wide uppercase">
                <i class="fa-solid fa-location-dot"></i>
                <span>Kecamatan jember — Wilayah Kerja Kab. Jember</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">
                Halo, Admin Cabang Kecamatan jember
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Sistem Pemantauan Presisi dan Validasi Disposisi Kerusakan Jalan Publik Warga
            </p>
        </div>

        <!-- Sync Status Pill -->
        <div class="flex items-center gap-3 bg-white border border-slate-200 shadow-xs rounded-xl px-4 py-2.5 shrink-0">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
            </span>
            <div>
                <p class="text-xs font-bold text-slate-800 tracking-tight">SINKRONISASI JALAN — DINAS PUPR AKTIF</p>
                <p class="text-[11px] text-slate-400 font-medium">Terakhir sinkronisasi: Hari ini, 11:42 WIB</p>
            </div>
        </div>
    </div>

    <!-- 4 KPI SUMMARY METRIC CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-6">
        
        <!-- Card 1: Laporan Masuk Hari Ini -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-600">Laporan Masuk Hari Ini</span>
                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200">PERLU TINDAKAN</span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900 tracking-tight">{{ $perluTindakanCount }}</span>
                <span class="text-xs font-semibold text-slate-500">Laporan</span>
            </div>
            <div class="mt-3 flex items-center text-xs font-semibold text-emerald-600 gap-1.5">
                <i class="fa-solid fa-arrow-trend-up text-[11px]"></i>
                <span>+3 kemarin</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-amber-500"></div>
        </div>

        <!-- Card 2: Menunggu Validasi -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-600">Menunggu Validasi</span>
                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 border border-blue-200">Pending</span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900 tracking-tight">{{ $menungguValidasiCount }}</span>
                <span class="text-xs font-semibold text-slate-500">Laporan</span>
            </div>
            <div class="mt-3 flex items-center text-xs font-semibold text-amber-600 gap-1.5">
                <i class="fa-regular fa-clock text-[11px]"></i>
                <span>Butuh verifikasi</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-yellow-500"></div>
        </div>

        <!-- Card 3: Terverifikasi & Diteruskan -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-600">Terverifikasi & Diteruskan</span>
                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">Ke PUPR</span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900 tracking-tight">{{ $terverifikasiCount }}</span>
                <span class="text-xs font-semibold text-slate-500">Aduan Selesai</span>
            </div>
            <div class="mt-3 flex items-center text-xs font-semibold text-emerald-600 gap-1.5">
                <i class="fa-solid fa-arrow-trend-up text-[11px]"></i>
                <span>+12 pekan ini</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-emerald-500"></div>
        </div>

        <!-- Card 4: Ditolak / Divalidasi Tidak Valid -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-600">Ditolak / Divalidasi Tidak Valid</span>
                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-red-100 text-red-800 border border-red-200">Reject</span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900 tracking-tight">{{ $ditolakCount }}</span>
                <span class="text-xs font-semibold text-slate-500">Laporan</span>
            </div>
            <div class="mt-3 flex items-center text-xs font-semibold text-slate-400 gap-1.5">
                <i class="fa-solid fa-ban text-[11px]"></i>
                <span>Duplikasi / Non-Kewenangan</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-red-500"></div>
        </div>

    </div>

    <!-- QUICK ACTIONS BANNER (Matching Figma Ice-Blue Bar) -->
    <div class="bg-sky-50 border border-sky-200/80 rounded-2xl p-4 sm:p-5 mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 shadow-2xs">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center shrink-0 shadow-sm">
                <i class="fa-solid fa-location-crosshairs text-base"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900">Tindakan Prioritas Wilayah jember</h3>
                <p class="text-xs text-slate-600 font-medium">Terdapat 3 aduan jalan berlubang kategori kritis butuh disposisi ke UPT Dinas PUPR</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('kecamatan.validation.index') }}" 
               class="bg-amber-800 hover:bg-amber-900 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-xs transition-colors flex items-center gap-2">
                <i class="fa-solid fa-list-check text-xs"></i>
                <span>Verifikasi Laporan Masuk (3 Antrean)</span>
            </a>
            <a href="{{ route('kecamatan.reports.gis-map') }}" 
               class="bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold px-3.5 py-2.5 rounded-xl border border-slate-300 shadow-2xs transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-map-location-dot text-slate-500"></i>
                <span>Peta GIS</span>
            </a>
            <a href="{{ route('kecamatan.reports.export-bap') }}" 
               class="bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold px-3.5 py-2.5 rounded-xl border border-slate-300 shadow-2xs transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-file-signature text-slate-500"></i>
                <span>Ekspor BAP</span>
            </a>
            <button onclick="window.print()" 
                    class="bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold px-3.5 py-2.5 rounded-xl border border-slate-300 shadow-2xs transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-print text-slate-500"></i>
                <span>Cetak Rekap</span>
            </button>
        </div>
    </div>

    <!-- MAIN TWO-COLUMN LAYOUT (8 COLS LEFT, 4 COLS RIGHT) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 mt-7">
        
        <!-- ==================== LEFT COLUMN (8 COLS) ==================== -->
        <div class="lg:col-span-8 flex flex-col gap-6">
            
            <!-- SECTION HEADER -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight">Daftar Antrean Validasi Prioritas Tertinggi</h2>
                        <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-red-100 text-red-700 border border-red-200">
                            TINDAKAN CEPAT DIBUTUHKAN
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Laporan warga berstatus prioritas urgensi tinggi estimasi jalan rusak butuh respon UPT Dinas PUPR</p>
                </div>
            </div>

            <!-- CARDS LIST OF REPORTS (Matching Figma Images 1 & 2) -->
            <div class="flex flex-col gap-4">
                
                @forelse($priorityReports as $report)
                <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-xs hover:shadow-md transition-all flex flex-col sm:flex-row gap-4 relative">
                    
                    <!-- Left Photo Thumbnail -->
                    <div class="sm:w-36 h-32 sm:h-auto rounded-xl overflow-hidden bg-slate-100 shrink-0 relative border border-slate-200 group">
                        <img src="{{ $report->photo_path }}" 
                             alt="{{ $report->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute bottom-1.5 left-1.5 bg-slate-900/80 backdrop-blur-xs text-white text-[9px] font-mono px-1.5 py-0.5 rounded flex items-center gap-1">
                            <i class="fa-solid fa-camera text-[8px]"></i>
                            <span>GPS VALID</span>
                        </div>
                    </div>

                    <!-- Right Card Details -->
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <!-- Badges & Ticket Info Row -->
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full {{ $report->urgency_badge }}">
                                        {{ $report->urgency_label }}
                                    </span>
                                    <span class="font-mono text-xs font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                        {{ $report->ticket_number }}
                                    </span>
                                    <span class="text-[11px] text-slate-400 font-medium">
                                        {{ $report->time_ago }} • Disposisi Warga
                                    </span>
                                </div>
                                <span class="text-[11px] font-bold text-red-600 bg-red-50 border border-red-200 px-2 py-0.5 rounded-full">
                                    {{ $report->sla_text ?? 'Sisa Waktu: 2 Jam' }}
                                </span>
                            </div>

                            <!-- Road Name & Title -->
                            <h3 class="text-sm sm:text-base font-extrabold text-slate-900 mt-2 hover:text-brand-600 transition-colors">
                                <a href="{{ route('kecamatan.validation.index', ['ticket' => $report->ticket_number]) }}">
                                    {{ $report->title }}
                                </a>
                            </h3>

                            <!-- Citizen Description -->
                            <p class="text-xs text-slate-600 font-normal leading-relaxed mt-1 line-clamp-2">
                                {{ $report->description }}
                            </p>

                            <!-- Meta Details (Reporter & Coordinate) -->
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-[11px] text-slate-500 font-medium mt-2 pt-2 border-t border-slate-100">
                                <div class="flex items-center gap-1">
                                    <i class="fa-regular fa-user text-slate-400"></i>
                                    <span>Laporan: <strong class="text-slate-700">{{ $report->reporter_name }}</strong> (Foto asli tervalidasi Geo-location)</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <i class="fa-solid fa-location-pin text-slate-400"></i>
                                    <span>Titik Koordinat: <span class="font-mono">{{ number_format($report->latitude, 4) }}, {{ number_format($report->longitude, 4) }}</span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Action Buttons -->
                        <div class="flex items-center justify-end gap-2.5 mt-3 pt-2">
                            <a href="{{ route('kecamatan.validation.index', ['ticket' => $report->ticket_number]) }}" 
                               class="bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold px-3.5 py-2 rounded-xl border border-slate-300 shadow-2xs transition-colors">
                                Tinjau Detail
                            </a>

                            @if($report->urgency == 'darurat')
                                <a href="{{ route('kecamatan.validation.index', ['ticket' => $report->ticket_number]) }}" 
                                   class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-xs transition-colors flex items-center gap-1.5">
                                    <i class="fa-solid fa-paper-plane text-[10px]"></i>
                                    <span>Teruskan Segera ke PUPR</span>
                                </a>
                            @else
                                <a href="{{ route('kecamatan.validation.index', ['ticket' => $report->ticket_number]) }}" 
                                   class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-xs transition-colors flex items-center gap-1.5">
                                    <span>Proses Validasi Langsung (SLA)</span>
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
                @empty
                <div class="bg-white rounded-2xl p-8 text-center border border-slate-200">
                    <i class="fa-regular fa-circle-check text-4xl text-emerald-500 mb-2"></i>
                    <p class="font-bold text-slate-800">Semua antrean prioritas telah divalidasi!</p>
                </div>
                @endforelse

            </div>

            <!-- ALUR SIKLUS VALIDASI KECAMATAN KE UPT DINAS PUPR (Matching Figma Bottom Box) -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs mt-2">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-slate-800">
                        ALUR SIKLUS VALIDASI KECAMATAN KE UPT DINAS PUPR
                    </span>
                    <span class="text-[11px] text-slate-400 font-medium">SOP Penanganan Darurat Jalan</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    
                    <!-- Tahap 1 -->
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                        <div class="flex items-center justify-between text-[11px] font-bold text-slate-500">
                            <span>Tahap 1</span>
                            <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        </div>
                        <h4 class="text-xs font-bold text-slate-800 mt-1">Laporan Warga</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Verifikasi Administrasi & GPS</p>
                    </div>

                    <!-- Tahap 2: Current Active Stage -->
                    <div class="bg-amber-50 border-2 border-amber-400 rounded-xl p-3 relative shadow-2xs">
                        <div class="flex items-center justify-between text-[11px] font-bold text-amber-700">
                            <span>Tahap 2 (Posisi Saat Ini)</span>
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        </div>
                        <h4 class="text-xs font-bold text-slate-900 mt-1">Validasi Ekbang</h4>
                        <p class="text-[11px] text-slate-600 mt-0.5">Cek Lapangan / Dokumen Teknis</p>
                    </div>

                    <!-- Tahap 3 -->
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                        <div class="flex items-center justify-between text-[11px] font-bold text-slate-400">
                            <span>Tahap 3</span>
                            <i class="fa-regular fa-clock text-slate-300"></i>
                        </div>
                        <h4 class="text-xs font-bold text-slate-700 mt-1">Disposisi UPT</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Penjadwalan Material & Hotmix</p>
                    </div>

                    <!-- Tahap 4 -->
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                        <div class="flex items-center justify-between text-[11px] font-bold text-slate-400">
                            <span>Tahap 4</span>
                            <i class="fa-regular fa-circle text-slate-300"></i>
                        </div>
                        <h4 class="text-xs font-bold text-slate-700 mt-1">Eksekusi Fisik</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Rekonstruksi / Selesai</p>
                    </div>

                </div>
            </div>

        </div>

        <!-- ==================== RIGHT COLUMN (4 COLS) ==================== -->
        <div class="lg:col-span-4 flex flex-col gap-6">
            
            <!-- WIDGET 1: Peringatan Batas SLA (24 Jam) -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-md bg-red-100 text-red-600 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900">Peringatan Batas SLA (24 Jam)</h3>
                    </div>
                    <span class="text-red-500 animate-pulse text-xs"><i class="fa-solid fa-bell"></i></span>
                </div>
                <p class="text-[11px] text-slate-500 leading-relaxed mt-2">
                    Berdasarkan SOP, laporan prioritas tinggi wajib diputuskan dalam waktu 24 jam sebelum dialihkan otomatis ke Dinas PUPR.
                </p>

                <!-- SLA Warning List -->
                <div class="flex flex-col gap-2.5 mt-4">
                    
                    <a href="{{ route('kecamatan.validation.index', ['ticket' => 'LP-2026-0842']) }}" 
                       class="p-3 bg-red-50/80 hover:bg-red-100/80 border border-red-200 rounded-xl block transition-colors">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs font-bold text-red-900">#LP-2026-0842 (Cikaret)</span>
                            <span class="text-[10px] font-extrabold bg-red-600 text-white px-2 py-0.5 rounded-full">Sisa 1 Jam 15 m</span>
                        </div>
                        <p class="text-[11px] text-red-800 font-medium mt-1">Longsor tebing jalan — Butuh tanggap darurat alat berat PUPR</p>
                    </a>

                    <a href="{{ route('kecamatan.validation.index', ['ticket' => 'LP-2026-0841']) }}" 
                       class="p-3 bg-amber-50/80 hover:bg-amber-100/80 border border-amber-200 rounded-xl block transition-colors">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs font-bold text-amber-900">#LP-2026-0841 (Mayor Oking)</span>
                            <span class="text-[10px] font-extrabold bg-amber-600 text-white px-2 py-0.5 rounded-full">Sisa 3 Jam 10 m</span>
                        </div>
                        <p class="text-[11px] text-amber-800 font-medium mt-1">Lubang jalan > 80cm — Rawan kecelakaan fatal motor</p>
                    </a>

                </div>

                <a href="{{ route('kecamatan.validation.index', ['tab' => 'high']) }}" 
                   class="w-full mt-4 py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-xl border border-slate-200 text-center block transition-colors">
                    Lihat Semua Antrean SLA (4 Laporan)
                </a>
            </div>

            <!-- WIDGET 2: Sebaran Wilayah Pekan Ini -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-extrabold text-slate-900">Sebaran Wilayah Pekan Ini</h3>
                    <i class="fa-solid fa-chart-simple text-slate-400 text-xs"></i>
                </div>
                <p class="text-[11px] text-slate-500 mt-1">Konsentrasi aduan warga di wilayah kerja Kec. jember</p>

                <!-- Progress bars -->
                <div class="flex flex-col gap-3.5 mt-4">
                    @foreach($villages as $v)
                    <div>
                        <div class="flex items-center justify-between text-xs font-semibold">
                            <span class="text-slate-800">{{ $v->name }}</span>
                            <span class="text-slate-600 font-bold">{{ $v->active_reports_count }} Laporan</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 mt-1.5 overflow-hidden">
                            <div class="bg-brand-600 h-2 rounded-full transition-all duration-500" 
                                 style="width: {{ min(100, $v->active_reports_count * 7) }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-slate-600">
                    <span>Total Terlaporkan Selesai</span>
                    <span class="text-brand-600 font-mono text-sm">{{ $totalResolvedRuas }} Titik Ruas</span>
                </div>
            </div>

            <!-- WIDGET 3: Hotline Lapangan Dinas PUPR (Dark Card Matching Figma) -->
            <div class="bg-slate-900 text-white rounded-2xl p-5 shadow-lg border border-slate-800 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-[10px] font-mono tracking-wider uppercase text-emerald-400 font-bold">UPT KELAS 1 KAB. JEMBER</span>
                    </div>
                    <span class="text-[10px] bg-slate-800 text-slate-300 px-2 py-0.5 rounded font-mono">24/7 SIAGA</span>
                </div>

                <h3 class="text-sm font-extrabold text-white mt-3">Hotline Lapangan Dinas PUPR</h3>
                <p class="text-xs text-slate-300 leading-relaxed mt-1">
                    Koordinasi langsung cepat tim teknis UPT Wilayah 1 jember bila butuh penanganan darurat alat berat.
                </p>

                <!-- Official Contact -->
                <div class="flex items-center gap-3 mt-4 p-3 bg-slate-800/80 rounded-xl border border-slate-700">
                    <div class="w-9 h-9 rounded-full bg-emerald-700 text-white font-bold flex items-center justify-center shrink-0 text-xs shadow-xs">
                        HG
                    </div>
                    <div>
                        <p class="text-xs font-bold text-white">Ir. Hendra Gunawan, S.T.</p>
                        <p class="text-[10px] text-slate-400">Kepala UPT Jalan & Jembatan Wil. jember</p>
                    </div>
                </div>

                <!-- CTA Button -->
                <a href="https://wa.me/6281198765432?text=Halo%20Pak%20Hendra%20UPT%20PUPR,%20koordinasi%20darurat%20aduan%20jalan%20SIGAP%20Kecamatan%20jember" 
                   target="_blank"
                   class="w-full mt-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl flex items-center justify-center gap-2 shadow-md transition-all">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>Hubungi WhatsApp Siaga (24/7)</span>
                </a>

                <p class="text-[10px] text-center text-slate-400 mt-2 font-mono">No. Tiket Cepat Darurat: 112 / 021-879-0123</p>
            </div>

            <!-- WIDGET 4: Kamera Pantauan Titik Rawan (CCTV Snapshot) -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                        <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider">Kamera Pantauan Titik Rawan</h3>
                    </div>
                    <span class="text-[10px] font-mono text-slate-400">CAM-04 JEMBER</span>
                </div>
                
                <div class="relative rounded-xl overflow-hidden bg-slate-900 border border-slate-200 h-40">
                    <img src="https://images.unsplash.com/photo-1545459720-aac8509eb02c?auto=format&fit=crop&w=600&q=80" 
                         alt="CCTV Simpang jember" 
                         class="w-full h-full object-cover opacity-85">
                    <div class="absolute top-2 left-2 bg-red-600/90 text-white text-[9px] font-bold px-2 py-0.5 rounded flex items-center gap-1 font-mono">
                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                        <span>LIVE STREAM</span>
                    </div>
                    <div class="absolute bottom-2 left-2 right-2 bg-slate-950/80 backdrop-blur-xs text-white text-[10px] px-2.5 py-1 rounded flex justify-between items-center font-mono">
                        <span>Simpang Mayor Oking - Cikaret</span>
                        <span>24 FPS • 1080p</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
