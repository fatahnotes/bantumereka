<?php
require 'config.php';

// Pastikan folder uploads/laporan ada
if (!is_dir('uploads/laporan')) {
    mkdir('uploads/laporan', 0755, true);
}

$success = false;
$error = '';

if (isset($_POST['submit'])) {
    $nama_pelapor   = $_POST['nama_pelapor'] ?? '';
    $kontak_pelapor = $_POST['kontak_pelapor'] ?? '';
    $ketua_rt       = $_POST['ketua_rt'] ?? '';
    $kontak_rt      = $_POST['kontak_rt'] ?? '';
    $nama_sasaran   = $_POST['nama_sasaran'] ?? '';
    $provinsi       = $_POST['provinsi'] ?? '';
    $kabupaten      = $_POST['kabupaten'] ?? '';
    $kecamatan      = $_POST['kecamatan'] ?? '';
    $kelurahan      = $_POST['kelurahan'] ?? '';
    $kelurahan_manual = $_POST['kelurahan_manual'] ?? '';
    $alamat_detail  = $_POST['alamat_detail'] ?? '';
    $kategori_id    = !empty($_POST['kategori_id']) ? (int)$_POST['kategori_id'] : null;
    $permasalahan   = $_POST['permasalahan'] ?? '';
    $link_pendukung = $_POST['link_pendukung'] ?? '';
    $tingkat_urgensi = isset($_POST['tingkat_urgensi']) ? (int)$_POST['tingkat_urgensi'] : 5;

    if (empty($kelurahan) && !empty($kelurahan_manual)) {
        $kelurahan = $kelurahan_manual;
    }

    $file_proposal = '';
    $file_pendukung = '';

    if (!empty($_FILES['file_proposal']['name'])) {
        $ext = strtolower(pathinfo($_FILES['file_proposal']['name'], PATHINFO_EXTENSION));
        if ($ext === 'pdf' && $_FILES['file_proposal']['size'] <= 2 * 1024 * 1024) {
            $file_proposal = time() . '_proposal.pdf';
            if (!move_uploaded_file($_FILES['file_proposal']['tmp_name'], 'uploads/laporan/' . $file_proposal)) {
                $error = 'Gagal mengunggah file proposal. Periksa izin folder.';
            }
        } else {
            $error = 'File proposal harus PDF dan maksimal 2MB.';
        }
    }

    if (empty($error) && !empty($_FILES['file_pendukung']['name'])) {
        $ext = strtolower(pathinfo($_FILES['file_pendukung']['name'], PATHINFO_EXTENSION));
        if ($ext === 'pdf' && $_FILES['file_pendukung']['size'] <= 2 * 1024 * 1024) {
            $file_pendukung = time() . '_pendukung.pdf';
            if (!move_uploaded_file($_FILES['file_pendukung']['tmp_name'], 'uploads/laporan/' . $file_pendukung)) {
                $error = 'Gagal mengunggah file pendukung. Periksa izin folder.';
            }
        } else {
            $error = 'File pendukung harus PDF dan maksimal 2MB.';
        }
    }

    if (empty($error)) {
        $stmt = $conn->prepare("INSERT INTO laporan_bantuan (nama_pelapor, kontak_pelapor, ketua_rt, kontak_rt, nama_sasaran, provinsi, kabupaten, kecamatan, kelurahan, alamat_detail, kategori_id, permasalahan, link_pendukung, tingkat_urgensi, file_proposal, file_pendukung) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssssssssisssss', $nama_pelapor, $kontak_pelapor, $ketua_rt, $kontak_rt, $nama_sasaran, $provinsi, $kabupaten, $kecamatan, $kelurahan, $alamat_detail, $kategori_id, $permasalahan, $link_pendukung, $tingkat_urgensi, $file_proposal, $file_pendukung);
        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = 'Gagal menyimpan data. Silakan coba lagi.';
        }
    }
}

