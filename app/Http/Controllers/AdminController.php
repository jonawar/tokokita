<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Total Pendapatan (Pesanan yang sudah dibayar/diproses)
        $totalRevenue = Order::whereIn('status', ['processing', 'shipped', 'completed'])->sum('total_price');

        // 2. Menunggu Verifikasi
        $waitingVerificationCount = Order::where('status', 'waiting_verification')->count();

        // 3. Total Pesanan Keseluruhan
        $orderCount = Order::count();

        // 4. Total Katalog Produk
        $productCount = Product::count();

        // 5. Pesanan Terbaru
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'waitingVerificationCount',
            'orderCount',
            'productCount',
            'recentOrders'
        ));
    }
}
