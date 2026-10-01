<!-- Background Overlay -->
<div id="modalShow" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center transition-all p-4 overflow-y-auto">
    
    <!-- Kotak Pop-up (Dilebarkan sedikit menjadi max-w-2xl agar muat menampung semua data) -->
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden relative border border-slate-200 my-8">
        
        <!-- Header Pop-up -->
        <div class="bg-slate-900 px-6 py-4 flex justify-between items-center">
            <h3 class="text-white font-bold text-lg">Konfirmasi Keseluruhan Hasil Inputan Progres</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-white transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Isi/Output Pop-up (Dibuat scrollable jika isinya panjang) -->
        <div class="p-6 max-h-[70vh] overflow-y-auto space-y-4">
            <div class="text-center mb-4">
                <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-2">
                    <i class="fa-solid fa-file-contract text-2xl text-teal-600"></i>
                </div>
                <p class="font-bold text-slate-800 text-base">Ringkasan Data Lapangan</p>
                <p class="text-xs text-slate-500">Periksa seluruh detail parameter teknis sebelum dipublikasikan.</p>
            </div>

            <!-- 1. Bagian Status & Capaian -->
            <div class="bg-slate-50 p-4 rounded-xl text-xs space-y-2 border border-slate-200">
                <p class="font-bold text-slate-700 uppercase tracking-wide border-b border-slate-200 pb-1 mb-2">A. Capaian & Catatan</p>
                <div class="flex justify-between">
                    <span class="text-slate-500 font-medium">Jalan:</span>
                    <span class="font-bold text-slate-900">Jl. Raya Mayor Oking No. 42</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 font-medium">Persentase Capaian:</span>
                    <span id="modal_persentase" class="font-black text-orange-600 text-sm">0%</span>
                </div>
                <div>
                    <span class="text-slate-500 font-medium block mb-1">Catatan Teknis:</span>
                    <p id="modal_catatan" class="text-slate-700 italic bg-white p-2.5 rounded border border-slate-200">-</p>
                </div>
            </div>

            <!-- 2. Bagian Spesifikasi Teknis (FR-04) -->
            <div class="bg-slate-50 p-4 rounded-xl text-xs space-y-2 border border-slate-200">
                <p class="font-bold text-slate-700 uppercase tracking-wide border-b border-slate-200 pb-1 mb-2">B. Spesifikasi Teknis (FR-04)</p>
                
                <div class="flex justify-between">
                    <span class="text-slate-500 font-medium">Metode Penanganan:</span>
                    <span id="modal_metode" class="font-bold text-slate-900 text-right">-</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-slate-500 font-medium">Volume Kerusakan & Dimensi:</span>
                    <span id="modal_volume" class="font-bold text-slate-900 text-right">-</span>
                </div>

                <!-- Rincian Material -->
                <div class="pt-2">
                    <span class="text-slate-500 font-medium block mb-1">Material & Agregat:</span>
                    <ul class="bg-white p-2.5 rounded border border-slate-200 space-y-1">
                        <li class="flex justify-between">
                            <span class="text-slate-600">Aspal Hotmix Laston AC-WC:</span>
                            <span class="font-bold text-slate-800"><span id="modal_asphalt">0</span> Ton</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-slate-600">Emulsi Tack Coat CRS-1:</span>
                            <span class="font-bold text-slate-800"><span id="modal_emulsi">0</span> Liter</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-slate-600">Lapis Pondasi Agregat Kelas A:</span>
                            <span class="font-bold text-slate-800"><span id="modal_agregat">0</span> M³</span>
                        </li>
                    </ul>
                </div>

                <!-- Anggaran & Target -->
                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-200 mt-2">
                    <div>
                        <span class="text-slate-500 block">Estimasi Anggaran:</span>
                        <span id="modal_anggaran" class="font-bold text-slate-900 text-sm">Rp 0</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block">Target Selesai:</span>
                        <span id="modal_target" class="font-bold text-orange-600 text-sm">-</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer Pop-up -->
        <div class="bg-slate-50 px-6 py-4 flex justify-end space-x-3 border-t border-slate-200">
            <button onclick="closeModal()" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Periksa Kembali</button>
            <button class="px-5 py-2 bg-teal-600 text-white rounded-lg text-xs font-bold hover:bg-teal-700 transition-colors shadow-sm" onclick="document.getElementById('formProgres').submit();">
                Ya, Publikasikan Sekarang
            </button>
        </div>
        
    </div>
</div>