@extends('kecamatan.layouts.app')

@section('title', 'Dashboard Admin Kecamatan')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- TOP HEADER & TIME FILTER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Dashboard Kecamatan</h1>
        </div>

        <!-- Filter Waktu -->
        <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-xl self-start md:self-auto overflow-x-auto max-w-full text-xs">
            <span class="px-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider hidden sm:inline-flex items-center gap-1">
                <i class="fa-regular fa-calendar text-[11px]"></i> Filter:
            </span>
            <a href="{{ route('kecamatan.dashboard', ['waktu' => 'all']) }}"
               class="px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $timeFilter === 'all' || !$timeFilter ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Semua
            </a>
            <a href="{{ route('kecamatan.dashboard', ['waktu' => 'hari_ini']) }}"
               class="px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $timeFilter === 'hari_ini' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Hari Ini
            </a>
            <a href="{{ route('kecamatan.dashboard', ['waktu' => '1_minggu']) }}"
               class="px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $timeFilter === '1_minggu' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                1 Minggu Terakhir
            </a>
            <a href="{{ route('kecamatan.dashboard', ['waktu' => '1_bulan']) }}"
               class="px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $timeFilter === '1_bulan' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Sebulan Terakhir
            </a>
        </div>
    </div>

    <!-- KPI CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">PERLU TINDAKAN</div>
                <div class="">
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-4xl font-extrabold text-slate-900">{{ $perluTindakanCount }}</div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-bold mt-2">
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">MENUNGGU VALIDASI</div>
                <div class="">
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-4xl font-extrabold text-slate-900">{{ $menungguValidasiCount }}</div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-bold mt-2">
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">DITERUSKAN KE PUPR</div>
                <div class="">
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-4xl font-extrabold text-slate-900">{{ $terverifikasiCount }}</div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-bold mt-2">
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">BAST SELESAI DIVERIFIKASI</div>
                <div class="">
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-4xl font-extrabold text-slate-900">{{ $totalResolvedRuas }}</div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-bold mt-2">
            </div>
        </div>

    </div>

    <!-- DAFTAR LAPORAN (FULL WIDTH) -->
    <div class="w-full">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900">Daftar Antrean Validasi Prioritas</h2>
            </div>
            <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-xl">
                <a href="{{ route('kecamatan.validation.index') }}" class="px-4 py-1.5 text-xs font-bold bg-white text-slate-900 rounded-lg shadow-sm">Lihat Semua Antrean</a>
            </div>
        </div>

        <div class="flex flex-col gap-4">

            @forelse($priorityReports as $report)
            <div class="bg-white rounded-2xl p-4 border {{ $report->tingkat_bahaya === 'Bahaya Tinggi' ? 'border-red-200 ring-1 ring-red-500/20' : 'border-slate-200' }} shadow-xs flex flex-col sm:flex-row gap-5 relative overflow-hidden">
                @if($report->tingkat_bahaya === 'Bahaya Tinggi')
                    <div class="absolute top-0 left-0 w-1 h-full bg-red-500"></div>
                @endif
                <div class="w-full sm:w-48 h-32 rounded-xl overflow-hidden relative shrink-0">
                    @if($report->url_foto)
                        <img src="{{ asset('storage/' . $report->url_foto) }}" alt="Jalan rusak" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400 flex-col gap-2">
                            <i class="fa-solid fa-image text-3xl"></i>
                        </div>
                    @endif
                    <div class="absolute top-2 left-2 {{ $report->tingkat_bahaya === 'Bahaya Tinggi' ? 'bg-red-600' : ($report->tingkat_bahaya === 'Sedang' ? 'bg-amber-500' : 'bg-emerald-600') }} text-white text-[10px] font-extrabold px-2 py-0.5 rounded uppercase">{{ $report->tingkat_bahaya }}</div>
                </div>
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <div class="text-[10px] font-mono font-bold text-slate-500">
                                LP-{{ $report->created_at->format('Y') }}-{{ str_pad($report->id_laporan, 4, '0', STR_PAD_LEFT) }}
                            </div>
                            <span class="text-[10px] font-bold bg-blue-50 text-blue-700 px-2 py-0.5 rounded border border-blue-200">{{ $report->status->nama_status ?? 'Menunggu Validasi' }}</span>
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900 mb-1">Jl. {{ $report->jalan->nama_jalan ?? 'Tidak diketahui' }} ({{ $report->jalan->desa->nama_desa ?? '-' }})</h3>
                        <p class="text-[11px] text-slate-600 leading-relaxed mb-3">Kategori: <strong>{{ $report->kategori->nama_kategori ?? '-' }}</strong>. {{ Str::limit($report->deskripsi, 120) }}</p>
                    </div>

                    <div>
                        <div class="flex items-center gap-4 mb-3">
                            <div class="flex items-center gap-1.5 text-[10px] font-bold {{ $report->tingkat_bahaya === 'Bahaya Tinggi' ? 'text-red-700 bg-red-50 border-red-200' : 'text-slate-700 bg-slate-100 border-slate-200' }} border px-2.5 py-1.5 rounded-lg">
                                <i class="fa-solid fa-user"></i> Dilaporkan oleh: {{ $report->pengguna->nama_lengkap ?? 'Warga' }}
                            </div>
                            <div class="flex items-center gap-1.5 text-[10px] text-slate-600 font-medium">
                                <i class="fa-solid fa-location-dot text-slate-400"></i> Kec. {{ $report->jalan->desa->kecamatan->nama_kecamatan ?? '-' }}
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                            <div class="flex items-center gap-1.5 text-[9px] text-slate-500 font-bold">
                                <i class="fa-solid fa-calendar-day"></i> Dilaporkan pada: {{ $report->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('kecamatan.validation.index', ['ticket' => $report->id_laporan]) }}" class="px-4 py-1.5 text-[10px] font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-lg shadow-xs transition-colors">Validasi Laporan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl p-10 border border-slate-200 shadow-xs flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fa-solid fa-check-double text-emerald-500 text-2xl"></i>
                </div>
                <h3 class="text-base font-extrabold text-slate-700">Tidak ada antrean validasi</h3>
                <p class="text-xs text-slate-400 mt-1">Semua laporan dari warga telah divalidasi dan diteruskan ke Dinas PUPR.</p>
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
