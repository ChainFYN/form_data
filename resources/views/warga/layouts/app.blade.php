<!DOCTYPE html>
<html lang="id" class="h-full" style="background-color: #F8F5F4;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#141E71">
    <meta name="csrf-token"

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
                            50: '#F3F8FF',
                            100: '#C0EEF4',
                            500: '#69A4F9',
                            600: '#3B4AE9',
                            700: '#141E71',
                            800: '#101C5A',
                            900: '#0A143F',
                        },
                        slate: {
                            50: '#F5F9FF',
                            800: '#1A2D66',
                            900: '#141E71',
                        },
                        navy: {
                            100: '#C0EEF4',
                            300: '#69A4F9',
                            500: '#3B4AE9',
                            700: '#141E71',
                            900: '#0B173F',
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

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

    <!-- jQuery for dynamic dropdowns -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F5F4; }
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
        .navy-gradient {
            background: linear-gradient(180deg, #0C146A 0%, #101B93 90%, #1523BC 100%);
            box-shadow: 0 4px 18px rgba(20, 30, 113, 0.18);
        }
        .footer-gradient {
            background: linear-gradient(180deg, #1523BC 0%, #101B93 20%, #0C146A 100%);
            box-shadow: 0 -4px 18px rgba(20, 30, 113, 0.12);
        }
    </style>
    @stack('styles')
</head>
<body class="h-full flex flex-col text-slate-800 antialiased" style="background-color: #F8F5F4;" x-data="{ mobileMenuOpen: false }">

    <!-- TOP NAVBAR (Disembunyikan pada halaman Login & Register) -->
    @if(!request()->routeIs('warga.login') && !request()->routeIs('warga.register') && !isset($hideHeader))
    <header class="navy-gradient border-b border-white/10 sticky top-0 z-40 shadow-[0_8px_24px_rgba(20,30,113,0.12)]">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Left: Logo & Portal Title -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('warga.dashboard') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/95 flex items-center justify-center text-white shadow-md ring-1 ring-white/40">
                            <i class="fa-solid fa-users text-lg text-[#141E71]"></i>
                        </div>
                        <div>
                            <div class="font-extrabold text-xl tracking-tight text-white leading-none">SIGAP</div>
                            <div class="text-[10px] font-bold uppercase tracking-wider text-[#C0EEF4] mt-1">WARGA</div>
                        </div>
                    </a>

                    <!-- Main Navigation Menu -->
                    <nav class="hidden md:flex items-center gap-2">
                        <a href="{{ route('warga.dashboard') }}" 
                           class="px-4 py-2 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('warga.dashboard') ? 'bg-[#F5F5F5] saturate-50 text-[#141E71] shadow-sm' : 'text-slate-100 hover:text-white hover:bg-white/10' }}">
                            Dashboard Warga
                        </a>
                        <a href="{{ route('warga.laporan.create') }}" 
                           class="px-4 py-2 text-sm font-semibold rounded-xl transition-all flex items-center gap-2 {{ request()->routeIs('warga.laporan.create') ? 'bg-[#F5F5F5] saturate-50 text-[#141E71] shadow-sm' : 'text-slate-100 hover:text-white hover:bg-white/10' }}">
                            <i class="fa-solid fa-circle-plus text-xs text-[#C0EEF4]"></i>
                            <span>Buat Laporan</span>
                        </a>
                        <a href="{{ route('warga.laporan.index') }}" 
                           class="px-4 py-2 text-sm font-semibold rounded-xl transition-all relative flex items-center gap-2 {{ request()->routeIs('warga.laporan.index') || request()->routeIs('warga.laporan.show') ? 'bg-[#F5F5F5] saturate-50 text-[#141E71] shadow-sm' : 'text-slate-100 hover:text-white hover:bg-white/10' }}">
                            <span>Riwayat Laporan</span>
                        </a>
                    </nav>
                </div>

                <!-- Right: Profile & Actions -->
                <div class="flex items-center gap-4">
                    @if(Session::has('warga_id'))
                        <div class="flex items-center gap-3 pl-4 border-l border-white/20">
                            <div class="text-right hidden sm:block">
                                <div class="text-xs font-extrabold text-white">{{ session('warga_name', 'Warga Pelapor') }}</div>
                                <div class="text-[10px] text-slate-200 font-medium">Pelapor Terdaftar<br>Kab. Jember</div>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-[#141E71] font-bold shrink-0 shadow-sm">
                                <i class="fa-regular fa-user"></i>
                            </div>
                            <form id="logout-form" action="{{ route('warga.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <button type="button" onclick="confirmLogout(event)" title="Keluar / Logout" class="text-slate-100 hover:text-white p-2 rounded-lg hover:bg-white/10 transition-colors">
                                <i class="fa-solid fa-arrow-right-from-bracket text-base"></i>
                            </button>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('warga.login') }}" class="px-4 py-2 text-xs font-bold text-white hover:bg-white/10 rounded-xl transition">
                                Masuk
                            </a>
                            <a href="{{ route('warga.register') }}" class="px-4 py-2 text-xs font-bold bg-[#F5F5F5] saturate-50 text-[#141E71] rounded-xl hover:bg-[#f2ddd1] transition shadow-sm">
                                Daftar Akun
                            </a>
                        </div>
                    @endif

                    <!-- Mobile Hamburger Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg text-white hover:bg-white/10 focus:outline-none">
                        <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark text-lg' : 'fa-bars text-lg'"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Drawer -->
            <div x-show="mobileMenuOpen" x-cloak class="md:hidden py-3 border-t border-white/10 flex flex-col gap-1.5 animate-in slide-in-from-top-2 duration-150">
                <a href="{{ route('warga.dashboard') }}" 
                   class="px-3.5 py-2 text-sm font-semibold rounded-lg {{ request()->routeIs('warga.dashboard') ? 'bg-[#F5F5F5] saturate-50 text-[#141E71]' : 'text-slate-100 hover:bg-white/10' }}">
                    Dashboard Warga
                </a>
                <a href="{{ route('warga.laporan.create') }}" 
                   class="px-3.5 py-2 text-sm font-semibold rounded-lg {{ request()->routeIs('warga.laporan.create') ? 'bg-[#F5F5F5] saturate-50 text-[#141E71]' : 'text-slate-100 hover:bg-white/10' }}">
                    Buat Laporan Baru
                </a>
                <a href="{{ route('warga.laporan.index') }}" 
                   class="px-3.5 py-2 text-sm font-semibold rounded-lg {{ request()->routeIs('warga.laporan.index') || request()->routeIs('warga.laporan.show') ? 'bg-[#F5F5F5] saturate-50 text-[#141E71]' : 'text-slate-100 hover:bg-white/10' }}">
                    Riwayat Laporan
                </a>
            </div>
        </div>
    </header>
    @endif

    <!-- TOAST NOTIFICATION -->
    @if(session('success') || session('status'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 rounded-xl shadow-2xl border text-sm font-semibold transition-all transform animate-in slide-in-from-bottom-5 duration-300 bg-emerald-600 text-white border-emerald-500">
            <i class="fa-solid fa-circle-check text-lg"></i>
            <div>
                <p class="leading-tight">{{ session('success') ?? session('status') }}</p>
            </div>
            <button @click="show = false" class="ml-3 text-white/80 hover:text-white">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 rounded-xl shadow-2xl border text-sm font-semibold transition-all transform animate-in slide-in-from-bottom-5 duration-300 bg-red-600 text-white border-red-500">
            <i class="fa-solid fa-triangle-exclamation text-lg"></i>
            <div>
                <p class="leading-tight">{{ session('error') }}</p>
            </div>
            <button @click="show = false" class="ml-3 text-white/80 hover:text-white">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    @endif

    <!-- MAIN BODY CONTENT -->
    <main class="flex-1" style="background-color: #F8F5F4;">
        @yield('content')
    </main>

    <!-- FOOTER (Matching PUPR & Kecamatan) -->
    <footer class="footer-gradient border-t border-white/10 mt-12 py-8">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <!-- Left -->
                <div>
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-md bg-white/95 flex items-center justify-center text-[#141E71] text-xs shadow-sm">
                            <i class="fa-solid fa-landmark"></i>
                        </div>
                        <h4 class="font-bold text-white text-sm">Pemerintah Kabupaten Jember</h4>
                    </div>
                    <p class="text-xs text-slate-200 mt-1">Dinas Pekerjaan Umum dan Penataan Ruang (PUPR) berkolaborasi dengan Kantor Kecamatan & Masyarakat Jember.</p>
                    <p class="text-[11px] text-slate-300 mt-2">&copy; {{ date('Y') }} Portal SIGAP Kabupaten Jember. Hak Cipta Dilindungi Undang-Undang.</p>
                </div>

                <!-- Right -->
                <div class="text-left md:text-right">
                    <p class="text-xs font-semibold text-slate-200">Layanan Darurat Jalan Rusak:</p>
                    <p class="text-sm font-bold text-white mt-0.5">Call Center Kab. Jember: 112 / (0331) 487-123</p>
                    <div class="flex items-center md:justify-end gap-3 text-[11px] text-slate-300 mt-2">
                        <span>Standar Partisipasi Warga</span>
                        <span>&bull;</span>
                        <span class="font-mono bg-white/10 px-1.5 py-0.5 rounded border border-white/15 text-white">Versi 2.4.1</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function confirmLogout(e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin keluar dari akun Warga?')) {
                document.getElementById('logout-form').submit();
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
