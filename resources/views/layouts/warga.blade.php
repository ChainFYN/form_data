<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIGAP - Sistem Informasi Pelaporan Kerusakan Jalan')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0066cc;
            --secondary-blue: #3399ff;
            --light-bg: #f5f8ff;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        main {
            flex: 1;
        }
        .navbar-sigap {
            background-color: var(--primary-blue);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand-sigap {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }
        .nav-link-sigap {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
        }
        .nav-link-sigap:hover {
            color: white !important;
        }
        .card-sigap {
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }
        .card-sigap:hover {
            transform: translateY(-2px);
        }
        .btn-sigap-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            color: white;
            border-radius: 8px;
            padding: 10px 24px;
            font-weight: 500;
        }
        .btn-sigap-primary:hover {
            background-color: var(--secondary-blue);
            border-color: var(--secondary-blue);
        }
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .status-menunggu { background-color: #fff3cd; color: #856404; }
        .status-diproses { background-color: #d1ecf1; color: #0c5460; }
        .status-selesai { background-color: #d4edda; color: #155724; }
        .status-ditolak { background-color: #f8d7da; color: #721c24; }
        .footer-sigap {
            background-color: var(--primary-blue);
            color: white;
            padding: 20px 0;
            margin-top: 40px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-sigap">
        <div class="container">
            <a class="navbar-brand navbar-brand-sigap" href="{{ route('warga.dashboard') }}">SIGAP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(Session::has('warga_id'))
                    <li class="nav-item">
                        <a class="nav-link nav-link-sigap {{ request()->routeIs('warga.dashboard') ? 'active' : '' }}" href="{{ route('warga.dashboard') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-sigap {{ request()->routeIs('warga.laporan.create') ? 'active' : '' }}" href="{{ route('warga.laporan.create') }}">Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-sigap {{ request()->routeIs('warga.laporan.index') ? 'active' : '' }}" href="{{ route('warga.laporan.index') }}">Riwayat</a>
                    </li>
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('warga.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a href="#" class="nav-link nav-link-sigap" onclick="confirmLogout(event)">Logout</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link nav-link-sigap" href="{{ route('warga.login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-sigap" href="{{ route('warga.register') }}">Daftar</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container my-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-sigap">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} SIGAP - Sistem Informasi Pelaporan Kerusakan Jalan. Jember.</p>
            <small>Email: sigap@jember.go.id | Hotline: 1500-123</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function confirmLogout(e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin keluar dari akun ini?')) {
                document.getElementById('logout-form').submit();
            }
        }
    </script>
    @stack('scripts')
</body>
</html>