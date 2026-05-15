<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Category::firstOrCreate(
            ['slug' => 'buku-anak'],
            ['name' => 'Buku Anak', 'description' => 'Berbagai macam buku cerita dan edukasi untuk anak-anak.']
        );

        \App\Models\Category::firstOrCreate(
            ['slug' => 'buku-dewasa'],
            ['name' => 'Buku Dewasa', 'description' => 'Berbagai macam buku untuk orang dewasa.']
        );

        \App\Models\Category::firstOrCreate(
            ['slug' => 'buku-parenting'],
            ['name' => 'Buku Parenting', 'description' => 'Berbagai macam buku untuk orang tua.']
        );

        \App\Models\Category::firstOrCreate(
            ['slug' => 'mainan-edukasi'],
            ['name' => 'Mainan Edukasi', 'description' => 'Mainan yang membantu tumbuh kembang dan kecerdasan anak.']
        );
    }
}
