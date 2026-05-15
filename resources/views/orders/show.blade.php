@extends('layouts.frontend')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
    <div class="container" style="padding-top: 50px;">
        <div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
            <h1>Detail Pesanan #{{ $order->id }}</h1>
            <a href="{{ route('orders.index') }}" class="btn" style="background: #6c757d;">Kembali ke Riwayat</a>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
            <!-- Order Detail -->
            <div>
                <div
                    style="background: white; padding: 30px; border-radius: 20px; box-shadow: var(--shadow); margin-bottom: 30px;">
                    <h3 style="margin-bottom: 20px;">Daftar Produk</h3>
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        @foreach($order->items as $item)
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 20px;">
                                <div style="display: flex; gap: 20px; align-items: center;">
                                    <div
                                        style="width: 60px; height: 60px; background: linear-gradient(135deg,#fef9e7,#fdebd0); border-radius: 10px; display: flex; align-items: center; justify-content: center; overflow:hidden;">
                                        <img src="{{ asset('images/logo.png') }}" alt="logo"
                                            style="width:48px;height:48px;object-fit:contain;">
                                    </div>
                                    <div>
                                        <h4 style="margin: 0;">{{ $item->product->name }}</h4>
                                        <p style="margin: 0; color: #666;">{{ $item->quantity }} x Rp
                                            {{ number_format($item->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                                <div style="font-weight: 700; color: var(--primary-color);">
                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div style="margin-top: 20px; text-align: right;">
                        <h3 style="color: var(--primary-color);">Total: Rp
                            {{ number_format($order->total_price, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>

                <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: var(--shadow);">
                    <h3 style="margin-bottom: 20px;">Informasi Pengiriman</h3>
                    <p><strong>Nama Penerima:</strong> {{ auth()->user()->name }}</p>
                    <p><strong>Nomor HP:</strong> {{ $order->phone }}</p>
                    <p><strong>Alamat Lengkap:</strong> {{ $order->address }}</p>
                    @if($order->note)
                        <p><strong>Catatan:</strong> {{ $order->note }}</p>
                    @endif
                </div>
            </div>

            <!-- Sidebar: Order Status -->
            <div>
                <div
                    style="background: white; padding: 30px; border-radius: 20px; box-shadow: var(--shadow); position: sticky; top: 100px;">
                    <h3 style="margin-bottom: 20px;">Status Pesanan</h3>
                    <div style="margin-bottom: 25px;">
                        <p style="margin-bottom: 10px;">Status Saat Ini:</p>
                        <span style="display: inline-block; padding: 10px 20px; border-radius: 25px; font-weight: 800; font-size: 1rem; width: 100%; text-align: center; box-sizing: border-box; 
                                background: 
                                @if($order->status == 'pending') #ffeeba; color: #856404; 
                                @elseif($order->status == 'waiting_verification') #d1ecf1; color: #0c5460;
                                @elseif($order->status == 'processing') #cce5ff; color: #004085;
                                @elseif($order->status == 'shipped') #b8daff; color: #004085; 
                                @elseif($order->status == 'completed') #c3e6cb; color: #155724; 
                                @elseif($order->status == 'cancelled') #f8d7da; color: #721c24;
                                @else #eee; @endif">
                            {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>

                    @if($order->status == 'pending')
                        <div
                            style="margin-bottom: 25px; padding: 20px; background: #fffaf0; border: 1px dashed #ffa502; border-radius: 15px;">
                            <h4 style="margin-top: 0; color: #e67e22;">📩 Konfirmasi Pembayaran</h4>
                            <p style="font-size: 0.85rem; color: #666; margin-bottom: 15px;">Silakan upload bukti transfer Anda
                                agar pesanan segera kami proses.</p>

                            <form action="{{ route('orders.confirm-payment', $order) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="payment_proof" accept="image/*" required
                                    style="width: 100%; margin-bottom: 10px; font-size: 0.8rem;">
                                <button type="submit" class="btn"
                                    style="width: 100%; padding: 10px; border-radius: 10px; background: #ffa502;">
                                    Upload Bukti
                                </button>
                            </form>
                        </div>
                    @endif

                    @if($order->payment_proof)
                        <div style="margin-bottom: 25px; text-align: center;">
                            <p style="font-size: 0.85rem; color: #666; margin-bottom: 10px;">Bukti yang Anda unggah:</p>
                            <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                <img src="{{ asset('storage/' . $order->payment_proof) }}"
                                    style="width: 100%; max-height: 150px; object-fit: cover; border-radius: 10px; border: 1px solid #ddd;">
                            </a>
                        </div>
                    @endif

                    @if($order->tracking_number)
                        <div style="padding: 20px; background: #e7f3ff; border-radius: 15px; border-left: 5px solid #007bff;">
                            <p style="margin: 0; font-size: 0.9rem; color: #0056b3; font-weight: 700;">NOMOR RESI:</p>
                            <h2 style="margin: 10px 0; color: #004085; word-break: break-all;">{{ $order->tracking_number }}
                            </h2>
                            <p style="margin: 0; font-size: 0.8rem; color: #666;">Gunakan nomor di atas untuk melacak paket Anda
                                di sistem ekspedisi terkait.</p>
                        </div>
                    @else
                        <p style="color: #999; text-align: center;">Resi akan muncul di sini setelah barang dikirim oleh tim
                            {{ config('app.name') }}.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection