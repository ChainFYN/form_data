@extends('kecamatan.layouts.app')

@section('title', 'Form Input Pengaduan Jalan Warga - SIGAP')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">

    <!-- HEADER -->
    <div class="pb-6 border-b border-slate-200">
        <a href="{{ route('kecamatan.dashboard') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors flex items-center gap-1.5 mb-2">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali ke Dashboard</span>
        </a>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
            Formulir Aduan Kerusakan Jalan Baru
        </h1>
        <p class="text-xs text-slate-500 mt-1">
            Laporkan jalan berlubang, amblas, retak buaya, atau saluran drainase tersumbat di wilayah Kecamatan Jember.
        </p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-xs p-4 rounded-xl mt-4">
            <ul class="list-disc pl-4 space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kecamatan.reports.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-xs flex flex-col gap-6 text-xs">
        @csrf

        <!-- INFORMASI LOKASI RUAS JALAN -->
        <div>
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2 mb-4">
                1. Lokasi & Titik Kerusakan Jalan
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">Nama Ruas Jalan <span class="text-red-500">*</span></label>
                    <input type="text" name="road_name" required placeholder="Contoh: Jl. Raya Mayor Oking No. 42" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 font-medium text-slate-800 focus:outline-none focus:border-brand-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">Desa / Kelurahan <span class="text-red-500">*</span></label>
                    <select name="village" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 font-medium text-slate-800 focus:outline-none focus:border-brand-500">
                        @foreach($villages as $v)
                            <option value="{{ $v->name }}">{{ $v->name }} ({{ $v->type }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Coordinate GPS Input with auto-detect -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4" x-data="{
                detectGPS() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(pos => {
                            document.getElementById('inputLat').value = pos.coords.latitude.toFixed(6);
                            document.getElementById('inputLng').value = pos.coords.longitude.toFixed(6);
                            alert('Koordinat GPS Anda berhasil dideteksi: ' + pos.coords.latitude + ', ' + pos.coords.longitude);
                        }, err => {
                            alert('Gagal mendeteksi GPS: ' + err.message);
                        });
                    } else {
                        alert('Browser Anda tidak mendukung geolokasi.');
                    }
                }
            }">
                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">Latitude (Lintang)</label>
                    <input type="text" id="inputLat" name="latitude" value="-6.485120" 
                           class="w-full font-mono bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 font-medium text-slate-800 focus:outline-none focus:border-brand-500">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1.5 flex justify-between">
                        <span>Longitude (Bujur)</span>
                        <button type="button" @click="detectGPS" class="text-brand-600 hover:underline text-[10px]">
                            <i class="fa-solid fa-crosshairs"></i> Deteksi Otomatis
                        </button>
                    </label>
                    <input type="text" id="inputLng" name="longitude" value="106.842310" 
                           class="w-full font-mono bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 font-medium text-slate-800 focus:outline-none focus:border-brand-500">
                </div>
            </div>
        </div>

        <!-- KLASIFIKASI KERUSAKAN -->
        <div>
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2 mb-4">
                2. Jenis & Tingkat Urgensi Kerusakan
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">Kategori Kerusakan <span class="text-red-500">*</span></label>
                    <select name="category" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 font-medium text-slate-800 focus:outline-none focus:border-brand-500">
                        <option value="Kerusakan Struktur Perkerasan Jalan Kabupaten">Kerusakan Struktur Perkerasan Jalan Kabupaten</option>
                        <option value="Longsor & Amblesan Samping Ruas">Longsor & Amblesan Samping Ruas</option>
                        <option value="Saluran Drainase Rusak & Genangan">Saluran Drainase Rusak & Genangan</option>
                        <option value="Retak Buaya (Alligator Crack)">Retak Buaya (Alligator Crack)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">Tingkat Urgensi Laporan <span class="text-red-500">*</span></label>
                    <select name="urgency" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 font-medium text-slate-800 focus:outline-none focus:border-brand-500">
                        <option value="darurat">DARURAT (Batas respon &lt; 2 jam, rawan korban jiwa)</option>
                        <option value="tinggi" selected>TINGGI (Batas respon &lt; 24 jam)</option>
                        <option value="sedang">SEDANG (Genangan air, retak parah)</option>
                        <option value="normal">NORMAL (Pemeliharaan berkala)</option>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <label class="block font-bold text-slate-700 mb-1.5">Deskripsi Lengkap Kerusakan <span class="text-red-500">*</span></label>
                <textarea name="description" rows="3" required placeholder="Jelaskan perkiraan diameter lubang, kedalaman, dan bahaya bagi pengguna jalan..." 
                          class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3 font-medium text-slate-800 focus:outline-none focus:border-brand-500"></textarea>
            </div>
        </div>

        <!-- IDENTITAS PELAPOR -->
        <div>
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2 mb-4">
                3. Identitas Pelapor (Warga Terverifikasi)
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">Nama Lengkap Pelapor <span class="text-red-500">*</span></label>
                    <input type="text" name="reporter_name" required placeholder="Contoh: Ahmad Pratama" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 font-medium text-slate-800 focus:outline-none focus:border-brand-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">Nomor Induk Kependudukan (NIK) <span class="text-red-500">*</span></label>
                    <input type="text" name="reporter_nik" required maxlength="16" placeholder="16 digit NIK KTP Jember" 
                           class="w-full font-mono bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 font-medium text-slate-800 focus:outline-none focus:border-brand-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">Nomor WhatsApp / Telp <span class="text-red-500">*</span></label>
                    <input type="text" name="reporter_phone" required placeholder="0812-xxxx-xxxx" 
                           class="w-full font-mono bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 font-medium text-slate-800 focus:outline-none focus:border-brand-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">Alamat Domisili <span class="text-red-500">*</span></label>
                    <input type="text" name="reporter_address" required placeholder="RT 04 / RW 02 Cirimekar" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 font-medium text-slate-800 focus:outline-none focus:border-brand-500">
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('kecamatan.dashboard') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl shadow-md transition-all flex items-center gap-2">
                <i class="fa-solid fa-paper-plane text-xs"></i>
                <span>Kirimkan Aduan Sekarang</span>
            </button>
        </div>

    </form>

</div>
@endsection
