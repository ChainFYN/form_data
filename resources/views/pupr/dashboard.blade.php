@extends('layouts.pupr')

@section('title', 'Beranda Admin PUPR - SIGAP')

@section('content')
<div class="container">
    <h2 class="mb-4">Selamat datang, <span class="text-primary">{{ session('pupr_name', 'Admin PUPR') }}</span></h2>
    <p class="text-muted mb-4">Dashboard pengelolaan dan tindak lanjut laporan kerusakan infrastruktur jalan.</p>

    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card card-sigap text-center p-3">
                <h3 class="text-primary mb-1">{{ $statistik['total'] ?? 0 }}</h3>
                <small class="text-muted">Total Laporan Masuk</small>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card card-sigap text-center p-3">
                <h3 class="text-warning mb-1">{{ $statistik['menunggu'] ?? 0 }}</h3>
                <small class="text-muted">Laporan Tervalidasi (Menunggu Tindak Lanjut)</small>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card card-sigap text-center p-3">
                <h3 class="text-info mb-1">{{ $statistik['diproses'] ?? 0 }}</h3>
                <small class="text-muted">Dalam Proses Perbaikan</small>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card card-sigap text-center p-3">
                <h3 class="text-success mb-1">{{ $statistik['selesai'] ?? 0 }}</h3>
                <small class="text-muted">Perbaikan Selesai</small>
            </div>
        </div>
    </div>

    <div class="card card-sigap p-4 text-center">
        <h4 class="mb-3">Tindak Lanjut Laporan</h4>
        <p class="text-muted mb-4">Pantau laporan tervalidasi dari kecamatan dan segera berikan rekomendasi serta perbarui log proses perbaikan.</p>
        <div class="d-grid gap-2 d-md-block">
            <a href="{{ route('pupr.laporan.index') ?? '#' }}" class="btn btn-sigap-primary btn-lg px-4 me-md-2">Lihat Daftar Laporan</a>
        </div>
    </div>
</div>
@endsection
