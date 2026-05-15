<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,waiting_verification,processing,shipped,completed,cancelled',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $newStatus = $request->status;
        $order->load('items.product');

        // Logic for stock deduction
        if (in_array($newStatus, ['processing', 'shipped', 'completed']) && !$order->is_stock_deducted) {
            // Check if stock is sufficient
            foreach ($order->items as $item) {
                if ($item->product && $item->product->stock < $item->quantity) {
                    return redirect()->back()->with('error', 'Stok tidak mencukupi untuk memproses pesanan ini. Produk: ' . $item->product->name . ' (Stok: ' . $item->product->stock . ')');
                }
            }

            // Deduct stock
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            $order->is_stock_deducted = true;
        }

        // Logic for stock restoration if cancelled
        if ($newStatus === 'cancelled' && $order->is_stock_deducted) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
            $order->is_stock_deducted = false;
        }

        $order->status = $newStatus;
        $order->tracking_number = $request->tracking_number;
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
