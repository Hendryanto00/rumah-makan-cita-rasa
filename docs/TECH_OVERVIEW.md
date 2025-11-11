## Ringkasan Teknologi dan Arsitektur Aplikasi

Aplikasi ini dibangun dengan stack berikut:

- Framework backend: Laravel 11 (PHP 8.2+)
- ORM: Eloquent (relasi antar model dan query builder)
- View layer: Blade + Tailwind CSS + Font Awesome
- Interaksi ringan di frontend: Alpine (via atribut `x-data`, `x-show`) dan JavaScript vanilla
- Grafik: Chart.js (CDN)
- PDF: barryvdh/laravel-dompdf
- Pembayaran: Midtrans (Snap/notification)
- Database: SQLite (dev) / MySQL/PG (prod), migrasi Laravel
- Auth: Laravel Breeze/fortify-style flows (login/register/verify)

Pengorganisasian kode mengikuti standar Laravel: `app/Http/Controllers`, `app/Models`, `resources/views`, `routes/web.php`, `database/migrations`, dll.

---

## Model Data Utama

- `User` (punya `role_id` → `Role`): relasi ke `Cart`, `Order`, `Review`, `Report`, `ActivityLog`.
- `Role` (admin, owner, user)
- `Category` 1..* `Menu`
- `Menu` (stock, price, active) terhubung dengan `OrderDetail` melalui `Order`
- `Cart` 1..* `CartItem`
- `Order` 1..* `OrderDetail`, 1..1 `Payment`
- `Payment` (status, amount, snap_token, paid_at, dsb.)
- `Review` (user menilai menu; dimoderasi admin)
- `Report` (entitas internal untuk laporan)
- `ActivityLog` (mencatat aksi penting admin: tambah/ubah/hapus/approve)

Relasi didefinisikan lewat Eloquent (`hasOne`, `hasMany`, `belongsTo`). Casting, fillable, hidden dideklarasikan pada setiap model untuk keamanan masal (mass-assignment) dan serialisasi.

---

## Alur Umum HTTP (Laravel)

1. Request masuk ke `routes/web.php` → route guard (`auth`, `verified`, `can:admin-only`, `can:owner-only`).
2. Controller menerima request, memvalidasi data (`$request->validate()`), menjalankan logika bisnis (query melalui Eloquent/DB builder).
3. Controller merender Blade view atau mengembalikan JSON (AJAX/polling).
4. Notifikasi sukses/gagal menggunakan session flash + SweetAlert modal (di `layouts/*.blade.php`).

---

## Fitur Peran User

### 1) Landing dan Menu Publik
- Route: `GET /`, `GET /menu`, `GET /menu/{menu}`
- Controller: `MenuController@index/show`
- Pencarian dan filter kategori dilakukan via query string (debounce, fetch untuk partial update grid).
- View: `resources/views/menus/*.blade.php` (grid kartu menu, badge stok, modal tambah ke keranjang).

### 2) Keranjang dan Pemesanan
- Model: `Cart`, `CartItem`
- Route (terlindungi `verified`): `cart.add`, `cart.index`, `cart.update`, `cart.remove`, `cart.clear`
- Alur:
  - Dari modal "Tambah ke Keranjang", request AJAX `POST cart.add` menambah item (validasi stock, quantity, notes).
  - Setelah checkout, `Order` dan `OrderDetail` dibuat; lanjut ke pembayaran Midtrans.

### 3) Pembayaran (Midtrans)
- `PaymentController`:
  - Membuat `snap_token` dan menyalurkan ke frontend Snap (jika dipakai).
  - Menerima `POST /midtrans/notification` (webhook). Memperbarui `payments.payment_status` dan `paid_at`.
  - Invoice `GET /order/{order}/invoice` (user) dan `GET /orders/{order}/invoice` (admin).

### 4) Review Menu
- `ReviewController` (user terverifikasi)
- CRUD (kecuali edit/index untuk user). Lihat review per menu via `GET /menus/{menu}/reviews` (AJAX).

---

## Fitur Peran Admin

### 1) Kelola Menu
- Controller: `App\Http\Controllers\Admin\MenuController`
- Endpoint resource (`index/create/store/edit/update/destroy`).
- Upload gambar (validasi + simpan ke `public/images/menu`), rename jika mengubah nama.
- Activity log:
  - Tambah: "Tambah Menu" + ringkasan harga/stock/kategori
  - Ubah: "Ubah Menu" + daftar field yang berubah (nama, harga, stock, kategori, status, deskripsi)
  - Hapus: "Hapus Menu" + ringkasan data

### 2) Kelola Kategori
- Controller: `CategoryController` (ruang lingkup admin)
- Pindah beberapa menu antar-kategori (log aktivitas "Pindah Menu").
- Tambah/ubah/hapus kategori (log aktivitas).

### 3) Kelola Pesanan
- Controller: `App\Http\Controllers\Admin\OrderController`
- `updateStatus` mengubah status `Order` (pending/paid/diproses/selesai/batal) + tulis `ActivityLog`.

### 4) Moderasi Ulasan
- Controller: `AdminReviewController`
- Aksi: approve/hide/unhide/reject (+ bulk action) dengan ActivityLog ringkas.

### 5) Profil Admin
- `Admin\ProfileController@update` mencatat perubahan profil (field yang berubah) ke `ActivityLog`.

### 6) Aktivitas Sistem
- Model: `ActivityLog`
- Sumber penulisan log: controller-admin memanggil `App\Services\ActivityLogger::log(...)`.
- Tabel DB: `activity_logs` (`user_id`, `action`, `target_table`, `target_id`, `description`, timestamps).

---

## Fitur Peran Owner

### 1) Dashboard Owner
- Controller: `Owner\DashboardController@index`
- Query ringkasan:
  - Pendapatan total/hari-ini/bulan-ini, growth vs bulan lalu
  - Tren penjualan 7 hari dan 6 bulan terakhir (Chart.js)
  - Menu terlaris & Pendapatan per kategori
  - Status pesanan, pesanan terbaru, stok menipis
- Responsif:
  - Chart: `maintainAspectRatio: false`, `suggestedMax` dinamis, label uang (k/M)
  - Tabel besar punya mode mobile list (md:hidden) untuk keterbacaan

### 2) Laporan Penjualan Harian
- Controller: `Owner\ReportController@dailyReport`
- Filter tanggal (default hari ini). Query: total pesanan, omzet, pelanggan, popular menus, detail pesanan.
- Download PDF: `dailyReportPdf()`. Jika tidak ada data → redirect + modal error (SweetAlert).
- View: `owner/reports/daily.blade.php` (responsif; daftar item pesanan pada mobile tampil badge + tombol “+N lainnya”).

### 3) Laporan Penjualan Bulanan
- Controller: `monthlyReport`, `monthlyReportPdf`
- Filter bulan (default bulan ini). Query: total pesanan, omzet, pelanggan, top menus, ringkasan harian (array).
- Perbandingan omzet vs bulan sebelumnya.

### 4) Laporan Menu Terlaris (periode)
- Controller: `topMenusReport`, `topMenusReportPdf`
- Filter `start_date` – `end_date`, tabel “Top by Quantity” dan “Top by Revenue” + kontribusi persen.
- Responsif: tabel (desktop) + list (mobile).

### 5) Laporan Aktivitas Sistem (Owner)
- Controller: `Owner\ActivityLogController@index`
- Filter: rentang tanggal, jenis aksi, tabel target, admin pelaku.
- Statistik ringkas “per aksi” dan “per tabel”.
- Tabel desktop + kartu list untuk mobile.
- Download PDF: `downloadPdf()`; jika data kosong → modal error.

### 6) Navigasi Owner
- Sidebar responsif (collapse di mobile), dropdown “Download PDF” di setiap menu laporan:
  - Klik nama menu → ke halaman laporan
  - Klik chevron → buka dropdown download PDF
  - Link download membaca filter aktif dari halaman via JS sebelum redirect (untuk menjaga context filter)

---

## Realtime dan UX Micro-interactions

- Beberapa halaman publik menggunakan fetch/AJAX untuk mencari/filter tanpa reload halaman (menu grid/pagination).
- `resources/views/menus/index.blade.php` memiliki JS untuk:
  - Modal “Tambah ke keranjang” (validasi stock di client, update badge keranjang)
  - Notification kecil di pojok kanan atas (success/error) dengan `z-index` di atas navbar
  - Polling ringan (contoh: menu updates) ke endpoint `routes/api/*` (lihat `RealtimeController`)

---

## Kebijakan Logging Aktivitas

- Tujuan: audit perubahan data oleh admin.
- Strategi saat ini: logging via controller (bukan model event) agar deskripsinya kontekstual.
- Helper `ActivityLogger::log($action, $targetTable, $targetId, $description)` memastikan struktur seragam.
- Retensi/skalabilitas (disarankan):
  - Index kolom: `created_at`, `(user_id, created_at)`, `(action, created_at)`, `(target_table, created_at)`
  - Retensi 6–12 bulan di DB utama; arsipkan lebih lama ke tabel arsip/CSV/Parquet
  - Alternatif: kirim ke log pipeline (ELK, Loki, ClickHouse) untuk skala besar

---

## Pola Responsif yang Digunakan

- Tabel besar memiliki dua presentasi:
  - Desktop/tablet: tabel penuh `hidden md:block`
  - Mobile: list ringkas `md:hidden` dengan informasi paling penting (badge, label, nilai)
- Chart: kanvas tinggi adaptif (Tailwind `h-64`) dan `maintainAspectRatio: false`
- Badge “+N lainnya” pada daftar item pesanan (mobile) memakai Alpine untuk expand/collapse per baris.

---

## PDF Export

- View PDF terpisah: `resources/views/owner/reports/pdf/*.blade.php` dan `owner/activity-logs/pdf.blade.php`
- `Pdf::loadView(...)->setPaper('a4','portrait')->download($filename)`
- Proteksi UX: jika periode kosong, controller redirect kembali dan tampilkan modal error (SweetAlert).

---

## Keamanan & Otorisasi

- Middleware:
  - `auth`: semua area private
  - `verified`: area order/keranjang
  - `can:admin-only` & `can:owner-only`: dashboard & resource khusus
- CSRF: otomatis pada form Blade, AJAX menyertakan `X-CSRF-TOKEN` dari meta tag.

---

## Tips Pengembangan

- Tambahkan test feature untuk alur penting (order & payment) di `tests/Feature`.
- Untuk menambah aktivitas yang dilog:
  - Panggil `ActivityLogger::log()` di titik perubahan (controller/service)
  - Gunakan deskripsi singkat yang mudah dipahami (hindari ID di teks untuk tampilan Owner)
- Untuk performa laporan:
  - Gunakan agregasi SQL (`SUM`, `COUNT`, `GROUP BY`) dan batasi kolom yang dipilih
  - Tambahkan index pada kolom filter (tanggal/status/foreign keys)

---

## Peta Kode Cepat

- Controllers utama:
  - Publik/User: `MenuController`, `CartController`, `OrderController`, `ReviewController`, `PaymentController`
  - Admin: `Admin\MenuController`, `Admin\OrderController`, `AdminReviewController`, `CategoryController`, `Admin\ProfileController`
  - Owner: `Owner\DashboardController`, `Owner\ReportController`, `Owner\ActivityLogController`
- Models: `app/Models/*` (lihat daftar model di bagian atas)
- Views: 
  - Layouts: `resources/views/layouts/*.blade.php` (navbar, owner sidebar, SweetAlert hook)
  - User: `resources/views/menus/*`, `cart/*`, `orders/*`
  - Admin: `resources/views/admin/*`
  - Owner: `resources/views/owner/*` (dashboard, reports, activity-logs)
- Routes: `routes/web.php` (guarded groups untuk admin/owner/user) + `routes/auth.php` + `routes/api` (polling)

---

Dengan dokumen ini, Anda bisa menjelaskan di skripsi:

1) Arsitektur MVC Laravel dan bagaimana data mengalir dari route → controller → model → view.
2) Pembagian peran (RBAC sederhana dengan `Role`) dan proteksi halaman.
3) Desain laporan (query agregasi, filter) serta ekspor PDF.
4) Strategi responsif UI (tabel → list; chart adaptif).
5) Logging aktivitas admin untuk audit dan retensi jangka panjang.

Jika Anda memerlukan sequence diagram/ERD, tambahkan di folder `docs/` ini; pola relasi sudah tercermin di model dan migrasi. 


