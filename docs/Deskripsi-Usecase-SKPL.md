# Deskripsi Use Case – Rumah Makan Cita Rasa

---

Nama Use Case : Sign In

Deskripsi singkat : Proses masuk ke dalam sistem menggunakan email dan password dari akun yang telah terdaftar.
Aktor : Pengguna terdaftar (pelanggan, admin, dan pemilik).
Pre kondisi : Aktor sudah memiliki akun yang terdaftar.
Pos kondisi : Aktor berhasil masuk ke sistem dan dapat menggunakan fitur sesuai hak akses.

Basic Flow :

Aktor membuka halaman sign in.
Aktor memasukkan email dan password.
Aktor melakukan klik pada tombol “Login”.
Sistem melakukan validasi pada data input.
  A1: Email atau password tidak terdaftar.
  A2: Data input tidak sesuai ketentuan.
Sistem mengarahkan aktor ke halaman dashboard dan terdapat fitur–fitur sesuai dengan hak akses.
Use case selesai.

Alternative Flow :

A1: Email atau password tidak terdaftar.
  1. Sistem menampilkan pesan error berupa “Email atau password salah”.
  2. Kembali ke basic flow langkah ke-2.

A2: Data input tidak sesuai ketentuan.
  1. Sistem menampilkan pesan error berupa ketentuan email atau password yang harus dipenuhi.
  2. Kembali ke basic flow langkah ke-2.

Error Flow : -

---

Nama Use Case : Sign Up

Deskripsi singkat : Proses pendaftaran akun baru pelanggan di sistem.
Aktor : Calon pengguna (pelanggan)
Pre kondisi : Pengguna belum memiliki akun.
Pos kondisi : User terdaftar dan dapat login setelah verifikasi email.

Basic Flow :

Aktor membuka halaman sign up.
Aktor mengisi nama, email, nomor telepon, alamat, dan password.
Aktor menekan tombol “Daftar”.
Sistem melakukan validasi data input.
  A1: Data tidak valid atau email sudah terdaftar.
Sistem menyimpan data pengguna baru dalam basis data.
Sistem mengirim email verifikasi ke pengguna.
Use case selesai.

Alternative Flow :

A1: Data tidak valid atau email sudah terdaftar.
  1. Sistem menampilkan pesan error kepada pengguna.
  2. Kembali ke basic flow langkah ke-2.

Error Flow : -

---

Nama Use Case : Verifikasi Email

Deskripsi singkat : Proses verifikasi email pengguna setelah melakukan pendaftaran akun baru.
Aktor : User baru (pelanggan)
Pre kondisi : Pengguna sudah menjalankan proses registrasi dan email terdaftar di sistem.
Pos kondisi : Status akun pengguna menjadi terverifikasi dan dapat mengakses seluruh fitur sistem.

Basic Flow :

Pengguna membuka email yang dikirim oleh sistem.
Pengguna mengklik tautan verifikasi email.
Sistem memvalidasi tautan verifikasi.
  A1: Link tidak valid atau sudah kadaluarsa.
Sistem mengubah status akun menjadi terverifikasi.
Sistem menampilkan notifikasi sukses verifikasi.
Use case selesai.

Alternative Flow :

A1: Link tidak valid atau sudah kadaluarsa.
  1. Sistem menampilkan pesan error link tidak valid atau expired.
  2. Sistem menyediakan pilihan pengiriman ulang link verifikasi.

Error Flow : -

---

Nama Use Case : Lupa Kata Sandi

Deskripsi singkat : Proses meminta reset password jika pengguna lupa kata sandi.
Aktor : Pengguna terdaftar (pelanggan, admin, pemilik)
Pre kondisi : Pengguna sudah pernah mendaftar dan memiliki email aktif.
Pos kondisi : Pengguna menerima email berisi link reset password.

Basic Flow :

Pengguna membuka halaman lupa password.
Pengguna memasukkan email terdaftar.
Sistem melakukan verifikasi email.
  A1: Email tidak terdaftar.
Sistem mengirimkan email reset password ke pengguna.
Sistem menampilkan notifikasi bahwa link reset telah dikirim ke email.
Use case selesai.

Alternative Flow :

A1: Email tidak terdaftar.
  1. Sistem menampilkan pesan error email belum terdaftar.
  2. Kembali ke basic flow langkah ke-2.

Error Flow : -

---

Nama Use Case : Reset Kata Sandi

Deskripsi singkat : Proses mengganti password melalui tautan reset yang dikirim via email.
Aktor : Pengguna terdaftar (pelanggan, admin, dan pemilik)
Pre kondisi : Pengguna telah menerima email reset password dan klik link reset.
Pos kondisi : Password berhasil diubah dan pengguna dapat login dengan password baru.

Basic Flow :

