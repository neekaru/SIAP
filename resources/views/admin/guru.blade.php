<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body{background:transparent;font-family:Arial, Helvetica, sans-serif;color:#222}
        .wrap{padding:24px}
        .img-background {position: absolute;top: 0;left: 0;right: 0;bottom: 0;background-image: url('{{ asset('img/bg.jpg') }}');background-size: cover;background-position: center;background-repeat: no-repeat;filter: blur(8px);z-index: 0;}
        nav{background:#fff;padding:12px;border-radius:6px;margin-bottom:18px}
        h2{margin-bottom:18px}
        .table-wrap{background:#fff;padding:16px;border-radius:6px}
        table.data{width:100%;border-collapse:collapse}
        table.data th, table.data td{border:2px solid #222;padding:8px;text-align:left}
        table.data th{background:#f5f5f5}
        .actions .btn{margin-right:8px}
        @media (max-width:900px){ .table-wrap{overflow:auto} }
    </style>
</head>
<body>
    <div class="img-background"></div>
    <div class="wrap container-fluid" style="z-index: 1; position: relative">
        <nav class="navbar navbar-expand-lg navbar-light mb-4 rounded shadow-sm" style="padding: 0.75rem 1.5rem; background: #fff;">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo" class="me-2" style="width:64px; height:64px; border-radius:8px; object-fit:cover; display:inline-block;">
                    <span class="mx-2"></span>
                    <span class="school fs-5">{{ strtoupper(env('NAMA_SEKOLAH', config('app.name', 'Nama Sekolah'))) }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="avatar d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;border-radius:50%;background:#efefef;">Img</span>
                    <span class="welcome me-3" style="line-height:1.2;">Selamat datang<br><strong>Nama Admin</strong></span>
                    <form method="POST" action="{{ route('logout.post') }}" style="display:inline">
                        @csrf
                        <button type="submit" class="logout btn btn-outline-secondary btn-sm">Logout</button>
                    </form>
                </div>
            </div>
        </nav>

        <h2 class="mb-4 text-white">Manajemen Guru</h2>

        <div class="table-wrap">
            <div class="d-flex justify-content-end mb-3">
                <a href="#" class="btn btn-primary">Tambah Guru</a>
            </div>

            <table class="data">
                <thead>
                    <tr>
                        <th style="width:60px">NO</th>
                        <th>Nama</th>
                        <th style="width:160px">NUPTK</th>
                        <th style="width:220px">Email</th>
                        <th style="width:180px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guru ?? [] as $i => $row)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $row['nama'] ?? '-' }}</td>
                            <td>{{ $row['nuptk'] ?? '-' }}</td>
                            <td>{{ $row['email'] ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted" style="padding:48px">Tidak ada data guru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>