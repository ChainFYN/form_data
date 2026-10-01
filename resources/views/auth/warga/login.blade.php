@extends('layouts.warga')

@section('title', 'Login - SIGAP')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card card-sigap p-4">
            <div class="card-body">
                <h3 class="text-center mb-4 text-primary fw-bold">MASUK</h3>
                <p class="text-center text-muted mb-4">Sistem Informasi Pelaporan Kerusakan Jalan</p>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('warga.login') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Terdaftar</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"></span>
                            <input type="email" name="email" id="email" class="form-control border-start-0 ps-0" placeholder="Nama@email.com" required style="box-shadow: none;">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Kata Sandi Akun</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"></span>
                            <input type="password" name="password" id="password" class="form-control border-start-0 border-end-0 ps-0" placeholder="Minimal 8 karakter " required style="box-shadow: none;">
                            <span class="input-group-text bg-white border-start-0 text-muted" style="cursor: pointer;" onclick="togglePassword()">👁</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember">
                            <label class="form-check-label text-muted" for="remember">Ingat saya</label>
                        </div>
                        <a href="#" class="text-decoration-none fw-semibold">Lupa Kata Sandi?</a>
                    </div>

                    <button type="submit" class="btn btn-sigap-primary w-100 mb-3 fw-bold">MASUK</button>
                </form>
                
                <p class="text-center mb-0 text-muted">
                    Belum memiliki akun pelapor warga? <a href="{{ route('warga.register') }}" class="text-decoration-none fw-bold">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
</script>
@endpush
@endsection