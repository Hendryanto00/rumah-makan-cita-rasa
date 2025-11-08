# A. Lampiran

Subbagian lampiran menyediakan informasi tambahan yang dirujuk oleh kebutuhan dalam dokumen SKPL. Informasi pada lampiran ini digunakan untuk memperjelas struktur data (ERD) dan aturan penghitungan transaksi pada sistem Rumah Makan Cita Rasa.

Sistem secara eksplisit merujuk informasi pada lampiran ini sebagai bagian dari kebutuhan yang ada: struktur entitas pada Lampiran A.1 menjadi acuan perancangan database dan validasi data, sedangkan aturan penghitungan pada Lampiran A.2 menjadi acuan perhitungan subtotal/total pada modul pesanan, pembayaran, dan laporan.

## A.1 Lampiran 1 – Entity Relationship Diagram (ERD)

Lampiran ini berisi tujuan dari setiap entitas pada Entity Relationship Diagram (ERD) yang dirancang untuk menggambarkan struktur data sistem. Berikut daftar entitas sesuai database proyek beserta perannya:

1. users: Struktur dan penyimpanan data akun pengguna (pelanggan, admin, owner) termasuk kredensial, profil dasar, dan verifikasi email.
2. roles: Struktur dan penyimpanan tipe hak akses (role) yang digunakan sistem untuk pembatasan fitur.
3. password_resets: Penyimpanan token reset password yang dikirim via email untuk proses lupa kata sandi.
4. activity_logs: Catatan audit aktivitas penting (login, CRUD, perubahan status pesanan/pembayaran) untuk keperluan audit.
5. categories: Pengelompokan menu (makanan/minuman) agar memudahkan filter dan navigasi pengguna.
6. menus: Penyimpanan data menu: nama, deskripsi, harga, gambar, kategori, status, dan stok.
7. carts: Keranjang aktif milik pengguna untuk menampung rencana pesanan sebelum checkout.
8. cart_items: Item dalam keranjang; menyimpan referensi menu, kuantitas, subtotal per item, dan catatan opsional.
9. orders: Data pesanan pengguna yang terbentuk dari keranjang, termasuk tanggal, status, dan total amount.
10. order_details: Rincian item per pesanan (menu, kuantitas, harga, subtotal, catatan) sebagai histori transaksi final.
11. payments: Data pembayaran terkait pesanan (metode, provider, snap_token, status, nominal, referensi transaksi).
12. reviews: Ulasan dan rating pelanggan untuk menu yang sudah dibeli, dengan siklus moderasi admin.
13. reports: Ringkasan laporan penjualan/aktivitas dengan periode tertentu untuk kebutuhan analitik dan rekap.

Catatan: Relasi kunci utama/asing diatur pada migrasi, antara lain `users`→`orders`, `orders`→`order_details`/`payments`, `menus`→`order_details`/`cart_items`, `categories`→`menus`, serta referensi ke `users` pada `reviews` dan pencatatan `activity_logs`.

## A.2 Lampiran 2 – Aturan Penghitungan Transaksi

Lampiran ini mendefinisikan aturan penghitungan yang digunakan oleh modul keranjang, pesanan, pembayaran, dan laporan. Aturan ini dirujuk oleh kebutuhan fungsional terkait checkout, pembayaran, dan pembuatan laporan.

Terminologi:
- harga: harga satuan dari suatu menu (field `price` pada `order_details`).
- kuantitas: jumlah unit yang dipesan untuk menu tersebut (field `quantity`).
- subtotal_item: hasil dari harga × kuantitas untuk suatu item (field `subtotal`).
- subtotal_pesanan: penjumlahan seluruh `subtotal_item` dalam satu pesanan.
- total_pesanan: nilai akhir yang harus dibayar pengguna dan disimpan pada `orders.total_amount`.

Aturan Penghitungan:
1. subtotal_item = harga × kuantitas.
2. subtotal_pesanan = Σ subtotal_item untuk semua item pada pesanan yang sama.
3. total_pesanan = subtotal_pesanan.
4. Nilai disimpan dengan presisi dua desimal sesuai tipe decimal(12,2) pada database.

Konsistensi Data:
- Nilai kuantitas minimal 1; harga tidak bernilai negatif.
- Paginasi dan indeks basis data wajib diterapkan pada daftar item (keranjang, pesanan, review) untuk performa.
- Perubahan harga menu setelah pesanan dibuat tidak mengubah nilai pada `order_details`; sistem menyimpan salinan harga saat transaksi untuk audit.

Status Pembayaran dan Pesanan:
- Status pembayaran pada `payments.payment_status`: pending, sukses, gagal.
- Status pesanan pada `orders.status`: pending, diproses, selesai, batal.
- Perubahan status mengacu pada notifikasi penyedia pembayaran (untuk transaksi online) atau input admin (untuk transaksi offline/penyesuaian).

Ketergantungan Pihak Ketiga:
- Integrasi Midtrans digunakan untuk pembayaran online. Field seperti `snap_token`, `transaction_id`, dan `status` pada `payments` mengikuti respons penyedia.

Pelaporan:
- Tabel `reports` menyimpan ringkasan metrik (periode, total_orders, total_revenue, dsb.) yang berasal dari agregasi `orders`, `order_details`, dan `payments` sesuai rentang waktu yang dipilih.


