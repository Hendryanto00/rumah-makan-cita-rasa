# Deskripsi Wireframe Rumah Makan Cita Rasa

Dokumen ini merangkum perilaku tiap halaman pada wireframes-user-bw-complete.html. Format mengikuti struktur **Deskripsi**, **Input**, **Output**, serta langkah **Method/Algoritma** untuk aksi utama di setiap layar.

---

## 1. Landing Page (Home)
Deskripsi: Beranda utama menyorot hero “Kami menyediakan makanan terbaik”, tombol “Lihat Menu” dan “Tentang Kami”, daftar 4 hidangan spesial (Spicy Noodles, Fried Rice, Satay, Special Salad), highlight keunggulan pesan online & ambil di tempat, serta footer berisi jam operasional dan tautan WhatsApp.

Input: Tombol “Lihat Menu”, tombol “Tentang Kami”, tombol “Lihat Semua Menu”, tombol “Pesan Sekarang”, tautan cepat di footer, tombol WhatsApp.

Output: Tampilan hero dengan gambar restoran, kartu hidangan spesial statis, blok penjelasan layanan online/pick-up, dan informasi jam operasional + kontak di footer.

Method/Algoritma:  
On 'Get'  
1. Ambil konten hero, daftar hidangan spesial statis, blok keunggulan, dan footer.  
2. Render urutan section (hero → hidangan spesial → kemudahan pesan → footer).  
3. Pastikan tautan footer (jam operasional, WhatsApp) aktif sebagai link navigasi.

---

## 2. About Page
Deskripsi: Halaman profil berisi hero “Tentang Rumah Makan Cita Rasa” dengan tombol “Hubungi Kami” dan “Lihat Menu”, diikuti blok visi/misi yang memakai dua kartu besar (ikon mata dan target) yang menjelaskan komitmen rasa, pelayanan, dan pengalaman makan.

Input: Tombol “Hubungi Kami”, tombol “Lihat Menu”.

Output: Informasi sejarah, teks visi dan daftar misi, serta tautan menuju kontak/menu.

Method/Algoritma:  
On 'Get'  
1. Ambil data hero (judul, deskripsi, gambar) dan konten visi/misi.  
2. Render hero, tombol aksi, lalu grid dua kartu visi/misi.

On 'Update'  
1. Saat tombol “Hubungi Kami” ditekan, arahkan ke halaman halaman kontak.  
2. Saat tombol “Lihat Menu” ditekan, arahkan ke halaman menu.

---

## 3. Contact Page
Deskripsi: Menampilkan hero “Hubungi Rumah Makan Cita Rasa” dengan tombol WhatsApp & “Lihat Menu”, embed Google Maps, lalu blok informasi (alamat, jam buka, nomor, kode lokasi) dan foto resto.

Input: Tombol “Hubungi via WhatsApp”, tombol “Lihat Menu”.

Output: Peta interaktif, detail alamat/jam operasional/kontak, dan link WhatsApp aktif.

Method/Algoritma:  
On 'Get'  
1. Ambil konten hero, URL WhatsApp, dan koordinat Google Maps.  
2. Render hero + tombol, iframe peta, dan kartu informasi kontak.

On 'Entry'  
1. Jika pengguna menekan tombol WhatsApp, buka tautan tautan WhatsApp dengan nomor resto.  
2. Jika menekan “Lihat Menu”, arahkan ke halaman menu.

---

## 4. Menu Listing Page
Deskripsi: Halaman menu berisi hero “Our Delicious Menu”, kolom pencarian AJAX, dropdown kategori, tombol “Cari”, grid kartu menu dinamis, serta modal “Tambah ke Keranjang” yang meminta jumlah dan catatan.

Input: Kolom pencarian, dropdown kategori, tombol “Cari”, tombol “Tambah ke Keranjang” pada kartu, form jumlah/catatan di modal.

Output: Grid menu sesuai filter, notifikasi stok, modal konfirmasi tambah keranjang, pagination yang diperbarui via AJAX.

Method/Algoritma:  
On 'Get'  
1. Baca parameter default (kategori populer, promo).  
2. Ambil daftar menu awal beserta metadata halaman.  
3. Tampilkan grid menu dan inisialisasi filter.

