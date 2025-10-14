<nav class="navbar navbar-expand-lg navbar-light mb-4 rounded shadow-sm" style="padding: 0.75rem 1.5rem; background: #fff;">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo" class="me-2" style="width:64px; height:64px; border-radius:8px; object-fit:cover; display:inline-block;">
            <span class="mx-2"></span>
            <span class="school fs-5">{{ strtoupper(env('NAMA_SEKOLAH', config('app.name', 'Nama Sekolah'))) }}</span>
        </div>
        <div class="d-flex align-items-center">
            <span class="avatar d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;border-radius:50%;background:#efefef;">Img</span>
            <span class="welcome me-3" style="line-height:1.2;">Selamat datang<br><strong>{{ \App\Models\DataAdmin::where('user_id', auth()->id())->value('nama') ?? (auth()->user()->name ?? 'Admin') }}</strong></span>
            <form method="POST" action="{{ route('logout.post') }}" style="display:inline">
                @csrf
                <button type="submit" class="logout btn btn-outline-secondary btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>