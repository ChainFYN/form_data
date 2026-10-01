# PANDUAN PENGGUNAAN APLIKASI SIGAP (SIGAP Kab. Jember)

**SIGAP** (*Sistem Informasi Tanggap Aduan & Gangguan Prasarana Jalan*) adalah aplikasi portal web berbasis **Laravel** yang dibuat khusus berdasarkan rancangan Figma **"Dashboard Admin Kecamatan - SIGAP Desktop"** dan **"Pemeriksaan & Disposisi Aduan Warga"** untuk Pemerintah Kabupaten Jember (Seksi Ekbang Kecamatan Jember & Dinas PUPR).

---

## 🚀 Cara Cepat Menjalankan Aplikasi

Aplikasi ini sudah **100% siap pakai**, database SQLite sudah otomatis terisi data awal (seeder), dan dependensi `vendor/` sudah lengkap.

### 1. Buka Terminal / CMD / PowerShell
Masuk ke direktori proyek `SIGAP`:
```bash
cd SIGAP
```

### 2. Jalankan Server Laravel
Cukup jalankan perintah:
```bash
php artisan serve
```

### 3. Buka di Browser
Akses URL berikut:
👉 **http://127.0.0.1:8000** atau **http://localhost:8000**

---

## 📂 Halaman & Fitur Utama Sesuai Figma

1. **Dashboard Kecamatan (`/dashboard`)** *(Figma Image 1)*
   - **4 KPI Metric Cards**:
     - *Laporan Masuk Hari Ini*: 14 Laporan (Perlu Tindakan)
     - *Menunggu Validasi*: 6 Laporan (Pending)
     - *Terverifikasi & Diteruskan*: 42 Aduan Selesai (Ke PUPR)
     - *Ditolak / Divalidasi Tidak Valid*: 5 Laporan (Reject)
   - **Banner Tindakan Prioritas Wilayah Jember**:
     - Tombol cepat verifikasi, peta GIS, ekspor BAP, dan cetak rekap.
   - **Daftar Antrean Validasi Prioritas Tertinggi**:
     - Laporan darurat dengan foto lapangan, sisa waktu SLA, detail pelapor, koordinat GPS, dan tombol tindakan langsung.
   - **Alur Siklus Validasi Kecamatan ke UPT Dinas PUPR**:
     - Stepper 4 tahap dari Laporan Warga &rarr; Validasi Ekbang &rarr; Disposisi UPT &rarr; Eksekusi Fisik.
   - **Widget Sidebar Kanan**:
     - *Peringatan Batas SLA (24 Jam)* dengan countdown peringatan.
     - *Sebaran Wilayah Pekan Ini* (Desa Sukamaju, Kelurahan Cirimekar, Kelurahan Tengah, Pakansari).
     - *Hotline Lapangan Dinas PUPR* (Kontak Kepala UPT Ir. Hendra Gunawan, S.T. & Tombol WhatsApp Siaga).
     - *Kamera Pantauan Titik Rawan* (Live CCTV Simpang jember).

2. **Validasi Laporan / Disposisi Aduan Warga (`/validasi`)** *(Figma Image 2)*
   - **Kolom Kiri**:
     - Pencarian live tiket aduan.
     - Filter tab: *Semua Antrean*, *Kategori Tinggi*, *Perlu Verifikasi*, *Selesai*.
     - Daftar antrean tiket dengan penanda aktif.
     - Banner Kebijakan Respon Cepat Kecamatan (&lt; 2 jam).
   - **Kolom Kanan (Inspeksi & Disposisi)**:
     - Header detail tiket `#LP-2026-0842` / tiket terpilih.
     - *Pemeriksaan Bukti Lapangan*: Komparasi foto bukti lapangan dengan **Peta Interaktif GIS (Leaflet)** + radius akurasi GPS 12m.
     - *Identitas Pelapor Warga*: Terverifikasi NIK, reputasi 94/100, alamat domisili, nomor telepon.
     - *Deskripsi Laporan Warga*.
     - *Keputusan Verifikator Kecamatan*:
       - Pilihan Disposisi interaktif (**ACC - Diteruskan ke PUPR** vs **REJECT - Tolak Aduan**).
       - Dropdown Prioritas Penanganan PUPR (Prioritas 1 s/d 4).
       - Dropdown Estimasi Tindakan Teknis (Patching Hotmix, Rekonstruksi, Drainase, dll).
       - Catatan Disposisi Resmi Verifikator dengan penghitung karakter otomatis.
       - Tanda tangan digital resmi Kasi Ekbang Hendra Wijaya, S.Sos.
       - Tombol aksi: Simpan Draf, Tolak Aduan, Kirim Disposisi ACC ke Dinas PUPR.

3. **Rekapitulasi Progres (`/rekapitulasi`)**
   - Tabel seluruh aduan warga dengan filter status, urgensi, wilayah desa, dan fitur cetak rekap.

4. **Statistik Wilayah (`/statistik`)**
   - Grafik batang Chart.js sebaran aduan per desa/kelurahan dan diagram donat tingkat urgensi.

5. **Data Master Desa (`/master-desa`)**
   - Data kelurahan/desa se-Kecamatan Jember, panjang ruas jalan (km), kontak posko, dan jumlah aduan.

6. **Peta GIS Sepenuhnya (`/peta-gis`)**
   - Peta interaktif Leaflet full screen dengan marker titik jalan rusak berwana sesuai tingkat keparahan.

7. **Cetak Berita Acara Pemeriksaan BAP Resmi (`/cetak-bap/{id}`)**
   - Format cetak formal BAP berkop surat resmi Pemerintah Kabupaten Jember lengkap dengan QR-code otentikasi.

8. **Form Input Laporan Warga Baru (`/lapor-baru`)**
   - Fitur pelaporan mandiri dilengkapi deteksi otomatis koordinat GPS perangkat.

---

## 🧪 Pengujian Bebas Error (Testing)
Seluruh kode telah diuji secara otomatis dan lulus 100%:
```bash
php artisan test
```
Hasil: `Tests: 11 passed, Assertions: 34 passed, 0 errors, 0 failures`.

---

## 👤 Akun Default
- **Nama**: Drs. Bambang Suherman
- **Jabatan**: Admin Ekbang Kec. Jember
- **Email**: admin@jember.jemberkab.go.id
- **Password**: password
