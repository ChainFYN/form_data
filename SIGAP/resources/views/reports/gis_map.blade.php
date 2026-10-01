@extends('layouts.app')

@section('title', 'Peta GIS Interaktif Kerusakan Jalan - SIGAP')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 uppercase tracking-wide">
                <span>Geographic Information System (GIS) Jember</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">
                Peta Pemetaan Titik Kerusakan Jalan
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Pemantauan spasial sebaran lubang, longsor, dan drainase rusak di seluruh ruas jalan Kabupaten Jember.
            </p>
        </div>

        <!-- Legend -->
        <div class="flex flex-wrap items-center gap-3 bg-white p-2.5 rounded-xl border border-slate-200 shadow-2xs text-xs">
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                <span class="font-bold text-slate-700">Darurat</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                <span class="font-bold text-slate-700">Tinggi (&lt;24 Jam)</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                <span class="font-bold text-slate-700">Sedang</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                <span class="font-bold text-slate-700">Terverifikasi/PUPR</span>
            </div>
        </div>
    </div>

    <!-- MAP CONTAINER -->
    <div class="mt-4 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden relative">
        <div id="fullGisMap" class="w-full h-[650px] z-10"></div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Center on Jember: -6.485, 106.845
        const map = L.map('fullGisMap').setView([-6.485, 106.845], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors • SIGAP'
        }).addTo(map);

        const reports = {!! json_encode($reports) !!};

        reports.forEach(r => {
            if (!r.latitude || !r.longitude) return;

            let color = '#10b981'; // default emerald
            if (r.urgency === 'darurat') color = '#ef4444';
            else if (r.urgency === 'tinggi') color = '#f59e0b';
            else if (r.urgency === 'sedang') color = '#3b82f6';

            if (r.status === 'diteruskan_pupr') color = '#059669';
            if (r.status === 'ditolak') color = '#94a3b8';

            const marker = L.circleMarker([r.latitude, r.longitude], {
                radius: r.urgency === 'darurat' ? 10 : 8,
                fillColor: color,
                color: "#ffffff",
                weight: 2,
                opacity: 1,
                fillOpacity: 0.9
            }).addTo(map);

            const popupContent = `
                <div class="font-sans text-xs p-1" style="min-width: 200px;">
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-mono font-bold text-slate-900">${r.ticket_number}</span>
                        <span class="text-[9px] font-bold uppercase px-1.5 py-0.5 rounded text-white" style="background-color: ${color}">${r.urgency}</span>
                    </div>
                    <img src="${r.photo_path}" class="w-full h-24 object-cover rounded my-1">
                    <p class="font-bold text-slate-900 mt-1">${r.road_name}</p>
                    <p class="text-[11px] text-slate-500">${r.village}</p>
                    <p class="text-[10px] text-slate-600 line-clamp-2 mt-1">${r.description}</p>
                    <a href="/validasi?ticket=${r.ticket_number}" class="mt-2 block bg-slate-900 hover:bg-slate-800 text-white font-bold text-center py-1 rounded text-[11px]">
                        Buka Validasi &rarr;
                    </a>
                </div>
            `;

            marker.bindPopup(popupContent);
        });
    });
</script>
@endpush
