<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIAP - Home</title>
    <style>
        :root{--bg:#dcdcdc;--card:#f6f6f6;--btn:#ffffff;--text:#1a1a1a}
        html,body{height:100%;margin:0;font-family:Arial, Helvetica, sans-serif;color:var(--text)}
        .page{height:100%;display:flex;align-items:center;justify-content:center;background:var(--bg)}
        .card{width:90%;max-width:1100px;padding:80px 40px;text-align:center;background:linear-gradient(#e9e9e9,#f4f4f4);box-shadow:0 2px 6px rgba(0,0,0,0.05)}
        h1{margin:0 0 48px;font-weight:500;font-size:28px}
        .actions{display:flex;gap:40px;justify-content:center}
        .btn{background:var(--btn);padding:18px 36px;border-radius:4px;border:1px solid rgba(0,0,0,0.06);min-width:160px;cursor:pointer;font-size:16px}
        @media (max-width:640px){.actions{flex-direction:column;gap:20px}.card{padding:48px 20px}h1{font-size:20px}}
    </style>
</head>
<body>
    <div class="page">
        <div class="card">
            <h1>Silahkan Melakukan Login</h1>
            <div class="actions">
                <button class="btn">Login Guru</button>
                <button class="btn">Login Siswa</button>
                <button class="btn">Login Admin</button>
            </div>
        </div>
    </div>
</body>
</html>