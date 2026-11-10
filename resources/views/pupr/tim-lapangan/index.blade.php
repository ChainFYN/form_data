@extends('pupr.layouts.app')

@section('title', 'Tim Lapangan - PUPR')

@section('content')
<!--<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Manajemen Tim Lapangan</h2>
        <a href="{{ route('pupr.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card card-sigap text-center p-4 bg-success text-white">
                <h3 class="mb-0">{{ $timTersedia }}</h3>
                <p class="mb-0 text-white-50">Tim Tersedia</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-sigap text-center p-4 bg-warning text-dark">
                <h3 class="mb-0">{{ $timDiLapangan }}</h3>
                <p class="mb-0 text-warning-50">Tim Di Lapangan</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-sigap text-center p-4 bg-secondary text-white">
                <h3 class="mb-0">{{ $timLapangan->count() }}</h3>
                <p class="mb-0 text-white-50">Total Tim</p>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($timLapangan as $tim)
        <div class="col-md-4 mb-4">
            <div class="card card-sigap">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">{{ $tim->nama_tim }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="badge bg-{{ $tim->status == 'Tersedia' ? 'success' : ($tim->status == 'Di Lapangan' ? 'warning' : 'secondary') }}">
                            {{ $tim->status }}
                        </span>
                    </div>
                    <p class="mb-1"><strong>Jumlah Personel:</strong> {{ $tim->jumlah_personel }} orang</p>
                    <p class="mb-1"><strong>Laporan Ditangani:</strong> {{ $tim->laporan_count ?? 0 }}</p>
                    <p class="mb-3 text-muted small">ID: {{ $tim->id_tim }}</p>

                    <form action="{{ route('pupr.tim-lapangan.update-status', $tim->id_tim) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-2">
                            <select name="status" class="form-select form-select-sm">
                                <option value="Tersedia" {{ $tim->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Di Lapangan" {{ $tim->status == 'Di Lapangan' ? 'selected' : '' }}>Di Lapangan</option>
                                <option value="Standby" {{ $tim->status == 'Standby' ? 'selected' : '' }}>Standby</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>-->

<!--<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('warga.dashboard') }}" class="hover:text-slate-900 transition">Beranda</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">Manajemen Tim Lapangan</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen Tim Lapangan</h1>
        </div>
        <!--<div class="flex items-center gap-3">
            <a href="{{ route('warga.laporan.create') }}" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-xs">
                <i class="fa-solid fa-circle-plus text-amber-400"></i>
                <span>Buat Laporan Baru</span>
            </a>
        </div>-->
    </div>

    <!-- FILTER & SEARCH BAR -->
    <div class="bg-[#FCFAF9] rounded-2xl p-4 border border-slate-200 shadow-xs mb-6">
        <form action="{{ route('pupr.laporan.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <!-- Search -->
            <!--<div class="relative flex-1 w-full">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari berdasarkan nama jalan"
                       class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800 placeholder-slate-400">
            </div>

            <!-- Status Filter -->
            <!--<div class="w-full sm:w-56 shrink-0">
                <select name="status" class="w-full py-2 px-3 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-700">
                    <option value="">Semua Status Laporan</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Menunggu Validasi</option>
                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Diproses PUPR</option>
                    <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Selesai Diperbaiki</option>
                    <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>-->

            <!-- Submit & Reset -->
            <!--<div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
                <button type="submit" class="flex-1 sm:flex-none px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition">
                    Filter
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('warga.laporan.index') }}" class="px-3 py-2 text-xs font-semibold text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition">
                        Reset
                    </a>
                @endif
            </div>-->
        </form>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-[#F5F5F5] saturate-50 rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">ID Tiket / Waktu</th>
                        <th class="py-3.5 px-4">Lokasi Ruas Jalan</th>
                        <th class="py-3.5 px-4">Kategori & Urgensi</th>
                        <th class="py-3.5 px-4">Status Penanganan</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($laporan as $index => $item)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <!-- No -->
                            <td class="py-4 px-4 text-center font-bold text-slate-400">
                                {{ $index + 1 }}
                            </td>

                            <!-- Tiket & Waktu -->
                            <td class="py-4 px-4">
                                <div class="font-mono font-bold text-slate-900 text-xs">
                                    LP-{{ $item->created_at->format('Y') }}-{{ str_pad($item->id_laporan, 4, '0', STR_PAD_LEFT) }}
                                </div>
                                <div class="text-[11px] text-slate-400 mt-0.5">
                                    {{ $item->created_at->format('d M Y, H:i') }} WIB
                                </div>
                            </td>

                            <!-- Lokasi Ruas Jalan -->
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-900">
                                    Jl. {{ $item->jalan->nama_jalan ?? '-' }}
                                </div>
                                <div class="text-[11px] text-slate-500 mt-0.5">
                                    {{ $item->jalan->desa->nama_desa ?? '-' }}, Kec. {{ $item->jalan->desa->kecamatan->nama_kecamatan ?? '-' }}
                                </div>
                                @if($item->latitude && $item->longitude)
                                    <div class="text-[10px] text-emerald-700 font-medium mt-1">
                                        <i class="fa-solid fa-location-dot text-[9px] mr-1"></i>GPS: {{ number_format($item->latitude, 4) }}, {{ number_format($item->longitude, 4) }}
                                    </div>
                                @endif
                            </td>

                            <!-- Kategori & Urgensi -->
                            <td class="py-4 px-4">
                                <div class="font-semibold text-slate-800">
                                    {{ $item->kategori->nama_kategori ?? 'Umum' }}
                                </div>
                                <div class="mt-1">
                                    <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider {{ $item->tingkat_bahaya === 'Bahaya Tinggi' ? 'bg-red-50 text-red-700 border border-red-200' : ($item->tingkat_bahaya === 'Sedang' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-slate-100 text-slate-700 border border-slate-200') }}">
                                        {{ $item->tingkat_bahaya }}
                                    </span>
                                </div>
                            </td>

                            <!-- Status Penanganan -->
                            <td class="py-4 px-4">
                                @php
                                    $badgeBg = 'bg-slate-100 text-slate-700 border-slate-200';
                                    $dotColor = 'bg-slate-400';
                                    if($item->id_status == 1) {
                                        $badgeBg = 'bg-amber-50 text-amber-800 border-amber-200';
                                        $dotColor = 'bg-amber-500';
                                    } elseif($item->id_status == 2) {
                                        $badgeBg = 'bg-blue-50 text-blue-800 border-blue-200';
                                        $dotColor = 'bg-blue-500';
                                    } elseif($item->id_status == 3) {
                                        $badgeBg = 'bg-emerald-50 text-emerald-800 border-emerald-200';
                                        $dotColor = 'bg-emerald-500';
                                    } elseif($item->id_status == 4) {
                                        $badgeBg = 'bg-red-50 text-red-800 border-red-200';
                                        $dotColor = 'bg-red-500';
                                    }
                                @endphp
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full border {{ $badgeBg }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                    {{ $item->status->nama_status ?? 'Menunggu' }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-4 text-center">
                                <a href="{{ route('warga.laporan.show', $item->id_laporan) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold rounded-lg text-xs transition">
                                    <span>Detail</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 px-4 text-center">
                                <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <i class="fa-regular fa-folder-open text-xl"></i>
                                </div>
                                <h4 class="text-sm font-bold text-slate-800 mb-1">Tidak Ada Laporan Ditemukan</h4>
                                <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4">
                                    @if(request('search') || request('status'))
                                        Tidak ditemukan laporan yang sesuai kriteria pencarian Anda.
                                    @else
                                        Anda belum pernah membuat laporan kerusakan jalan.
                                    @endif
                                </p>
                                <!--<a href="{{ route('warga.laporan.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>Buat Laporan Baru</span>
                                </a>-->
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>-->
@endsection
