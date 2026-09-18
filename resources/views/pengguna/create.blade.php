<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna - Sistem Pelaporan Kerusakan Jalan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5 mb-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Tambah Pengguna Baru</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pengguna.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-label mb-1 form-control" value="{{ old('username') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-label mb-1 form-control" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-label mb-1 form-control" value="{{ old('nama_lengkap') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label">No. Telepon</label>
                            <input type="text" name="telepon" id="telepon" class="form-label mb-1 form-control" value="{{ old('telepon') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-label mb-1 form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="id_peran" class="form-label">Peran</label>
                            <select name="id_peran" id="id_peran" class="form-select" required>
                                <option value="" disabled selected>Pilih Peran</option>
                                @foreach($peran as $item)
                                    <option value="{{ $item->id_peran }}" {{ old('id_peran') == $item->id_peran ? 'selected' : '' }}>
                                        {{ $item->nama_peran }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="id_desa" class="form-label">Desa (Domisili)</label>
                        <select name="id_desa" id="id_desa" class="form-select">
                            <option value="">-- Tidak Memilih Desa --</option>
                            @foreach($desa as $item)
                                <option value="{{ $item->id_desa }}" {{ old('id_desa') == $item->id_desa ? 'selected' : '' }}>
                                    {{ $item->nama_desa }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Opsional untuk Admin Kecamatan/PUPR jika cakupan luas.</small>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success px-4">Simpan</button>
                        <a href="{{ route('pengguna.index') }}" class="btn btn-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>