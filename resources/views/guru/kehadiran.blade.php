<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Kehadiran - Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .table-wrap{background:#fff;padding:16px;border-radius:6px}
        table.attendance{width:100%;border-collapse:collapse}
        table.attendance th, table.attendance td{border:2px solid #222;padding:8px;text-align:left}
        table.attendance th{background:#f5f5f5}
        .actions .btn{margin-right:8px}
        @media (max-width:900px){ .table-wrap{overflow:auto} }
    </style>
</head>
<body>
    <div class="img-background"></div>
    <div class="wrap container-fluid" style="z-index: 1; position: relative">
        <nav class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div style="width:36px;height:36px;background:#eee;border-radius:4px;display:flex;align-items:center;justify-content:center;margin-right:12px">Logo</div>
                <strong>{{ strtoupper(config('app.name', 'Nama Sekolah')) }}</strong>
            </div>
            <div class="d-flex align-items-center">
                <div style="width:36px;height:36px;border-radius:50%;background:#efefef;margin-right:10px;display:flex;align-items:center;justify-content:center">Img</div>
                <div>Selamat datang<br><strong>Nama Guru</strong></div>
                <span class="mx-2"></span>
                <a href="#" class="btn btn-outline-secondary btn-sm">Logout</a>
            </div>
        </nav>

        <h2 class="mb-8 mt-4">Data Kehadiran</h2>

        <div class="table-wrap">
            <!-- actions at per-row only; removed top-level action buttons per design -->

            <table class="attendance">
                <thead>
                    <tr>
                        <th style="width:60px">NO</th>
                        <th>Nama</th>
                        <th style="width:160px">NIS</th>
                        <th style="width:160px">Waktu</th>
                        <th style="width:140px">Status</th>
                        <th style="width:180px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kehadiran as $i => $row)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $row['nama'] ?? '-' }}</td>
                            <td>{{ $row['nis'] ?? '-' }}</td>
                            <td>{{ $row['waktu'] ?? '-' }}</td>
                            <td>{{ $row['status'] ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary">Validasi</button>
                                    <button class="btn btn-sm btn-outline-danger">Alpa</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted" style="padding:48px">Tidak ada data kehadiran untuk hari ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
