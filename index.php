<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://bantumereka.org/">
    <meta property="og:title" content="Bantu Mereka - Platform Kebaikan Transparan dan Akuntabel With Blockchain">
    <meta property="og:description" content="Bantu Mereka adalah satu-satunya platform donasi berbasis blockchain di Indonesia. Donasi 100% tersalurkan tanpa potongan. Transparansi terjamin dengan smart contract.">
    <meta property="og:image" content="https://bantumereka.org/gbr/mylog.png">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="315">
    <meta property="og:image:alt" content="Logo Bantu Mereka">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://bantumereka.org/">
    <meta name="twitter:title" content="Bantu Mereka - Platform Kebaikan Transparan dan Akuntabel With Blockchain">
    <meta name="twitter:description" content="Bantu Mereka adalah satu-satunya platform donasi berbasis blockchain di Indonesia. Donasi 100% tersalurkan tanpa potongan. Transparansi terjamin dengan smart contract.">
    <meta name="twitter:image" content="https://bantumereka.org/gbr/mylog.png">
    <meta name="description" content="Bantu Mereka adalah satu-satunya platform donasi berbasis blockchain di Indonesia. Donasi 100% tersalurkan tanpa potongan. Transparansi terjamin dengan smart contract.">
    <meta name="keywords" content="Donasi, Blockchain, Sedekah, Galang Dana, Yayasan, Bantu Mereka, Smart Contract, Tanpa Potongan">
    <meta name="author" content="Bantu Mereka">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantu Mereka - Platform Kebaikan Transparan dan Akuntabel With Blockchain</title>
    <link rel="shortcut icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='0.9em' font-size='90'>🤝</text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

    <style>
        :root {
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
        .container { max-width: 1140px; margin: 0 auto; padding: 0 20px; }

        /* ===== NAVBAR ===== */
        .navbar { background: rgba(255,255,255,0.97); backdrop-filter: blur(10px); padding: 12px 0; position: sticky; top: 0; z-index: 1000; box-shadow: 0 2px 20px rgba(0,0,0,0.05); transition: all var(--transition-speed) ease; }
        .navbar .container { display: flex; align-items: center; gap: 15px; }
        .navbar__logo a { font-size: 1.6rem; font-weight: 800; color: var(--deep-blue); text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .navbar__logo a i { color: var(--primary-red); font-size: 1.7rem; }
        .navbar__right { display: flex; align-items: center; gap: 12px; }
        .social-icons-header a { color: var(--deep-blue); margin-left: 8px; font-size: 1.1rem; transition: color var(--transition-speed); }
        .social-icons-header a:hover { color: var(--accent-gold); }
        .btn-download-app { background: var(--accent-gold); color: var(--deep-blue); padding: 8px 14px; border-radius: 30px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 0.8rem; box-shadow: 0 4px 12px rgba(212,175,55,0.25); transition: all var(--transition-speed); }
        .btn-download-app:hover { background: #c9a52c; color: white; transform: translateY(-1px); }
        .navbar__links { display: flex; align-items: center; gap: 18px; list-style: none; margin-left: auto; }
        .navbar__links a { text-decoration: none; color: var(--deep-blue); font-weight: 600; font-size: 0.9rem; transition: color var(--transition-speed); }
        .navbar__links a:hover { color: var(--primary-red); }
        .btn-nav-donate { background: var(--primary-red); color: white !important; padding: 8px 20px; border-radius: 50px; font-weight: 700; box-shadow: 0 4px 14px rgba(198,40,40,0.3); transition: all var(--transition-speed); }
        .btn-nav-donate:hover { background: #a51d1d; }
        .navbar-toggle { display: none; background: none; border: none; font-size: 1.6rem; color: var(--deep-blue); cursor: pointer; }
        .logo-img { height: 45px; width: auto; display: block; }

        /* ===== HERO SLIDER ===== */
        .hero-slider-section { background: linear-gradient(180deg, var(--off-white) 0%, #fff 100%); padding: 25px 0 0; }
        .hero-slider-container { width: 88vw; margin: 0 auto; max-width: 1200px; }
        .hero-slide-item { border-radius: 18px; overflow: hidden; margin: 0 8px; box-shadow: var(--shadow-md); position: relative; }
        .hero-slide-item img { width: 100%; height: 380px; object-fit: cover; display: block; }
        .hero-slide-overlay { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); color: white; padding: 28px 20px 20px; }
        .hero-slide-overlay h2 { font-size: 1.6rem; font-weight: 800; margin-bottom: 6px; }
        .hero-slide-overlay p { font-size: 0.9rem; opacity: 0.95; }
        .btn-slide-donate { background: var(--accent-gold); color: var(--deep-blue); padding: 8px 20px; border-radius: 30px; font-weight: 700; text-decoration: none; display: inline-block; transition: all var(--transition-speed); margin-top: 8px; font-size: 0.85rem; }
        .btn-slide-donate:hover { background: #c9a52c; transform: scale(1.02); }
        .slick-dots { display: none !important; }

        /* ===== VIDEO FLOATING ===== */
        .video-floating-section { position: relative; padding: 20px 0 0; margin-top: -70px; z-index: 5; }
        .video-floating-card { background: white; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.15); max-width: 600px; margin: 0 auto; overflow: hidden; position: relative; transition: all 0.3s ease; display: none; }
        .video-floating-card iframe { width: 100%; height: 315px; border: none; display: block; }
        .video-close-btn { position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.7); color: white; border: none; border-radius: 50%; width: 32px; height: 32px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; transition: background 0.2s; }
        .video-close-btn:hover { background: var(--primary-red); }
        .video-play-button { display: flex; align-items: center; justify-content: center; margin: 15px auto 0; width: 70px; height: 70px; background: var(--primary-red); border-radius: 50%; position: relative; cursor: pointer; box-shadow: 0 8px 20px rgba(198,40,40,0.25); transition: all 0.3s ease; z-index: 6; }
        .video-play-button::after { content: ""; position: absolute; top: -6px; left: -6px; right: -6px; bottom: -6px; border: 2px solid var(--primary-red); border-radius: 50%; opacity: 0.6; pointer-events: none; animation: pulse-outline 2s infinite ease-out; }
        @keyframes pulse-outline { 0% { transform: scale(1); opacity: 0.6; } 50% { transform: scale(1.15); opacity: 0.2; } 100% { transform: scale(1); opacity: 0.6; } }
        .video-play-button i { color: white; font-size: 1.8rem; margin-left: 4px; }
        .video-play-button:hover { background: #a51d1d; transform: scale(1.05); }

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

        /* ===== NEW3 INTRO SECTION ===== */
        .NEW3-intro-section { padding: 80px 0; background: linear-gradient(135deg, #E8F0FE 0%, #FFFFFF 100%); overflow: hidden; position: relative; margin-top: -50px; }
        .NEW3-intro-section::before { content: ""; position: absolute; top: -60px; right: -60px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(212,175,55,0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none; }
        .NEW3-intro-content { display: flex; align-items: center; gap: 50px; flex-wrap: wrap; }
        .NEW3-intro-image { flex: 0 0 35%; min-width: 250px; position: relative; }
        .NEW3-intro-image img { width: 100%; border-radius: 28px; box-shadow: 0 20px 40px rgba(0,0,0,0.08); display: block; }
        .NEW3-intro-image::after { content: "❤️"; position: absolute; bottom: -20px; right: -20px; font-size: 2.5rem; background: var(--accent-gold); width: 65px; height: 65px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(212,175,55,0.35); }
        .NEW3-intro-text { flex: 1; padding: 10px 0; display: flex; flex-direction: column; gap: 18px; }
        .NEW3-motto-big { font-size: 2.4rem; font-weight: 800; color: var(--deep-blue); line-height: 1.2; }
        .NEW3-motto-big span { color: var(--primary-red); position: relative; }
        .NEW3-motto-big span::after { content: ""; position: absolute; bottom: 2px; left: 0; width: 100%; height: 6px; background: var(--accent-gold); opacity: 0.5; border-radius: 3px; }
        .NEW3-motto-medium { font-size: 1.15rem; font-weight: 600; color: var(--text-grey); line-height: 1.5; padding-left: 25px; border-left: 4px solid var(--accent-gold); }
        .NEW3-motto-small { font-size: 0.95rem; color: var(--text-grey); line-height: 1.7; font-style: italic; background: rgba(255,255,255,0.7); padding: 14px 18px; border-radius: 14px; backdrop-filter: blur(5px); }
        .NEW3-btn-join { background: var(--primary-red); color: white; padding: 14px 32px; border-radius: 50px; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 8px 20px rgba(198,40,40,0.25); transition: all 0.2s ease; align-self: flex-start; font-size: 1rem; }
        .NEW3-btn-join:hover { background: #a51d1d; transform: translateY(-2px); color: white; }

        /* ===== NEW1 STATS ===== */
        .NEW1-stats-section { background: linear-gradient(135deg, var(--soft-blue) 0%, var(--white) 100%); padding: 40px 0 30px; position: relative; overflow: hidden; }
        .NEW1-stats-section::before { content: ""; position: absolute; top: -30px; right: -30px; width: 180px; height: 180px; background: radial-gradient(circle, var(--light-gold) 0%, transparent 70%); opacity: 0.3; border-radius: 50%; pointer-events: none; }
        .NEW1-stats-header { text-align: center; margin-bottom: 30px; }
        .NEW1-stats-header h2 { font-size: 2rem; font-weight: 800; color: var(--deep-blue); margin-bottom: 6px; }
        .NEW1-stats-header p { color: var(--text-grey); font-size: 0.95rem; max-width: 550px; margin: 0 auto; }
        .NEW1-stats-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 18px; }
        .NEW1-stat-card { background: var(--white); border-radius: 18px; padding: 22px 18px; text-align: center; flex: 1 1 150px; max-width: 190px; box-shadow: 0 8px 20px rgba(0,0,0,0.04); transition: all 0.2s ease; border: 1px solid rgba(0,0,0,0.02); }
        .NEW1-stat-card:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.06); border-color: var(--accent-gold); }
        .NEW1-stat-icon { font-size: 2rem; margin-bottom: 8px; color: var(--accent-gold); }
        .NEW1-stat-number { font-size: 2rem; font-weight: 800; color: var(--deep-blue); line-height: 1.2; }
        .NEW1-stat-label { font-size: 0.8rem; color: var(--text-grey); margin-top: 4px; font-weight: 600; }
        .NEW1-stat-sub { font-size: 0.7rem; color: var(--primary-red); margin-top: 2px; font-weight: 700; opacity: 0.8; }

        /* ===== NEW1 FEATURES ===== */
        .NEW1-features-section { padding: 40px 0; background: var(--white); }
        .NEW1-features-header { text-align: center; margin-bottom: 35px; }
        .NEW1-features-header h2 { font-size: 1.9rem; font-weight: 800; color: var(--deep-blue); margin-bottom: 6px; }
        .NEW1-features-header p { color: var(--text-grey); max-width: 600px; margin: 0 auto; font-size: 0.9rem; }
        .NEW1-features-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; }
        .NEW1-feature-card { background: var(--white); border-radius: 18px; padding: 24px 18px; flex: 1 1 240px; max-width: 290px; box-shadow: 0 8px 20px rgba(0,0,0,0.04); transition: all 0.2s ease; border: 1px solid #eee; text-align: center; position: relative; overflow: hidden; }
        .NEW1-feature-card::after { content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 3px; background: var(--accent-gold); transform: scaleX(0); transform-origin: left; transition: transform 0.2s ease; }
        .NEW1-feature-card:hover::after { transform: scaleX(1); }
        .NEW1-feature-card:hover { transform: translateY(-4px); box-shadow: 0 15px 30px rgba(0,0,0,0.06); border-color: transparent; }
        .NEW1-feature-icon { font-size: 2.2rem; color: var(--deep-blue); margin-bottom: 12px; }
        .NEW1-feature-card h4 { font-size: 1.1rem; font-weight: 800; color: var(--deep-blue); margin-bottom: 10px; }
        .NEW1-feature-card p { color: var(--text-grey); font-size: 0.8rem; line-height: 1.5; margin-bottom: 14px; }
        .NEW1-feature-badge { display: inline-block; background: var(--soft-blue); color: var(--deep-blue); padding: 4px 12px; border-radius: 18px; font-weight: 700; font-size: 0.7rem; margin-bottom: 10px; }
        .NEW1-feature-cta { margin-top: 30px; text-align: center; }
        .NEW1-join-button { background: var(--primary-red); color: white; padding: 12px 30px; border-radius: 50px; text-decoration: none; font-weight: 700; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 6px 18px rgba(198,40,40,0.25); transition: all var(--transition-speed); }
        .NEW1-join-button:hover { background: #a51d1d; transform: translateY(-2px); color: white; }

        /* ===== NEW2 PROGRAMS ===== */
        .NEW2-programs-section { padding: 40px 0; background: var(--white); position: relative; overflow: hidden; }
        .NEW2-programs-section--cream { background: var(--cream); }
        .NEW2-section-header { text-align: center; margin-bottom: 30px; }
        .NEW2-section-header h2 { font-weight: 800; font-size: 1.8rem; color: var(--deep-blue); margin-bottom: 6px; }
        .NEW2-section-header p { color: var(--text-grey); max-width: 550px; margin: 0 auto; font-size: 0.85rem; }
        .NEW2-slider-3d-wrapper { position: relative; max-width: 1050px; margin: 0 auto; padding: 0 40px; }
        .NEW2-slider-3d-wrapper::before { content: ""; position: absolute; top: 38%; left: 20px; width: calc(100% - 40px); height: 55%; background: var(--soft-blue); border-radius: 28px; z-index: 0; opacity: 0.6; }
        .NEW2-slider-3d { position: relative; z-index: 1; }
        .NEW2-slider-3d .slick-list { padding: 18px 0 !important; }
        .NEW2-donation-card { background: var(--white); border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.06); margin: 0 10px; transition: all var(--transition-speed); border: 1px solid #eee; text-align: left; }
        .NEW2-donation-card:hover { transform: translateY(-5px); box-shadow: 0 18px 35px rgba(0,0,0,0.1); }
        .NEW2-donation-card img { width: 100%; height: 170px; object-fit: cover; }
        .NEW2-donation-card-body { padding: 15px 14px; }
        .NEW2-donation-card-body h4 { font-size: 0.95rem; font-weight: 700; color: var(--deep-blue); margin-bottom: 5px; }
        .NEW2-donation-card-body .raised { font-size: 0.85rem; font-weight: 800; color: var(--deep-blue); }
        .NEW2-donation-card-body .raised-label { font-size: 0.65rem; color: var(--text-grey); }
        .NEW2-donation-card-body .btn-donate-sm { display: inline-block; background: var(--primary-red); color: white; padding: 6px 14px; border-radius: 25px; font-weight: 700; text-decoration: none; font-size: 0.75rem; margin-top: 8px; transition: all var(--transition-speed); }
        .NEW2-donation-card-body .btn-donate-sm:hover { background: #a51d1d; }
        .NEW2-slider-arrow { position: absolute; top: 50%; transform: translateY(-50%); z-index: 2; background: var(--white); border: 2px solid var(--accent-gold); color: var(--deep-blue); width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: all var(--transition-speed); }
        .NEW2-slider-arrow:hover { background: var(--accent-gold); color: white; border-color: var(--accent-gold); }
        .NEW2-slider-arrow--prev { left: 0; }
        .NEW2-slider-arrow--next { right: 0; }
        .NEW2-category-filters { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin-bottom: 25px; }
        .NEW2-category-filters button { background: var(--white); border: 1px solid #ddd; padding: 6px 14px; border-radius: 20px; font-weight: 600; font-size: 0.75rem; cursor: pointer; transition: all var(--transition-speed); color: var(--text-dark); }
        .NEW2-category-filters button:hover, .NEW2-category-filters button.active { background: var(--primary-red); color: white; border-color: var(--primary-red); }
        .NEW2-link-more { text-align: center; margin-top: 25px; }
        .NEW2-link-more a { color: var(--primary-red); font-weight: 700; text-decoration: none; font-size: 0.9rem; }
        .NEW2-link-more a:hover { color: #a51d1d; }

        /* ===== ARTICLES ===== */
        .NEW2-articles-section { padding: 40px 0; background: var(--white); }
        .NEW2-articles-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; }
        .NEW2-article-card { background: var(--white); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow-sm); border: 1px solid #eee; transition: all var(--transition-speed); }
        .NEW2-article-card:hover { transform: translateY(-3px); box-shadow: 0 12px 25px rgba(0,0,0,0.07); }
        .NEW2-article-card img { width: 100%; height: 140px; object-fit: cover; }
        .NEW2-article-card-body { padding: 14px; }
        .NEW2-article-card-body .date { font-size: 0.7rem; color: var(--text-grey); margin-bottom: 4px; }
        .NEW2-article-card-body h4 { font-size: 0.85rem; font-weight: 700; color: var(--deep-blue); line-height: 1.35; }
        .section-header { text-align: center; margin-bottom: 28px; }
        .section-header h2 { font-weight: 800; font-size: 1.8rem; color: var(--deep-blue); margin-bottom: 6px; }
        .section-header p { color: var(--text-grey); max-width: 550px; margin: 0 auto; font-size: 0.85rem; }

        /* ===== ABOUT ===== */
        .about-section { padding: 40px 0; background: var(--cream); }
        .about-content { display: flex; align-items: center; gap: 35px; flex-wrap: wrap; }
        .about-text { flex: 1 1 340px; }
        .about-text h2 { font-size: 1.7rem; font-weight: 800; color: var(--deep-blue); margin-bottom: 14px; }
        .about-text p { color: var(--text-grey); line-height: 1.6; margin-bottom: 12px; font-size: 0.85rem; }
        .about-image { flex: 1 1 340px; }
        .about-image img { width: 100%; border-radius: var(--radius); box-shadow: var(--shadow-md); }

        /* ===== CTA ===== */
        .cta-section { background: linear-gradient(135deg, #0A2540 0%, #1A3A5C 100%); padding: 50px 0; text-align: center; color: white; }
        .cta-section h2 { font-weight: 800; font-size: 1.8rem; margin-bottom: 8px; }
        .cta-section p { opacity: 0.9; max-width: 500px; margin: 0 auto 22px; font-size: 0.9rem; }
        .btn-cta-primary { background: var(--accent-gold); color: var(--deep-blue); padding: 12px 32px; border-radius: 50px; font-weight: 700; text-decoration: none; display: inline-block; box-shadow: 0 6px 18px rgba(212,175,55,0.3); transition: all var(--transition-speed); }
        .btn-cta-primary:hover { background: #c9a52c; transform: translateY(-2px); }

        /* ===== FOOTER ===== */
        .footer { background: #0A1929; color: #ccc; padding: 40px 0 22px; }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px,1fr)); gap: 25px; }
        .footer h5 { color: white; margin-bottom: 10px; font-weight: 700; font-size: 0.9rem; }
        .footer a { color: #bbb; text-decoration: none; font-size: 0.8rem; transition: color var(--transition-speed); }
        .footer a:hover { color: var(--accent-gold); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); margin-top: 25px; padding-top: 15px; text-align: center; font-size: 0.75rem; opacity: 0.7; }

        /* ===== WHATSAPP FLOAT ===== */
        .NEW3-wa-float { position: fixed; bottom: 25px; right: 25px; z-index: 9999; background: #25D366; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; box-shadow: 0 6px 22px rgba(37,211,102,0.4); text-decoration: none; transition: all var(--transition-speed); }
        .NEW3-wa-float:hover { transform: scale(1.1); color: white; }
        .NEW3-wa-float span { position: absolute; top: -6px; right: -6px; background: var(--primary-red); color: white; font-size: 0.6rem; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .VOLUNTER-heading { font-size: 2rem; }
            .VOLUNTER-grid { flex-direction: column; }
            .VOLUNTER-card { max-width: 100%; margin: 0 !important; }
            .VOLUNTER-card--data .VOLUNTER-card-inner,
            .VOLUNTER-card--volunteer .VOLUNTER-card-inner { transform: rotate(0deg); }
            .VOLUNTER-image { flex: 0 0 auto; max-width: 280px; margin: 0 auto; order: -1; }
        }
        @media (max-width: 768px) {
            .NEW3-intro-content { flex-direction: column; }
            .NEW3-intro-image { flex: 0 0 100%; max-width: 400px; margin: 0 auto; }
            .NEW3-motto-big { font-size: 1.8rem; }
            .video-floating-card iframe { height: 200px; }
            .navbar-toggle { display: block; }
            .navbar__links { display: none; flex-direction: column; position: absolute; top: 100%; left: 0; right: 0; background: white; padding: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
            .navbar__links.active { display: flex; }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
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
            <li><a href="#">Beranda</a></li>
            <li><a href="about.php">Tentang Kami</a></li>
            <li><a href="http://localhost/appbantumereka/" class="btn-nav-donate"><i class="fas fa-heart"></i> Donasi</a></li>
        </ul>
    </div>
</nav>

<!-- ===== HERO SLIDER ===== -->
<section class="hero-slider-section">
    <div class="hero-slider-container">
        <div class="hero-slider" id="heroSlider">
            <?php
            $slides = [
                ['image' => 'https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1050&q=80', 'title' => 'Blockchain Mendukung Kemanusiaan', 'desc' => 'Donasi transparan dengan smart contract.'],
                ['image' => 'https://images.pexels.com/photos/6646918/pexels-photo-6646918.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 'title' => '100% Tersalurkan Tanpa Potongan', 'desc' => 'Operasional kami dari bisnis lain.'],
                ['image' => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?ixlib=rb-4.0.3&auto=format&fit=crop&w=1050&q=80', 'title' => 'Bantu Sesama, Wujudkan Perubahan', 'desc' => 'Platform donasi pertama berbasis blockchain.']
            ];
            foreach ($slides as $slide):
            ?>
            <div class="hero-slide-item">
                <img src="<?= $slide['image'] ?>" alt="">
                <div class="hero-slide-overlay">
                    <h2><?= $slide['title'] ?></h2>
                    <p><?= $slide['desc'] ?></p>
                    <a href="http://localhost/appbantumereka/" class="btn-slide-donate">Donasi Sekarang <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== VIDEO FLOATING ===== -->
<div class="video-floating-section">
    <div class="container" style="max-width:650px; text-align:center;">
        <div class="video-floating-card" id="videoCard">
            <button class="video-close-btn" id="closeVideoBtn"><i class="fas fa-times"></i></button>
            <iframe id="youtubeVideo" width="100%" height="315"
                src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&mute=1&rel=0"
                title="Bantu Mereka Video" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        </div>
        <div class="video-play-button" id="reopenVideoBtn">
            <i class="fas fa-play"></i>
        </div>
    </div>
</div>

<!-- ===== VOLUNTER SECTION ===== -->
<section class="VOLUNTER-section">
    <div class="VOLUNTER-ornament VOLUNTER-ornament--dots"></div>
    <div class="VOLUNTER-ornament VOLUNTER-ornament--circle"></div>
    <div class="VOLUNTER-ornament VOLUNTER-ornament--wave"></div>
    <div class="VOLUNTER-ornament VOLUNTER-ornament--sparkle"></div>

    <div class="container VOLUNTER-container">
        <div class="VOLUNTER-hero">
            <span class="VOLUNTER-eyebrow">🤝 Cara Lain Berkontribusi, Selain BER-DONASI</span>
            <h2 class="VOLUNTER-heading">
                Kenali <span>Mereka</span>, dan <span>Bantu</span> Kami Menjangkau
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

<!-- ===== NEW3 INTRO SECTION ===== -->
<section class="NEW3-intro-section">
    <div class="container">
        <div class="NEW3-intro-content">
            <div class="NEW3-intro-image">
                <img src="https://images.unsplash.com/photo-1509099836639-18ba1795216d?q=80&w=1631&auto=format&fit=crop" alt="Kepedulian bersama">
            </div>
            <div class="NEW3-intro-text">
                <div class="NEW3-motto-big">Karena <span>Setetes Kebaikan</span> Bisa Menjadi <span>Samudra Harapan</span></div>
                <div class="NEW3-motto-medium">Donasi Anda — tanpa potongan, tercatat selamanya di blockchain.</div>
                <div class="NEW3-motto-small">"Bukan berapa banyak yang kita beri, tapi seberapa tulus hati yang mengulurkan tangan."</div>
                <a href="http://localhost/appbantumereka" class="NEW3-btn-join">Mulai Donasi <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- ===== STATS ===== -->
<section class="NEW1-stats-section">
    <div class="container">
        <div class="NEW1-stats-header">
            <h2>Dampak Nyata Kami</h2>
            <p>Setiap angka adalah cerita, setiap statistik adalah kehidupan yang telah Anda sentuh bersama sama.</p>
        </div>
        <div class="NEW1-stats-grid">
            <?php
            $total_program_aktif  = $conn->query("SELECT COUNT(*) AS total FROM program WHERE is_active=1")->fetch_assoc()['total'];
            $total_penerima       = $conn->query("SELECT COUNT(*) AS total FROM distribution_recipients")->fetch_assoc()['total'];
            $total_donatur_semua  = $conn->query("SELECT COUNT(DISTINCT email) AS total FROM donasi")->fetch_assoc()['total'];
            $stats = [
                ['icon' => 'fas fa-globe-asia',         'number' => '6',                 'label' => 'Negara Program',     'sub' => 'Jangkauan Global'],
                ['icon' => 'fas fa-users',               'number' => $total_penerima,      'label' => 'Penerima Manfaat',   'sub' => 'Kehidupan Tersentuh'],
                ['icon' => 'fas fa-hand-holding-heart',  'number' => $total_program_aktif, 'label' => 'Program Aktif',      'sub' => 'Aksi Berkelanjutan'],
                ['icon' => 'fas fa-donate',              'number' => $total_donatur_semua, 'label' => 'Donatur Tergabung',  'sub' => 'Komunitas Tumbuh'],
            ];
            foreach ($stats as $stat):
            ?>
            <div class="NEW1-stat-card">
                <div class="NEW1-stat-icon"><i class="<?= $stat['icon'] ?>"></i></div>
                <div class="NEW1-stat-number"><?= number_format($stat['number'], 0, ',', '.') ?></div>
                <div class="NEW1-stat-label"><?= $stat['label'] ?></div>
                <div class="NEW1-stat-sub"><?= $stat['sub'] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== FITUR BLOCKCHAIN ===== -->
<section class="NEW1-features-section" id="blockchain">
    <div class="container">
        <div class="NEW1-features-header">
            <h2>Teknologi yang Membawa Perubahan</h2>
            <p>Kami membangun kepercayaan tanpa batas dengan blockchain.</p>
        </div>
        <div class="NEW1-features-grid">
            <div class="NEW1-feature-card">
                <div class="NEW1-feature-icon"><i class="fas fa-link"></i></div>
                <span class="NEW1-feature-badge">Smart Contract Audited</span>
                <h4>Blockchain Transparan</h4>
                <p>Setiap transaksi tercatat di blockchain publik. Lacak donasi Anda kapan saja.</p>
                <p style="font-size:0.7rem; font-weight:600; color:var(--deep-blue);">Didukung CertiK Security</p>
            </div>
            <div class="NEW1-feature-card">
                <div class="NEW1-feature-icon"><i class="fas fa-hand-holding-usd"></i></div>
                <span class="NEW1-feature-badge">Tanpa Potongan</span>
                <h4>100% Tersalurkan</h4>
                <p>Operasional dari bisnis mandiri, donasi Anda sepenuhnya untuk penerima manfaat.</p>
                <p style="font-size:0.7rem; font-weight:600; color:var(--primary-red);">Baca Laporan Keuangan →</p>
            </div>
            <div class="NEW1-feature-card">
                <div class="NEW1-feature-icon"><i class="fas fa-shield-alt"></i></div>
                <span class="NEW1-feature-badge">Keamanan Web3</span>
                <h4>Desentralisasi & Aman</h4>
                <p>Enkripsi tinggi dan desentralisasi melindungi data serta donasi Anda.</p>
                <p style="font-size:0.7rem; font-weight:600; color:var(--deep-blue);">Pelajari Keamanan →</p>
            </div>
        </div>
        <div class="NEW1-feature-cta">
            <a href="http://localhost/appbantumereka" class="NEW1-join-button"><i class="fas fa-user-plus"></i> Bergabung & Mulai Donasi</a>
        </div>
    </div>
</section>

<!-- ===== PROGRAM PRIORITAS ===== -->
<section class="NEW2-programs-section" id="programs">
    <div class="container">
        <div class="NEW2-section-header">
            <h2># Program Prioritas</h2>
            <p>Bergabunglah dalam Aksi Cepat! Setiap Donasi Memberi Harapan Baru</p>
        </div>
    </div>
    <div class="NEW2-slider-3d-wrapper">
        <div class="NEW2-slider-arrow NEW2-slider-arrow--prev" id="prevPrioritas"><i class="fas fa-chevron-left"></i></div>
        <div class="NEW2-slider-3d" id="sliderPrioritas">
            <?php
            $prioritasResult = $conn->query("SELECT p.*,
                COALESCE((SELECT SUM(jumlah) FROM donasi WHERE program_id = p.id AND status = 'berhasil'), 0) AS total_terkumpul
                FROM program p WHERE p.is_active = 1 AND p.is_prioritas = 1 ORDER BY p.created_at DESC");
            if ($prioritasResult && $prioritasResult->num_rows > 0):
                while ($item = $prioritasResult->fetch_assoc()):
                    $gambar = strpos($item['gambar'], 'http') === 0 ? $item['gambar'] : 'uploads/' . $item['gambar'];
            ?>
            <div class="NEW2-donation-card">
                <img src="<?= htmlspecialchars($gambar) ?>" alt="<?= htmlspecialchars($item['nama']) ?>">
                <div class="NEW2-donation-card-body">
                    <h4><?= htmlspecialchars($item['nama']) ?></h4>
                    <div class="raised-label">Dana Terkumpul</div>
                    <div class="raised">Rp <?= number_format($item['total_terkumpul'], 0, ',', '.') ?></div>
                    <div class="raised-label" style="margin-top:4px;">Target: Rp <?= number_format($item['target_donasi'], 0, ',', '.') ?></div>
                    <a href="http://localhost/appbantumereka/detail.php?id=<?= $item['id'] ?>" class="btn-donate-sm">Donasi Sekarang</a>
                </div>
            </div>
            <?php
                endwhile;
            else:
                echo '<p style="text-align:center;color:var(--text-grey);">Belum ada program prioritas.</p>';
            endif;
            ?>
        </div>
        <div class="NEW2-slider-arrow NEW2-slider-arrow--next" id="nextPrioritas"><i class="fas fa-chevron-right"></i></div>
    </div>
</section>

<!-- ===== PROGRAM TERBARU ===== -->
<section class="NEW2-programs-section NEW2-programs-section--cream">
    <div class="container">
        <div class="NEW2-section-header">
            <h2># Program Terbaru</h2>
            <p>Satu Langkah Lebih Dekat, Donasi Sekarang untuk Kampanye Terbaru Kami</p>
        </div>
    </div>
    <div class="NEW2-slider-3d-wrapper">
        <div class="NEW2-slider-arrow NEW2-slider-arrow--prev" id="prevTerbaru"><i class="fas fa-chevron-left"></i></div>
        <div class="NEW2-slider-3d" id="sliderTerbaru">
            <?php
            $terbaruResult = $conn->query("SELECT p.*,
                COALESCE((SELECT SUM(jumlah) FROM donasi WHERE program_id = p.id AND status = 'berhasil'), 0) AS total_terkumpul
                FROM program p WHERE p.is_active = 1 ORDER BY p.created_at DESC LIMIT 8");
            if ($terbaruResult && $terbaruResult->num_rows > 0):
                while ($item = $terbaruResult->fetch_assoc()):
                    $gambar = strpos($item['gambar'], 'http') === 0 ? $item['gambar'] : 'uploads/' . $item['gambar'];
            ?>
            <div class="NEW2-donation-card">
                <img src="<?= htmlspecialchars($gambar) ?>" alt="<?= htmlspecialchars($item['nama']) ?>">
                <div class="NEW2-donation-card-body">
                    <h4><?= htmlspecialchars($item['nama']) ?></h4>
                    <div class="raised-label">Dana Terkumpul</div>
                    <div class="raised">Rp <?= number_format($item['total_terkumpul'], 0, ',', '.') ?></div>
                    <div class="raised-label" style="margin-top:4px;">Target: Rp <?= number_format($item['target_donasi'], 0, ',', '.') ?></div>
                    <a href="http://localhost/appbantumereka/detail.php?id=<?= $item['id'] ?>" class="btn-donate-sm">Donasi Sekarang</a>
                </div>
            </div>
            <?php
                endwhile;
            else:
                echo '<p style="text-align:center;color:var(--text-grey);">Belum ada program.</p>';
            endif;
            ?>
        </div>
        <div class="NEW2-slider-arrow NEW2-slider-arrow--next" id="nextTerbaru"><i class="fas fa-chevron-right"></i></div>
    </div>
</section>

<!-- ===== PROGRAM KATEGORI ===== -->
<section class="NEW2-programs-section">
    <div class="container">
        <div class="NEW2-section-header">
            <h2>Jangan Pernah Berhenti Menjadi Orang Baik</h2>
            <p>Pilih kategori program yang ingin Anda bantu</p>
        </div>
        <div class="NEW2-category-filters" id="categoryFilters">
            <button class="active" data-category="all">Semua</button>
            <?php
            $kategoriRes = $conn->query("SELECT id, nama FROM kategori ORDER BY nama");
            if ($kategoriRes && $kategoriRes->num_rows > 0):
                while ($kat = $kategoriRes->fetch_assoc()):
                    echo '<button data-category="cat-'.$kat['id'].'">'.htmlspecialchars($kat['nama']).'</button>';
                endwhile;
            endif;
            ?>
        </div>
    </div>
    <div class="NEW2-slider-3d-wrapper" id="kategoriSliderWrapper">
        <div class="NEW2-slider-arrow NEW2-slider-arrow--prev" id="prevKategori"><i class="fas fa-chevron-left"></i></div>
        <div class="NEW2-slider-3d" id="sliderKategori">
            <?php
            $allProgResult = $conn->query("SELECT p.*,
                COALESCE((SELECT SUM(jumlah) FROM donasi WHERE program_id = p.id AND status = 'berhasil'), 0) AS total_terkumpul,
                k.nama AS kategori_nama
                FROM program p LEFT JOIN kategori k ON p.kategori_id = k.id
                WHERE p.is_active = 1 ORDER BY p.created_at DESC");
            if ($allProgResult && $allProgResult->num_rows > 0):
                while ($item = $allProgResult->fetch_assoc()):
                    $gambar = strpos($item['gambar'], 'http') === 0 ? $item['gambar'] : 'uploads/' . $item['gambar'];
            ?>
            <div class="NEW2-donation-card cat-<?= $item['kategori_id'] ?>">
                <img src="<?= htmlspecialchars($gambar) ?>" alt="<?= htmlspecialchars($item['nama']) ?>">
                <div class="NEW2-donation-card-body">
                    <h4><?= htmlspecialchars($item['nama']) ?></h4>
                    <div class="raised-label">Dana Terkumpul</div>
                    <div class="raised">Rp <?= number_format($item['total_terkumpul'], 0, ',', '.') ?></div>
                    <div class="raised-label" style="margin-top:4px;">Target: Rp <?= number_format($item['target_donasi'], 0, ',', '.') ?></div>
                    <a href="http://localhost/appbantumereka/detail.php?id=<?= $item['id'] ?>" class="btn-donate-sm">Donasi Sekarang</a>
                </div>
            </div>
            <?php
                endwhile;
            else:
                echo '<p style="text-align:center;color:var(--text-grey);">Belum ada program.</p>';
            endif;
            ?>
        </div>
        <div class="NEW2-slider-arrow NEW2-slider-arrow--next" id="nextKategori"><i class="fas fa-chevron-right"></i></div>
    </div>
    <div id="kategoriEmptyMessage" style="display:none; text-align:center; color:var(--text-grey); padding:20px;">Belum ada program untuk kategori ini.</div>
    <div class="NEW2-link-more"><a href="http://localhost/appbantumereka">Lihat Program Lainnya ➔</a></div>
</section>

<!-- ===== ARTICLES / PROGRAM ACAK ===== -->
<section class="NEW2-articles-section">
    <div class="container">
        <div class="NEW2-section-header">
            <h2>Mengulurkan Sesama, Melampaui Batasan</h2>
            <p>Dari tangan ke tangan, cinta kasih menyatakan kita satu.</p>
        </div>
        <div class="NEW2-articles-grid">
            <?php
            $randomPrograms = $conn->query("SELECT p.*,
                COALESCE((SELECT SUM(jumlah) FROM donasi WHERE program_id = p.id AND status = 'berhasil'), 0) AS total_terkumpul
                FROM program p WHERE p.is_active = 1 ORDER BY RAND() LIMIT 3");
            if ($randomPrograms && $randomPrograms->num_rows > 0):
                while ($item = $randomPrograms->fetch_assoc()):
                    $gambar = strpos($item['gambar'], 'http') === 0 ? $item['gambar'] : 'uploads/' . $item['gambar'];
            ?>
            <div class="NEW2-article-card">
                <img src="<?= htmlspecialchars($gambar) ?>" alt="<?= htmlspecialchars($item['nama']) ?>">
                <div class="NEW2-article-card-body">
                    <div class="date">Rp <?= number_format($item['total_terkumpul'], 0, ',', '.') ?> terkumpul</div>
                    <h4><?= htmlspecialchars($item['nama']) ?></h4>
                    <a href="http://localhost/appbantumereka/detail_program.php?id=<?= $item['id'] ?>" style="font-size:0.85rem; color:var(--primary-red);">Selengkapnya →</a>
                </div>
            </div>
            <?php
                endwhile;
            else:
                echo '<p style="text-align:center;color:var(--text-grey);">Belum ada program.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- ===== ABOUT ===== -->
<section class="about-section" id="about">
    <div class="container">
        <div class="about-content">
            <div class="about-text">
                <h2>Tentang <span style="color:var(--primary-red);">Bantu Mereka</span></h2>
                <p><strong>Bantu Mereka</strong> adalah platform donasi blockchain pertama di Indonesia. Smart contract memastikan setiap rupiah tercatat transparan. Tanpa potongan — operasional dari bisnis mandiri.</p>
                <p>Visi kami: ekosistem donasi modern, tepercaya, tanpa perantara, memberdayakan langsung.</p>
            </div>
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1050&q=80" alt="Blockchain Donasi">
            </div>
        </div>
    </div>
</section>

<!-- ===== CTA ===== -->
<section class="cta-section">
    <div class="container">
        <h2>Siap Bergabung dengan Gerakan "Bantu Mereka"?</h2>
        <p>Download aplikasi sekarang dan mulai donasi transparan tanpa potongan.</p>
        <a href="http://localhost/appbantumereka" class="btn-cta-primary"><i class="fas fa-download"></i> Download Aplikasi</a>
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <h5><i class="fas fa-hand-holding-heart"></i> Bantu Mereka</h5>
                <p style="font-size:0.8rem;">Platform donasi dengan basis blockchain pertama di Dunia, Transparan dan Akuntabel. 100% tersalurkan tanpa potongan.</p>
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
                    <li><a href="#">Blockchain</a></li>
                    <li><a href="#">Laporan Keuangan</a></li>
                    <li><a href="#">Karir</a></li>
                </ul>
            </div>
            <div>
                <h5>Kontak</h5>
                <p style="font-size:0.8rem;"><i class="fas fa-map-marker-alt"></i> Jakarta</p>
                <p style="font-size:0.8rem;"><i class="fas fa-envelope"></i> info@bantumereka.org</p>
                <p style="font-size:0.8rem;"><i class="fas fa-phone"></i> +62 812-3456-7890</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> Bantu Mereka Foundation. | bantumereka.org</p>
        </div>
    </div>
</footer>

<!-- ===== WHATSAPP FLOAT ===== -->
<a href="https://wa.me/6287788111000?text=Halo%20Bantu%20Mereka%2C%20saya%20ingin%20bertanya..." class="NEW3-wa-float" target="_blank">
    <i class="fab fa-whatsapp"></i>
    <span>1</span>
</a>

<!-- ===== SCRIPTS ===== -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
$(document).ready(function(){

    // Hero Slider
    $('#heroSlider').slick({
        centerMode: true, centerPadding: '3%', slidesToShow: 1,
        autoplay: true, autoplaySpeed: 4000, dots: false, arrows: false,
        responsive: [{ breakpoint: 768, settings: { centerPadding: '0px', slidesToShow: 1 } }]
    });

    // Config slider program
    var sliderConfig = {
        slidesToShow: 3, slidesToScroll: 1, dots: false, arrows: false,
        responsive: [
            { breakpoint: 920, settings: { slidesToShow: 2 } },
            { breakpoint: 600, settings: { slidesToShow: 1 } }
        ]
    };

    $('#sliderPrioritas').slick($.extend({}, sliderConfig, { autoplay: true, autoplaySpeed: 3500 }));
    $('#sliderTerbaru').slick($.extend({}, sliderConfig, { autoplay: true, autoplaySpeed: 4000 }));
    $('#sliderKategori').slick($.extend({}, sliderConfig, { autoplay: true, autoplaySpeed: 4500 }));

    // Arrow navigasi
    $('#prevPrioritas').click(function(){ $('#sliderPrioritas').slick('slickPrev'); });
    $('#nextPrioritas').click(function(){ $('#sliderPrioritas').slick('slickNext'); });
    $('#prevTerbaru').click(function(){ $('#sliderTerbaru').slick('slickPrev'); });
    $('#nextTerbaru').click(function(){ $('#sliderTerbaru').slick('slickNext'); });
    $('#prevKategori').click(function(){ $('#sliderKategori').slick('slickPrev'); });
    $('#nextKategori').click(function(){ $('#sliderKategori').slick('slickNext'); });

    // Filter Kategori
    $('#categoryFilters button').click(function(){
        $('#categoryFilters button').removeClass('active');
        $(this).addClass('active');
        var filter = $(this).data('category');
        var slider = $('#sliderKategori');

        slider.slick('slickUnfilter');

        if (filter === 'all') {
            slider.slick('slickGoTo', 0);
            slider.slick('setPosition');
            $('#kategoriSliderWrapper').show();
            $('#kategoriEmptyMessage').hide();
        } else {
            slider.slick('slickFilter', '.' + filter);
            setTimeout(function(){
                var visibleSlides = slider.find('.slick-slide:not(.slick-cloned)').filter(function(){
                    return $(this).css('display') !== 'none';
                }).length;
                if (visibleSlides === 0) {
                    $('#kategoriSliderWrapper').hide();
                    $('#kategoriEmptyMessage').show();
                } else {
                    $('#kategoriSliderWrapper').show();
                    $('#kategoriEmptyMessage').hide();
                    slider.slick('slickGoTo', 0);
                    slider.slick('setPosition');
                }
            }, 100);
        }
    });

    // Video floating
    $('#reopenVideoBtn').click(function(){
        $('#videoCard').slideDown(300);
        $(this).hide();
        var iframe = document.getElementById('youtubeVideo');
        iframe.src = iframe.src;
    });
    $('#closeVideoBtn').click(function(){
        $('#videoCard').slideUp(300, function(){
            $('#reopenVideoBtn').show().css('display', 'flex');
        });
    });

    // Navbar toggle mobile
    $('#navbarToggle').click(function(){
        $('#navbarLinks').toggleClass('active');
    });

});
</script>
</body>
</html>