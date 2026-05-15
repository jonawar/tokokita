@extends('layouts.frontend')

@section('title', 'Keranjang Belanja - ' . config('app.name'))

@section('content')
<div class="container cart-page" style="padding-top: 50px;">
    <h1 class="page-title">Keranjang Belanja</h1>

    @if(empty($cart))
        <div class="cart-empty">
            <div class="empty-icon">🛒</div>
            <h2>Keranjang Anda masih kosong.</h2>
            <p>Yuk, cari buku atau mainan seru untuk si kecil!</p>
            <a href="{{ route('home') }}" class="btn">Mulai Belanja</a>
        </div>
    @else
        <div class="cart-grid">
            <div class="cart-items">
                @foreach($cart as $id => $item)
                    <div class="cart-item">
                        <div class="cart-item-img">
                            @if(isset($item['image_url']))
                                <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}">
                            @else
                                📚
                            @endif
                        </div>
                        <div class="cart-item-info">
                            <h3>{{ $item['name'] }}</h3>
                            <p class="cart-item-price">Rp {{ number_format($item['price'], 0, ',', '.') }} <span class="qty">x {{ $item['quantity'] }}</span></p>
                        </div>
                        <div class="cart-item-actions">
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-remove">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="cart-summary">
                <h3>Ringkasan Belanja</h3>
                <div class="summary-row">
                    <span>Total Transaksi</span>
                    <strong class="total-price">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                </div>
                <a href="{{ route('orders.checkout') }}" class="btn btn-checkout">Lanjut ke Pembayaran</a>
            </div>
        </div>
    @endif
</div>
@endsection
