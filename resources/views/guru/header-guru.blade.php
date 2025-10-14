<nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm rounded-3 px-4 py-3">
    <div class="container-fluid">
        <span class="navbar-brand d-flex align-items-center gap-3">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo sekolah" class="navbar-brand-logo">
            <span class="fs-5 text-uppercase fw-semibold">{{ strtoupper(env('NAMA_SEKOLAH', config('app.name', 'Nama Sekolah'))) }}</span>
        </span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#guruNavbar" aria-controls="guruNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="guruNavbar">
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