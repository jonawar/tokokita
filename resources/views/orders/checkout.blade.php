@extends('layouts.frontend')

@section('title', 'Checkout - ' . config('app.name'))

@section('content')
<div class="container" style="padding-top: 50px;">
    <h1 style="margin-bottom: 30px;">Checkout</h1>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px;">
        <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: var(--shadow);">
            <h3>Informasi Pengiriman</h3>
            <form action="{{ route('orders.store') }}" method="POST" style="margin-top: 20px;">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 10px; font-weight: 600;">Nomor HP</label>
                    <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" style="width: 100%; padding: 15px; border-radius: 10px; border: 1px solid #ddd;" placeholder="Contoh: 081234567890" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 10px; font-weight: 600;">Alamat Lengkap</label>
                    <textarea name="address" style="width: 100%; padding: 15px; border-radius: 10px; border: 1px solid #ddd; height: 150px; resize: vertical;" required>{{ auth()->user()->address ?? '' }}</textarea>
                </div>
                <button type="submit" class="btn" style="width: 100%; font-size: 1.2rem; padding: 20px;">
                    Buat Pesanan Sekarang
                </button>
            </form>
        </div>

        <div>
            <h3>Pesanan Anda</h3>
            @foreach($cart as $id => $item)
                <div style="display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #eee;">
                    <span>{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                    <strong>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</strong>
                </div>
            @endforeach
            <div style="display: flex; justify-content: space-between; padding: 20px 0; font-size: 1.5rem;">
                <span>Total</span>
                <strong style="color: var(--secondary-color);">Rp {{ number_format($total, 0, ',', '.') }}</strong>
            </div>
        </div>
    </div>
</div>
@endsection
