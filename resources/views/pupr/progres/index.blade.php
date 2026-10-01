@extends('pupr.layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative">
    
    <!-- HEADER -->
    <div class="mb-6">
        <span class="inline-block bg-orange-100 text-orange-700 text-xs font-semibold px-2 py-1 rounded mb-2">SEDANG DIKERJAKAN PUPR</span>
        <h2 class="text-2xl font-bold text-slate-900 p-1">Detail Penanganan Lapangan: Jl. Raya Mayor Oking No. 42</h2>
        <p class="text-sm text-slate-500 mt-1 flex items-center">📍 Cibinong, Kab. Bogor | 🕒 Update Terakhir: 25 Sep 2026, 14:00 WIB</p>
    </div>

    <!-- FORM UTAMA -->
    <form id="formProgres" action="#" method="POST">
        @csrf

        <!-- GRID LAYOUT UTAMA (2 Kolom Kiri, 1 Kolom Kanan) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- ================= KOLOM KIRI (Form Log & Tahapan) ================= -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-4 mb-6">
                        <h3 class="font-bold text-lg text-slate-800">Form Update Log Progres Lapangan</h3>
                        <span class="bg-slate-100 text-slate-600 text-xs px-2 py-1 rounded font-medium">Kode: HWPT-09-24</span>
                    </div>
                    
                    <!-- GRID 2 KOLOM: Tahapan & Persentase -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        
                        <!-- Checkbox Berurutan -->
                        <div class="flex flex-col">
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Status Tahapan Pekerjaan</label>
                            
                            <div class="space-y-3 bg-slate-50 p-5 rounded-xl border border-slate-200 flex-1">
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="checkbox" class="tahapan-checkbox form-checkbox h-5 w-5 text-teal-600 rounded border-slate-300 focus:ring-teal-500 transition-all cursor-pointer bg-white" 
                                           data-index="1" data-persen="25" onchange="aturUrutan(1)">
                                    <span class="text-sm font-medium text-slate-700 group-hover:text-teal-700 transition-colors">Pengecekan Lokasi</span>
                                </label>
                                
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="checkbox" class="tahapan-checkbox form-checkbox h-5 w-5 text-teal-600 rounded border-slate-300 focus:ring-teal-500 transition-all cursor-pointer bg-white" 
                                           data-index="2" data-persen="50" onchange="aturUrutan(2)">
                                    <span class="text-sm font-medium text-slate-700 group-hover:text-teal-700 transition-colors">Persiapan Material & Alat</span>
                                </label>
                                
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="checkbox" class="tahapan-checkbox form-checkbox h-5 w-5 text-teal-600 rounded border-slate-300 focus:ring-teal-500 transition-all cursor-pointer bg-white" 
                                           data-index="3" data-persen="75" onchange="aturUrutan(3)">
                                    <span class="text-sm font-medium text-slate-700 group-hover:text-teal-700 transition-colors">Pengerjaan Fisik / Eksekusi</span>
                                </label>
                                
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="checkbox" class="tahapan-checkbox form-checkbox h-5 w-5 text-teal-600 rounded border-slate-300 focus:ring-teal-500 transition-all cursor-pointer bg-white" 
                                           data-index="4" data-persen="100" onchange="aturUrutan(4)">
                                    <span class="text-sm font-medium text-slate-700 group-hover:text-teal-700 transition-colors">Selesai & Publikasi Progres</span>
                                </label>
                            </div>

                            <input type="hidden" name="status_pekerjaan_id" id="input_status" value="0">
                            <input type="hidden" name="persentase_capaian" id="input_persentase" value="0">
                        </div>

                        <!-- Kotak Persentase -->
                        <div class="flex flex-col">
                            <label class="block text-xs font-bold text-transparent mb-2 uppercase tracking-wide select-none">Spacer</label>
                            
                            <div class="bg-orange-50/80 border border-orange-100 rounded-xl p-6 flex flex-col items-center justify-center text-center flex-1">
                                <p class="text-sm font-bold text-orange-800 mb-3 uppercase tracking-wider">Persentase Capaian</p>
                                <p id="teks_persentase" class="text-6xl font-black text-orange-600 transition-all duration-300 drop-shadow-sm">0%</p>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Teknis (Placeholder / Shadow Text) -->
                    <div class="mb-2">
                        <label for="catatan" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Catatan Teknis Lapangan</label>
                        <textarea id="catatan" name="catatan" 
                                  class="w-full border border-slate-300 rounded-xl p-4 text-sm h-28 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-all placeholder-slate-400" 
                                  placeholder="Ketik detail pengerjaan, kendala cuaca, atau informasi material yang digunakan di sini..."></textarea>
                    </div>
                </div>
            </div>

            <!-- ================= KOLOM KANAN (Spesifikasi & Visual Menjadi Form Input) ================= -->
            <div class="space-y-6">
                
<!-- Card: Spesifikasi Teknis (FR-04) Berbentuk Form Input -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                    <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-3">
                        <h3 class="font-bold text-lg text-slate-800">Spesifikasi Teknis (FR-04)</h3>
                        <span class="bg-slate-100 text-slate-600 text-[10px] font-extrabold px-2 py-1 rounded">REV-02</span>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Metode Penanganan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Metode Penanganan</label>
                            <select id="metode_penanganan" class="w-full border border-slate-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none bg-white">
                                <option value="Deep Patching & Hotmix Overlay" selected>Deep Patching & Hotmix Overlay</option>
                                <option value="Full Depth Reclamation">Full Depth Reclamation</option>
                                <option value="Patching Manual">Patching Manual</option>
                            </select>
                        </div>

                        <!-- Volume Kerusakan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Volume Kerusakan & Dimensi</label>
                            <input type="text" id="volume_kerusakan" value="2.7 M³ (6m x 3m x 0.15m)" 
                                   class="w-full border border-slate-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">
                        </div>

                        <!-- Material & Agregat Digunakan -->
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">MATERIAL & AGREGAT DIGUNAKAN:</label>
                            
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs text-slate-600 font-medium">Aspal Hotmix Laston AC-WC</span>
                                <div class="flex items-center gap-1 w-32">
                                    <input type="number" step="0.1" id="material_asphalt" value="3,2" class="w-full border border-slate-300 rounded p-1.5 text-xs text-right focus:outline-none focus:border-teal-500 bg-white">
                                    <span class="text-xs text-slate-500 font-bold">Ton</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs text-slate-600 font-medium">Emulsi Tack Coat CRS-1</span>
                                <div class="flex items-center gap-1 w-32">
                                    <input type="number" id="material_emulsi" value="40" class="w-full border border-slate-300 rounded p-1.5 text-xs text-right focus:outline-none focus:border-teal-500 bg-white">
                                    <span class="text-xs text-slate-500 font-bold">Liter</span>
                                    </div>
                            </div>

                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs text-slate-600 font-medium">Lapis Pondasi Agregat Kelas A</span>
                                <div class="flex items-center gap-1 w-32">
                                    <input type="number" step="0.1" id="material_agregat" value="3,0" class="w-full border border-slate-300 rounded p-1.5 text-xs text-right focus:outline-none focus:border-teal-500 bg-white">
                                    <span class="text-xs text-slate-500 font-bold">M³</span>
                                </div>
                            </div>
                        </div>

                        <!-- Estimasi Anggaran & Target Selesai -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Estimasi Anggaran (Rp)</label>
                                <input type="text" id="estimasi_anggaran" placeholder="Contoh: 8.450.000" class="w-full border border-slate-300 rounded-lg p-2.5 text-xs font-bold text-slate-900 focus:outline-none focus:border-teal-500 placeholder:font-normal placeholder:text-slate-400">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Target Selesai</label>
                                <input type="date" id="target_selesai" value="2026-09-26" class="w-full border border-slate-300 rounded-lg p-2 text-xs font-bold text-slate-900 focus:outline-none focus:border-teal-500 bg-white">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card: Komparasi Visual Pengerjaan -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-lg text-slate-800 mb-4">Komparasi Visual Pengerjaan</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-slate-100 h-24 rounded-lg flex items-center justify-center text-xs text-slate-400 font-medium border border-slate-200">[Foto Awal]</div>
                        <div class="bg-slate-100 h-24 rounded-lg flex items-center justify-center text-xs text-slate-400 font-medium border border-slate-200">[Foto Progres]</div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Tombol Submit & Toggle Pop-up Bawah (Full Lebar Form) -->
        <div class="mt-6 bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <label class="flex items-center text-sm text-slate-600 cursor-pointer group">
                <input type="checkbox" class="mr-2 rounded text-teal-600 border-slate-300 focus:ring-teal-500 h-4 w-4"> 
                <span class="group-hover:text-slate-900 transition-colors font-medium">Notifikasi via WhatsApp API ke pelapor & kantor camat</span>
            </label>
            <button type="button" onclick="openModal()" class="w-full sm:w-auto bg-orange-500 text-white px-8 py-3 rounded-xl shadow-sm font-bold text-sm hover:bg-orange-600 transition-colors">
                Simpan & Publikasikan Progres
            </button>
        </div>
    </form>

    <!-- Include File Pop-Up (Show) -->
    @include('pupr.progres.show')

</main>

<!-- SCRIPT LOGIKA CHECKBOX BERURUTAN -->
<script>
    function aturUrutan(clickedIndex) {
        const checkboxes = document.querySelectorAll('.tahapan-checkbox');
        const clickedCheckbox = document.querySelector(`.tahapan-checkbox[data-index="${clickedIndex}"]`);
        const isChecking = clickedCheckbox.checked;

        let targetIndex = isChecking ? clickedIndex : clickedIndex - 1;
        
        let currentPersen = 0;
        let currentStatus = 0;

        checkboxes.forEach((cb) => {
            const index = parseInt(cb.getAttribute('data-index'));
            const persen = parseInt(cb.getAttribute('data-persen'));

            if (index <= targetIndex) {
                cb.checked = true;
                currentPersen = persen;
                currentStatus = index; 
            } else {
                cb.checked = false;
            }
        });

        document.getElementById('teks_persentase').innerText = currentPersen + '%';
        document.getElementById('input_status').value = currentStatus;
        document.getElementById('input_persentase').value = currentPersen;
    }
</script>

<!-- SCRIPT UNTUK TOGGLE POP-UP DAN KIRIM DATA -->
<script>
    function openModal() {
        // 1. Ambil data dari form log & tahapan
        const persentase = document.getElementById('input_persentase').value;
        const catatan = document.getElementById('catatan').value;

        // 2. Ambil data dari form spesifikasi teknis menggunakan ID yang baru ditambahkan
        const metode = document.getElementById('metode_penanganan').value;
        const volume = document.getElementById('volume_kerusakan').value;
        const asphalt = document.getElementById('material_asphalt').value;
        const emulsi = document.getElementById('material_emulsi').value;
        const agregat = document.getElementById('material_agregat').value;
        const anggaran = document.getElementById('estimasi_anggaran').value;
        const target = document.getElementById('target_selesai').value;

        // 3. Masukkan nilai ke dalam elemen Pop-up (modal show.blade.php)
        document.getElementById('modal_persentase').innerText = persentase + '%';
        document.getElementById('modal_catatan').innerText = catatan ? catatan : '- Tidak ada catatan -';
        
        document.getElementById('modal_metode').innerText = metode;
        document.getElementById('modal_volume').innerText = volume;
        document.getElementById('modal_asphalt').innerText = asphalt ? asphalt : '0';
        document.getElementById('modal_emulsi').innerText = emulsi ? emulsi : '0';
        document.getElementById('modal_agregat').innerText = agregat ? agregat : '0';
        document.getElementById('modal_anggaran').innerText = anggaran ? 'Rp ' + anggaran : 'Rp 0';
        document.getElementById('modal_target').innerText = target ? target : '-';

        // 4. Tampilkan modal
        document.getElementById('modalShow').classList.remove('hidden');
    }
    
    function closeModal() {
        document.getElementById('modalShow').classList.add('hidden');
    }
</script>
@endsection