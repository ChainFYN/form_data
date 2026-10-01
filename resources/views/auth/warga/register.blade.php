@extends('warga.layouts.app')

@section('title', 'Pendaftaran Akun Warga - SIGAP')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8 max-w-2xl mx-auto">
    <div class="text-center mb-8">
        <div class="w-14 h-14 rounded-2xl bg-slate-900 flex items-center justify-center text-white mx-auto shadow-md mb-4">
            <i class="fa-solid fa-user-plus text-2xl text-emerald-400"></i>
        </div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Registrasi Akun Warga</h1>
        <p class="text-xs text-slate-500 mt-1">Daftarkan akun pelapor Anda untuk berpartisipasi dalam perbaikan infrastruktur jalan.</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 sm:p-8">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl p-4 mb-6 space-y-1">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                    <span>Terdapat kesalahan pengisian data:</span>
                </div>
                <ul class="list-disc pl-5 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('warga.register') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Username -->
                <div>
                    <label for="username" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="username" 
                           id="username" 
                           value="{{ old('username') }}" 
                           maxlength="10" 
                           required 
                           placeholder="Maks 10 huruf" 
                           class="w-full py-2.5 px-3 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800 placeholder-slate-400">
                    <span class="text-[10px] text-slate-400 block mt-1">Hanya huruf alfabet, maks. 10 karakter.</span>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email') }}" 
                           required 
                           placeholder="nama@email.com" 
                           class="w-full py-2.5 px-3 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800 placeholder-slate-400">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nama Lengkap -->
                <div>
                    <label for="nama_lengkap" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Nama Lengkap (sesuai KTP) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama_lengkap" 
                           id="nama_lengkap" 
                           value="{{ old('nama_lengkap') }}" 
                           maxlength="100" 
                           required 
                           placeholder="Nama Lengkap Anda" 
                           class="w-full py-2.5 px-3 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800 placeholder-slate-400">
                    <span class="text-[10px] text-slate-400 block mt-1">Hanya huruf dan spasi.</span>
                </div>

                <!-- Telepon -->
                <div>
                    <label for="telepon" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Nomor WhatsApp / Telepon <span class="text-red-500">*</span>
                    </label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 rounded-l-xl border border-r-0 border-slate-200 bg-slate-100 text-slate-600 text-xs font-bold">
                            +62
                        </span>
                        <input type="text" 
                               name="telepon" 
                               id="telepon" 
                               value="{{ old('telepon') }}" 
                               minlength="12" 
                               maxlength="15" 
                               required 
                               placeholder="81234567890" 
                               onkeypress="return event.charCode >= 48 && event.charCode <= 57" 
                               class="w-full py-2.5 px-3 text-xs rounded-r-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800 placeholder-slate-400">
                    </div>
                    <span class="text-[10px] text-slate-400 block mt-1">12-15 digit angka (tanpa 0 di depan).</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Kecamatan -->
                <div>
                    <label for="id_kecamatan" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Kecamatan Domisili <span class="text-red-500">*</span>
                    </label>
                    <select id="id_kecamatan" class="w-full py-2.5 px-3 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800" required>
                        <option value="" disabled selected>Pilih Kecamatan</option>
                        @foreach($kecamatan as $k)
                            <option value="{{ $k->id_kecamatan }}">{{ $k->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Desa -->
                <div>
                    <label for="id_desa" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Kelurahan / Desa <span class="text-red-500">*</span>
                    </label>
                    <select name="id_desa" id="id_desa" class="w-full py-2.5 px-3 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800 disabled:opacity-50 disabled:cursor-not-allowed" required disabled>
                        <option value="" disabled selected>Pilih Kecamatan terlebih dahulu</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           minlength="8" 
                           maxlength="12" 
                           required 
                           placeholder="8 - 12 karakter" 
                           class="w-full py-2.5 px-3 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800 placeholder-slate-400">
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Ulangi Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation" 
                           minlength="8" 
                           maxlength="12" 
                           required 
                           placeholder="Ketik ulang kata sandi" 
                           class="w-full py-2.5 px-3 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400 bg-slate-50 text-slate-800 placeholder-slate-400">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-3 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition shadow-xs flex items-center justify-center gap-2">
                    <i class="fa-solid fa-user-check text-emerald-400"></i>
                    <span>Daftarkan Akun Pelapor Warga</span>
                </button>
            </div>
        </form>

        <div class="mt-6 pt-5 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-500">
                Sudah memiliki akun warga? 
                <a href="{{ route('warga.login') }}" class="font-bold text-slate-900 hover:text-brand-600 transition">
                    Masuk ke sini &rarr;
                </a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const desaData = @json($desaGrouped);
    
    $('#id_kecamatan').on('change', function() {
        const idKec = $(this).val();
        const desaSelect = $('#id_desa');
        desaSelect.empty().append('<option value="" disabled selected>Pilih Kelurahan/Desa</option>');
        
        if (desaData[idKec]) {
            desaData[idKec].forEach(function(d) {
                desaSelect.append(`<option value="${d.id_desa}">${d.nama_desa}</option>`);
            });
            desaSelect.prop('disabled', false);
        } else {
            desaSelect.prop('disabled', true);
        }
    });
</script>
@endpush