On 'Find'  
1. Baca kata kunci dan filter dari pengguna.  
2. Query menu sesuai parameter tersebut.  
3. Tampilkan hasil pencarian dan update pagination.  
4. Bila kosong tampilkan state “tidak ditemukan”.

On 'Entry'  
1. Saat tombol “Tambah ke Keranjang” ditekan, baca ID menu & qty default.  
2. Simpan item baru ke keranjang user.  
3. Tampilkan notifikasi sukses dan perbarui badge keranjang.

---

## 5. Menu Detail Page
Deskripsi: Halaman detail menu menonjolkan hero nama menu, badge kategori, stok, rata-rata rating, gambar dinamis, deskripsi, harga, tombol “Write a Review”/“Add to Cart”, serta komponen review yang menampilkan daftar ulasan.

Input: Tombol “Write a Review”, tombol “Add to Cart”, form modal jumlah & catatan.

Output: Detail menu lengkap (kategori, stok, harga, deskripsi), daftar review, notifikasi stok saat menambah ke keranjang.

Method/Algoritma:  
On 'Get'  
1. Baca ID menu dari URL.  
2. Ambil detail menu, rating, dan rekomendasi terkait.  
3. Render informasi ke tampilan.

On 'Entry'  
1. Saat tombol “Add to Cart” ditekan, kumpulkan ID menu, qty, dan catatan dari modal.  
2. Validasi stok & batas qty sebelum menyimpan.  
3. Simpan item ke keranjang (via AJAX) dan tampilkan notifikasi.

---

## 6. Cart Page
Deskripsi: Halaman keranjang memuat hero “Keranjang Saya”, daftar item dengan gambar, catatan, quantity control, tombol hapus, ringkasan total di panel kanan, tombol “Checkout Sekarang”, tautan “Lanjutkan Belanja”, serta state kosong bila tidak ada item.

Input: Tombol +/- pada setiap item, tombol hapus, tombol “Checkout Sekarang”, link “Lanjutkan Belanja”.

Output: Subtotal per item, total keseluruhan, SweetAlert saat checkout, atau pesan “Keranjang Kosong” dengan tombol kembali ke menu.

Method/Algoritma:  
On 'Get'  
1. Ambil seluruh item keranjang aktif beserta ringkasan biaya.  
2. Jika kosong tampilkan state “keranjang kosong”.  
3. Render tabel item dan ringkasan.

On 'Update'  
1. Ketika tombol +/- ditekan, baca ID item dan jumlah baru.  
2. Validasi jumlah minimal 1 dan tidak melebihi stok.  
3. Simpan perubahan lalu refresh ringkasan biaya.

On 'Delete'  
1. Saat ikon hapus diklik, baca ID item.  
2. Hapus item dari keranjang dan hitung ulang total.  
3. Jika tidak tersisa item, tampilkan state kosong.

On 'Entry'  
1. Ketika “Checkout Sekarang” dipilih, panggil endpoint endpoint pembuatan pesanan.  
2. Jika sukses, redirect ke proses pembayaran; jika gagal, tampilkan pesan error.

---

## 7. Orders (History) Page
Deskripsi: Halaman riwayat pesanan menampilkan hero “Riwayat Pesanan”, dropdown filter status, kartu-kartu pesanan berisi ID, tanggal, total bayar, badge status, timeline langkah (pending → selesai), tombol “Lihat Detail”, “Unduh Nota”, serta banner lanjutan pembayaran jika status masih menunggu.

Input: Dropdown status, tombol “Lihat Detail”, tombol “Unduh Nota”, tombol “Lanjutkan Pembayaran”.

Output: Daftar pesanan terfilter, badge status berwarna, timeline status, dan pagination; jika belum ada pesanan muncul state kosong dengan tombol menuju menu.

Method/Algoritma:  
On 'Get'  
1. Ambil daftar pesanan terbaru user beserta statusnya.  
2. Tampilkan kartu pesanan lengkap dengan badge status, timeline, dan tombol aksi.

On 'Find'  
1. Baca status yang dipilih pada dropdown filter.  
2. Query riwayat berdasarkan status tersebut.  
3. Jika tidak ada hasil, tampilkan state kosong.

