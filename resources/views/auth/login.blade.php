<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ $role }}</title>
    <style>
        :root{--bg:#dcdcdc;--card:#ffffff;--panel:#efefef;--text:#1a1a1a}
        html,body{height:100%;margin:0;font-family:Arial, Helvetica, sans-serif;color:var(--text)}
        .page{height:100%;display:flex;align-items:center;justify-content:center;background:var(--bg)}
        .card{width:420px;padding:36px 40px;text-align:center;background:var(--card);box-shadow:0 2px 6px rgba(0,0,0,0.06)}
        .logo{width:100px;height:60px;background:#e0e0e0;margin:0 auto 20px;display:flex;align-items:center;justify-content:center}
        .form-row{margin:12px 0}
        .input{display:block;width:80%;max-width:300px;margin:0 auto;padding:12px;background:var(--panel);border:0;border-radius:2px;text-align:center}
        .submit{display:block;width: 100%;max-width:320px;margin:12px auto 0 auto;padding:12px;background:var(--panel);border:0;border-radius:2px;cursor:pointer}
        h2{margin:0 0 18px;font-weight:500}
        @media (max-width:480px){.card{width:90%;padding:24px}}
    </style>
</head>
<body>
    <div class="page">
        <div class="card">
            <div class="logo">LOGO</div>
            <h2>Login {{ $role }}</h2>
            <form method="POST" action="#">
                <div class="form-row">
                    <input type="email" name="email" placeholder="Email" class="input" />
                </div>
                <div class="form-row">
                    <input type="password" name="password" placeholder="Password" class="input" />
                </div>
                <div class="form-row">
                    <button type="submit" class="submit">LOGIN</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>