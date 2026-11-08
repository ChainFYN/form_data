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
                            LP-{{ $item->created_at->format('Y') }}-{{ str_pad($item->id_laporan, 4, '0', STR_PAD_LEFT) }}
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
