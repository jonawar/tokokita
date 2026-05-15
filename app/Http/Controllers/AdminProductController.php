<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Exports\ProductsTemplateExport;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'supplier'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function show($id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('products.show', $id);
        }
        $product = Product::findOrFail($id);
        return redirect()->route('admin.products.edit', $product);
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'type' => 'required|in:book,toy',
            'image_url' => 'nullable|url',
            'video_url' => 'nullable|url',
            'is_promo' => 'nullable|boolean',
            'promo_price' => 'nullable|numeric|min:0|lt:price',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'nullable|url',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(), // Temporary slug
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'type' => $request->type,
            'image_url' => $request->image_url,
            'video_url' => $request->video_url,
            'is_promo' => $request->has('is_promo'),
            'promo_price' => $request->promo_price,
        ]);

        // Update slug with real ID for consistency
        $product->update([
            'slug' => Str::slug($request->name) . '-' . $product->id,
        ]);

        if ($request->has('additional_images')) {
            foreach ($request->additional_images as $imageUrl) {
                if ($imageUrl) {
                    $product->images()->create([
                        'image_url' => $imageUrl,
                        'is_primary' => false,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'type' => 'required|in:book,toy',
            'image_url' => 'nullable|url',
            'video_url' => 'nullable|url',
            'is_promo' => 'nullable|boolean',
            'promo_price' => 'nullable|numeric|min:0|lt:price',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'nullable|url',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . $product->id,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'type' => $request->type,
            'image_url' => $request->image_url,
            'video_url' => $request->video_url,
            'is_promo' => $request->has('is_promo'),
            'promo_price' => $request->promo_price,
        ]);

        // Handle additional images: only delete and re-sync if the field is present in the request
        if ($request->has('additional_images')) {
            $product->images()->delete();
            foreach ($request->additional_images as $imageUrl) {
                if (!empty($imageUrl)) {
                    $product->images()->create([
                        'image_url' => $imageUrl,
                        'is_primary' => false,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new ProductsImport, $request->file('file'));
            return redirect()->back()->with('success', 'Produk berhasil diimpor!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimpor: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new ProductsTemplateExport, 'template_produk.xlsx');
    }
}
