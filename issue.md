# Isu: Optimalisasi Tampilan Customer untuk Mobile

## Deskripsi
Tampilan customer saat ini perlu dioptimalkan agar responsif dan nyaman digunakan di perangkat mobile (smartphone/tablet). Beberapa elemen UI mungkin terlihat berantakan, tumpang tindih, atau terlalu kecil untuk ditekan (touch target) pada layar yang lebih kecil.

## Tujuan
Memastikan seluruh halaman utama yang diakses oleh pelanggan (customer) dapat beradaptasi dengan baik di berbagai ukuran layar, mulai dari mobile hingga desktop.

## Ruang Lingkup (Halaman yang Perlu Diperiksa & Diperbaiki)

- [x] **Navbar & Footer**
  - [x] Implementasi hamburger menu untuk mobile.
  - [x] Pastikan navigasi mudah dijangkau dan ukurannya pas untuk sentuhan.
  - [x] Penyesuaian tata letak footer di layar kecil (susun vertikal jika perlu).

- [x] **Halaman Beranda (Home / Katalog Utama)**
  - [x] Penyesuaian grid produk (misal: 1 atau 2 kolom untuk mobile, bukan 3 atau 4).
  - [x] Optimasi slider/banner agar ukurannya proporsional dan teks tetap terbaca.
  - [x] Filter dan pencarian produk mudah digunakan di layar kecil.

- [x] **Halaman Detail Produk (`products/show.blade.php`)**
  - [x] Gambar produk dan gallery menyesuaikan lebar layar.
  - [x] Tombol "Beli" / "Tambah ke Keranjang" menonjol dan ukurannya besar (tappable).
  - [x] Teks deskripsi dan spesifikasi produk tidak keluar dari batas layar.

- [x] **Halaman Keranjang (Cart) & Checkout**
  - [x] Tabel rincian keranjang mungkin perlu diubah menjadi list card untuk mobile agar tidak terpotong (overflow).
  - [x] Form input pada saat checkout harus responsif (lebar 100%).

## Panduan Perbaikan
- Gunakan utility class dari framework CSS yang ada (misal: Bootstrap atau Tailwind CSS).
- Manfaatkan kelas-kelas responsif seperti `md:flex`, `lg:w-1/2`, `col-12 col-md-6`, dsb.
- Pastikan ukuran font untuk teks minimal 14px-16px agar mudah dibaca di mobile.
- Area yang bisa diklik (tombol, tautan) sebaiknya memiliki tinggi/lebar minimal 44px x 44px.

## Status
- [x] Selesai & Menunggu Testing
