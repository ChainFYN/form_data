<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin Kecamatan') -SIGAP Kab. Jember</title>
    
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
                            50: '#fff7ed',
                            100: '#ffedd5',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        },
                        navy: {
                            800: '#0f172a',
                            900: '#0b1329',
                            950: '#050a18',
                        },
                        sigap: {
                            teal: '#0d9488',
                            darkteal: '#134e4a',
                        }
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Leaflet GIS CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>
    @stack('styles')
</head>
<body class="h-full flex flex-col text-slate-800 antialiased" x-data="{ searchModalOpen: false, notifOpen: false }">

    <!-- TOP NAVBAR -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs no-print">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Left: Logo & Portal Title -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('kecamatan.dashboard') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white">
                            <i class="fa-solid fa-building text-lg text-emerald-400"></i>
                        </div>
                        <div>
                            <div class="font-extrabold text-xl tracking-tight text-slate-900 leading-none">SIGAP</div>
                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mt-1">KECAMATAN</div>
                        </div>
                    </a>

                    <!-- Main Navigation Menu -->
                    <nav class="hidden md:flex items-center gap-1.5 ml-4">
                        <a href="{{ route('kecamatan.dashboard') }}" 
                           class="px-3.5 py-2 text-sm font-semibold rounded-lg transition-all {{ request()->routeIs('dashboard') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            Dashboard Kecamatan
                        </a>
                        <a href="{{ route('kecamatan.validation.index') }}" 
                           class="px-3.5 py-2 text-sm font-semibold rounded-lg transition-all relative flex items-center gap-2 {{ request()->routeIs('validation.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>Validasi Laporan</span>
                            
                        </a>
                        <a href="{{ route('kecamatan.bast.index') }}" 
                           class="px-3.5 py-2 text-sm font-semibold rounded-lg transition-all relative flex items-center gap-2 {{ request()->routeIs('kecamatan.bast.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>Verifikasi BAST</span>
                            <span class="inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-slate-900 bg-amber-400 rounded">2 Baru</span>
                        </a>

                    </nav>
                </div>

                <!-- Right: Notifications & Profile -->
                <div class="flex items-center gap-5">
                    
                    <!-- Notification Bell Dropdown -->
                    <div class="relative" x-data="{ notifOpen: false }">
                        <button @click="notifOpen = !notifOpen" 
                                class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200 relative transition-colors">
                            <i class="fa-regular fa-bell text-lg"></i>
                            <span class="absolute top-0 right-0 w-3.5 h-3.5 bg-amber-500 border-2 border-white rounded-full"></span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div x-show="notifOpen" @click.away="notifOpen = false" x-cloak
                             class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-slate-200 py-2 z-50 animate-in fade-in slide-in-from-top-2 duration-150">
                            <div class="px-4 py-2 border-b border-slate-100 flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-900 uppercase tracking-wider">Notifikasi Masuk (3)</span>
                                <span class="text-[11px] text-emerald-600 font-semibold cursor-pointer hover:underline">Tandai Dibaca</span>
                            </div>
                            <div class="divide-y divide-slate-100 max-h-72 overflow-y-auto custom-scrollbar">
                                <a href="{{ route('kecamatan.validation.index', ['ticket' => 'LP-2026-0842']) }}" class="flex gap-3 px-4 py-3 hover:bg-slate-50 transition-colors">
                                    <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-triangle-exclamation text-xs"></i>
                                    </div>
                                    <div class="text-xs">
                                        <p class="font-semibold text-slate-800">Aduan Kritis: Longsor Tebing</p>
                                        <p class="text-slate-500 text-[11px] truncate">Jl. Raya Cikaret KM 2 butuh respon UPT</p>
                                        <span class="text-[10px] text-slate-400 mt-1 block">15 menit lalu • SLA Sisa 2 Jam</span>
                                    </div>
                                </a>
                                <a href="{{ route('kecamatan.validation.index', ['ticket' => 'LP-2026-0841']) }}" class="flex gap-3 px-4 py-3 hover:bg-slate-50 transition-colors">
                                    <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-road-barrier text-xs"></i>
                                    </div>
                                    <div class="text-xs">
                                        <p class="font-semibold text-slate-800">Lubang Jalan Dalam >15cm</p>
                                        <p class="text-slate-500 text-[11px] truncate">Jl. Raya Mayor Oking No. 42</p>
                                        <span class="text-[10px] text-slate-400 mt-1 block">40 menit lalu • Menunggu Verifikasi</span>
                                    </div>
                                </a>
                                <div class="flex gap-3 px-4 py-3 hover:bg-slate-50 transition-colors">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-arrows-rotate text-xs"></i>
                                    </div>
                                    <div class="text-xs">
                                        <p class="font-semibold text-slate-800">Sinkronisasi Dinas PUPR Berhasil</p>
                                        <p class="text-slate-500 text-[11px]">42 data aduan tersinkronisasi ke server UPT</p>
                                        <span class="text-[10px] text-slate-400 mt-1 block">Hari ini, 11:42 WIB</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Profile Badge -->
                    <div class="flex items-center gap-3 pl-5 border-l border-slate-200">
                        <div class="text-right hidden sm:block">
                            <div class="text-xs font-extrabold text-slate-900">Kecamatan</div>
                            <div class="text-[10px] text-slate-500 font-medium">Admin<br>Kecamatan Jember</div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 shrink-0">
                            <i class="fa-regular fa-user"></i>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>

    <!-- TOAST NOTIFICATION -->
    @if(session('status'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 rounded-xl shadow-2xl border text-sm font-semibold transition-all transform animate-in slide-in-from-bottom-5 duration-300 {{ session('status_type') == 'success' ? 'bg-emerald-600 text-white border-emerald-500' : (session('status_type') == 'warning' ? 'bg-amber-600 text-white border-amber-500' : 'bg-slate-900 text-white border-slate-800') }}">
            <i class="fa-solid {{ session('status_type') == 'success' ? 'fa-circle-check text-lg' : 'fa-triangle-exclamation text-lg' }}"></i>
            <div>
                <p class="leading-tight">{{ session('status') }}</p>
            </div>
            <button @click="show = false" class="ml-3 text-white/80 hover:text-white">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    @endif

    <!-- MAIN BODY CONTENT -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- FOOTER (Matching Figma Exactly) -->
    <footer class="bg-white border-t border-slate-200 mt-12 py-8 no-print">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <!-- Left -->
                <div>
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-md bg-emerald-700 flex items-center justify-center text-white text-xs">
                            <i class="fa-solid fa-landmark"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm">Pemerintah Kabupaten Jember</h4>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Dinas Pekerjaan Umum dan Penataan Ruang (PUPR) berkolaborasi dengan Kantor Kecamatan Jember.</p>
                    <p class="text-[11px] text-slate-400 mt-2">© 2026 Portal SIGAP Kabupaten Jember. Hak Cipta Dilindungi Undang-Undang.</p>
                </div>

                <!-- Right -->
                <div class="text-left md:text-right">
                    <p class="text-xs font-semibold text-slate-700">Layanan Darurat Jalan Rusak:</p>
                    <p class="text-sm font-bold text-brand-600 mt-0.5">Call Center Kab. Jember: 112 / (021) 879-0123</p>
                    <div class="flex items-center md:justify-end gap-3 text-[11px] text-slate-400 mt-2">
                        <span>Standar Pelayanan Publik No. 201/KORD-UPR/2026</span>
                        <span>•</span>
                        <span class="font-mono bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200 text-slate-600">Versi 2.4.1</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- CTRL+K QUICK SEARCH MODAL -->
    <div x-show="searchModalOpen" @keydown.window.ctrl.k.prevent="searchModalOpen = true" @keydown.window.escape="searchModalOpen = false" x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-start justify-center pt-20 px-4">
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 max-w-xl w-full overflow-hidden" @click.away="searchModalOpen = false">
            <div class="p-4 border-b border-slate-100 flex items-center gap-3">
                <i class="fa-solid fa-magnifying-glass text-slate-400 text-lg"></i>
                <input type="text" 
                       id="modalSearchInput" 
                       placeholder="Ketik nomor tiket (e.g. LP-2026-0842), nama jalan, atau nama pelapor..." 
                       class="w-full text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none"
                       @keydown.enter="window.location.href = '{{ route('kecamatan.validation.index') }}?search=' + $el.value">
                <kbd class="text-[11px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded font-mono border">ESC</kbd>
            </div>
            <div class="p-3 bg-slate-50 text-xs text-slate-500 flex items-center justify-between">
                <span>Pencarian Cepat Akses Tiket SIGAP</span>
                <span class="text-brand-600 font-semibold cursor-pointer" @click="window.location.href = '{{ route('kecamatan.validation.index') }}'">Buka Semua Antrean &rarr;</span>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
