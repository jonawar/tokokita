# Tokokita - E-Commerce Platform

Tokokita adalah platform e-commerce berbasis Laravel yang dirancang khusus untuk toko buku, mainan edukatif, dan produk digital lainnya. Platform ini memiliki fitur unggulan berupa pencarian cepat (Meilisearch) dan proses instalasi yang mudah bagi pengguna non-teknis melalui Web Installer.

## 🚀 Tech Stack

Platform ini dibangun menggunakan teknologi modern:

- **Backend**: [Laravel 8](https://laravel.com/)
- **Frontend Logic**: [Alpine.js](https://alpinejs.dev/)
- **Styling**: [Tailwind CSS 3](https://tailwindcss.com/)
- **Database**: MySQL / MariaDB
- **Search Engine**: [Meilisearch](https://www.meilisearch.com/) (via Laravel Scout)
- **Auth**: Laravel Breeze & JWT Auth
- **Excel Export/Import**: Maatwebsite Excel
- **Installer**: RachidLaasri Laravel Installer

## ✨ Fitur Utama

- 🛒 **Shopping Cart**: Sistem keranjang belanja yang intuitif.
- 🔍 **Fast Search**: Pencarian produk instan menggunakan Meilisearch.
- 📱 **Responsive Design**: Tampilan yang optimal di perangkat mobile dan desktop.
- 📦 **Order Management**: Kelola pesanan pelanggan dengan mudah bagi admin.
- 🛠 **Web Installer**: Setup database dan aplikasi langsung dari browser tanpa perlu terminal.
- 💬 **WhatsApp Integration**: Tombol chat langsung untuk tanya jawab produk.

## 🛠 Instalasi

Ikuti langkah-langkah berikut untuk menjalankan project di lingkungan lokal:

### Prasyarat
- PHP >= 7.3
- Composer
- Node.js & NPM
- MySQL

### Langkah-langkah

1. **Clone Repository**
   ```bash
   git clone https://github.com/jonawar/tokokita.git
   cd tokokita
   ```

2. **Install Dependensi Backend**
   ```bash
   composer install
   ```

3. **Install Dependensi Frontend**
   ```bash
   npm install
   npm run dev
   ```

4. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Atur koneksi database Anda di file `.env`.

5. **Generate App Key**
   ```bash
   php artisan key.generate
   ```

6. **Web Installer (Direkomendasikan)**
   Akses `http://localhost/install` di browser Anda untuk menyelesaikan proses instalasi (migrasi database dan pembuatan akun admin).

   **Atau Manual via Terminal:**
   ```bash
   php artisan migrate --seed
   ```

7. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```

## 🔐 Akun Admin Default
Jika menggunakan seeder, Anda dapat login dengan:
- **Email**: `admin@tokokita.com`
- **Password**: `admin123`

## 📄 Lisensi
Project ini dilisensikan di bawah [MIT License](LICENSE).
