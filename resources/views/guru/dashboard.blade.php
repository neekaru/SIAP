<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Guru</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root{--panel:#ffffff;--muted:#cfcfcf;--accent:#f6f6f6;--text:#111}
        html,body{height:100%;margin:0;font-family:Arial, Helvetica, sans-serif;color:var(--text);background:transparent}
        .wrap{min-height:100%;padding:28px}
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
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:28px}
        .stat{background:#fff;padding:18px;border-radius:14px;box-shadow:0 2px 8px rgba(0,0,0,0.06);text-align:left;display:flex;align-items:center;gap:16px}
        .stat-icon{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:24px}
        .stat .label{font-size:14px;color:#333}
        .stat .value{font-size:28px;font-weight:600;margin-top:6px}

        .actions{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px}
        .action-btn{background:#fff;padding:18px;border-radius:8px;text-align:center;font-size:20px}

        .big-action{background:#fff;padding:18px;border-radius:8px;text-align:center;font-size:20px;margin-bottom:20px}

        .panel{background:#fff;padding:18px;border-radius:8px;min-height:220px}
        .table-wrap{background:#fff;padding:16px;border-radius:6px}

        @media (max-width:900px){.stats-grid{grid-template-columns:repeat(1,1fr)}.actions{grid-template-columns:repeat(1,1fr)}}
    </style>
</head>
<body>
    <div class="img-background"></div>
    <div class="wrap" style="z-index: 1; position: relative">
        @include('guru.header-guru')

        <div class="table-wrap">
            <h2 class="mb-4 ps-3">Dashboard Guru</h2>

        <div class="stats-grid">
            <div class="stat" style="background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%); color: white;">
                <div class="stat-icon text-white">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="label text-white">Total Siswa</div>
                    <div class="value" id="total-siswa"></div>
                </div>
            </div>
            <div class="stat" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%); color: white;">
                <div class="stat-icon text-white">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <div>
                    <div class="label text-white">Hadir</div>
                    <div class="value" id="total-hadir"></div>
                </div>
            </div>
            <div class="stat" style="background: linear-gradient(135deg, #fd7e14 0%, #d26e04 100%); color: white;">
                <div class="stat-icon text-white">
                    <i class="bi bi-emoji-expressionless-fill"></i>
                </div>
                <div>
                    <div class="label text-white">Izin/Sakit</div>
                    <div class="value" id="total-izin-sakit"></div>
                </div>
            </div>
            <div class="stat" style="background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%); color: white;">
                <div class="stat-icon text-white">
                    <i class="bi bi-question-circle-fill"></i>
                </div>
                <div>
                    <div class="label text-white">Belum Absen</div>
                    <div class="value" id="total-belum-absen"></div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="actions">
        <a href="{{ route('guru.kehadiran') }}" class="action-btn text-decoration-none text-dark">
            <i class="fa-solid fa-calendar-check me-2"></i>
            Data Kehadiran
        </a>
        <a href="{{ route('guru.izin_sakit') }}" class="action-btn text-decoration-none text-dark">
            <i class="fa-solid fa-file-medical me-2"></i>
            Mengelola Izin dan Sakit
        </a>
    </div>

    <div class="big-action" id="open-report">
        <i class="fa-solid fa-file-lines me-2"></i>
        Lihat Laporan Absensi
    </div>

        <div class="panel">
            <h5><i class="fa-solid fa-calendar-day me-2"></i>Absen Hari ini</h5>
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
                        // Statis ticks
                        fetch("{{ route('guru.stats') }}", {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('total-siswa').textContent = data.total_siswa;
                            document.getElementById('total-hadir').textContent = data.hadir;
                            document.getElementById('total-izin-sakit').textContent = data.izin_sakit;
                            document.getElementById('total-belum-absen').textContent = data.belum_absen;
                        })

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
