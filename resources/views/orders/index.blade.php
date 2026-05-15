@extends('layouts.frontend')

@section('title', 'Riwayat Pesanan Saya - ' . config('app.name'))

@section('content')
<div class="container" style="padding-top: 50px;">
    <div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
        <h1>Pesanan Saya</h1>
        <a href="{{ route('home') }}" class="btn" style="background: #6c757d;">Belanja Lagi</a>
    </div>

    @if($orders->count() > 0)
    <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: var(--shadow); overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #eee;">
                    <th style="padding: 15px;">Order ID</th>
                    <th style="padding: 15px;">Total Belanja</th>
                    <th style="padding: 15px;">Status</th>
                    <th style="padding: 15px;">No. Resi</th>
                    <th style="padding: 15px;">Tanggal</th>
                    <th style="padding: 15px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px;">#{{ $order->id }}</td>
                    <td style="padding: 15px;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td style="padding: 15px;">
                        <span style="padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; font-weight: 700; background: 
                            @if($order->status == 'pending') #ffeeba; color: #856404; @elseif($order->status == 'shipped') #b8daff; color: #004085; @elseif($order->status == 'completed') #c3e6cb; color: #155724; @else #eee; @endif">
                            {{ strtoupper($order->status) }}
                        </span>
                    </td>
                    <td style="padding: 15px;">{{ $order->tracking_number ?? '-' }}</td>
                    <td style="padding: 15px;">{{ $order->created_at->format('d M Y') }}</td>
                    <td style="padding: 15px;">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn" style="padding: 8px 15px; font-size: 0.9rem;">Lihat Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $orders->links() }}
        </div>
    </div>
    @else
    <div style="background: white; padding: 50px; border-radius: 20px; box-shadow: var(--shadow); text-align: center;">
        <h3 style="color: #999;">Anda belum memiliki riwayat pesanan.</h3>
        <p style="margin-bottom: 30px;">Ayo mulai belanja produk edukasi terbaik untuk si kecil!</p>
        <a href="{{ route('home') }}" class="btn">Mulai Belanja</a>
    </div>
    @endif
</div>
@endsection
