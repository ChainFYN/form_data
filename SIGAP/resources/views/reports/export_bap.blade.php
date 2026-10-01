<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap BAP Disposisi Jalan - SIGAP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0 !important; }
        }
    </style>
</head>
<body class="bg-slate-100 p-8 print:p-4 text-slate-800 text-xs">

    <div class="max-w-6xl mx-auto mb-4 flex justify-between items-center no-print">
        <a href="{{ route('dashboard') }}" class="font-bold text-slate-600 hover:text-slate-900">&larr; Kembali ke Dashboard</a>
        <button onclick="window.print()" class="bg-brand-600 hover:bg-brand-700 text-white font-bold px-4 py-2 rounded-lg flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Cetak Dokumen Rekap BAP
        </button>
    </div>

    <div class="max-w-6xl mx-auto bg-white p-8 rounded-xl border border-slate-200 shadow-sm print:border-none print:shadow-none">
        
        <div class="text-center pb-4 border-b-2 border-slate-900">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-500">PEMERINTAH KABUPATEN JEMBER — KECAMATAN JEMBER</h2>
            <h1 class="text-xl font-extrabold text-slate-900 uppercase mt-1">DAFTAR REKAPITULASI DISPOSISI ADUAN JALAN KE DINAS PUPR</h1>
            <p class="text-xs text-slate-500 mt-0.5">Periode Tahun Anggaran 2026 • Wilayah Kerja Seksi Ekbang Kecamatan Jember</p>
        </div>

        <table class="w-full text-left text-[11px] mt-6 border-collapse">
            <thead>
                <tr class="bg-slate-100 border-y border-slate-300 font-bold uppercase tracking-wider text-slate-700">
                    <th class="py-2.5 px-3">No</th>
                    <th class="py-2.5 px-3">No. Tiket</th>
                    <th class="py-2.5 px-3">Ruas Jalan</th>
                    <th class="py-2.5 px-3">Wilayah</th>
                    <th class="py-2.5 px-3">Urgensi</th>
                    <th class="py-2.5 px-3">Prioritas PUPR</th>
                    <th class="py-2.5 px-3">Estimasi Teknis</th>
                    <th class="py-2.5 px-3">Verifikator</th>
                    <th class="py-2.5 px-3">Waktu Validasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($reports as $index => $r)
                <tr>
                    <td class="py-2 px-3">{{ $index + 1 }}</td>
                    <td class="py-2 px-3 font-mono font-bold">{{ $r->ticket_number }}</td>
                    <td class="py-2 px-3 font-semibold">{{ $r->road_name }}</td>
                    <td class="py-2 px-3">{{ $r->village }}</td>
                    <td class="py-2 px-3 uppercase font-bold">{{ $r->urgency }}</td>
                    <td class="py-2 px-3">{{ $r->pupr_priority ?? 'Prioritas 1' }}</td>
                    <td class="py-2 px-3">{{ $r->technical_estimate ?? 'Penambalan Hotmix' }}</td>
                    <td class="py-2 px-3">{{ $r->verified_by_name ?? 'Hendra Wijaya, S.Sos' }}</td>
                    <td class="py-2 px-3">{{ $r->verified_at ? $r->verified_at->format('d/m/Y H:i') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-8 pt-4 border-t border-slate-200 flex justify-between items-center text-[10px] text-slate-400">
            <span>Dicetak secara otomatis dari SIGAP Kab. Jember</span>
            <span>Total Dokumen Disposisi: {{ count($reports) }} Laporan Terverifikasi</span>
        </div>

    </div>

</body>
</html>
