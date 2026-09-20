@extends('layouts.warga')

@section('title', 'Beranda - SIGAP')

@section('content')
<div class="container">
    <h2 class="mb-4">Selamat datang, <span class="text-primary">{{ session('warga_name') }}</span></h2>
    <p class="text-muted mb-4">Sampaikan laporan kerusakan infrastruktur jalan di wilayah Anda.</p>

    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card card-sigap text-center p-3">
                <h3 class="text-primary mb-1">{{ $statistik['total'] }}</h3>
                <small class="text-muted">Total Laporan</small>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card card-sigap text-center p-3">
                <h3 class="text-warning mb-1">{{ $statistik['menunggu'] }}</h3>
                <small class="text-muted">Menunggu</small>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card card-sigap text-center p-3">
                <h3 class="text-info mb-1">{{ $statistik['diproses'] }}</h3>
                <small class="text-muted">Diproses</small>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card card-sigap text-center p-3">
                <h3 class="text-success mb-1">{{ $statistik['selesai'] }}</h3>
                <small class="text-muted">Selesai</small>
            </div>
        </div>
    </div>

    <div class="card card-sigap p-4 text-center">
        <h4 class="mb-3">Ada kerusakan jalan?</h4>
        <p class="text-muted mb-4">Laporkan sekarang dan bantu kami memperbaiki infrastruktur jalan di wilayah Anda.</p>
        <div class="d-grid gap-2 d-md-block">
            <a href="{{ route('warga.laporan.create') }}" class="btn btn-sigap-primary btn-lg px-4 me-md-2">Buat Laporan Baru</a>
            <a href="{{ route('warga.laporan.index') }}" class="btn btn-outline-primary btn-lg px-4">Lihat Riwayat Laporan</a>
        </div>
    </div>
</div>
@endsection