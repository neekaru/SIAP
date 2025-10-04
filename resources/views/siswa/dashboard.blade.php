<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Siswa Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root{--bg:#dcdcdc;--panel:#ffffff;--muted:#cfcfcf;--accent:#f6a2a2;--text:#111}
        html,body{height:100%;margin:0;font-family:Arial, Helvetica, sans-serif;color:var(--text)}
        .wrap{min-height:100%;background:var(--bg);padding:18px}
        header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
        .brand{display:flex;align-items:center;gap:12px}
        .brand .logo{width:36px;height:36px;background:#eee;border:1px solid #ddd;display:flex;align-items:center;justify-content:center}
        .profile{display:flex;align-items:center;gap:12px}
        .profile .avatar{width:36px;height:36px;border-radius:50%;background:#efefef;display:flex;align-items:center;justify-content:center}
        .profile .logout{padding:6px 10px;background:#f3f3f3;border-radius:4px;border:1px solid #ddd}

        .status{border:2px solid #000;padding:14px;background:transparent;display:flex;justify-content:space-between;align-items:center;margin-bottom:28px}
        .status-left{display:flex;align-items:center;gap:12px}
        .status-dot{width:14px;height:14px;border-radius:50%;background:#2ecc40}
        .status-right{font-size:18px}

        .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px}
        .card{background:var(--accent);padding:28px;text-align:center}
        .card .icon-outer{width:80px;height:80px;border-radius:50%;background:#e9e9e9;margin:0 auto 18px;display:flex;align-items:center;justify-content:center}
        .card-label{margin-top:6px}

        @media (max-width:900px){.grid{grid-template-columns:repeat(1,1fr)}}
    </style>
</head>
<body>
    <div class="wrap">
        <header>
            <div class="brand">
                <div class="logo">Logo</div>
                <div class="school">Nama Sekolah</div>
            </div>
            <div class="profile">
                <div class="avatar">Img</div>
                <div class="welcome">Selamat datang<br><strong>Nama Siswa</strong></div>
                <div class="logout">Logout</div>
            </div>
        </header>

        <div class="status">
            <div class="status-left">
                <div>
                    <div style="font-weight:600">Status kehadiran Hari ini</div>
                    <div style="margin-top:8px"><span class="status-dot"></span> &nbsp; Belum Absen &nbsp; &nbsp; Tanggal Hari ini</div>
                </div>
            </div>
            <div class="status-right">Jam Hari ini : 23:59 WIB</div>
        </div>

        <div class="grid">
            <div class="card" id="card-absen-masuk" style="cursor:pointer">
                <div class="icon-outer">icon</div>
                <div class="card-label">Absen Masuk</div>
            </div>
            <div class="card" id="card-absen-pulang" style="cursor:pointer">
                <div class="icon-outer">icon</div>
                <div class="card-label">Absen Pulang</div>
            </div>
            <div class="card">
                <div class="icon-outer">icon</div>
                <div class="card-label">Izin/Sakit</div>
            </div>
        </div>
    </div>

    <!-- Izin/Sakit Modal -->
    <div id="modal-izin-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);align-items:center;justify-content:center;z-index:45">
        <div style="background:#fff;width:640px;max-width:96%;padding:22px;box-shadow:0 8px 30px rgba(0,0,0,0.2)">
            <div style="text-align:center;margin-bottom:12px;font-size:20px;font-weight:600">Pilih Jenis Permohonan</div>
            <div style="display:flex;gap:18px;justify-content:center;margin-bottom:12px">
                <label style="display:flex;align-items:center;gap:8px;background:#f3f3f3;padding:16px;width:180px;justify-content:center;cursor:pointer">
                    <input type="radio" name="izin_type" value="izin" checked />
                    <div>Izin</div>
                </label>
                <label style="display:flex;align-items:center;gap:8px;background:#f3f3f3;padding:16px;width:180px;justify-content:center;cursor:pointer">
                    <input type="radio" name="izin_type" value="sakit" />
                    <div>Sakit</div>
                </label>
            </div>

            <div style="margin-bottom:8px">
                <div style="font-size:12px;margin-bottom:6px">Tanggal</div>
                <input type="date" id="izin-date" style="width:100%;padding:10px;border:1px solid #ddd" />
            </div>

            <div style="margin-bottom:8px">
                <div style="font-size:12px;margin-bottom:6px">Alasan / Keterangan</div>
                <textarea id="izin-reason" rows="5" style="width:100%;padding:10px;border:1px solid #ddd"></textarea>
            </div>

            <div style="margin-bottom:12px">
                <div style="font-size:12px;margin-bottom:6px">Surat Keterangan (Optional)</div>
                <input type="file" id="izin-file" />
            </div>

            <div style="display:flex;gap:18px;justify-content:center">
                <button id="btn-submit-izin" style="padding:10px 18px">Ajukan Permohonan</button>
                <button id="btn-cancel-izin" style="padding:10px 18px">Batal</button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);align-items:center;justify-content:center;z-index:40">
        <div id="modal" style="background:#fff;width:720px;max-width:92%;padding:22px;box-shadow:0 8px 30px rgba(0,0,0,0.2)">
            <div style="background:#e9e9e9;padding:18px;text-align:center;margin-bottom:12px">
                <div style="font-size:18px">Waktu Absen</div>
                <div style="font-size:28px;font-weight:600;margin-top:8px">23:59 WIB</div>
                <div style="margin-top:6px;color:#555">Wednesday, 24 September 2025</div>
            </div>

            <div id="masuk-lokasi-live" style="background:#efefef;padding:12px;margin-bottom:10px">
                <div id="masuk-location-text">Lokasi Live<br><small>Lokasi sedang dilacak secara real-time</small></div>
                <div style="float:right"><span id="masuk-accuracy">Akurasi: -</span></div>
                <div style="clear:both"></div>
            </div>

            <div style="border:1px solid #ddd;padding:12px;margin-bottom:12px">
                <div style="font-weight:600">Konfirmasi Lokasi</div>
                <div style="margin-top:6px">Klik "Konfirmasi Lokasi" untuk memverifikasi posisi Anda</div>
                <div style="text-align:right;margin-top:8px"><button id="btn-confirm-location">Konfirmasi Lokasi</button></div>
            </div>

            <div style="background:#e9e9e9;height:180px;display:flex;align-items:center;justify-content:center;margin-bottom:16px">Maps</div>

            <div style="display:flex;gap:18px;justify-content:center">
                <button id="btn-confirm-absen" style="padding:10px 18px" disabled>Konfirmasi Absen Masuk</button>
                <button id="btn-cancel" style="padding:10px 18px">Batal</button>
            </div>
        </div>
    </div>

    <script>
        const card = document.getElementById('card-absen-masuk');
        const overlay = document.getElementById('modal-overlay');
        const btnCancel = document.getElementById('btn-cancel');
        const btnConfirm = document.getElementById('btn-confirm-absen');

        card.addEventListener('click', function () {
            overlay.style.display = 'flex';
        });

        btnCancel.addEventListener('click', function () {
            overlay.style.display = 'none';
        });

        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) overlay.style.display = 'none';
        });

        btnConfirm.addEventListener('click', function () {
            if (!window._masukLocation) { alert('Silakan konfirmasi lokasi terlebih dahulu'); return; }
            fetch('/absen/masuk', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({location: window._masukLocation})
            }).then(r => r.json()).then(data => {
                alert('Absen masuk berhasil');
                overlay.style.display = 'none';
            }).catch(err => { alert('Gagal: ' + err); });
        });

        // Absen pulang modal
        const cardPulang = document.getElementById('card-absen-pulang');
        // create pulang overlay & modal elements
        const pulangOverlay = document.createElement('div');
        pulangOverlay.id = 'modal-overlay-pulang';
        pulangOverlay.style.cssText = 'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);align-items:center;justify-content:center;z-index:40';
        pulangOverlay.innerHTML = `
            <div style="background:#fff;width:720px;max-width:92%;padding:22px;box-shadow:0 8px 30px rgba(0,0,0,0.2)">
                <div style="background:#e9e9e9;padding:18px;text-align:center;margin-bottom:12px">
                    <div style="font-size:18px">Waktu Absen Pulang</div>
                    <div style="font-size:28px;font-weight:600;margin-top:8px">16:30 WIB</div>
                    <div style="margin-top:6px;color:#555">Wednesday, 24 September 2025</div>
                </div>
                <div id="pulang-lokasi-live" style="background:#efefef;padding:12px;margin-bottom:10px">
                    <div id="pulang-location-text">Lokasi Live<br><small>Lokasi sedang dilacak secara real-time</small></div>
                    <div style="float:right"><span id="pulang-accuracy">Akurasi: -</span></div>
                    <div style="clear:both"></div>
                </div>

                <div style="border:1px solid #ddd;padding:12px;margin-bottom:12px">
                    <div style="font-weight:600">Konfirmasi Lokasi</div>
                    <div style="margin-top:6px">Klik "Konfirmasi Lokasi" untuk memverifikasi posisi Anda</div>
                    <div style="text-align:right;margin-top:8px"><button id="btn-confirm-location-pulang">Konfirmasi Lokasi</button></div>
                </div>

                <div style="background:#e9e9e9;height:140px;display:flex;align-items:center;justify-content:center;margin-bottom:16px">Maps</div>
                <div style="display:flex;gap:18px;justify-content:center">
                    <button id="btn-confirm-pulang" style="padding:10px 18px" disabled>Konfirmasi Absen Pulang</button>
                    <button id="btn-cancel-pulang" style="padding:10px 18px">Batal</button>
                </div>
            </div>`;
        document.body.appendChild(pulangOverlay);

        cardPulang.addEventListener('click', function () {
            pulangOverlay.style.display = 'flex';
        });

        pulangOverlay.addEventListener('click', function (e) {
            if (e.target === pulangOverlay) pulangOverlay.style.display = 'none';
        });

        document.getElementById('btn-confirm-pulang').addEventListener('click', function () {
            if (!window._pulangLocation) { alert('Silakan konfirmasi lokasi terlebih dahulu'); return; }
            fetch('/absen/pulang', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({location: window._pulangLocation})
            }).then(r => r.json()).then(data => {
                alert('Absen pulang berhasil');
                pulangOverlay.style.display = 'none';
            }).catch(err => { alert('Gagal: ' + err); });
        });

        document.getElementById('btn-cancel-pulang').addEventListener('click', function () {
            pulangOverlay.style.display = 'none';
        });

        // Konfirmasi lokasi handler for pulang
        document.getElementById('btn-confirm-location-pulang').addEventListener('click', function () {
            // Attempt to get current position and update UI
            if (!navigator.geolocation) {
                alert('Geolocation tidak didukung di browser Anda');
                return;
            }
            const accEl = document.getElementById('pulang-accuracy');
            const locText = document.getElementById('pulang-location-text');
            accEl.innerText = 'Mencari posisi...';
            navigator.geolocation.getCurrentPosition(function (pos) {
                const lat = pos.coords.latitude.toFixed(6);
                const lon = pos.coords.longitude.toFixed(6);
                const accuracy = Math.round(pos.coords.accuracy) + ' m';
                accEl.innerText = 'Akurasi: ' + accuracy;
                locText.innerHTML = 'Posisi: ' + lat + ', ' + lon + '<br><small>Lokasi berhasil didapatkan</small>';
                // enable pulang confirm button and store location
                const btnPulang = document.getElementById('btn-confirm-pulang');
                if (btnPulang) { btnPulang.disabled = false; }
                window._pulangLocation = {lat: lat, lon: lon, accuracy: accuracy};
                const confirmLocBtnPulang = document.getElementById('btn-confirm-location-pulang');
                if (confirmLocBtnPulang) { confirmLocBtnPulang.innerText = 'Terverifikasi'; }
            }, function (err) {
                accEl.innerText = 'Akurasi: -';
                alert('Gagal mendapatkan lokasi: ' + (err.message || 'unknown'));
            }, {enableHighAccuracy: true, timeout: 10000});
        });

        // Konfirmasi lokasi handler for masuk
        document.getElementById('btn-confirm-location').addEventListener('click', function () {
            if (!navigator.geolocation) {
                alert('Geolocation tidak didukung di browser Anda');
                return;
            }
            const accEl = document.getElementById('masuk-accuracy');
            const locText = document.getElementById('masuk-location-text');
            accEl.innerText = 'Mencari posisi...';
            navigator.geolocation.getCurrentPosition(function (pos) {
                const lat = pos.coords.latitude.toFixed(6);
                const lon = pos.coords.longitude.toFixed(6);
                const accuracy = Math.round(pos.coords.accuracy) + ' m';
                accEl.innerText = 'Akurasi: ' + accuracy;
                locText.innerHTML = 'Posisi: ' + lat + ', ' + lon + '<br><small>Lokasi berhasil didapatkan</small>';
                // enable masuk confirm button and store location
                const btnMasuk = document.getElementById('btn-confirm-absen');
                if (btnMasuk) { btnMasuk.disabled = false; }
                window._masukLocation = {lat: lat, lon: lon, accuracy: accuracy};
                const confirmLocBtnMasuk = document.getElementById('btn-confirm-location');
                if (confirmLocBtnMasuk) { confirmLocBtnMasuk.innerText = 'Terverifikasi'; }
            }, function (err) {
                accEl.innerText = 'Akurasi: -';
                alert('Gagal mendapatkan lokasi: ' + (err.message || 'unknown'));
            }, {enableHighAccuracy: true, timeout: 10000});
        });

            // Izin/Sakit modal
            const izinCard = document.querySelector('.card .card-label + .card-label, .card');
            // open via the third card (Izin/Sakit)
            const cards = document.querySelectorAll('.grid .card');
            const izinCardEl = cards[2];
            const izinOverlay = document.getElementById('modal-izin-overlay');
            const btnCancelIzin = document.getElementById('btn-cancel-izin');
            const btnSubmitIzin = document.getElementById('btn-submit-izin');

            if (izinCardEl) {
                izinCardEl.addEventListener('click', function () {
                    izinOverlay.style.display = 'flex';
                });
            }

            btnCancelIzin.addEventListener('click', function () {
                izinOverlay.style.display = 'none';
            });

            btnSubmitIzin.addEventListener('click', function () {
                const type = document.querySelector('input[name="izin_type"]:checked').value;
                const date = document.getElementById('izin-date').value;
                const reason = document.getElementById('izin-reason').value.trim();
                const fileInput = document.getElementById('izin-file');
                if (!date) { alert('Pilih tanggal'); return; }
                if (!reason) { alert('Masukkan alasan atau keterangan'); return; }

                const formData = new FormData();
                formData.append('type', type);
                formData.append('date', date);
                formData.append('reason', reason);
                if (fileInput.files[0]) { formData.append('file', fileInput.files[0]); }

                fetch('/izin/request', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                }).then(r => r.json()).then(data => {
                    alert('Permohonan terkirim');
                    izinOverlay.style.display = 'none';
                }).catch(err => { alert('Gagal: ' + err); });
            });
    </script>
</body>
</html>