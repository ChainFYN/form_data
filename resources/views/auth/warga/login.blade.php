@extends('warga.layouts.app')

@section('title', 'Masuk - SIGAP Warga')

@section('content')
<div class="min-h-[calc(100vh-280px)] flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <div class="w-14 h-14 rounded-2xl bg-slate-900 flex items-center justify-center text-white mx-auto shadow-md mb-4">
            <i class="fa-solid fa-users text-2xl text-sky-400"></i>
        </div>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Masuk Portal SIGAP</h2>
        <p class="text-xs text-slate-500 mt-1">Sistem Informasi Pelaporan Kerusakan Jalan (SIGAP) Kab. Jember</p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
        <div class="bg-white py-8 px-6 sm:px-10 rounded-2xl border border-slate-200 shadow-xs">

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl p-3.5 mb-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('warga.login') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="login" class="block text-xs font-bold text-slate-700 mb-1.5">NIK atau Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-id-card text-xs"></i>
                        </div>
                        <input type="text"
                               name="login"
                               id="login"
                               value="{{ old('login') }}"
                               required
                               placeholder="Masukkan NIK (Warga) atau Email (Admin)"
                               class="w-full pl-9 pr-3 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800 placeholder-slate-400">
                    </div>
                    <span class="text-[10px] text-slate-400 block mt-1">Warga: masukkan 16 digit NIK &bull; Admin: masukkan alamat email</span>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold text-slate-700">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </div>
                        <input type="password"
                               name="password"
                               id="password"
                               required
                               placeholder="Minimal 8 karakter"
                               class="w-full pl-9 pr-10 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800 placeholder-slate-400">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <i id="password-toggle-icon" class="fa-regular fa-eye text-xs"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900">
                        <span class="text-xs text-slate-600">Ingat saya</span>
                    </label>
                    <span class="text-[11px] text-slate-400">Portal Aman Terenkripsi</span>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition shadow-xs flex items-center justify-center gap-2">
                        <span>Masuk ke Akun SIGAP</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500">
                    Belum memiliki akun warga?
                    <a href="{{ route('warga.register') }}" class="font-bold text-slate-900 hover:text-brand-600 transition">
                        Daftar sekarang &rarr;
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('password-toggle-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush
