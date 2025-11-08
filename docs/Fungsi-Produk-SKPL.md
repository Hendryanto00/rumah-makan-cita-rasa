# Spesifikasi Kebutuhan Perangkat Lunak (SKPL)
## Sistem Informasi Pemesanan Makanan Berbasis Website – Rumah Makan Cita Rasa

---

# 2.2 Fungsi Produk

## Fungsi 01 – Sign In
**Deskripsi** : Sistem menyediakan fitur bagi pengguna terdaftar (pelanggan, admin, dan owner) untuk masuk ke dalam sistem menggunakan alamat email dan kata sandi yang telah terdaftar.

**Rasional** : Fitur ini memastikan bahwa hanya pengguna yang sah dan memiliki peran tertentu yang dapat mengakses sistem sesuai dengan hak aksesnya masing-masing.

---

## Fungsi 02 – Sign Up
**Deskripsi** : Sistem menyediakan fitur bagi calon pelanggan untuk membuat akun baru dengan mengisi data seperti nama, email, telepon, alamat, dan kata sandi.

**Rasional** : Fitur ini memungkinkan calon pelanggan untuk mendaftar secara mandiri agar dapat menggunakan seluruh layanan yang tersedia pada sistem Rumah Makan Cita Rasa.

---

## Fungsi 03 – Verifikasi Email
**Deskripsi** : Sistem menyediakan fitur bagi pengguna yang baru mendaftar untuk melakukan verifikasi alamat email melalui tautan (link) yang dikirimkan secara otomatis ke email terdaftar. Pengguna hanya dapat mengakses fitur sistem setelah proses verifikasi berhasil dilakukan.

**Rasional** : Fitur ini bertujuan untuk memastikan bahwa akun yang dibuat benar-benar dimiliki oleh pengguna yang sah, mencegah pendaftaran menggunakan alamat email palsu, serta meningkatkan keamanan dan validitas data pengguna dalam sistem Rumah Makan Cita Rasa.

---

## Fungsi 04 – Lupa Kata Sandi
**Deskripsi** : Sistem menyediakan fitur bagi pengguna terdaftar untuk melakukan pemulihan akses akun apabila lupa kata sandi. Sistem akan mengirimkan tautan (link) pemulihan ke alamat email yang telah terdaftar, yang berisi token unik untuk proses penggantian kata sandi.

**Rasional** : Fitur ini bertujuan untuk memastikan bahwa hanya pemilik akun yang sah yang dapat melakukan proses pemulihan kata sandi. Dengan demikian, keamanan dan kerahasiaan akun pengguna pada sistem Rumah Makan Cita Rasa dapat tetap terjaga.

---

## Fungsi 05 – Reset Kata Sandi
**Deskripsi** : Sistem menyediakan fitur bagi pengguna yang telah tervalidasi melalui email untuk melakukan pengaturan ulang pada kata sandi akun yang dimiliki dengan memasukkan kata sandi baru sesuai dengan aturan yang berlaku.

**Rasional** : Fitur ini memungkinkan pengguna yang telah melalui proses lupa kata sandi untuk membuat kata sandi baru yang aman dan dapat digunakan untuk akses ke dalam sistem Rumah Makan Cita Rasa.

---

## Fungsi 06 – Log Out
**Deskripsi** : Sistem menyediakan fitur bagi pengguna terdaftar untuk keluar dari sistem secara aman dengan menghancurkan session yang aktif dan menghapus data autentikasi.

**Rasional** : Fitur ini bertujuan untuk memastikan keamanan data pengguna dengan mencegah akses tidak sah ke akun yang sedang login, khususnya ketika menggunakan perangkat yang dibagikan dengan pengguna lain.

---

## Fungsi 07 – Lihat Daftar Menu
**Deskripsi** : Sistem menyediakan fitur bagi semua pengguna untuk melihat daftar menu makanan yang tersedia dengan informasi dasar seperti nama, harga, kategori, dan rating. Pengguna dapat melakukan filter berdasarkan kategori dan pencarian berdasarkan nama menu.

**Rasional** : Fitur ini memudahkan pelanggan untuk menjelajahi dan menemukan menu makanan yang diinginkan dengan cara yang efisien dan terorganisir.

---

## Fungsi 08 – Lihat Detail Menu
**Deskripsi** : Sistem menyediakan fitur bagi semua pengguna untuk melihat informasi lengkap mengenai menu makanan tertentu termasuk deskripsi detail, harga, stok, kategori, rating rata-rata, dan daftar review dari pelanggan lain.

**Rasional** : Fitur ini memberikan informasi komprehensif yang diperlukan pelanggan untuk membuat keputusan pembelian yang tepat berdasarkan informasi lengkap mengenai menu tersebut.

---

## Fungsi 09 – Tambah Item ke Keranjang
**Deskripsi** : Sistem menyediakan fitur bagi pelanggan untuk menambahkan menu makanan ke dalam keranjang belanja dengan menentukan jumlah item yang ingin dibeli dan catatan khusus (opsional) untuk setiap item.

**Rasional** : Fitur ini memungkinkan pelanggan untuk mengumpulkan beberapa item sebelum melakukan checkout, meningkatkan pengalaman belanja dan efisiensi proses pemesanan.

---

## Fungsi 10 – Lihat Keranjang
**Deskripsi** : Sistem menyediakan fitur bagi pelanggan untuk melihat semua item yang telah ditambahkan ke dalam keranjang belanja beserta total harga yang harus dibayar.

**Rasional** : Fitur ini memungkinkan pelanggan untuk melakukan review terhadap item yang ingin dipesan sebelum melanjutkan ke proses checkout.

---

## Fungsi 11 – Update Item Keranjang
**Deskripsi** : Sistem menyediakan fitur bagi pelanggan untuk melakukan perubahan pada jumlah item dan catatan khusus pada item yang telah ditambahkan ke keranjang.

**Rasional** : Fitur ini memberikan fleksibilitas kepada pelanggan untuk mengubah pesanan sebelum melakukan checkout tanpa harus menghapus dan menambah ulang item.

---

## Fungsi 12 – Hapus Item dari Keranjang
**Deskripsi** : Sistem menyediakan fitur bagi pelanggan untuk melakukan penghapusan item tertentu dari keranjang belanja.

**Rasional** : Fitur ini memungkinkan pelanggan untuk menghapus item yang tidak diinginkan lagi tanpa harus menghapus seluruh isi keranjang.

---

## Fungsi 13 – Hapus Semua Item Keranjang (DIHAPUS KARNA NGGA DI PAKAI KARNA DUPLIKASI)
**Deskripsi** : Sistem menyediakan fitur bagi pelanggan untuk melakukan penghapusan semua item dari keranjang belanja sekaligus.

**Rasional** : Fitur ini memberikan kemudahan kepada pelanggan untuk mengosongkan keranjang secara cepat ketika ingin memulai pesanan baru.

---

## Fungsi 14 – Buat Pesanan
**Deskripsi** : Sistem menyediakan fitur bagi pelanggan untuk membuat pesanan baru dari semua item yang ada di dalam keranjang belanja. Sistem akan memproses pesanan dan menyiapkan proses pembayaran.

**Rasional** : Fitur ini memungkinkan pelanggan untuk menyelesaikan proses pemesanan dan melanjutkan ke tahap pembayaran dengan data pesanan yang sudah terverifikasi.

---

## Fungsi 15 – Lihat Daftar Pesanan
**Deskripsi** : Sistem menyediakan fitur bagi pelanggan untuk melihat daftar semua pesanan yang telah dibuat dengan informasi status, tanggal, dan total harga. Pelanggan dapat melakukan filter berdasarkan status pesanan.

**Rasional** : Fitur ini memungkinkan pelanggan untuk melacak riwayat pemesanan dan status masing-masing pesanan yang pernah dibuat.

---

## Fungsi 16 – Lihat Detail Pesanan
**Deskripsi** : Sistem menyediakan fitur bagi pelanggan untuk melihat informasi detail pesanan tertentu termasuk item yang dipesan, total harga, status pembayaran, metode pembayaran, dan informasi lainnya.

**Rasional** : Fitur ini memberikan informasi lengkap kepada pelanggan mengenai pesanan yang telah dibuat untuk keperluan verifikasi dan tracking.

---

## Fungsi 17 – Pembayaran Online
**Deskripsi** : Sistem menyediakan fitur bagi pelanggan untuk melakukan pembayaran pesanan menggunakan berbagai metode pembayaran yang tersedia melalui integrasi Midtrans payment gateway, seperti kartu kredit, transfer virtual account, e-wallet (GoPay, ShopeePay), QRIS, dan convenience store (Indomaret, Alfamart).

**Rasional** : Fitur ini memungkinkan pelanggan untuk melakukan pembayaran dengan metode yang paling nyaman bagi mereka, meningkatkan kepuasan pelanggan dan tingkat konversi pembayaran.

---

## Fungsi 18 – Download Invoice PDF
**Deskripsi** : Sistem menyediakan fitur bagi pelanggan untuk melakukan download invoice pesanan dalam format PDF yang berisi detail lengkap pesanan, pembayaran, dan informasi pelanggan untuk keperluan arsip digital dan pencetakan.

**Rasional** : Fitur ini memenuhi kebutuhan pelanggan untuk memiliki dokumentasi resmi atas transaksi yang telah dilakukan, yang dapat digunakan untuk keperluan akuntansi pribadi atau klaim garansi.

---

## Fungsi 19 – Tambah Review
**Deskripsi** : Sistem menyediakan fitur bagi pelanggan untuk menambahkan review dan rating pada menu yang telah dipesan dengan mengisi rating (1-5 bintang) dan komentar (opsional). Review akan masuk ke status pending sebelum disetujui oleh admin.

**Rasional** : Fitur ini memungkinkan pelanggan untuk berbagi pengalaman dan feedback mengenai menu, membantu pelanggan lain dalam membuat keputusan pembelian, dan membantu rumah makan untuk meningkatkan kualitas layanan.

---

## Fungsi 20 – Lihat Review Menu
**Deskripsi** : Sistem menyediakan fitur bagi semua pengguna untuk melihat daftar review yang telah disetujui untuk menu tertentu beserta rating dan komentar dari pelanggan lain.

**Rasional** : Fitur ini memberikan informasi sosial proof yang membantu pelanggan dalam membuat keputusan pembelian berdasarkan pengalaman pelanggan lain.

---

## Fungsi 21 – Update Review
**Deskripsi** : Sistem menyediakan fitur bagi pelanggan untuk melakukan perubahan pada review yang telah dibuat untuk menu tertentu, termasuk mengubah rating dan komentar.

**Rasional** : Fitur ini memberikan fleksibilitas kepada pelanggan untuk memperbarui review mereka jika mengalami perubahan pengalaman atau jika ingin memberikan informasi tambahan.

---

## Fungsi 22 – Hapus Review
**Deskripsi** : Sistem menyediakan fitur bagi pelanggan untuk melakukan penghapusan review yang telah dibuat jika merasa review tersebut tidak lagi relevan.

**Rasional** : Fitur ini memberikan kontrol kepada pelanggan atas review yang telah dibuat dan memberikan keleluasaan untuk menghapus review yang tidak diinginkan lagi.

---

## Fungsi 23 – Perbaharui Profil
**Deskripsi** : Sistem menyediakan fitur bagi pengguna terdaftar untuk melakukan perubahan pada data profil diri dengan mengisi data berupa nama, email, nomor telepon, dan alamat.

**Rasional** : Fitur ini memungkinkan pengguna untuk menjaga data profil tetap up-to-date, memastikan akurasi informasi yang digunakan untuk pemesanan dan komunikasi.

---

## Fungsi 24 – Perbaharui Kata Sandi
**Deskripsi** : Sistem menyediakan fitur bagi pengguna terdaftar untuk melakukan perubahan pada kata sandi akun dengan memasukkan kata sandi lama dan kata sandi baru sesuai dengan aturan keamanan yang berlaku.

**Rasional** : Fitur ini memungkinkan pengguna untuk menjaga keamanan akun dengan secara berkala mengubah kata sandi, mengurangi risiko akses tidak sah.

---

## Fungsi 25 – Hapus Akun
**Deskripsi** : Sistem menyediakan fitur bagi pengguna terdaftar untuk melakukan penghapusan akun secara permanen dari sistem beserta semua data yang terkait, kecuali data transaksi yang wajib disimpan untuk keperluan akuntansi.

**Rasional** : Fitur ini memenuhi hak privasi pengguna untuk menghapus data pribadi mereka dari sistem sesuai dengan peraturan perlindungan data pribadi yang berlaku.

---

## Fungsi 26 – Tambah Menu
**Deskripsi** : Sistem menyediakan fitur bagi admin untuk menambahkan menu makanan baru ke dalam sistem dengan mengisi data berupa nama menu, kategori, harga, stok, deskripsi, dan upload gambar menu.

**Rasional** : Fitur ini memungkinkan admin untuk memperluas pilihan menu yang tersedia bagi pelanggan dan mengelola katalog produk dengan efisien.

---

## Fungsi 27 – Lihat Daftar Menu (Admin)
**Deskripsi** : Sistem menyediakan fitur bagi admin untuk melihat daftar semua menu yang tersedia dalam sistem dengan informasi lengkap dan opsi untuk melakukan edit atau hapus.

**Rasional** : Fitur ini memudahkan admin untuk mengelola dan memantau seluruh katalog menu yang tersedia dalam sistem.

---

## Fungsi 28 – Perbaharui Menu
**Deskripsi** : Sistem menyediakan fitur bagi admin untuk melakukan perubahan pada data menu yang telah ada dengan mengisi data berupa nama menu, kategori, harga, stok, deskripsi, dan gambar. Admin dapat mengubah salah satu atau semua field yang diperlukan.

**Rasional** : Fitur ini memungkinkan admin untuk memperbarui informasi menu seperti perubahan harga, ketersediaan stok, atau perbaikan deskripsi untuk menjaga akurasi informasi produk.

---

## Fungsi 29 – Hapus Menu
**Deskripsi** : Sistem menyediakan fitur bagi admin untuk melakukan penghapusan menu tertentu dari sistem. Menu yang dihapus tidak akan lagi ditampilkan kepada pelanggan.

**Rasional** : Fitur ini memungkinkan admin untuk mengeluarkan menu yang tidak lagi tersedia atau tidak lagi ditawarkan kepada pelanggan.

---

## Fungsi 30 – Lihat Daftar Pesanan (Admin)
**Deskripsi** : Sistem menyediakan fitur bagi admin untuk melihat daftar semua pesanan dari seluruh pelanggan dengan informasi status, tanggal, pelanggan, total harga, dan metode pembayaran. Admin dapat melakukan filter berdasarkan status pesanan dan pencarian berdasarkan nama pelanggan.

**Rasional** : Fitur ini memungkinkan admin untuk memantau dan mengelola semua pesanan yang masuk ke dalam sistem secara efisien.

---

## Fungsi 31 – Lihat Detail Pesanan (Admin)
**Deskripsi** : Sistem menyediakan fitur bagi admin untuk melihat informasi detail pesanan tertentu secara lengkap termasuk item yang dipesan, jumlah, harga, total, data pelanggan, status pembayaran, metode pembayaran, dan informasi lainnya.

**Rasional** : Fitur ini memberikan informasi komprehensif kepada admin untuk mengelola pesanan secara detail dan mengambil keputusan yang tepat.

---

## Fungsi 32 – Tambah Kategori
**Deskripsi** : Sistem menyediakan fitur bagi admin untuk menambahkan kategori menu baru ke dalam sistem dengan mengisi data berupa nama kategori dan deskripsi kategori.

**Rasional** : Fitur ini memungkinkan admin untuk mengorganisir menu berdasarkan kategori tertentu, memudahkan pelanggan dalam mencari menu yang diinginkan.

---

## Fungsi 33 – Lihat Daftar Kategori (Admin)
**Deskripsi** : Sistem menyediakan fitur bagi admin untuk melihat daftar semua kategori menu yang tersedia dalam sistem dengan informasi lengkap dan opsi untuk melakukan edit atau hapus.

**Rasional** : Fitur ini memudahkan admin untuk mengelola dan memantau seluruh kategori menu yang tersedia dalam sistem.

---

## Fungsi 34 – Perbaharui Kategori
**Deskripsi** : Sistem menyediakan fitur bagi admin untuk melakukan perubahan pada data kategori yang telah ada dengan mengisi data berupa nama kategori dan deskripsi.

**Rasional** : Fitur ini memungkinkan admin untuk memperbarui informasi kategori untuk meningkatkan akurasi dan relevansi pengorganisasian menu.

---

## Fungsi 35 – Hapus Kategori
**Deskripsi** : Sistem menyediakan fitur bagi admin untuk melakukan penghapusan kategori tertentu dari sistem. Menu yang terkait dengan kategori tersebut perlu dipindahkan atau dihapus terlebih dahulu.

**Rasional** : Fitur ini memungkinkan admin untuk menghapus kategori yang tidak lagi relevan atau digunakan dalam sistem.

---

## Fungsi 36 – Lihat Daftar Review (Admin)
**Deskripsi** : Sistem menyediakan fitur bagi admin untuk melihat daftar semua review yang diajukan oleh pelanggan dengan filter berdasarkan status (pending, approved, hidden) dan pencarian berdasarkan nama pelanggan atau nama menu.

**Rasional** : Fitur ini memudahkan admin untuk memoderasi review yang masuk, memastikan kualitas dan relevansi review yang ditampilkan kepada pelanggan.

---

## Fungsi 37 – Lihat Detail Review (Admin)
**Deskripsi** : Sistem menyediakan fitur bagi admin untuk melihat informasi detail review tertentu secara lengkap termasuk data reviewer, menu yang direview, rating, komentar, dan status review.

**Rasional** : Fitur ini memungkinkan admin untuk melakukan evaluasi menyeluruh terhadap review sebelum memutuskan untuk approve, hide, atau reject review tersebut.

---

## Fungsi 38 – Approve Review
**Deskripsi** : Sistem menyediakan fitur bagi admin untuk menyetujui review yang telah diajukan oleh pelanggan agar ditampilkan di halaman menu terkait. Review yang di-approve akan muncul di daftar review menu untuk dilihat oleh pengguna lain.

**Rasional** : Fitur ini memastikan bahwa hanya review yang relevan dan berkualitas yang ditampilkan kepada pelanggan, membantu dalam proses moderasi konten.

---

## Fungsi 39 – Hide Review
**Deskripsi** : Sistem menyediakan fitur bagi admin untuk menyembunyikan review tertentu agar tidak ditampilkan di halaman menu. Review tetap tersimpan di database tetapi tidak ditampilkan kepada pengguna umum.

**Rasional** : Fitur ini memungkinkan admin untuk menyembunyikan review yang bermasalah tanpa harus menghapusnya secara permanen, memberikan fleksibilitas dalam moderasi konten.

---

## Fungsi 40 – Reject Review
**Deskripsi** : Sistem menyediakan fitur bagi admin untuk menolak dan menghapus review tertentu dari sistem secara permanen. Review yang di-reject tidak akan dapat dilihat lagi dan data akan dihapus dari database.

**Rasional** : Fitur ini memungkinkan admin untuk menghapus review yang tidak sesuai dengan kebijakan sistem atau mengandung konten yang tidak pantas.

---

## Fungsi 41 – Statistik Review
**Deskripsi** : Sistem menyediakan fitur bagi admin untuk melihat statistik review termasuk total review, rata-rata rating keseluruhan, distribusi rating, dan tren review dalam periode tertentu.

**Rasional** : Fitur ini memberikan insight kepada admin mengenai sentiment pelanggan dan kualitas produk, membantu dalam pengambilan keputusan bisnis.

---

## Fungsi 42 – Statistik Dashboard (Owner)
**Deskripsi** : Sistem menyediakan fitur bagi owner untuk melihat statistik keseluruhan sistem termasuk total pesanan, total pelanggan, total pendapatan, menu terlaris, dan metrik bisnis lainnya dalam periode tertentu.

**Rasional** : Fitur ini memberikan overview bisnis yang komprehensif kepada owner untuk monitoring performa dan pengambilan keputusan strategis.

---

## Fungsi 43 – Laporan Harian Penjualan (Owner)
**Deskripsi** : Sistem menyediakan fitur bagi owner untuk melihat laporan penjualan harian yang berisi total pesanan, total pendapatan, jumlah pelanggan yang berbelanja, menu yang terjual, dan ringkasan transaksi pada tanggal tertentu.

**Rasional** : Fitur ini membantu owner untuk memantau performa penjualan harian secara detail dan mengidentifikasi pola atau tren penjualan setiap hari.

---

## Fungsi 44 – Laporan Bulanan Penjualan (Owner)
**Deskripsi** : Sistem menyediakan fitur bagi owner untuk melihat laporan penjualan bulanan yang berisi ringkasan total pesanan, total pendapatan, jumlah pelanggan, menu terlaris, dan perbandingan performa bulanan. Owner dapat memilih bulan dan tahun yang ingin dilihat.

**Rasional** : Fitur ini memberikan analisis mendalam mengenai performa bisnis bulanan kepada owner untuk evaluasi dan perencanaan strategi bisnis jangka menengah.

---

## Fungsi 45 – Laporan Menu Terlaris (Owner)
**Deskripsi** : Sistem menyediakan fitur bagi owner untuk melihat laporan menu terlaris berdasarkan jumlah penjualan dan total pendapatan dalam periode tertentu. Laporan menampilkan ranking menu, jumlah terjual, total pendapatan per menu, dan persentase kontribusi terhadap total penjualan.

**Rasional** : Fitur ini membantu owner untuk mengidentifikasi menu yang paling diminati pelanggan, memungkinkan pengambilan keputusan terkait strategi promosi, manajemen stok, dan pengembangan menu baru.

---

## Fungsi 46 – Laporan Aktivitas Sistem (Owner)
**Deskripsi** : Sistem menyediakan fitur bagi owner untuk melihat laporan aktivitas sistem yang mencatat semua perubahan data yang dilakukan oleh admin, seperti penambahan menu, perubahan harga, dan penghapusan data. Laporan dilengkapi dengan filter berdasarkan tanggal, tipe aksi, dan pengguna.

**Rasional** : Fitur ini menyediakan transparansi dan accountability kepada owner untuk memantau semua perubahan yang terjadi dalam sistem, memastikan bahwa operasi berjalan sesuai kebijakan yang telah ditetapkan. Fitur ini juga menyediakan audit trail yang dapat digunakan untuk tracking perubahan data, troubleshooting, dan keamanan sistem.

---

## Fungsi 47 – Download Laporan Harian Penjualan PDF (Owner)
**Deskripsi** : Sistem menyediakan fitur bagi owner untuk melakukan download laporan penjualan harian dalam format PDF yang berisi detail lengkap transaksi pada tanggal tertentu untuk keperluan arsip digital dan pencetakan.

**Rasional** : Fitur ini memenuhi kebutuhan owner untuk memiliki dokumentasi resmi laporan harian dalam format yang dapat diarsipkan dan dicetak untuk keperluan akuntansi dan pelaporan keuangan.

---

## Fungsi 48 – Download Laporan Bulanan Penjualan PDF (Owner)
**Deskripsi** : Sistem menyediakan fitur bagi owner untuk melakukan download laporan penjualan bulanan dalam format PDF yang berisi ringkasan dan analisis performa bisnis bulanan untuk keperluan arsip digital dan pencetakan.

**Rasional** : Fitur ini memenuhi kebutuhan owner untuk memiliki dokumentasi resmi laporan bulanan dalam format yang dapat diarsipkan dan dicetak untuk keperluan akuntansi, pelaporan keuangan, dan evaluasi strategi bisnis.

---

## Fungsi 49 – Download Laporan Menu Terlaris PDF (Owner)
**Deskripsi** : Sistem menyediakan fitur bagi owner untuk melakukan download laporan menu terlaris dalam format PDF yang berisi ranking menu, analisis penjualan, dan rekomendasi untuk keperluan arsip digital dan pencetakan.

**Rasional** : Fitur ini memenuhi kebutuhan owner untuk memiliki dokumentasi resmi analisis produk dalam format yang dapat diarsipkan dan dicetak untuk keperluan pengambilan keputusan strategis terkait menu dan promosi.

---

## Fungsi 50 – Download Laporan Aktivitas Sistem PDF (Owner)
**Deskripsi** : Sistem menyediakan fitur bagi owner untuk melakukan download laporan aktivitas sistem dalam format PDF yang berisi catatan semua perubahan data untuk keperluan arsip digital dan pencetakan.

**Rasional** : Fitur ini memenuhi kebutuhan owner untuk memiliki dokumentasi resmi audit trail dalam format yang dapat diarsipkan dan dicetak untuk keperluan audit internal, compliance, dan keamanan sistem.

---

**Catatan**: Dokumen ini merupakan bagian dari Spesifikasi Kebutuhan Perangkat Lunak (SKPL) untuk Sistem Informasi Pemesanan Makanan Berbasis Website – Rumah Makan Cita Rasa yang mencakup fungsi-fungsi produk yang tersedia dalam sistem.

