<?php
// index.php - Bantu Mereka Foundation Prototype
// Full single-page website for bantumereka.org
// Layout & UX inspired by handsfoundation.id, branding: Blockchain, Tanpa Potongan
?>
<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta property="og:title" content="Bantu Mereka - Platform Donasi Blockchain">
    <meta name="description" content="Bantu Mereka adalah satu-satunya platform donasi berbasis blockchain di Indonesia. Donasi 100% tersalurkan tanpa potongan. Transparansi terjamin dengan smart contract.">
    <meta name="keywords" content="Donasi, Blockchain, Sedekah, Galang Dana, Yayasan, Bantu Mereka, Smart Contract, Tanpa Potongan">
    <meta name="author" content="Bantu Mereka">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantu Mereka - Donasi Blockchain Tanpa Potongan</title>
    <link rel="shortcut icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='0.9em' font-size='90'>🤝</text></svg>">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Slick Carousel CSS (slider tanpa dots) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    
    <style>
        :root {
            /* Palet Inspirasi Bantu Mereka */
            --deep-blue: #0A2540;
            --soft-blue: #E8F0FE;
            --cream: #FFF8F0;
            --primary-red: #C62828;
            --accent-gold: #D4AF37;
            --light-gold: #F9E79F;
            --white: #FFFFFF;
            --off-white: #FAFAFA;
            --grey-light: #F5F5F5;
            --text-dark: #1E272E;
            --text-grey: #5A6D7C;
            
            --radius: 16px;
            --shadow-sm: 0 4px 12px rgba(0,0,0,0.04);
            --shadow-md: 0 12px 28px rgba(0,0,0,0.06);
            --transition-speed: 0.2s;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--text-dark);
            background: var(--white);
            overflow-x: hidden;
            line-height: 1.6;
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        
        /* ===== NAVBAR PUTIH KONTRAS ===== */
        .navbar {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(10px);
            padding: 14px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            transition: all var(--transition-speed) ease;
        }

        .navbar .container {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .navbar__links {
            margin-left: auto;
        }
        .navbar__logo a {
            font-size: 1.9rem;
            font-weight: 800;
            color: var(--deep-blue);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .navbar__logo a i { color: var(--primary-red); font-size: 2rem; }
        .navbar__right {
            display: flex;
            align-items: center;
            gap: 18px;
        }
        .social-icons-header a {
            color: var(--deep-blue);
            margin-left: 12px;
            font-size: 1.2rem;
            transition: color var(--transition-speed);
        }
        .social-icons-header a:hover { color: var(--accent-gold); }
        .btn-download-app {
            background: var(--accent-gold);
            color: var(--deep-blue);
            padding: 9px 18px;
            border-radius: 30px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            box-shadow: 0 4px 12px rgba(212,175,55,0.25);
            transition: all var(--transition-speed);
        }
        .btn-download-app:hover {
            background: #c9a52c;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(212,175,55,0.4);
        }
        .navbar__links {
            display: flex;
            align-items: center;
            gap: 22px;
            list-style: none;
        }
        .navbar__links a {
            text-decoration: none;
            color: var(--deep-blue);
            font-weight: 600;
            font-size: 0.95rem;
            transition: color var(--transition-speed);
        }
        .navbar__links a:hover { color: var(--primary-red); }
        .btn-nav-donate {
            background: var(--primary-red);
            color: white !important;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(198,40,40,0.3);
            transition: all var(--transition-speed);
        }
        .btn-nav-donate:hover { background: #a51d1d; }
        .navbar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.8rem;
            color: var(--deep-blue);
            cursor: pointer;
        }
        
        /* ===== HERO SLIDER (TANPA DOTS, 85% LEBAR) ===== */
        .hero-slider-section {
            background: linear-gradient(180deg, var(--off-white) 0%, #fff 100%);
            padding: 30px 0 20px;
        }
        .hero-slider-container {
            width: 85vw;
            margin: 0 auto;
            max-width: 1300px;
        }
        .hero-slide-item {
            border-radius: 20px;
            overflow: hidden;
            margin: 0 10px;
            box-shadow: var(--shadow-md);
            position: relative;
        }
        .hero-slide-item img {
            width: 100%;
            height: 420px;
            object-fit: cover;
            display: block;
        }
        .hero-slide-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
            color: white;
            padding: 35px 25px 25px;
        }
        .hero-slide-overlay h2 { font-size: 1.9rem; font-weight: 800; margin-bottom: 8px; }
        .hero-slide-overlay p { font-size: 1rem; opacity: 0.95; }
        .btn-slide-donate {
            background: var(--accent-gold);
            color: var(--deep-blue);
            padding: 10px 24px;
            border-radius: 30px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            transition: all var(--transition-speed);
            margin-top: 10px;
        }
        .btn-slide-donate:hover { background: #c9a52c; transform: scale(1.02); }
        .slick-dots { display: none !important; }
        
        /* ===== NEW1- STATS (lebih ringkas) ===== */
        .NEW1-stats-section {
            background: linear-gradient(135deg, var(--soft-blue) 0%, var(--white) 100%);
            padding: 50px 0 40px;
            position: relative;
            overflow: hidden;
        }
        .NEW1-stats-section::before {
            content: "";
            position: absolute;
            top: -40px;
            right: -40px;
            width: 220px;
            height: 220px;
            background: radial-gradient(circle, var(--light-gold) 0%, transparent 70%);
            opacity: 0.3;
            border-radius: 50%;
            pointer-events: none;
        }
        .NEW1-stats-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .NEW1-stats-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--deep-blue);
            margin-bottom: 8px;
        }
        .NEW1-stats-header p {
            color: var(--text-grey);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
            font-weight: 500;
        }
        .NEW1-stats-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
        }
        .NEW1-stat-card {
            background: var(--white);
            border-radius: 20px;
            padding: 30px 24px;
            text-align: center;
            flex: 1 1 180px;
            max-width: 220px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.04);
            transition: all 0.2s ease;
            border: 1px solid rgba(0,0,0,0.02);
        }
        .NEW1-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 35px rgba(0,0,0,0.06);
            border-color: var(--accent-gold);
        }
        .NEW1-stat-icon {
            font-size: 2.4rem;
            margin-bottom: 12px;
            color: var(--accent-gold);
        }
        .NEW1-stat-number {
            font-size: 2.6rem;
            font-weight: 800;
            color: var(--deep-blue);
            line-height: 1.2;
        }
        .NEW1-stat-label {
            font-size: 0.95rem;
            color: var(--text-grey);
            margin-top: 6px;
            font-weight: 600;
        }
        .NEW1-stat-sub {
            font-size: 0.8rem;
            color: var(--primary-red);
            margin-top: 4px;
            font-weight: 700;
            opacity: 0.8;
        }
        
        /* ===== NEW1- FEATURES (lebih ringkas) ===== */
        .NEW1-features-section {
            padding: 50px 0;
            background: var(--white);
        }
        .NEW1-features-header {
            text-align: center;
            margin-bottom: 45px;
        }
        .NEW1-features-header h2 {
            font-size: 2.3rem;
            font-weight: 800;
            color: var(--deep-blue);
            margin-bottom: 8px;
        }
        .NEW1-features-header p {
            color: var(--text-grey);
            max-width: 700px;
            margin: 0 auto;
            font-size: 1.05rem;
        }
        .NEW1-features-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
        }
        .NEW1-feature-card {
            background: var(--white);
            border-radius: 20px;
            padding: 30px 22px;
            flex: 1 1 280px;
            max-width: 320px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.04);
            transition: all 0.2s ease;
            border: 1px solid #eee;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .NEW1-feature-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--accent-gold);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.2s ease;
        }
        .NEW1-feature-card:hover::after {
            transform: scaleX(1);
        }
        .NEW1-feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 35px rgba(0,0,0,0.06);
            border-color: transparent;
        }
        .NEW1-feature-icon {
            font-size: 2.8rem;
            color: var(--deep-blue);
            margin-bottom: 15px;
        }
        .NEW1-feature-card h4 {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--deep-blue);
            margin-bottom: 12px;
        }
        .NEW1-feature-card p {
            color: var(--text-grey);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 18px;
        }
        .NEW1-feature-badge {
            display: inline-block;
            background: var(--soft-blue);
            color: var(--deep-blue);
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.8rem;
            margin-bottom: 12px;
        }
        .NEW1-feature-cta {
            margin-top: 40px;
            text-align: center;
        }
        .NEW1-join-button {
            background: var(--primary-red);
            color: white;
            padding: 14px 38px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.05rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 20px rgba(198,40,40,0.25);
            transition: all var(--transition-speed);
        }
        .NEW1-join-button:hover {
            background: #a51d1d;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(198,40,40,0.35);
            color: white;
        }
        
        /* ===== PROGRAM CARDS (lebih ringkas) ===== */
        .programs-section {
            padding: 50px 0;
            background: var(--white);
        }
        .section-header { text-align: center; margin-bottom: 35px; }
        .section-header h2 { font-weight: 800; font-size: 2.2rem; color: var(--deep-blue); margin-bottom: 8px; }
        .section-header p { color: var(--text-grey); max-width: 650px; margin: 0 auto; font-size: 1rem; }
        .program-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }
        .program-card {
            background: var(--white);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid #eee;
            transition: all var(--transition-speed);
        }
        .program-card:hover { transform: translateY(-5px); box-shadow: 0 15px 28px rgba(0,0,0,0.07); border-color: var(--accent-gold); }
        .program-card img { width: 100%; height: 180px; object-fit: cover; }
        .program-card-body { padding: 20px 16px; }
        .program-card-body .category { color: var(--primary-red); font-weight: 700; font-size: 0.8rem; text-transform: uppercase; }
        .program-card-body h4 { margin: 6px 0; color: var(--deep-blue); font-size: 1.1rem; }
        .program-card-body p { color: var(--text-grey); font-size: 0.85rem; }
        .progress-bar-container { height: 7px; background: #e9ecef; border-radius: 10px; margin: 12px 0 8px; overflow: hidden; }
        .progress-bar-fill { height: 100%; background: var(--primary-red); border-radius: 10px; width: 0%; }
        .fund-info { display: flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 14px; }
        .fund-info .raised { color: var(--deep-blue); font-weight: 700; }
        .btn-donate-card {
            background: var(--primary-red); color: white; text-align: center;
            padding: 10px; border-radius: 30px; text-decoration: none;
            font-weight: 700; display: block; transition: all var(--transition-speed);
        }
        .btn-donate-card:hover { background: #a51d1d; }
        
        /* ===== ABOUT (lebih ringkas) ===== */
        .about-section { padding: 50px 0; background: var(--cream); }
        .about-content { display: flex; align-items: center; gap: 45px; flex-wrap: wrap; }
        .about-text { flex: 1 1 380px; }
        .about-text h2 { font-size: 2rem; font-weight: 800; color: var(--deep-blue); margin-bottom: 18px; }
        .about-text p { color: var(--text-grey); line-height: 1.65; margin-bottom: 14px; font-size: 0.95rem; }
        .about-image { flex: 1 1 380px; }
        .about-image img { width: 100%; border-radius: var(--radius); box-shadow: var(--shadow-md); }
        
        /* ===== CTA (lebih ringkas) ===== */
        .cta-section {
            background: linear-gradient(135deg, #0A2540 0%, #1A3A5C 100%);
            padding: 60px 0; text-align: center; color: white;
        }
        .cta-section h2 { font-weight: 800; font-size: 2.2rem; margin-bottom: 10px; }
        .cta-section p { opacity: 0.9; max-width: 550px; margin: 0 auto 25px; font-size: 1rem; }
        .btn-cta-primary {
            background: var(--accent-gold); color: var(--deep-blue);
            padding: 14px 40px; border-radius: 50px; font-weight: 700;
            text-decoration: none; display: inline-block; box-shadow: 0 8px 20px rgba(212,175,55,0.3);
            transition: all var(--transition-speed);
        }
        .btn-cta-primary:hover { background: #c9a52c; transform: translateY(-2px); }
        
        /* ===== FOOTER ===== */
        .footer {
            background: #0A1929; color: #ccc; padding: 45px 0 25px;
        }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px,1fr)); gap: 30px; }
        .footer h5 { color: white; margin-bottom: 12px; font-weight: 700; }
        .footer a { color: #bbb; text-decoration: none; transition: color var(--transition-speed); }
        .footer a:hover { color: var(--accent-gold); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); margin-top: 30px; padding-top: 18px; text-align: center; font-size: 0.85rem; opacity: 0.7; }
        
        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .navbar__right { order: 2; }
            .navbar__links { display: none; width: 100%; flex-direction: column; background: white; padding: 20px; margin-top: 15px; border-radius: 12px; box-shadow: var(--shadow-sm); }
            .navbar__links.active { display: flex; }
            .navbar-toggle { display: block; }
            .hero-slide-item img { height: 280px; }
            .hero-slider-container { width: 92vw; }
            .section-header h2 { font-size: 1.8rem; }
            .NEW1-stats-header h2, .NEW1-features-header h2 { font-size: 1.9rem; }
        }

        .logo-img {
            height: 60px;
            width: auto;
            display: block;
        }
    </style>
