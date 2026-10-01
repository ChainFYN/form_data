<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>BAP Resmi - {{ $report->ticket_number }} - SIGAP Kab. Jember</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Times New Roman', Times, serif; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0 !important; background: white !important; }
        }
    </style>
</head>
<body class="bg-slate-100 py-10 print:py-0 text-black">

    <!-- Top Action Toolbar -->
    <div class="max-w-4xl mx-auto mb-6 px-4 flex items-center justify-between no-print">
        <a href="{{ route('kecamatan.validation.index', ['ticket' => $report->ticket_number]) }}" class="text-sm font-sans text-slate-600 hover:text-slate-900 font-bold flex items-center gap-2">
            &larr; Kembali ke Portal Validasi
        </a>
        <button onclick="window.print()" class="bg-blue-700 hover:bg-blue-800 text-white font-sans text-xs font-bold px-5 py-2.5 rounded-lg shadow flex items-center gap-2">
            <i class="fa-solid fa-print"></i>
            <span>Cetak Dokumen BAP (PDF)</span>
        </button>
    </div>

    <!-- Official Document Sheet (A4 format) -->
    <div class="max-w-4xl mx-auto bg-white p-12 border border-slate-300 shadow-lg print:border-none print:shadow-none print:p-8">
        
        <!-- KOP SURAT PEMERINTAH KABUPATEN Jember -->
        <div class="flex items-center gap-5 border-b-4 border-double border-black pb-4 text-center">
            <div class="w-24 h-24 shrink-0 flex items-center justify-center">
                <i class="fa-solid fa-landmark text-5xl text-black"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold tracking-wider uppercase">PEMERINTAH KABUPATEN Jember</h3>
                <h2 class="text-2xl font-black tracking-wide uppercase">KECAMATAN JEMBER</h2>
                <h4 class="text-sm font-bold tracking-wide uppercase">SEKSI EKONOMI DAN PEMBANGUNAN (EKBANG)</h4>
                <p class="text-xs mt-1">Jl. HR. Lukman No. 01 Jember, Kabupaten Jember 16911 Telp. (021) 875-1234</p>
                <p class="text-[11px] italic">Laman: jember.jemberkab.go.id • Email: ekbang@jember.jemberkab.go.id</p>
            </div>
            <div class="w-24 shrink-0 text-right">
                <div class="border border-black p-1 text-[9px] font-mono text-center">
                    <span>FORMULIR</span><br>
                    <strong>F-PUPR-02</strong>
                </div>
            </div>
        </div>

        <!-- DOCUMENT TITLE -->
        <div class="text-center mt-6">
            <h1 class="text-base font-bold underline uppercase tracking-wider">BERITA ACARA PEMERIKSAAN & DISPOSISI LAPANGAN (BAP-DL)</h1>
            <p class="text-xs font-mono mt-1">Nomor: 600.1 / {{ substr($report->ticket_number, 8) }} / BAP-DL / EKB-CBN / {{ date('Y') }}</p>
        </div>

        <!-- PARAGRAPH 1 -->
        <div class="mt-6 text-sm leading-relaxed text-justify">
            <p>
                Pada hari ini, <strong class="uppercase">{{ Carbon\Carbon::parse($report->verified_at ?? now())->translatedFormat('l, d F Y') }}</strong>, bertempat di Kantor Kecamatan Jember, telah dilakukan verifikasi administratif, geospasial, dan teknis lapangan atas laporan pengaduan masyarakat mengenai gangguan prasarana jalan kabupaten sebagai berikut:
            </p>
        </div>

        <!-- SECTION I: IDENTITAS PENGADUAN -->
        <div class="mt-5">
            <h4 class="text-xs font-bold uppercase tracking-wider border-b border-black pb-1">I. DATA TIKET & IDENTITAS PELAPOR</h4>
            <table class="w-full text-xs mt-2 leading-relaxed">
                <tr>
                    <td class="w-48 py-1">Nomor Registrasi Aduan</td>
                    <td class="w-4 py-1">:</td>
                    <td class="py-1 font-mono font-bold">{{ $report->ticket_number }}</td>
                </tr>
                <tr>
                    <td class="py-1">Nama Pelapor Warga</td>
                    <td class="py-1">:</td>
                    <td class="py-1 font-bold">{{ $report->reporter_name }} (Terverifikasi NIK: {{ $report->masked_nik }})</td>
                </tr>
                <tr>
                    <td class="py-1">Alamat / Kontak</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $report->reporter_address }} / Telp: {{ $report->reporter_phone }}</td>
                </tr>
                <tr>
                    <td class="py-1">Waktu Masuk Aduan</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $report->created_at ? $report->created_at->format('d/m/Y H:i') : '-' }} WIB</td>
                </tr>
            </table>
        </div>

        <!-- SECTION II: FAKTA TEKNIS & LOKASI -->
        <div class="mt-5">
            <h4 class="text-xs font-bold uppercase tracking-wider border-b border-black pb-1">II. HASIL VERIFIKASI & FAKTA TEKNIS RUAS JALAN</h4>
            <table class="w-full text-xs mt-2 leading-relaxed">
                <tr>
                    <td class="w-48 py-1">Nama Ruas Jalan</td>
                    <td class="w-4 py-1">:</td>
                    <td class="py-1 font-bold">{{ $report->road_name }}</td>
                </tr>
                <tr>
                    <td class="py-1">Kelurahan / Desa</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $report->village }}, Kecamatan Jember</td>
                </tr>
                <tr>
                    <td class="py-1">Klasifikasi Jalan</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $report->road_class }}</td>
                </tr>
                <tr>
                    <td class="py-1">Titik Koordinat GPS</td>
                    <td class="py-1">:</td>
                    <td class="py-1 font-mono">Lat: {{ number_format($report->latitude, 6) }}, Lng: {{ number_format($report->longitude, 6) }} (Akurasi: ±{{ $report->gps_accuracy_m }} meter)</td>
                </tr>
                <tr>
                    <td class="py-1">Tingkat Urgensi / Status</td>
                    <td class="py-1">:</td>
                    <td class="py-1 font-bold uppercase">{{ $report->urgency_label }} / {{ $report->status_label }}</td>
                </tr>
                <tr>
                    <td class="py-1 align-top">Keterangan / Temuan Warga</td>
                    <td class="py-1 align-top">:</td>
                    <td class="py-1 italic text-justify">"{{ $report->description }}"</td>
                </tr>
            </table>
        </div>

        <!-- SECTION III: REKOMENDASI DISPOSISI -->
        <div class="mt-5">
            <h4 class="text-xs font-bold uppercase tracking-wider border-b border-black pb-1">III. REKOMENDASI & DISPOSISI TEKNIS KECAMATAN KE DINAS PUPR</h4>
            <table class="w-full text-xs mt-2 leading-relaxed">
                <tr>
                    <td class="w-48 py-1">Prioritas Penanganan UPT</td>
                    <td class="w-4 py-1">:</td>
                    <td class="py-1 font-bold">{{ $report->pupr_priority ?? 'PRIORITAS 1 - DARURAT (SLA 48 Jam)' }}</td>
                </tr>
                <tr>
                    <td class="py-1">Estimasi Tindakan Teknis</td>
                    <td class="py-1">:</td>
                    <td class="py-1 font-bold">{{ $report->technical_estimate ?? 'Penambalan Aspal Dingin/Hotmix (Patching)' }}</td>
                </tr>
                <tr>
                    <td class="py-1 align-top">Catatan Resmi Disposisi</td>
                    <td class="py-1 align-top">:</td>
                    <td class="py-1 text-justify font-sans bg-slate-50 p-2 border border-slate-200">
                        {{ $report->verifier_notes ?? 'Laporan valid. Titik koordinat sesuai dengan ruas jalan kabupaten kelas 3B. Prioritas penambalan aspal hotmix darurat untuk mencegah korban kecelakaan lalu lintas lanjutan UPTD.' }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- SIGNATURES -->
        <div class="mt-10 grid grid-cols-2 gap-8 text-center text-xs">
            <div>
                <p>Mengetahui,</p>
                <p class="font-bold">Camat Jember</p>
                <div class="h-20 flex items-center justify-center">
                    <span class="text-[10px] font-mono border border-dashed border-slate-400 px-3 py-1 text-slate-500">[Tanda Tangan Elektronik]</span>
                </div>
                <p class="font-bold underline">Drs. RUSLIANDY, M.Si., M.E.</p>
                <p>NIP. 19720412 199303 1 005</p>
            </div>

            <div>
                <p>Jember, {{ Carbon\Carbon::parse($report->verified_at ?? now())->translatedFormat('d F Y') }}</p>
                <p class="font-bold">Kasi Ekonomi dan Pembangunan</p>
                <div class="h-20 flex items-center justify-center">
                    <span class="text-[10px] font-mono border border-emerald-600 px-3 py-1 text-emerald-700 bg-emerald-50 font-bold">[Tervalidasi Digital - KASI EKBANG]</span>
                </div>
                <p class="font-bold underline">{{ $report->verified_by_name ?? 'Hendra Wijaya, S.Sos' }}</p>
                <p>NIP. {{ $report->verified_by_nip ?? '19790623 200501 1 004' }}</p>
            </div>
        </div>

        <div class="mt-8 pt-4 border-t border-slate-300 text-[10px] flex justify-between items-center text-slate-500 font-sans">
            <span>Dokumen ini diterbitkan sah melalui Sistem Informasi Tanggap Pengaduan Jalan (SIGAP) Kab. Jember.</span>
            <span class="font-mono">Verifikasi Otentikasi: #{{ md5($report->ticket_number) }}</span>
        </div>

    </div>

</body>
</html>
