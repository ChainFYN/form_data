@extends('layouts.warga')

@section('title', 'Daftar - SIGAP')

@section('content')
<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-7">
        <div class="card card-sigap p-4">
            <div class="card-body">
                <h3 class="text-center mb-2 text-primary fw-bold">DAFTAR AKUN WARGA</h3>
                <p class="text-center text-muted mb-4">Lengkapi data diri Anda untuk membuat laporan</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('warga.register') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label fw-semibold">Username</label>
                            <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" maxlength="10" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Hanya huruf, maksimal 10 karakter.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" maxlength="100" required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Hanya huruf.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label fw-semibold">No. Telepon / WA</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold">+62</span>
                                <input type="text" name="telepon" id="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon') }}" placeholder="81234567890" minlength="12" maxlength="15" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                            </div>
                            @error('telepon')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Angka saja, 12 hingga 15 digit (tanpa 0 di depan, misal 812...)</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="id_kecamatan" class="form-label fw-semibold">Kecamatan</label>
                            <select id="id_kecamatan" class="form-select" required>
                                <option value="" disabled selected>Pilih Kecamatan</option>
                                @foreach($kecamatan as $k)
                                    <option value="{{ $k->id_kecamatan }}">{{ $k->nama_kecamatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="id_desa" class="form-label fw-semibold">Kelurahan / Desa</label>
                            <select name="id_desa" id="id_desa" class="form-select" required disabled>
                                <option value="" disabled selected>Pilih Kecamatan terlebih dahulu</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-sigap-primary w-100 mb-3 mt-3">Daftar Akun</button>
                </form>

                <p class="text-center mb-0">
                    Sudah punya akun? <a href="{{ route('warga.login') }}" class="text-decoration-none fw-semibold">Masuk di sini</a>
                </p>
            </div>
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