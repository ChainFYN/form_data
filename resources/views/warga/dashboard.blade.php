@extends('warga.layouts.app')

@section('title', 'Dashboard Warga')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- WELCOME BANNER -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-2xl p-6 sm:p-8 text-white mb-8 shadow-sm relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white pointer-events-none">
            <i class="fa-solid fa-users text-9xl"></i>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-semibold mb-3 border border-emerald-500/30">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Portal Warga Pelapor SIGAP
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Selamat Datang, {{ session('warga_name', 'Warga Jember') }}!
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm mt-1 max-w-2xl leading-relaxed">
                    Sampaikan laporan kondisi kerusakan infrastruktur jalan di lingkungan Anda secara langsung dan pantau proses verifikasi hingga perbaikan lapangan secara transparan.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('warga.laporan.create') }}" class="px-5 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold text-xs sm:text-sm transition flex items-center gap-2 shadow-lg shadow-emerald-500/20">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span>Buat Laporan Baru</span>
                </a>
            </div>
        </div>
    </div>

    <!-- KPI STAT CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        
        <!-- Menunggu -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">MENUNGGU VERIFIKASI</div>
                <div class="w-8 h-8 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center border border-amber-100">
                    <i class="fa-solid fa-clock text-xs"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-4xl font-extrabold text-slate-900">{{ $statistik['menunggu'] ?? 0 }}</div>
                <div class="text-xs font-bold text-slate-500">Tiket Laporan</div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-bold mt-2">
                <span class="bg-amber-100 text-amber-800 px-2 py-0.5 rounded">Antrean Kecamatan</span>
                <span class="text-amber-600">Verifikasi Lapangan</span>
            </div>
        </div>

        <!-- Diproses -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">SEDANG DIPROSES PUPR</div>
                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center border border-blue-100">
                    <i class="fa-solid fa-screwdriver-wrench text-xs"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-4xl font-extrabold text-slate-900">{{ $statistik['diproses'] ?? 0 }}</div>
                <div class="text-xs font-bold text-slate-500">Tiket SPK</div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-bold mt-2">
                <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded">Pengerjaan UPT</span>
                <span class="text-blue-600">Jadwal Perbaikan</span>
            </div>
        </div>

        <!-- Selesai -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">SELESAI DITANGANI</div>
                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center border border-emerald-100">
                    <i class="fa-solid fa-check-double text-xs"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-4xl font-extrabold text-slate-900">{{ $statistik['selesai'] ?? 0 }}</div>
                <div class="text-xs font-bold text-slate-500">Ruas Jalan</div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-bold mt-2">
                <span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded">100% Rampung</span>
                <span class="text-emerald-600">BAST Terbit</span>
            </div>
        </div>

        <!-- Total -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">TOTAL LAPORAN SAYA</div>
                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center border border-slate-200">
                    <i class="fa-solid fa-folder-open text-xs"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-4xl font-extrabold text-slate-900">{{ $statistik['total'] ?? 0 }}</div>
                <div class="text-xs font-bold text-slate-500">Keseluruhan</div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-bold mt-2">
                <span class="text-slate-600">Histori Aduan</span>
                <span class="text-slate-500 font-semibold">{{ $statistik['ditolak'] ?? 0 }} Ditolak</span>
            </div>
        </div>

    </div>

    <!-- MAIN TWO COLUMNS CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- LEFT: DAFTAR LAPORAN TERKINI -->
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900">Riwayat Laporan Terkini Anda</h2>
                    <p class="text-xs text-slate-500 font-medium">Pantau status laporan terkini yang telah berhasil dikirimkan ke sistem.</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('warga.laporan.index') }}" class="px-4 py-2 text-xs font-bold bg-white text-slate-900 border border-slate-200 rounded-xl hover:bg-slate-100 shadow-xs flex items-center gap-1.5 transition">
                        <span>Lihat Semua</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                @forelse($recentLaporan as $item)
                    <div class="bg-white rounded-2xl p-4 border {{ $item->tingkat_bahaya === 'Bahaya Tinggi' ? 'border-red-200 ring-1 ring-red-500/20' : 'border-slate-200' }} shadow-xs flex flex-col sm:flex-row gap-5 relative overflow-hidden transition-all hover:shadow-md">
                        @if($item->tingkat_bahaya === 'Bahaya Tinggi')
                            <div class="absolute top-0 left-0 w-1.5 h-full bg-red-500"></div>
                        @endif

                        <!-- Foto Thumbnail -->
                        <div class="w-full sm:w-44 h-32 rounded-xl overflow-hidden relative shrink-0 bg-slate-100">
                            @if($item->url_foto)
                                <img src="{{ asset('storage/' . $item->url_foto) }}" alt="Foto kerusakan jalan" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 flex-col gap-1">
                                    <i class="fa-solid fa-image text-2xl"></i>
                                    <span class="text-[10px]">Foto tidak ada</span>
                                </div>
                            @endif
                            <div class="absolute top-2 left-2 {{ $item->tingkat_bahaya === 'Bahaya Tinggi' ? 'bg-red-600' : ($item->tingkat_bahaya === 'Sedang' ? 'bg-amber-500' : 'bg-slate-700') }} text-white text-[10px] font-extrabold px-2 py-0.5 rounded uppercase tracking-wider">
                                {{ $item->tingkat_bahaya }}
                            </div>
                        </div>

                        <!-- Laporan Info -->
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-1.5">
                                    <div class="text-[11px] font-mono font-bold text-slate-500">
                                        #LP-{{ $item->created_at->format('Y') }}-{{ str_pad($item->id_laporan, 4, '0', STR_PAD_LEFT) }}
                                    </div>

                                    <!-- Status Badge -->
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
                                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-0.5 rounded-full border {{ $badgeBg }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                        {{ $item->status->nama_status ?? 'Menunggu' }}
                                    </span>
                                </div>

                                <h3 class="text-sm font-extrabold text-slate-900 mb-1">
                                    Jl. {{ $item->jalan->nama_jalan ?? '-' }}
                                    <span class="font-normal text-slate-500 text-xs">
                                        ({{ $item->jalan->desa->nama_desa ?? '-' }}, Kec. {{ $item->jalan->desa->kecamatan->nama_kecamatan ?? '-' }})
                                    </span>
                                </h3>

                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[10px] font-bold bg-slate-100 text-slate-600 px-2 py-0.5 rounded border border-slate-200">
                                        <i class="fa-solid fa-tag text-[9px] mr-1"></i>{{ $item->kategori->nama_kategori ?? 'Umum' }}
                                    </span>
                                    <span class="text-[10px] text-slate-400">
                                        <i class="fa-regular fa-calendar mr-1"></i>{{ $item->created_at->format('d M Y, H:i') }} WIB
                                    </span>
                                </div>

                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                                    {{ $item->deskripsi }}
                                </p>
                            </div>

                            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between">
                                <div class="text-[11px] text-slate-500">
                                    @if($item->latitude && $item->longitude)
                                        <span class="text-emerald-700 font-semibold"><i class="fa-solid fa-location-dot mr-1"></i>GPS Terdata</span>
                                    @else
                                        <span class="text-slate-400"><i class="fa-solid fa-location-crosshairs mr-1"></i>Tanpa GPS</span>
                                    @endif
                                </div>
                                <a href="{{ route('warga.laporan.show', $item->id_laporan) }}" class="text-xs font-bold text-slate-900 hover:text-brand-600 flex items-center gap-1.5 group">
                                    <span>Detail Penanganan</span>
                                    <i class="fa-solid fa-chevron-right text-[10px] transition-transform group-hover:translate-x-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-10 border border-slate-200 text-center">
                        <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                            <i class="fa-regular fa-folder-open text-2xl"></i>
                        </div>
                        <h4 class="text-base font-extrabold text-slate-900 mb-1">Belum Ada Laporan</h4>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto mb-5 leading-relaxed">
                            Anda belum pernah mengirimkan laporan kerusakan jalan. Bantu laporkan kerusakan jalan di wilayah Anda sekarang.
                        </p>
                        <a href="{{ route('warga.laporan.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition">
                            <i class="fa-solid fa-plus"></i>
                            <span>Buat Laporan Pertama</span>
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- RIGHT: INFORMASI & PANDUAN WARGA -->
        <div class="flex flex-col gap-6">

            <!-- Card Buat Laporan Cepat -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center">
                        <i class="fa-solid fa-road-barrier text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 leading-tight">Laporkan Kerusakan Jalan</h3>
                        <p class="text-[11px] text-slate-500">Ambil foto & tentukan titik lokasi</p>
                    </div>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed mb-4">
                    Sistem SIGAP mempercepat respon penanganan kerusakan jalan di Kabupaten Jember dengan menghubungkan aduan Anda ke Kantor Kecamatan dan Dinas PUPR.
                </p>
                <a href="{{ route('warga.laporan.create') }}" class="w-full py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 shadow-xs">
                    <i class="fa-solid fa-camera"></i>
                    <span>Kirim Aduan Baru</span>
                </a>
            </div>

            <!-- Card Alur Penanganan Stepper -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Alur Kerja Penanganan SIGAP</h3>
                <ol class="relative border-l border-slate-200 ml-3 space-y-5">
                    <li class="relative pl-6">
                        <span class="absolute -left-3 top-0.5 flex h-6 w-6 items-center justify-center rounded-full bg-slate-900 text-white text-[11px] font-bold">1</span>
                        <h4 class="text-xs font-bold text-slate-900">Warga Mengirim Laporan</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Sertakan foto kondisi jalan, alamat jalan desa, dan koordinat GPS.</p>
                    </li>
                    <li class="relative pl-6">
                        <span class="absolute -left-3 top-0.5 flex h-6 w-6 items-center justify-center rounded-full bg-amber-500 text-white text-[11px] font-bold">2</span>
                        <h4 class="text-xs font-bold text-slate-900">Validasi Kecamatan</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Admin Kecamatan memverifikasi kebenaran dan tingkat urgensi aduan.</p>
                    </li>
                    <li class="relative pl-6">
                        <span class="absolute -left-3 top-0.5 flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-white text-[11px] font-bold">3</span>
                        <h4 class="text-xs font-bold text-slate-900">Penanganan Dinas PUPR</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">UPT Bina Marga menerbitkan SPK dan menurunkan tim teknis lapangan.</p>
                    </li>
                    <li class="relative pl-6">
                        <span class="absolute -left-3 top-0.5 flex h-6 w-6 items-center justify-center rounded-full bg-emerald-600 text-white text-[11px] font-bold">4</span>
                        <h4 class="text-xs font-bold text-slate-900">Selesai & BAST Terbit</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Perbaikan rampung 100% dan bukti fisik dipublikasikan di sistem.</p>
                    </li>
                </ol>
            </div>

            <!-- Card Tips Laporan -->
            <div class="bg-slate-100 rounded-2xl p-5 border border-slate-200">
                <div class="flex items-center gap-2 mb-2 text-slate-900 font-bold text-xs">
                    <i class="fa-solid fa-lightbulb text-amber-500"></i>
                    <span>Tips Agar Laporan Cepat Diverifikasi</span>
                </div>
                <ul class="text-[11px] text-slate-600 space-y-1.5 leading-relaxed">
                    <li>&bull; Ambil foto dengan sudut yang memperlihatkan skala kerusakan dan patokan sekitar.</li>
                    <li>&bull; Tekan tombol <strong>Ambil Lokasi Sekarang</strong> agar titik GPS akurat otomatis tersimpan.</li>
                    <li>&bull; Beri deskripsi jelas seperti nomor rumah terdekat atau nama persimpangan.</li>
                </ul>
            </div>

        </div>

    </div>

</div>
@endsection
