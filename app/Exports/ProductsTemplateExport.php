<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    public function array(): array
    {
        return [
            ['Buku Contoh 1', 'Buku Anak', '', 'Deskripsi buku baru ini adalah contoh untuk diisi.', '50000', '10', 'Buku', ''],
            ['Mainan Contoh 1', 'Mainan Edukasi', '', 'Deskripsi mainan edukasi baru.', '75000', '5', 'Mainan', ''],
        ];
    }

    public function headings(): array
    {
        return ['Nama', 'Kategori', 'Suplier', 'Deskripsi', 'Harga', 'Stok', 'Tipe (Buku/Mainan)', 'Image URL'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold
            1    => ['font' => ['bold' => true]],
        ];
    }
}
