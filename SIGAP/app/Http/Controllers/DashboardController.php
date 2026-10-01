<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Village;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // KPI Counters
        $perluTindakanCount = 14;
        $menungguValidasiCount = Report::where('status', 'menunggu_validasi')->count();
        $terverifikasiCount = Report::where('status', 'diteruskan_pupr')->count();
        $ditolakCount = Report::where('status', 'ditolak')->count();

        // Priority validation queue (Menunggu validasi, sorted by urgency)
        $priorityReports = Report::whereIn('status', ['menunggu_validasi', 'draf'])
            ->orderByRaw("CASE 
                WHEN urgency = 'darurat' THEN 1 
                WHEN urgency = 'tinggi' THEN 2 
                WHEN urgency = 'sedang' THEN 3 
                ELSE 4 
            END")
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // SLA Warning items (Urgent cases under 24 hours)
        $slaAlerts = Report::whereIn('urgency', ['darurat', 'tinggi'])
            ->where('status', 'menunggu_validasi')
            ->take(3)
            ->get();

        // Sebaran Wilayah Pekan Ini
        $villages = Village::orderBy('active_reports_count', 'desc')->take(4)->get();
        $totalResolvedRuas = 27;

        return view('dashboard', compact(
            'perluTindakanCount',
            'menungguValidasiCount',
            'terverifikasiCount',
            'ditolakCount',
            'priorityReports',
            'slaAlerts',
            'villages',
            'totalResolvedRuas'
        ));
    }
}
