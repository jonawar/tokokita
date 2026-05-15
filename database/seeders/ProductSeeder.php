<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bukuAnak = \App\Models\Category::where('slug', 'buku-anak')->first();
        $mainanEdukasi = \App\Models\Category::where('slug', 'mainan-edukasi')->first();

        \App\Models\Product::create([
            'category_id' => $bukuAnak->id,
            'name' => 'Cerita Si Kancil',
            'slug' => 'cerita-si-kancil',
            'description' => 'Buku cerita klasik yang mengajarkan kecerdikan.',
            'price' => 25000,
            'stock' => 50,
            'type' => 'book',
        ]);

        \App\Models\Product::create([
            'category_id' => $bukuAnak->id,
            'name' => 'Belajar Mewarnai Hewan',
            'slug' => 'belajar-mewarnai-hewan',
            'description' => 'Buku aktivitas mewarnai untuk anak PAUD dan TK.',
            'price' => 15000,
            'stock' => 100,
            'type' => 'book',
        ]);

        \App\Models\Product::create([
            'category_id' => $mainanEdukasi->id,
            'name' => 'Puzzle Kayu Alfabet',
            'slug' => 'puzzle-kayu-alfabet',
            'description' => 'Mainan edukasi untuk mengenalkan huruf pada anak.',
            'price' => 45000,
            'stock' => 30,
            'type' => 'toy',
        ]);

        \App\Models\Product::create([
            'category_id' => $mainanEdukasi->id,
            'name' => 'Balok Susun Warna-Warni',
            'slug' => 'balok-susun-warna-warni',
            'description' => 'Membantu koordinasi tangan dan mata serta pengenalan warna.',
            'price' => 60000,
            'stock' => 20,
            'type' => 'toy',
        ]);
    }
}
