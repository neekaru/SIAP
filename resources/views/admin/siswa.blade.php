<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Siswa</title>
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
        @include('admin.header-admin')

        
        <div class="table-wrap">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Manajemen Siswa</h2>
                <a href="{{ route('siswa.create') }}" class="btn btn-primary">Tambah Siswa</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <table class="data">
                <thead>
                    <tr>
                        <th class="text-center" style="width:60px">NO</th>
                        <th>Nama</th>
                        <th style="width:160px">NIS</th>
                        <th style="width:200px">Kelas</th>
                        <th style="width:220px">Email</th>
                        <th class="text-center" style="width:180px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa ?? [] as $i => $row)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $row->nama ?? '-' }}</td>
                            <td>{{ $row->nis ?? '-' }}</td>
                            <td>{{ $row->kelas->nama ?? '-' }}</td>
                            <td>{{ $row->user->email ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('siswa.edit', $row->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form method="POST" action="{{ route('siswa.destroy', $row->id) }}" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted" style="padding:48px">Tidak ada data siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>