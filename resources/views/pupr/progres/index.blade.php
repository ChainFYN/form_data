@extends('pupr.layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative">
    
    <!-- HEADER -->
    <div class="mb-6">
        <span class="inline-block bg-orange-100 text-orange-700 text-xs font-semibold px-2 py-1 rounded mb-2">SEDANG DIKERJAKAN PUPR</span>
        <h2 class="text-2xl font-bold text-slate-900 p-1">Detail Penanganan Lapangan: Jl. {{ $laporan->jalan->nama_jalan ?? '-' }}</h2>
        <p class="text-sm text-slate-500 mt-1 flex items-center">📍 Kec. {{ $laporan->jalan->desa->kecamatan->nama_kecamatan ?? '-' }}, Kab. Jember | 🕒 Update Terakhir: {{ $laporan->updated_at->format('d M Y, H:i') }} WIB</p>
    </div>

    <!-- FORM UTAMA -->
    <form id="formProgres" action="{{ route('pupr.progres.update', $laporan->id_laporan) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- GRID LAYOUT UTAMA (2 Kolom Kiri, 1 Kolom Kanan) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- ================= KOLOM KIRI (Form Log & Tahapan) ================= -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-4 mb-6">
                        <h3 class="font-bold text-lg text-slate-800">Form Update Log Progres Lapangan</h3>
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
                
<!-- Card: Spesifikasi Teknis Berbentuk Form Input -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                    <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-3">
                        <h3 class="font-bold text-lg text-slate-800">Spesifikasi Teknis</h3>
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
                                    <input type="number" min="0" step="0.1" id="material_asphalt" value="3.2" oninput="checkNegativeMaterial(this)" class="w-full border border-slate-300 rounded p-1.5 text-xs text-right focus:outline-none focus:border-teal-500 bg-white">
                                    <span class="text-xs text-slate-500 font-bold">Ton</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs text-slate-600 font-medium">Emulsi Tack Coat CRS-1</span>
                                <div class="flex items-center gap-1 w-32">
                                    <input type="number" min="0" id="material_emulsi" value="40" oninput="checkNegativeMaterial(this)" class="w-full border border-slate-300 rounded p-1.5 text-xs text-right focus:outline-none focus:border-teal-500 bg-white">
                                    <span class="text-xs text-slate-500 font-bold">Liter</span>
                                    </div>
                            </div>

                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs text-slate-600 font-medium">Lapis Pondasi Agregat Kelas A</span>
                                <div class="flex items-center gap-1 w-32">
                                    <input type="number" min="0" step="0.1" id="material_agregat" value="3.0" oninput="checkNegativeMaterial(this)" class="w-full border border-slate-300 rounded p-1.5 text-xs text-right focus:outline-none focus:border-teal-500 bg-white">
                                    <span class="text-xs text-slate-500 font-bold">M³</span>
                                </div>
                            </div>
                            <p id="error_material" class="text-red-500 text-[10px] mt-1 hidden"><i class="fa-solid fa-triangle-exclamation"></i> Exception: Material tidak boleh bernilai negatif!</p>
                        </div>

                        <!-- Estimasi Anggaran & Target Selesai -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Estimasi Anggaran (Rp)</label>
                                <input type="text" id="estimasi_anggaran" placeholder="Contoh: 8.450.000" oninput="formatAnggaran(this)" class="w-full border border-slate-300 rounded-lg p-2.5 text-xs font-bold text-slate-900 focus:outline-none focus:border-teal-500 placeholder:font-normal placeholder:text-slate-400">
                                <p id="error_anggaran" class="text-red-500 text-[10px] mt-1 hidden"><i class="fa-solid fa-triangle-exclamation"></i> Exception: Angka tidak boleh negatif!</p>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Target Selesai</label>
                                <input type="date" id="target_selesai" min="{{ date('Y-m-d', strtotime('+1 day')) }}" onchange="validateDate(this)" class="w-full border border-slate-300 rounded-lg p-2 text-xs font-bold text-slate-900 focus:outline-none focus:border-teal-500 bg-white">
                                <p id="error_target" class="text-red-500 text-[10px] mt-1 hidden"><i class="fa-solid fa-triangle-exclamation"></i> Exception: Tidak boleh memilih hari ini atau tanggal berlalu!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card: Komparasi Visual Pengerjaan -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-lg text-slate-800 mb-4">Komparasi Visual Pengerjaan</h3>
                    <div class="grid grid-cols-2 gap-4">
                        
                        <!-- Kiri: Input Foto Progres -->
                        <div class="flex flex-col">
                            <label class="block text-xs font-bold text-slate-700 mb-2">Upload Foto Progres</label>
                            <label class="flex-1 border-2 border-dashed border-slate-300 bg-slate-50 hover:bg-slate-100 transition-colors rounded-xl flex flex-col items-center justify-center cursor-pointer p-4 group relative overflow-hidden h-32" id="upload-container">
                                <div id="upload-placeholder" class="text-center">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-teal-500 mb-2 group-hover:scale-110 transition-transform"></i>
                                    <p class="text-[10px] font-bold text-slate-700">Pilih atau Tarik Foto</p>
                                    <p class="text-[9px] text-slate-400 mt-1">PNG/JPG Max 5MB</p>
                                </div>
                                <img id="upload-preview" src="#" alt="Preview" class="hidden absolute inset-0 w-full h-full object-cover z-10" />
                                <input type="file" name="foto_progres" accept="image/png, image/jpeg" class="hidden" onchange="previewImage(this)">
                            </label>
                        </div>

                        <!-- Kanan: Foto Awal -->
                        <div class="flex flex-col">
                            <label class="block text-xs font-bold text-slate-700 mb-2">Foto Awal Lapangan</label>
                            <div class="flex-1 bg-slate-100 rounded-xl flex items-center justify-center text-xs text-slate-400 font-medium border border-slate-200 overflow-hidden relative h-32">
                                @if($laporan->url_foto)
                                    <img src="{{ asset('storage/' . $laporan->url_foto) }}" alt="Foto Awal" class="absolute inset-0 w-full h-full object-cover">
                                @else
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fa-solid fa-image text-3xl mb-1 opacity-50"></i>
                                        <span>Tidak ada foto</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                <!-- SCRIPT PREVIEW GAMBAR -->
                <script>
                    function previewImage(input) {
                        if (input.files && input.files[0]) {
                            // Check file size (5MB = 5 * 1024 * 1024 bytes)
                            if(input.files[0].size > 5242880) {
                                alert("Ukuran file terlalu besar. Maksimal 5MB.");
                                input.value = "";
                                return;
                            }
                            
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById('upload-preview').src = e.target.result;
                                document.getElementById('upload-preview').classList.remove('hidden');
                                document.getElementById('upload-placeholder').classList.add('hidden');
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                </script>

            </div>
        </div>

        <!-- Tombol Submit & Toggle Pop-up Bawah (Full Lebar Form) -->
        <div class="mt-6 bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex justify-end">
            <button type="button" id="btnSubmitForm" onclick="openModal()" class="w-full sm:w-auto bg-orange-500 text-white px-8 py-3 rounded-xl shadow-sm font-bold text-sm hover:bg-orange-600 transition-colors">
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
        
        // Ubah Teks Tombol
        if(currentPersen === 100) {
            document.getElementById('btnSubmitForm').innerText = 'Selesaikan & Buat BAST';
            if(document.getElementById('btnSubmitModal')) {
                document.getElementById('btnSubmitModal').innerText = 'Selesaikan & Buat BAST';
            }
        } else {
            document.getElementById('btnSubmitForm').innerText = 'Simpan & Publikasikan Progres';
            if(document.getElementById('btnSubmitModal')) {
                document.getElementById('btnSubmitModal').innerText = 'Ya, Publikasikan Sekarang';
            }
        }
    }
</script>

<!-- SCRIPT UNTUK FORMAT ANGGARAN & EXCEPTION NEGATIF -->
<script>
    function formatAnggaran(input) {
        // Cek jika ada tanda negatif
        if (input.value.includes('-')) {
            document.getElementById('error_anggaran').classList.remove('hidden');
            // Hapus tanda negatif langsung
            input.value = input.value.replace(/-/g, '');
            
            // Sembunyikan notif setelah 3 detik
            setTimeout(() => {
                document.getElementById('error_anggaran').classList.add('hidden');
            }, 3000);
        } else {
            document.getElementById('error_anggaran').classList.add('hidden');
        }
        
        // Hapus semua karakter selain angka
        let val = input.value.replace(/[^0-9]/g, '');
        
        // Format dengan titik (Ribuan)
        if (val !== '') {
            input.value = new Intl.NumberFormat('id-ID').format(val);
        } else {
            input.value = '';
        }
    }

    function validateDate(input) {
        if(!input.value) return;

        let selectedDate = new Date(input.value);
        let minDate = new Date("{{ date('Y-m-d', strtotime('+1 day')) }}");
        
        selectedDate.setHours(0,0,0,0);
        minDate.setHours(0,0,0,0);

        if (selectedDate < minDate) {
            document.getElementById('error_target').classList.remove('hidden');
            input.value = ""; // Reset value
            setTimeout(() => {
                document.getElementById('error_target').classList.add('hidden');
            }, 3000);
        } else {
            document.getElementById('error_target').classList.add('hidden');
        }
    }

    function checkNegativeMaterial(input) {
        if (input.value.includes('-') || input.value < 0) {
            document.getElementById('error_material').classList.remove('hidden');
            
            // Hapus tanda negatif
            input.value = Math.abs(input.value);
            if(input.value == 0 || input.value === "") {
                input.value = "";
            }
            
            // Sembunyikan notif setelah 3 detik
            setTimeout(() => {
                document.getElementById('error_material').classList.add('hidden');
            }, 3000);
        } else {
            document.getElementById('error_material').classList.add('hidden');
        }
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