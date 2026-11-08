<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>BAST - {{ $laporan->id_laporan }}</title>
    <style>
        body { font-family: sans-serif; font-size: 11pt; line-height: 1.4; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 5px 0; }
        .header small { color: #666; }
        .info { margin: 20px 0; }
        .info div { margin-bottom: 8px; }
        .info strong { display: inline-block; width: 120px; }
        .ttd { margin-top: 40px; display: flex; justify-content: space-between; }
        .ttd-column { text-align: center; width: 45%; }
        .ttd-column p { margin: 80px 0 0 0; }
        .footer { margin-top: 40px; border-top: 1px solid #ccc; padding-top: 10px; font-size: 9pt; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>BERITA ACARA SERAH TERIMA (BAST)</h2>
        <small>Pekerjaan Perbaikan Infrastruktur Jalan</small>
        <p style="margin-top: 15px; font-size: 9pt;">Nomor: {{ $laporan->no_bast ?? 'Belum ada' }}</p>
    </div>

    <div class="info">
        <div><strong>Kecamatan:</strong> {{ $laporan->jalan->desa->kecamatan->nama_kecamatan }}</div>
        <div><strong>Desa:</strong> {{ $laporan->jalan->desa->nama_desa }}</div>
        <div><strong>Jalan:</strong> {{ $laporan->jalan->nama_jalan }}</div>
        <div><strong>Kategori:</strong> {{ $laporan->kategori->nama_kategori }}</div>
        <div><strong>Tingkat Bahaya:</strong> {{ $laporan->tingkat_bahaya }}</div>
        <div><strong>Tim:</strong> {{ $laporan->timLapangan->nama_tim ?? '-' }}</div>
        <div><strong>Tanggal Laporan:</strong> {{ \Carbon\Carbon::parse($laporan->created_at)->format('d/m/Y') }}</div>
    </div>

    <div class="info">
        <div><strong>Deskripsi Kerusakan:</strong></div>
        <p style="margin: 5px 0 15px 120px;">{{ $laporan->deskripsi }}</p>
    </div>

    <div class="info">
        <div><strong>Pelapor:</strong> {{ $laporan->pengguna->nama_lengkap }}</div>
        <div><strong>Email:</strong> {{ $laporan->pengguna->email }}</div>
    </div>

    <div class="info">
        <div><strong>Tahapan Pengerjaan:</strong></div>
        <ul>
            @foreach($laporan->logProses as $log)
            <li>{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y, H:i') }} - {{ $log->catatan_update }}</li>
            @endforeach
        </ul>
    </div>

    <div class="info">
        <p style="margin-top: 20px;"><strong>Dengan ini menyatakan bahwa pekerjaan perbaikan jalan di atas telah selesai dikerjakan dengan baik dan sesuai dengan spesifikasi yang disepakati.</strong></p>
    </div>

    <div class="ttd">
        <div class="ttd-column">
            <p>Dari Pihak PUPR</p>
            <br><br>
            <u>(...........................)</u>
            <p>NIP. ...........................</p>
        </div>
        <div class="ttd-column">
            <p>Dari Pihak Kecamatan</p>
            <br><br>
            <u>(...........................)</u>
            <p>NIP. ...........................</p>
        </div>
    </div>

    <div class="footer">
        <p>PDF ini dibuat otomatis oleh sistem SIGAP Kab. Jember</p>
    </div>
</body>
</html>