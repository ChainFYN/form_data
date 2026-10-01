@extends('warga.layouts.app')

@section('title', 'Buat Laporan Kerusakan Jalan')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- BREADCRUMB & HEADER -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
            <a href="{{ route('warga.dashboard') }}" class="hover:text-slate-900 transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('warga.laporan.index') }}" class="hover:text-slate-900 transition">Riwayat Laporan</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Buat Laporan Baru</span>
        </div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Formulir Laporan Kerusakan Jalan</h1>
        <p class="text-xs text-slate-500 mt-0.5">Sampaikan informasi kondisi kerusakan jalan secara lengkap agar dapat segera diverifikasi oleh tim kecamatan.</p>
    </div>

    <!-- ERROR ALERT -->
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-2xl p-4 mb-6 text-xs">
            <div class="flex items-center gap-2 font-bold mb-2">
                <i class="fa-solid fa-triangle-exclamation text-sm text-red-600"></i>
                <span>Mohon perbaiki kesalahan berikut:</span>
            </div>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM CARD -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 sm:p-8">
        <form action="{{ route('warga.laporan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- SECTION 1: LOKASI KERUSAKAN -->
            <div class="mb-8">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center text-xs font-bold">1</div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Lokasi Kerusakan Jalan</h2>
                        <p class="text-[11px] text-slate-500">Pilih wilayah kecamatan, kelurahan/desa, dan ruas jalan terkait.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Kecamatan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kecamatan <span class="text-red-500">*</span></label>
                        <select id="id_kecamatan" class="w-full py-2.5 px-3 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800" required>
                            <option value="" disabled selected>Pilih Kecamatan</option>
                            @foreach($kecamatan as $k)
                                <option value="{{ $k->id_kecamatan }}">{{ $k->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Desa -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kelurahan / Desa <span class="text-red-500">*</span></label>
                        <select id="id_desa" class="w-full py-2.5 px-3 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800 disabled:opacity-50 disabled:cursor-not-allowed" required disabled>
                            <option value="" disabled selected>Pilih Kecamatan dulu</option>
                        </select>
                    </div>

                    <!-- Jalan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Ruas Jalan <span class="text-red-500">*</span></label>
                        <select name="id_jalan" id="id_jalan" class="w-full py-2.5 px-3 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800 disabled:opacity-50 disabled:cursor-not-allowed" required disabled>
                            <option value="" disabled selected>Pilih Desa dulu</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: DETAIL KERUSAKAN -->
            <div class="mb-8">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center text-xs font-bold">2</div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Detail Kerusakan & Tingkat Bahaya</h2>
                        <p class="text-[11px] text-slate-500">Tentukan kategori fisik jalan rusak serta tingkat bahaya bagi pengguna jalan.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <!-- Kategori -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Kerusakan <span class="text-red-500">*</span></label>
                        <select name="id_kategori" class="w-full py-2.5 px-3 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800" required>
                            <option value="" disabled selected>Pilih Kategori Kerusakan</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tingkat Bahaya -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tingkat Urgensi / Bahaya <span class="text-red-500">*</span></label>
                        <select name="tingkat_bahaya" class="w-full py-2.5 px-3 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800" required>
                            <option value="Rendah" {{ old('tingkat_bahaya') == 'Rendah' ? 'selected' : '' }}>Rendah (Kerusakan Ringan / Pemeliharaan Berkala)</option>
                            <option value="Sedang" {{ old('tingkat_bahaya') == 'Sedang' ? 'selected' : '' }}>Sedang (Mengganggu Lalu Lintas / Perlu Perhatian)</option>
                            <option value="Bahaya Tinggi" {{ old('tingkat_bahaya') == 'Bahaya Tinggi' ? 'selected' : '' }}>Bahaya Tinggi (Potensi Kecelakaan / Putus Jalur)</option>
                        </select>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        Deskripsi Kerusakan <span class="text-red-500">*</span>
                        <span class="text-[11px] text-slate-400 font-normal ml-1">(minimal 10 karakter)</span>
                    </label>
                    <textarea name="deskripsi" 
                              rows="4" 
                              placeholder="Jelaskan kondisi kerusakan secara detail, seperti perkiraan kedalaman lubang, patokan lokasi (depan masjid, toko, jembatan), atau potensi bahaya..." 
                              class="w-full p-3 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800 placeholder-slate-400" 
                              required>{{ old('deskripsi') }}</textarea>
                </div>
            </div>

            <!-- SECTION 3: KOORDINAT GPS (OPSIONAL) -->
            <div class="mb-8">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center text-xs font-bold">3</div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Titik Koordinat GPS (Opsional)</h2>
                        <p class="text-[11px] text-slate-500">Membantu petugas UPT PUPR menemukan titik pasti kerusakan di peta GIS.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Latitude</label>
                        <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}" placeholder="Contoh: -8.1724" class="w-full py-2.5 px-3 text-xs rounded-xl border border-slate-200 bg-slate-100 text-slate-700 font-mono" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Longitude</label>
                        <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}" placeholder="Contoh: 113.6995" class="w-full py-2.5 px-3 text-xs rounded-xl border border-slate-200 bg-slate-100 text-slate-700 font-mono" readonly>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" id="btn-get-location" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition border border-slate-300">
                        <i class="fa-solid fa-location-crosshairs text-emerald-600"></i>
                        <span>Ambil Lokasi GPS Saat Ini</span>
                    </button>
                    <span id="location-status" class="text-[11px] text-slate-500">Klik tombol untuk mengambil koordinat otomatis dari perangkat Anda.</span>
                </div>
            </div>

            <!-- SECTION 4: FOTO BUKTI KERUSAKAN -->
            <div class="mb-8">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center text-xs font-bold">4</div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Foto Bukti Kerusakan <span class="text-red-500">*</span></h2>
                        <p class="text-[11px] text-slate-500">Unggah foto kondisi fisik jalan yang rusak (Format: JPG, JPEG, PNG. Maks: 5MB).</p>
                    </div>
                </div>

                <div class="border-2 border-dashed border-slate-300 rounded-2xl p-6 text-center hover:border-slate-400 transition bg-slate-50/50">
                    <div class="mb-3">
                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-400"></i>
                    </div>
                    <div class="text-xs text-slate-700 font-medium mb-1">
                        Pilih foto atau ambil gambar dari kamera
                    </div>
                    <p class="text-[11px] text-slate-400 mb-4">Pastikan gambar terlihat terang dan menampilkan titik kerusakan jalan</p>
                    <input type="file" name="foto" id="foto-input" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-800 cursor-pointer max-w-sm mx-auto" required>
                    
                    <!-- Preview Image -->
                    <div id="image-preview-container" class="mt-4 hidden">
                        <p class="text-[11px] font-bold text-slate-500 mb-2">Pratinjau Foto:</p>
                        <img id="image-preview" src="#" alt="Pratinjau Foto" class="max-h-56 mx-auto rounded-xl border border-slate-200 shadow-xs object-cover">
                    </div>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('warga.dashboard') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition flex items-center gap-2 shadow-xs">
                    <i class="fa-solid fa-paper-plane text-emerald-400"></i>
                    <span>Kirim Laporan Kerusakan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    const desaData = @json($desaGrouped);
    const jalanData = @json($jalanGrouped);

    $('#id_kecamatan').on('change', function() {
        const idKec = $(this).val();
        const desaSelect = $('#id_desa');
        const jalanSelect = $('#id_jalan');

        desaSelect.empty().append('<option value="" disabled selected>Pilih Kelurahan/Desa</option>');
        jalanSelect.empty().append('<option value="" disabled selected>Pilih Desa dulu</option>').prop('disabled', true);

        if (desaData[idKec]) {
            desaData[idKec].forEach(function(d) {
                desaSelect.append(`<option value="${d.id_desa}">${d.nama_desa}</option>`);
            });
            desaSelect.prop('disabled', false);
        } else {
            desaSelect.prop('disabled', true);
        }
    });

    $('#id_desa').on('change', function() {
        const idDesa = $(this).val();
        const jalanSelect = $('#id_jalan');

        jalanSelect.empty().append('<option value="" disabled selected>Pilih Jalan</option>');

        if (jalanData[idDesa]) {
            jalanData[idDesa].forEach(function(j) {
                jalanSelect.append(`<option value="${j.id_jalan}">${j.nama_jalan}</option>`);
            });
            jalanSelect.prop('disabled', false);
        } else {
            jalanSelect.append(`<option value="" disabled>Belum ada data jalan di desa ini</option>`);
            jalanSelect.prop('disabled', true);
        }
    });

    // Geolocation Helper
    $('#btn-get-location').on('click', function() {
        const statusSpan = $('#location-status');
        if (navigator.geolocation) {
            statusSpan.text('Mengakses satelit GPS...');
            navigator.geolocation.getCurrentPosition(function(position) {
                $('#latitude').val(position.coords.latitude.toFixed(7));
                $('#longitude').val(position.coords.longitude.toFixed(7));
                statusSpan.html('<span class="text-emerald-700 font-bold"><i class="fa-solid fa-check mr-1"></i>Koordinat GPS berhasil diperoleh!</span>');
            }, function(error) {
                statusSpan.html('<span class="text-red-600 font-bold"><i class="fa-solid fa-xmark mr-1"></i>Gagal mengambil lokasi. Pastikan izin GPS aktif di browser.</span>');
            });
        } else {
            statusSpan.text('Browser Anda tidak mendukung Geolocation.');
        }
    });

    // Image Preview
    $('#foto-input').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                $('#image-preview').attr('src', evt.target.result);
                $('#image-preview-container').removeClass('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
