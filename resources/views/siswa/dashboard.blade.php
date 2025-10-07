<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Siswa Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root{--panel:#ffffff;--muted:#cfcfcf;--accent:#f6a2a2;--text:#111}
        html,body{height:100%;margin:0;font-family:Arial, Helvetica, sans-serif;color:var(--text);background:transparent}
        .wrap{min-height:100%;padding:18px}
        header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
        .brand{display:flex;align-items:center;gap:12px}
        .profile{display:flex;align-items:center;gap:12px}
        .profile .avatar{width:36px;height:36px;border-radius:50%;background:#efefef;display:flex;align-items:center;justify-content:center}
        .profile .logout{padding:6px 10px;background:#f3f3f3;border-radius:4px;border:1px solid #ddd}

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
    <div class="img-background"></div>
    <div class="wrap">
        <nav class="navbar navbar-expand-lg navbar-light mb-4 rounded shadow-sm" style="padding: 0.75rem 1.5rem; background: #fffbe6; box-shadow: 0 2px 12px rgba(0,0,0,0.10);">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo" class="me-2" style="width:64px; height:64px; border-radius:8px; object-fit:cover; display:inline-block;">
                    <span class="mx-2"></span>
                    <span class="school fs-5">{{strtoupper(env('NAMA_SEKOLAH'))}}</span>
                </div>
                <div class="d-flex align-items-center">
                    <img src="{{ asset('img/siswa.png') }}" alt="Siswa" class="avatar me-2" style="width:36px; height:36px; border-radius:50%; object-fit:cover; display:inline-block;">
                    <span class="welcome me-3" style="line-height:1.2;">Selamat datang<br><strong>Nama Siswa</strong></span>
                    <form method="POST" action="{{ route('logout.post') }}" style="display:inline">
                        @csrf
                        <button type="submit" class="logout btn btn-outline-secondary btn-sm">Logout</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="jumbotron bg-white p-4 mb-4 rounded shadow-sm" style="z-index: 1; position: relative;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-2">Status Kehadiran Hari ini</h5>
                    <div class="d-flex align-items-center">
                        <span class="status-dot me-2" style="width:14px;height:14px;border-radius:50%;background:#2ecc40;display:inline-block"></span>
                        <span class="fw-semibold">Belum Absen</span>
                        <span class="mx-3 text-muted">Tanggal Hari ini</span>
                    </div>
                </div>
                <div class="fs-5" id="current-time">
                    Jam Hari ini :
                </div>
            </div>
        </div>

        <div class="grid">
            <div class="card shadow-sm p-3" id="card-absen-masuk" role="button">
                <div class="d-flex flex-column align-items-center justify-content-center h-100">
                    <div class="icon-outer mb-2">
                        <i class="fa-solid fa-door-open fa-2x text-success"></i>
                    </div>
                    <div class="card-label">Absen Masuk</div>
                </div>
            </div>
            <div class="card shadow-sm p-3" id="card-absen-pulang" role="button">
                <div class="d-flex flex-column align-items-center justify-content-center h-100">
                    <div class="icon-outer mb-2">
                        <i class="fa-solid fa-door-closed fa-2x text-primary"></i>
                    </div>
                    <div class="card-label">Absen Pulang</div>
                </div>
            </div>
            <div class="card shadow-sm p-3" id="card-izin" role="button">
                <div class="d-flex flex-column align-items-center justify-content-center h-100">
                    <div class="icon-outer mb-2">
                        <i class="fa-solid fa-notes-medical fa-2x text-warning"></i>
                    </div>
                    <div class="card-label">Izin/Sakit</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Modals -->

    <!-- Masuk Modal -->
    <div class="modal fade" id="modalMasuk" tabindex="-1" aria-labelledby="modalMasukLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light">
            <h5 class="modal-title" id="modalMasukLabel">Absen Masuk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
                <div class="p-3 mb-3 bg-light rounded text-center">
                <div style="font-size:18px">Waktu Absen</div>
                <div id="masuk-time" style="font-size:28px;font-weight:600;margin-top:8px">--:-- WIB</div>
                <div id="masuk-date" class="text-muted" style="margin-top:6px">--</div>
            </div>

            <div id="masuk-lokasi-live" class="mb-3 p-2 bg-white border rounded">
                <div id="masuk-location-text">Lokasi Live<br><small>Lokasi sedang dilacak secara real-time</small></div>
                <div class="float-end"><span id="masuk-accuracy">Akurasi: -</span></div>
                <div class="clearfix"></div>
            </div>

            <div class="border p-3 mb-3 rounded">
                <div class="fw-semibold">Konfirmasi Lokasi</div>
                <div class="mt-2">Klik "Konfirmasi Lokasi" untuk memverifikasi posisi Anda</div>
                <div class="text-end mt-2"><button id="btn-confirm-location" class="btn btn-sm btn-outline-primary">Konfirmasi Lokasi</button></div>
            </div>

            <div class="bg-light mb-3 rounded" id="map-masuk" style="height:180px;"></div>
          </div>
          <div class="modal-footer">
            <button id="btn-confirm-absen" type="button" class="btn btn-primary" disabled>Konfirmasi Absen Masuk</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Pulang Modal -->
    <div class="modal fade" id="modalPulang" tabindex="-1" aria-labelledby="modalPulangLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light">
            <h5 class="modal-title" id="modalPulangLabel">Absen Pulang</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="p-3 mb-3 bg-light rounded text-center">
                <div style="font-size:18px">Waktu Absen Pulang</div>
                <div id="pulang-time" style="font-size:28px;font-weight:600;margin-top:8px">--:-- WIB</div>
                <div id="pulang-date" class="text-muted" style="margin-top:6px">--</div>
            </div>

            <div id="pulang-lokasi-live" class="mb-3 p-2 bg-white border rounded">
                <div id="pulang-location-text">Lokasi Live<br><small>Lokasi sedang dilacak secara real-time</small></div>
                <div class="float-end"><span id="pulang-accuracy">Akurasi: -</span></div>
                <div class="clearfix"></div>
            </div>

            <div class="border p-3 mb-3 rounded">
                <div class="fw-semibold">Konfirmasi Lokasi</div>
                <div class="mt-2">Klik "Konfirmasi Lokasi" untuk memverifikasi posisi Anda</div>
                <div class="text-end mt-2"><button id="btn-confirm-location-pulang" class="btn btn-sm btn-outline-primary">Konfirmasi Lokasi</button></div>
            </div>

            <div class="bg-light mb-3 rounded" id="map-pulang" style="height:140px;"></div>
          </div>
          <div class="modal-footer">
            <button id="btn-confirm-pulang" type="button" class="btn btn-primary" disabled>Konfirmasi Absen Pulang</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Izin/Sakit Modal -->
    <div class="modal fade" id="modalIzin" tabindex="-1" aria-labelledby="modalIzinLabel" aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light">
            <h5 class="modal-title" id="modalIzinLabel">Ajukan Izin / Sakit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="text-center mb-3 fw-semibold">Pilih Jenis Permohonan</div>

            <div class="d-flex gap-2 justify-content-center mb-3">
                <label class="d-flex align-items-center gap-2 bg-light p-2 rounded" style="width:160px;justify-content:center;cursor:pointer">
                    <input type="radio" name="izin_type" value="izin" checked />
                    <div>Izin</div>
                </label>
                <label class="d-flex align-items-center gap-2 bg-light p-2 rounded" style="width:160px;justify-content:center;cursor:pointer">
                    <input type="radio" name="izin_type" value="sakit" />
                    <div>Sakit</div>
                </label>
            </div>

            <div class="mb-2">
                <div class="small mb-1">Tanggal</div>
                <input type="date" id="izin-date" class="form-control" />
            </div>

            <div class="mb-2">
                <div class="small mb-1">Alasan / Keterangan</div>
                <textarea id="izin-reason" rows="4" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <div class="small mb-1">Surat Keterangan (Optional)</div>
                <input type="file" id="izin-file" class="form-control" />
            </div>
          </div>
          <div class="modal-footer">
            <button id="btn-submit-izin" type="button" class="btn btn-primary">Ajukan Permohonan</button>
            <button id="btn-cancel-izin" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Update current time every second (guard element existence, start clock)
        const timeEl = document.getElementById('current-time');

        function updateTime() {
            const now = new Date();
            const options = { hour: '2-digit', minute: '2-digit'};
            let timeString = now.toLocaleTimeString('id-ID', options);
            // Replace "." with ":" in the time string
            timeString = timeString.replace(/\./g, ':');
            if (timeEl) {
                timeEl.innerText = 'Jam Hari ini : ' + timeString + ' WIB';
            }
        }

        // Start the clock only when the element exists
        if (timeEl) {
            updateTime();
            setInterval(updateTime, 1000);
        }

        // Bootstrap modal instances
        const modalMasukEl = document.getElementById('modalMasuk');
        const modalPulangEl = document.getElementById('modalPulang');
        const modalIzinEl = document.getElementById('modalIzin');

        const modalMasuk = new bootstrap.Modal(modalMasukEl);
        const modalPulang = new bootstrap.Modal(modalPulangEl);
        const modalIzin = new bootstrap.Modal(modalIzinEl);

        // Card click handlers to open modals
        document.getElementById('card-absen-masuk').addEventListener('click', function () {
            modalMasuk.show();
        });
        document.getElementById('card-absen-pulang').addEventListener('click', function () {
            modalPulang.show();
        });
        document.getElementById('card-izin').addEventListener('click', function () {
            modalIzin.show();
        });

        // Masuk modal logic
        let mapMasuk;
        const btnConfirmLocationMasuk = document.getElementById('btn-confirm-location');
        const btnConfirmAbsenMasuk = document.getElementById('btn-confirm-absen');

        // Initialize map when modal is shown
        modalMasukEl.addEventListener('shown.bs.modal', function () {
            if (!mapMasuk) {
                mapMasuk = L.map('map-masuk').setView([-6.2, 106.816666], 13); // Default to Jakarta
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(mapMasuk);
            }
        });

        btnConfirmLocationMasuk.addEventListener('click', function () {
            if (!navigator.geolocation) {
                alert('Geolocation tidak didukung di browser Anda');
                return;
            }
            const accEl = document.getElementById('masuk-accuracy');
            const locText = document.getElementById('masuk-location-text');
            accEl.innerText = 'Mencari posisi...';
            navigator.geolocation.getCurrentPosition(function (pos) {
                const lat = pos.coords.latitude;
                const lon = pos.coords.longitude;
                const accuracy = pos.coords.accuracy;
                const accuracyText = Math.round(accuracy) + ' m';
                accEl.innerText = 'Akurasi: ' + accuracyText;
                locText.innerHTML = 'Posisi: ' + lat.toFixed(6) + ', ' + lon.toFixed(6) + '<br><small>Lokasi tervalidasi</small>';
                if (btnConfirmAbsenMasuk) { btnConfirmAbsenMasuk.disabled = false; }
                window._masukLocation = {lat: lat.toFixed(6), lon: lon.toFixed(6), accuracy: accuracyText};

                // Update map
                mapMasuk.setView([lat, lon], 16);
                L.marker([lat, lon]).addTo(mapMasuk).bindPopup('Lokasi Anda').openPopup();
                L.circle([lat, lon], {color: 'blue', fillColor: '#30f', fillOpacity: 0.2, radius: accuracy}).addTo(mapMasuk);

                btnConfirmLocationMasuk.innerText = 'Lokasi tervalidasi';
            }, function (err) {
                accEl.innerText = 'Akurasi: -';
                alert('Gagal mendapatkan lokasi: ' + (err.message || 'unknown'));
            }, {enableHighAccuracy: true, timeout: 10000});
        });

        btnConfirmAbsenMasuk.addEventListener('click', function () {
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
                modalMasuk.hide();
            }).catch(err => { alert('Gagal: ' + err); });
        });

        // Pulang modal logic
        let mapPulang;
        const btnConfirmLocationPulang = document.getElementById('btn-confirm-location-pulang');
        const btnConfirmPulang = document.getElementById('btn-confirm-pulang');

        // Initialize map when modal is shown
        modalPulangEl.addEventListener('shown.bs.modal', function () {
            if (!mapPulang) {
                mapPulang = L.map('map-pulang').setView([-6.2, 106.816666], 13); // Default to Jakarta
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(mapPulang);
            }
        });

        btnConfirmLocationPulang.addEventListener('click', function () {
            if (!navigator.geolocation) {
                alert('Geolocation tidak didukung di browser Anda');
                return;
            }
            const accEl = document.getElementById('pulang-accuracy');
            const locText = document.getElementById('pulang-location-text');
            accEl.innerText = 'Mencari posisi...';
            navigator.geolocation.getCurrentPosition(function (pos) {
                const lat = pos.coords.latitude;
                const lon = pos.coords.longitude;
                const accuracy = pos.coords.accuracy;
                const accuracyText = Math.round(accuracy) + ' m';
                accEl.innerText = 'Akurasi: ' + accuracyText;
                locText.innerHTML = 'Posisi: ' + lat.toFixed(6) + ', ' + lon.toFixed(6) + '<br><small>Lokasi tervalidasi</small>';
                if (btnConfirmPulang) { btnConfirmPulang.disabled = false; }
                window._pulangLocation = {lat: lat.toFixed(6), lon: lon.toFixed(6), accuracy: accuracyText};

                // Update map
                mapPulang.setView([lat, lon], 16);
                L.marker([lat, lon]).addTo(mapPulang).bindPopup('Lokasi Anda').openPopup();
                L.circle([lat, lon], {color: 'blue', fillColor: '#30f', fillOpacity: 0.2, radius: accuracy}).addTo(mapPulang);

                btnConfirmLocationPulang.innerText = 'Lokasi tervalidasi';
            }, function (err) {
                accEl.innerText = 'Akurasi: -';
                alert('Gagal mendapatkan lokasi: ' + (err.message || 'unknown'));
            }, {enableHighAccuracy: true, timeout: 10000});
        });

        btnConfirmPulang.addEventListener('click', function () {
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
                modalPulang.hide();
            }).catch(err => { alert('Gagal: ' + err); });
        });

        // Izin/Sakit modal logic
        const btnSubmitIzin = document.getElementById('btn-submit-izin');
        const btnCancelIzin = document.getElementById('btn-cancel-izin');

        btnCancelIzin.addEventListener('click', function () {
            // Bootstrap will handle hiding
        });

        btnSubmitIzin.addEventListener('click', function () {
            const typeEl = document.querySelector('input[name="izin_type"]:checked');
            const type = typeEl ? typeEl.value : 'izin';
            const date = document.getElementById('izin-date').value;
            const reason = document.getElementById('izin-reason').value.trim();
            const fileInput = document.getElementById('izin-file');
            if (!date) { alert('Pilih tanggal'); return; }
            if (!reason) { alert('Masukkan alasan atau keterangan'); return; }

            const formData = new FormData();
            formData.append('type', type);
            formData.append('date', date);
            formData.append('reason', reason);
            if (fileInput && fileInput.files[0]) { formData.append('file', fileInput.files[0]); }

            fetch('/izin/request', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            }).then(r => r.json()).then(data => {
                alert('Permohonan terkirim');
                modalIzin.hide();
            }).catch(err => { alert('Gagal: ' + err); });
        });

        // Update masuk-time element with realtime clock (local time, HH:mm WIB)
        const masukTimeEl = document.getElementById('masuk-time');
        function updateMasukTime() {
            if (!masukTimeEl) return;
            const now = new Date();
            const opts = { hour: '2-digit', minute: '2-digit', hour12: false };
            let t = now.toLocaleTimeString('id-ID', opts);
            t = t.replace(/\./g, ':');
            masukTimeEl.innerText = t + ' WIB';
        }
        if (masukTimeEl) {
            updateMasukTime();
            setInterval(updateMasukTime, 1000);
        }

        // Update pulang-time element with realtime clock (local time, HH:mm WIB)
        const pulangTimeEl = document.getElementById('pulang-time');
        function updatePulangTime() {
            if (!pulangTimeEl) return;
            const now = new Date();
            const opts = { hour: '2-digit', minute: '2-digit', hour12: false };
            let t = now.toLocaleTimeString('id-ID', opts);
            t = t.replace(/\./g, ':');
            pulangTimeEl.innerText = t + ' WIB';
        }
        if (pulangTimeEl) {
            updatePulangTime();
            setInterval(updatePulangTime, 1000);
        }

        // Helper: format date in Indonesian -> "NamaHari, dd NamaBulan yyyy"
        function formatIndoDate(date) {
            const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
            const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            const dayName = days[date.getDay()];
            const d = date.getDate();
            const m = months[date.getMonth()];
            const y = date.getFullYear();
            return `${dayName}, ${d.toString().padStart(2,'0')} ${m} ${y}`;
        }

        // Update both date displays
        const masukDateEl = document.getElementById('masuk-date');
        const pulangDateEl = document.getElementById('pulang-date');
        function updateDates() {
            const now = new Date();
            const formatted = formatIndoDate(now);
            if (masukDateEl) masukDateEl.innerText = formatted;
            if (pulangDateEl) pulangDateEl.innerText = formatted;
        }
        // Call initially
        updateDates();
        // Also update when modals are shown so they reflect current date
        if (modalMasukEl) modalMasukEl.addEventListener('shown.bs.modal', updateDates);
        if (modalPulangEl) modalPulangEl.addEventListener('shown.bs.modal', updateDates);

        // Realtime location tracking: try device geolocation first, fallback to IP-based lookup
        let masukIntervalId = null;
        let pulangIntervalId = null;
        let markerMasuk = null, circleMasuk = null;
        let markerPulang = null, circlePulang = null;

        async function getIpLocation() {
            try {
                const res = await fetch('/ip-location');
                if (!res.ok) throw new Error('IP lookup failed');
                const j = await res.json();
                if (!j || !j.latitude || !j.longitude) return null;
                return {lat: parseFloat(j.latitude), lon: parseFloat(j.longitude), accuracy: 5000};
            } catch (e) {
                return null;
            }
        }

        function updateLocationOnUI(type, lat, lon, accuracy) {
            const accText = accuracy ? (Math.round(accuracy) + ' m') : 'Akurasi: -';
            if (type === 'masuk') {
                const accEl = document.getElementById('masuk-accuracy');
                const locText = document.getElementById('masuk-location-text');
                if (accEl) accEl.innerText = 'Akurasi: ' + (accuracy ? Math.round(accuracy) + ' m' : '-');
                if (locText) locText.innerHTML = 'Posisi: ' + lat.toFixed(6) + ', ' + lon.toFixed(6) + '<br><small>Lokasi tervalidasi</small>';
                if (btnConfirmAbsenMasuk) btnConfirmAbsenMasuk.disabled = false;
                window._masukLocation = {lat: lat.toFixed(6), lon: lon.toFixed(6), accuracy: Math.round(accuracy) + ' m'};
                if (mapMasuk) {
                    mapMasuk.setView([lat, lon], 16);
                    if (markerMasuk) { markerMasuk.setLatLng([lat, lon]); } else { markerMasuk = L.marker([lat, lon]).addTo(mapMasuk).bindPopup('Lokasi Anda').openPopup(); }
                    if (circleMasuk) { circleMasuk.setLatLng([lat, lon]).setRadius(accuracy || 50); } else { circleMasuk = L.circle([lat, lon], {color: 'blue', fillColor: '#30f', fillOpacity: 0.2, radius: accuracy || 50}).addTo(mapMasuk); }
                }
            } else if (type === 'pulang') {
                const accEl = document.getElementById('pulang-accuracy');
                const locText = document.getElementById('pulang-location-text');
                if (accEl) accEl.innerText = 'Akurasi: ' + (accuracy ? Math.round(accuracy) + ' m' : '-');
                if (locText) locText.innerHTML = 'Posisi: ' + lat.toFixed(6) + ', ' + lon.toFixed(6) + '<br><small>Lokasi tervalidasi</small>';
                if (btnConfirmPulang) btnConfirmPulang.disabled = false;
                window._pulangLocation = {lat: lat.toFixed(6), lon: lon.toFixed(6), accuracy: Math.round(accuracy) + ' m'};
                if (mapPulang) {
                    mapPulang.setView([lat, lon], 16);
                    if (markerPulang) { markerPulang.setLatLng([lat, lon]); } else { markerPulang = L.marker([lat, lon]).addTo(mapPulang).bindPopup('Lokasi Anda').openPopup(); }
                    if (circlePulang) { circlePulang.setLatLng([lat, lon]).setRadius(accuracy || 50); } else { circlePulang = L.circle([lat, lon], {color: 'blue', fillColor: '#30f', fillOpacity: 0.2, radius: accuracy || 50}).addTo(mapPulang); }
                }
            }
        }

        function startIpTracking(type, intervalMs) {
            const fn = async () => {
                const ipLoc = await getIpLocation();
                if (ipLoc) {
                    updateLocationOnUI(type, ipLoc.lat, ipLoc.lon, ipLoc.accuracy);
                    if (type === 'masuk') { if (masukIntervalId == null) masukIntervalId = setInterval(fn, intervalMs); }
                    if (type === 'pulang') { if (pulangIntervalId == null) pulangIntervalId = setInterval(fn, intervalMs); }
                }
            };
            fn();
        }

        function startDeviceTracking(type, intervalMs) {
            const options = { enableHighAccuracy: true, maximumAge: 0, timeout: 5000 };
            const fn = () => {
                navigator.geolocation.getCurrentPosition(function (pos) {
                    const lat = pos.coords.latitude;
                    const lon = pos.coords.longitude;
                    const accuracy = pos.coords.accuracy || 50;
                    updateLocationOnUI(type, lat, lon, accuracy);
                }, async function (err) {
                    // On error (e.g., permission denied), fallback to IP-based tracking
                    if (err && (err.code === err.PERMISSION_DENIED || err.code === err.POSITION_UNAVAILABLE)) {
                        if (type === 'masuk' && masukIntervalId) { clearInterval(masukIntervalId); masukIntervalId = null; }
                        if (type === 'pulang' && pulangIntervalId) { clearInterval(pulangIntervalId); pulangIntervalId = null; }
                        startIpTracking(type, intervalMs);
                    }
                }, options);
            };
            // run immediately and then interval
            fn();
            if (type === 'masuk') { if (masukIntervalId == null) masukIntervalId = setInterval(fn, intervalMs); }
            if (type === 'pulang') { if (pulangIntervalId == null) pulangIntervalId = setInterval(fn, intervalMs); }
        }

        function stopTracking(type) {
            if (type === 'masuk') {
                if (masukIntervalId) { clearInterval(masukIntervalId); masukIntervalId = null; }
                if (markerMasuk && mapMasuk) { mapMasuk.removeLayer(markerMasuk); markerMasuk = null; }
                if (circleMasuk && mapMasuk) { mapMasuk.removeLayer(circleMasuk); circleMasuk = null; }
            } else if (type === 'pulang') {
                if (pulangIntervalId) { clearInterval(pulangIntervalId); pulangIntervalId = null; }
                if (markerPulang && mapPulang) { mapPulang.removeLayer(markerPulang); markerPulang = null; }
                if (circlePulang && mapPulang) { mapPulang.removeLayer(circlePulang); circlePulang = null; }
            }
        }

        // Start tracking when modals open, stop when close
        if (modalMasukEl) {
            modalMasukEl.addEventListener('shown.bs.modal', function () {
                if (!mapMasuk) {
                    mapMasuk = L.map('map-masuk').setView([-6.2, 106.816666], 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors' }).addTo(mapMasuk);
                }
                // prioritise device geolocation, fallback to IP, update every 3000ms
                if (navigator.geolocation) startDeviceTracking('masuk', 3000); else startIpTracking('masuk', 3000);
            });
            modalMasukEl.addEventListener('hidden.bs.modal', function () { stopTracking('masuk'); });
        }
        if (modalPulangEl) {
            modalPulangEl.addEventListener('shown.bs.modal', function () {
                if (!mapPulang) {
                    mapPulang = L.map('map-pulang').setView([-6.2, 106.816666], 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors' }).addTo(mapPulang);
                }
                if (navigator.geolocation) startDeviceTracking('pulang', 3000); else startIpTracking('pulang', 3000);
            });
            modalPulangEl.addEventListener('hidden.bs.modal', function () { stopTracking('pulang'); });
        }


    </script>
</body>
</html>
