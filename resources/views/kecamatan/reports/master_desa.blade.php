@extends('kecamatan.layouts.app')

@section('title', 'Data Master Desa & Wilayah - SIGAP')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- PAGE HEADER -->
    <div class="pb-6 border-b border-slate-200">
        <div class="flex items-center gap-2 text-xs font-bold text-slate-500 uppercase tracking-wide">
            <span>Basis Data Kewilayahan</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">
            Data Master Desa & Kelurahan Jember
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
            Daftar wilayah administrasi, penanggung jawab posko desa, dan cakupan panjang ruas jalan kabupaten.
        </p>
    </div>

    <!-- VILLAGES GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        @foreach($villages as $v)
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full {{ $v->type == 'Kelurahan' ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800' }}">
                        {{ $v->type }}
                    </span>
                    <span class="text-xs font-mono font-semibold text-slate-400">
                        {{ $v->coverage_km }} km Ruas Jalan
                    </span>
                </div>

                <h3 class="text-base font-extrabold text-slate-900 mt-3">{{ $v->name }}</h3>
                <p class="text-xs text-slate-500 mt-1">Wilayah Kerja Kec. Jember, Kab. Jember</p>

                <!-- Village Head & Contact -->
                <div class="mt-4 p-3 bg-slate-50 rounded-xl border border-slate-100 text-xs">
                    <div class="flex items-center gap-2 text-slate-700">
                        <i class="fa-solid fa-user-tie text-slate-400"></i>
                        <span>Kepala/Lurah: <strong>{{ $v->head_of_village ?? 'Pj. Kepala Desa' }}</strong></span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-500 mt-1.5">
                        <i class="fa-solid fa-phone text-slate-400"></i>
                        <span>Kontak Posko: {{ $v->phone ?? '021-8750000' }}</span>
                    </div>
                </div>

                <!-- Stats Counters -->
                <div class="grid grid-cols-2 gap-2 mt-4 text-center">
                    <div class="p-2.5 bg-amber-50 rounded-xl border border-amber-100">
                        <span class="text-[10px] font-bold text-amber-800 uppercase block">Aduan Aktif</span>
                        <span class="text-lg font-black text-amber-700">{{ $v->active_reports_count }}</span>
                    </div>
                    <div class="p-2.5 bg-emerald-50 rounded-xl border border-emerald-100">
                        <span class="text-[10px] font-bold text-emerald-800 uppercase block">Terselesaikan</span>
                        <span class="text-lg font-black text-emerald-700">{{ $v->resolved_reports_count }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-5 pt-3 border-t border-slate-100">
                <a href="{{ route('kecamatan.reports.recapitulation', ['village' => $v->name]) }}" 
                   class="w-full py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl text-center block transition-colors">
                    Lihat Seluruh Aduan Wilayah Ini &rarr;
                </a>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
