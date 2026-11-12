@extends('warga.layouts.app')

@section('title', 'Dashboard Warga')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- WELCOME BANNER -->
    <div class="bg-slate-900 rounded-2xl p-6 sm:p-8 text-white mb-4 shadow-sm relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Selamat Datang, {{ session('warga_name', 'Warga Jember') }}!
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm mt-1 max-w-2xl leading-relaxed">
                    Sampaikan laporan kondisi kerusakan infrastruktur jalan di lingkungan Anda secara langsung dan pantau proses verifikasi hingga perbaikan lapangan secara transparan.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('warga.laporan.create') }}" class="px-5 py-3 rounded-xl bg-[#F5F5F5] saturate-50 hover:bg-[#f2ddd1] text-slate-900 font-bold text-xs sm:text-sm transition flex items-center gap-2 shadow-lg shadow-black/10">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span>Buat Laporan Baru</span>
                </a>
            </div>
        </div>
    </div>

    <!-- KPI STAT CARDS -->
    @php
        $selectedStatus = request('status');
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">

        <!-- Menunggu -->
        <a href="{{ route('warga.laporan.index', ['status' => 1]) }}" class="block bg-[#FCFAF9] rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32 transition-all hover:shadow-md {{ $selectedStatus == 1 ? 'border-[#0B4F6C] border-2 ring-2 ring-[#0B4F6C]/15 shadow-lg shadow-[#0B4F6C]/10' : 'border-slate-200' }}">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">MENUNGGU VERIFIKASI</div>
            </div>
            <div class="flex items-center justify-center h-full">
                <div class="text-4xl font-extrabold text-slate-900">{{ $statistik['menunggu'] ?? 0 }}</div>
            </div>
        </a>

        <!-- Diproses -->
        <a href="{{ route('warga.laporan.index', ['status' => 2]) }}" class="block bg-[#FCFAF9] rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32 transition-all hover:shadow-md {{ $selectedStatus == 2 ? 'border-[#0B4F6C] border-2 ring-2 ring-[#0B4F6C]/15 shadow-lg shadow-[#0B4F6C]/10' : 'border-slate-200' }}">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">SEDANG DIPROSES PUPR</div>
            </div>
            <div class="flex items-center justify-center h-full">
                <div class="text-4xl font-extrabold text-slate-900">{{ $statistik['diproses'] ?? 0 }}</div>
            </div>
        </a>

        <!-- Selesai -->
        <a href="{{ route('warga.laporan.index', ['status' => 3]) }}" class="block bg-[#FCFAF9] rounded-2xl p-5 border border-[#0B4F6C] shadow-xs relative overflow-hidden flex flex-col justify-between h-32 transition-all hover:shadow-md {{ $selectedStatus == 3 ? 'border-[#0B4F6C] border-2 ring-2 ring-[#0B4F6C]/15 shadow-lg shadow-[#0B4F6C]/10' : 'border-slate-200' }}">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">SELESAI DITANGANI</div>
            </div>
            <div class="flex items-center justify-center h-full">
                <div class="text-4xl font-extrabold text-slate-900">{{ $statistik['selesai'] ?? 0 }}</div>
            </div>
        </a>

        <!-- Total -->
        <a href="{{ route('warga.laporan.index') }}" class="block bg-[#FCFAF9] rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32 transition-all hover:shadow-md">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">TOTAL LAPORAN SAYA</div>
            </div>
            <div class="flex items-center justify-center h-full">
                <div class="text-4xl font-extrabold text-slate-900">{{ $statistik['total'] ?? 0 }}</div>
            </div>
        </a>
    </div>
    <section class="bg-[#FCFAF9] rounded-2xl border border-slate-200 shadow-xs p-6 sm:p-8 mb-4">
        <h3 class="text-center text-xs font-bold uppercase tracking-wider text-slate-400 mb-8">Alur Kerja Penanganan SIGAP</h3>

        <ol class="relative grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-4">
            <!-- Garis penghubung (hanya tampil di desktop) -->
            <div class="hidden md:block absolute top-8 left-[12.5%] right-[12.5%] h-0.5 bg-slate-200"></div>

            <li class="relative flex flex-col items-center text-center">
                <span class="relative z-10 flex h-16 w-16 items-center justify-center rounded-full bg-slate-900 text-white text-xl shadow-md">
                    <i class="fa-solid fa-camera"></i>
                </span>
                <span class="mt-4 text-[11px] font-bold uppercase tracking-wide text-slate-500">Langkah 1</span>
                <h4 class="mt-1 text-sm font-extrabold text-slate-900">Buat Laporan</h4>
                <p class="mt-1.5 text-xs text-slate-500 leading-relaxed max-w-[15rem]">Sertakan foto kondisi jalan, alamat jalan desa, dan koordinat GPS.</p>
            </li>

            <li class="relative flex flex-col items-center text-center">
                <span class="relative z-10 flex h-16 w-16 items-center justify-center rounded-full bg-amber-500 text-white text-xl shadow-md">
                    <i class="fa-solid fa-clipboard-check"></i>
                </span>
                <span class="mt-4 text-[11px] font-bold uppercase tracking-wide text-amber-600">Langkah 2</span>
                <h4 class="mt-1 text-sm font-extrabold text-slate-900">Validasi Kecamatan</h4>
                <p class="mt-1.5 text-xs text-slate-500 leading-relaxed max-w-[15rem]">Kecamatan memverifikasi kebenaran dan tingkat urgensi aduan.</p>
            </li>

            <li class="relative flex flex-col items-center text-center">
                <span class="relative z-10 flex h-16 w-16 items-center justify-center rounded-full bg-blue-600 text-white text-xl shadow-md">
                    <i class="fa-solid fa-helmet-safety"></i>
                </span>
                <span class="mt-4 text-[11px] font-bold uppercase tracking-wide text-blue-600">Langkah 3</span>
                <h4 class="mt-1 text-sm font-extrabold text-slate-900">Penanganan Dinas PUPR</h4>
                <p class="mt-1.5 text-xs text-slate-500 leading-relaxed max-w-[15rem]">UPT Bina Marga menerbitkan SPK dan menurunkan tim teknis lapangan.</p>
            </li>

            <li class="relative flex flex-col items-center text-center">
                <span class="relative z-10 flex h-16 w-16 items-center justify-center rounded-full bg-emerald-600 text-white text-xl shadow-md">
                    <i class="fa-solid fa-circle-check"></i>
                </span>
                <span class="mt-4 text-[11px] font-bold uppercase tracking-wide text-emerald-600">Langkah 4</span>
                <h4 class="mt-1 text-sm font-extrabold text-slate-900">Selesai &amp; BAST Terbit</h4>
                <p class="mt-1.5 text-xs text-slate-500 leading-relaxed max-w-[15rem]">Perbaikan rampung 100% dan bukti fisik dipublikasikan di sistem.</p>
            </li>
        </ol>
    </section>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900">Riwayat Laporan Terkini Anda</h2>
                </div>

                <!-- Filter Waktu -->
                <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-xl text-xs" id="filter-waktu-group">
                    <button type="button" onclick="applyFilter('all', this)"
                       class="filter-btn px-3 py-1.5 rounded-lg font-bold transition-all {{ $timeFilter === 'all' || !$timeFilter ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                        Semua
                    </button>
                    <button type="button" onclick="applyFilter('hari_ini', this)"
                       class="filter-btn px-3 py-1.5 rounded-lg font-bold transition-all {{ $timeFilter === 'hari_ini' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                        Hari Ini
                    </button>
                    <button type="button" onclick="applyFilter('kemarin', this)"
                       class="filter-btn px-3 py-1.5 rounded-lg font-bold transition-all {{ $timeFilter === 'kemarin' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                        Kemarin
                    </button>
                    <button type="button" onclick="applyFilter('1_minggu', this)"
                       class="filter-btn px-3 py-1.5 rounded-lg font-bold transition-all {{ $timeFilter === '1_minggu' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                        1 Minggu Terakhir
                    </button>
                    <button type="button" onclick="applyFilter('1_bulan', this)"
                       class="filter-btn px-3 py-1.5 rounded-lg font-bold transition-all {{ $timeFilter === '1_bulan' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                        Sebulan Terakhir
                    </button>
                </div>

            </div>
            <div>
                <div>
                    <div>
                        <div id="riwayat-container">
                            @include('warga.partials.riwayat_list')
                        </div>
                    </div>
                </div>
            </div>
@endsection


<script>
function applyFilter(waktu, el) {
    const container = document.getElementById('riwayat-container');

    // 1. Efek loading halus (redupkan sementara)
    container.style.opacity = '0.5';

    // 2. Request AJAX ke controller
    fetch(`{{ route('warga.dashboard') }}?waktu=${waktu}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        // Ganti isi daftar riwayat
        container.innerHTML = html;
        container.style.opacity = '1';

        // 3. KUNCI UTAMA: Ganti URL tanpa menumpuk riwayat browser (Back tetap normal)
        const url = new URL(window.location);
        if (waktu === 'all') {
            url.searchParams.delete('waktu');
        } else {
            url.searchParams.set('waktu', waktu);
        }
        window.history.replaceState({}, '', url);

        // 4. Perbarui tampilan tombol aktif (styling Tailwind)
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.className = 'filter-btn px-3 py-1.5 rounded-lg font-bold transition-all text-slate-600 hover:text-slate-900';
        });
        el.className = 'filter-btn px-3 py-1.5 rounded-lg font-bold transition-all bg-white text-slate-900 shadow-xs';
    })
    .catch(err => {
        console.error('Gagal memuat data:', err);
        container.style.opacity = '1';
    });
}
</script>
