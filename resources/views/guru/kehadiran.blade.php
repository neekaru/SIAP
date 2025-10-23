<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Kehadiran - Guru</title>
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
        .table-card{overflow:hidden;box-shadow:0 10px 25px rgba(15,23,42,0.08)}
        .table-card .card-header{background:linear-gradient(90deg,#3b82f6,#6366f1);color:#fff}
        .table-card .table thead th{background:#f8f9fa;font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;color:#475569}
        .table-card .table tbody td{vertical-align:middle}
    </style>
</head>
<body>
    <div class="img-background"></div>
    <div class="wrap container-fluid">
        @include('guru.header-guru')

        <h2 class="section-title text-white fw-semibold mb-4 mt-2">Data Kehadiran</h2>


        <div class="card table-card border-0 bg-white">
            <div class="card-header d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div>
                    <h5 class="card-title mb-0 fw-semibold">Rekap Kehadiran Harian</h5>
                    <small class="opacity-75">Periksa dan kelola status kehadiran siswa di bawah ini.</small>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col" style="width:60px" class="text-center">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col" style="width:160px">NIS</th>
                                <th scope="col" style="width:160px">Waktu</th>
                                <th scope="col" style="width:140px">Status</th>
                                <th scope="col" style="width:180px" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kehadiran as $i => $row)
                                @php
                                    $statusLabel = $row['status'] ?? '-';
                                    $statusKey = strtolower($statusLabel);
                                    $badgeMap = [
                                        'hadir' => 'bg-success',
                                        'izin' => 'bg-warning text-dark',
                                        'sakit' => 'bg-info text-dark',
                                        'alpa' => 'bg-danger',
                                        'alpha' => 'bg-danger',
                                    ];
                                    $badgeClass = $badgeMap[$statusKey] ?? 'bg-secondary';
                                @endphp
                                <tr>
                                    <td class="text-center fw-semibold">{{ $i + 1 }}</td>
                                    <td class="fw-medium text-dark">{{ $row['nama'] ?? '-' }}</td>
                                    <td class="text-secondary">{{ $row['nis'] ?? '-' }}</td>
                                    <td>{{ $row['waktu'] ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if(strtolower($statusLabel) === 'hadir')
                                            <button class="btn btn-sm btn-outline-danger toggle-status" data-current-status="hadir" data-id="{{ $row['id'] ?? '' }}">Alpa</button>
                                        @elseif(in_array(strtolower($statusLabel), ['alpa', 'alpha']))
                                            <button class="btn btn-sm btn-outline-success toggle-status" data-current-status="alpa" data-id="{{ $row['id'] ?? '' }}">Hadir</button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">Tidak ada data kehadiran untuk hari ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle toggle status button clicks
            document.querySelectorAll('.toggle-status').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const currentStatus = this.getAttribute('data-current-status');
                    const row = this.closest('tr');
                    const siswaId = this.getAttribute('data-id');
                    // Ambil tanggal dari waktu sekarang dengan format seperti updated_at (YYYY-MM-DD HH:mm:ss)
                    function getCurrentDateTime() {
                        const now = new Date();
                        const pad = n => n < 10 ? '0' + n : n;
                        const year = now.getFullYear();
                        const month = pad(now.getMonth() + 1);
                        const day = pad(now.getDate());
                        const hours = pad(now.getHours());
                        const minutes = pad(now.getMinutes());
                        const seconds = pad(now.getSeconds());
                        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                    }
                    const tanggal = getCurrentDateTime();

                    let newStatus, confirmText, confirmButtonText, confirmButtonColor;

                    if (currentStatus === 'hadir') {
                        newStatus = 'Alpa';
                        confirmText = 'Apakah anda ingin Alpha ???';
                        confirmButtonText = 'Ya, Alpa';
                        confirmButtonColor = '#dc3545';
                    } else {
                        newStatus = 'Hadir';
                        confirmText = 'Apakah anda ingin ubah ke Hadir ???';
                        confirmButtonText = 'Ya, Hadir';
                        confirmButtonColor = '#28a745';
                    }

                    Swal.fire({
                        title: 'Konfirmasi',
                        text: confirmText,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: confirmButtonColor,
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: confirmButtonText,
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Kirim AJAX POST ke endpoint validasi kehadiran
                            fetch("{{ route('guru.validasi_kehadiran') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                                },
                                body: JSON.stringify({
                                    siswa_id: siswaId,
                                    tanggal: tanggal,
                                    action: newStatus
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire(
                                        'Berhasil!',
                                        `Status siswa telah diubah menjadi ${newStatus}.`,
                                        'success'
                                    ).then(() => {
                                        // Reload halaman agar data terbaru muncul
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        data.message || 'Gagal memvalidasi data absensi.',
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat memproses permintaan.',
                                    'error'
                                );
                            });
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