Pengguna membuka email reset password.
Pengguna klik link yang diberikan sistem.
Sistem menampilkan halaman untuk mengisi password baru.
Pengguna memasukkan password baru dan konfirmasi password.
Sistem melakukan validasi input.
  A1: Password tidak memenuhi ketentuan.
Sistem menyimpan password baru dan menampilkan notifikasi sukses.
Use case selesai.

Alternative Flow :

A1: Password tidak memenuhi ketentuan.
  1. Sistem memberikan pesan error ketentuan password.
  2. Kembali ke basic flow langkah ke-4.

Error Flow : -

---

Nama Use Case : Log Out

Deskripsi singkat : Proses keluar dari sistem untuk mengakhiri sesi pengguna.
Aktor : Pengguna terdaftar (pelanggan, admin, dan pemilik)
Pre kondisi : Pengguna sudah dalam keadaan login.
Pos kondisi : Sesi pengguna berakhir dan kembali ke halaman login/beranda.

Basic Flow :

Pengguna menekan tombol logout pada aplikasi.
Sistem memproses permintaan logout.
Sistem menghapus sesi pengguna.
Sistem mengarahkan pengguna ke halaman login atau beranda.
Use case selesai.

Alternative Flow :

-

Error Flow : -

---

Nama Use Case : Lihat Daftar Menu

Deskripsi singkat : Pengguna melihat seluruh daftar menu yang tersedia pada aplikasi.
Aktor : Semua pengguna
Pre kondisi : Sistem sudah memiliki daftar menu yang aktif.
Pos kondisi : Daftar menu tampil sesuai filter, kategori, dan pencarian.

Basic Flow :

Pengguna membuka halaman menu di aplikasi/website.
Sistem menampilkan seluruh menu yang tersedia.
Pengguna dapat menggunakan fitur pencarian untuk menemukan menu tertentu.
Pengguna dapat menerapkan filter atau memilih kategori menu.
Sistem memperbarui tampilan daftar menu sesuai kriteria yang dipilih.
Use case selesai.

Alternative Flow :

-

Error Flow : -

---

Nama Use Case : Lihat Detail Menu

Deskripsi singkat : Pengguna melihat informasi detail dari satu menu tertentu.
Aktor : Semua pengguna
Pre kondisi : Menu yang ingin dilihat sudah tersedia di database.
Pos kondisi : Pengguna melihat detail, deskripsi, harga, rating, stok, dan review menu.

Basic Flow :

Pengguna memilih menu dari daftar.
Sistem menampilkan halaman detail menu.
Detail menu yang tampil meliputi: gambar, deskripsi, harga, status stok, rating, dan review yang sudah tersedia.
Use case selesai.

Alternative Flow :

-

Error Flow : -

---

Nama Use Case : Tambah Item ke Keranjang

Deskripsi singkat : Pengguna menambahkan menu (beserta jumlah dan catatan) ke keranjang belanja.
Aktor : Pengguna terdaftar (pelanggan)
Pre kondisi : Pengguna sudah login dan memilih menu yang diinginkan.
Pos kondisi : Menu beserta jumlah/catatan berhasil masuk ke keranjang pengguna.

Basic Flow :

Pengguna memilih menu dari halaman detail.
Pengguna menentukan jumlah pesanan dan catatan (opsional).
Pengguna menekan tombol “Tambah ke keranjang”.
Sistem memproses dan menambahkan item ke dalam keranjang belanja.
Sistem memperbarui keranjang pengguna dan menampilkan notifikasi sukses.
Use case selesai.

Alternative Flow :

-

Error Flow : -

---

Nama Use Case : Lihat Keranjang

Deskripsi singkat : Pengguna melihat semua item yang sudah dimasukkan ke keranjang sebelum melakukan pemesanan.
Aktor : Pengguna terdaftar (pelanggan)
Pre kondisi : Pengguna sudah login dan memiliki item di keranjang.
Pos kondisi : Pengguna melihat daftar, jumlah, dan total harga item yang ada di keranjang.

Basic Flow :

Pengguna membuka halaman keranjang.
Sistem menampilkan seluruh item yang ada di keranjang pengguna.
Sistem menampilkan jumlah item, subtotal per item, dan total harga seluruh item di keranjang.
Use case selesai.

Alternative Flow :

A1: Keranjang kosong.
  1. Sistem menampilkan notifikasi bahwa keranjang kosong.
  2. Pengguna diarahkan untuk menambah item ke keranjang dari menu.

Error Flow : -

---

Nama Use Case : Update Item Keranjang

Deskripsi singkat : Pengguna mengubah jumlah atau catatan pada item di keranjang belanja.
Aktor : Pengguna terdaftar (pelanggan)
Pre kondisi : Terdapat item dalam keranjang pengguna.
Pos kondisi : Item di keranjang diperbarui sesuai perubahan yang diinginkan pengguna.

Basic Flow :

