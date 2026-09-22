@extends('layouts.warga')

@section('title', 'Buat Laporan - SIGAP')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-sigap p-4">
            <h3 class="mb-4 text-primary fw-bold">FORMULIR LAPORAN KERUSAKAN JALAN</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('warga.laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Lokasi -->
                <h5 class="fw-bold text-secondary mb-3">1. Lokasi Kerusakan</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Kecamatan</label>
                        <select id="id_kecamatan" class="form-select" required>
                            <option value="" disabled selected>Pilih Kecamatan</option>
                            @foreach($kecamatan as $k)
                                <option value="{{ $k->id_kecamatan }}">{{ $k->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Kelurahan / Desa</label>
                        <select id="id_desa" class="form-select" required disabled>
                            <option value="" disabled selected>Pilih Kecamatan dulu</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Jalan</label>
                        <select name="id_jalan" id="id_jalan" class="form-select" required disabled>
                            <option value="" disabled selected>Pilih Desa dulu</option>
                        </select>
                    </div>
                </div>

                <!-- Kategori & Detail -->
                <h5 class="fw-bold text-secondary mb-3 mt-3">2. Detail Kerusakan</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Kategori Kerusakan</label>
                        <select name="id_kategori" class="form-select" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tingkat Bahaya / Urgensi</label>
                        <select name="tingkat_bahaya" class="form-select" required>
                            <option value="Rendah">Rendah (Rutin)</option>
                            <option value="Sedang">Sedang (Perlu Perhatian)</option>
                            <option value="Bahaya Tinggi">Bahaya Tinggi (Segera Ditangani)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi Kerusakan</label>
                    <textarea name="deskripsi" class="form-control" rows="4" oninput="this.value = this.value.replace(/[^a-zA-Z0-9\s\n\r.,!?\-()]/g, ''); this.placeholder = 'Jelaskan kondisi kerusakan, patokan lokasi, dll.';" required>{{ old('deskripsi') }}</textarea>
                </div>

                <!-- Geolocation -->
                <h5 class="fw-bold text-secondary mb-3 mt-3">3. Lokasi GPS (Opsional)</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Latitude</label>
                        <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitude" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Longitude</label>
                        <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Longitude" readonly>
                    </div>
                    <div class="col-md-12 mt-2">
                        <button type="button" id="btn-get-location" class="btn btn-outline-primary btn-sm">Ambil Lokasi Sekarang</button>
                        <small class="text-muted ms-2">Klik untuk menggunakan lokasi GPS Anda saat ini.</small>
                    </div>
                </div>

                <!-- Foto Bukti -->
                <h5 class="fw-bold text-secondary mb-3 mt-3">4. Foto Bukti Kerusakan</h5>
                <div class="mb-4">
                    <input type="file" name="foto" class="form-control" accept="image/*" required>
                    <small class="text-muted">Maksimal file size: 5MB (Format: JPG, PNG)</small>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-sigap-primary btn-lg">Kirim Laporan</button>
                    <a href="{{ route('warga.dashboard') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
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

    // Geolocation
    $('#btn-get-location').on('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                $('#latitude').val(position.coords.latitude.toFixed(8));
                $('#longitude').val(position.coords.longitude.toFixed(8));
                alert('Lokasi berhasil didapatkan!');
            }, function(error) {
                alert('Gagal mendapatkan lokasi. Pastikan GPS aktif dan izin diberikan.');
            });
        } else {
            alert('Browser tidak mendukung geolocation.');
        }
    });
</script>
@endpush