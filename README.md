<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

# 🍽️ Sistem Informasi Pemesanan Makanan Berbasis Website – Rumah Makan Cita Rasa

**Rumah Makan Cita Rasa** adalah sistem informasi berbasis web yang dirancang untuk mempermudah proses pemesanan makanan secara online. Proyek ini dibangun menggunakan framework **Laravel 12** dengan berbagai fitur lengkap untuk pelanggan, admin, dan pemilik restaurant.

Sistem ini menyediakan platform yang memungkinkan pelanggan untuk memesan makanan secara online, admin untuk mengelola menu dan pesanan, serta owner untuk melihat laporan penjualan dan aktivitas sistem.

---

## ✨ Fitur Utama

### 👤 Untuk Pelanggan (User)
- **Registrasi & Autentikasi** – Sistem registrasi dengan verifikasi email
- **Lupa Password** – Reset password melalui email
- **Fitur Menu** – Lihat dan filter menu berdasarkan kategori
- **Keranjang Belanja** – Tambah, update, hapus item dengan notes khusus
- **Pemesanan** – Proses checkout dengan detail pesanan lengkap
- **Pembayaran** – Integrasi Midtrans (Snap Payment Gateway)
- **Status Pesanan** – Tracking status pesanan secara real-time
- **Review & Rating** – Berikan ulasan untuk menu yang dipesan
- **Profile Management** – Kelola data profile dan riwayat pesanan

### 👨‍💼 Untuk Admin
- **Dashboard Admin** – Ringkasan statistik penjualan
- **Manajemen Menu** – CRUD menu dengan kategori, harga, dan stok
- **Manajemen Kategori** – Kelola kategori menu
- **Manajemen Pesanan** – Kelola semua pesanan pelanggan
- **Update Status Pesanan** – Update status pesanan (pending, processing, completed, dll)
- **Manajemen User** – Lihat dan kelola data pengguna

### 👑 Untuk Owner
- **Dashboard Owner** – Overview bisnis dan analitik
- **Laporan Transaksi** – Laporan penjualan harian, mingguan, dan bulanan
- **Laporan Menu Terlaris** – Analisis menu paling populer
- **Laporan Aktivitas** – Activity log untuk semua aktivitas sistem

---

## 🗂️ Struktur Database

Sistem menggunakan database MySQL dengan tabel-tabel berikut:
- **users** – Data pengguna dengan role-based access
- **roles** – Role: user, admin, owner
- **categories** – Kategori menu
- **menus** – Data menu makanan/minuman
- **carts** & **cart_items** – Keranjang belanja
- **orders** & **order_details** – Pemesanan dan detail pesanan
- **payments** – Data pembayaran (Midtrans integration)
- **reviews** – Ulasan dan rating menu
- **reports** – Laporan penjualan
- **activity_logs** – Log aktivitas sistem

---

## 🧰 Teknologi yang Digunakan

### Backend
- **Laravel 12** – Framework PHP modern
- **PHP 8.2+** – Bahasa pemrograman
- **MySQL** – Database management system
- **Midtrans API** – Payment gateway integration

### Frontend
- **Blade Template** – Template engine Laravel
- **Tailwind CSS** – Utility-first CSS framework
- **Alpine.js** – Lightweight JavaScript framework
- **Vite** – Build tool modern dan cepat

### Tools & Packages
- **Laravel Breeze** – Authentication scaffolding
- **Laravel Tinker** – Command line REPL
- **Faker** – Generate fake data untuk testing
- **Midtrans PHP SDK** – Payment gateway library

---

## ⚙️ Cara Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL
- Git

### 1. Clone Repository

```bash
git clone https://github.com/username/rumah-makan-cita-rasa.git
cd rumah-makan-cita-rasa
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Setup Environment

```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rumah_makan_cita_rasa
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Konfigurasi Midtrans (Opsional untuk Development)

Tambahkan konfigurasi Midtrans di file `.env`:

```env
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_SANITIZED=true
MIDTRANS_3DS_SECURE=true
```

### 6. Migrasi Database & Seeder

```bash
# Run migrations
php artisan migrate

# (Opsional) Run seeders untuk data dummy
php artisan db:seed
```

### 7. Build Assets

```bash
# Development mode (watch for changes)
npm run dev

# Production mode (untuk deployment)
npm run build
```

### 8. Jalankan Server

```bash
php artisan serve
```

---

## 📝 Akun Default (Setelah Seeder)

### User (Pelanggan)
- Email: `user@example.com`
- Password: `password`

### Admin
- Email: `admin@example.com`
- Password: `password`

### Owner
- Email: `owner@example.com`
- Password: `password`

> **Catatan:** Pastikan jalankan seeder untuk mendapatkan akun default di atas.

---

## 🗄️ Database Seeder

Untuk mengisi database dengan data dummy:

```bash
php artisan db:seed

# Atau seed spesifik
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=MenuSeeder
php artisan db:seed --class=ReviewSeeder
```

---

## 📂 Struktur Proyek

```
rumah-makan-cita-rasa/
├── app/
│   ├── Console/Commands/
│   ├── Http/
│   │   ├── Controllers/      # Controller untuk handling request
│   │   ├── Middleware/       # Custom middleware
│   │   └── Requests/         # Form request validation
│   ├── Mail/                 # Email notifications
│   ├── Models/               # Eloquent models
│   ├── Notifications/        # Notifications system
│   └── Policies/            # Authorization policies
├── config/                   # Konfigurasi aplikasi
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── public/                  # Public assets & index.php
├── resources/
│   ├── views/               # Blade templates
│   ├── css/                # CSS files
│   └── js/                 # JavaScript files
├── routes/                  # Route definitions
├── storage/                 # Storage files & logs
├── tests/                   # PHPUnit tests
└── vendor/                  # Composer dependencies
```

---

## 🚀 Fitur Lanjutan

### Email Verification
- Sistem verifikasi email untuk keamanan akun
- Custom email template

### Cart dengan Notes
- Pelanggan dapat menambahkan catatan khusus untuk setiap menu

### Activity Logging
- Pencatatan aktivitas sistem untuk audit trail

### Responsive Design
- Mobile-friendly dengan Tailwind CSS
- Optimized untuk berbagai perangkat

---

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) – The PHP Framework for Web Artisans
- [Tailwind CSS](https://tailwindcss.com) – A utility-first CSS framework
- [Midtrans](https://midtrans.com) – Payment gateway
- [Alpine.js](https://alpinejs.dev) – A rugged, minimal framework for composing JavaScript behavior
