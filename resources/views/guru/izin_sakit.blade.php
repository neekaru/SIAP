<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Izin / Sakit - Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{background:transparent;font-family:Arial, Helvetica, sans-serif;color:#222}
        .wrap{padding:24px;position:relative;z-index:1}
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
        .navbar-avatar{width:36px;height:36px;border-radius:50%;background:#efefef;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:.875rem}
        .navbar-brand-logo{width:64px;height:64px;object-fit:cover;border-radius:.75rem}
        .navbar-user-text{line-height:1.2}
        .section-title{color:#fff}
        .table-card{border-radius:18px;overflow:hidden;box-shadow:0 10px 25px rgba(15,23,42,0.08)}
        .table-card .card-header{background:linear-gradient(90deg,#ec4899,#a855f7);color:#fff}
        .table-card .table thead th{background:#f8f9fa;font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;color:#475569}
        .table-card .table tbody td{vertical-align:middle}
    </style>
</head>
<body>
    <div class="img-background"></div>
    <div class="wrap container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm rounded-3 px-4 py-3">
            <div class="container-fluid">
                <span class="navbar-brand d-flex align-items-center gap-3">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo sekolah" class="navbar-brand-logo">
                    <span class="fs-5 text-uppercase fw-semibold">{{ strtoupper(env('NAMA_SEKOLAH', config('app.name', 'Nama Sekolah'))) }}</span>
                </span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#guruLeaveNavbar" aria-controls="guruLeaveNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="guruLeaveNavbar">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                        <li class="nav-item d-flex align-items-center">
                            <span class="navbar-avatar me-2">Img</span>
                            <span class="navbar-text navbar-user-text m-0 text-secondary text-start text-lg-end">Selamat datang<br><strong class="text-dark">Nama Guru</strong></span>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout.post') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary btn-sm">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <h2 class="section-title text-white fw-semibold mb-4 mt-2">Izin / Sakit</h2>

        <div class="card table-card border-0 bg-white">
            <div class="card-header d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div>
                    <h5 class="card-title mb-0 fw-semibold">Permohonan Izin &amp; Sakit</h5>
                    <small class="opacity-75">Tinjau, setujui, atau tolak permohonan siswa.</small>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col" style="width:60px" class="text-center">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col" style="width:140px">NIS</th>
                                <th scope="col" style="width:140px">Tanggal</th>
                                <th scope="col" style="width:120px" class="text-center">Jenis</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col" style="width:160px" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $i => $row)
                                @php
                                    $jenisLabel = $row['jenis'] ?? '-';
                                    $jenisKey = strtolower($jenisLabel);
                                    $badgeMap = [
                                        'izin' => 'bg-warning text-dark',
                                        'sakit' => 'bg-info text-dark',
                                        'alpa' => 'bg-danger',
                                    ];
                                    $badgeClass = $badgeMap[$jenisKey] ?? 'bg-secondary';
                                @endphp
                                <tr>
                                    <td class="text-center fw-semibold">{{ $i + 1 }}</td>
                                    <td class="fw-medium text-dark">{{ $row['nama'] }}</td>
                                    <td class="text-secondary">{{ $row['nis'] }}</td>
                                    <td>{{ $row['tanggal'] }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $badgeClass }}">{{ $jenisLabel }}</span>
                                    </td>
                                    <td>{{ $row['keterangan'] }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-sm btn-outline-primary">Setujui</button>
                                            <button class="btn btn-sm btn-outline-danger">Tolak</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">Tidak ada permohonan izin/sakit.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
