@extends('pupr.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Riwayat Penanganan Laporan</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar progres pekerjaan fisik lapangan (25% - 100%) dan status verifikasi BAST.</p>
        </div>

        <!-- Filter Tab -->
        <div class="flex items-center gap-2 bg-slate-200/70 p-1 rounded-xl text-xs font-bold">
            <a href="{{ route('pupr.riwayat', ['status' => 'semua']) }}"
               class="px-4 py-2 rounded-lg transition-all {{ $filterStatus === 'semua' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                Semua (25% - 100%)
            </a>
            <a href="{{ route('pupr.riwayat', ['status' => '25-75']) }}"
               class="px-4 py-2 rounded-lg transition-all {{ $filterStatus === '25-75' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                Sedang Berjalan (25% - 75%)
            </a>
            <a href="{{ route('pupr.riwayat', ['status' => '100']) }}"
               class="px-4 py-2 rounded-lg transition-all {{ $filterStatus === '100' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                Selesai (100%)
            </a>
        </div>
    </div>

    <!-- Tabel / List Riwayat -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($riwayatLaporan->isEmpty())
            <div class="p-12 text-center text-slate-400">
                <i class="fa-solid fa-clipboard-list text-4xl mb-3 text-slate-300"></i>
                <p class="font-medium text-slate-600">Belum ada riwayat laporan pada tahapan 25% - 100%.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-extrabold text-slate-500 tracking-wider">
                            <th class="py-4 px-6">Tiket & Lokasi</th>
                            <th class="py-4 px-6">Capaian Progres</th>
                            <th class="py-4 px-6">Status Validasi (100%)</th>
                            <th class="py-4 px-6">Update Terakhir</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @foreach($riwayatLaporan as $laporan)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- Tiket & Jalan -->
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $laporan->kode_tiket }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">
                                    <i class="fa-solid fa-location-dot text-amber-500 mr-1"></i>
                                    {{ $laporan->jalan->nama_jalan ?? 'Lokasi tidak terdata' }}
                                </div>
                            </td>

                            <!-- Progres Bar & Badge -->
                            <td class="py-4 px-6">
                                <div class="w-48">
                                    <div class="flex justify-between items-center mb-1 text-xs font-bold">
                                        <span class="text-slate-700">{{ $laporan->progres_persen }}%</span>
                                        <span class="text-[11px] text-slate-400">
                                            @if($laporan->progres_persen == 25) Pengecekan
                                            @elseif($laporan->progres_persen == 50) Persiapan Material
                                            @elseif($laporan->progres_persen == 75) Pengerjaan Fisik
                                            @else Selesai Lapangan @endif
                                        </span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                        <div class="h-2.5 rounded-full transition-all duration-300 {{ $laporan->progres_persen == 100 ? 'bg-emerald-500' : 'bg-amber-500' }}"
                                             style="width: {{ $laporan->progres_persen }}%"></div>
                                    </div>
                                </div>
                            </td>

                            <!-- Status Validasi Khusus 100% -->
                            <td class="py-4 px-6">
                                @if($laporan->progres_persen >= 100)
                                    @if($laporan->status_validasi_100 === 'menunggu_validasi')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <i class="fa-solid fa-clock-rotate-left animate-spin text-[10px]"></i>
                                            Menunggu Validasi
                                        </span>
                                    @elseif($laporan->status_validasi_100 === 'tervalidasi')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                            Tervalidasi
                                        </span>
                                    @elseif($laporan->status_validasi_100 === 'tidak_tervalidasi')
                                        <div class="flex flex-col gap-1">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                <i class="fa-solid fa-circle-xmark text-rose-600"></i>
                                                Tidak Tervalidasi
                                            </span>
                                            @if($laporan->catatan_bast)
                                                <span class="text-[11px] text-rose-600 italic">"{{ Str::limit($laporan->catatan_bast, 35) }}"</span>
                                            @endif
                                        </div>
                                    @endif
                                @else
                                    <span class="text-xs text-slate-400 italic">Tahap Pengerjaan</span>
                                @endif
                            </td>

                            <!-- Update Terakhir -->
                            <td class="py-4 px-6 text-xs text-slate-500">
                                {{ $laporan->updated_at ? $laporan->updated_at->diffForHumans() : '-' }}
                            </td>

                            <!-- Aksi Edit / Draft -->
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('pupr.progres.show', $laporan->id_laporan) }}"
                                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold transition-all shadow-xs {{ $laporan->status_validasi_100 === 'tidak_tervalidasi' ? 'bg-rose-600 hover:bg-rose-700 text-white' : 'bg-slate-900 hover:bg-slate-800 text-white' }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    {{ $laporan->status_validasi_100 === 'tidak_tervalidasi' ? 'Perbaiki / Edit' : 'Edit Draft' }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
