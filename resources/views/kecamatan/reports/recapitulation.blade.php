@extends('kecamatan.layouts.app')

@section('title', 'Rekapitulasi Progres Aduan Jalan -  SIGAP')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 uppercase tracking-wide">
                <span>Layanan Kecamatan Jember</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">
                Rekapitulasi Progres Penanganan Jalan
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Data terpadu seluruh aduan kerusakan infrastruktur jalan di wilayah Kecamatan jember.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('kecamatan.reports.export-bap') }}" 
               class="bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold px-3.5 py-2.5 rounded-xl border border-slate-300 shadow-2xs transition-colors flex items-center gap-2">
                <i class="fa-solid fa-file-pdf text-red-500"></i>
                <span>Cetak Rekap BAP</span>
            </a>
            <a href="{{ route('kecamatan.reports.create') }}" 
               class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-xs transition-colors flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Input Aduan Baru</span>
            </a>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs mt-6">
        <form action="{{ route('kecamatan.reports.recapitulation') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 text-xs">
            
            <div>
                <label class="block font-bold text-slate-700 mb-1">Cari Kata Kunci</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="No tiket, jalan, nama..." 
                       class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-xs font-medium focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Status Disposisi</label>
                <select name="status" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-xs font-medium focus:outline-none focus:border-brand-500">
                    <option value="">Semua Status</option>
                    <option value="menunggu_validasi" {{ $status == 'menunggu_validasi' ? 'selected' : '' }}>Menunggu Validasi</option>
                    <option value="diteruskan_pupr" {{ $status == 'diteruskan_pupr' ? 'selected' : '' }}>Diteruskan ke PUPR</option>
                    <option value="ditolak" {{ $status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="selesai" {{ $status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Tingkat Urgensi</label>
                <select name="urgency" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-xs font-medium focus:outline-none focus:border-brand-500">
                    <option value="">Semua Urgensi</option>
                    <option value="darurat" {{ $urgency == 'darurat' ? 'selected' : '' }}>Darurat</option>
                    <option value="tinggi" {{ $urgency == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                    <option value="sedang" {{ $urgency == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="normal" {{ $urgency == 'normal' ? 'selected' : '' }}>Normal</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-bold py-2 px-3 rounded-lg text-xs transition-colors">
                    Terapkan Filter
                </button>
                <a href="{{ route('kecamatan.reports.recapitulation') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-2 px-3 rounded-lg text-xs transition-colors">
                    Reset
                </a>
            </div>

        </form>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden mt-6">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3.5 px-4">No. Tiket</th>
                        <th class="py-3.5 px-4">Ruas Jalan & Wilayah</th>
                        <th class="py-3.5 px-4">Kategori Kerusakan</th>
                        <th class="py-3.5 px-4">Urgensi</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Pelapor</th>
                        <th class="py-3.5 px-4">Tanggal Masuk</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($reports as $r)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-4 font-mono font-bold text-slate-900">
                            {{ $r->ticket_number }}
                        </td>
                        <td class="py-3 px-4">
                            <span class="font-bold text-slate-900 block truncate max-w-xs">{{ $r->road_name }}</span>
                            <span class="text-[11px] text-slate-400">{{ $r->village }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="truncate max-w-[200px] block">{{ $r->category }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-full {{ $r->urgency_badge }}">
                                {{ $r->urgency_label }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $r->status == 'diteruskan_pupr' ? 'bg-emerald-100 text-emerald-800' : ($r->status == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                                {{ $r->status_label }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="font-bold text-slate-800 block">{{ $r->reporter_name }}</span>
                            <span class="text-[10px] text-slate-400 font-mono">{{ $r->masked_nik }}</span>
                        </td>
                        <td class="py-3 px-4 text-slate-500 whitespace-nowrap">
                            {{ $r->created_at ? $r->created_at->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('kecamatan.validation.index', ['ticket' => $r->ticket_number]) }}" 
                                   class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors" title="Buka Detail">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('kecamatan.reports.print-bap', $r->id) }}" 
                                   target="_blank"
                                   class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors" title="Cetak BAP">
                                    <i class="fa-solid fa-print text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-8 text-slate-400">
                            Tidak ditemukan data yang sesuai kriteria filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $reports->withQueryString()->links() }}
        </div>
    </div>

</div>
@endsection
