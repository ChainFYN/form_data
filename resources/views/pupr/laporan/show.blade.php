@extends('layouts.pupr')

@section('title', 'Detail & Tindak Lanjut Laporan - SIGAP')

@section('content')
<div class="row">
    <!-- Kolom Kiri: Detail Laporan -->
    <div class="col-md-7 mb-4">
        <div class="card card-sigap p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-primary mb-0">Detail Laporan #LP-{{ str_pad($laporan->id_laporan ?? 0, 4, '0', STR_PAD_LEFT) }}</h4>
                @php
                    $statusClass = 'status-menunggu';
                    if(($laporan->id_status ?? 1) == 2) $statusClass = 'status-diproses';
                    elseif(($laporan->id_status ?? 1) == 3) $statusClass = 'status-selesai';
                    elseif(($laporan->id_status ?? 1) == 4) $statusClass = 'status-ditolak';
                @endphp
                <span class="status-badge {{ $statusClass }}">{{ $laporan->status->nama_status ?? 'Status' }}</span>
            </div>

            <div class="mb-3">
                <img src="{{ asset('storage/' . ($laporan->foto ?? 'default.jpg')) }}" class="img-fluid rounded w-100" alt="Foto Kerusakan" style="max-height: 400px; object-fit: cover;">
            </div>

            <table class="table table-borderless">
                <tr>
                    <td width="35%" class="text-muted fw-semibold">Pelapor</td>
                    <td>: {{ $laporan->pengguna->nama_lengkap ?? 'Nama Pelapor' }}</td>
                </tr>
                <tr>
                    <td class="text-muted fw-semibold">Tanggal Laporan</td>
                    <td>: {{ isset($laporan->created_at) ? $laporan->created_at->format('d M Y, H:i') : '-' }} WIB</td>
                </tr>
                <tr>
                    <td class="text-muted fw-semibold">Kategori Kerusakan</td>
                    <td>: {{ $laporan->kategori->nama_kategori ?? 'Kategori' }}</td>
                </tr>
                <tr>
                    <td class="text-muted fw-semibold">Tingkat Bahaya</td>
                    <td>: <span class="badge bg-{{ ($laporan->tingkat_bahaya ?? '') == 'Bahaya Tinggi' ? 'danger' : (($laporan->tingkat_bahaya ?? '') == 'Sedang' ? 'warning' : 'info') }}">{{ $laporan->tingkat_bahaya ?? 'Tingkat' }}</span></td>
                </tr>
                <tr>
                    <td class="text-muted fw-semibold">Lokasi</td>
                    <td>: Jl. {{ $laporan->jalan->nama_jalan ?? '-' }}, Ds. {{ $laporan->jalan->desa->nama_desa ?? '-' }}, Kec. {{ $laporan->jalan->desa->kecamatan->nama_kecamatan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="text-muted fw-semibold">Deskripsi</td>
                    <td>: {{ $laporan->deskripsi ?? 'Deskripsi Laporan' }}</td>
                </tr>
            </table>

            @if(isset($laporan->validasi))
            <hr>
            <h5 class="fw-bold text-secondary mb-3">Catatan Validasi Kecamatan</h5>
            <div class="alert alert-info">
                <strong>Validator:</strong> {{ $laporan->validasi->pengguna->nama_lengkap ?? 'Admin Kec' }}<br>
                <strong>Tanggal:</strong> {{ $laporan->validasi->created_at->format('d M Y') }}<br>
                <strong>Catatan:</strong> {{ $laporan->validasi->catatan ?? '-' }}
            </div>
            @endif
        </div>
    </div>

    <!-- Kolom Kanan: Tindak Lanjut PUPR -->
    <div class="col-md-5 mb-4">
        <div class="card card-sigap p-4 mb-4">
            <h4 class="fw-bold text-primary mb-3">Tindak Lanjut & Log Proses</h4>
            <form action="{{ route('pupr.laporan.log', $laporan->id_laporan ?? 0) ?? '#' }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Update Status Perbaikan</label>
                    <select name="id_status" class="form-select" required>
                        <option value="2" {{ ($laporan->id_status ?? 1) == 2 ? 'selected' : '' }}>Diproses (Sedang Diperbaiki)</option>
                        <option value="3" {{ ($laporan->id_status ?? 1) == 3 ? 'selected' : '' }}>Selesai (Perbaikan Rampung)</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Catatan Progress / Log Proses</label>
                    <textarea name="catatan_progress" class="form-control" rows="3" placeholder="Tulis catatan progress saat ini..." required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Foto Bukti Progress/Selesai (Opsional)</label>
                    <input type="file" name="foto_selesai" class="form-control" accept="image/*">
                    <small class="text-muted">Upload foto pengerjaan atau hasil setelah diperbaiki.</small>
                </div>

                <button type="submit" class="btn btn-sigap-primary w-100">Simpan Log Proses</button>
            </form>
        </div>

        <div class="card card-sigap p-4">
            <h4 class="fw-bold text-primary mb-3">Rekomendasi Perbaikan</h4>
            <form action="{{ route('pupr.laporan.rekomendasi', $laporan->id_laporan ?? 0) ?? '#' }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Jenis Perbaikan (Saran Teknis)</label>
                    <input type="text" name="jenis_perbaikan" class="form-control" placeholder="Misal: Penambalan aspal, cor beton..." required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Estimasi Biaya / Anggaran (Opsional)</label>
                    <input type="number" name="estimasi_biaya" class="form-control" placeholder="Rp ...">
                </div>

                <button type="submit" class="btn btn-warning w-100 fw-bold">Simpan Rekomendasi</button>
            </form>
        </div>
        
        @if(isset($laporan->logProses) && $laporan->logProses->count() > 0)
        <div class="card card-sigap p-4 mt-4">
            <h5 class="fw-bold text-secondary mb-3">Riwayat Log Proses</h5>
            <ul class="list-group list-group-flush">
                @foreach($laporan->logProses as $log)
                <li class="list-group-item px-0">
                    <small class="text-muted d-block">{{ $log->created_at->format('d M Y, H:i') }} WIB</small>
                    <span class="fw-semibold">{{ $log->status->nama_status ?? 'Update' }}:</span> {{ $log->catatan }}
                    @if($log->url_foto_selesai)
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $log->url_foto_selesai) }}" target="_blank" class="badge bg-primary text-decoration-none">Lihat Foto</a>
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>
@endsection
