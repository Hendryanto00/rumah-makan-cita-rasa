# 3.2 Kebutuhan Fungsional

Pada bagian kebutuhan fungsional ini, sistem Rumah Makan Cita Rasa dijabarkan menjadi 50 kebutuhan utama sesuai dengan fitur pada Fungsi Produk. Setiap kebutuhan diberi ID unik, judul, dan deskripsi yang padat serta jelas. Aktor dijelaskan sesuai fiturnya.

### 3.2.1. Sign In
ID Requirement: FR-CITARASA-ORDER-101
Deskripsi: Seluruh pengguna (user, admin, owner) dapat masuk ke sistem menggunakan email dan password terdaftar.

### 3.2.2. Sign Up
ID Requirement: FR-CITARASA-ORDER-102
Deskripsi: Calon pelanggan dapat membuat akun baru dengan memasukkan nama, email, telepon, alamat, dan password.

### 3.2.3. Verifikasi Email
ID Requirement: FR-CITARASA-ORDER-103
Deskripsi: Sistem mengirim link verifikasi ke email user baru, user harus verifikasi sebelum akses penuh.

### 3.2.4. Lupa Kata Sandi
ID Requirement: FR-CITARASA-ORDER-104
Deskripsi: User dapat meminta tautan reset password yang dikirimkan ke email terdaftar.

### 3.2.5. Reset Kata Sandi
ID Requirement: FR-CITARASA-ORDER-105
Deskripsi: Fitur mengganti password melalui tautan khusus pada email verifikasi reset.

### 3.2.6. Log Out
ID Requirement: FR-CITARASA-ORDER-106
Deskripsi: Pengguna, admin, owner dapat keluar dari sistem secara aman dan sesi diakhiri.

### 3.2.7. Lihat Daftar Menu
ID Requirement: FR-CITARASA-ORDER-107
Deskripsi: Semua pengguna dapat melihat semua menu dengan fitur pencarian, filter kategori, dan rating pada halaman utama.

### 3.2.8. Lihat Detail Menu
ID Requirement: FR-CITARASA-ORDER-108
Deskripsi: Pengguna dapat melihat detail lengkap menu: deskripsi, harga, stok, rating, dan review.

### 3.2.9. Tambah Item ke Keranjang
ID Requirement: FR-CITARASA-ORDER-109
Deskripsi: User dapat menambahkan menu berikut jumlah dan catatan ke keranjang belanja.

### 3.2.10. Lihat Keranjang
ID Requirement: FR-CITARASA-ORDER-110
Deskripsi: User dapat melihat daftar item dalam keranjang, termasuk jumlah total dan total harga.

### 3.2.11. Update Item Keranjang
ID Requirement: FR-CITARASA-ORDER-111
Deskripsi: User dapat mengubah jumlah/catatan item di keranjang sebelum membuat pesanan.

### 3.2.12. Hapus Item dari Keranjang
ID Requirement: FR-CITARASA-ORDER-112
Deskripsi: User dapat menghapus item tertentu dari keranjang belanja.

### 3.2.13. Buat Pesanan
ID Requirement: FR-CITARASA-ORDER-113
Deskripsi: User dapat membuat pesanan dari semua item di keranjang.

### 3.2.14. Lihat Daftar Pesanan
ID Requirement: FR-CITARASA-ORDER-114
Deskripsi: User dapat melihat riwayat pesanan beserta status, tanggal, dan pencarian.

### 3.2.15. Lihat Detail Pesanan
ID Requirement: FR-CITARASA-ORDER-115
Deskripsi: User dapat melihat detail tiap pesanan: item, harga, status, metode pembayaran.

### 3.2.16. Pembayaran Online
ID Requirement: FR-CITARASA-ORDER-116
Deskripsi: User melakukan pembayaran digital terintegrasi Midtrans; sistem menerima update otomatis status pembayaran.

### 3.2.17. Download Invoice PDF
ID Requirement: FR-CITARASA-ORDER-117
Deskripsi: User dapat mengunduh invoice pesanan dalam format PDF dari sistem.

### 3.2.18. Tambah Review
ID Requirement: FR-CITARASA-ORDER-118
Deskripsi: Pelanggan dapat memberikan review + rating pada menu yang dipesan.

### 3.2.19. Lihat Review Menu
ID Requirement: FR-CITARASA-ORDER-119
Deskripsi: Semua pengguna dapat membaca seluruh review pada menu tertentu.

### 3.2.20. Update Review
ID Requirement: FR-CITARASA-ORDER-120
Deskripsi: Pelanggan bisa memperbarui isi review sudah ditulis sebelumnya.

### 3.2.21. Hapus Review 
ID Requirement: FR-CITARASA-ORDER-121
Deskripsi: Pelanggan bisa menghapus review yang sudah dibuatnya.

### 3.2.22. Update Profil
ID Requirement: FR-CITARASA-ORDER-122
Deskripsi: User bisa memperbarui nama, email, alamat, dan telepon di halaman profil.

### 3.2.23. Ubah Password Profil
ID Requirement: FR-CITARASA-ORDER-123
Deskripsi: User mengganti password dari halaman profil (setelah login).

### 3.2.24. Hapus Akun
ID Requirement: FR-CITARASA-ORDER-124
Deskripsi: User dapat menghapus akunnya permanen (termasuk semua data kecuali data wajib transaksi).

### 3.2.25. Tambah Menu (Admin)
ID Requirement: FR-CITARASA-ORDER-125
Deskripsi: Admin dapat menambah menu makanan/minuman baru disertai foto dan detail info.

### 3.2.26. Lihat Daftar Menu (Admin)
ID Requirement: FR-CITARASA-ORDER-126
Deskripsi: Admin dapat melihat seluruh menu, searching/filtering, dan akses detail untuk edit/hapus.

### 3.2.27. Edit Menu (Admin)
ID Requirement: FR-CITARASA-ORDER-127
Deskripsi: Admin dapat memperbarui info menu: harga, nama, stok, deskripsi, dsb.

### 3.2.28. Hapus Menu (Admin)
ID Requirement: FR-CITARASA-ORDER-128
Deskripsi: Admin dapat menghapus menu yang sudah tidak tersedia dari sistem.

### 3.2.29. Lihat Daftar Pesanan (Admin)
ID Requirement: FR-CITARASA-ORDER-129
Deskripsi: Admin dapat memantau semua pesanan pelanggan yang masuk ke sistem.

### 3.2.30. Lihat Detail Pesanan (Admin)
ID Requirement: FR-CITARASA-ORDER-130
Deskripsi: Admin dapat membaca detail lengkap pesanan (user, item, harga, status, dsb).

### 3.2.31. Tambah Kategori (Admin)
ID Requirement: FR-CITARASA-ORDER-131
Deskripsi: Admin dapat menambah kategori baru untuk pengelompokan menu.

### 3.2.32. Lihat Daftar Kategori (Admin)
ID Requirement: FR-CITARASA-ORDER-132
Deskripsi: Admin dapat membaca seluruh kategori, searching atau filter kategori.

### 3.2.33. Edit Kategori (Admin)
ID Requirement: FR-CITARASA-ORDER-133
Deskripsi: Admin memperbarui nama/deskripsi kategori yang sudah ada.

### 3.2.34. Hapus Kategori (Admin)
ID Requirement: FR-CITARASA-ORDER-134
Deskripsi: Admin menghapus kategori tak terpakai (menu terkait harus dipindah atau hapus dulu).

### 3.2.35. Lihat Daftar Review (Admin)
ID Requirement: FR-CITARASA-ORDER-135
Deskripsi: Admin melihat semua review baru, dengan filter status dan pencarian.

### 3.2.36. Lihat Detail Review (Admin)
ID Requirement: FR-CITARASA-ORDER-136
Deskripsi: Admin dapat membaca detail ulasan pelanggan (rating, komentar, reviewer).

### 3.2.37. Approve Review (Admin)
ID Requirement: FR-CITARASA-ORDER-137
Deskripsi: Admin menyetujui review/customer review agar tampil di publik.

### 3.2.38. Hide Review (Admin)
ID Requirement: FR-CITARASA-ORDER-138
Deskripsi: Admin menyembunyikan review tertentu dari tampil publik (tetap tersimpan).

### 3.2.39. Reject/Hapus Review (Admin)
ID Requirement: FR-CITARASA-ORDER-139
Deskripsi: Admin menolak/menghapus review tidak pantas, tidak akan tampil lagi di sistem.

### 3.2.40. Statistik Review (Admin)
ID Requirement: FR-CITARASA-ORDER-140
Deskripsi: Admin melihat statistik total rating, jumlah review, distribusi bintang dan tren penilaian dari seluruh review menu.

### 3.2.41. Statistik Dashboard (Owner)
ID Requirement: FR-CITARASA-ORDER-141
Deskripsi: Owner dapat memantau performa bisnis secara menyeluruh lewat dashboard statistik.

### 3.2.42. Laporan Harian Penjualan (Owner)
ID Requirement: FR-CITARASA-ORDER-142
Deskripsi: Owner melihat laporan penjualan secara harian (jumlah penjualan, omzet, pelanggan, menu populer).

### 3.2.43. Laporan Bulanan Penjualan (Owner)
ID Requirement: FR-CITARASA-ORDER-143
Deskripsi: Owner melihat laporan penjualan bulanan (total penjualan, menu laris, ringkasan transaksi).

### 3.2.44. Laporan Menu Terlaris (Owner)
ID Requirement: FR-CITARASA-ORDER-144
Deskripsi: Owner melihat laporan khusus menu terbanyak terjual dan kontributor omzet terbesar dalam periode tertentu.

### 3.2.45. Laporan Aktivitas Sistem (Owner)
ID Requirement: FR-CITARASA-ORDER-145
Deskripsi: Owner dapat membaca log seluruh aktivitas penting di sistem (update data, tambah, hapus) sepanjang waktu tertentu.

### 3.2.46. Download Laporan Harian Penjualan PDF (Owner)
ID Requirement: FR-CITARASA-ORDER-146
Deskripsi: Owner dapat mengunduh hasil laporan penjualan harian dalam format PDF.

### 3.2.47. Download Laporan Bulanan Penjualan PDF (Owner)
ID Requirement: FR-CITARASA-ORDER-147
Deskripsi: Owner dapat mengunduh laporan bulanan penjualan ke format PDF.

### 3.2.48. Download Laporan Menu Terlaris PDF (Owner)
ID Requirement: FR-CITARASA-ORDER-148
Deskripsi: Owner mengunduh dokumen PDF berisi laporan menu terlaris berdasarkan data penjualan.

### 3.2.49. Download Laporan Aktivitas Sistem PDF (Owner)
ID Requirement: FR-CITARASA-ORDER-149
Deskripsi: Owner dapat mendownload/cetak log aktivitas sistem ke PDF untuk keperluan audit atau arsip digital.


