@extends('layouts.warga')

@section('title', 'Detail Laporan - SIGAP')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card card-sigap p-4 mb-4">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h3 class="fw-bold text-primary mb-1">Tiket Laporan #LP-{{ str_pad($laporan->id_laporan, 4, '0', STR_PAD_LEFT) }}</h3>
                    <p class="text-muted">{{ $laporan->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
                <a href="{{ route('warga.laporan.index') }}" class="btn btn-outline-secondary btn-sm">Kembali ke Riwayat</a>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5 class="fw-bold text-secondary mb-3">Informasi Lokasi</h5>
                    <p class="mb-1 text-muted small">Alamat Jalan:</p>
                    <p class="fw-semibold">Jl. {{ $laporan->jalan->nama_jalan }}</p>
                    
                    <p class="mb-1 text-muted small">Wilayah:</p>
                    <p class="fw-semibold">{{ $laporan->jalan->desa->nama_desa }}, Kec. {{ $laporan->jalan->desa->kecamatan->nama_kecamatan }}</p>
                    
                    <p class="mb-1 text-muted small">Koordinat GPS:</p>
                    <p class="fw-semibold text-primary">
                        @if($laporan->latitude && $laporan->longitude)
                            {{ $laporan->latitude }}, {{ $laporan->longitude }}
                            <a href="https://www.google.com/maps?q={{ $laporan->latitude }},{{ $laporan->longitude }}" target="_blank" class="ms-2 small">(Lihat di Maps)</a>
                        @else
                            <span class="text-danger italic">Tidak disertakan</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-4">
                    <h5 class="fw-bold text-secondary mb-3">Kondisi Kerusakan</h5>
                    <p class="mb-1 text-muted small">Kategori:</p>
                    <p class="fw-semibold">{{ $laporan->kategori->nama_kategori }}</p>

                    <p class="mb-1 text-muted small">Tingkat Bahaya / Urgensi:</p>
                    <p class="fw-bold {{ $laporan->tingkat_bahaya == 'Bahaya Tinggi' ? 'text-danger' : ($laporan->tingkat_bahaya == 'Sedang' ? 'text-warning' : 'text-success') }}">
                        {{ $laporan->tingkat_bahaya }}
                    </p>

                    <p class="mb-1 text-muted small">Deskripsi:</p>
                    <div class="p-3 bg-light rounded border border-light-subtle">
                        {{ $laporan->deskripsi }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h5 class="fw-bold text-secondary mb-3 text-center">Bukti Foto Kerusakan</h5>
                    <div class="text-center p-2 border rounded bg-light">
                        @if($laporan->url_foto)
                            <img src="{{ asset('storage/' . $laporan->url_foto) }}" class="img-fluid rounded shadow-sm" style="max-height: 400px;" alt="Foto Kerusakan">
                        @else
                            <p class="py-5 text-muted">Foto tidak tersedia.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline Progress -->
        <div class="card card-sigap p-4 shadow-sm">
            <h5 class="fw-bold text-secondary mb-4 text-center">Status & Timeline Penanganan</h5>
            <div class="list-group list-group-flush">
                <div class="list-group-item px-0 border-0 mb-3">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">1</div>
                            <div>
                                <h6 class="mb-0 fw-bold">Laporan Dibuat</h6>
                                <p class="mb-0 text-muted small">Laporan Anda telah berhasil masuk ke sistem SIGAP.</p>
                            </div>
                        </div>
                        <small class="text-muted">{{ $laporan->created_at->format('d M Y') }}</small>
                    </div>
                </div>

                <div class="list-group-item px-0 border-0 mb-3">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="{{ $laporan->id_status >= 2 ? 'bg-primary' : 'bg-secondary opacity-50' }} text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">2</div>
                            <div>
                                <h6 class="mb-0 fw-bold">Validasi Kecamatan</h6>
                                @if($laporan->validasi)
                                    <p class="mb-0 text-muted small">Divalidasi oleh: {{ $laporan->validasi->pengguna->nama_lengkap }} (Kecamatan)</p>
                                    <p class="mb-0 small text-success">"{{ $laporan->validasi->catatan }}"</p>
                                @else
                                    <p class="mb-0 text-muted small">Menunggu verifikasi lapangan dari pihak kecamatan.</p>
                                @endif
                            </div>
                        </div>
                        @if($laporan->validasi)
                            <small class="text-muted">{{ $laporan->validasi->created_at->format('d M Y') }}</small>
                        @endif
                    </div>
                </div>

                <div class="list-group-item px-0 border-0 mb-3">
                    <div class="d-flex w-100 align-items-start">
                        <div class="{{ $laporan->id_status == 3 || $laporan->id_status == 2 ? 'bg-primary' : 'bg-secondary opacity-50' }} text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; flex-shrink: 0;">3</div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-bold">Pengerjaan Dinas PUPR</h6>
                            @if($laporan->logProses->count() > 0)
                                <p class="mb-0 text-muted small">Proses penanganan sedang/telah dilakukan.</p>
                                <button type="button" class="btn btn-sm btn-outline-primary fw-semibold rounded-pill px-3 mt-2" data-bs-toggle="modal" data-bs-target="#modalProgresPUPR">
                                    Lihat Detail Penanganan
                                </button>
                            @else
                                <p class="mb-0 text-muted small">Setelah validasi, tim teknis PUPR akan menjadwalkan perbaikan.</p>
                            @endif
                        </div>
                    </div>
                </div>


                @if($laporan->id_status == 3)
                    <div class="list-group-item px-0 border-0">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">4</div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-success">Perbaikan Selesai</h6>
                                    <p class="mb-0 text-muted small">Jalan telah diperbaiki dan diverifikasi oleh pihak berwenang.</p>
                                </div>
                            </div>
                            <small class="text-muted">{{ $laporan->updated_at->format('d M Y') }}</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Progres PUPR -->
@if($laporan->logProses->count() > 0)
<div class="modal fade" id="modalProgresPUPR" tabindex="-1" aria-labelledby="modalProgresPUPRLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow" style="border-radius: 1rem;">
            <div class="modal-header border-0 bg-white pt-4 px-4 pb-0">
                <h5 class="modal-title fw-bolder text-dark" id="modalProgresPUPRLabel">
                    <i class="fa-solid fa-hard-hat text-primary me-2"></i> Riwayat Penanganan PUPR
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <div class="timeline-container relative">
                    @foreach($laporan->logProses as $log)
                    <div class="card bg-light border-0 mb-3 rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold">Update Progres</span>
                                <small class="text-muted fw-bold"><i class="fa-regular fa-clock me-1"></i> {{ $log->created_at->format('d M Y, H:i') }} WIB</small>
                            </div>
                            <p class="mb-0 fw-medium text-secondary" style="line-height: 1.6;">{{ $log->catatan_update }}</p>
                            
                            @if(!empty($log->url_foto_selesai) && $log->url_foto_selesai !== 'default.jpg' && $log->url_foto_selesai !== '')
                                <div class="mt-4 text-center">
                                    <img src="{{ asset('storage/' . $log->url_foto_selesai) }}" class="img-fluid rounded-4 shadow-sm" style="max-height: 300px; object-fit: cover; width: 100%;" alt="Foto Progres Lapangan">
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer border-0 bg-white pb-4 px-4">
                <button type="button" class="btn btn-secondary rounded-pill px-5 fw-bold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection