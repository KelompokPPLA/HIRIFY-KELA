<header class="site-header">
    <div class="container nav">
        <a class="brand" href="/" aria-label="Hirify beranda">
            <span class="brand-mark">H</span>
            <span>Hirify!</span>
        </a>

        <button class="btn btn-ghost mobile-toggle" type="button" id="menuToggle">Menu</button>

        <nav class="nav-links" id="navLinks">
            <a href="#fitur">Fitur</a>
            <a href="#cara-kerja">Cara Kerja</a>
            <a href="#testimoni">Testimoni</a>
            <a href="#kontak">Kontak</a>
        </nav>

        <div class="nav-actions">
            @auth
                <a class="btn btn-ghost" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="btn btn-dark" href="{{ route('dashboard') }}">Buka Akun</a>
            @else
                <a class="btn btn-ghost" href="{{ route('login') }}">Masuk</a>
                <a class="btn btn-dark" href="{{ route('register') }}">Daftar</a>
            @endauth
        </div>
    </div>
</header>
