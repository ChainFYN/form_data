@extends('kecamatan.layouts.app')

@section('title', 'Dashboard Admin Kecamatan')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- KPI CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">PERLU TINDAKAN</div>
                <div class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center border border-red-100">
                    <i class="fa-solid fa-triangle-exclamation text-xs"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-4xl font-extrabold text-slate-900">{{ $perluTindakanCount }}</div>
                <div class="text-xs font-bold text-slate-500">Laporan Darurat</div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-bold mt-2">
                <span class="bg-red-100 text-red-800 px-2 py-0.5 rounded">Butuh Respon Cepat</span>
                <span class="text-red-600"><i class="fa-solid fa-arrow-up mr-1"></i>SLA < 2 Jam</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">MENUNGGU VALIDASI</div>
                <div class="w-8 h-8 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center border border-amber-100">
                    <i class="fa-solid fa-clock text-xs"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-4xl font-extrabold text-slate-900">{{ $menungguValidasiCount }}</div>
                <div class="text-xs font-bold text-slate-500">Laporan Baru</div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-bold mt-2">
                <span class="text-slate-600"><i class="fa-solid fa-circle text-[8px] text-amber-500 mr-1"></i>Antrean Verifikasi</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">DITERUSKAN KE PUPR</div>
                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center border border-blue-100">
                    <i class="fa-solid fa-share text-xs"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-4xl font-extrabold text-slate-900">{{ $terverifikasiCount }}</div>
                <div class="text-xs font-bold text-slate-500">Disposisi</div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-bold mt-2">
                <span class="text-blue-600">Diproses oleh Dinas</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">SELESAI / DITOLAK</div>
                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center border border-slate-200">
                    <i class="fa-solid fa-check-double text-xs"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-4xl font-extrabold text-slate-900">{{ $totalResolvedRuas + $ditolakCount }}</div>
                <div class="text-xs font-bold text-slate-500">Total Tiket</div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-bold mt-2">
                <span class="text-emerald-700">{{ $totalResolvedRuas }} Selesai</span>
                <span class="text-red-700">{{ $ditolakCount }} Ditolak</span>
            </div>
        </div>

    </div>

    <!-- MAIN TWO COLUMNS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- LEFT: DAFTAR LAPORAN -->
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900">Daftar Antrean Validasi Prioritas</h2>
                    <p class="text-xs text-slate-500 font-medium">Laporan masuk dari warga yang membutuhkan pemeriksaan dan disposisi Kecamatan.</p>
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
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <div class="text-[10px] font-mono font-bold text-slate-500">
                                #LP-{{ $report->created_at->format('Y') }}-{{ str_pad($report->id_laporan, 4, '0', STR_PAD_LEFT) }}
                            </div>
                            <span class="text-[10px] font-bold bg-blue-50 text-blue-700 px-2 py-0.5 rounded border border-blue-200">{{ $report->status->nama_status ?? 'Menunggu Validasi' }}</span>
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900 mb-1">Jl. {{ $report->jalan->nama_jalan ?? 'Tidak diketahui' }} ({{ $report->jalan->desa->nama_desa ?? '-' }})</h3>
                        <p class="text-[11px] text-slate-600 leading-relaxed mb-3">Kategori: <strong>{{ $report->kategori->nama_kategori ?? '-' }}</strong>. {{ Str::limit($report->deskripsi, 80) }}</p>

                        <div class="flex items-center gap-4 mb-3">
                            <div class="flex items-center gap-1.5 text-[10px] font-bold {{ $report->tingkat_bahaya === 'Bahaya Tinggi' ? 'text-red-700 bg-red-50 border-red-200' : 'text-slate-700 bg-slate-100 border-slate-200' }} border px-2.5 py-1.5 rounded-lg">
                                <i class="fa-solid fa-user"></i> Dilaporkan oleh: {{ $report->pengguna->nama_lengkap ?? 'Warga' }}
                            </div>
                            <div class="flex items-center gap-1.5 text-[10px] text-slate-600 font-medium">
                                <i class="fa-solid fa-location-dot text-slate-400"></i> Kec. {{ $report->jalan->desa->kecamatan->nama_kecamatan ?? '-' }}
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="flex items-center gap-1.5 text-[9px] text-slate-500 font-bold">
                                <i class="fa-solid fa-calendar-day"></i> Dilaporkan pada: {{ $report->created_at->format('d M Y, H:i') }} WIB
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('kecamatan.validation.index', ['ticket' => $report->id_laporan]) }}" class="px-4 py-1.5 text-[10px] font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-lg shadow-xs transition-colors">Validasi Laporan</a>
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

        <!-- RIGHT: REKAPITULASI -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs sticky top-28">

                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900">Rekapitulasi Cepat</h3>
                        </div>
                    </div>
                </div>

                <div class="p-5">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-4">AKSI CEPAT</div>
                    <div class="space-y-3">
                        <a href="{{ route('kecamatan.validation.index') }}" class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center"><i class="fa-solid fa-list-check"></i></div>
                                <span class="text-xs font-bold text-slate-700">Validasi Laporan</span>
                            </div>
                            <i class="fa-solid fa-chevron-right text-slate-400 text-[10px]"></i>
                        </a>
                        <a href="#" class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center"><i class="fa-solid fa-map-location-dot"></i></div>
                                <span class="text-xs font-bold text-slate-700">Peta Sebaran Laporan</span>
                            </div>
                            <i class="fa-solid fa-chevron-right text-slate-400 text-[10px]"></i>
                        </a>
                        <a href="#" class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center"><i class="fa-solid fa-file-signature"></i></div>
                                <span class="text-xs font-bold text-slate-700">Cetak BAP</span>
                            </div>
                            <i class="fa-solid fa-chevron-right text-slate-400 text-[10px]"></i>
                        </a>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">KINERJA KECAMATAN</div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-[10px] font-bold mb-1.5">
                                    <span class="text-slate-700">Akurasi Validasi</span>
                                    <span class="text-emerald-600">98%</span>
                                </div>
                                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500" style="width: 98%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-[10px] font-bold mb-1.5">
                                    <span class="text-slate-700">Laporan Selesai / Disetujui PUPR</span>
                                    <span class="text-blue-600">65%</span>
                                </div>
                                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-500" style="width: 65%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-[10px] font-bold mb-1.5">
                                    <span class="text-slate-700">Rata-rata Waktu Respon</span>
                                    <span class="text-slate-900">< 4 Jam</span>
                                </div>
                                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-slate-900" style="width: 80%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>
@endsection
