<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta property="og:title" content="Tentang Bantu Mereka - Platform Donasi Berbasis Blockchain">
    <meta property="og:description" content="Kenali lebih dekat Bantu Mereka, platform donasi berbasis blockchain pertama di Indonesia.">
    <meta property="og:image" content="https://bantumereka.org/gbr/mylog.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Bantu Mereka</title>
    <link rel="shortcut icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='0.9em' font-size='90'>🤝</text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <style>
        :root {
            --deep-blue: #0A2540;
            --soft-blue: #E8F0FE;
            --primary-red: #C62828;
            --accent-gold: #D4AF37;
            --light-gold: #F9E79F;
            --text-grey: #5A6D7C;
            --white: #ffffff;
            --off-white: #FAFAFA;
            --radius: 24px;
            --shadow-sm: 0 10px 30px rgba(0,0,0,0.06);
            --shadow-md: 0 20px 50px rgba(0,0,0,0.1);
            --shadow-xl: 0 30px 70px rgba(0,0,0,0.15);
            --transition-speed: 0.2s;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #1E272E;
            background: var(--white);
            overflow-x: hidden;
            line-height: 1.6;
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

        /* ===== NAVBAR (SAMA DENGAN INDEX.PHP) ===== */
        .navbar {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(10px);
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            transition: all var(--transition-speed) ease;
        }
        .navbar .container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .navbar__logo a {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--deep-blue);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .navbar__logo a i { color: var(--primary-red); font-size: 1.7rem; }
        .navbar__right {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .social-icons-header a {
            color: var(--deep-blue);
            margin-left: 8px;
            font-size: 1.1rem;
            transition: color var(--transition-speed);
        }
        .social-icons-header a:hover { color: var(--accent-gold); }
        .btn-download-app {
            background: var(--accent-gold);
            color: var(--deep-blue);
            padding: 8px 14px;
            border-radius: 30px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            box-shadow: 0 4px 12px rgba(212,175,55,0.25);
            transition: all var(--transition-speed);
        }
        .btn-download-app:hover {
            background: #c9a52c;
            color: white;
            transform: translateY(-1px);
        }
        .navbar__links {
            display: flex;
            align-items: center;
            gap: 18px;
            list-style: none;
            margin-left: auto;
        }
        .navbar__links a {
            text-decoration: none;
            color: var(--deep-blue);
            font-weight: 600;
            font-size: 0.9rem;
            transition: color var(--transition-speed);
        }
        .navbar__links a:hover { color: var(--primary-red); }
        .btn-nav-donate {
            background: var(--primary-red);
            color: white !important;
            padding: 8px 20px;
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
            font-size: 1.6rem;
            color: var(--deep-blue);
            cursor: pointer;
        }
        .logo-img { height: 45px; width: auto; display: block; }

        /* ===== HERO PARALLAX ===== */
        .hero-about {
            position: relative; min-height: 90vh; display: flex; align-items: center;
            background: url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=1600&q=80') center/cover no-repeat;
            background-attachment: fixed; overflow: hidden;
        }
        .hero-about::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(10,37,64,0.92) 0%, rgba(198,40,40,0.7) 100%);
        }
        .hero-about .hero-content {
            position: relative; z-index: 1; text-align: center; color: white;
            max-width: 800px; margin: 0 auto; padding-top: 60px;
        }
        .hero-about .hero-badge {
            display: inline-block; background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px); padding: 8px 20px; border-radius: 50px;
            font-size: 0.85rem; font-weight: 600; margin-bottom: 20px;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .hero-about h1 { font-size: 4rem; font-weight: 900; line-height: 1.15; margin-bottom: 20px; }
        .hero-about h1 span { color: var(--accent-gold); }
        .hero-about p { font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto; }

        /* ===== SECTION STYLES ===== */
        .section { padding: 100px 0; position: relative; }
        .section-label {
            display: inline-block; background: var(--soft-blue); color: var(--deep-blue);
            padding: 6px 16px; border-radius: 50px; font-weight: 700;
            font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;
        }
        .section h2 { font-size: 2.8rem; font-weight: 900; color: var(--deep-blue); line-height: 1.2; margin-bottom: 20px; }
        .section p { color: var(--text-grey); line-height: 1.8; font-size: 1.05rem; }

        /* ===== STORY (DIAGONAL LAYOUT) ===== */
        .story-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center;
        }
        .story-image-wrapper {
            position: relative; transform: rotate(-3deg);
        }
        .story-image-wrapper::before {
            content: ''; position: absolute; top: -20px; left: -20px;
            width: 100%; height: 100%; border: 3px solid var(--accent-gold);
            border-radius: var(--radius); z-index: -1;
        }
        .story-image-wrapper img {
            width: 100%; border-radius: var(--radius); box-shadow: var(--shadow-xl);
        }
        .story-text { transform: rotate(1deg); }

        /* ===== VISI MISI (BENTUK DIAMOND) ===== */
        .vm-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;
            margin-top: 50px;
        }
        .vm-card {
            background: var(--white); border-radius: var(--radius);
            padding: 40px 30px; text-align: center; position: relative;
            box-shadow: var(--shadow-sm); transition: all 0.3s;
            border-bottom: 4px solid transparent;
        }
        .vm-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-md); border-bottom-color: var(--accent-gold); }
        .vm-card:nth-child(odd) { margin-top: -30px; }
        .vm-card .icon-circle {
            width: 70px; height: 70px; border-radius: 20px; display: flex;
            align-items: center; justify-content: center; margin: 0 auto 20px;
            font-size: 1.8rem; color: white; transform: rotate(-5deg);
        }
        .vm-card h4 { font-weight: 800; color: var(--deep-blue); margin-bottom: 10px; font-size: 1.2rem; }
        .vm-card p { color: var(--text-grey); font-size: 0.9rem; line-height: 1.6; }

        /* ===== TIM (MASONRY STYLE) ===== */
        .team-masonry {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 25px; margin-top: 50px;
        }
        .team-card {
            background: var(--white); border-radius: var(--radius);
            overflow: hidden; box-shadow: var(--shadow-sm); transition: all 0.3s;
            position: relative;
        }
        .team-card:nth-child(3n+1) { transform: rotate(-1deg); }
        .team-card:nth-child(3n+2) { transform: rotate(1deg); }
        .team-card:nth-child(3n+3) { transform: rotate(-0.5deg); }
        .team-card:hover { transform: rotate(0deg) translateY(-10px) !important; box-shadow: var(--shadow-xl); z-index: 2; }
        .team-card img { width: 100%; height: 260px; object-fit: cover; }
        .team-card .team-info { padding: 20px; text-align: center; background: white; }
        .team-card .team-info h4 { font-weight: 800; color: var(--deep-blue); }
        .team-card .team-info .job { color: var(--primary-red); font-size: 0.85rem; font-weight: 600; margin: 5px 0 10px; }
        .team-card .team-info .bio { color: var(--text-grey); font-size: 0.85rem; line-height: 1.5; }
        .team-card .social-links { display: flex; justify-content: center; gap: 10px; margin-top: 12px; }
        .team-card .social-links a {
            width: 35px; height: 35px; border-radius: 50%; background: var(--soft-blue);
            color: var(--deep-blue); display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem; transition: all 0.2s; text-decoration: none;
        }
        .team-card .social-links a:hover { background: var(--accent-gold); color: white; }

        /* ===== PARTNER (MARQUEE STYLE) ===== */
        .partner-strip {
            display: flex; gap: 40px; align-items: center; justify-content: center;
            flex-wrap: wrap; padding: 40px 0;
        }
        .partner-strip a {
            display: block; transition: all 0.3s; filter: grayscale(100%);
            opacity: 0.6; max-width: 130px;
        }
        .partner-strip a:hover { filter: grayscale(0%); opacity: 1; transform: scale(1.05); }
        .partner-strip img { width: 100%; height: auto; max-height: 60px; object-fit: contain; }

        /* ===== LEGALITAS (SPLIT CARD) ===== */
        .legal-split {
            display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center;
        }
        .legal-visual { position: relative; }
        .legal-visual img { width: 100%; border-radius: var(--radius); box-shadow: var(--shadow-xl); }
        .legal-visual .stamp {
            position: absolute; bottom: -25px; right: -25px;
            width: 90px; height: 90px; background: var(--primary-red);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 900; font-size: 0.9rem; text-align: center;
            box-shadow: var(--shadow-md); transform: rotate(15deg); line-height: 1.2;
        }

        /* ===== CTA ===== */
        .cta-section {
            background: linear-gradient(135deg, #0A2540 0%, #1A3A5C 100%);
            padding: 80px 0; text-align: center; color: white; position: relative; overflow: hidden;
        }
        .cta-section::before {
            content: ''; position: absolute; top: -80px; right: -80px;
            width: 300px; height: 300px; background: radial-gradient(circle, rgba(212,175,55,0.2) 0%, transparent 70%);
            border-radius: 50%;
        }
        .cta-section h2 { font-size: 2.5rem; font-weight: 900; margin-bottom: 15px; }
        .cta-section p { opacity: 0.9; max-width: 500px; margin: 0 auto 30px; }
        .btn-cta {
            background: var(--accent-gold); color: var(--deep-blue); padding: 16px 40px;
            border-radius: 50px; font-weight: 700; font-size: 1.05rem; text-decoration: none;
            display: inline-block; box-shadow: 0 10px 30px rgba(212,175,55,0.3); transition: all 0.3s;
        }
        .btn-cta:hover { transform: translateY(-3px); box-shadow: 0 15px 40px rgba(212,175,55,0.4); }

        /* ===== FOOTER ===== */
        .footer { background: #0A1929; color: #ccc; padding: 50px 0 25px; text-align: center; }
        .footer a { color: var(--accent-gold); text-decoration: none; }

        @media (max-width: 768px) {
            .hero-about h1 { font-size: 2.5rem; }
            .story-grid, .legal-split { grid-template-columns: 1fr; gap: 40px; }
            .story-image-wrapper { transform: none; }
            .story-text { transform: none; }
            .vm-grid { grid-template-columns: 1fr; }
            .vm-card:nth-child(odd) { margin-top: 0; }
            .navbar-toggle { display: block; }
            .navbar__links {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                padding: 20px;
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            }
            .navbar__links.active { display: flex; }
        }

        /* ===== VOLUNTER SECTION ===== */
        .VOLUNTER-section {
            position: relative;
            padding: 0 0 100px;
            background: linear-gradient(180deg, #ffffff 0%, #FFF8F0 30%, #FFF8F0 100%);
            overflow: hidden;
            margin-top: -1px;
        }
        .VOLUNTER-ornament { position: absolute; pointer-events: none; z-index: 0; }
        .VOLUNTER-ornament--dots { top: 10%; left: 3%; width: 140px; height: 140px; background: radial-gradient(circle, rgba(212,175,55,0.3) 2px, transparent 2px); background-size: 22px 22px; opacity: 0.5; }
        .VOLUNTER-ornament--circle { bottom: 15%; right: 5%; width: 220px; height: 220px; border: 2px dashed rgba(198,40,40,0.15); border-radius: 50%; animation: VOLUNTER-spin 30s linear infinite; }
        @keyframes VOLUNTER-spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .VOLUNTER-ornament--wave { bottom: -1px; left: 0; width: 100%; height: 60px; background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,60 C150,120 350,0 600,60 C850,120 1050,0 1200,60 L1200,120 L0,120 Z' fill='rgba(198,40,40,0.05)'/%3E%3C/svg%3E"); background-size: cover; opacity: 0.8; }
        .VOLUNTER-ornament--sparkle { top: 25%; right: 8%; font-size: 2rem; color: rgba(212,175,55,0.5); animation: VOLUNTER-twinkle 2s ease-in-out infinite; }
        @keyframes VOLUNTER-twinkle { 0%, 100% { opacity: 0.4; transform: scale(1); } 50% { opacity: 0.8; transform: scale(1.1); } }
        .VOLUNTER-container { position: relative; z-index: 1; }
        .VOLUNTER-hero { text-align: center; margin-bottom: 60px; padding-top: 20px; }
        .VOLUNTER-eyebrow { display: inline-block; background: var(--white); color: var(--deep-blue); padding: 8px 22px; border-radius: 50px; font-weight: 700; font-size: 0.85rem; letter-spacing: 0.5px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: 1px solid rgba(212,175,55,0.3); }
        .VOLUNTER-heading { font-size: 3.2rem; font-weight: 900; color: var(--deep-blue); line-height: 1.3; margin-bottom: 18px; max-width: 850px; margin-left: auto; margin-right: auto; text-align: center; }
        .VOLUNTER-heading span { color: var(--primary-red); position: relative; display: inline-block; }
        .VOLUNTER-heading span::after { content: ""; position: absolute; bottom: 4px; left: 0; width: 100%; height: 8px; background: var(--accent-gold); opacity: 0.5; border-radius: 4px; }
        .VOLUNTER-subheading { font-size: 1.15rem; color: var(--text-grey); max-width: 600px; margin: 0 auto; line-height: 1.7; }
        .VOLUNTER-divider { margin: 25px auto 0; width: 60px; height: 3px; background: linear-gradient(to right, transparent, var(--accent-gold), transparent); position: relative; }
        .VOLUNTER-divider span { position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: var(--white); padding: 0 8px; color: var(--primary-red); font-size: 0.9rem; }
        .VOLUNTER-grid { display: flex; align-items: center; justify-content: center; gap: 35px; flex-wrap: wrap; }
        .VOLUNTER-card { flex: 1 1 250px; max-width: 320px; position: relative; transition: all 0.4s ease; }
        .VOLUNTER-card--data { margin-top: -20px; }
        .VOLUNTER-card--volunteer { margin-bottom: -20px; }
        .VOLUNTER-card:hover { transform: translateY(-8px); }
        .VOLUNTER-card-badge { position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: var(--white); border: 1px solid #eee; padding: 7px 18px; border-radius: 50px; font-weight: 700; font-size: 0.8rem; z-index: 2; box-shadow: 0 6px 15px rgba(0,0,0,0.06); white-space: nowrap; }
        .VOLUNTER-card-inner { background: var(--white); border-radius: 32px; padding: 45px 24px 30px; text-align: center; box-shadow: 0 15px 35px rgba(0,0,0,0.06); transition: all 0.3s ease; position: relative; overflow: hidden; }
        .VOLUNTER-card--data .VOLUNTER-card-inner { border-top: 4px solid var(--primary-red); transform: rotate(-1deg); background: linear-gradient(180deg, #fff 0%, #fff5f5 100%); }
        .VOLUNTER-card--volunteer .VOLUNTER-card-inner { border-top: 4px solid var(--accent-gold); transform: rotate(1deg); background: linear-gradient(180deg, #fff 0%, #fffef5 100%); }
        .VOLUNTER-card-icon { font-size: 2.8rem; margin-bottom: 18px; display: inline-block; padding: 15px; border-radius: 20px; background: var(--off-white); }
        .VOLUNTER-card--data .VOLUNTER-card-icon { color: var(--primary-red); }
        .VOLUNTER-card--volunteer .VOLUNTER-card-icon { color: var(--accent-gold); }
        .VOLUNTER-card h4 { font-size: 1.3rem; font-weight: 800; color: var(--deep-blue); margin-bottom: 10px; }
        .VOLUNTER-card p { font-size: 0.9rem; color: var(--text-grey); margin-bottom: 22px; line-height: 1.65; }
        .VOLUNTER-card-line { position: absolute; bottom: 12px; right: 15px; width: 45px; height: 3px; background: var(--accent-gold); opacity: 0.5; border-radius: 3px; }
        .VOLUNTER-card-dot { position: absolute; top: 20px; right: 20px; width: 8px; height: 8px; background: var(--primary-red); border-radius: 50%; opacity: 0.6; }
        .VOLUNTER-card--volunteer .VOLUNTER-card-dot { background: var(--accent-gold); }
        .VOLUNTER-btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 30px; font-weight: 700; font-size: 0.9rem; text-decoration: none; transition: all 0.25s ease; position: relative; z-index: 1; }
        .VOLUNTER-btn--data { background: var(--primary-red); color: white; box-shadow: 0 8px 20px rgba(198,40,40,0.25); }
        .VOLUNTER-btn--data:hover { background: #a51d1d; transform: translateY(-3px); color: white; }
        .VOLUNTER-btn--volunteer { background: var(--accent-gold); color: var(--deep-blue); box-shadow: 0 8px 20px rgba(212,175,55,0.25); }
        .VOLUNTER-btn--volunteer:hover { background: #c9a52c; transform: translateY(-3px); }
        .VOLUNTER-image { flex: 0 0 270px; max-width: 270px; position: relative; }
        .VOLUNTER-image-glow { position: absolute; top: -15px; left: -15px; width: calc(100% + 30px); height: calc(100% + 30px); background: radial-gradient(circle, rgba(212,175,55,0.25) 0%, transparent 70%); border-radius: 40px; z-index: -1; }
        .VOLUNTER-image-frame { position: relative; border-radius: 28px; overflow: visible; box-shadow: 0 25px 50px rgba(0,0,0,0.15); transition: transform 0.3s ease; }
        .VOLUNTER-image-frame:hover { transform: scale(1.02); }
        .VOLUNTER-image-frame img { width: 100%; display: block; border-radius: 28px; }
        .VOLUNTER-image-badge { position: absolute; bottom: -22px; right: -22px; width: 65px; height: 65px; background: var(--primary-red); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: 0 12px 28px rgba(198,40,40,0.35); animation: VOLUNTER-pulse 2s infinite ease-in-out; }
        @keyframes VOLUNTER-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.08); } }
        .VOLUNTER-image-star { position: absolute; font-size: 1.5rem; color: var(--accent-gold); opacity: 0.7; }
        .VOLUNTER-image-star--1 { top: -15px; left: -15px; }
        .VOLUNTER-image-star--2 { bottom: -10px; right: 30px; font-size: 1.2rem; }
    </style>
</head>
<body>

<!-- ===== NAVBAR (SAMA DENGAN INDEX.PHP) ===== -->
<nav class="navbar">
    <div class="container">
        <div class="navbar__logo">
            <a href="#"><img src="gbr/mylog.png" alt="Logo" class="logo-img"></a>
        </div>
        <div class="navbar__right">
            <div class="social-icons-header">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
            <a href="http://localhost/appbantumereka" class="btn-download-app"><i class="fas fa-download"></i> Download App</a>
        </div>
        <button class="navbar-toggle" id="navbarToggle"><i class="fas fa-bars"></i></button>
        <ul class="navbar__links" id="navbarLinks">
            <li><a href="index.php">Beranda</a></li>
            <li><a href="about.php">Tentang Kami</a></li>
            <li><a href="http://localhost/appbantumereka/" class="btn-nav-donate"><i class="fas fa-heart"></i> Donasi</a></li>
        </ul>
    </div>
</nav>

<!-- HERO -->
<section class="hero-about">
    <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
        <div class="hero-badge">✨ Platform Donasi Berbasis Blockchain Pertama di Indonesia</div>
        <h1>Jembatan <span>Kebaikan</span> untuk Negeri</h1>
        <p>Kami hadir untuk membangun ekosistem donasi modern yang transparan, tanpa potongan, dan tercatat selamanya di blockchain.</p>
    </div>
</section>

<!-- STORY -->
<section class="section" style="background: #f8f9fa;">
    <div class="container">
        <div class="story-grid">
            <div class="story-image-wrapper" data-aos="fade-right" data-aos-duration="800">
                <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?w=700&q=80" alt="Bantu Mereka">
            </div>
            <div class="story-text" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                <span class="section-label">Cerita Kami</span>
                <h2>Lahir dari Kepedulian, Tumbuh oleh Kepercayaan</h2>
                <p>Di tengah maraknya ketidakpercayaan terhadap lembaga donasi, Bantu Mereka hadir sebagai jawaban. Kami menggabungkan teknologi <strong>blockchain</strong> dan <strong>smart contract</strong> untuk menciptakan platform donasi yang sepenuhnya transparan.</p>
                <p>Setiap rupiah yang Anda donasikan tercatat di rantai blok publik, tidak dapat dimanipulasi, dan 100% tersalurkan kepada yang membutuhkan. Biaya operasional kami ditanggung oleh lini bisnis mandiri, sehingga donasi Anda utuh tanpa potongan.</p>
            </div>
        </div>
    </div>
</section>

<!-- VISI & MISI -->
<section class="section" style="background: linear-gradient(135deg, #E8F0FE 0%, #ffffff 100%);">
    <div class="container">
        <div style="text-align:center;" data-aos="fade-up">
            <span class="section-label">Arah Kami</span>
            <h2>Visi & Misi</h2>
        </div>
        <div class="vm-grid">
            <div class="vm-card" data-aos="zoom-in" data-aos-delay="100">
                <div class="icon-circle" style="background: linear-gradient(135deg, #C62828, #e53935);"><i class="fas fa-eye"></i></div>
                <h4>Visi Kami</h4>
                <p>Menjadi platform donasi blockchain terpercaya di Asia Tenggara, menciptakan ekosistem donasi modern tanpa perantara.</p>
            </div>
            <div class="vm-card" data-aos="zoom-in" data-aos-delay="200">
                <div class="icon-circle" style="background: linear-gradient(135deg, #D4AF37, #f4c430);"><i class="fas fa-bullseye"></i></div>
                <h4>Misi Kami</h4>
                <p>Membangun platform transparan, menyalurkan donasi tepat sasaran, dan memberdayakan masyarakat melalui program berkelanjutan.</p>
            </div>
            <div class="vm-card" data-aos="zoom-in" data-aos-delay="300">
                <div class="icon-circle" style="background: linear-gradient(135deg, #0A2540, #1a3a5c);"><i class="fas fa-heart"></i></div>
                <h4>Nilai Kami</h4>
                <p>Transparansi, akuntabilitas, inovasi, dan kemanusiaan adalah nilai-nilai yang memandu setiap langkah kami.</p>
            </div>
        </div>
    </div>
</section>

<!-- TIM -->
<section class="section">
    <div class="container">
        <div style="text-align:center; margin-bottom:50px;" data-aos="fade-up">
            <span class="section-label">Orang di Balik Platform</span>
            <h2>Tim Kami</h2>
            <p style="max-width:600px; margin:0 auto;">Dipimpin oleh para profesional yang berdedikasi untuk misi kemanusiaan.</p>
        </div>
        <div class="team-masonry">
            <?php
            $team = $conn->query("SELECT * FROM team ORDER BY urutan ASC");
            $base_app_url = 'http://localhost/appbantumereka';
            while($t = $team->fetch_assoc()):
                $foto_url = $t['foto'] ? $base_app_url . '/uploads/tim/' . $t['foto'] : 'https://via.placeholder.com/400x400?text=No+Photo';
            ?>
            <div class="team-card" data-aos="fade-up" data-aos-delay="<?= $t['urutan'] * 100 ?>">
                <img src="<?= htmlspecialchars($foto_url) ?>" alt="<?= htmlspecialchars($t['nama']) ?>">
                <div class="team-info">
                    <h4><?= htmlspecialchars($t['nama']) ?></h4>
                    <div class="job"><?= htmlspecialchars($t['jabatan']) ?></div>
                    <div class="bio"><?= htmlspecialchars($t['bio']) ?></div>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- LEGALITAS -->
<section class="section" style="background: #f8f9fa;">
    <div class="container">
        <div class="legal-split">
            <div class="legal-visual" data-aos="fade-right">
                <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=600&q=80" alt="Legalitas">
                <div class="stamp">LEGAL & AUDITED</div>
            </div>
            <div data-aos="fade-left" data-aos-delay="200">
                <span class="section-label">Kredibilitas</span>
                <h2>Legalitas & Keamanan</h2>
                <p><strong>Yayasan Bantu Mereka</strong> terdaftar resmi di Kementerian Hukum dan HAM RI dengan nomor AHU-0012345.AH.01.12 Tahun 2025. Smart contract kami telah diaudit oleh <strong>CertiK Security</strong> dan dinyatakan aman. Laporan keuangan dipublikasikan secara berkala dan dapat diakses oleh publik.</p>
            </div>
        </div>
    </div>
</section>

<!-- PARTNER -->
<section class="section">
    <div class="container">
        <div style="text-align:center; margin-bottom:40px;" data-aos="fade-up">
            <span class="section-label">Bersama</span>
            <h2>Partner & Pendukung</h2>
        </div>
        <div class="partner-strip" data-aos="fade-up">
            <?php
            $partners = $conn->query("SELECT * FROM partners ORDER BY urutan ASC");
            while($p = $partners->fetch_assoc()):
                $logo_url = $p['logo'] ? $base_app_url . '/uploads/partner/' . $p['logo'] : 'https://via.placeholder.com/150x50?text=No+Logo';
            ?>
            <a href="<?= htmlspecialchars($p['website_url']) ?>" target="_blank">
                <img src="<?= htmlspecialchars($logo_url) ?>" alt="<?= htmlspecialchars($p['nama']) ?>">
            </a>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container" data-aos="fade-up">
        <h2>Siap Menjadi Bagian dari Perubahan?</h2>
        <p>Bersama kita bisa menjangkau lebih banyak yang membutuhkan.</p>
        <a href="http://localhost/appbantumereka/" class="btn-cta"><i class="fas fa-heart"></i> Mulai Donasi Sekarang</a>
    </div>
</section>

<!-- ===== VOLUNTER SECTION ===== -->
<section class="VOLUNTER-section">
    <div class="VOLUNTER-ornament VOLUNTER-ornament--dots"></div>
    <div class="VOLUNTER-ornament VOLUNTER-ornament--circle"></div>
    <div class="VOLUNTER-ornament VOLUNTER-ornament--wave"></div>
    <div class="VOLUNTER-ornament VOLUNTER-ornament--sparkle"></div>

    <div class="container VOLUNTER-container">
        <div class="VOLUNTER-hero">
            <h2 class="VOLUNTER-heading">
                atau ... <span>Bantu</span> Kami
            </h2>
            <p class="VOLUNTER-subheading">
                Tidak semua bisa berdonasi, tapi semua bisa peduli. Laporkan mereka yang membutuhkan, atau terjun langsung sebagai relawan — pilih caramu berkontribusi.
            </p>
            <div class="VOLUNTER-divider"><span><i class="fas fa-heart"></i></span></div>
        </div>

        <div class="VOLUNTER-grid">
            <!-- KIRI: Kirim Data -->
            <div class="VOLUNTER-card VOLUNTER-card--data">
                <div class="VOLUNTER-card-badge">📋 Beri Tahu Kami</div>
                <div class="VOLUNTER-card-inner">
                    <div class="VOLUNTER-card-icon"><i class="fas fa-clipboard-list"></i></div>
                    <h4>Data Calon Penerima</h4>
                    <p>Punya tetangga yang kelaparan? Kenal anak putus sekolah di sekitar? Cukup laporkan, tim kami yang akan bergerak.</p>
                    <a href="http://localhost/bantumereka/kirim-data.php" class="VOLUNTER-btn VOLUNTER-btn--data">
                        <i class="fas fa-paper-plane"></i> Saya Mau Kirim Data
                    </a>
                </div>
                <div class="VOLUNTER-card-line"></div>
                <div class="VOLUNTER-card-dot"></div>
            </div>

            <!-- TENGAH: Gambar -->
            <div class="VOLUNTER-image">
                <div class="VOLUNTER-image-frame">
                    <img src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Mereka yang membutuhkan uluran tangan">
                    <div class="VOLUNTER-image-badge">❤️</div>
                </div>
                <div class="VOLUNTER-image-glow"></div>
                <div class="VOLUNTER-image-star VOLUNTER-image-star--1">✦</div>
                <div class="VOLUNTER-image-star VOLUNTER-image-star--2">✧</div>
            </div>

            <!-- KANAN: Relawan -->
            <div class="VOLUNTER-card VOLUNTER-card--volunteer">
                <div class="VOLUNTER-card-badge">🙌 Aksi Langsung</div>
                <div class="VOLUNTER-card-inner">
                    <div class="VOLUNTER-card-icon"><i class="fas fa-hands-helping"></i></div>
                    <h4>Jadi Relawan</h4>
                    <p>Bukan hanya uang yang dibutuhkan, tapi juga kehadiran. Tanganmu adalah harapan yang dinanti. Daftar sekarang, jadilah pahlawan tanpa jubah.</p>
                    <a href="http://localhost/bantumereka/relawan.php" class="VOLUNTER-btn VOLUNTER-btn--volunteer">
                        <i class="fas fa-user-plus"></i> Mau Jadi Relawan
                    </a>
                </div>
                <div class="VOLUNTER-card-line"></div>
                <div class="VOLUNTER-card-dot"></div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <p>&copy; <?= date('Y') ?> <a href="index.php">Bantu Mereka Foundation</a>. Platform donasi blockchain pertama di Indonesia. 100% tersalurkan tanpa potongan.</p>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });

    // Navbar toggle untuk mobile
    document.getElementById('navbarToggle').addEventListener('click', function() {
        document.getElementById('navbarLinks').classList.toggle('active');
    });
</script>
</body>
</html>