Pengguna memilih item pada keranjang yang ingin diubah.
Pengguna memperbarui jumlah atau mengedit catatan pada item tersebut.
Pengguna menekan tombol simpan/perbarui.
Sistem memproses dan memperbarui item di keranjang.
Sistem menampilkan notifikasi perubahan berhasil.
Use case selesai.

Alternative Flow :

-

Error Flow : -

---

Nama Use Case : Hapus Item dari Keranjang

Deskripsi singkat : Pengguna menghapus salah satu item dari keranjang belanja.
Aktor : Pengguna terdaftar (pelanggan)
Pre kondisi : Terdapat item di keranjang pengguna.
Pos kondisi : Item yang dihapus tidak lagi muncul di keranjang pengguna.

Basic Flow :

Pengguna membuka keranjang dan memilih item yang ingin dihapus.
Pengguna menekan tombol hapus pada item tersebut.
Sistem menghapus item dari daftar keranjang pengguna.
Sistem memperbarui tampilan keranjang.
Use case selesai.

Alternative Flow :

-

Error Flow : -

---

Nama Use Case : Buat Pesanan

Deskripsi singkat : Pengguna melakukan proses checkout/membuat pesanan berdasarkan isi keranjang.
Aktor : Pengguna terdaftar (pelanggan)
Pre kondisi : Terdapat item di keranjang, pengguna sudah login.
Pos kondisi : Pesanan baru tercatat, item dikeluarkan dari keranjang.

Basic Flow :

Pengguna membuka halaman keranjang.
Pengguna menekan tombol checkout/buat pesanan.
Sistem memproses aktifasi pesanan baru dari isi keranjang.
Sistem menyimpan data pesanan ke database.
Sistem mengosongkan keranjang pengguna.
Sistem mengarahkan pengguna ke halaman detail pesanan/bayar.
Use case selesai.

Alternative Flow :

-

Error Flow : -

---

Nama Use Case : Lihat Daftar Pesanan

Deskripsi singkat : Pengguna melihat riwayat seluruh pesanan yang pernah dibuat.
Aktor : Pengguna terdaftar (pelanggan)
Pre kondisi : Pengguna sudah pernah membuat satu atau lebih pesanan.
Pos kondisi : Daftar pesanan pengguna tampil beserta detail status, tanggal, dan total pembayaran.

Basic Flow :

Pengguna membuka menu pesanan saya/riwayat transaksi.
Sistem mengambil dan menampilkan seluruh data pesanan pengguna dari database.
Pengguna dapat memilih salah satu pesanan untuk melihat detail lebih lanjut.
Use case selesai.

Alternative Flow :

-

Error Flow : -

---

Nama Use Case : Lihat Detail Pesanan

Deskripsi singkat : Pengguna melihat rincian lengkap untuk satu pesanan tertentu.
Aktor : Pengguna terdaftar (pelanggan)
Pre kondisi : Pengguna memiliki minimal satu data pesanan di sistem.
Pos kondisi : Rincian item, status, total pembayaran, dan cara pembayaran pesanan tampil untuk pengguna.

Basic Flow :

Pengguna memilih satu pesanan dari daftar pesanan.
Sistem menampilkan detail item, status pesanan, total pembayaran, dan metode pembayaran.
Use case selesai.

Alternative Flow :

-

Error Flow : -

---

Nama Use Case : Pembayaran Online

Deskripsi singkat : Pengguna melakukan pembayaran digital untuk satu pesanan lewat integrasi Midtrans.
Aktor : Pengguna terdaftar (pelanggan)
Pre kondisi : Terdapat pesanan dengan status belum dibayar, pengguna login.
Pos kondisi : Status pesanan berubah menjadi “dibayar” jika transaksi berhasil.

Basic Flow :

Pengguna membuka detail pesanan yang belum dibayar.
Pengguna menekan tombol bayar sekarang.
Sistem menampilkan opsi pembayaran melalui Midtrans.
Pengguna memilih metode pembayaran sesuai keinginan dan melakukan instruksi pembayaran.
Sistem otomatis menerima notifikasi sukses jika pembayaran berhasil.
Status pesanan berubah menjadi dibayar.
Use case selesai.

Alternative Flow :

A1: Pembayaran gagal/kadaluarsa.
  1. Sistem menampilkan info gagal bayar.
  2. Status pesanan tetap menunggu pembayaran.

Error Flow : -

---

Nama Use Case : Download Invoice PDF

Deskripsi singkat : Pengguna mengunduh faktur/invoice pesanan dalam bentuk PDF setelah transaksi selesai.
Aktor : Pengguna terdaftar (pelanggan)
Pre kondisi : Ada pesanan selesai/transaksi sah.
Pos kondisi : File PDF invoice tersimpan pada perangkat pengguna.

Basic Flow :

Pengguna membuka detail salah satu pesanan selesai.
Pengguna menekan tombol download invoice.
Sistem menghasilkan file invoice PDF sesuai pesanan.
Sistem memberikan tautan download dan pengguna menyimpan file.
Use case selesai.

Alternative Flow :

-

Error Flow : -

---

Nama Use Case : Tambah Review

Deskripsi singkat : Pengguna menambahkan ulasan dan rating pada menu yang sudah dipesan.
Aktor : Pengguna terdaftar (pelanggan)
Pre kondisi : Pesanan sudah selesai, menu diterima pengguna.
Pos kondisi : Review baru tercatat, status review menunggu moderasi admin.

Basic Flow :

Pengguna membuka daftar pesanan yang sudah selesai.
Pengguna memilih menu untuk direview.
Pengguna mengisi rating dan komentar (review).
Pengguna menekan tombol simpan review.
Sistem memproses dan menyimpan review dalam status “menunggu moderasi/admin”.
Use case selesai.

Alternative Flow :

A1: Review untuk menu tersebut sudah pernah dikirim pengguna.
  1. Sistem menampilkan pesan bahwa review hanya bisa dibuat satu kali per menu.
  2. Pengguna dapat memilih untuk mengedit review lama atau batal membuat review baru.

Error Flow :

E1: Koneksi terputus saat menyimpan review.
  1. Sistem menampilkan pesan error jaringan.
  2. Pengguna dapat mencoba ulang atau membatalkan aksi.

---

Nama Use Case : Lihat Review Menu

Deskripsi singkat : Pengguna melihat seluruh review yang sudah dimoderasi pada menu tertentu.
Aktor : Semua pengguna
Pre kondisi : Menu yang ingin dilihat memiliki review yang sudah disetujui admin.
Pos kondisi : Semua review tampil dalam daftar review menu.

Basic Flow :

Pengguna membuka halaman detail menu.
Sistem menampilkan daftar review terverifikasi untuk menu tersebut.
Use case selesai.

Alternative Flow :

A1: Menu belum memiliki review.
  1. Sistem menampilkan pesan bahwa belum ada review.
  2. Pengguna diarahkan untuk menjadi reviewer pertama jika sudah pernah membeli menu tersebut.

Error Flow : -

---

Nama Use Case : Update Review

Deskripsi singkat : Pengguna memperbarui isi review yang sebelumnya sudah dibuat.
Aktor : Pengguna terdaftar (pelanggan)
Pre kondisi : Sudah pernah menulis review untuk menu tersebut.
Pos kondisi : Review diperbarui dan statusnya kembali ke “menunggu moderasi”.

Basic Flow :

Pengguna masuk ke daftar review miliknya.
Pengguna memilih review yang ingin diedit.
Pengguna memperbarui rating atau isi komentar, lalu simpan.
Sistem menyimpan perubahan dan mengatur review ke “menunggu moderasi”.
Use case selesai.

Alternative Flow :

A1: Review yang ingin diupdate tidak ditemukan atau bukan milik pengguna.
  1. Sistem menampilkan notifikasi error dan membatalkan proses update.

Error Flow :

E1: Gagal menyimpan perubahan review karena kesalahan sistem.
  1. Sistem menampilkan pesan error umum.
  2. Pengguna bisa mencoba ulang.

---

Nama Use Case : Hapus Review

Deskripsi singkat : Pengguna menghapus review yang pernah dibuat pada menu tertentu.
Aktor : Pengguna terdaftar (pelanggan)
Pre kondisi : Review masih ada dan merupakan milik pengguna.
Pos kondisi : Review terhapus dan tidak lagi tampil di menu.

Basic Flow :

Pengguna membuka daftar review milik sendiri.
Pengguna memilih review yang ingin dihapus.
Pengguna menekan tombol hapus dan melakukan konfirmasi.
Sistem menghapus review dan memperbarui status menu.
Use case selesai.

Alternative Flow :

A1: Pengguna membatalkan proses hapus saat konfirmasi.
  1. Sistem membatalkan proses penghapusan.
  2. Review tetap ada.

A2: Review sudah dihapus lebih dulu oleh admin.
  1. Sistem menampilkan notifikasi data tidak ditemukan.

Error Flow : -

---

Nama Use Case : Update Profil

Deskripsi singkat : Pengguna memperbarui data profil (nama, alamat, telepon, email).
Aktor : Pengguna terdaftar (pelanggan, admin, pemilik)
Pre kondisi : Pengguna sudah login dan akses ke halaman profil.
Pos kondisi : Data profil diperbarui sesuai input pengguna.

Basic Flow :

Pengguna membuka halaman profil.
Pengguna mengedit data sesuai kebutuhan (nama, alamat, telepon, email).
Pengguna menekan tombol simpan.
Sistem memvalidasi data input.
  A1: Data tidak valid/form kosong.
