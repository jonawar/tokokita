@extends('layouts.frontend')

@section('title', 'Katalog Produk - ' . config('app.name'))

@section('content')

    {{-- ===== HERO ===== --}}
    <section class="catalog-hero">
        <div class="container fade-in">
            <h1>Katalog Produk</h1>
            <p>Jelajahi koleksi buku cerita & mainan edukasi terbaik untuk si kecil</p>

            {{-- Type quick filter --}}
            <div class="filter-pills">
                <a href="{{ route('home', request()->except(['type', 'page'])) }}"
                    class="filter-pill {{ !request('type') && !request('category') && !request('search') ? 'active' : '' }}">
                    ✨ Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('home', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                        class="filter-pill {{ request('category') == $cat->slug ? 'active' : '' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="container">

        {{-- Search result banner --}}
        @if(request('search'))
            <div
                style="margin-top: 30px; padding: 15px 25px; background: linear-gradient(135deg,#fff5f5,#fff); border-radius: 15px; border-left: 5px solid var(--primary-color); display:flex; justify-content:space-between; align-items:center;">
                <p style="margin:0;">Hasil pencarian untuk: <strong>"{{ request('search') }}"</strong></p>
                <a href="{{ route('home') }}" style="color: var(--primary-color); font-weight:700; text-decoration:none;">✕
                    Hapus Filter</a>
            </div>
        @endif

        {{-- Toolbar: count + sort --}}
        <div class="catalog-toolbar">
            <p class="catalog-count">
                Menampilkan <span>{{ $products->total() }}</span> produk
            </p>
            <div class="catalog-sort" style="display:flex; gap:10px; align-items:center;">
                <label style="font-weight:600; font-size:0.9rem; color:#888;">Urutkan:</label>
                <select onchange="window.location.href=this.value">
                    <option value="{{ route('home', array_merge(request()->except(['sort', 'page']), [])) }}">Terbaru
                    </option>
                    <option
                        value="{{ route('home', array_merge(request()->except(['sort', 'page']), ['sort' => 'price_asc'])) }}"
                        {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Termurah</option>
                    <option
                        value="{{ route('home', array_merge(request()->except(['sort', 'page']), ['sort' => 'price_desc'])) }}"
                        {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Termahal</option>
                    <option
                        value="{{ route('home', array_merge(request()->except(['sort', 'page']), ['sort' => 'name_asc'])) }}"
                        {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama: A–Z</option>
                </select>
            </div>
        </div>

        {{-- Product grid --}}
        <div class="product-grid">
            @forelse($products as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card fade-in">

                    {{-- Product image area --}}
                    <div
                        class="product-card-img {{ $product->type == 'book' ? 'book-bg' : 'toy-bg' }} overflow-hidden rounded-lg relative bg-gray-50">
                        <img src="{{ $product->image_url ?: 'https://placehold.co/600x600/f3f4f6/a1a1aa?text=' . urlencode(config('app.name')) . '+No+Image' }}"
                            alt="{{ $product->name }}" loading="lazy"
                            onerror="this.onerror=null;this.src='https://placehold.co/600x600/f3f4f6/a1a1aa?text=Image+Error';"
                            class="w-full h-full object-cover aspect-square transition-transform duration-500 hover:scale-105"
                            style="text-indent: -10000px;">

                        {{-- Stock badge overlay --}}
                        <div style="position:absolute; top:14px; right:14px; display:flex; flex-direction:column; gap:5px; align-items:flex-end;">
                            @if($product->is_promo && $product->promo_price)
                                <span class="stock-badge available" style="background:var(--secondary-color); color:white;">PROMO</span>
                            @endif
                            
                            @if($product->stock == 0)
                                <span class="stock-badge empty">Habis</span>
                            @elseif($product->stock <= 5)
                                <span class="stock-badge low">Stok Terbatas</span>
                            @else
                                <span class="stock-badge available">Tersedia</span>
                            @endif
                        </div>
                    </div>

                    {{-- Card body --}}
                    <div class="product-card-body">
                        <div class="product-card-meta">
                            <span class="category-badge">{{ $product->category->name }}</span>
                            @if($product->supplier)
                                <span style="font-size:0.75rem; color:#aaa; font-weight:600;">{{ $product->supplier->name }}</span>
                            @endif
                        </div>

                        <h3>{{ $product->name }}</h3>

                        @if($product->description)
                            <p
                                style="font-size:0.85rem; color:#888; line-height:1.5; margin-bottom:10px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                {{ $product->description }}
                            </p>
                        @endif
                        
                        <div class="product-card-rating" style="display:flex; align-items:center; gap:5px; margin-bottom:10px;">
                            <div class="rating-stars" style="font-size: 0.85rem;">
                                @php $avg = $product->averageRating(); @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($avg))
                                        <span>⭐</span>
                                    @else
                                        <span style="filter: grayscale(1); opacity: 0.3;">⭐</span>
                                    @endif
                                @endfor
                            </div>
                            <span style="font-size: 0.75rem; color: #aaa;">({{ $product->reviewCount() }})</span>
                        </div>

                        <div class="price-container" style="display:flex; flex-direction:column;">
                            @if($product->is_promo && $product->promo_price)
                                <span style="font-size:0.85rem; color:#aaa; text-decoration:line-through;">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <div class="price" style="color:var(--secondary-color);">Rp {{ number_format($product->promo_price, 0, ',', '.') }}</div>
                            @else
                                <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div style="grid-column:1/-1; text-align:center; padding:80px 20px;">
                    <div style="font-size:4rem; margin-bottom:20px;">🔍</div>
                    <h3 style="color:#999; margin-bottom:10px;">Produk tidak ditemukan</h3>
                    <p style="color:#bbb; margin-bottom:25px;">Coba ubah kata kunci atau hapus filter yang aktif</p>
                    <a href="{{ route('home') }}" class="btn">Lihat Semua Produk</a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div style="margin: 10px 0 60px; display:flex; justify-content:center;">
            {{ $products->links() }}
        </div>
    </div>

    {{-- WhatsApp floating button (sitewide) --}}
    <a href="https://wa.me/{{ env('WHATSAPP_NUMBER', '6281234567890') }}?text={{ urlencode('Halo ' . config('app.name') . ', saya ingin bertanya tentang produk Anda.') }}"
        target="_blank" class="wa-float" title="Chat via WhatsApp">
        💬
    </a>

@endsection