@extends('layouts.frontend')

@section('title', $product->name . ' - ' . config('app.name'))

@section('content')
    <div class="container product-detail-page" style="padding-top: 50px;">
        <div class="product-detail-grid">
            <div class="product-gallery-container">
                <div class="product-image-main" id="mainImageContainer">
                    <img id="mainProductImage" src="{{ $product->image_url ?: 'https://placehold.co/600x600/f3f4f6/a1a1aa?text=' . urlencode(config('app.name')) . '+No+Image' }}" 
                         alt="{{ $product->name }}" 
                         onerror="this.onerror=null;this.src='https://placehold.co/600x600/f3f4f6/a1a1aa?text=Image+Error';"
                         class="max-w-full max-h-full object-contain rounded-xl shadow-lg">
                </div>
                
                @if($product->images->count() > 0)
                    <div class="thumbnails-grid">
                        <div class="thumb-item active" onclick="switchImage('{{ $product->image_url }}')">
                            <img src="{{ $product->image_url }}" class="w-full h-full object-cover">
                        </div>
                        @foreach($product->images as $img)
                            <div class="thumb-item" onclick="switchImage('{{ $img->image_url }}')">
                                <img src="{{ $img->image_url }}" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="product-info-container fade-in">
                <div class="category-badge">{{ $product->category->name }}</div>
                @if($product->supplier)
                    <div class="supplier-info">
                        <span>🏭 Suplier:</span>
                        <span style="color: var(--primary-color);">{{ $product->supplier->name }}</span>
                    </div>
                @endif
                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="product-rating-overview" style="margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                    <div class="rating-stars">
                        @php $avg = $product->averageRating(); @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($avg))
                                <span>⭐</span>
                            @else
                                <span style="filter: grayscale(1); opacity: 0.3;">⭐</span>
                            @endif
                        @endfor
                    </div>
                    <span class="rating-count">({{ $product->reviewCount() }} Ulasan)</span>
                </div>
                @if($product->is_promo && $product->promo_price)
                    <div class="promo-badge">PROMO SPESIAL</div>
                    <div class="original-price">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                    <div class="price promo">
                        Rp {{ number_format($product->promo_price, 0, ',', '.') }}
                    </div>
                @else
                    <div class="price">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                @endif
                <p class="product-description">
                    {{ $product->description }}
                </p>
                <div class="product-stock">
                    <strong>Stok:</strong> {{ $product->stock }} {{ $product->type == 'book' ? 'Buku' : 'Buah' }}
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" style="margin-bottom: 15px;">
                    @csrf
                    <button type="submit" class="btn btn-add-cart">
                        Tambah ke Keranjang
                    </button>
                </form>
            </div>
        </div>

        {{-- Video Section --}}
        @if($product->video_url)
            <div class="product-video-section">
                <h2 class="section-title">Video Produk</h2>
                <div class="video-container">
                    @if(strpos($product->video_url, 'youtube.com') !== false || strpos($product->video_url, 'youtu.be') !== false)
                        @php
                            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $product->video_url, $matches);
                            $videoId = $matches[1] ?? null;
                        @endphp
                        @if($videoId)
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @else
                            <div class="video-error">Tautan video tidak valid</div>
                        @endif
                    @elseif(strpos($product->video_url, 'drive.google.com') !== false)
                        @php
                            preg_match('/(?:\/d\/|id=)([\w-]+)/', $product->video_url, $matches);
                            $driveId = $matches[1] ?? null;
                        @endphp
                        @if($driveId)
                            <iframe src="https://drive.google.com/file/d/{{ $driveId }}/preview" width="100%" height="100%" allow="autoplay" frameborder="0"></iframe>
                        @else
                            <div class="video-error">Tautan Google Drive tidak valid</div>
                        @endif
                    @else
                        <video controls style="width: 100%; height: 100%;">
                            <source src="{{ $product->video_url }}" type="video/mp4">
                            Browser Anda tidak mendukung tag video.
                        </video>
                    @endif
                </div>
            </div>
        @endif
        {{-- Reviews Section --}}
        <div class="reviews-section fade-in">
            <h2 class="section-title">Ulasan Pelanggan</h2>
            
            @if($product->reviews->count() > 0)
                <div class="reviews-list">
                    @foreach($product->reviews as $review)
                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-user">{{ $review->user->name }}</div>
                                <div class="review-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span style="{{ $i <= $review->rating ? '' : 'filter: grayscale(1); opacity: 0.3;' }}">⭐</span>
                                    @endfor
                                </div>
                            </div>
                            <div class="review-comment">
                                {{ $review->comment }}
                            </div>
                            <div class="review-date" style="font-size: 0.8rem; color: #888; margin-top: 5px;">
                                {{ $review->created_at->format('d M Y') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="text-align: center; color: #888; padding: 20px;">Belum ada ulasan untuk produk ini.</p>
            @endif

            <div class="review-form-container">
                <h3 style="margin-bottom: 20px;">Tulis Ulasan</h3>
                @auth
                    <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Rating Anda</label>
                            <div class="star-rating-input">
                                <input type="radio" id="star5" name="rating" value="5" required /><label for="star5" title="5 stars">⭐</label>
                                <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 stars">⭐</label>
                                <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 stars">⭐</label>
                                <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 stars">⭐</label>
                                <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star">⭐</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comment">Komentar (Opsional)</label>
                            <textarea name="comment" id="comment" rows="4" class="form-control" placeholder="Bagikan pengalaman Anda menggunakan produk ini..."></textarea>
                        </div>
                        <button type="submit" class="btn">Kirim Ulasan</button>
                    </form>
                @else
                    <p style="text-align: center; background: #f9f9f9; padding: 15px; border-radius: 10px;">
                        Silakan <a href="{{ route('login') }}" style="color: var(--primary-color); font-weight: 700;">Login</a> untuk memberikan ulasan.
                    </p>
                @endauth
            </div>
        </div>
    </div>
    </div>

    <script>
        function switchImage(url) {
            const mainImg = document.getElementById('mainProductImage');
            mainImg.style.opacity = '0';
            setTimeout(() => {
                mainImg.src = url;
                mainImg.style.opacity = '1';
            }, 200);

            // Update border
            document.querySelectorAll('.thumb-item').forEach(item => {
                item.style.borderColor = 'transparent';
                if(item.querySelector('img').src === url) {
                    item.style.borderColor = 'var(--primary-color)';
                }
            });
        }
    </script>
@endsection