Sistem menyimpan data baru dan menampilkan notifikasi perubahan berhasil.
Use case selesai.

Alternative Flow :

A1: Data tidak valid atau sudah pernah digunakan (email).
  1. Sistem menampilkan pesan error validasi.
  2. Pengguna diminta menginput ulang data.

Error Flow : -

---

Nama Use Case : Ubah Password Profil

Deskripsi singkat : Pengguna mengganti password dari halaman profil setelah login.
Aktor : Pengguna terdaftar (pelanggan, admin, pemilik)
Pre kondisi : Pengguna sudah login dan mengetahui password lama.
Pos kondisi : Password baru tersimpan dan pengguna bisa login menggunakan password baru.

Basic Flow :

Pengguna membuka halaman profil > ubah password.
Pengguna mengisi password lama, password baru, dan konfirmasi password baru.
Sistem memvalidasi kecocokan password lama dan ketentuan password baru.
  A1: Password lama tidak cocok atau ketentuan tidak terpenuhi.
Sistem menyimpan password baru.
Sistem menampilkan notifikasi perubahan berhasil.
Use case selesai.

Alternative Flow :

A1: Password lama salah atau password baru tidak sesuai ketentuan.
  1. Sistem menampilkan pesan error yang relevan.
  2. Pengguna melakukan perbaikan input dan mengirim ulang.

Error Flow : -

---

Nama Use Case : Hapus Akun

Deskripsi singkat : Pengguna menghapus akunnya secara permanen dari sistem.
Aktor : Pengguna terdaftar (pelanggan)
Pre kondisi : Pengguna login dan melakukan konfirmasi penghapusan.
Pos kondisi : Akun dinonaktifkan/dihapus; data wajib transaksi tetap disimpan sesuai regulasi.

Basic Flow :

Pengguna membuka halaman pengaturan akun.
Pengguna menekan hapus akun dan melakukan konfirmasi.
Sistem memverifikasi kredensial/konfirmasi akhir.
Sistem menandai akun terhapus dan mengakhiri sesi.
Sistem menampilkan notifikasi keberhasilan.
Use case selesai.

Alternative Flow :

A1: Pengguna membatalkan konfirmasi.
  1. Sistem membatalkan proses penghapusan.

Error Flow : -

---

Nama Use Case : Tambah Menu (Admin)

Deskripsi singkat : Admin menambahkan menu baru dengan detail lengkap.
Aktor : Admin
Pre kondisi : Admin login; minimal satu kategori tersedia.
Pos kondisi : Menu baru tersimpan dan dapat tampil di katalog jika aktif.

Basic Flow :

Admin membuka halaman manajemen menu.
Admin mengisi nama, harga, kategori, deskripsi, stok, gambar, dan status.
Sistem memvalidasi data input.
  A1: Data tidak valid.
Sistem menyimpan menu baru.
Use case selesai.

Alternative Flow :

A1: Data tidak valid (harga negatif, kategori kosong, file gambar tidak sesuai).
  1. Sistem menolak penyimpanan dan menampilkan pesan validasi.
  2. Admin memperbaiki input dan menyimpan ulang.

Error Flow : -

---

Nama Use Case : Lihat Daftar Menu (Admin)

Deskripsi singkat : Admin melihat seluruh menu yang ada, termasuk pencarian dan filter.
Aktor : Admin
Pre kondisi : Terdapat data menu di sistem.
Pos kondisi : Daftar menu tampil sesuai filter/urut pencarian admin.

Basic Flow :

Admin membuka halaman daftar menu.
Sistem menampilkan daftar menu dengan informasi ringkas.
Admin dapat melakukan pencarian, filter kategori/status, dan pengurutan.
Use case selesai.

Alternative Flow :

A1: Tidak ada data sesuai kriteria.
  1. Sistem menampilkan pesan tidak ada hasil.

Error Flow : -

---

Nama Use Case : Edit Menu (Admin)

Deskripsi singkat : Admin memperbarui informasi menu yang sudah ada.
Aktor : Admin
Pre kondisi : Menu yang dimaksud tersedia di sistem.
Pos kondisi : Perubahan menu tersimpan dan memengaruhi tampilan katalog.

Basic Flow :

Admin membuka detail menu yang ingin diubah.
Admin memperbarui field yang diperlukan (harga, deskripsi, stok, gambar, status, kategori).
Sistem memvalidasi input.
  A1: Data tidak valid.
Sistem menyimpan perubahan.
Use case selesai.

Alternative Flow :

A1: Data tidak valid.
  1. Sistem menampilkan pesan validasi dan membatalkan penyimpanan.

Error Flow : -

---

Nama Use Case : Hapus Menu (Admin)

Deskripsi singkat : Admin menghapus menu yang tidak lagi dijual.
Aktor : Admin
Pre kondisi : Menu ada dan tidak terikat transaksi aktif.
Pos kondisi : Menu terhapus atau dinonaktifkan dari katalog.

