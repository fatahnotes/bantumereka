<?php
require 'config.php';

// Pastikan folder uploads/relawan ada
if (!is_dir('uploads/relawan')) {
    mkdir('uploads/relawan', 0755, true);
}

$success = false;
$error = '';
$linkWa = ''; // Menyimpan link WhatsApp grup per provinsi

if (isset($_POST['submit'])) {
    $nama_lengkap       = $_POST['nama_lengkap'] ?? '';
    $email              = $_POST['email'] ?? '';
    $no_hp              = $_POST['no_hp'] ?? '';
    $bulan_tahun_lahir  = $_POST['bulan_tahun_lahir'] ?? '';
    $jenis_kelamin      = $_POST['jenis_kelamin'] ?? '';
    $kontak_darurat     = $_POST['kontak_darurat'] ?? '';
    $provinsi           = $_POST['provinsi'] ?? '';
    $kabupaten          = $_POST['kabupaten'] ?? '';
    $kecamatan          = $_POST['kecamatan'] ?? '';
    $kelurahan          = $_POST['kelurahan'] ?? '';
    $kelurahan_manual   = $_POST['kelurahan_manual'] ?? '';
    $alamat_detail      = $_POST['alamat_detail'] ?? '';
    $motivasi           = $_POST['motivasi'] ?? '';
    $pengalaman         = $_POST['pengalaman_relawan'] ?? '';
    $riwayat_pekerjaan  = $_POST['riwayat_pekerjaan'] ?? '';
    $keahlian           = $_POST['keahlian'] ?? '';
    $riwayat_kesehatan  = $_POST['riwayat_kesehatan'] ?? '';
    $hobi               = $_POST['hobi'] ?? '';
    $organisasi         = $_POST['organisasi'] ?? '';
    $pendidikan         = $_POST['pendidikan_terakhir'] ?? '';
    $prodi              = $_POST['prodi'] ?? '';
    $pernyataan         = isset($_POST['pernyataan']) ? 1 : 0;
    $sosial_jenis       = $_POST['sosial_jenis'] ?? [];
    $sosial_url         = $_POST['sosial_url'] ?? [];

    if (empty($kelurahan) && !empty($kelurahan_manual)) {
        $kelurahan = $kelurahan_manual;
    }

    // Upload foto
    $foto = '';
    if (!empty($_FILES['foto']['name'])) {
        $allowed = ['image/jpeg', 'image/png'];
        if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
            $error = 'Ukuran foto maksimal 2MB.';
        } elseif (!in_array($_FILES['foto']['type'], $allowed)) {
            $error = 'Format foto harus JPG atau PNG.';
        } else {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $foto = time() . '_relawan.' . $ext;
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/relawan/' . $foto)) {
                $error = 'Gagal mengunggah foto.';
            }
        }
    }

    if (empty($error)) {
        // Validasi input wajib
        if (empty($nama_lengkap) || empty($email) || empty($no_hp) || empty($provinsi) || empty($kabupaten) || empty($kecamatan) || empty($motivasi)) {
            $error = 'Harap isi semua field wajib (*).';
        } elseif (!$pernyataan) {
            $error = 'Anda harus menyetujui pernyataan siap berkontribusi.';
        } else {
            $cek = $conn->query("SELECT id FROM relawan WHERE email = '" . $conn->real_escape_string($email) . "'");
            if ($cek->num_rows > 0) {
                $error = 'Email sudah terdaftar. Gunakan email lain.';
            } else {
                $stmt = $conn->prepare("INSERT INTO relawan (nama_lengkap, email, no_hp, bulan_tahun_lahir, jenis_kelamin, kontak_darurat, provinsi, kabupaten, kecamatan, kelurahan, alamat_detail, motivasi, pengalaman_relawan, riwayat_pekerjaan, keahlian, riwayat_kesehatan, hobi, organisasi, pendidikan_terakhir, prodi, foto, pernyataan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param('sssssssssssssssssssssi', $nama_lengkap, $email, $no_hp, $bulan_tahun_lahir, $jenis_kelamin, $kontak_darurat, $provinsi, $kabupaten, $kecamatan, $kelurahan, $alamat_detail, $motivasi, $pengalaman, $riwayat_pekerjaan, $keahlian, $riwayat_kesehatan, $hobi, $organisasi, $pendidikan, $prodi, $foto, $pernyataan);
                $stmt->execute();
                $relawan_id = $conn->insert_id;

                // Simpan media sosial
                if (!empty($sosial_jenis) && is_array($sosial_jenis)) {
                    $stmtSosial = $conn->prepare("INSERT INTO relawan_sosial (relawan_id, jenis, url) VALUES (?, ?, ?)");
                    foreach ($sosial_jenis as $i => $jenis) {
                        $url = $sosial_url[$i] ?? '';
                        if ($jenis && $url) {
                            $stmtSosial->bind_param('iss', $relawan_id, $jenis, $url);
                            $stmtSosial->execute();
                        }
                    }
                }

                // Ambil link WhatsApp grup sesuai provinsi
                $stmtGrup = $conn->prepare("SELECT link_whatsapp FROM whatsapp_grup WHERE provinsi = ?");
                $stmtGrup->bind_param('s', $provinsi);
                $stmtGrup->execute();
                $stmtGrup->bind_result($linkWa);
                $stmtGrup->fetch();
                $stmtGrup->close();

                $success = true;
            }
        }
    }
}

