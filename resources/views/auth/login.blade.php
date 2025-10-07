<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ $role }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root{--bg:#dcdcdc;--text:#1a1a1a}
        html,body{height:100%;margin:0;font-family:Arial, Helvetica, sans-serif;color:var(--text)}
        .page{height:100%;display:flex;align-items:center;justify-content:center;background:var(--bg)}
        .custom-card{background:#ffffff;box-shadow:0 2px 6px rgba(0,0,0,0.06)}
        .logo-placeholder{width:100px;height:60px;background:#e0e0e0;margin:0 auto 20px;display:flex;align-items:center;justify-content:center;border-radius:4px}

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .custom-card {
                width: 95% !important;
                margin: 0 auto;
            }
        }

        /** Background image styles **/
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
    </style>
</head>
<body>
    <div class="page">
        <div class="img-background"></div>
        <div class="card custom-card border-0" style="width: 420px; z-index: 1; position: relative;">
            <div class="card-body text-center p-4">
                <img src="{{ asset('img/logo.jpg') }}" alt="Logo" class="img-fluid" style="width:120px; height:auto; margin:0 auto 20px; display:block;">
                <h2 class="card-title mb-4 fw-normal">Login {{ $role }}</h2>
                 <form method="POST" action="{{ route('login.post', strtolower($role)) }}">
                     @csrf
                     @if ($errors->any())
                         <div class="alert alert-danger">
                             {{ $errors->first() }}
                         </div>
                     @endif
                    <div class="mb-3">
                        <input type="email" name="email" placeholder="Email" class="form-control form-control-lg text-center" />
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" placeholder="Password" class="form-control form-control-lg text-center" />
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-lg w-100">LOGIN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>