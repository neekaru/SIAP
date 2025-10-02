<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Siswa Dashboard</title>
    <style>
        :root{--bg:#dcdcdc;--panel:#ffffff;--muted:#cfcfcf;--accent:#f6a2a2;--text:#111}
        html,body{height:100%;margin:0;font-family:Arial, Helvetica, sans-serif;color:var(--text)}
        .wrap{min-height:100%;background:var(--bg);padding:18px}
        header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
        .brand{display:flex;align-items:center;gap:12px}
        .brand .logo{width:36px;height:36px;background:#eee;border:1px solid #ddd;display:flex;align-items:center;justify-content:center}
        .profile{display:flex;align-items:center;gap:12px}
        .profile .avatar{width:36px;height:36px;border-radius:50%;background:#efefef;display:flex;align-items:center;justify-content:center}
        .profile .logout{padding:6px 10px;background:#f3f3f3;border-radius:4px;border:1px solid #ddd}

        .status{border:2px solid #000;padding:14px;background:transparent;display:flex;justify-content:space-between;align-items:center;margin-bottom:28px}
        .status-left{display:flex;align-items:center;gap:12px}
        .status-dot{width:14px;height:14px;border-radius:50%;background:#2ecc40}
        .status-right{font-size:18px}

        .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px}
        .card{background:var(--accent);padding:28px;text-align:center}
        .card .icon-outer{width:80px;height:80px;border-radius:50%;background:#e9e9e9;margin:0 auto 18px;display:flex;align-items:center;justify-content:center}
        .card-label{margin-top:6px}

        @media (max-width:900px){.grid{grid-template-columns:repeat(1,1fr)}}
    </style>
</head>
<body>
    <div class="wrap">
        <header>
            <div class="brand">
                <div class="logo">Logo</div>
                <div class="school">Nama Sekolah</div>
            </div>
            <div class="profile">
                <div class="avatar">Img</div>
                <div class="welcome">Selamat datang<br><strong>Nama Siswa</strong></div>
                <div class="logout">Logout</div>
            </div>
        </header>

        <div class="status">
            <div class="status-left">
                <div>
                    <div style="font-weight:600">Status kehadiran Hari ini</div>
                    <div style="margin-top:8px"><span class="status-dot"></span> &nbsp; Belum Absen &nbsp; &nbsp; Tanggal Hari ini</div>
                </div>
            </div>
            <div class="status-right">Jam Hari ini : 23:59 WIB</div>
        </div>

        <div class="grid">
            <div class="card">
                <div class="icon-outer">icon</div>
                <div class="card-label">Absen Masuk</div>
            </div>
            <div class="card">
                <div class="icon-outer">icon</div>
                <div class="card-label">Absen Pulang</div>
            </div>
            <div class="card">
                <div class="icon-outer">icon</div>
                <div class="card-label">Izin/Sakit</div>
            </div>
        </div>
    </div>
</body>
</html>