On 'Update'  
1. Ketika user menekan “Lanjutkan Pembayaran”, ambil ID pesanan terkait.  
2. Ambil data pembayaran terbaru (token Midtrans) jika status masih pending.  
3. Redirect ke halaman pembayaran untuk menyelesaikan transaksi.

---

## 8. Order Detail Page
Deskripsi: Halaman detail pesanan menampilkan ringkasan pesanan (tanggal, status, timeline), daftar item lengkap dengan catatan, panel ringkasan total + metode pembayaran, serta tombol “Download Nota (PDF)” dan link kembali ke daftar pesanan.

Input: Tombol “Download Nota (PDF)”, tautan “Kembali ke Daftar Pesanan”.

Output: Timeline status, rincian tiap item, informasi pembayaran, file PDF saat unduh nota.

Method/Algoritma:  
On 'Get'  
1. Baca ID pesanan dari route.  
2. Ambil data pesanan, detail item, dan informasi pembayaran.  
3. Render timeline status, daftar item, dan ringkasan biaya.

On 'Find'  
1. Ketika tombol “Download Nota” ditekan, cari kembali data pesanan.  
2. Bangun template PDF dan kirim ke browser untuk diunduh.

---

## 9. Payment Page
Deskripsi: Halaman pembayaran menampilkan ringkasan order, instruksi mode sandbox Midtrans (nomor kartu uji), tombol “Bayar Sekarang” yang memunculkan widget Snap, serta link kembali ke keranjang.

Input: Tombol “Bayar Sekarang” (memicu Snap), tombol “Kembali ke Keranjang”.

Output: Widget Snap Midtrans, notifikasi sukses/gagal/pending, pengosongan keranjang setelah pembayaran berhasil.

Method/Algoritma:  
On 'Get'  
1. Validasi order dan token Snap.  
2. Render halaman dengan info order, instruksi testing, dan tombol bayar.

On 'Entry'  
1. Saat “Bayar Sekarang” ditekan, panggil fungsi pembayaran Snap dengan token.  
2. Tangani callback callback onSuccess/onPending/onError/onClose.  
3. Pada sukses, hapus keranjang dan arahkan ke halaman riwayat pesanan.

On 'Update'  
1. Jika pengguna menutup widget, panggil endpoint refresh token.  
2. Perbarui token Snap agar tombol bisa dipakai ulang.

---

## 10. Review Create Page
Deskripsi: Halaman tambah review memiliki hero “Write a Review”, kartu highlight menu (jika datang dari halaman menu), rating bintang interaktif, textarea komentar dengan counter, serta tombol “Kirim Review”.

Input: Dropdown menu (jika perlu), rating 1–5, komentar (opsional), tombol “Kirim Review”.

Output: Validasi error bila rating kosong, pesan sukses setelah submit, dan redirect sesuai rute.

Method/Algoritma:  
On 'Get'  
1. Jika dipanggil dengan ID menu, ambil detail menu untuk kartu highlight.  
2. Render form rating dan komentar.

On 'Entry'  
1. Ambil ID menu, rating, komentar.  
2. Validasi rating serta panjang komentar.  
3. Simpan review lalu tampilkan pesan sukses atau error validasi.

---

## 11. Profile Page
Deskripsi: Halaman profil menampilkan tiga kartu vertikal: form informasi profil (nama, email, telepon, alamat) lengkap dengan kirim ulang verifikasi email; form ubah password tiga field; serta form hapus akun dengan peringatan.

Input: Field nama/email/telepon/alamat, tombol “Simpan”, field password lama/baru/konfirmasi, tombol “Hapus Akun”.

Output: SweetAlert untuk simpan profil, toast sukses/gagal dari sesi, akun terhapus saat konfirmasi.

Method/Algoritma:  
On 'Get'  
1. Ambil data user dan status verifikasi email.  
2. Render tiga kartu form beserta status pesan sesi.

On 'Update'  
1. Ketika form profil disubmit, validasi input lalu simpan via endpoint pembaruan profil.  
2. Ketika form password disubmit, pastikan password lama benar dan simpan yang baru.

