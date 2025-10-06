<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Guru</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root{--panel:#ffffff;--muted:#cfcfcf;--accent:#f6f6f6;--text:#111}
        html,body{height:100%;margin:0;font-family:Arial, Helvetica, sans-serif;color:var(--text);background:#e9e9e9}
        .wrap{min-height:100%;padding:28px}
        header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
        .brand{display:flex;align-items:center;gap:12px}
        .profile{display:flex;align-items:center;gap:12px}

        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:28px}
        .stat{background:#fff;padding:18px;border-radius:14px;box-shadow:0 2px 8px rgba(0,0,0,0.06);text-align:left}
        .stat .label{font-size:14px;color:#333}
        .stat .value{font-size:28px;font-weight:600;margin-top:6px}

        .actions{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px}
        .action-btn{background:#fff;padding:18px;border-radius:8px;text-align:center;font-size:20px}

        .big-action{background:#fff;padding:18px;border-radius:8px;text-align:center;font-size:20px;margin-bottom:20px}

        .panel{background:#fff;padding:18px;border-radius:8px;min-height:220px}

        @media (max-width:900px){.stats-grid{grid-template-columns:repeat(1,1fr)}.actions{grid-template-columns:repeat(1,1fr)}}
    </style>
</head>
<body>
    <div class="wrap">
        <nav class="navbar navbar-expand-lg navbar-light mb-4 rounded shadow-sm" style="padding: 0.75rem 1.5rem; background: #fff;">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <span class="logo d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;background:#eee;border:1px solid #ddd;">Logo</span>
                    <span class="mx-2"></span>
                    <span class="school fs-5">{{ strtoupper(env('NAMA_SEKOLAH')) }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="avatar d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;border-radius:50%;background:#efefef;">Img</span>
                    <span class="welcome me-3" style="line-height:1.2;">Selamat datang<br><strong>Nama Guru</strong></span>
                    <a href="#" class="logout btn btn-outline-secondary btn-sm">Logout</a>
                </div>
            </div>
        </nav>

        <h2 class="mb-4">Dashboard Guru</h2>

        <div class="stats-grid">
            <div class="stat">
                <div class="label">Total Siswa</div>
                <div class="value">{{ $total_siswa ?? '-' }}</div>
            </div>
            <div class="stat">
                <div class="label">Hadir</div>
                <div class="value">{{ $hadir ?? '-' }}</div>
            </div>
            <div class="stat">
                <div class="label">Izin/Sakit</div>
                <div class="value">{{ $izin_sakit ?? '-' }}</div>
            </div>
            <div class="stat">
                <div class="label">Belum Absen</div>
                <div class="value">{{ $belum_absen ?? '-' }}</div>
            </div>
        </div>

        <div class="actions">
            <div class="action-btn">Data Kehadiran</div>
            <div class="action-btn">Mengelola Izin dan Sakit</div>
        </div>

        <div class="big-action">Lihat Laporan Absensi</div>

        <div class="panel">
            <h5>Absen Hari ini</h5>
            <div style="height:160px;border:1px dashed #eee;margin-top:12px;border-radius:6px;padding:12px;background:#fafafa">
                <!-- Placeholder area for today's attendance list -->
                <p class="text-muted">Tidak ada data yang ditampilkan.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
