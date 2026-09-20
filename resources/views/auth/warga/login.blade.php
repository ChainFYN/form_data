@extends('layouts.warga')

@section('title', 'Login - SIGAP')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
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
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                    <button type="submit" class="btn btn-sigap-primary w-100 mb-3">Masuk</button>
                </form>
                
                <p class="text-center mb-0">
                    Belum punya akun? <a href="{{ route('warga.register') }}" class="text-decoration-none fw-semibold">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection