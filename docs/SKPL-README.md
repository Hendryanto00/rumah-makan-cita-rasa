# Spesifikasi Kebutuhan Perangkat Lunak (SKPL)
## Sistem Informasi Pemesanan Makanan Berbasis Website – Rumah Makan Cita Rasa

---

# 3. Kebutuhan Rinci

## 3.1 Kebutuhan Antarmuka Eksternal

Pada kebutuhan antarmuka eksternal ini, sistem yang dibangun memiliki hubungan dengan berbagai pihak, baik dengan pengguna, perangkat keras, perangkat lunak, komunikasi maupun sistem. Kebutuhan ini bertujuan agar dapat memberikan gambaran mengenai interaksi yang terjadi di dalam sistem yang dibangun tersebut.

## 3.1.1 Antarmuka Pengguna

Rumah Makan Cita Rasa memiliki form antar muka berikut :

| No | Nama Form | Deskripsi Fungsi Form |
|---|---|---|
| 1 | Login | Digunakan oleh pengguna terdaftar untuk masuk kedalam sistem dengan email dan password dari akun yang telah terdaftar. |
| 2 | Register | Digunakan oleh calon pengguna untuk membuat akun baru dengan mengisi data akun berupa nama, email, password, nomor telepon, dan alamat. |
| 3 | Forgot Password | Digunakan oleh pengguna terdaftar untuk mengirim link validasi dan token unik ke alamat email yang telah dimasukkan. |
| 4 | Reset Password | Digunakan oleh pengguna yang telah tervalidasi untuk melakukan pengaturan ulang pada password akun yang dimiliki dengan password baru yang dimasukkan. |
| 5 | Verify Email | Digunakan oleh pengguna yang baru mendaftar untuk memverifikasi alamat email yang digunakan pada akun. |
| 6 | Tambah Item ke Keranjang | Digunakan oleh pelanggan untuk menambahkan menu makanan ke dalam keranjang belanja dengan mengisi jumlah item dan catatan khusus (opsional). |
| 7 | Update Item Keranjang | Digunakan oleh pelanggan untuk melakukan perubahan pada jumlah item dan catatan khusus pada item yang telah ditambahkan ke keranjang. |
| 8 | Hapus Item dari Keranjang | Digunakan oleh pelanggan untuk melakukan penghapusan item tertentu dari keranjang belanja. |
| 9 | Buat Pesanan | Digunakan oleh pelanggan untuk membuat pesanan baru dari semua item yang ada di dalam keranjang belanja. |
| 10 | Form Pembayaran | Digunakan oleh pelanggan untuk melakukan pembayaran pesanan menggunakan berbagai metode pembayaran yang tersedia melalui integrasi Midtrans. |
| 11 | Tambah Review | Digunakan oleh pelanggan untuk menambahkan review dan rating pada menu yang telah dipesan dengan mengisi rating dan komentar (opsional). |
| 12 | Update Review | Digunakan oleh pelanggan untuk melakukan perubahan pada review yang telah dibuat untuk menu tertentu. |
| 13 | Hapus Review | Digunakan oleh pelanggan untuk melakukan penghapusan review yang telah dibuat. |
| 14 | Log Out | Digunakan oleh pengguna terdaftar untuk keluar dari sistem secara aman. |
| 15 | Perbaharui Profil | Digunakan oleh pengguna terdaftar untuk melakukan perubahan pada data profil diri dengan mengisi data berupa nama, email, nomor telepon, dan alamat. |
| 16 | Perbaharui Password | Digunakan oleh pengguna terdaftar untuk melakukan perubahan pada password akun dengan memasukkan password lama dan password baru. |
| 17 | Hapus Akun | Digunakan oleh pengguna terdaftar untuk melakukan penghapusan akun secara permanen dari sistem. |
| 18 | Tambah Menu | Digunakan oleh admin untuk menambahkan menu makanan baru ke dalam sistem dengan mengisi data berupa nama menu, kategori, harga, stok, deskripsi, dan gambar. |
| 19 | Lihat Daftar Menu (Admin) | Digunakan oleh admin untuk melihat daftar semua menu yang tersedia dalam sistem dengan informasi lengkap dan opsi untuk melakukan edit atau hapus. |
| 20 | Perbaharui Menu | Digunakan oleh admin untuk melakukan perubahan pada data menu yang telah ada dengan mengisi data berupa nama menu, kategori, harga, stok, deskripsi, dan gambar. |
| 21 | Hapus Menu | Digunakan oleh admin untuk melakukan penghapusan menu tertentu dari sistem. |
| 22 | Lihat Daftar Pesanan (Admin) | Digunakan oleh admin untuk melihat daftar semua pesanan dari seluruh pelanggan dengan informasi status, tanggal, pelanggan, total harga, dan metode pembayaran. |
| 23 | Lihat Detail Pesanan (Admin) | Digunakan oleh admin untuk melihat informasi detail pesanan tertentu secara lengkap termasuk item yang dipesan, data pelanggan, status pembayaran, dan informasi lainnya. |
| 24 | Tambah Kategori | Digunakan oleh admin untuk menambahkan kategori menu baru ke dalam sistem dengan mengisi data berupa nama kategori dan deskripsi. |
| 25 | Lihat Daftar Kategori (Admin) | Digunakan oleh admin untuk melihat daftar semua kategori menu yang tersedia dalam sistem dengan informasi lengkap dan opsi untuk melakukan edit atau hapus. |
| 26 | Perbaharui Kategori | Digunakan oleh admin untuk melakukan perubahan pada data kategori yang telah ada dengan mengisi data berupa nama kategori dan deskripsi. |
| 27 | Hapus Kategori | Digunakan oleh admin untuk melakukan penghapusan kategori tertentu dari sistem. |
| 28 | Lihat Daftar Review (Admin) | Digunakan oleh admin untuk melihat daftar semua review yang diajukan oleh pelanggan dan dilengkapi dengan filter status serta pencarian. |
| 29 | Lihat Detail Review (Admin) | Digunakan oleh admin untuk melihat informasi detail review tertentu secara lengkap termasuk data reviewer dan menu yang direview. |
| 30 | Approve Review | Digunakan oleh admin untuk menyetujui review yang telah diajukan oleh pelanggan agar ditampilkan di halaman menu. |
| 31 | Hide Review | Digunakan oleh admin untuk menyembunyikan review tertentu agar tidak ditampilkan di halaman menu. |
| 32 | Reject Review | Digunakan oleh admin untuk menolak dan menghapus review tertentu dari sistem. |
| 33 | Statistik Review | Digunakan oleh admin untuk melihat statistik review termasuk total review, rata-rata rating, dan distribusi rating. |
| 34 | Statistik Dashboard (Owner) | Digunakan oleh owner untuk melihat statistik keseluruhan sistem termasuk total pesanan, total pelanggan, total pendapatan, menu terlaris, dan metrik bisnis lainnya. |
| 35 | Laporan Harian Penjualan (Owner) | Digunakan oleh owner untuk melihat laporan penjualan harian yang berisi total pesanan, total pendapatan, jumlah pelanggan, dan ringkasan transaksi pada tanggal tertentu. |
| 36 | Laporan Bulanan Penjualan (Owner) | Digunakan oleh owner untuk melihat laporan penjualan bulanan yang berisi ringkasan total pesanan, total pendapatan, jumlah pelanggan, menu terlaris, dan perbandingan performa bulanan. |
| 37 | Laporan Menu Terlaris (Owner) | Digunakan oleh owner untuk melihat laporan menu terlaris berdasarkan jumlah penjualan dan total pendapatan dalam periode tertentu. |
| 38 | Laporan Aktivitas Sistem (Owner) | Digunakan oleh owner untuk melihat laporan aktivitas sistem yang mencatat semua perubahan data yang dilakukan oleh admin. |
| 39 | Download Laporan Harian PDF (Owner) | Digunakan oleh owner untuk melakukan download laporan penjualan harian dalam format PDF untuk keperluan arsip digital dan pencetakan. |
| 40 | Download Laporan Bulanan PDF (Owner) | Digunakan oleh owner untuk melakukan download laporan penjualan bulanan dalam format PDF untuk keperluan arsip digital dan pencetakan. |
| 41 | Download Laporan Menu Terlaris PDF (Owner) | Digunakan oleh owner untuk melakukan download laporan menu terlaris dalam format PDF untuk keperluan arsip digital dan pencetakan. |
| 42 | Download Laporan Aktivitas Sistem PDF (Owner) | Digunakan oleh owner untuk melakukan download laporan aktivitas sistem dalam format PDF untuk keperluan arsip digital dan pencetakan. |

Selain form di atas, Rumah Makan Cita Rasa juga menyediakan report berikut ini:

| No | Nama Report | Deskripsi Fungsi Report |
|---|---|---|
| 1 | Detail Menu | Digunakan oleh semua pengguna untuk melihat informasi detail menu makanan tertentu termasuk harga, stok, deskripsi, kategori, dan rating rata-rata. |
| 2 | Daftar Menu | Digunakan oleh semua pengguna untuk melihat daftar menu makanan yang tersedia dan dilengkapi dengan filter berdasarkan kategori serta pencarian berdasarkan nama menu. |
| 3 | Detail Keranjang | Digunakan oleh pelanggan untuk melihat semua item yang telah ditambahkan ke dalam keranjang belanja termasuk total harga. |
| 4 | Daftar Pesanan | Digunakan oleh pelanggan untuk melihat daftar semua pesanan yang telah dibuat dan dilengkapi dengan filter status (pending, paid, diproses, selesai, batal). |
| 5 | Detail Pesanan | Digunakan oleh pelanggan untuk melihat informasi detail pesanan tertentu termasuk item yang dipesan, total harga, status pembayaran, dan informasi pengiriman. |
| 6 | Invoice PDF | Digunakan oleh pelanggan untuk melakukan download invoice pesanan dalam format PDF untuk keperluan arsip digital dan pencetakan. |
| 7 | Detail Review | Digunakan oleh semua pengguna untuk melihat informasi detail review tertentu termasuk rating, komentar, dan data reviewer. |
| 8 | Daftar Review Menu | Digunakan oleh semua pengguna untuk melihat daftar review yang telah disetujui untuk menu tertentu. |
| 9 | Daftar Review (Admin) | Digunakan oleh admin untuk melihat daftar semua review yang diajukan oleh pelanggan dan dilengkapi dengan filter status (pending, approved, hidden) serta pencarian berdasarkan nama pelanggan atau nama menu. |
| 10 | Detail Review (Admin) | Digunakan oleh admin untuk melihat informasi detail review tertentu secara lengkap termasuk data reviewer dan menu yang direview. |
| 11 | Statistik Review | Digunakan oleh admin untuk melihat statistik review termasuk total review, rata-rata rating, dan distribusi rating. |
| 12 | Statistik Dashboard (Owner) | Digunakan oleh owner untuk melihat statistik keseluruhan sistem termasuk total pesanan, total pelanggan, total pendapatan, menu terlaris, dan metrik bisnis lainnya. |
| 13 | Laporan Harian Penjualan (Owner) | Digunakan oleh owner untuk melihat laporan penjualan harian yang berisi total pesanan, total pendapatan, jumlah pelanggan, dan ringkasan transaksi pada tanggal tertentu. |
| 14 | Laporan Bulanan Penjualan (Owner) | Digunakan oleh owner untuk melihat laporan penjualan bulanan yang berisi ringkasan total pesanan, total pendapatan, jumlah pelanggan, menu terlaris, dan perbandingan performa bulanan. |
| 15 | Laporan Menu Terlaris (Owner) | Digunakan oleh owner untuk melihat laporan menu terlaris berdasarkan jumlah penjualan dan total pendapatan dalam periode tertentu. |
| 16 | Laporan Aktivitas Sistem (Owner) | Digunakan oleh owner untuk melihat laporan aktivitas sistem yang mencatat semua perubahan data yang dilakukan oleh admin. |
| 17 | Download Laporan PDF (Owner) | Digunakan oleh owner untuk melakukan download semua jenis laporan (harian, bulanan, menu terlaris, aktivitas) dalam format PDF untuk keperluan arsip digital dan pencetakan. |

## 3.1.2 Antarmuka Perangkat Keras

Sistem informasi pemesanan makanan berbasis website dibangun untuk dapat diakses secara fleksibel melalui perangkat seluler maupun desktop. Pengguna dapat menggunakan smartphone, tablet, atau komputer dekstop yang dapat terhubung ke internet untuk mengakses sistem melalui browser modern. Sistem ini dirancang dengan pendekatan responsive design yang memungkinkan tampilan yang optimal pada berbagai ukuran layar perangkat.

Untuk pengguna umum, mereka cukup menggunakan perangkat yang memiliki browser modern dan koneksi internet. Sementara untuk admin dan owner, mereka dapat menggunakan smartphone maupun dekstop dalam mengakses sistem melalui browser modern yang terhubung dengan internet untuk mengelola menu, pesanan, transaksi pembayaran, review, statistik, dan melihat serta mendownload laporan.

## 3.1.3 Antarmuka Perangkat Lunak

Pada pembangunan sistem informasi pemesanan makanan berbasis website, Rumah Makan Cita Rasa, terdapat beberapa perangkat lunak yang dibutuhkan untuk mengoperasikannya pada sisi server adalah sebagai berikut:

| No | Nama | Sumber | Deskripsi |
|---|---|---|---|
| 1 | Laravel Framework 12 | Laravel.com (open-source) | Framework PHP berbasis Model-View-Controller (MVC) yang digunakan untuk membangun aplikasi web dengan fitur lengkap seperti routing, middleware, authentication, dan ORM. |
| 2 | PHP 8.2+ | PHP.net (open-source) | Bahasa pemrograman server-side yang digunakan sebagai runtime environment untuk menjalankan aplikasi Laravel. |
| 3 | MySQL | Oracle Corporation (open-source) | Database Management System relasional yang digunakan untuk menyimpan dan mengelola data aplikasi seperti user, menu, pesanan, dan pembayaran. |
| 4 | Laravel Breeze | Laravel.com (open-source) | Paket authentication scaffolding yang menyediakan fitur registrasi, login, email verification, dan password reset dengan antarmuka yang sudah terstruktur. |
| 5 | Laravel Mail | Laravel.com (open-source) | Komponen yang menyediakan fitur untuk melakukan pengiriman email dengan menggunakan SMTP server untuk keperluan verifikasi email dan reset password. |
| 6 | Laravel DomPDF | Barryvdh.nl (open-source) | Paket yang menyediakan fitur untuk melakukan pembuatan dan unduh file dengan format PDF dari view HTML dalam aplikasi Laravel. |
| 7 | Midtrans PHP SDK 2.6 | Midtrans.com (open-source) | Library yang menyediakan integrasi dengan Midtrans payment gateway untuk memproses pembayaran menggunakan berbagai metode pembayaran. |
| 8 | Laravel Tinker | Laravel.com (open-source) | Tool command-line REPL (Read-Eval-Print Loop) yang memungkinkan interaksi langsung dengan aplikasi Laravel melalui command line. |
| 9 | Faker PHP | Faker PHP (open-source) | Library yang menyediakan fitur untuk generate data dummy yang dapat digunakan dalam pengembangan dan testing aplikasi. |
| 10 | Laravel Pint | Laravel.com (open-source) | Code style fixer yang mempermudah pengembangan dengan menjaga konsistensi kode sesuai dengan standar PSR-12. |

