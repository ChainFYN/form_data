<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'all');
        $search = $request->query('search', '');
        $selectedTicketNumber = $request->query('ticket', 'LP-2026-0842');

        $query = Report::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('road_name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('reporter_name', 'like', "%{$search}%");
            });
        }

        // Apply Tab filters
        if ($tab === 'high') {
            $query->whereIn('urgency', ['darurat', 'tinggi']);
        } elseif ($tab === 'pending') {
            $query->where('status', 'menunggu_validasi');
        } elseif ($tab === 'resolved') {
            $query->whereIn('status', ['diteruskan_pupr', 'selesai', 'ditolak']);
        }

        $tickets = $query->orderByRaw("CASE 
                WHEN urgency = 'darurat' THEN 1 
                WHEN urgency = 'tinggi' THEN 2 
                WHEN urgency = 'sedang' THEN 3 
                ELSE 4 
            END")
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        // Active ticket for the right detail panel
        $activeTicket = Report::where('ticket_number', $selectedTicketNumber)->first();
        if (!$activeTicket && $tickets->isNotEmpty()) {
            $activeTicket = $tickets->first();
        }

        // Counts for tabs
        $allCount = Report::count();
        $highCount = Report::whereIn('urgency', ['darurat', 'tinggi'])->count();
        $pendingCount = Report::where('status', 'menunggu_validasi')->count();
        $resolvedCount = Report::whereIn('status', ['diteruskan_pupr', 'selesai'])->count();

        // Accuracy score and active queue
        $accuracyScore = 98.4;
        $activeQueueToday = Report::where('status', 'menunggu_validasi')->whereIn('urgency', ['darurat', 'tinggi'])->count();

        return view('validation.index', compact(
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
        $report = Report::findOrFail($id);

        $action = $request->input('action', 'acc'); // acc, reject, draft

        if ($action === 'acc') {
            $validated = $request->validate([
                'pupr_priority' => 'required|string',
                'technical_estimate' => 'required|string',
                'verifier_notes' => 'required|string|min:10',
            ]);

            $report->update([
                'status' => 'diteruskan_pupr',
                'decision' => 'acc',
                'pupr_priority' => $validated['pupr_priority'],
                'technical_estimate' => $validated['technical_estimate'],
                'verifier_notes' => $validated['verifier_notes'],
                'verified_by_name' => 'Hendra Wijaya, S.Sos',
                'verified_by_nip' => '19790623 200501 1 004',
                'verified_by_title' => 'Kasi Ekbang Kec. jember',
                'verified_at' => Carbon::now(),
            ]);

            $msg = "Disposisi Tiket #{$report->ticket_number} BERHASIL DI-ACC & Diteruskan ke UPT Dinas PUPR Wilayah jember!";
            $type = 'success';
        } elseif ($action === 'reject') {
            $report->update([
                'status' => 'ditolak',
                'decision' => 'reject',
                'verifier_notes' => $request->input('verifier_notes', 'Aduan ditolak karena tidak memenuhi ketentuan jalan kabupaten / duplikasi.'),
                'verified_by_name' => 'Hendra Wijaya, S.Sos',
                'verified_by_nip' => '19790623 200501 1 004',
                'verified_by_title' => 'Kasi Ekbang Kec. jember',
                'verified_at' => Carbon::now(),
            ]);

            $msg = "Tiket #{$report->ticket_number} telah Ditolak & status dikembalikan ke pelapor.";
            $type = 'warning';
        } else {
            // Save Draft
            $report->update([
                'status' => 'draf',
                'decision' => 'draf',
                'pupr_priority' => $request->input('pupr_priority'),
                'technical_estimate' => $request->input('technical_estimate'),
                'verifier_notes' => $request->input('verifier_notes'),
            ]);

            $msg = "Draf pemeriksaan tiket #{$report->ticket_number} berhasil disimpan!";
            $type = 'info';
        }

        return redirect()->route('validation.index', ['ticket' => $report->ticket_number])
            ->with('status', $msg)
            ->with('status_type', $type);
    }
}
