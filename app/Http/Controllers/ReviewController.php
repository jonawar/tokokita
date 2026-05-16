<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews for admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->latest()->paginate(20);
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Store a newly created review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('product_id', $product->id)
                                ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        // Optional: Check if user has purchased the product
        // $hasPurchased = Auth::user()->orders()
        //     ->whereHas('items', function($query) use ($product) {
        //         $query->where('product_id', $product->id);
        //     })
        //     ->where('status', 'completed')
        //     ->exists();
        // 
        // if (!$hasPurchased) {
        //     return back()->with('error', 'Anda hanya dapat memberikan ulasan untuk produk yang telah dibeli.');
        // }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true, // Auto-approve for now
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }

    /**
     * Remove the specified review from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Ulasan telah dihapus.');
    }

    /**
     * Approve the specified review.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        return back()->with('success', 'Ulasan telah disetujui.');
    }
}
