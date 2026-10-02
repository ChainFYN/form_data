<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Validasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ValidationController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'all');
        $search = $request->query('search', '');
        $selectedId = $request->query('ticket');

        $query = Laporan::with(['pengguna', 'jalan.desa.kecamatan', 'kategori', 'status', 'validasi']);

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id_laporan', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhereHas('pengguna', fn ($q2) => $q2->where('nama_lengkap', 'like', "%{$search}%"))
                    ->orWhereHas('jalan', fn ($q2) => $q2->where('nama_jalan', 'like', "%{$search}%"));
            });
        }

        // Apply Tab filters based on id_status
        // 1 = Menunggu Validasi, 2 = Diproses, 3 = Selesai, 4 = Ditolak
        if ($tab === 'pending') {
            $query->where('id_status', 1);
        } elseif ($tab === 'resolved') {
            $query->whereIn('id_status', [3, 4]);
        } elseif ($tab === 'high') {
            $query->where('tingkat_bahaya', 'Bahaya Tinggi');
        }

        $tickets = $query->orderByRaw("CASE
                WHEN tingkat_bahaya = 'Bahaya Tinggi' THEN 1
                WHEN tingkat_bahaya = 'Sedang' THEN 2
                ELSE 3
            END")
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        // Active ticket for the right detail panel
        $activeTicket = null;
        if ($selectedId) {
            $activeTicket = Laporan::with(['pengguna', 'jalan.desa.kecamatan', 'kategori', 'status', 'validasi'])->find($selectedId);
        }
        if (! $activeTicket && $tickets->isNotEmpty()) {
            $activeTicket = $tickets->first();
        }

        // Counts for tabs
        $allCount = Laporan::count();
        $highCount = Laporan::where('tingkat_bahaya', 'Bahaya Tinggi')->count();
        $pendingCount = Laporan::where('id_status', 1)->count();
        $resolvedCount = Laporan::whereIn('id_status', [3, 4])->count();

        $accuracyScore = 98.4;
        $activeQueueToday = Laporan::where('id_status', 1)->where('tingkat_bahaya', 'Bahaya Tinggi')->count();

        return view('kecamatan.validation.index', compact(
            'tickets',
            'activeTicket',
            'tab',
            'search',
            'allCount',
            'highCount',
            'pendingCount',
            'resolvedCount',
            'accuracyScore',
            'activeQueueToday'
        ));
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $kecamatanId = Session::get('kecamatan_id');
        $action = $request->input('action', 'acc');
        $catatan = trim((string) $request->input('catatan', ''));

        // 1. Validasi catatan wajib diisi (baik ACC maupun Reject)
        if ($catatan === '') {
            return redirect()
                ->route('kecamatan.validation.index', ['ticket' => $laporan->id_laporan])
                ->withInput()
                ->withErrors(['catatan' => 'Catatan verifikator kecamatan wajib diisi.']);
        }

        // 2. Validasi catatan tidak boleh mengandung simbol khusus
        // Hanya huruf, angka, spasi, enter, dan tanda baca standar (. , - ? ! ())
        if (! preg_match('/^[a-zA-Z0-9\s.,!?\-()]+$/u', $catatan)) {
            return redirect()
                ->route('kecamatan.validation.index', ['ticket' => $laporan->id_laporan])
                ->withInput()
                ->withErrors(['catatan' => 'Catatan tidak boleh mengandung simbol. Hanya huruf, angka, spasi, dan tanda baca umum (. , - ? ! ()) yang diperbolehkan.']);
        }

        if ($action === 'acc') {
            // Update status ke Diproses (id_status = 2)
            $laporan->update(['id_status' => 2]);

            // Simpan ke tabel validasi
            Validasi::updateOrCreate(
                ['id_laporan' => $laporan->id_laporan],
                [
                    'id_pengguna' => $kecamatanId,
                    'status_valid' => 'VALID',
                    'catatan' => $catatan,
                ]
            );

            $msg = "Laporan #{$laporan->id_laporan} berhasil divalidasi & diteruskan ke Dinas PUPR!";
            $type = 'success';
        } elseif ($action === 'reject') {
            // Update status ke Ditolak (id_status = 4)
            $laporan->update(['id_status' => 4]);

            Validasi::updateOrCreate(
                ['id_laporan' => $laporan->id_laporan],
                [
                    'id_pengguna' => $kecamatanId,
                    'status_valid' => 'TIDAK_VALID',
                    'catatan' => $catatan,
                ]
            );

            $msg = "Laporan #{$laporan->id_laporan} telah ditolak.";
            $type = 'warning';
        } else {
            // Draft — tidak ubah status
            $msg = "Draft catatan laporan #{$laporan->id_laporan} berhasil disimpan.";
            $type = 'info';
        }

        return redirect()->route('kecamatan.validation.index', ['ticket' => $laporan->id_laporan])
            ->with('status', $msg)
            ->with('status_type', $type);
    }
}