Sedangkan perangkat lunak yang dibutuhkan untuk mengoperasikan perangkat lunak Rumah Makan Cita Rasa di sisi klien adalah sebagai berikut :

| No | Nama | Sumber | Deskripsi |
|---|---|---|---|
| 1 | HTML5 | W3C (standard) | Markup language untuk membangun struktur halaman web dengan semantik yang baik dan mendukung multimedia. |
| 2 | CSS3 | W3C (standard) | Stylesheet language untuk mengatur tampilan dan layout halaman web dengan fitur seperti grid, flexbox, dan animations. |
| 3 | JavaScript ES6+ | ECMA International (standard) | Bahasa pemrograman client-side yang digunakan untuk membuat interaktivitas pada halaman web. |
| 4 | Tailwind CSS 3.1 | Tailwind Labs (open-source) | Framework CSS utility-first yang menyediakan kelas-kelas utilitas untuk mempermudah proses styling komponen UI dengan pendekatan yang efisien. |
| 5 | Alpine.js 3.4 | Alpine.js (open-source) | Framework JavaScript yang ringan untuk membuat interaktivitas pada halaman dengan pendekatan deklaratif dan reaktif. |
| 6 | Axios 1.11 | axios-http.com (open-source) | Library JavaScript yang menyediakan fitur untuk memudahkan aplikasi web dalam melakukan komunikasi dengan REST API melalui HTTP client berbasis promise. |
| 7 | Vite 7 | Vitejs.dev (open-source) | Build tool modern dan cepat yang digunakan untuk development dan production build dengan hot module replacement untuk pengalaman development yang lebih baik. |
| 8 | PostCSS 8 | PostCSS (open-source) | Tool untuk mengubah CSS dengan plugin JavaScript yang digunakan untuk autoprefixing dan optimasi CSS. |

