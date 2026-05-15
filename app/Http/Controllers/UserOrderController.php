<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    /**
     * Confirm payment by uploading proof.
     */
    public function confirmPayment(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            $image = $request->file('payment_proof');
            $imageName = 'proof_' . $order->id . '_' . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('payment_proofs', $imageName, 'public');

            $order->update([
                'payment_proof' => $path,
                'status' => 'waiting_verification',
            ]);

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah! Mohon tunggu verifikasi dari admin.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah bukti pembayaran.');
    }
}
