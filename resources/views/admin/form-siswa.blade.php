<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($siswa) ? 'Edit Siswa' : 'Tambah Siswa' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body{background:transparent;font-family:Arial, Helvetica, sans-serif;color:#222}
        .wrap{padding:24px}
        .img-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('{{ asset('img/bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(8px);
            z-index: 0;
        }
        nav{background:#fff;padding:12px;border-radius:6px;margin-bottom:18px}
        h2{margin-bottom:18px}
        .form-wrap{background:#fff;padding:24px;border-radius:6px}
        .form-group{margin-bottom:18px}
        .form-group label{font-weight:600;margin-bottom:8px;display:block}
        .form-group input,
        .form-group select,
        .form-group textarea{
            width:100%;
            padding:10px;
            border:2px solid #ddd;
            border-radius:4px;
            font-size:14px;
            font-family:Arial, Helvetica, sans-serif
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus{
            outline:none;
            border-color:#007bff;
            box-shadow:0 0 0 3px rgba(0,123,255,0.1)
        }
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:24px}
        .form-row.full{grid-template-columns:1fr}
        .btn-group{display:flex;gap:12px;margin-top:24px;justify-content:flex-end}
        .btn{padding:10px 24px;border:none;border-radius:4px;font-weight:600;cursor:pointer;transition:all 0.3s}
        .btn-primary{background:#007bff;color:#fff}
        .btn-primary:hover{background:#0056b3;text-decoration:none;color:#fff}
        .btn-secondary{background:#6c757d;color:#fff}
        .btn-secondary:hover{background:#545b62;text-decoration:none;color:#fff}
        .error-message{color:#dc3545;font-size:12px;margin-top:4px;display:block}
        .form-group.has-error input,
        .form-group.has-error select,
        .form-group.has-error textarea{border-color:#dc3545}
        @media (max-width:768px){ 
            .form-row{grid-template-columns:1fr}
            .btn-group{flex-direction:column}
            .btn{width:100%}
        }
    </style>
</head>
<body>
    <div class="img-background"></div>
    <div class="wrap container-fluid" style="z-index: 1; position: relative">
        @include('admin.header-admin')

        <div class="form-wrap">
            <h2>{{ isset($siswa) ? 'Edit Siswa' : 'Tambah Siswa' }}</h2>

            <form method="POST" action="{{ isset($siswa) && $siswa ? route('siswa.update', $siswa->id) : route('siswa.store') }}">
                @csrf
                @if(isset($siswa) && $siswa)
                    @method('PUT')
                @endif

                <div class="form-row">
                    <div class="form-group @error('nama') has-error @enderror">
                        <label for="nama">Nama Siswa</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama', $siswa->nama ?? '') }}" required placeholder="Masukkan nama siswa">
                        @error('nama')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group @error('nis') has-error @enderror">
                        <label for="nis">NIS</label>
                        <input type="text" id="nis" name="nis" value="{{ old('nis', $siswa->nis ?? '') }}" required placeholder="Masukkan nomor induk siswa">
                        @error('nis')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group @error('user_id') has-error @enderror">
                        <label for="user_id">Akun Pengguna</label>
                        <select id="user_id" name="user_id" required>
                            <option value="">-- Pilih Akun --</option>
                            @foreach($users ?? [] as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $siswa->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group @error('kelas_id') has-error @enderror">
                        <label for="kelas_id">Kelas</label>
                        <select id="kelas_id" name="kelas_id">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas ?? [] as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id ?? '') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas ?? $k->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group @error('no_hp_ortu') has-error @enderror">
                        <label for="no_hp_ortu">No. HP Orang Tua</label>
                        <input type="tel" id="no_hp_ortu" name="no_hp_ortu" value="{{ old('no_hp_ortu', $siswa->no_hp_ortu ?? '') }}" placeholder="Masukkan nomor HP orang tua">
                        @error('no_hp_ortu')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="btn-group">
                    <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        {{ isset($siswa) ? 'Perbarui' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