Basic Flow :

Admin memilih menu dari daftar.
Admin menekan hapus dan melakukan konfirmasi.
Sistem menghapus atau menandai menu sebagai nonaktif.
Use case selesai.

Alternative Flow :

A1: Menu terkait transaksi aktif.
  1. Sistem menolak penghapusan dan menyarankan menonaktifkan menu.

Error Flow : -

---

Nama Use Case : Lihat Daftar Pesanan (Admin)

Deskripsi singkat : Admin memantau seluruh pesanan pelanggan.
Aktor : Admin
Pre kondisi : Ada pesanan yang tercatat di sistem.
Pos kondisi : Daftar pesanan tampil dengan kemampuan filter dan pencarian.

Basic Flow :

Admin membuka halaman pesanan.
Sistem menampilkan daftar pesanan dengan status terbaru.
Admin dapat memfilter berdasarkan status, tanggal, atau pelanggan.
Use case selesai.

Alternative Flow :

A1: Tidak ada pesanan pada kriteria yang dipilih.
  1. Sistem menampilkan pesan tidak ada data.

Error Flow : -

---

Nama Use Case : Lihat Detail Pesanan (Admin)

Deskripsi singkat : Admin melihat rincian lengkap sebuah pesanan.
Aktor : Admin
Pre kondisi : Pesanan yang dimaksud ada di sistem.
Pos kondisi : Rincian pesanan terlihat untuk tindak lanjut operasional.

Basic Flow :

Admin memilih salah satu pesanan dari daftar.
Sistem menampilkan detail item, harga, alamat (jika perlu), status, dan metode pembayaran.
Use case selesai.

Alternative Flow :

A1: Pesanan tidak ditemukan.
  1. Sistem menampilkan notifikasi data tidak tersedia.

Error Flow : -

---

Nama Use Case : Tambah Kategori (Admin)

Deskripsi singkat : Admin menambah kategori baru untuk pengelompokan menu.
Aktor : Admin
Pre kondisi : Admin login dan memiliki hak akses.
Pos kondisi : Kategori baru tersimpan dan tersedia saat membuat menu.

Basic Flow :

Admin membuka halaman kategori.
Admin mengisi nama dan deskripsi (opsional).
Sistem memvalidasi input dan menyimpan.
Use case selesai.

Alternative Flow :

A1: Nama kategori sudah digunakan.
  1. Sistem menolak penyimpanan dan menampilkan pesan validasi.

Error Flow : -

---

Nama Use Case : Lihat Daftar Kategori (Admin)

Deskripsi singkat : Admin melihat seluruh kategori yang tersedia.
Aktor : Admin
Pre kondisi : Ada data kategori.
Pos kondisi : Daftar kategori tampil dengan kemampuan pencarian.

Basic Flow :

Admin membuka halaman kategori.
Sistem menampilkan daftar kategori.
Admin dapat melakukan pencarian atau sortir.
Use case selesai.

Alternative Flow :

A1: Tidak ada data kategori.
  1. Sistem menampilkan pesan tidak ada data.

Error Flow : -

---

Nama Use Case : Edit Kategori (Admin)

Deskripsi singkat : Admin memperbarui data kategori.
Aktor : Admin
Pre kondisi : Kategori yang dimaksud ada.
Pos kondisi : Perubahan kategori tersimpan dan berdampak ke menu yang terkait.

Basic Flow :

Admin memilih kategori yang akan diubah.
Admin memperbarui nama/deskripsi.
Sistem memvalidasi dan menyimpan perubahan.
Use case selesai.

Alternative Flow :

A1: Nama kategori baru bentrok dengan kategori lain.
  1. Sistem menolak penyimpanan dan menampilkan pesan validasi.

Error Flow : -

---

Nama Use Case : Hapus Kategori (Admin)

Deskripsi singkat : Admin menghapus kategori yang tidak dipakai.
Aktor : Admin
Pre kondisi : Kategori tidak memiliki menu aktif terkait.
Pos kondisi : Kategori terhapus dari sistem.

Basic Flow :

Admin memilih kategori dari daftar.
Admin menekan hapus dan konfirmasi.
Sistem menghapus kategori atau menolak jika masih dipakai.
Use case selesai.

Alternative Flow :

A1: Masih ada menu terkait kategori tersebut.
  1. Sistem menolak penghapusan dan menampilkan daftar menu terkait.

Error Flow : -

---

Nama Use Case : Lihat Daftar Review (Admin)

Deskripsi singkat : Admin melihat daftar review dengan filter status.
Aktor : Admin
Pre kondisi : Terdapat review pada sistem.
Pos kondisi : Daftar review tampil sesuai kriteria.

Basic Flow :

Admin membuka halaman review.
Sistem menampilkan daftar review beserta status (menunggu, disetujui, ditolak/tersembunyi).
Admin dapat memfilter dan mencari review.
Use case selesai.

Alternative Flow :

A1: Tidak ada review pada kriteria.
  1. Sistem menampilkan pesan tidak ada data.

Error Flow : -

---

Nama Use Case : Lihat Detail Review (Admin)

Deskripsi singkat : Admin melihat rincian review spesifik.
Aktor : Admin
Pre kondisi : Review ada pada sistem.
Pos kondisi : Detail review tampil untuk keputusan moderasi.

Basic Flow :

Admin memilih review dari daftar.
Sistem menampilkan detail rating, komentar, menu, dan pengguna.
Use case selesai.

Alternative Flow :

A1: Review tidak ditemukan.
  1. Sistem menampilkan notifikasi data tidak tersedia.

Error Flow : -

---

Nama Use Case : Approve Review (Admin)

Deskripsi singkat : Admin menyetujui review agar tampil ke publik.
Aktor : Admin
Pre kondisi : Review berstatus menunggu moderasi.
Pos kondisi : Review berstatus disetujui dan tampil di halaman menu.

Basic Flow :

Admin membuka detail review yang menunggu.
Admin menekan tombol setujui.
Sistem mengubah status review menjadi disetujui.
Use case selesai.

Alternative Flow :

A1: Review sudah diproses.
  1. Sistem menampilkan informasi status terkini dan membatalkan aksi.

Error Flow : -

---

Nama Use Case : Hide Review (Admin)

Deskripsi singkat : Admin menyembunyikan review dari publik tanpa menghapus data.
Aktor : Admin
Pre kondisi : Review ada pada sistem.
Pos kondisi : Review tidak tampil untuk publik, status menjadi disembunyikan.

Basic Flow :

Admin membuka detail review.
Admin menekan tombol sembunyikan.
Sistem memperbarui status review menjadi tersembunyi.
Use case selesai.

Alternative Flow :

A1: Review sudah tersembunyi.
  1. Sistem memberi tahu bahwa tidak ada perubahan.

Error Flow : -

---

Nama Use Case : Reject/Hapus Review (Admin)

Deskripsi singkat : Admin menolak atau menghapus review yang tidak pantas.
Aktor : Admin
Pre kondisi : Review ada dan berstatus menunggu/aktif.
Pos kondisi : Review tidak akan tampil lagi (ditolak/terhapus).

Basic Flow :

Admin membuka detail review.
Admin memilih aksi tolak/hapus disertai alasan (opsional).
Sistem memperbarui status atau menghapus permanen sesuai kebijakan.
Use case selesai.

Alternative Flow :

A1: Review sudah dihapus oleh admin lain.
  1. Sistem menampilkan status terbaru dan membatalkan aksi.

Error Flow : -

---

Nama Use Case : Statistik Review (Admin)

Deskripsi singkat : Admin melihat statistik agregat dari review pelanggan.
Aktor : Admin
Pre kondisi : Terdapat data review pada sistem.
Pos kondisi : Statistik tampil (jumlah review, rata-rata rating, distribusi bintang, tren).

Basic Flow :

Admin membuka halaman statistik review.
Sistem menghitung dan menampilkan metrik agregat.
Admin dapat memfilter berdasarkan periode/waktu.
Use case selesai.

Alternative Flow :

A1: Tidak ada data pada periode yang dipilih.
  1. Sistem menampilkan pesan tidak ada data.

Error Flow : -

---

Nama Use Case : Statistik Dashboard (Owner)

Deskripsi singkat : Owner memantau performa bisnis pada dashboard.
Aktor : Pemilik
Pre kondisi : Ada data transaksi, menu, dan review.
Pos kondisi : Dashboard menampilkan KPI utama (pendapatan, jumlah pesanan, pelanggan, menu terlaris).

Basic Flow :

Owner membuka halaman dashboard.
Sistem memuat metrik dan grafik KPI.
Owner dapat mengubah rentang waktu.
Use case selesai.

Alternative Flow :

A1: Data pada rentang waktu sedikit atau kosong.
  1. Sistem tetap menampilkan informasi sesuai yang tersedia.

Error Flow : -

---

Nama Use Case : Laporan Harian Penjualan (Owner)

Deskripsi singkat : Owner melihat laporan penjualan harian.
Aktor : Pemilik
Pre kondisi : Ada transaksi pada hari terkait.
Pos kondisi : Laporan harian tampil beserta ringkasan.

Basic Flow :

Owner membuka halaman laporan.
Owner memilih tanggal harian.
Sistem menampilkan total transaksi, omzet, jumlah item terjual, dan menu populer.
Use case selesai.

Alternative Flow :

A1: Tidak ada transaksi di tanggal tersebut.
  1. Sistem menampilkan pesan tidak ada data.

Error Flow : -

