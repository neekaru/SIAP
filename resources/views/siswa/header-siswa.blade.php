<nav class="navbar navbar-expand-lg navbar-light mb-4 rounded shadow-sm" style="padding: 0.75rem 1.5rem; background: #fffbe6; box-shadow: 0 2px 12px rgba(0,0,0,0.10);">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo" class="me-2" style="width:64px; height:64px; border-radius:8px; object-fit:cover; display:inline-block;">
            <span class="mx-2"></span>
            <span class="school fs-5">{{strtoupper(env('NAMA_SEKOLAH'))}}</span>
        </div>
        <div class="d-flex align-items-center">
            <img src="{{ asset('img/siswa.png') }}" alt="Siswa" class="avatar me-2" style="width:36px; height:36px; border-radius:50%; object-fit:cover; display:inline-block;">
            <span class="welcome me-3" style="line-height:1.2;">Selamat datang<br><strong>{{ \App\Models\DataSiswa::where('user_id', auth()->id())->value('nama') ?? (auth()->user()->name ?? 'Siswa') }}</strong></span>
            <form method="POST" action="{{ route('logout.post') }}" style="display:inline">
                @csrf
                <button type="submit" class="logout btn btn-outline-secondary btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>