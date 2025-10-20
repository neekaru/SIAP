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
            <h2>{{ isset($siswa) ? 'Edit Siswa' : 'Tambah Siswa' }}</h2>

            @if(isset($siswa))
                <form method="POST" action="{{ route('siswa.update', $siswa_id) }}">
                    @csrf
                    @method('PUT')
            @else
                <form method="POST" action="{{ route('siswa.store') }}">
                    @csrf
            @endif

                <!-- DATA SISWA -->
                <div style="background:#f8f9fa; padding:16px; border-radius:6px; margin-bottom:24px">
                    <h4 style="margin-top:0; margin-bottom:16px; color:#333">Data Siswa</h4>
                    
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
                        <div class="form-group @error('kelas_id') has-error @enderror">
                            <label for="kelas_id">Kelas</label>
                            <select id="kelas_id" name="kelas_id">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelas ?? [] as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id ?? '') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama ?? $k->kode }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group @error('no_hp_ortu') has-error @enderror">
                            <label for="no_hp_ortu">No. HP Orang Tua</label>
                            <input type="tel" id="no_hp_ortu" name="no_hp_ortu" value="{{ old('no_hp_ortu', $siswa->no_hp_ortu ?? '') }}" placeholder="Masukkan nomor HP orang tua">
                            @error('no_hp_ortu')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- DATA PENGGUNA (USER) -->
                <div style="background:#f8f9fa; padding:16px; border-radius:6px; margin-bottom:24px">
                    <h4 style="margin-top:0; margin-bottom:16px; color:#333">Data Pengguna</h4>
                    
                    <div class="form-row">
                        <div class="form-group @error('user_name') has-error @enderror">
                            <label for="user_name">Nama Pengguna</label>
                            <input type="text" id="user_name" name="user_name" value="{{ old('user_name', $siswa?->user?->name ?? '') }}" required placeholder="Akan terisi otomatis dari nama siswa">
                            @error('user_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group @error('email') has-error @enderror">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $siswa?->user?->email ?? '') }}" required placeholder="Akan terisi otomatis dari nama siswa">
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group @error('username') has-error @enderror">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username', $siswa?->user?->username ?? '') }}" required placeholder="Akan terisi otomatis dari nama siswa">
                            @error('username')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        @if(!isset($siswa))
                        <div class="form-group @error('password') has-error @enderror">
                            <label for="password">Password</label>
                            <div style="position: relative;">
                                <input type="password" id="password" name="password" required placeholder="Masukkan password">
                                <button type="button" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #666;">
                                    <i class="fas fa-eye" id="passwordIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif
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
    <script>
        // Auto-fill user data from student name
        document.getElementById('nama').addEventListener('input', function() {
            const nama = this.value.trim();
            
            if (nama) {
                // Set nama pengguna (same as nama siswa)
                document.getElementById('user_name').value = nama;
                
                // Generate username (lowercase, no spaces, replace with dots or underscores)
                const username = nama.toLowerCase().replace(/\s+/g, '.');
                document.getElementById('username').value = username;
                
                // Generate email (lowercase, no spaces, add @siswa.school or similar)
                const emailUsername = nama.toLowerCase().replace(/\s+/g, '.');
                document.getElementById('email').value = emailUsername + '@siswa.sch.id';
            }
        });

        // Trigger auto-fill on page load if nama already has value
        window.addEventListener('load', function() {
            const namaInput = document.getElementById('nama');
            if (namaInput.value) {
                namaInput.dispatchEvent(new Event('input'));
            }
        });

        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('passwordIcon');

        if (togglePassword && passwordInput && passwordIcon) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle icon
                if (type === 'password') {
                    passwordIcon.className = 'fas fa-eye';
                } else {
                    passwordIcon.className = 'fas fa-eye-slash';
                }
            });
        }
    </script>
</body>
</html>
