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
                        <label for="email" class="form-label fw-semibold text-start d-block">Email</label>
                        <input type="email" name="email" id="email" placeholder="Masukkan email Anda" class="form-control form-control-lg" required />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold text-start d-block">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" placeholder="Masukkan password Anda" class="form-control form-control-lg border-end-0" required />
                            <span class="input-group-text bg-white border-start-0" style="cursor: pointer;" onclick="togglePassword()">
                                <svg id="password-eye-closed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                                    <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                                    <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                                    <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.708zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                                </svg>
                                <svg id="password-eye-open" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye d-none" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.173 8z"/>
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                </svg>
                            </span>
                        </div>
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

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeClosed = document.getElementById('password-eye-closed');
            const eyeOpen = document.getElementById('password-eye-open');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeClosed.classList.add('d-none');
                eyeOpen.classList.remove('d-none');
            } else {
                passwordInput.type = 'password';
                eyeClosed.classList.remove('d-none');
                eyeOpen.classList.add('d-none');
            }
        }

        // Optional: Add Enter key support for form submission
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const emailInput = document.getElementById('email');

            passwordInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.querySelector('button[type="submit"]').click();
                }
            });

            emailInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    passwordInput.focus();
                }
            });
        });
    </script>
</body>
</html>