<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin</title>
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

    .stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-bottom:28px}
    .stat{background:#fff;padding:26px;border-radius:18px;box-shadow:0 6px 18px rgba(0,0,0,0.06);text-align:left}
    .stat .label{font-size:16px;color:#444}
    .stat .value{font-size:32px;font-weight:600;margin-top:8px}

    .actions{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:28px;align-items:center}
    .action-btn{background:#fff;padding:18px;border-radius:8px;text-align:center;font-size:18px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(0,0,0,0.04)}

    .report-btn{background:#fff;padding:22px;border-radius:10px;text-align:center;font-size:20px;margin:18px 0;box-shadow:0 6px 18px rgba(0,0,0,0.06);cursor:pointer}

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
                    <span class="logo d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;background:#eee;border:1px solid #ddd;">Logo</span>
                    <span class="mx-2"></span>
                    <span class="school fs-5">{{ strtoupper(env('NAMA_SEKOLAH')) }}</span>
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

    <h2 class="mb-4">Dashboard Admin</h2>

        <div class="stats-grid">
            <div class="stat">
                <div class="label">Total Siswa</div>
                <div class="value">{{ $total_siswa ?? '-' }}</div>
            </div>
            <div class="stat">
                <div class="label">Total Guru</div>
                <div class="value">{{ $total_guru ?? '-' }}</div>
            </div>
            <div class="stat">
                <div class="label">Total Kelas</div>
                <div class="value">{{ $total_kelas ?? '-' }}</div>
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('admin.siswa') }}" class="action-btn text-decoration-none text-dark" style="color:#000">
            Manajemen Siswa
            </a>
            <a href="{{ route('admin.guru') }}" class="action-btn text-decoration-none text-dark" style="color:#000">
            Manajemen Guru
            </a>
            <a href="{{ route('admin.kelas') }}" class="action-btn text-decoration-none text-dark" style="color:#000">
            Manajemen Kelas
            </a>
        </div>
        <div class="w-100 d-flex justify-content-center">
            <button type="button" class="action-btn text-decoration-none text-dark w-100" style="border:none;background:#fff;" data-bs-toggle="modal" data-bs-target="#laporanModal">
                Laporan Absensi
            </button>
        </div>
    </div>

    <!-- end .wrap -->

    <!-- Laporan Modal -->
    <div class="modal fade" id="laporanModal" tabindex="-1" aria-labelledby="laporanModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="laporanModalLabel">Buat Laporan Absensi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Jenis laporan</label>
                            <select class="form-select" id="laporan-type">
                                <option value="harian">Laporan Harian</option>
                                <option value="mingguan">Laporan Mingguan</option>
                            </select>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="laporan-start" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col">
                                <label class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control" id="laporan-end" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Format Laporan</label>
                            <div class="d-flex gap-3 mt-2">
                                <button type="button" class="btn btn-success flex-fill" id="format-pdf">PDF</button>
                                <button type="button" class="btn btn-outline-success flex-fill" id="format-excel">Excel</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" id="generate-laporan" class="btn btn-primary">Generate Laporan</button>
                    </div>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function(){
                document.addEventListener('DOMContentLoaded', function(){
                    // Ensure modal is appended to body to avoid stacking-context issues
                    try {
                        const modalEl = document.getElementById('laporanModal');
                        if (modalEl && modalEl.parentElement !== document.body) {
                            document.body.appendChild(modalEl);
                        }
                    } catch (err) {
                        // ignore in non-browser environments
                        console && console.warn && console.warn('Could not move modal to body', err);
                    }

                    const pdfBtn = document.getElementById('format-pdf');
                    const excelBtn = document.getElementById('format-excel');
                    let selectedFormat = 'pdf';

                    function selectFormat(fmt){
                        selectedFormat = fmt;
                        if (!pdfBtn || !excelBtn) return;
                        if(fmt === 'pdf'){
                            pdfBtn.classList.remove('btn-outline-success'); pdfBtn.classList.add('btn-success');
                            excelBtn.classList.remove('btn-success'); excelBtn.classList.add('btn-outline-success');
                        } else {
                            excelBtn.classList.remove('btn-outline-success'); excelBtn.classList.add('btn-success');
                            pdfBtn.classList.remove('btn-success'); pdfBtn.classList.add('btn-outline-success');
                        }
                    }

                    if (pdfBtn) pdfBtn.addEventListener('click', function(){ selectFormat('pdf'); });
                    if (excelBtn) excelBtn.addEventListener('click', function(){ selectFormat('excel'); });

                    // initialize selection each time modal is shown
                    const modalEl = document.getElementById('laporanModal');
                    if (modalEl) {
                        modalEl.addEventListener('shown.bs.modal', function(){
                            // reset to default pdf on open
                            selectedFormat = 'pdf';
                            selectFormat(selectedFormat);
                        });
                    }

                    const genBtn = document.getElementById('generate-laporan');
                    if (genBtn) {
                        genBtn.addEventListener('click', function(){
                            const startEl = document.getElementById('laporan-start');
                            const endEl = document.getElementById('laporan-end');
                            const typeEl = document.getElementById('laporan-type');
                            const start = startEl ? startEl.value : '';
                            const end = endEl ? endEl.value : '';
                            const type = typeEl ? typeEl.value : '';
                            // TODO: replace alert with proper POST/download and validation
                            alert('Generate laporan: ' + type + ' (' + start + ' - ' + end + ') format: ' + selectedFormat);
                            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                            modal.hide();
                        });
                    }
                });
            })();
    </script>
</body>
</html>
