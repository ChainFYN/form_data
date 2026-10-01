@extends('warga.layouts.app')

@section('title', 'Detail Laporan #' . str_pad($laporan->id_laporan, 4, '0', STR_PAD_LEFT))

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- BREADCRUMB & HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('warga.dashboard') }}" class="hover:text-slate-900 transition">Beranda</a>
                <span>/</span>
                <a href="{{ route('warga.laporan.index') }}" class="hover:text-slate-900 transition">Riwayat Laporan</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">Detail Tiket</span>
            </div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight font-mono">
                    LP-{{ $laporan->created_at->format('Y') }}-{{ str_pad($laporan->id_laporan, 4, '0', STR_PAD_LEFT) }}
                </h1>

                <!-- Status Badge -->
                @php
                    $badgeBg = 'bg-slate-100 text-slate-700 border-slate-200';
                    $dotColor = 'bg-slate-400';
                    if($laporan->id_status == 1) {
                        $badgeBg = 'bg-amber-50 text-amber-800 border-amber-200';
                        $dotColor = 'bg-amber-500';
                    } elseif($laporan->id_status == 2) {
                        $badgeBg = 'bg-blue-50 text-blue-800 border-blue-200';
                        $dotColor = 'bg-blue-500';
                    } elseif($laporan->id_status == 3) {
                        $badgeBg = 'bg-emerald-50 text-emerald-800 border-emerald-200';
                        $dotColor = 'bg-emerald-500';
                    } elseif($laporan->id_status == 4) {
                        $badgeBg = 'bg-red-50 text-red-800 border-red-200';
                        $dotColor = 'bg-red-500';
                    }
                @endphp
                <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full border {{ $badgeBg }}">
                    <span class="w-2 h-2 rounded-full {{ $dotColor }}"></span>
                    {{ $laporan->status->nama_status ?? 'Menunggu' }}
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Diajukan pada {{ $laporan->created_at->format('d F Y, H:i') }} WIB</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('warga.laporan.index') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl text-xs font-bold hover:bg-slate-50 transition flex items-center gap-2 shadow-xs">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>Kembali ke Riwayat</span>
            </a>
        </div>
    </div>

    <!-- MAIN TWO COLUMNS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- LEFT COLUMN: DETAIL INFORMASI & FOTO -->
        <div class="lg:col-span-2 space-y-6">

            <!-- FOTO BUKTI KERUSAKAN -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-camera text-slate-500"></i>
                        <h2 class="text-sm font-bold text-slate-900">Dokumentasi Bukti Lapangan</h2>
                    </div>
                    <span class="text-[11px] font-bold px-2 py-0.5 rounded uppercase tracking-wider {{ $laporan->tingkat_bahaya === 'Bahaya Tinggi' ? 'bg-red-50 text-red-700 border border-red-200' : ($laporan->tingkat_bahaya === 'Sedang' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-slate-100 text-slate-700 border border-slate-200') }}">
                        {{ $laporan->tingkat_bahaya }}
                    </span>
                </div>
                <div class="p-4 bg-slate-50/50 flex items-center justify-center">
                    @if($laporan->url_foto)
                        <img src="{{ asset('storage/' . $laporan->url_foto) }}" alt="Foto kerusakan jalan" class="max-h-[460px] w-auto max-w-full rounded-xl border border-slate-200 shadow-xs object-contain">
                    @else
                        <div class="py-16 text-center text-slate-400">
                            <i class="fa-regular fa-image text-4xl mb-2"></i>
                            <p class="text-xs">Foto tidak tersedia dalam sistem</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- DETAIL LOKASI & DESKRIPSI -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
                <h2 class="text-sm font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">
                    Informasi Lokasi & Kerusakan
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Ruas Jalan</span>
                        <p class="text-sm font-bold text-slate-900">Jl. {{ $laporan->jalan->nama_jalan ?? '-' }}</p>
                    </div>

                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Wilayah Administratif</span>
                        <p class="text-sm font-medium text-slate-800">
                            {{ $laporan->jalan->desa->nama_desa ?? '-' }}, Kec. {{ $laporan->jalan->desa->kecamatan->nama_kecamatan ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Kategori Kerusakan</span>
                        <p class="text-xs font-semibold text-slate-800 inline-flex items-center gap-1.5 bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200">
                            <i class="fa-solid fa-tag text-[10px] text-slate-500"></i>
                            {{ $laporan->kategori->nama_kategori ?? 'Umum' }}
                        </p>
                    </div>

                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Koordinat GPS</span>
                        @if($laporan->latitude && $laporan->longitude)
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-xs font-semibold text-slate-700">
                                    {{ $laporan->latitude }}, {{ $laporan->longitude }}
                                </span>
                                <a href="https://www.google.com/maps?q={{ $laporan->latitude }},{{ $laporan->longitude }}" target="_blank" class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded text-[11px] font-bold hover:bg-emerald-100 transition inline-flex items-center gap-1">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                    <span>Peta</span>
                                </a>
                            </div>
                        @else
                            <p class="text-xs text-slate-400 italic">Koordinat GPS tidak dicantumkan</p>
                        @endif
                    </div>
                </div>

                <!-- Deskripsi Laporan -->
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Deskripsi Aduan Warga</span>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 text-xs text-slate-700 leading-relaxed">
                        {{ $laporan->deskripsi }}
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN: TIMELINE PROGRES & STATUS PENANGANAN -->
        <div class="space-y-6">

            <!-- TIMELINE PENANGANAN -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
                <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-100">
                    <i class="fa-solid fa-timeline text-slate-500"></i>
                    <h2 class="text-sm font-bold text-slate-900">Alur & Riwayat Penanganan</h2>
                </div>

                <div class="relative border-l-2 border-slate-200 ml-3.5 space-y-6 my-3">

                    <!-- STEP 1: LAPORAN DIBUAT -->
                    <div class="relative pl-6">
                        <div class="absolute -left-[19px] top-0 w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-bold shadow-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <h3 class="text-xs font-extrabold text-slate-900">Laporan Berhasil Terkirim</h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">Aduan masuk ke sistem SIGAP dan diteruskan ke Kecamatan.</p>
                        <span class="text-[10px] text-slate-400 mt-1 block">
                            {{ $laporan->created_at->format('d M Y, H:i') }} WIB
                        </span>
                    </div>

                    <!-- STEP 2: VALIDASI KECAMATAN -->
                    <div class="relative pl-6">
                        @if($laporan->validasi)
                            <div class="absolute -left-[19px] top-0 w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-bold shadow-xs">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <h3 class="text-xs font-extrabold text-slate-900">Validasi Lapangan Kecamatan</h3>
                            <p class="text-[11px] text-slate-600 mt-0.5">
                                Diverifikasi oleh: <span class="font-bold text-slate-800">{{ $laporan->validasi->pengguna->nama_lengkap ?? 'Admin Kecamatan' }}</span>
                            </p>
                            @if($laporan->validasi->catatan)
                                <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-2.5 mt-2 text-[11px] text-emerald-900">
                                    <span class="font-bold block text-[10px] uppercase tracking-wider text-emerald-800 mb-0.5">Catatan Verifikasi:</span>
                                    "{{ $laporan->validasi->catatan }}"
                                </div>
                            @endif
                            <span class="text-[10px] text-slate-400 mt-1 block">
                                {{ $laporan->validasi->created_at->format('d M Y, H:i') }} WIB
                            </span>
                        @elseif($laporan->id_status == 4)
                            <div class="absolute -left-[19px] top-0 w-8 h-8 rounded-full bg-red-500 text-white flex items-center justify-center text-xs font-bold shadow-xs">
                                <i class="fa-solid fa-xmark"></i>
                            </div>
                            <h3 class="text-xs font-extrabold text-red-700">Laporan Ditolak</h3>
                            <p class="text-[11px] text-slate-500 mt-0.5">Laporan belum memenuhi kriteria atau merupakan jalan non-kabupaten.</p>
                        @else
                            <div class="absolute -left-[19px] top-0 w-8 h-8 rounded-full bg-amber-400 text-white flex items-center justify-center text-xs font-bold animate-pulse shadow-xs">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <h3 class="text-xs font-extrabold text-slate-900">Pemeriksaan Tim Kecamatan</h3>
                            <p class="text-[11px] text-slate-500 mt-0.5">Sedang dalam antrean pengecekan lapangan oleh pihak kantor kecamatan setempat.</p>
                        @endif
                    </div>

                    <!-- STEP 3: PENANGANAN PUPR -->
                    <div class="relative pl-6">
                        @if($laporan->logProses && $laporan->logProses->count() > 0)
                            <div class="absolute -left-[19px] top-0 w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold shadow-xs">
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                            </div>
                            <h3 class="text-xs font-extrabold text-slate-900">Pengerjaan Tim Teknis PUPR</h3>
                            <div class="mt-2 space-y-2">
                                @foreach($laporan->logProses as $log)
                                    <div class="bg-blue-50/80 border border-blue-200 rounded-lg p-2.5 text-[11px] text-blue-950">
                                        <div class="flex items-center justify-between text-[10px] text-blue-700 font-bold mb-1">
                                            <span>Update Progres:</span>
                                            <span>{{ $log->created_at->format('d M, H:i') }}</span>
                                        </div>
                                        <p>{{ $log->catatan_update }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @elseif($laporan->id_status >= 2)
                            <div class="absolute -left-[19px] top-0 w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold shadow-xs">
                                <i class="fa-solid fa-truck-pickup"></i>
                            </div>
                            <h3 class="text-xs font-extrabold text-slate-900">Disposisi Masuk ke UPT PUPR</h3>
                            <p class="text-[11px] text-slate-500 mt-0.5">Surat Perintah Kerja (SPK) sedang dijadwalkan oleh UPT Pemeliharaan Jalan.</p>
                        @else
                            <div class="absolute -left-[19px] top-0 w-8 h-8 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center text-xs font-bold">
                                3
                            </div>
                            <h3 class="text-xs font-semibold text-slate-400">Pengerjaan Dinas PUPR</h3>
                            <p class="text-[11px] text-slate-400 mt-0.5">Menunggu hasil validasi kecamatan terlebih dahulu.</p>
                        @endif
                    </div>

                    <!-- STEP 4: SELESAI -->
                    <div class="relative pl-6">
                        @if($laporan->id_status == 3)
                            <div class="absolute -left-[19px] top-0 w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-bold shadow-xs">
                                <i class="fa-solid fa-check-double"></i>
                            </div>
                            <h3 class="text-xs font-extrabold text-emerald-800">Perbaikan Selesai 100%</h3>
                            <p class="text-[11px] text-slate-600 mt-0.5">Ruas jalan telah selesai diperbaiki dan diverifikasi oleh pengawas UPT.</p>
                            <span class="text-[10px] text-slate-400 mt-1 block">
                                {{ $laporan->updated_at->format('d M Y, H:i') }} WIB
                            </span>
                        @else
                            <div class="absolute -left-[19px] top-0 w-8 h-8 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center text-xs font-bold">
                                4
                            </div>
                            <h3 class="text-xs font-semibold text-slate-400">Penyelesaian & BAST</h3>
                            <p class="text-[11px] text-slate-400 mt-0.5">Tahap akhir setelah rekonstruksi fisik tuntas.</p>
                        @endif
                    </div>

                </div>
            </div>

            <!-- BANTUAN & INFORMASI TIKET -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Informasi Tambahan</h3>
                <p class="text-xs text-slate-600 leading-relaxed mb-4">
                    Jika ada pembaruan kondisi mendesak terkait ruas jalan ini, Anda dapat menghubungi posko koordinasi penanganan jalan dengan menyebutkan nomor tiket:
                </p>
                <div class="bg-slate-100 rounded-xl p-3 text-center border border-slate-200 font-mono font-bold text-slate-800 text-xs mb-4">
                    LP-{{ $laporan->created_at->format('Y') }}-{{ str_pad($laporan->id_laporan, 4, '0', STR_PAD_LEFT) }}
                </div>
                <div class="text-[11px] text-slate-500 space-y-1">
                    <p><i class="fa-solid fa-phone text-slate-400 mr-1.5"></i>Call Center Jember: 112</p>
                    <p><i class="fa-solid fa-envelope text-slate-400 mr-1.5"></i>sigap@jemberkab.go.id</p>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
