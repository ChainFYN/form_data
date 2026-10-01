@extends('kecamatan.layouts.app')

@section('title', 'Verifikasi BAST PUPR - Pemeriksaan & Penyerahan Hasil')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- BREADCRUMB & HEADER -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 pb-6 border-b border-slate-200">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Pemeriksaan Verifikasi BAST dari PUPR
            </h1>
        </div>

        <!-- Top Right Tabs -->
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('kecamatan.validation.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-200 transition-colors">
                Validasi Aduan Awal (2)
            </a>
            <a href="#" class="px-4 py-2 bg-slate-900 text-white font-bold text-xs rounded-xl shadow-xs flex items-center gap-2">
                <span>Verifikasi BAST PUPR</span>
                <span class="bg-amber-400 text-slate-900 px-1.5 py-0.5 rounded text-[10px]">2 Baru</span>
            </a>
        </div>
    </div>

    <!-- MAIN TWO-COLUMN WORKSPACE -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 mt-6">
        
        <!-- LEFT COLUMN: QUEUE & FILTERS -->
        <div class="lg:col-span-4 flex flex-col gap-4">
            
            <form action="#" method="GET" class="relative">
                <div class="relative">
                    <input type="text" 
                           placeholder="Cari id laporan, jalan..." 
                           class="w-full pl-9 pr-4 py-2 text-xs font-semibold text-slate-800 bg-white border border-slate-200 rounded-xl shadow-2xs focus:outline-none focus:border-brand-500">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </form>

            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 custom-scrollbar text-xs">
                <a href="#" class="px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap bg-slate-900 text-white shadow-xs">
                    Semua BAST (3)
                </a>
                <a href="#" class="px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100">
                    Perlu Segera ACC (2)
                </a>
                <a href="#" class="px-3 py-1.5 rounded-lg font-bold transition-all whitespace-nowrap bg-white text-slate-600 border border-slate-200 hover:bg-slate-100">
                    Prioritas Tinggi
                </a>
            </div>

            <!-- TICKET QUEUE LIST -->
            <div class="flex flex-col gap-3 max-h-[750px] overflow-y-auto pr-1 custom-scrollbar">
                
                @forelse($laporan_bast as $bast)
                <a href="#" class="p-4 rounded-2xl border transition-all text-left block relative {{ $loop->first ? 'bg-emerald-50/40 border-amber-500 shadow-sm ring-1 ring-amber-500' : 'bg-white border-slate-200 hover:border-slate-300' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <span class="font-mono text-xs font-bold text-slate-900">#LP-{{ date('Y') }}-{{ str_pad($bast->id_laporan, 4, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-full {{ $bast->tingkat_bahaya == 'Bahaya Tinggi' ? 'bg-red-500 text-white' : ($bast->tingkat_bahaya == 'Sedang' ? 'bg-amber-500 text-white' : 'bg-blue-500 text-white') }}">{{ $bast->tingkat_bahaya }}</span>
                        </div>
                        <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-300">
                            100% Selesai
                        </span>
                    </div>

                    <h4 class="text-xs font-bold text-slate-900 mt-2 truncate">
                        Jl. {{ $bast->jalan->nama_jalan ?? '-' }}
                    </h4>
                    <p class="text-[10px] text-slate-500 line-clamp-1 mt-0.5">
                        Kel. {{ $bast->jalan->desa->nama_desa ?? '-' }}, Kec. {{ $bast->jalan->desa->kecamatan->nama_kecamatan ?? '-' }}
                    </p>

                    <div class="text-[10px] text-slate-500 font-medium mt-2 pt-2 border-t border-slate-200/60">
                        <div class="flex justify-between items-center mt-2">
                            <span>{{ $bast->updated_at->format('d M Y, H:i') }} WIB</span>
                            <span class="text-amber-600 font-bold">Sedang Diperiksa <i class="fa-solid fa-chevron-right ml-1 text-[8px]"></i></span>
                        </div>
                    </div>
                </a>
                @empty
                    <div class="p-4 text-center text-xs text-slate-500 border border-dashed border-slate-300 rounded-xl">Belum ada BAST yang perlu diperiksa.</div>
                @endforelse

            </div>
        </div>

        <!-- RIGHT COLUMN: TICKET INSPECTION & DISPOSITION -->
        <div class="lg:col-span-8 flex flex-col gap-6">
            @if($laporan_bast->count() > 0)
            @php $activeBast = $laporan_bast->first(); @endphp
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
                <h2 class="text-xl font-extrabold text-slate-900 mb-1">Detail Berkas BAST #LP-{{ date('Y') }}-{{ str_pad($activeBast->id_laporan, 4, '0', STR_PAD_LEFT) }}</h2>
                <p class="text-xs text-slate-500 font-medium">Klasifikasi: {{ $activeBast->kategori->nama_kategori ?? 'Lainnya' }}</p>
                
                <div class="mt-6 border-t border-slate-100 pt-6">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-xs shrink-0">A</div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-sm font-bold text-slate-900">Evaluasi Teknis & Rekomendasi Penanganan Selesai</h3>
                                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-200">Wajib Diisi PPK</span>
                            </div>
                            
                            <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl text-xs text-slate-700 leading-relaxed mt-2">
                                <span class="font-bold">Kajian Teknis Penanganan Selesai:</span> Penanganan darurat telah dituntaskan. Tim PUPR telah memastikan kondisi jalan kembali fungsional sesuai standar.
                                <div class="mt-3 flex items-center gap-1.5 text-[10px] text-emerald-700 font-semibold">
                                    <i class="fa-solid fa-circle-check"></i> Tersinkronisasi dengan Berita Acara Rekayasa Lapangan (BARL).
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOMPARASI VISUAL -->
                <div class="mt-6">
                    <div class="flex items-center justify-between mb-3 text-[10px] font-bold uppercase text-slate-400">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                            <span>KOMPARASI VISUAL BUKTI LAPANGAN (SEBELUM VS SELESAI)</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="border border-slate-200 p-2 rounded-xl">
                            <div class="relative rounded-lg overflow-hidden h-40 bg-slate-100">
                                @if($activeBast->url_foto)
                                    <img src="{{ asset('storage/' . $activeBast->url_foto) }}" alt="Sebelum" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">Tak ada foto</div>
                                @endif
                                <div class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded">SEBELUM (0%)</div>
                            </div>
                        </div>
                        <div class="border border-emerald-200 p-2 rounded-xl bg-emerald-50/20">
                            <div class="relative rounded-lg overflow-hidden h-40 bg-slate-100 flex items-center justify-center text-slate-400 text-xs">
                                <!-- Asumsikan foto progres disimpan atau ditampilkan dari tabel log -->
                                [Foto Progres PUPR]
                                <div class="absolute top-2 left-2 bg-emerald-600 text-white text-[10px] font-bold px-2 py-1 rounded">SELESAI (100%)</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- CHECKLIST -->
                <div class="mt-8 border-t border-slate-100 pt-6">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-xs shrink-0">B</div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-sm font-bold text-slate-900">Checklist Pengujian Mutu Lapangan (Quality Control Bina Marga)</h3>
                                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200"><i class="fa-solid fa-check"></i> 4/4 Parameter Lolos Uji</span>
                            </div>
                            <p class="text-xs text-slate-500 mb-4">Hasil uji petik keteknikan sebelum penerbitan sertifikat kelayakan fungsi jalan kecamatan.</p>
                            
                            <div class="space-y-3">
                                <div class="flex items-start justify-between bg-emerald-50/30 p-3 rounded-lg border border-slate-100">
                                    <div class="flex items-start gap-3">
                                        <div class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] mt-0.5 shrink-0"><i class="fa-solid fa-check"></i></div>
                                        <div>
                                            <div class="text-xs font-bold text-slate-800">Uji Kepadatan & Suhu Pemadatan Hamparan Aspal</div>
                                            <div class="text-[10px] text-slate-500">Suhu tiba di lokasi 145°C (Standar Min. 120°C). Pemadatan tandem roller 6 lintasan (98.4%).</div>
                                        </div>
                                    </div>
                                    <div class="text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2 py-1 rounded">VALID > 140°C</div>
                                </div>

                                <div class="flex items-start justify-between bg-emerald-50/30 p-3 rounded-lg border border-slate-100">
                                    <div class="flex items-start gap-3">
                                        <div class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] mt-0.5 shrink-0"><i class="fa-solid fa-check"></i></div>
                                        <div>
                                            <div class="text-xs font-bold text-slate-800">Uji Kerataan Permukaan Mistar 3 Meter (Straight Edge)</div>
                                            <div class="text-[10px] text-slate-500">Deviasi maksimum celah mistar terukur 1.5 mm (Spesifikasi batas toleransi kemiringan maks 4 mm).</div>
                                        </div>
                                    </div>
                                    <div class="text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2 py-1 rounded">LOLOS TOLERANSI</div>
                                </div>

                                <div class="flex items-start justify-between bg-emerald-50/30 p-3 rounded-lg border border-slate-100">
                                    <div class="flex items-start gap-3">
                                        <div class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] mt-0.5 shrink-0"><i class="fa-solid fa-check"></i></div>
                                        <div>
                                            <div class="text-xs font-bold text-slate-800">Uji Ketebalan Inti Core Drill Sampel</div>
                                            <div class="text-[10px] text-slate-500">Pengambilan 2 titik sampel lab menghasilkan rata-rata tebal padat 4.20 cm (Standar spek teknis AC-WC min 4.00 cm).</div>
                                        </div>
                                    </div>
                                    <div class="text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2 py-1 rounded">TEBAL 4.2 CM</div>
                                </div>

                                <div class="flex items-start justify-between bg-emerald-50/30 p-3 rounded-lg border border-slate-100">
                                    <div class="flex items-start gap-3">
                                        <div class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] mt-0.5 shrink-0"><i class="fa-solid fa-check"></i></div>
                                        <div>
                                            <div class="text-xs font-bold text-slate-800">Normalisasi Saluran Air & Pembersihan Sisa Agregat</div>
                                            <div class="text-[10px] text-slate-500">Inlet culvert telah diserok, bebas sampah dan endapan pasir. Area jalur lalu lintas steril dari puing aspal.</div>
                                        </div>
                                    </div>
                                    <div class="text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2 py-1 rounded">STERIL & LANCAR</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ACTION FORM -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs" x-data="{ decisionAction: 'acc' }">
                <div class="flex items-start justify-between mb-4 border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900">Keputusan Verifikator Kecamatan (Aksi Akhir BAST)</h3>
                        <p class="text-[11px] text-slate-500 mt-1">Tentukan status verifikasi akhir berkas BAST untuk penutupan laporan warga & penyerahan hasil fisik secara resmi.</p>
                    </div>
                    <div class="text-[10px] font-bold bg-amber-100 text-amber-900 px-2 py-1 rounded border border-amber-200 shrink-0">Kewenangan Kasie Ekbang</div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div @click="decisionAction = 'acc'" 
                         :class="decisionAction === 'acc' ? 'border-amber-500 bg-amber-50 ring-1 ring-amber-500' : 'border-slate-200 bg-white hover:border-slate-300'"
                         class="p-4 rounded-xl border cursor-pointer transition-all">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-4 h-4 rounded-full border flex items-center justify-center" :class="decisionAction === 'acc' ? 'bg-amber-500 border-amber-500' : 'border-slate-300'">
                                <div class="w-1.5 h-1.5 rounded-full bg-white" x-show="decisionAction === 'acc'"></div>
                            </div>
                            <span class="text-xs font-bold text-slate-900">Verifikasi & Terbitkan BAST ke Warga</span>
                            <span class="text-[9px] font-bold bg-emerald-100 text-emerald-700 px-1.5 py-0.5 rounded">Rekomendasi</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed ml-6">Pekerjaan fisik dinilai tuntas, sesuai spesifikasi teknis dan rapi. Tiket aduan warga akan otomatis ditutup dengan status "Selesai Sempurna" serta BAST terkirim via aplikasi warga.</p>
                    </div>

                    <div @click="decisionAction = 'reject'" 
                         :class="decisionAction === 'reject' ? 'border-red-500 bg-red-50 ring-1 ring-red-500' : 'border-slate-200 bg-white hover:border-slate-300'"
                         class="p-4 rounded-xl border cursor-pointer transition-all">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-4 h-4 rounded-full border flex items-center justify-center" :class="decisionAction === 'reject' ? 'bg-red-500 border-red-500' : 'border-slate-300'">
                                <div class="w-1.5 h-1.5 rounded-full bg-white" x-show="decisionAction === 'reject'"></div>
                            </div>
                            <span class="text-xs font-bold text-slate-900">Tolak / Minta Perbaikan Lapangan</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed ml-6">Pekerjaan aspal bergelombang, drainase terhambat, atau ketebalan kurang. Berkas dikembalikan ke Dinas PUPR untuk perbaikan minor eksekusi pemeliharaan.</p>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-xs font-bold text-slate-900">Catatan Pemeriksaan & Berita Acara Kecamatan:</label>
                        <span class="text-[10px] text-slate-400">Tercantum pada surat tembusan warga & arsip Pemkab</span>
                    </div>
                    <textarea class="w-full text-xs text-slate-700 border border-slate-300 rounded-xl p-3 focus:outline-none focus:border-amber-500 bg-slate-50" rows="4">Telah dilakukan uji petik visual dan pengecekan lokasi bersama perwakilan RT 02 / RW 05 Kelurahan Sukamaju pada tanggal 26 September 2026. Pekerjaan perbaikan lapis Laston AC-WC telah memenuhi standar teknis jalan Kecamatan, permukaan rata, dan aliran drainase berfungsi normal tanpa genangan. Berita Acara Serah Terima (BAST) disetujui untuk diteruskan dan diarsipkan ke dalam sistem informasi pelaporan warga.</textarea>
                </div>

                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200 mb-6">
                    <div class="w-8 h-8 rounded bg-emerald-700 text-white font-bold flex items-center justify-center text-xs">DG</div>
                    <div>
                        <div class="text-xs font-bold text-slate-900">Dra. Siti Rahmawati <span class="text-[10px] text-slate-500 font-normal ml-1">NIP. 19790815 200604 2 015</span></div>
                        <div class="text-[10px] text-slate-500">Kasie Pembangunan & Pemberdayaan Masyarakat Kec. Cibinong</div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4">
                    <button class="px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50">Simpan Draf Pemeriksaan</button>
                    <button class="px-4 py-2 text-xs font-bold text-red-600 bg-white border border-red-200 hover:bg-red-50 rounded-xl">Tolak & Kembalikan ke PUPR</button>
                    <button class="px-5 py-2 text-xs font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-check-double text-[10px]"></i> Verifikasi BAST & Kirim ke Warga
                    </button>
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs text-center py-20 text-slate-500">
                Belum ada laporan yang diselesaikan dan siap untuk diverifikasi BAST.
            </div>
            @endif

        </div>
    </div>

</div>
@endsection
