@extends('kecamatan.layouts.app')

@section('title', 'Dashboard Admin Kecamatan')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- TOP HEADER & TIME FILTER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Dashboard Kecamatan</h1>
        </div>

        <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-xl self-start md:self-auto overflow-x-auto max-w-full text-xs">
            <span class="px-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider hidden sm:inline-flex items-center gap-1">
                <i class="fa-regular fa-calendar text-[11px]"></i> Filter:
            </span>
            <button type="button" onclick="filterKecamatan('all', this)"
               class="filter-kec-btn px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $timeFilter === 'all' || !$timeFilter ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Semua
            </button>
            <button type="button" onclick="filterKecamatan('hari_ini', this)"
               class="filter-kec-btn px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $timeFilter === 'hari_ini' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Hari Ini
            </button>
            <button type="button" onclick="filterKecamatan('kemarin', this)"
               class="filter-kec-btn px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $timeFilter === 'kemarin' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Kemarin
            </button>
            <button type="button" onclick="filterKecamatan('1_minggu', this)"
               class="filter-kec-btn px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $timeFilter === '1_minggu' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                1 Minggu Terakhir
            </button>
            <button type="button" onclick="filterKecamatan('1_bulan', this)"
               class="filter-kec-btn px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap {{ $timeFilter === '1_bulan' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Sebulan Terakhir
            </button>
        </div>

    </div>

    <!-- KPI CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32 text-center">
            <div class="flex items-center justify-center">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">PERLU TINDAKAN</div>
            </div>
            <div class="flex items-center justify-center h-full">
                <div class="text-4xl font-extrabold text-slate-900">{{ $perluTindakanCount }}</div>
            </div>
        </div>

        <a href="{{ route('kecamatan.validation.index', ['tab' => 'pending']) }}" class="block bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32 transition-all hover:shadow-md hover:border-slate-300 text-center">
            <div class="flex items-center justify-center">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">MENUNGGU VALIDASI</div>
            </div>
            <div class="flex items-center justify-center h-full">
                <div class="text-4xl font-extrabold text-slate-900">{{ $menungguValidasiCount }}</div>
            </div>
        </a>

        <a href="{{ route('kecamatan.validation.index', ['tab' => 'selesai']) }}" class="block bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32 transition-all hover:shadow-md hover:border-slate-300 text-center">
            <div class="flex items-center justify-center">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">DITERUSKAN KE PUPR</div>
            </div>
            <div class="flex items-center justify-center h-full">
                <div class="text-4xl font-extrabold text-slate-900">{{ $terverifikasiCount }}</div>
            </div>
        </a>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32 text-center">
            <div class="flex items-center justify-center">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">BAST SELESAI DIVERIFIKASI</div>
            </div>
            <div class="flex items-center justify-center h-full">
                <div class="text-4xl font-extrabold text-slate-900">{{ $totalResolvedRuas }}</div>
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

        <div id="antrean-container">
            @include('kecamatan.partials.antrean_list')
        </div>
    </div>

</div>
@endsection

<script>
function filterKecamatan(waktu, el) {
    const container = document.getElementById('antrean-container');
    if (!container) return;

    container.style.opacity = '0.5';

    fetch(`{{ route('kecamatan.dashboard') }}?waktu=${waktu}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        // Hanya memperbarui daftar antrean
        container.innerHTML = html;
        container.style.opacity = '1';

        // Update URL tanpa menumpuk riwayat browser (Back tetap normal)
        const url = new URL(window.location);
        if (waktu === 'all') {
            url.searchParams.delete('waktu');
        } else {
            url.searchParams.set('waktu', waktu);
        }
        window.history.replaceState({}, '', url);

        // Update active class tombol
        document.querySelectorAll('.filter-kec-btn').forEach(btn => {
            btn.className = 'filter-kec-btn px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap text-slate-600 hover:text-slate-900';
        });
        el.className = 'filter-kec-btn px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap bg-white text-slate-900 shadow-xs';
    })
    .catch(error => {
        console.error('Error filter antrean:', error);
        container.style.opacity = '1';
    });
}
</script>
