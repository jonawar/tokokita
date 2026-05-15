<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $products = Product::with(['category', 'supplier', 'images']);

        // Search logic (Standard Database Search)
        if (!empty($search)) {
            $products->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Filters
        if ($request->has('category') && $request->category != '') {
            $products->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('supplier') && $request->supplier != '') {
            $products->whereHas('supplier', function ($q) use ($request) {
                $q->where('id', $request->supplier);
            });
        }

        if ($request->has('type') && $request->type != '') {
            $products->where('type', $request->type);
        }

        // Priority: In stock first, Out of stock last
        $products->orderByRaw('stock > 0 DESC');

        // Internal Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $products->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $products->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $products->orderBy('name', 'asc');
                break;
            default:
                $products->orderBy('stock', 'desc');
                $products->latest();
                break;
        }

        $products = $products->paginate(12)->appends($request->query());

        $categories = Category::all();
        $suppliers = \App\Models\Supplier::all();

        return view('products.index', compact('products', 'categories', 'suppliers'));
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'supplier', 'images'])->where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }
}
