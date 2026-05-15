<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', setting('store_name', config('app.name')) . ' - Toko Buku & Mainan Edukasi')</title>
    <meta name="description"
        content="{{ setting('meta_description', 'Toko buku & mainan edukasi terbaik untuk si kecil.') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        :root {
            --font-main: 'Inter', sans-serif;
        }

        body {
            font-family: var(--font-main);
        }
    </style>
</head>

<body>
    <header class="site-header">
        {{-- ===== Row 1: Logo + Nav ===== --}}
        <div class="header-top">
            <div class="container header-top-inner">
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ setting('store_name', config('app.name')) }}"
                        style="height: 55px; width: auto; display: block;">
                </a>

                <div class="mobile-nav-toggle" id="mobileNavToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <nav class="nav-links" id="navLinks">
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('cart.index') }}" class="nav-cart">
                        🛒 Keranjang
                        @if(count(session('cart', [])) > 0)
                            <span class="cart-badge">{{ count(session('cart', [])) }}</span>
                        @endif
                    </a>
                    @guest
                        <a href="{{ route('login') }}" class="nav-btn-outline">Login</a>
                        <a href="{{ route('register') }}" class="nav-btn-solid">Daftar</a>
                    @else
                        <a href="{{ route('profile.edit') }}">Profil Saya</a>
                        @if(!Auth::user()->is_admin)
                            <a href="{{ route('orders.index') }}">Pesanan Saya</a>
                        @endif
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
                            <a href="{{ route('admin.products.index') }}">📦 Produk</a>
                            <a href="{{ route('admin.categories.index') }}">🏷 Kategori</a>
                            <a href="{{ route('admin.suppliers.index') }}">🏭 Suplier</a>
                            <a href="{{ route('admin.orders.index') }}" style="color:var(--secondary-color);">📋 Kelola
                                Pesanan</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" style="display:inline; margin:0;">
                            @csrf
                            <button type="submit" class="nav-logout">Keluar</button>
                        </form>
                    @endguest
                </nav>
            </div>
        </div>

        {{-- ===== Row 2: Search Bar ===== --}}
        <div class="header-search">
            <div class="container">
                <form action="{{ route('home') }}" method="GET" class="search-form">
                    <span class="search-icon">🔍</span>
                    <input type="text" name="search" id="searchInput"
                        placeholder="Cari buku, mainan edukasi, atau kategori..." value="{{ request('search') }}"
                        autocomplete="off">
                    @if(request('search'))
                        <a href="{{ route('home') }}" class="search-clear" title="Hapus pencarian">✕</a>
                    @endif
                    <button type="submit" class="search-btn">Cari</button>
                </form>
            </div>
        </div>
    </header>

    <main>
        @if(session('success'))
            <div class="container" style="padding-top:20px;">
                <div class="alert alert-success">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="container" style="padding-top:20px;">
                <div class="alert alert-error">{{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container footer-inner">
            <div class="footer-info">
                <h2 class="footer-logo">{{ setting('store_name', config('app.name')) }}</h2>
                <p style="opacity:0.7; margin-top:8px;">
                    {{ setting('meta_description', 'Toko buku & mainan edukasi terbaik untuk si kecil.') }}</p>
            </div>
            <div class="footer-copy">
                &copy; {{ date('Y') }} {{ setting('store_name', config('app.name')) }}. {{ setting('store_address') }}
            </div>
        </div>
    </footer>

    <script>
        // Mobile Navigation Toggle
        const mobileNavToggle = document.getElementById('mobileNavToggle');
        const navLinks = document.getElementById('navLinks');

        if (mobileNavToggle) {
            mobileNavToggle.addEventListener('click', function () {
                this.classList.toggle('active');
                navLinks.classList.toggle('active');
                document.body.classList.toggle('menu-open');
            });
        }

        // Admin dropdown toggle
        var toggleBtn = document.getElementById('adminDropdown');
        if (toggleBtn) {
            toggleBtn.querySelector('.dropdown-toggle').addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var menu = document.getElementById('adminMenu');
                menu.classList.toggle('open');
            });
            document.addEventListener('click', function (e) {
                var menu = document.getElementById('adminMenu');
                if (menu && !toggleBtn.contains(e.target)) {
                    menu.classList.remove('open');
                }
            });
        }
    </script>
</body>

</html>