On 'Delete'  
1. Saat form hapus akun dikirim, verifikasi password konfirmasi.  
2. Jika valid, hapus user dan logout lalu arahkan ke landing.

---

## 12. Login Page
Deskripsi: Halaman login berisi judul “Selamat Datang”, form email, password dengan tombol lihat/sembunyi icon mata, checkbox “Ingat saya”, link “Lupa kata sandi?”, tombol “Daftar”, dan tombol “Masuk”.

Input: Field email, field password, checkbox remember, link lupa password, tombol daftar, tombol masuk.

Output: Validasi field, pesan error jika login gagal, redirect ke dashboard/home jika berhasil.

Method/Algoritma:  
On 'Get'  
1. Render form login dengan status session jika ada.  
2. Jika user sudah login, bisa diarahkan ke halaman utama.

On 'Entry'  
1. Ambil email, password, dan pilihan “remember me”.  
2. Jalankan fungsi Auth::attempt.  
3. Bila berhasil, buat sesi + redirect; bila gagal kembalikan dengan error.

---

## 13. Register Page
Deskripsi: Halaman register memuat judul “Buat Akun Baru”, field nama, email, telepon opsional, textarea alamat, dua field password dengan toggle tampil/sembunyi (Alpine), link “Sudah terdaftar?”, serta tombol “Daftar” dengan indikator loading.

Input: Nama, email, telepon, alamat, password, konfirmasi password, tombol daftar.

Output: Validasi per field, pesan error bila gagal, redireksi ke halaman verifikasi bila sukses.

Method/Algoritma:  
On 'Get'  
1. Render form registrasi kosong beserta CSRF token.  
2. Tampilkan error sebelumnya jika ada.

On 'Entry'  
1. Validasi semua field (email unik, password konfirmasi).  
2. Simpan user baru, kirim email verifikasi.  
3. Redirect ke halaman verifikasi email.

---

## 14. Forgot Password Page
Deskripsi: Halaman lupa password menampilkan judul “Lupa Kata Sandi”, satu field email, tombol “Kirim Link Reset”, serta link “Kembali ke Login”.

Input: Field email, tombol kirim link, link kembali.

Output: Pesan sukses ketika link reset dikirim atau error jika email tidak dikenal.

Method/Algoritma:  
On 'Get'  
1. Render form dengan penjelasan ringkas.  
2. Tampilkan pesan status jika request sebelumnya sukses.

On 'Entry'  
1. Validasi email.  
2. Jika valid dan terdaftar, buat token reset dan kirim email.  
3. Kembalikan dengan status sukses atau error.

---

## 15. Reset Password Page
Deskripsi: Halaman reset password berisi form untuk menetapkan password baru melalui tautan reset yang dikirim via email.

Input: Email (readonly/hidden), password baru, konfirmasi password, tombol reset.

Output: Pesan sukses dan tombol kembali login.

Method/Algoritma:  
On 'Get'  
1. Validasi token reset dari URL.  
2. Jika valid, tampilkan form penggantian password; jika tidak, tampilkan pesan token tidak berlaku.

On 'Entry'  
1. Ambil password baru dan konfirmasi.  
2. Validasi kekuatan password dan kecocokan.  
3. Simpan password baru lalu nonaktifkan token reset.  
4. Tampilkan notifikasi sukses dan tautan ke login.

---

## 16. Verify Email Page
Deskripsi: Halaman verifikasi email menampilkan informasi setelah registrasi dan menyediakan tombol untuk mengirim ulang tautan verifikasi atau keluar.

Input: Tombol “Kirim Ulang Email Verifikasi”, tombol “Keluar”.

Output: Pesan konfirmasi bahwa email verifikasi dikirim ulang atau limit rate.

Method/Algoritma:  
On 'Get'  
1. Periksa status verifikasi user.  
2. Jika belum terverifikasi, tampilkan instruksi pengecekan email.

On 'Entry'  
1. Saat “Kirim Ulang” ditekan, pastikan belum melewati batas pengiriman ulang.  
2. Buat token verifikasi baru.  
3. Kirim email verifikasi dan tampilkan pesan sukses.  
4. Jika limit tercapai, tampilkan pesan tunggu.

