@extends('layouts.warga')

@section('title', 'Riwayat Laporan - SIGAP')

@section('content')
<div class="card card-sigap p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary mb-0">Riwayat Laporan Anda</h3>
        <a href="{{ route('warga.laporan.create') }}" class="btn btn-sigap-primary">+ Buat Laporan Baru</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>ID Tiket / Tanggal</th>
                    <th>Lokasi & Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <span class="fw-bold">#LP-{{ str_pad($item->id_laporan, 4, '0', STR_PAD_LEFT) }}</span><br>
                        <small class="text-muted">{{ $item->created_at->format('d M Y, H:i') }} WIB</small>
                    </td>
                    <td>
                        <span class="fw-semibold">Jl. {{ $item->jalan->nama_jalan }}</span><br>
                        <small class="text-secondary">{{ $item->kategori->nama_kategori }} - {{ $item->jalan->desa->nama_desa }}</small>
                    </td>
                    <td>
                        @php
                            $statusClass = 'status-menunggu';
                            if($item->id_status == 2) $statusClass = 'status-diproses';
                            elseif($item->id_status == 3) $statusClass = 'status-selesai';
                            elseif($item->id_status == 4) $statusClass = 'status-ditolak';
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $item->status->nama_status }}</span>
                    </td>
                    <td>
                        <a href="{{ route('warga.laporan.show', $item->id_laporan) }}" class="btn btn-sm btn-outline-primary px-3">Lihat Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <p class="text-muted mb-0">Belum ada laporan yang dikirim.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection