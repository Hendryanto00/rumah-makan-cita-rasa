<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

# 🍽️ Sistem Informasi Pemesanan Makanan Berbasis Website – Rumah Makan Cita Rasa

Proyek ini merupakan sistem informasi berbasis web yang digunakan untuk mempermudah proses pemesanan makanan di **Rumah Makan Cita Rasa**.  
Dibangun menggunakan framework **Laravel**, sistem ini menyediakan fitur seperti:
- Pemesanan menu secara online
- Manajemen data pengguna, pengelolaan pesanan dan menu oleh admin
- Keranjang belanja dan pembayaran
- Laporan transaksi bulanan, menu terlaris dan laporan altivitas admin oleh owner

---

## 🚀 Fitur Utama

- 🔐 **Autentikasi Pengguna:** Login, Register, dan Lupa Password
- 🍱 **Manajemen Menu:** CRUD (Create, Read, Update, Delete) untuk data makanan/minuman
- 🛒 **Keranjang Belanja (Cart):** Tambah, hapus, dan ubah jumlah pesanan
- 💵 **Pemesanan & Pembayaran:** Integrasi dengan Midtrans untuk pembayaran online
- 📊 **Laporan Penjualan:** Menampilkan data transaksi dan rekap pesanan
- 👨‍💼 **Admin Panel:** Mengelola pengguna, menu, dan pesanan pelanggan

---

## 🧰 Teknologi yang Digunakan

- **Laravel 10+** – Framework utama backend  
- **Blade Template** – View engine untuk frontend  
- **MySQL** – Database sistem  
- **TailwindCSS / Bootstrap** – Desain antarmuka  
- **Midtrans API** – Gateway pembayaran  
- **JavaScript** – Interaktivitas halaman  

---

## ⚙️ Cara Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/nama-proyek.git
cd nama-proyek
```
### 2. Install Dependencies

```bash
composer install
npm install
npm run dev
```
### 3. Buat File .env

```bash
cp .env.example .env
php artisan key:generate
```
### 4. Konfigurasi Database

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ur_db_name
DB_USERNAME=root
DB_PASSWORD=
```

Lalu jalankan migrasi:
```bash
php artisan migrate
```
### 5. Jalankan Server

```bash
php artisan serve
```
