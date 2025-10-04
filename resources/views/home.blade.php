<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIAP - Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root{--bg:#dcdcdc;--text:#1a1a1a}
        html,body{height:100%;margin:0;font-family:Arial, Helvetica, sans-serif;color:var(--text)}
        .page{
            height:100%;
            display:flex;
            align-items:center;
            justify-content:center;
            position:relative;
        }
        .custom-card{background:linear-gradient(#e9e9e9,#f4f4f4);box-shadow:0 2px 6px rgba(0,0,0,0.05)}

        /* Responsive adjustments for mobile */
        @media (max-width: 768px) {
            .card-body {
                padding: 2rem 1rem !important;
            }
            .actions {
                flex-direction: column !important;
                gap: 1rem !important;
                align-items: center;
            }
            .btn {
                width: 100% !important;
                max-width: 250px;
                min-width: 200px !important;
            }
            h1 {
                font-size: 1.5rem !important;
                margin-bottom: 2rem !important;
            }
        }

        @media (max-width: 576px) {
            .custom-card {
                width: 95% !important;
                margin: 0 auto;
            }
            .btn span {
                font-size: 0.9rem;
            }
            .img-background {
                background-position: center center;
            }
        }

        /* Vertical button layout styles */
        .btn.d-flex.flex-column {
            transition: transform 0.2s ease;
        }

        .btn.d-flex.flex-column:hover {
            transform: translateY(-2px);
        }

        .btn .fs-4 {
            font-size: 2rem !important;
        }

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
            z-index: -2;
        }

        /* Content overlay to ensure card readability */
        .img-background::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(2px);
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="img-background"></div>
        <div class="card custom-card border-0" style="width: 90%; max-width: 1100px; position: relative; z-index: 1;">
                <div class="card-body text-center p-5">
                    <h1 class="card-title mb-4 fw-normal">Silahkan Melakukan Login</h1>
                    <div class="actions d-flex justify-content-center gap-3 flex-wrap">
                        <a href="/login/guru" class="btn btn-success btn-lg px-4 py-3 d-flex flex-column align-items-center" role="button" style="min-width: 120px;">
                            <i class="fas fa-chalkboard fs-4 mb-2"></i>
                            <span>Login Guru</span>
                        </a>
                        <a href="/login/siswa" class="btn btn-danger btn-lg px-4 py-3 d-flex flex-column align-items-center" role="button" style="min-width: 120px;">
                            <i class="fas fa-user-graduate fs-4 mb-2"></i>
                            <span>Login Siswa</span>
                        </a>
                        <a href="/login/admin" class="btn btn-primary btn-lg px-4 py-3 d-flex flex-column align-items-center" role="button" style="min-width: 120px;">
                            <i class="fas fa-user-cog fs-4 mb-2"></i>
                            <span>Login Admin</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>