---

## 17. Confirm Password Page
Deskripsi: Halaman konfirmasi password muncul sebelum mengakses area sensitif dan meminta pengguna memasukkan password saat ini.

Input: Password, tombol “Konfirmasi”.

Output: Pesan sukses dan akses lanjut, atau pesan kesalahan.

Method/Algoritma:  
On 'Get'  
1. Pastikan user sudah login.  
2. Tampilkan form konfirmasi password.

On 'Entry'  
1. Ambil password yang dimasukkan.  
2. Verifikasi dengan kredensial user.  
3. Jika cocok, set flag session confirmed_at dan redirect; jika tidak, tampilkan error.

---

## 18. Review Show (Detail) Page
Deskripsi: Halaman halaman detail review menampilkan dua panel: informasi menu (nama, deskripsi, harga, kategori) dan informasi review (rating bintang, status moderasi, penulis, tanggal, komentar). Bagian bawah berisi tombol kembali serta opsi edit/hapus jika user berwenang.

Input: Tombol “Kembali ke Review”, tombol “Ubah Review” (jika diizinkan), tombol “Hapus Review”.

Output: Detail review dan menu terkait, badge status, pesan konfirmasi saat hapus.

Method/Algoritma:  
On 'Get'  
1. Ambil ID review dari route.  
2. Muat relasi menu dan user.  
3. Render data ke dua panel informasi.

On 'Delete'  
1. Saat tombol “Hapus Review” disubmit, verifikasi hak akses pengguna.  
2. Hapus review dan redirect dengan pesan sukses.

---

## 19. Invoice Page
Deskripsi: Halaman invoice menghasilkan nota PDF berisi identitas restoran, detail pesanan/pelanggan, tabel item, ringkasan total, dan catatan pembayaran.

Input: Tidak ada interaksi langsung; file dipanggil saat user memilih “Download Nota”.

Output: Dokumen PDF siap unduh/cetak yang menampilkan seluruh rincian order.

Method/Algoritma:  
On 'Get'  
1. Ambil data pesanan, user, detail item, dan pembayaran.  
2. Sisipkan data ke template HTML/PDF.  
3. Kembalikan sebagai file yang dapat diunduh user.

---

## 20. Empty Cart State
Deskripsi: State kosong pada halaman keranjang menampilkan ilustrasi ikon keranjang, pesan “Keranjang Kosong”, dan tombol “Mulai Belanja” yang mengarah ke daftar menu.

Input: Tombol “Mulai Belanja”.

Output: Pesan motivasi untuk menambah item dan navigasi ke halaman menu.

Method/Algoritma:  
On 'Get'  
1. Jika koleksi keranjang kosong, render blok empty-state.  
2. Sembunyikan daftar item/ringkasan.

On 'Entry'  
1. Saat tombol “Mulai Belanja” ditekan, arahkan user ke halaman menu.

---

## 21. Modals & Confirmations
Deskripsi: Komponen modal & konfirmasi mencakup (a) modal “Tambah ke Keranjang” di halaman menu dan detail menu, serta (b) SweetAlert konfirmasi pada keranjang/checkout.

Input: Modal add-to-cart: field jumlah, catatan, tombol “Tambah/Batal”. SweetAlert checkout: tombol “Ya, Checkout!” atau “Batal”.

Output: Penambahan item ke keranjang atau batal; konfirmasi sebelum membuat order; pesan keberhasilan/gagal.

Method/Algoritma:  
On 'Get'  
1. Ketika user klik “Add to Cart”, tampilkan modal berisi jumlah & catatan.  
2. Saat user klik “Checkout”, munculkan SweetAlert konfirmasi.

On 'Entry'  
1. Jika form modal disubmit, kirim data ke endpoint endpoint tambah keranjang, lalu tampilkan notifikasi dan tutup modal.  
2. Jika checkout dikonfirmasi di SweetAlert, panggil endpoint endpoint pembuatan pesanan dan lanjutkan alur pembayaran.  
3. Jika pengguna memilih batal, cukup tutup modal/alert tanpa perubahan.

---

Dokumen ini dapat diperbarui bila ada perubahan flow atau penambahan halaman baru pada wireframe.