## 3.1.4 Antarmuka Komunikasi

Pada pembangunan sistem informasi pemesanan makanan berbasis website, Rumah Makan Cita Rasa, terdapat beberapa kebutuhan terkait mekanisme komunikasi antar perangkat lunak, antara lain:

1. **Protokol Komunikasi**: Menggunakan protokol komunikasi berupa HTTP dan HTTPS melalui REST API endpoints untuk komunikasi antara frontend dan backend serta untuk integrasi dengan Midtrans payment gateway.

2. **Format Data**: Menggunakan format data berupa JavaScript Object Notation (JSON) dalam komunikasi serta pertukaran data antara frontend dan juga backend untuk request dan response API.

3. **Pengiriman File**: Pada pengiriman file berupa gambar menu dan foto profil, sistem menggunakan format berupa multipart/form-data dalam mengirimkannya ke backend melalui HTTP POST request.

4. **Authentication dan Authorization**: Session-based authentication menggunakan Laravel session dan middleware digunakan sebagai bagian dari proses authentication dan authorization pada setiap request yang dilakukan. Token CSRF digunakan untuk melindungi form dari Cross-Site Request Forgery attacks.

5. **Email Protocol**: SMTP (Simple Mail Transfer Protocol) digunakan untuk pengiriman email notifikasi seperti verifikasi email dan reset password ke alamat email pelanggan.

6. **Integrasi Payment Gateway**: Webhook notification dari Midtrans digunakan untuk mendapatkan update status pembayaran secara real-time. Sistem akan menerima callback notification dari Midtrans melalui HTTPS POST request dengan format JSON.

## 3.1.5 Antarmuka Sistem

Sistem Rumah Makan Cita Rasa juga memiliki hubungan erat dengan beberapa perangkat lunak eksternal dalam pengoperasiannya, antara lain:

1. **Database Management System**: Dengan menggunakan MySQL sebagai basis data utama, sistem akan berinteraksi dengan MySQL dalam melakukan pengambilan dan penyimpanan data yang digunakan di dalam sistem seperti data pengguna, menu, pesanan, pembayaran, dan review.

2. **PDF Generation Service**: Dengan bantuan dari library Laravel DomPDF, sistem dapat dengan mudah dalam proses pembuatan file dengan format PDF (seperti invoice dan laporan penjualan) pada server yang dapat diunduh oleh pelanggan dan owner melalui browser.

3. **Email Notification Service**: Sistem berintegrasi dengan layanan email berbasis SMTP server dalam mengirimkan link validasi berupa token unik yang dibutuhkan ketika proses verifikasi email dan reset password dilakukan oleh pengguna terdaftar.

4. **Payment Gateway Service**: Sistem berintegrasi dengan Midtrans sebagai payment gateway untuk memproses pembayaran online dengan berbagai metode pembayaran seperti kartu kredit, transfer virtual account, e-wallet (GoPay, ShopeePay), QRIS, dan convenience store (Indomaret, Alfamart). Sistem akan mengirim request pembayaran ke Midtrans API dan menerima webhook notification untuk update status pembayaran.

5. **File Storage System**: Sistem menggunakan file storage local untuk menyimpan file gambar menu dan foto profil yang diunggah oleh pengguna. File disimpan dalam direktori storage yang diakses melalui symbolic link ke direktori public.

6. **Web Server**: Sistem memerlukan web server seperti Apache atau Nginx untuk menjalankan aplikasi PHP dan melayani request HTTP/HTTPS dari client browser. Web server juga menangani routing dan static file serving.

---

**Catatan**: Dokumen ini merupakan bagian dari Spesifikasi Kebutuhan Perangkat Lunak (SKPL) untuk Sistem Informasi Pemesanan Makanan Berbasis Website – Rumah Makan Cita Rasa yang mencakup kebutuhan rinci antarmuka eksternal sistem.