// Data wilayah
$wilayahFile = __DIR__ . '/data/data.json';
$wilayahData = [];
$fallback = [
    "DKI Jakarta" => [
        "Jakarta Pusat" => ["Gambir","Menteng","Sawah Besar","Senen","Cempaka Putih","Johar Baru","Kemayoran","Tanah Abang"],
        "Jakarta Utara" => ["Cilincing","Kelapa Gading","Koja","Pademangan","Penjaringan","Tanjung Priok"],
        "Jakarta Barat" => ["Cengkareng","Grogol Petamburan","Kalideres","Kebon Jeruk","Kembangan","Palmerah","Taman Sari","Tambora"],
        "Jakarta Selatan" => ["Cilandak","Jagakarsa","Kebayoran Baru","Kebayoran Lama","Mampang Prapatan","Pancoran","Pasar Minggu","Pesanggrahan","Setiabudi","Tebet"],
        "Jakarta Timur" => ["Cakung","Cipayung","Ciracas","Duren Sawit","Jatinegara","Kramat Jati","Makasar","Matraman","Pasar Rebo","Pulo Gadung"]
    ]
];
if (file_exists($wilayahFile)) {
    $jsonContent = file_get_contents($wilayahFile);
    $raw = json_decode($jsonContent, true);
    if (isset($raw['62']['provinces'])) {
        $provinces = $raw['62']['provinces'];
        $wilayah = [];
        foreach ($provinces as $provId => $provData) {
            $provName = $provData['name'];
            $wilayah[$provName] = [];
            if (isset($provData['cities'])) {
                foreach ($provData['cities'] as $cityId => $cityData) {
                    $cityName = $cityData['name'];
                    $wilayah[$provName][$cityName] = [];
                    if (isset($cityData['districts'])) {
                        foreach ($cityData['districts'] as $distId => $distData) {
                            $distEntry = ['name' => $distData['name'], 'neighborhoods' => []];
                            if (isset($distData['neighborhoods'])) {
                                foreach ($distData['neighborhoods'] as $nId => $nData) {
                                    $distEntry['neighborhoods'][] = $nData['name'];
                                }
                            }
                            $wilayah[$provName][$cityName][] = $distEntry;
                        }
                    }
                }
            }
        }
        if (!empty($wilayah)) $wilayahData = $wilayah;
    }
}
if (empty($wilayahData)) $wilayahData = $fallback;
$wilayahJson = json_encode($wilayahData, JSON_UNESCAPED_UNICODE);

