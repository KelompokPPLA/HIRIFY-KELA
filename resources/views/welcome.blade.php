<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Hirify adalah platform persiapan karier untuk mahasiswa dan pencari kerja di Indonesia.">
    <title>Hirify | Platform Persiapan Karier</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f7f9fc;
            --surface: #ffffff;
            --surface-soft: #eef6ff;
            --ink: #0f172a;
            --muted: #5b6b82;
            --line: rgba(15, 23, 42, 0.08);
            --navy: #0f172a;
            --navy-2: #14213d;
            --blue: #26c6da;
            --blue-2: #1aa8c0;
            --cyan: #bff7ff;
            --shadow: 0 18px 50px rgba(15, 23, 42, 0.08);
            --radius-xl: 28px;
            --radius-lg: 22px;
            --radius-md: 16px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 10% 8%, rgba(38, 198, 218, 0.15), transparent 22%),
                radial-gradient(circle at 90% 0%, rgba(38, 198, 218, 0.09), transparent 26%),
                linear-gradient(180deg, #ffffff 0%, var(--bg) 100%);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .container {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(18px);
            background: rgba(255, 255, 255, 0.82);
            border-bottom: 1px solid rgba(15, 23, 42, 0.06);
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            min-height: 76px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 1.2rem;
            letter-spacing: -0.03em;
        }

        .brand-mark {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            color: white;
            font-size: 17px;
            font-weight: 800;
            background: linear-gradient(145deg, #0399b7, #06d8ee);
            box-shadow: 0 10px 30px rgba(3, 153, 183, 0.25);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .nav-links a {
            color: var(--muted);
            font-weight: 600;
            font-size: 0.98rem;
        }

        .nav-links a:hover {
            color: var(--ink);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            border: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-radius: 14px;
            padding: 13px 20px;
            font-weight: 800;
            letter-spacing: -0.01em;
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease, color .18s ease;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--blue) 0%, var(--blue-2) 100%);
            color: white;
            box-shadow: 0 16px 30px rgba(38, 198, 218, 0.28);
        }

        .btn-dark {
            background: #0f172a;
            color: white;
        }

        .btn-ghost {
            border: 1px solid rgba(15, 23, 42, 0.1);
            color: var(--ink);
            background: white;
        }

        .hero {
            padding: 42px 0 30px;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.08fr 0.92fr;
            gap: 30px;
            align-items: center;
            min-height: 640px;
            padding: 32px;
            border-radius: 34px;
            background:
                radial-gradient(circle at 15% 18%, rgba(255, 255, 255, 0.08), transparent 18%),
                radial-gradient(circle at 85% 16%, rgba(255, 255, 255, 0.05), transparent 15%),
                linear-gradient(135deg, #0b1021 0%, #10182d 42%, #17253a 100%);
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 28px 70px rgba(15, 23, 42, 0.18);
        }

        .hero-grid::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.07) 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.52;
            pointer-events: none;
        }

        .hero-copy,
        .hero-panel {
            position: relative;
            z-index: 1;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            padding: 10px 16px;
            border-radius: 999px;
            border: 1px solid rgba(38, 198, 218, 0.35);
            background: rgba(9, 36, 54, 0.78);
            color: #18d5e6;
            font-weight: 700;
            font-size: 0.92rem;
            margin-bottom: 22px;
        }

        .hero h1 {
            margin: 0;
            font-size: clamp(3rem, 7vw, 5.8rem);
            line-height: 0.96;
            letter-spacing: -0.06em;
            max-width: 11ch;
        }

        .hero p {
            max-width: 60ch;
            color: rgba(255, 255, 255, 0.78);
            font-size: 1.08rem;
            line-height: 1.75;
            margin: 24px 0 0;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 28px;
        }

        .hero-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 34px;
            margin-top: 34px;
        }

        .stat strong {
            display: block;
            font-size: 2rem;
            line-height: 1;
            letter-spacing: -0.04em;
            color: white;
        }

        .stat span {
            display: block;
            margin-top: 6px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.96rem;
        }

        .hero-panel {
            background: rgba(79, 108, 128, 0.48);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 28px;
            padding: 28px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.06);
        }

        .check-list {
            display: grid;
            gap: 16px;
        }

        .check-item {
            display: flex;
            align-items: center;
            gap: 14px;
            background: white;
            color: #0f172a;
            border-radius: 16px;
            padding: 14px 16px;
            font-weight: 700;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }

        .check-icon {
            width: 26px;
            height: 26px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            background: rgba(38, 198, 218, 0.12);
            color: #06b6d4;
            font-weight: 900;
        }

        .section {
            padding: 90px 0 0;
        }

        .section-head {
            text-align: center;
            max-width: 760px;
            margin: 0 auto 34px;
        }

        .section-head h2 {
            margin: 0;
            font-size: clamp(2rem, 4vw, 2.8rem);
            letter-spacing: -0.04em;
        }

        .section-head p {
            margin: 12px auto 0;
            color: var(--muted);
            line-height: 1.7;
            font-size: 1.03rem;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }

        .feature-card,
        .step-card,
        .testimonial-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
        }

        .feature-card {
            padding: 26px 22px 24px;
            transition: transform .2s ease, border-color .2s ease;
        }

        .feature-card:hover {
            transform: translateY(-3px);
            border-color: rgba(38, 198, 218, 0.45);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: grid;
            place-items: center;
            background: linear-gradient(180deg, rgba(38, 198, 218, 0.16), rgba(38, 198, 218, 0.06));
            color: #06b6d4;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .feature-card h3 {
            margin: 0 0 10px;
            font-size: 1.2rem;
            letter-spacing: -0.03em;
        }

        .feature-card p,
        .step-card p,
        .testimonial-card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
            position: relative;
        }

        .steps-grid::before {
            content: '';
            position: absolute;
            top: 58px;
            left: 11%;
            right: 11%;
            height: 2px;
            background: linear-gradient(90deg, rgba(38, 198, 218, 0), rgba(38, 198, 218, 0.8), rgba(38, 198, 218, 0));
            opacity: 0.55;
        }

        .step-card {
            padding: 28px 20px 24px;
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 68px;
            height: 68px;
            border-radius: 18px;
            margin: 0 auto 22px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #22d3ee 0%, #2dd4bf 100%);
            color: white;
            font-size: 1.4rem;
            font-weight: 800;
            box-shadow: 0 14px 28px rgba(34, 211, 238, 0.25);
        }

        .step-card h3 {
            margin: 0 0 12px;
            font-size: 1.12rem;
            letter-spacing: -0.03em;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .testimonial-card {
            padding: 24px;
        }

        .stars {
            color: #11c5d8;
            letter-spacing: 2px;
            font-size: 1.2rem;
            margin-bottom: 18px;
        }

        .quote {
            font-size: 1.02rem;
        }

        .person {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-top: 22px;
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            color: white;
            font-weight: 800;
            background: linear-gradient(135deg, #0f172a, #22c1c3);
        }

        .person strong {
            display: block;
            font-size: 1rem;
        }

        .person span {
            display: block;
            color: var(--muted);
            font-size: 0.92rem;
            margin-top: 2px;
        }

        .cta {
            margin: 96px 0 0;
            border-radius: 34px;
            background: linear-gradient(135deg, #0f172a 0%, #111d38 55%, #0f172a 100%);
            color: white;
            text-align: center;
            padding: 72px 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 24px 65px rgba(15, 23, 42, 0.18);
        }

        .cta-shell {
            padding-bottom: 64px;
        }

        .cta::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
            background-size: 22px 22px;
            opacity: 0.45;
        }

        .cta-inner {
            position: relative;
            z-index: 1;
            max-width: 760px;
            margin: 0 auto;
        }

        .cta h2 {
            margin: 0;
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            line-height: 0.98;
            letter-spacing: -0.05em;
        }

        .cta p {
            margin: 16px auto 0;
            max-width: 62ch;
            color: rgba(255, 255, 255, 0.75);
            line-height: 1.75;
            font-size: 1.03rem;
        }

        .cta-actions {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 28px;
        }

        .footer {
            margin-top: 0;
            background: #0e1729;
            color: white;
            padding: 58px 0 22px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.3fr repeat(3, minmax(0, 1fr));
            gap: 28px;
        }

        .footer h4 {
            margin: 0 0 14px;
            font-size: 1rem;
            letter-spacing: -0.02em;
        }

        .footer p,
        .footer a {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.75;
            font-size: 0.98rem;
        }

        .footer a:hover {
            color: white;
        }

        .footer-links {
            display: grid;
            gap: 10px;
        }

        .footer-bottom {
            margin-top: 30px;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            text-align: center;
            color: rgba(255, 255, 255, 0.58);
            font-size: 0.94rem;
        }

        .mobile-toggle {
            display: none;
        }

        .hero-badge {
            display: inline-flex;
            gap: 10px;
            align-items: center;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.86);
            font-size: 0.9rem;
            font-weight: 700;
            margin-top: 18px;
        }

        @media (max-width: 1080px) {
            .hero-grid,
            .feature-grid,
            .steps-grid,
            .testimonials-grid,
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

            .steps-grid::before {
                display: none;
            }

            .hero h1 {
                max-width: none;
            }
        }

        @media (max-width: 760px) {
            .container {
                width: min(100% - 22px, 1180px);
            }

            .nav {
                min-height: 70px;
                flex-wrap: wrap;
            }

            .nav-links,
            .nav-actions {
                width: 100%;
                justify-content: space-between;
            }

            .nav-links {
                display: none;
            }

            .nav-links.is-open {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                padding: 0 0 10px;
            }

            .mobile-toggle {
                display: inline-flex;
            }

            .hero {
                padding-top: 20px;
            }

            .hero-grid,
            .feature-grid,
            .steps-grid,
            .testimonials-grid,
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .hero-grid {
                padding: 22px;
                border-radius: 24px;
            }

            .hero h1 {
                font-size: clamp(2.7rem, 13vw, 4rem);
            }

            .hero-stats {
                gap: 22px;
            }

            .cta {
                padding: 58px 18px;
                border-radius: 24px;
            }

            .cta-shell {
                padding-bottom: 44px;
            }
        }
    </style>
</head>
<body>
    <x-public.header />

    <main>
        <section class="hero">
            <div class="container">
                <div class="hero-grid">
                    <div class="hero-copy">
                        <div class="eyebrow">Platform Persiapan Karier #1</div>
                        <h1>Persiapkan Kariermu dengan Lebih Percaya Diri</h1>
                        <p>
                            Bangun profil profesional, susun roadmap karier, latihan CV ATS, dan temukan mentor yang relevan
                            agar langkahmu menuju dunia kerja terasa lebih terarah dan realistis.
                        </p>

                        <div class="hero-actions">
                            <a class="btn btn-primary" href="{{ route('register') }}">Mulai Sekarang</a>
                            <a class="btn btn-ghost" href="#fitur">Lihat Fitur</a>
                        </div>

                        <div class="hero-badge">Siap untuk mahasiswa, fresh graduate, dan job seeker</div>

                        <div class="hero-stats">
                            <div class="stat">
                                <strong>10K+</strong>
                                <span>Pengguna Aktif</span>
                            </div>
                            <div class="stat">
                                <strong>500+</strong>
                                <span>Mentor Profesional</span>
                            </div>
                            <div class="stat">
                                <strong>95%</strong>
                                <span>Tingkat Kepuasan</span>
                            </div>
                        </div>
                    </div>

                    <div class="hero-panel" aria-label="Keunggulan Hirify">
                        <div class="check-list">
                            <div class="check-item">
                                <span class="check-icon">✓</span>
                                <span>CV Lolos ATS Screening</span>
                            </div>
                            <div class="check-item">
                                <span class="check-icon">✓</span>
                                <span>Roadmap Karier Tersusun</span>
                            </div>
                            <div class="check-item">
                                <span class="check-icon">✓</span>
                                <span>Skill Meningkat Lebih Cepat</span>
                            </div>
                            <div class="check-item">
                                <span class="check-icon">✓</span>
                                <span>Akses Mentor dan Insight Industri</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="fitur">
            <div class="container">
                <div class="section-head">
                    <h2>Fitur Unggulan</h2>
                    <p>Semua yang kamu butuhkan untuk memulai karier yang lebih siap, lebih rapi, dan lebih terarah.</p>
                </div>

                <div class="feature-grid">
                    <article class="feature-card">
                        <div class="feature-icon">⌘</div>
                        <h3>CV ATS-Friendly</h3>
                        <p>Buat CV yang mudah dibaca oleh sistem ATS dan lebih siap dipakai melamar kerja.</p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon">🧭</div>
                        <h3>Roadmap Karier</h3>
                        <p>Tentukan jalur belajar, prioritas skill, dan langkah karier yang paling relevan untukmu.</p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon">🎓</div>
                        <h3>Pelatihan Terstruktur</h3>
                        <p>Akses materi yang runtut agar progres belajar terasa nyata dan tidak acak.</p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon">◎</div>
                        <h3>Mentorship 1-on-1</h3>
                        <p>Belajar langsung dari mentor berpengalaman untuk arah yang lebih tepat.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section" id="cara-kerja">
            <div class="container">
                <div class="section-head">
                    <h2>Cara Kerja</h2>
                    <p>Mulai perjalanan kariermu dalam beberapa langkah yang sederhana namun efektif.</p>
                </div>

                <div class="steps-grid">
                    <article class="step-card">
                        <div class="step-number">01</div>
                        <h3>Buat Profil</h3>
                        <p>Lengkapi data diri, latar belakang, dan tujuan kariermu.</p>
                    </article>

                    <article class="step-card">
                        <div class="step-number">02</div>
                        <h3>Pilih Roadmap</h3>
                        <p>Tentukan jalur belajar yang paling sesuai dengan targetmu.</p>
                    </article>

                    <article class="step-card">
                        <div class="step-number">03</div>
                        <h3>Belajar & Berkembang</h3>
                        <p>Ikuti pelatihan, latihan CV, dan sesi mentoring secara bertahap.</p>
                    </article>

                    <article class="step-card">
                        <div class="step-number">04</div>
                        <h3>Siap Berkarier</h3>
                        <p>Raih peluang kerja yang lebih cocok dengan kemampuanmu.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section" id="testimoni">
            <div class="container">
                <div class="section-head">
                    <h2>Kata Mereka</h2>
                    <p>Banyak pengguna merasa proses persiapan kerja jadi lebih terstruktur dan percaya diri.</p>
                </div>

                <div class="testimonials-grid">
                    <article class="testimonial-card">
                        <div class="stars">★★★★★</div>
                        <p class="quote">"Hirify membantu saya membuat CV yang lebih rapi dan akhirnya lolos screening di beberapa perusahaan."</p>
                        <div class="person">
                            <div class="avatar">S</div>
                            <div>
                                <strong>Sarah Wijaya</strong>
                                <span>Product Designer · Tech Startup</span>
                            </div>
                        </div>
                    </article>

                    <article class="testimonial-card">
                        <div class="stars">★★★★★</div>
                        <p class="quote">"Roadmap dan mentoringnya bikin saya tidak bingung lagi harus belajar apa dulu. Lebih fokus."</p>
                        <div class="person">
                            <div class="avatar">A</div>
                            <div>
                                <strong>Ahmad Rizki</strong>
                                <span>Data Analyst · E-commerce</span>
                            </div>
                        </div>
                    </article>

                    <article class="testimonial-card">
                        <div class="stars">★★★★★</div>
                        <p class="quote">"Self assessment dan pelatihannya membantu saya tahu skill apa yang paling perlu ditingkatkan."</p>
                        <div class="person">
                            <div class="avatar">D</div>
                            <div>
                                <strong>Diana Putri</strong>
                                <span>Fresh Graduate · Banking</span>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="container cta-shell" id="kontak">
            <div class="cta">
                <div class="cta-inner">
                    <h2>Siap Memulai Perjalanan Kariermu?</h2>
                    <p>Bergabunglah dengan ribuan mahasiswa dan pencari kerja yang sedang membangun persiapan karier lebih matang bersama Hirify.</p>
                    <div class="cta-actions">
                        <a class="btn btn-primary" href="{{ route('register') }}">Daftar Gratis Sekarang</a>
                        <a class="btn btn-ghost" href="{{ route('login') }}">Sudah Punya Akun</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <x-public.footer />

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');

        if (menuToggle && navLinks) {
            menuToggle.addEventListener('click', () => {
                navLinks.classList.toggle('is-open');
            });
        }
    </script>
</body>
</html>