---

Nama Use Case : Laporan Bulanan Penjualan (Owner)

Deskripsi singkat : Owner melihat laporan penjualan bulanan.
Aktor : Pemilik
Pre kondisi : Ada transaksi pada bulan terkait.
Pos kondisi : Laporan bulanan tampil beserta ringkasan dan perbandingan.

Basic Flow :

Owner membuka halaman laporan.
Owner memilih bulan dan tahun.
Sistem menampilkan total penjualan, omzet, tren, dan menu terlaris.
Use case selesai.

Alternative Flow :

A1: Tidak ada transaksi pada bulan tersebut.
  1. Sistem menampilkan pesan tidak ada data.

Error Flow : -

---

Nama Use Case : Laporan Menu Terlaris (Owner)

Deskripsi singkat : Owner melihat daftar menu terlaris pada periode tertentu.
Aktor : Pemilik
Pre kondisi : Ada transaksi yang melibatkan menu pada periode.
Pos kondisi : Daftar menu terlaris tampil beserta jumlah terjual dan kontribusi omzet.

Basic Flow :

Owner membuka halaman laporan khusus.
Owner memilih rentang tanggal.
Sistem menampilkan peringkat menu berdasarkan jumlah terjual dan omzet.
Use case selesai.

Alternative Flow :

A1: Tidak ada data pada periode tersebut.
  1. Sistem menampilkan pesan tidak ada data.

Error Flow : -

---

Nama Use Case : Laporan Aktivitas Sistem (Owner)

Deskripsi singkat : Owner membaca log aktivitas penting sistem untuk audit.
Aktor : Pemilik
Pre kondisi : Sistem menyimpan log aktivitas.
Pos kondisi : Log aktivitas tampil dan dapat difilter.

Basic Flow :

Owner membuka halaman log aktivitas.
Sistem menampilkan daftar log (aksi, aktor, waktu, objek).
Owner menerapkan filter periode/aktor/aksi (opsional).
Use case selesai.

Alternative Flow :

A1: Tidak ada log dalam periode tertentu.
  1. Sistem menampilkan pesan tidak ada data.

Error Flow : -

---

Nama Use Case : Download Laporan Harian Penjualan PDF (Owner)

Deskripsi singkat : Owner mengunduh laporan penjualan harian dalam PDF.
Aktor : Pemilik
Pre kondisi : Laporan harian tersedia.
Pos kondisi : File PDF terunduh di perangkat owner.

Basic Flow :

Owner membuka laporan harian.
Owner menekan tombol unduh PDF.
Sistem menghasilkan file PDF dan memberikan tautan unduh.
Use case selesai.

Alternative Flow :

A1: Gagal menghasilkan PDF.
  1. Sistem menampilkan notifikasi dan menawarkan coba lagi.

Error Flow : -

---

Nama Use Case : Download Laporan Bulanan Penjualan PDF (Owner)

Deskripsi singkat : Owner mengunduh laporan bulanan penjualan dalam PDF.
Aktor : Pemilik
Pre kondisi : Laporan bulanan tersedia.
Pos kondisi : File PDF tersimpan di perangkat owner.

Basic Flow :

Owner membuka laporan bulanan.
Owner menekan tombol unduh PDF.
Sistem menghasilkan file PDF dan menyediakan tautan unduh.
Use case selesai.

Alternative Flow :

A1: Gagal menghasilkan PDF.
  1. Sistem menampilkan notifikasi kesalahan.

Error Flow : -

---

Nama Use Case : Download Laporan Menu Terlaris PDF (Owner)

Deskripsi singkat : Owner mengunduh laporan menu terlaris dalam PDF.
Aktor : Pemilik
Pre kondisi : Laporan menu terlaris tersedia.
Pos kondisi : File PDF unduhan tersedia di perangkat owner.

Basic Flow :

Owner membuka laporan menu terlaris.
Owner menekan tombol unduh PDF.
Sistem membuat file PDF dan menyajikan tautan unduh.
Use case selesai.

Alternative Flow :

A1: Gagal membuat file PDF.
  1. Sistem menampilkan pesan kesalahan.

Error Flow : -

---

Nama Use Case : Download Laporan Aktivitas Sistem PDF (Owner)

Deskripsi singkat : Owner mengunduh log aktivitas sistem dalam format PDF.
Aktor : Pemilik
Pre kondisi : Laporan aktivitas tersedia.
Pos kondisi : File PDF terunduh untuk kebutuhan audit/arsip.

Basic Flow :

Owner membuka halaman log aktivitas.
Owner menekan unduh PDF.
Sistem menghasilkan file PDF dan memberikan tautan unduh.
Use case selesai.

Alternative Flow :

A1: Pembuatan PDF gagal.
  1. Sistem menampilkan notifikasi dan menawarkan percobaan ulang.

Error Flow : -

---
