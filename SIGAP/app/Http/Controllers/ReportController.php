<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Rekapitulasi Progres
     */
    public function recapitulation(Request $request)
    {
        $status = $request->query('status');
        $urgency = $request->query('urgency');
        $village = $request->query('village');
        $search = $request->query('search');

        $query = Report::query();

        if ($status) {
            $query->where('status', $status);
        }
        if ($urgency) {
            $query->where('urgency', $urgency);
        }
        if ($village) {
            $query->where('village', $village);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('road_name', 'like', "%{$search}%")
                  ->orWhere('reporter_name', 'like', "%{$search}%");
            });
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(15);
        $villages = Village::all();

        return view('reports.recapitulation', compact('reports', 'villages', 'status', 'urgency', 'village', 'search'));
    }

    /**
     * Statistik Wilayah
     */
    public function statistics()
    {
        $villages = Village::all();
        $totalReports = Report::count();
        $pendingReports = Report::where('status', 'menunggu_validasi')->count();
        $forwardedReports = Report::where('status', 'diteruskan_pupr')->count();
        $rejectedReports = Report::where('status', 'ditolak')->count();

        // Urgency breakdown
        $urgencyBreakdown = [
            'darurat' => Report::where('urgency', 'darurat')->count(),
            'tinggi' => Report::where('urgency', 'tinggi')->count(),
            'sedang' => Report::where('urgency', 'sedang')->count(),
            'normal' => Report::where('urgency', 'normal')->count(),
        ];

        return view('reports.statistics', compact(
            'villages',
            'totalReports',
            'pendingReports',
            'forwardedReports',
            'rejectedReports',
            'urgencyBreakdown'
        ));
    }

    /**
     * Data Master Desa & Ruas Jalan
     */
    public function masterDesa()
    {
        $villages = Village::withCount('reports')->get();
        return view('reports.master_desa', compact('villages'));
    }

    /**
     * Peta GIS Interaktif
     */
    public function gisMap()
    {
        $reports = Report::all();
        return view('reports.gis_map', compact('reports'));
    }

    /**
     * Cetak Berita Acara Pemeriksaan (BAP) Resmi
     */
    public function printBap($id)
    {
        $report = Report::findOrFail($id);
        return view('reports.print_bap', compact('report'));
    }

    /**
     * Ekspor Rekap BAP
     */
    public function exportBap()
    {
        $reports = Report::where('status', 'diteruskan_pupr')
            ->orderBy('verified_at', 'desc')
            ->get();
        return view('reports.export_bap', compact('reports'));
    }

    /**
     * Form Lapor Baru (Warga)
     */
    public function create()
    {
        $villages = Village::all();
        return view('reports.create', compact('villages'));
    }

    /**
     * Simpan Aduan Baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'road_name' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'urgency' => 'required|in:darurat,tinggi,sedang,normal',
            'description' => 'required|string|min:10',
            'reporter_name' => 'required|string|max:255',
            'reporter_nik' => 'required|string|max:20',
            'reporter_phone' => 'required|string|max:20',
            'reporter_address' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Generate Ticket Number: LP-2026-XXXX
        $lastReport = Report::latest('id')->first();
        $nextId = $lastReport ? $lastReport->id + 1 : 1;
        $ticketNumber = 'LP-2026-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $slaHours = match ($validated['urgency']) {
            'darurat' => 2,
            'tinggi' => 5,
            'sedang' => 14,
            default => 24,
        };

        $photoPath = 'https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?auto=format&fit=crop&w=800&q=80';

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/reports');
            $photoPath = asset(str_replace('public/', 'storage/', $path));
        }

        $report = Report::create([
            'ticket_number' => $ticketNumber,
            'title' => $validated['road_name'] . ' (' . $validated['village'] . ')',
            'road_name' => $validated['road_name'],
            'subdistrict' => 'Kecamatan jember',
            'village' => $validated['village'],
            'road_class' => 'Ruas Jalan Kabupaten',
            'category' => $validated['category'],
            'urgency' => $validated['urgency'],
            'status' => 'menunggu_validasi',
            'sla_deadline' => Carbon::now()->addHours($slaHours),
            'sla_text' => "Sisa Waktu {$slaHours} Jam",
            'description' => $validated['description'],
            'latitude' => $validated['latitude'] ?? -6.489100,
            'longitude' => $validated['longitude'] ?? 106.841900,
            'gps_accuracy_m' => 12,
            'reporter_name' => $validated['reporter_name'],
            'reporter_nik' => $validated['reporter_nik'],
            'reporter_phone' => $validated['reporter_phone'],
            'reporter_address' => $validated['reporter_address'],
            'reporter_reputation' => 90,
            'photo_path' => $photoPath,
        ]);

        return redirect()->route('validation.index', ['ticket' => $report->ticket_number])
            ->with('status', "Laporan baru berhasil didaftarkan dengan nomor tiket #{$report->ticket_number}!")
            ->with('status_type', 'success');
    }
}