// Data wilayah JSON
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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Relawan - Bantu Mereka</title>
    <link rel="shortcut icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='0.9em' font-size='90'>🤝</text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --deep-blue: #0A2540; --soft-blue: #E8F0FE; --primary-red: #C62828;
            --accent-gold: #D4AF37; --text-grey: #5A6D7C; --white: #ffffff;
            --radius: 20px; --shadow: 0 15px 35px rgba(0,0,0,0.06);
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; background: linear-gradient(135deg, var(--soft-blue) 0%, #fff 100%); padding: 30px 20px; }
        .container { max-width: 900px; margin: 0 auto; }
        .btn-back { display: inline-flex; align-items: center; gap: 8px; background: var(--white); color: var(--deep-blue); padding: 10px 20px; border-radius: 50px; text-decoration: none; font-weight: 700; font-size: 0.9rem; box-shadow: 0 4px 15px rgba(0,0,0,0.06); margin-bottom: 20px; transition: all 0.2s; }
        .btn-back:hover { background: var(--deep-blue); color: white; }
        .header { text-align: center; margin-bottom: 30px; }
        .header img { height: 60px; margin-bottom: 10px; }
        .header h1 { font-size: 2rem; font-weight: 800; color: var(--deep-blue); }
        .header p { color: var(--text-grey); font-size: 1.05rem; }
        .card { background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow); padding: 35px 30px; margin-bottom: 30px; }
        .card h2 { font-size: 1.5rem; font-weight: 800; color: var(--deep-blue); margin-bottom: 10px; }
        .card h2 i { color: var(--accent-gold); }
        .form-group { margin-bottom: 18px; }
        label { font-weight: 600; font-size: 0.9rem; color: var(--deep-blue); display: block; margin-bottom: 6px; }
        input, select, textarea { width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 12px; font-size: 0.95rem; background: #fafafa; transition: border 0.2s; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: var(--accent-gold); box-shadow: 0 0 0 3px rgba(212,175,55,0.15); background: #fff; }
        .form-row { display: flex; gap: 15px; margin-bottom: 18px; }
        .form-row .form-group { flex: 1; margin-bottom: 0; }
        .btn-submit { background: var(--primary-red); color: white; border: none; padding: 14px 32px; border-radius: 30px; font-weight: 700; font-size: 1rem; cursor: pointer; box-shadow: 0 8px 20px rgba(198,40,40,0.2); transition: all 0.2s; }
        .btn-submit:hover { background: #a51d1d; transform: translateY(-2px); }
        .alert-success { background: #e8f5e9; color: #2e7d32; padding: 25px 20px; border-radius: 12px; margin-bottom: 20px; border-left: 5px solid #2e7d32; text-align: center; }
        .alert-success .countdown-number { font-size: 2.5rem; font-weight: 800; color: #2e7d32; }
        .alert-danger { background: #ffebee; color: #b71c1c; padding: 15px 20px; border-radius: 12px; margin-bottom: 20px; border-left: 5px solid #b71c1c; }
        .text-muted { color: var(--text-grey); font-size: 0.85rem; margin-top: 4px; }
        .form-check { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 18px; }
        .form-check input { width: auto; margin-top: 3px; }
        .btn-add-sosial { background: var(--accent-gold); color: var(--deep-blue); border: none; padding: 10px 18px; border-radius: 12px; font-weight: 600; cursor: pointer; margin-bottom: 10px; }
        .btn-add-sosial:hover { background: #c9a52c; }
        .sosial-item { display: flex; gap: 10px; align-items: center; margin-bottom: 10px; }
        .sosial-item select, .sosial-item input { flex: 1; }
        .btn-remove-sosial { background: var(--primary-red); color: white; border: none; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; font-size: 0.9rem; }
        .btn-wa-grup { display: inline-block; background: #25D366; color: #fff; padding: 12px 24px; border-radius: 30px; font-weight: 700; text-decoration: none; font-size: 1rem; margin-top: 10px; transition: all 0.2s; }
        .btn-wa-grup:hover { background: #1da851; transform: translateY(-2px); }
        @media (max-width: 600px) { .form-row { flex-direction: column; } .card { padding: 25px 20px; } }
    </style>
</head>
<body>
<div class="container">
    <a href="index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>

    <?php if ($success): ?>
        <div class="header">
            <img src="gbr/mylog.png" alt="Bantu Mereka" onerror="this.onerror=null;this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🤝</text></svg>';">
            <h1>Pendaftaran Berhasil!</h1>
        </div>
        <div class="alert-success">
            <i class="fas fa-check-circle" style="font-size:3rem; display:block; margin-bottom:15px;"></i>
            <strong>Terima kasih telah mendaftar sebagai relawan!</strong><br>
            Data Anda akan diverifikasi oleh Tim Bantu Mereka. Setelah disetujui, Anda akan menerima email untuk login akun beserta kartu anggota digital.
            <br><br>
            <?php if ($linkWa): ?>
                <p style="margin-bottom:10px;">Sambil menunggu verifikasi, silakan bergabung dengan grup WhatsApp relawan di provinsi <strong><?= htmlspecialchars($provinsi) ?></strong>:</p>
                <a href="<?= htmlspecialchars($linkWa) ?>" target="_blank" class="btn-wa-grup">
                    <i class="fab fa-whatsapp"></i> Gabung Grup WhatsApp <?= htmlspecialchars($provinsi) ?>
                </a>
            <?php else: ?>
                <p>Grup WhatsApp untuk provinsi <strong><?= htmlspecialchars($provinsi) ?></strong> belum tersedia. Pantau terus informasi selanjutnya melalui email Anda.</p>
            <?php endif; ?>
            <br><br>
            Mengarahkan ke halaman utama dalam <span class="countdown-number" id="countdown">60</span> detik...
        </div>
    <?php else: ?>
        <div class="header">
            <img src="gbr/mylog.png" alt="Bantu Mereka" onerror="this.onerror=null;this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🤝</text></svg>';">
            <h1>Daftar Sebagai Relawan</h1>
            <p>Bergabunglah dengan tim relawan Bantu Mereka dan jadilah bagian dari aksi kemanusiaan langsung di lapangan.</p>
        </div>

        <?php if ($error): ?>
            <div class="alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" id="formRelawan">
            <!-- Data Diri -->
            <div class="card">
                <h2><i class="fas fa-user-edit"></i> Data Diri Relawan</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Nama Lengkap *</label>
                        <input type="text" name="nama_lengkap" placeholder="Nama lengkap Anda" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-envelope"></i> Email *</label>
                        <input type="email" name="email" placeholder="Alamat email aktif" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-phone-alt"></i> No HP *</label>
                        <input type="text" name="no_hp" placeholder="08xxxxxxxxxx" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-calendar-alt"></i> Bulan & Tahun Lahir</label>
                        <input type="month" name="bulan_tahun_lahir">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-venus-mars"></i> Jenis Kelamin</label>
                        <select name="jenis_kelamin">
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-phone"></i> Kontak Darurat (Nama & No HP)</label>
                    <input type="text" name="kontak_darurat" placeholder="Nama dan nomor yang bisa dihubungi saat darurat">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-camera"></i> Foto Profil (JPG/PNG, maks 2MB)</label>
                    <input type="file" name="foto" accept="image/jpeg,image/png">
                </div>
            </div>

            <!-- Alamat -->
            <div class="card">
                <h2><i class="fas fa-map-marker-alt"></i> Alamat Domisili</h2>
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
                    <textarea name="alamat_detail" placeholder="Tulis alamat lengkap..." rows="3" required></textarea>
                </div>
            </div>

            <!-- Motivasi, Latar Belakang, Riwayat -->
            <div class="card">
                <h2><i class="fas fa-heart"></i> Motivasi & Latar Belakang</h2>
                <div class="form-group">
                    <label><i class="fas fa-question-circle"></i> Motivasi Menjadi Relawan *</label>
                    <textarea name="motivasi" placeholder="Ceritakan mengapa Anda ingin menjadi relawan Bantu Mereka..." rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-history"></i> Pengalaman Relawan / Sukarelawan</label>
                    <textarea name="pengalaman_relawan" placeholder="Ceritakan pengalaman Anda..." rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-briefcase"></i> Riwayat Pekerjaan</label>
                    <textarea name="riwayat_pekerjaan" placeholder="Tuliskan riwayat pekerjaan Anda (bila ada)..." rows="3"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-star"></i> Hobi</label>
                        <input type="text" name="hobi" placeholder="Misal: mendaki, fotografi">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-users"></i> Organisasi yang Diikuti</label>
                        <input type="text" name="organisasi" placeholder="Misal: PMI, Karang Taruna">
                    </div>
                </div>
            </div>

            <!-- Keahlian & Kesehatan -->
            <div class="card">
                <h2><i class="fas fa-plus-circle"></i> Keahlian & Kesehatan</h2>
                <div class="form-group">
                    <label><i class="fas fa-lightbulb"></i> Keahlian / Kompetensi yang Dimiliki</label>
                    <textarea name="keahlian" placeholder="Misal: pertolongan pertama, komunikasi, IT, mengajar..." rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-heartbeat"></i> Riwayat Kesehatan & Alergi (jika ada)</label>
                    <textarea name="riwayat_kesehatan" placeholder="Informasi penting tentang kondisi kesehatan atau alergi..." rows="3"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-graduation-cap"></i> Pendidikan Terakhir</label>
                        <select name="pendidikan_terakhir">
                            <option value="">-- Pilih --</option>
                            <option>SD</option><option>SMP</option><option>SMA/SMK</option>
                            <option>D1/D2/D3</option><option>S1</option><option>S2</option><option>S3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-book"></i> Prodi / Jurusan</label>
                        <input type="text" name="prodi" placeholder="Nama program studi atau jurusan">
                    </div>
                </div>
            </div>

            <!-- Media Sosial -->
            <div class="card">
                <h2><i class="fas fa-share-alt"></i> Media Sosial</h2>
                <div id="sosialContainer"></div>
                <button type="button" class="btn-add-sosial" onclick="tambahSosial()"><i class="fas fa-plus"></i> Tambah Media Sosial</button>
            </div>

            <!-- Pernyataan -->
            <div class="card">
                <h2><i class="fas fa-handshake"></i> Pernyataan Relawan</h2>
                <div class="form-check">
                    <input type="checkbox" name="pernyataan" id="pernyataan" value="1" required>
                    <label for="pernyataan" style="font-weight:400; font-size:0.9rem; color:var(--text-grey);">
                        Saya menyatakan siap berkontribusi sebagai relawan Bantu Mereka, mengikuti arahan koordinator lapangan, dan menjunjung tinggi nilai-nilai kemanusiaan.
                    </label>
                </div>
            </div>

            <div style="text-align:right;">
                <button type="submit" name="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Kirim Pendaftaran</button>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php if ($success): ?>
<script>
    let seconds = 60;
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
        if (this.value.trim() !== '') kelSelect.disabled = true;
        else if (kecSelect.value) {
            const idx = kecSelect.selectedOptions[0]?.dataset?.index;
            if (idx !== undefined && wilayah[provSelect.value][kabSelect.value][idx]?.neighborhoods?.length > 0)
                kelSelect.disabled = false;
        }
    });
    kelSelect.addEventListener('change', function() {
        if (this.value !== '') kelManual.value = '';
    });

    populateProvinces();

    // Media sosial dinamis
    function tambahSosial(jenis = '', url = '') {
        const container = document.getElementById('sosialContainer');
        const div = document.createElement('div');
        div.className = 'sosial-item';
        div.innerHTML = `
            <select name="sosial_jenis[]">
                <option value="">Pilih Platform</option>
                <option value="instagram" ${jenis==='instagram'?'selected':''}>Instagram</option>
                <option value="facebook" ${jenis==='facebook'?'selected':''}>Facebook</option>
                <option value="twitter" ${jenis==='twitter'?'selected':''}>Twitter</option>
                <option value="linkedin" ${jenis==='linkedin'?'selected':''}>LinkedIn</option>
                <option value="tiktok" ${jenis==='tiktok'?'selected':''}>TikTok</option>
                <option value="youtube" ${jenis==='youtube'?'selected':''}>YouTube</option>
                <option value="website" ${jenis==='website'?'selected':''}>Website</option>
                <option value="lainnya" ${jenis==='lainnya'?'selected':''}>Lainnya</option>
            </select>
            <input type="url" name="sosial_url[]" placeholder="https://..." value="${url}">
            <button type="button" class="btn-remove-sosial" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
        `;
        container.appendChild(div);
    }
    window.tambahSosial = tambahSosial;
</script>
<?php endif; ?>
</body>
</html>