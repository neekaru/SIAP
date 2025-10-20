<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($kelas) ? 'Edit Kelas' : 'Tambah Kelas' }}</title>
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
        .form-wrap .btn{padding:10px 24px;border:none;border-radius:4px;font-weight:600;cursor:pointer;transition:all 0.3s}
        .form-wrap .btn-primary{background:#007bff;color:#fff}
        .form-wrap .btn-primary:hover{background:#0056b3;text-decoration:none;color:#fff}
        .form-wrap .btn-secondary{background:#6c757d;color:#fff}
        .form-wrap .btn-secondary:hover{background:#545b62;text-decoration:none;color:#fff}
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
            <h2>{{ isset($kelas) ? 'Edit Kelas' : 'Tambah Kelas' }}</h2>

            <form method="POST" action="{{ isset($kelas) && $kelas ? route('kelas.update', $kelas->id) : route('kelas.store') }}">
                @csrf
                @if(isset($kelas) && $kelas)
                    @method('PUT')
                @endif

                <!-- DATA KELAS -->
                <div style="background:#f8f9fa; padding:16px; border-radius:6px; margin-bottom:24px">
                    <h4 style="margin-top:0; margin-bottom:16px; color:#333">Data Kelas</h4>

                    <div class="form-row">
                        <div class="form-group @error('kode') has-error @enderror">
                            <label for="kode">Kode Kelas</label>
                            <input type="text" id="kode" name="kode" value="{{ old('kode', $kelas->kode ?? '') }}" required placeholder="Masukkan kode kelas (contoh: X-A)">
                            @error('kode')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group @error('nama') has-error @enderror">
                            <label for="nama">Nama Kelas</label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama', $kelas->nama ?? '') }}" required placeholder="Masukkan nama kelas">
                            @error('nama')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group @error('walikelas_id') has-error @enderror">
                            <label for="walikelas_id">Wali Kelas</label>
                            <select id="walikelas_id" name="walikelas_id" required>
                                <option value="">-- Pilih Wali Kelas --</option>
                                @foreach($guru ?? [] as $g)
                                    <option value="{{ $g->id }}" {{ old('walikelas_id', $kelas->walikelas_id ?? '') == $g->id ? 'selected' : '' }}>
                                        {{ $g->nama }} ({{ $g->nip }})
                                    </option>
                                @endforeach
                            </select>
                            @error('walikelas_id')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="btn-group">
                    <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        {{ isset($kelas) ? 'Perbarui' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>