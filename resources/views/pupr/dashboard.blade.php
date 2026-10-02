@extends('pupr.layouts.app')

@section('title', 'Dashboard PUPR')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- KPI CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">TERVALIDASI & SPK CAMAT</div>
                <div class="w-8 h-8 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center border border-amber-100">
                    <i class="fa-solid fa-file-signature text-xs"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-4xl font-extrabold text-slate-900">{{ $statistik['diproses'] ?? 0 }}</div>
                <div class="text-xs font-bold text-slate-500">Tiket SPK</div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-bold mt-2">
                <span class="bg-amber-100 text-amber-800 px-2 py-0.5 rounded">Butuh Penjadwalan</span>
                <span class="text-amber-600"><i class="fa-solid fa-arrow-up mr-1"></i>{{ $statistik['diproses'] ?? 0 }} SPK Baru</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">MENUNGGU VALIDASI CAMAT</div>
                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center border border-blue-100">
                    <i class="fa-solid fa-clock text-xs"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-4xl font-extrabold text-slate-900">{{ $statistik['menunggu'] ?? 0 }}</div>
                <div class="text-xs font-bold text-slate-500">Laporan Baru</div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-bold mt-2">
                <span class="text-slate-600"><i class="fa-solid fa-circle text-[8px] text-amber-500 mr-1"></i>Di antrean Kecamatan</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">SELESAI DIVERIFIKASI</div>
                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center border border-emerald-100">
                    <i class="fa-solid fa-check-double text-xs"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-4xl font-extrabold text-slate-900">{{ $statistik['selesai'] ?? 0 }}</div>
                <div class="text-xs font-bold text-slate-500">Titik Ruas</div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-bold mt-2">
                <span class="text-emerald-600">100% Rampung Fisik</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">TOTAL LAPORAN MASUK</div>
                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center border border-slate-200">
                    <i class="fa-solid fa-calendar-check text-xs"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-4xl font-extrabold text-slate-900">{{ $statistik['total'] ?? 0 }}</div>
                <div class="text-xs font-bold text-slate-500">Keseluruhan</div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-bold mt-2">
                <span class="text-slate-600">Seluruh data tercatat</span>
                <span class="text-amber-700">SIGAP Jember</span>
            </div>
        </div>

    </div>

    <!-- MAIN TWO COLUMNS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- LEFT: DAFTAR LAPORAN -->
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900">Daftar Laporan Tervalidasi Siap Kerja</h2>
                    <p class="text-xs text-slate-500 font-medium">Disposisi masuk dari Kantor Kecamatan Cibinong yang telah lolos verifikasi teknis UPT 1.</p>
                </div>
                <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-xl">
                    <button class="px-4 py-1.5 text-xs font-bold bg-white text-slate-900 rounded-lg shadow-sm">Semua (18)</button>
                    <button class="px-4 py-1.5 text-xs font-bold text-slate-600 hover:text-slate-900">Darurat / Prioritas 1 (4)</button>
                    <button class="px-4 py-1.5 text-xs font-bold text-slate-600 hover:text-slate-900">Reguler (9)</button>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                
                @forelse($laporan_diproses as $laporan)
                <div class="bg-white rounded-2xl p-4 border {{ $laporan->tingkat_bahaya === 'Bahaya Tinggi' ? 'border-red-200 ring-1 ring-red-500/20' : 'border-slate-200' }} shadow-xs flex flex-col sm:flex-row gap-5 relative overflow-hidden">
                    @if($laporan->tingkat_bahaya === 'Bahaya Tinggi')
                        <div class="absolute top-0 left-0 w-1 h-full bg-red-500"></div>
                    @endif
                    <div class="w-full sm:w-48 h-32 rounded-xl overflow-hidden relative shrink-0">
                        @if($laporan->url_foto)
                            <img src="{{ asset('storage/' . $laporan->url_foto) }}" alt="Jalan rusak" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400 flex-col gap-2">
                                <i class="fa-solid fa-image text-3xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-2 left-2 {{ $laporan->tingkat_bahaya === 'Bahaya Tinggi' ? 'bg-red-600' : ($laporan->tingkat_bahaya === 'Sedang' ? 'bg-amber-500' : 'bg-slate-600') }} text-white text-[10px] font-extrabold px-2 py-0.5 rounded uppercase">{{ $laporan->tingkat_bahaya }}</div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <div class="text-[10px] font-mono font-bold text-slate-500">
                                LP-{{ $laporan->created_at->format('Y') }}-{{ str_pad($laporan->id_laporan, 4, '0', STR_PAD_LEFT) }} — SPK: #SPK-PUPR-{{ str_pad($laporan->id_laporan, 4, '0', STR_PAD_LEFT) }}
                            </div>
                            <span class="text-[10px] font-bold bg-blue-50 text-blue-700 px-2 py-0.5 rounded border border-blue-200">Siap Dikerjakan</span>
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900 mb-1">Jl. {{ $laporan->jalan->nama_jalan ?? 'Tidak diketahui' }} ({{ $laporan->jalan->desa->nama_desa ?? '-' }})</h3>
                        <p class="text-[11px] text-slate-600 leading-relaxed mb-3">Kerusakan: <strong>{{ $laporan->kategori->nama_kategori ?? '-' }}</strong>. {{ $laporan->deskripsi }}</p>
                        
                        <div class="flex items-center gap-4 mb-3">
                            <div class="flex items-center gap-1.5 text-[10px] font-bold {{ $laporan->tingkat_bahaya === 'Bahaya Tinggi' ? 'text-red-700 bg-red-50 border-red-200' : 'text-slate-700 bg-slate-100 border-slate-200' }} border px-2.5 py-1.5 rounded-lg">
                                <i class="fa-solid fa-user"></i> Dilaporkan oleh: {{ $laporan->pengguna->nama_lengkap ?? 'Warga' }}
                            </div>
                            <div class="flex items-center gap-1.5 text-[10px] text-slate-600 font-medium">
                                <i class="fa-solid fa-location-dot text-slate-400"></i> Kec. {{ $laporan->jalan->desa->kecamatan->nama_kecamatan ?? '-' }}
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="flex items-center gap-1.5 text-[9px] text-slate-500 font-bold">
                                <i class="fa-solid fa-calendar-day"></i> Dilaporkan pada: {{ $laporan->created_at->format('d M Y, H:i') }} WIB
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="document.getElementById('modal-detail-{{ $laporan->id_laporan }}').classList.remove('hidden')" class="px-3 py-1.5 text-[10px] font-bold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors">Detail Laporan</button>
                                <a href="{{ route('pupr.progres.show', $laporan->id_laporan) }}" class="px-3 py-1.5 text-[10px] font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-lg shadow-xs transition-colors">Update Progres Lapangan</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODAL DETAIL -->
                <div id="modal-detail-{{ $laporan->id_laporan }}" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
                    <div class="bg-white rounded-3xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl">
                        <!-- Header -->
                        <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
                            <div>
                                <h3 class="font-extrabold text-slate-900 text-lg">Detail Laporan LP-{{ $laporan->created_at->format('Y') }}-{{ str_pad($laporan->id_laporan, 4, '0', STR_PAD_LEFT) }}</h3>
                                <p class="text-xs text-slate-500 font-medium mt-1">Dilaporkan pada {{ $laporan->created_at->format('d M Y, H:i') }} WIB</p>
                            </div>
                            <button onclick="document.getElementById('modal-detail-{{ $laporan->id_laporan }}').classList.add('hidden')" class="w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>
                        </div>
                        <!-- Body -->
                        <div class="p-6 overflow-y-auto flex-1 bg-slate-50/30">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Foto -->
                                <div>
                                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Foto Lapangan</div>
                                    <div class="w-full h-64 md:h-80 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200">
                                        @if($laporan->url_foto)
                                            <img src="{{ asset('storage/' . $laporan->url_foto) }}" alt="Foto Laporan" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                                <i class="fa-solid fa-image text-4xl mb-2"></i>
                                                <span class="text-xs font-medium">Tidak ada foto</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- Informasi -->
                                <div>
                                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Informasi Laporan</div>
                                    
                                    <div class="space-y-4">
                                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                                            <div class="text-[10px] text-slate-500 font-bold uppercase mb-1">Pelapor</div>
                                            <div class="font-bold text-slate-900">{{ $laporan->pengguna->nama_lengkap ?? 'Warga' }}</div>
                                            <div class="text-xs text-slate-600"><i class="fa-solid fa-phone text-slate-400 mr-1"></i> {{ $laporan->pengguna->telepon ?? '-' }}</div>
                                        </div>

                                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                                            <div class="text-[10px] text-slate-500 font-bold uppercase mb-1">Lokasi Kerusakan</div>
                                            <div class="font-bold text-slate-900">Jl. {{ $laporan->jalan->nama_jalan ?? 'Tidak diketahui' }}</div>
                                            <div class="text-xs text-slate-600">Desa {{ $laporan->jalan->desa->nama_desa ?? '-' }}, Kec. {{ $laporan->jalan->desa->kecamatan->nama_kecamatan ?? '-' }}</div>
                                        </div>

                                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                                            <div class="text-[10px] text-slate-500 font-bold uppercase mb-1">Tingkat Bahaya & Kategori</div>
                                            <div class="flex items-center gap-2">
                                                <div class="inline-flex px-2 py-1 {{ $laporan->tingkat_bahaya === 'Bahaya Tinggi' ? 'bg-red-100 text-red-700 border-red-200' : ($laporan->tingkat_bahaya === 'Sedang' ? 'bg-amber-100 text-amber-700 border-amber-200' : 'bg-slate-100 text-slate-700 border-slate-200') }} border rounded-lg text-xs font-bold uppercase">
                                                    {{ $laporan->tingkat_bahaya }}
                                                </div>
                                                <div class="text-sm font-bold text-slate-700">{{ $laporan->kategori->nama_kategori ?? '-' }}</div>
                                            </div>
                                        </div>

                                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                                            <div class="text-[10px] text-slate-500 font-bold uppercase mb-1">Deskripsi Kerusakan</div>
                                            <p class="text-sm text-slate-700 leading-relaxed">{{ $laporan->deskripsi }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-2xl p-10 border border-slate-200 shadow-xs flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-check-double text-emerald-500 text-2xl"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-700">Tidak ada SPK baru</h3>
                    <p class="text-xs text-slate-400 mt-1">Semua laporan dari kecamatan telah ditangani atau belum ada disposisi baru masuk.</p>
                </div>
                @endforelse

            </div>
        </div>

        <!-- RIGHT: KESIAPAN TIM -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs sticky top-28">
                
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center">
                            <i class="fa-solid fa-truck-pickup"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900">Kesiapan Tim & Armada UPT 1</h3>
                        </div>
                    </div>
                    <div class="text-[10px] font-bold bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full border border-emerald-200 flex items-center gap-1">
                        100% Siaga
                    </div>
                </div>

                <div class="p-5">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-4">STATUS REGU LAPANGAN</div>
                    
                    <div class="space-y-4">
                        <!-- Regu 1 -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-start gap-2">
                                <div class="w-2 h-2 rounded-full bg-amber-500 mt-1.5"></div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900">Regu Rajawali (8 Orang)</div>
                                    <div class="text-[10px] text-slate-500">Aktif • Jl. Mayor Oking</div>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-amber-700">Di Lapangan</span>
                        </div>

                        <!-- Regu 2 -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-start gap-2">
                                <div class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5"></div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900">Regu Elang (10 Orang)</div>
                                    <div class="text-[10px] text-slate-500">Standby • Basecamp UPT Cibinong</div>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-600">Siaga SPK</span>
                        </div>

                        <!-- Regu 3 -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-start gap-2">
                                <div class="w-2 h-2 rounded-full bg-slate-900 mt-1.5"></div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900">Regu Badak (Mekanik & Alat)</div>
                                    <div class="text-[10px] text-slate-500">Mobilisasi • Heavy Lowbed Truck</div>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-700">Bergerak</span>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">KETERSEDIAAN MATERIAL HOTMIX</div>
                            <div class="text-[10px] font-bold text-slate-600">Depo UPT 1</div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-[10px] font-bold mb-1.5">
                                    <span class="text-slate-700">Aspal Hotmix AC-WC</span>
                                    <span class="text-slate-900">38 Ton (76%)</span>
                                </div>
                                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-slate-900" style="width: 76%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between text-[10px] font-bold mb-1.5">
                                    <span class="text-slate-700">Agregat Pondasi Kelas A</span>
                                    <span class="text-slate-900">55 M³ (86%)</span>
                                </div>
                                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-amber-700" style="width: 86%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-[10px] font-bold mb-1.5">
                                    <span class="text-slate-700">Emulsi Tack Coat Cationic</span>
                                    <span class="text-slate-900">12 Drum (60%)</span>
                                </div>
                                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-600" style="width: 60%"></div>
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
