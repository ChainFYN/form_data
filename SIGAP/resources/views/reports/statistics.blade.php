@extends('layouts.app')

@section('title', 'Statistik Wilayah - SIGAP')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- PAGE HEADER -->
    <div class="pb-6 border-b border-slate-200">
        <div class="flex items-center gap-2 text-xs font-bold text-slate-500 uppercase tracking-wide">
            <span>Analitik Terpadu Kecamatan Jember</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">
            Statistik Kerusakan & Pemeliharaan Jalan
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
            Visualisasi distribusi titik kerusakan, pemenuhan Service Level Agreement (SLA), dan tren aduan warga.
        </p>
    </div>

    <!-- STAT SUMMARY CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-xs font-bold text-slate-500">Total Akumulasi Aduan</span>
            <p class="text-3xl font-black text-slate-900 mt-2">{{ $totalReports }}</p>
            <span class="text-xs font-semibold text-emerald-600 mt-2 block">100% Tercatat Resmi</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-xs font-bold text-slate-500">Sedang Proses Validasi</span>
            <p class="text-3xl font-black text-amber-600 mt-2">{{ $pendingReports }}</p>
            <span class="text-xs font-semibold text-slate-400 mt-2 block">Menunggu Disposisi</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-xs font-bold text-slate-500">Diteruskan ke UPT PUPR</span>
            <p class="text-3xl font-black text-emerald-600 mt-2">{{ $forwardedReports }}</p>
            <span class="text-xs font-semibold text-emerald-600 mt-2 block">Surat Perintah Kerja Terbit</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-xs font-bold text-slate-500">Ditolak / Non-Kewenangan</span>
            <p class="text-3xl font-black text-red-600 mt-2">{{ $rejectedReports }}</p>
            <span class="text-xs font-semibold text-slate-400 mt-2 block">Jalan Swadaya / Duplikasi</span>
        </div>
    </div>

    <!-- CHARTS GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 mt-7">
        
        <!-- Bar Chart: Sebaran per Desa/Kelurahan (8 cols) -->
        <div class="lg:col-span-8 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Sebaran Aduan Berdasarkan Desa & Kelurahan</h3>
                    <p class="text-xs text-slate-500">Jumlah titik aduan kerusakan jalan di 6 kelurahan/desa wilayah jember</p>
                </div>
                <span class="text-xs font-mono font-bold bg-slate-100 px-2 py-1 rounded">2026 YTD</span>
            </div>
            <div class="h-80">
                <canvas id="villageBarChart"></canvas>
            </div>
        </div>

        <!-- Doughnut Chart: Urgensi (4 cols) -->
        <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Komposisi Tingkat Urgensi</h3>
                <p class="text-xs text-slate-500">Klasifikasi prioritas tindakan UPT</p>
                <div class="h-64 mt-4 flex items-center justify-center">
                    <canvas id="urgencyDoughnutChart"></canvas>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 mt-4 pt-4 border-t border-slate-100 text-xs">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-500"></span>
                    <span class="text-slate-600">Darurat: <strong>{{ $urgencyBreakdown['darurat'] }}</strong></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                    <span class="text-slate-600">Tinggi: <strong>{{ $urgencyBreakdown['tinggi'] }}</strong></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                    <span class="text-slate-600">Sedang: <strong>{{ $urgencyBreakdown['sedang'] }}</strong></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                    <span class="text-slate-600">Normal: <strong>{{ $urgencyBreakdown['normal'] }}</strong></span>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Village Bar Chart
        const ctxBar = document.getElementById('villageBarChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: {!! json_encode($villages->pluck('name')) !!},
                datasets: [{
                    label: 'Aduan Aktif',
                    data: {!! json_encode($villages->pluck('active_reports_count')) !!},
                    backgroundColor: '#ea580c',
                    borderRadius: 8,
                }, {
                    label: 'Selesai Ditangani',
                    data: {!! json_encode($villages->pluck('resolved_reports_count')) !!},
                    backgroundColor: '#10b981',
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Urgency Doughnut Chart
        const ctxDoughnut = document.getElementById('urgencyDoughnutChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Darurat', 'Tinggi', 'Sedang', 'Normal'],
                datasets: [{
                    data: [
                        {{ $urgencyBreakdown['darurat'] }},
                        {{ $urgencyBreakdown['tinggi'] }},
                        {{ $urgencyBreakdown['sedang'] }},
                        {{ $urgencyBreakdown['normal'] }}
                    ],
                    backgroundColor: ['#ef4444', '#f59e0b', '#3b82f6', '#10b981'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endpush