$kategoriList = $conn->query("SELECT id, nama FROM kategori ORDER BY nama");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Data Penerima Bantuan - Bantu Mereka</title>
    <link rel="shortcut icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='0.9em' font-size='90'>🤝</text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --deep-blue: #0A2540; --soft-blue: #E8F0FE; --primary-red: #C62828;
            --accent-gold: #D4AF37; --text-grey: #5A6D7C; --white: #ffffff;
            --radius: 20px; --shadow: 0 15px 35px rgba(0,0,0,0.06);
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, var(--soft-blue) 0%, #fff 100%);
            padding: 30px 20px;
        }
        .container { max-width: 900px; margin: 0 auto; }
        .btn-back {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--white); color: var(--deep-blue);
            padding: 10px 20px; border-radius: 50px; text-decoration: none;
            font-weight: 700; font-size: 0.9rem; box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            margin-bottom: 20px; transition: all 0.2s;
        }
        .btn-back:hover { background: var(--deep-blue); color: white; }
        .header { text-align: center; margin-bottom: 30px; }
        .header img { height: 60px; margin-bottom: 10px; }
        .header h1 { font-size: 2rem; font-weight: 800; color: var(--deep-blue); }
        .header p { color: var(--text-grey); font-size: 1.05rem; }
        .card {
            background: var(--white); border-radius: var(--radius);
            box-shadow: var(--shadow); padding: 35px 30px; margin-bottom: 30px;
        }
        .card h2 { font-size: 1.5rem; font-weight: 800; color: var(--deep-blue); margin-bottom: 10px; }
        .card h2 i { color: var(--accent-gold); }
        .form-group { margin-bottom: 18px; }
        label { font-weight: 600; font-size: 0.9rem; color: var(--deep-blue); display: block; margin-bottom: 6px; }
        input, select, textarea {
            width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 12px;
            font-size: 0.95rem; background: #fafafa; transition: border 0.2s;
        }
        input:focus, select:focus, textarea:focus {
            outline: none; border-color: var(--accent-gold);
            box-shadow: 0 0 0 3px rgba(212,175,55,0.15); background: #fff;
        }
        .form-row { display: flex; gap: 15px; margin-bottom: 18px; }
        .form-row .form-group { flex: 1; margin-bottom: 0; }
        .btn-submit {
            background: var(--primary-red); color: white; border: none;
            padding: 14px 32px; border-radius: 30px; font-weight: 700;
            font-size: 1rem; cursor: pointer; box-shadow: 0 8px 20px rgba(198,40,40,0.2);
            transition: all 0.2s;
        }
        .btn-submit:hover { background: #a51d1d; transform: translateY(-2px); }
        .alert-success {
            background: #e8f5e9; color: #2e7d32; padding: 25px 20px;
            border-radius: 12px; margin-bottom: 20px; border-left: 5px solid #2e7d32;
            text-align: center;
        }
        .alert-success .countdown-number {
            font-size: 2.5rem; font-weight: 800; color: #2e7d32;
        }
        .alert-danger {
            background: #ffebee; color: #b71c1c; padding: 15px 20px;
            border-radius: 12px; margin-bottom: 20px; border-left: 5px solid #b71c1c;
        }
        .text-muted { color: var(--text-grey); font-size: 0.85rem; margin-top: 4px; }
        /* Slider urgensi */
        .urgency-slider-container {
            margin: 25px 0;
        }
        .urgency-slider-container input[type="range"] {
            width: 100%;
            -webkit-appearance: none;
            appearance: none;
            height: 10px;
            border-radius: 5px;
            background: linear-gradient(to right, #4caf50, #ff9800, #f44336);
            outline: none;
        }
        .urgency-slider-container input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: white;
            border: 3px solid var(--primary-red);
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .urgency-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            color: var(--text-grey);
            margin-top: 8px;
        }
        .urgency-value {
            text-align: center;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary-red);
            margin-bottom: 5px;
        }
        .urgency-desc {
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-grey);
            margin-bottom: 10px;
        }
        @media (max-width: 600px) {
            .form-row { flex-direction: column; }
            .card { padding: 25px 20px; }
        }
    </style>
