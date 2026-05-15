<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Skip if name is empty
        if (empty($row['nama'])) {
            return null;
        }

        $categoryName = trim($row['kategori']);
        $category = Category::where('name', 'LIKE', "%$categoryName%")->first();
        
        if (!$category) {
            return null; // Skip if category not found
        }

        $supplierName = trim($row['suplier'] ?? '');
        $supplierId = null;
        if (!empty($supplierName)) {
            $supplier = Supplier::where('name', 'LIKE', "%$supplierName%")->first();
            $supplierId = $supplier ? $supplier->id : null;
        }

        return new Product([
            'name'        => trim($row['nama']),
            'slug'        => Str::slug($row['nama']) . '-' . time() . rand(1, 100),
            'category_id' => $category->id,
            'supplier_id' => $supplierId,
            'description' => trim($row['deskripsi'] ?? ''),
            'price'       => (float)($row['harga'] ?? 0),
            'stock'       => (int)($row['stok'] ?? 0),
            'type'        => strtolower(trim($row['tipe_bukumainan'] ?? '')) == 'mainan' ? 'toy' : 'book',
            'image_url'   => $row['image_url'] ?? null,
        ]);
    }
}
