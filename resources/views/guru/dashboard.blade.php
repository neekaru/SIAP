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
        html,body{height:100%;margin:0;font-family:Arial, Helvetica, sans-serif;color:var(--text);background:transparent}
        .wrap{min-height:100%;padding:28px}
        header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
        .brand{display:flex;align-items:center;gap:12px}
        .profile{display:flex;align-items:center;gap:12px}

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
    <div class="img-background"></div>
    <div class="wrap" style="z-index: 1; position: relative">
        <nav class="navbar navbar-expand-lg navbar-light mb-4 rounded shadow-sm" style="padding: 0.75rem 1.5rem; background: #fff;">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo" class="me-2" style="width:64px; height:64px; border-radius:8px; object-fit:cover; display:inline-block;">
                    <span class="mx-2"></span>
                    <span class="school fs-5">{{ strtoupper(env('NAMA_SEKOLAH')) }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="avatar d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;border-radius:50%;background:#efefef;">Img</span>
                    <span class="welcome me-3" style="line-height:1.2;">Selamat datang<br><strong>Nama Guru</strong></span>
                    <form method="POST" action="{{ route('logout.post') }}" style="display:inline">
                        @csrf
                        <button type="submit" class="logout btn btn-outline-secondary btn-sm">Logout</button>
                    </form>
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
            <a href="{{ route('guru.kehadiran') }}" class="action-btn text-decoration-none text-dark">
                Data Kehadiran
            </a>
            <a href="{{ route('guru.izin_sakit') }}" class="action-btn text-decoration-none text-dark">
                Mengelola Izin dan Sakit
            </a>
        </div>

    <div class="big-action" id="open-report">Lihat Laporan Absensi</div>

        <div class="panel">
            <h5>Absen Hari ini</h5>
            <div style="height:160px;border:1px dashed #eee;margin-top:12px;border-radius:6px;padding:12px;background:#fafafa;overflow-y:auto">
                @forelse($today_attendance ?? [] as $attendance)
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:6px 0;border-bottom:1px solid #eee;font-size:14px;">
                        <div>
                            <strong>{{ $attendance['nama'] }}</strong><br>
                            <small class="text-muted">NIS: {{ $attendance['nis'] }}</small>
                        </div>
                        <div style="text-align:right;">
                            <span class="badge {{ $attendance['status'] == 'Hadir' ? 'bg-success' : ($attendance['status'] == 'Izin' ? 'bg-warning' : 'bg-danger') }}">
                                {{ $attendance['status'] }}
                            </span><br>
                            <small class="text-muted">{{ $attendance['waktu'] != '-' ? $attendance['waktu'] : 'Tidak hadir' }}</small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Tidak ada data yang ditampilkan.</p>
                @endforelse
            </div>
        </div>
    </div>

        <!-- Report Modal -->
        <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportModalLabel">Generate Laporan Absensi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                                <div class="col-md-6">
                                        <label class="form-label">Tanggal Mulai</label>
                                        <input type="date" class="form-control" id="report-start" value="2025-09-25" />
                                </div>
                                <div class="col-md-6">
                                        <label class="form-label">Tanggal Akhir</label>
                                        <input type="date" class="form-control" id="report-end" value="2025-09-26" />
                                </div>

                                <div class="col-12">
                                        <label class="form-label">Jenis laporan</label>
                                        <select class="form-select" id="report-type">
                                                <option value="harian">Laporan Harian</option>
                                                <option value="mingguan">Laporan Mingguan</option>
                                        </select>
                                </div>

                                <div class="col-12">
                                        <label class="form-label">Format Laporan</label>
                                        <select class="form-select" id="report-format">
                                                <option value="pdf">PDF</option>
                                                <option value="csv">CSV</option>
                                        </select>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" id="generate-report" class="btn btn-primary">Generate Laporan</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
                (function(){
                        const openBtn = document.getElementById('open-report');
                        const reportModalEl = document.getElementById('reportModal');
                        const reportModal = new bootstrap.Modal(reportModalEl);
                        if (openBtn) openBtn.addEventListener('click', function(){ reportModal.show(); });

                        document.getElementById('generate-report').addEventListener('click', function(){
                                const start = document.getElementById('report-start').value;
                                const end = document.getElementById('report-end').value;
                                const type = document.getElementById('report-type').value;
                                const format = document.getElementById('report-format').value;
                                // For now just show an alert. In a real app you would POST and trigger download.
                                alert('Generate laporan: ' + type + ' (' + start + ' - ' + end + ') format: ' + format);
                                reportModal.hide();
                        });
                })();
        </script>
</body>
</html>