</head>
<body>
<div class="container">
    <a href="index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>

    <?php if ($success): ?>
        <div class="header">
            <img src="gbr/mylog.png" alt="Bantu Mereka" onerror="this.onerror=null;this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🤝</text></svg>';">
            <h1>Terima Kasih!</h1>
        </div>
        <div class="alert-success">
            <i class="fas fa-check-circle" style="font-size:3rem; display:block; margin-bottom:15px;"></i>
            <strong>Data berhasil dikirim.</strong><br>
            Tim kami akan meninjau dan menghubungi Anda jika diperlukan.
            <br><br>
            Mengarahkan ke halaman utama dalam <span class="countdown-number" id="countdown">10</span> detik...
        </div>
    <?php else: ?>
        <div class="header">
            <img src="gbr/mylog.png" alt="Bantu Mereka" onerror="this.onerror=null;this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🤝</text></svg>';">
            <h1>Kirim Data Penerima Bantuan</h1>
            <p>Jika Anda tidak bisa berdonasi, bantu kami menemukan mereka yang membutuhkan.</p>
        </div>

        <?php if ($error): ?>
            <div class="alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <!-- Data Pemberi Informasi -->
            <div class="card">
                <h2><i class="fas fa-user-edit"></i> Data Pemberi Informasi</h2>
                <p style="color:var(--text-grey); margin-bottom:20px;">Informasi Anda diperlukan agar kami dapat menghubungi jika ada tindak lanjut.</p>
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Nama Lengkap *</label>
                        <input type="text" name="nama_pelapor" placeholder="Nama Anda" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-address-book"></i> Kontak (Email / No HP) *</label>
                        <input type="text" name="kontak_pelapor" placeholder="Email atau No HP" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-user-tie"></i> Nama Ketua RT Setempat *</label>
                        <input type="text" name="ketua_rt" placeholder="Nama Ketua RT" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-phone-alt"></i> Kontak Ketua RT *</label>
                        <input type="text" name="kontak_rt" placeholder="No HP Ketua RT" required>
                    </div>
                </div>
            </div>

            <!-- Data Sasaran -->
            <div class="card">
                <h2><i class="fas fa-hands-helping"></i> Data Penerima Bantuan (Sasaran)</h2>
                <p style="color:var(--text-grey); margin-bottom:20px;">Lengkapi data pihak yang Anda usulkan untuk menerima bantuan. Semakin lengkap, semakin cepat kami proses.</p>

                <div class="form-group">
                    <label><i class="fas fa-user"></i> Nama Sasaran *</label>
                    <input type="text" name="nama_sasaran" placeholder="Nama individu / keluarga / kelompok" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-map"></i> Provinsi *</label>
                        <select name="provinsi" id="provinsi" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-city"></i> Kabupaten / Kota *</label>
                        <select name="kabupaten" id="kabupaten" required disabled>
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Kecamatan *</label>
                        <select name="kecamatan" id="kecamatan" required disabled>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-home"></i> Kelurahan / Desa</label>
                        <select name="kelurahan" id="kelurahan" disabled>
                            <option value="">Pilih Kelurahan (jika tersedia)</option>
                        </select>
                        <input type="text" name="kelurahan_manual" id="kelurahan_manual" placeholder="Atau tulis manual" style="margin-top:6px; display:none;">
                        <small class="text-muted">Isi salah satu (pilih atau tulis manual).</small>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-road"></i> Alamat Detail *</label>
                    <textarea name="alamat_detail" placeholder="Tulis alamat lengkap: RT/RW, nama jalan, patokan..." rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-tag"></i> Kategori Permasalahan *</label>
                    <select name="kategori_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php while($kat = $kategoriList->fetch_assoc()): ?>
                        <option value="<?= $kat['id'] ?>"><?= htmlspecialchars($kat['nama']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-exclamation-triangle"></i> Permasalahan & Alasan Membutuhkan Bantuan *</label>
                    <textarea name="permasalahan" placeholder="Jelaskan kondisi, permasalahan, dan mengapa layak dibantu..." rows="5" required></textarea>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-link"></i> Link Pendukung (Google Drive, Foto, dll) *</label>
                    <input type="url" name="link_pendukung" placeholder="https://drive.google.com/..." required>
                    <small class="text-muted">Berikan link yang bisa diakses publik.</small>
                </div>

                <!-- TINGKAT URGENSI -->
                <div class="card" style="background:#fafafa; box-shadow:none; border:1px solid #eee;">
                    <h2 style="font-size:1.2rem;"><i class="fas fa-exclamation-circle"></i> Tingkat Urgensi Bantuan *</h2>
                    <p style="color:var(--text-grey); margin-bottom:10px;">Seberapa penting bantuan ini harus segera diberikan? Geser ke kanan jika semakin mendesak.</p>
                    <div class="urgency-value" id="urgencyValue">5</div>
                    <div class="urgency-slider-container">
                        <input type="range" name="tingkat_urgensi" id="tingkat_urgensi" min="1" max="10" value="5" required oninput="updateUrgency(this.value)">
                    </div>
                    <div class="urgency-labels">
                        <span>1 - Tidak Mendesak</span>
                        <span>5 - Segera</span>
                        <span>10 - Darurat (Menyangkut Nyawa)</span>
                    </div>
                    <div class="urgency-desc" id="urgencyDesc">Segera dibutuhkan dalam waktu dekat</div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-file-pdf"></i> Proposal (PDF, opsional, maks 2MB)</label>
                        <input type="file" name="file_proposal" accept=".pdf">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-paperclip"></i> Dokumen Pendukung (PDF, opsional, maks 2MB)</label>
                        <input type="file" name="file_pendukung" accept=".pdf">
                    </div>
                </div>
            </div>

            <div style="text-align:right;">
                <button type="submit" name="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Kirim Data</button>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php if ($success): ?>
<script>
    let seconds = 10;
    const countdownEl = document.getElementById('countdown');
    const timer = setInterval(() => {
        seconds--;
        countdownEl.textContent = seconds;
        if (seconds <= 0) {
            clearInterval(timer);
            window.location.href = 'index.php';
        }
    }, 1000);
</script>
<?php else: ?>
<script>
    // Update urgency display
    function updateUrgency(val) {
        document.getElementById('urgencyValue').textContent = val;
        const desc = document.getElementById('urgencyDesc');
        const messages = {
            1: 'Tidak mendesak, bisa ditunda',
            2: 'Kurang mendesak',
            3: 'Perlu perhatian',
            4: 'Cukup penting',
            5: 'Segera dibutuhkan dalam waktu dekat',
            6: 'Cukup darurat',
            7: 'Darurat, perlu tindakan cepat',
            8: 'Sangat darurat',
            9: 'Kritis, segera mungkin',
            10: 'Darurat! Menyangkut keselamatan/nyawa'
        };
        desc.textContent = messages[val] || '';
    }

    // Wilayah script
    const wilayah = <?= $wilayahJson ?>;
    const provSelect = document.getElementById('provinsi');
    const kabSelect = document.getElementById('kabupaten');
    const kecSelect = document.getElementById('kecamatan');
    const kelSelect = document.getElementById('kelurahan');
    const kelManual = document.getElementById('kelurahan_manual');

    function populateProvinces() {
        provSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
        for (let prov in wilayah) {
            const opt = document.createElement('option');
            opt.value = prov;
            opt.textContent = prov;
            provSelect.appendChild(opt);
        }
    }
    provSelect.addEventListener('change', function() {
        const prov = this.value;
        kabSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
        kecSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        kelSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
        kelSelect.disabled = true;
        kelManual.style.display = 'none';
        kelManual.value = '';
        kecSelect.disabled = true;
        if (prov && wilayah[prov]) {
            kabSelect.disabled = false;
            for (let kab in wilayah[prov]) {
                const opt = document.createElement('option');
                opt.value = kab;
                opt.textContent = kab;
                kabSelect.appendChild(opt);
            }
        } else {
            kabSelect.disabled = true;
        }
    });
    kabSelect.addEventListener('change', function() {
        const prov = provSelect.value;
        const kab = this.value;
        kecSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        kelSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
        kelSelect.disabled = true;
        kelManual.style.display = 'none';
        kelManual.value = '';
        kecSelect.disabled = true;
        if (prov && kab && wilayah[prov][kab]) {
            kecSelect.disabled = false;
            wilayah[prov][kab].forEach((dist, idx) => {
                const opt = document.createElement('option');
                opt.value = dist.name;
                opt.textContent = dist.name;
                opt.dataset.index = idx;
                kecSelect.appendChild(opt);
            });
        }
    });
    kecSelect.addEventListener('change', function() {
        const prov = provSelect.value;
        const kab = kabSelect.value;
        const idx = this.selectedOptions[0]?.dataset?.index;
        kelSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
        kelManual.style.display = 'none';
        kelManual.value = '';
        kelSelect.disabled = true;
        if (prov && kab && idx !== undefined && wilayah[prov][kab][idx]?.neighborhoods?.length > 0) {
            kelSelect.disabled = false;
            wilayah[prov][kab][idx].neighborhoods.forEach(n => {
                const opt = document.createElement('option');
                opt.value = n;
                opt.textContent = n;
                kelSelect.appendChild(opt);
            });
        } else {
            kelManual.style.display = 'block';
        }
    });

    kelManual.addEventListener('input', function() {
        if (this.value.trim() !== '') {
            kelSelect.disabled = true;
        } else {
            if (kecSelect.value) {
                const idx = kecSelect.selectedOptions[0]?.dataset?.index;
                if (idx !== undefined && wilayah[provSelect.value][kabSelect.value][idx]?.neighborhoods?.length > 0) {
                    kelSelect.disabled = false;
                }
            }
        }
    });
    kelSelect.addEventListener('change', function() {
        if (this.value !== '') {
            kelManual.value = '';
        }
    });

    populateProvinces();
</script>
<?php endif; ?>
</body>
</html>