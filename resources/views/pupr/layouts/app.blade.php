<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin PUPR') - SIGAP Kab. Bogor</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            900: '#0c4a6e',
                        },
                        navy: {
                            800: '#0f172a',
                            900: '#080f20',
                        }
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="h-full flex flex-col text-slate-800 antialiased">

    <!-- TOP NAVBAR -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Left: Logo & Nav -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('pupr.dashboard') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white">
                            <i class="fa-solid fa-hard-hat text-lg text-amber-400"></i>
                        </div>
                        <div>
                            <div class="font-extrabold text-xl tracking-tight text-slate-900 leading-none">SIGAP</div>
                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mt-1">PUPR</div>
                        </div>
                    </a>

                    <nav class="hidden md:flex items-center gap-2">
                        <a href="{{ route('pupr.dashboard') }}" class="px-4 py-2.5 text-xs font-bold rounded-xl transition-all {{ request()->routeIs('pupr.dashboard') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                            Dashboard Operasional
                        </a>



                    </nav>
                </div>

                <!-- Right: User Profile -->
                <div class="flex items-center gap-5">
                    <div class="relative">
                        <button class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200">
                            <i class="fa-regular fa-bell text-lg"></i>
                        </button>
                        <span class="absolute top-0 right-0 w-3.5 h-3.5 bg-amber-500 border-2 border-white rounded-full"></span>
                    </div>

                    <div class="flex items-center gap-3 pl-5 border-l border-slate-200">
                        <div class="text-right hidden sm:block">
                            <div class="text-xs font-extrabold text-slate-900">{{ session('pupr_name', 'Ir. Hendra Gunawan, S.T.') }}</div>
                            <div class="text-[10px] text-slate-500 font-medium">Koordinator UPT<br>Pemeliharaan Jalan Wilayah 1</div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 shrink-0">
                            <i class="fa-regular fa-user"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-1 bg-slate-50">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-100 border-t border-slate-200 mt-12 py-10">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 text-xs text-slate-500">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h4 class="font-extrabold text-slate-900 text-sm mb-2">Dinas PUPR Kabupaten Bogor</h4>
                    <p class="mb-4 text-slate-600 leading-relaxed">Pemerintah Kabupaten Bogor — Bidang Bina Marga dan Pemeliharaan Jalan & Jembatan. Akselerasi pemeliharaan, verifikasi lapangan, dan monitoring pemulihan infrastruktur jalan wilayah Tegar Beriman.</p>
                    <p class="text-[10px] italic">Alamat: Jl. Tegar Beriman No. 1, Kelurahan Pakansari, Kecamatan Cibinong, Kabupaten Bogor, Jawa Barat 16914</p>
                </div>
                <div>
                    <h5 class="font-extrabold text-slate-900 mb-2">Standar Operasional (SLA)</h5>
                    <ul class="space-y-1.5 text-slate-600">
                        <li>• Triage & Validasi: Maks. 24 Jam</li>
                        <li>• Rekomendasi Teknis: 1x 48 Jam Kerja</li>
                        <li>• Penanganan Darurat: <span class="text-amber-600 font-bold">< 6 Jam</span></li>
                        <li>• Rekonstruksi Permanen: Sesuai DPA/APBD</li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-extrabold text-slate-900 mb-2">Kontak Siaga Lapangan</h5>
                    <ul class="space-y-1.5 text-slate-600">
                        <li>Call Center PUPR: (021) 8790-1234</li>
                        <li>Radio Trunking UPT 1: CH-08 (Cibinong-Citeureup)</li>
                        <li>Email: bima.pupr@bogorkab.go.id</li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-slate-200 flex flex-col md:flex-row justify-between items-center text-[10px]">
                <div>&copy; 2026 Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Bogor. Hak Cipta Dilindungi Undang-Undang.</div>
                <div class="flex gap-4 mt-2 md:mt-0">
                    <a href="#" class="hover:text-slate-800">Infrastruktur Presisi</a>
                    <a href="#" class="hover:text-slate-800">Transparansi Publik</a>
                    <a href="#" class="hover:text-slate-800">Sistem Geospasial Terpadu</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