</head>
<body>

<!-- ========== NAVIGATION (PUTIH) ========== -->
<nav class="navbar">
    <div class="container">
        <div class="navbar__logo">
            <a href="#">
                <img src="gbr/mylog.png" alt="Logo" class="logo-img">
            </a>
        </div>

        <div class="navbar__right">
            <div class="social-icons-header">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
            <a href="#" class="btn-download-app"><i class="fas fa-download"></i> Download App</a>
        </div>
        <button class="navbar-toggle" id="navbarToggle">
            <i class="fas fa-bars"></i>
        </button>

        <ul class="navbar__links" id="navbarLinks">
            <li><a href="#">Beranda</a></li>
            <li><a href="#">Tentang Kami</a></li>
            <li><a href="#">Program</a></li>
            <li><a href="#" class="btn-nav-donate"><i class="fas fa-heart"></i> Donasi</a></li>
        </ul>
    </div>
</nav>

<!-- ========== HERO SLIDER (TANPA INDIKATOR) ========== -->
<section class="hero-slider-section">
    <div class="hero-slider-container">
        <div class="hero-slider" id="heroSlider">
            <?php
            $slides = [
                ['image' => 'https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1050&q=80', 'title' => 'Blockchain Mendukung Kemanusiaan', 'desc' => 'Donasi transparan dengan smart contract.'],
                ['image' => 'https://images.pexels.com/photos/6646918/pexels-photo-6646918.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 'title' => '100% Tersalurkan Tanpa Potongan', 'desc' => 'Operasional kami dari bisnis lain, donasi Anda utuh.'],
                ['image' => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?ixlib=rb-4.0.3&auto=format&fit=crop&w=1050&q=80', 'title' => 'Bantu Sesama, Wujudkan Perubahan', 'desc' => 'Platform donasi pertama berbasis blockchain.']
            ];
            foreach ($slides as $slide):
            ?>
            <div class="hero-slide-item">
                <img src="<?php echo $slide['image']; ?>" alt="">
                <div class="hero-slide-overlay">
                    <h2><?php echo $slide['title']; ?></h2>
                    <p><?php echo $slide['desc']; ?></p>
                    <a href="#" class="btn-slide-donate">Donasi Sekarang <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ========== STATS (tanpa animasi) ========== -->
<section class="NEW1-stats-section">
    <div class="container">
        <div class="NEW1-stats-header">
            <h2>Dampak Nyata Kami</h2>
            <p>Setiap angka adalah cerita, setiap statistik adalah kehidupan yang telah kami sentuh bersama.</p>
        </div>
        <div class="NEW1-stats-grid">
            <?php
            $stats = [
                ['icon' => 'fas fa-globe-asia', 'number' => '6', 'label' => 'Negara Program', 'sub' => 'Jangkauan Global'],
                ['icon' => 'fas fa-users', 'number' => '72.731', 'label' => 'Penerima Manfaat', 'sub' => 'Kehidupan Tersentuh'],
                ['icon' => 'fas fa-hand-holding-heart', 'number' => '8', 'label' => 'Program Aktif', 'sub' => 'Aksi Berkelanjutan'],
                ['icon' => 'fas fa-donate', 'number' => '1.250', 'label' => 'Donatur Tergabung', 'sub' => 'Komunitas Tumbuh'],
            ];
            foreach ($stats as $stat):
            ?>
            <div class="NEW1-stat-card">
                <div class="NEW1-stat-icon"><i class="<?php echo $stat['icon']; ?>"></i></div>
                <div class="NEW1-stat-number"><?php echo $stat['number']; ?></div>
                <div class="NEW1-stat-label"><?php echo $stat['label']; ?></div>
                <div class="NEW1-stat-sub"><?php echo $stat['sub']; ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ========== FEATURES (Blockchain & Tanpa Potongan) ========== -->
<section class="NEW1-features-section" id="blockchain">
    <div class="container">
        <div class="NEW1-features-header">
            <h2>Teknologi yang Membawa Perubahan</h2>
            <p>Kami membangun kepercayaan tanpa batas dengan blockchain. Kini saatnya berdonasi dengan keyakinan penuh.</p>
        </div>
        <div class="NEW1-features-grid">
            <div class="NEW1-feature-card">
                <div class="NEW1-feature-icon"><i class="fas fa-link"></i></div>
                <span class="NEW1-feature-badge">Smart Contract Audited</span>
                <h4>Blockchain Transparan</h4>
                <p>Setiap transaksi tercatat di jaringan blockchain publik yang tidak dapat diubah. Anda bisa melacak donasi Anda kapan saja, memastikan dana sampai ke tujuan yang tepat.</p>
                <p style="font-size:0.85rem; font-weight:600; color:var(--deep-blue);">Didukung oleh CertiK Security</p>
            </div>
            <div class="NEW1-feature-card">
                <div class="NEW1-feature-icon"><i class="fas fa-hand-holding-usd"></i></div>
                <span class="NEW1-feature-badge">Tanpa Potongan</span>
                <h4>100% Tersalurkan</h4>
                <p>Kami tidak mengambil satu rupiah pun dari donasi. Biaya operasional Bantu Mereka dibiayai oleh unit bisnis mandiri, sehingga donasi Anda sepenuhnya menjadi manfaat bagi yang membutuhkan.</p>
                <p style="font-size:0.85rem; font-weight:600; color:var(--primary-red);">Baca Laporan Keuangan Kami →</p>
            </div>
            <div class="NEW1-feature-card">
                <div class="NEW1-feature-icon"><i class="fas fa-shield-alt"></i></div>
                <span class="NEW1-feature-badge">Keamanan Web3</span>
                <h4>Desentralisasi & Aman</h4>
                <p>Dengan teknologi enkripsi tingkat tinggi dan sistem desentralisasi, data pribadi dan donasi Anda terjaga dari risiko peretasan. Privasi Anda adalah prioritas kami.</p>
                <p style="font-size:0.85rem; font-weight:600; color:var(--deep-blue);">Pelajari Keamanan Kami →</p>
            </div>
        </div>
        <div class="NEW1-feature-cta">
            <a href="#" class="NEW1-join-button"><i class="fas fa-user-plus"></i> Bergabung Sekarang & Mulai Donasi</a>
        </div>
    </div>
</section>

<!-- ========== PROGRAM KOTAK DONASI ========== -->
<section class="programs-section" id="programs">
    <div class="container">
        <div class="section-header">
            <h2>Program Prioritas Kami</h2>
            <p>Setiap program dipantau secara real-time melalui dashboard blockchain kami.</p>
        </div>
        <div class="program-grid">
            <?php
            $programs = [
                ['image' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1050&q=80', 'title' => 'Bantuan Pangan Keluarga', 'cat' => 'Kemanusiaan', 'desc' => 'Paket sembako via smart contract.', 'raised' => 'Rp 85.000.000', 'percent' => 65],
                ['image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1050&q=80', 'title' => 'Beasiswa Anak Negeri', 'cat' => 'Pendidikan', 'desc' => 'Pendidikan tanpa potongan.', 'raised' => 'Rp 120.500.000', 'percent' => 80],
                ['image' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1050&q=80', 'title' => 'Layanan Kesehatan Gratis', 'cat' => 'Kesehatan', 'desc' => 'Pengobatan transparan.', 'raised' => 'Rp 45.200.000', 'percent' => 30],
                ['image' => 'https://images.pexels.com/photos/6995204/pexels-photo-6995204.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 'title' => 'Tanggap Bencana', 'cat' => 'Darurat', 'desc' => 'Bantuan cepat via blockchain.', 'raised' => 'Rp 210.750.000', 'percent' => 92],
                ['image' => 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1050&q=80', 'title' => 'Pemberdayaan UMKM', 'cat' => 'Ekonomi', 'desc' => 'Modal usaha mikro.', 'raised' => 'Rp 68.300.000', 'percent' => 45],
                ['image' => 'https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1050&q=80', 'title' => 'Relawan Komunitas', 'cat' => 'Sosial', 'desc' => 'Aksi sosial terdesentralisasi.', 'raised' => 'Rp 32.100.000', 'percent' => 25],
            ];
            foreach ($programs as $prog):
            ?>
            <div class="program-card">
                <img src="<?php echo $prog['image']; ?>" alt="">
                <div class="program-card-body">
                    <span class="category"><?php echo $prog['cat']; ?></span>
                    <h4><?php echo $prog['title']; ?></h4>
                    <p><?php echo $prog['desc']; ?></p>
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" style="width: <?php echo $prog['percent']; ?>%;"></div>
                    </div>
                    <div class="fund-info">
                        <span>Terkumpul</span>
                        <span class="raised"><?php echo $prog['raised']; ?></span>
                    </div>
                    <a href="#" class="btn-donate-card">Donasi Sekarang</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ========== ABOUT ========== -->
<section class="about-section" id="about">
    <div class="container">
        <div class="about-content">
            <div class="about-text">
                <h2>Tentang <span style="color:var(--primary-red);">Bantu Mereka</span></h2>
                <p><strong>Bantu Mereka</strong> adalah platform donasi berbasis blockchain pertama di Indonesia. Kami menggunakan smart contract untuk memastikan setiap rupiah donasi tercatat secara transparan di jaringan blockchain. Tidak ada potongan biaya operasional karena seluruh biaya operasional kami ditanggung oleh pendapatan bisnis lainnya. Fokus kami adalah menyalurkan 100% donasi Anda kepada yang membutuhkan.</p>
                <p>Visi kami adalah menciptakan ekosistem donasi modern yang tepercaya, tanpa perantara, dan memberdayakan masyarakat secara langsung.</p>
            </div>
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1050&q=80" alt="Blockchain Donasi">
            </div>
        </div>
    </div>
</section>

<!-- ========== CALL TO ACTION ========== -->
<section class="cta-section">
    <div class="container">
        <h2>Siap Bergabung dengan Gerakan "Bantu Mereka"?</h2>
        <p>Download aplikasi Bantu Mereka sekarang dan mulai donasi transparan tanpa potongan.</p>
        <a href="#" class="btn-cta-primary"><i class="fas fa-download"></i> Download Aplikasi</a>
    </div>
</section>

<!-- ========== FOOTER ========== -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <h5><i class="fas fa-hand-holding-heart"></i> Bantu Mereka</h5>
                <p>Platform donasi blockchain pertama di Indonesia. 100% donasi tersalurkan tanpa potongan.</p>
            </div>
            <div>
                <h5>Program</h5>
                <ul style="list-style:none;padding:0;">
                    <li><a href="#">Bantuan Pangan</a></li>
                    <li><a href="#">Pendidikan</a></li>
                    <li><a href="#">Kesehatan</a></li>
                    <li><a href="#">Tanggap Bencana</a></li>
                </ul>
            </div>
            <div>
                <h5>Perusahaan</h5>
                <ul style="list-style:none;padding:0;">
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Teknologi Blockchain</a></li>
                    <li><a href="#">Laporan Keuangan</a></li>
                    <li><a href="#">Karir</a></li>
                </ul>
            </div>
            <div>
                <h5>Kontak</h5>
                <p><i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia</p>
                <p><i class="fas fa-envelope"></i> info@bantumereka.org</p>
                <p><i class="fas fa-phone"></i> +62 812-3456-7890</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Bantu Mereka Foundation. All rights reserved. | bantumereka.org</p>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
    $(document).ready(function(){
        // Inisialisasi slider tanpa animasi scroll
        $('#heroSlider').slick({
            centerMode: true,
            centerPadding: '3%',
            slidesToShow: 1,
            autoplay: true,
            autoplaySpeed: 4000,
            dots: false,
            arrows: false,
            responsive: [
                {
                    breakpoint: 768,
                    settings: { centerPadding: '0px', slidesToShow: 1 }
                }
            ]
        });
        
        // Mobile menu
        $('#navbarToggle').click(function(){
            $('#navbarLinks').toggleClass('active');
        });
        
        console.log('❤️ Bantu Mereka - Blockchain Donation Platform Ready');
    });
</script>
</body>
</html>