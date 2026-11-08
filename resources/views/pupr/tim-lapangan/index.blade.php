@extends('layouts.pupr')

@section('title', 'Tim Lapangan - PUPR')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Manajemen Tim Lapangan</h2>
        <a href="{{ route('pupr.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card card-sigap text-center p-4 bg-success text-white">
                <h3 class="mb-0">{{ $timTersedia }}</h3>
                <p class="mb-0 text-white-50">Tim Tersedia</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-sigap text-center p-4 bg-warning text-dark">
                <h3 class="mb-0">{{ $timDiLapangan }}</h3>
                <p class="mb-0 text-warning-50">Tim Di Lapangan</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-sigap text-center p-4 bg-secondary text-white">
                <h3 class="mb-0">{{ $timLapangan->count() }}</h3>
                <p class="mb-0 text-white-50">Total Tim</p>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($timLapangan as $tim)
        <div class="col-md-4 mb-4">
            <div class="card card-sigap">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">{{ $tim->nama_tim }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="badge bg-{{ $tim->status == 'Tersedia' ? 'success' : ($tim->status == 'Di Lapangan' ? 'warning' : 'secondary') }}">
                            {{ $tim->status }}
                        </span>
                    </div>
                    <p class="mb-1"><strong>Jumlah Personel:</strong> {{ $tim->jumlah_personel }} orang</p>
                    <p class="mb-1"><strong>Laporan Ditangani:</strong> {{ $tim->laporan_count ?? 0 }}</p>
                    <p class="mb-3 text-muted small">ID: {{ $tim->id_tim }}</p>
                    
                    <form action="{{ route('pupr.tim-lapangan.update-status', $tim->id_tim) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-2">
                            <select name="status" class="form-select form-select-sm">
                                <option value="Tersedia" {{ $tim->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Di Lapangan" {{ $tim->status == 'Di Lapangan' ? 'selected' : '' }}>Di Lapangan</option>
                                <option value="Standby" {{ $tim->status == 'Standby' ? 'selected' : '' }}>Standby</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection