# Deskripsi Wireframe Admin Rumah Makan Cita Rasa

Dokumen ini menjelaskan setiap halaman backoffice (admin) yang tercantum pada `docs/wireframes-admin-bw.html`. Struktur yang digunakan: **Deskripsi**, **Input**, **Output**, dan **Method/Algoritma**.

Catan Sidebar & Pola Modal:  
- Semua halaman admin menampilkan sidebar kiri berisi menu (Profil, Dashboard, Kelola Menu, Kelola Pesanan, Kelola Kategori, Kelola Review, Statistik Review). Item aktif diberi latar lebih gelap untuk menegaskan halaman yang sedang dibuka.  
- Pola Modal:  
A. Modal konfirmasi berkode (hapus akun) – sesuai wireframe bagian 14A.  
B. Modal SweetAlert hapus – digunakan saat menghapus data (kategori, menu, review).  
C. Modal SweetAlert simpan – digunakan sebelum menyimpan form atau memperbarui status.

---

## 1. Dashboard Admin
Deskripsi: Menampilkan hero ucapan selamat datang, grid aksi cepat (profil, kategori, menu, review, statistik), ringkasan status pesanan (pending, paid, diproses, selesai, batal), tabel pesanan terbaru, blok stok menipis, serta kartu menu terlaris.

Input: Klik pada kartu aksi cepat, tautan "Lihat Semua", tombol menuju daftar pesanan/menu.

Output: Angka status pesanan, tabel pesanan terbaru (dengan versi mobile), daftar menu stok rendah, ringkasan menu terlaris.

Method/Algoritma:  
On 'Get'  
1. Ambil data pengguna login, tanggal hari ini, dan angka ringkasan (status, pesanan terbaru, stok menipis, menu terlaris).  
2. Render hero, quick action, kartu status, dua tabel, serta grid menu terlaris.  
3. Sediakan tautan ke modul terkait.

---

## 2. Daftar Kategori
Deskripsi: Tabel daftar kategori dengan tombol tambah, pencarian nama/deskripsi, filter kategori yang sudah atau belum memiliki menu, tampilan versi desktop dan kartu mobile, serta sweetalert saat hapus.

Input: Field pencarian, dropdown filter, tombol "Cari", tombol "Tambah Kategori", tombol aksi "Edit/Hapus".

Output: Tabel kategori (nama, deskripsi, jumlah menu, aksi), kartu mobile, indikator kosong jika tidak ada data, pesan sukses/error melalui SweetAlert. Hapus kategori memakai modal tipe B.

Method/Algoritma:  
On 'Get'  
1. Ambil daftar kategori beserta jumlah menu.  
2. Tampilkan header, form filter, tabel desktop, kartu mobile, dan pagination.  
3. Jika tidak ada data, tampilkan empty state dengan ikon dan tombol tambah kategori.

On 'Find'  
1. Baca parameter pencarian atau filter.  
2. Terapkan query sesuai filter dan reload tabel.  
3. Jika hasil kosong, tampilkan pesan "Tidak ada kategori".

On 'Delete'  
1. Ketika tombol hapus diklik, tampilkan modal SweetAlert dengan nama kategori.  
2. Jika kategori memiliki menu, tampilkan pesan error.  
3. Jika tidak ada menu dan admin menekan konfirmasi, submit form DELETE dan perbarui tabel.

---

## 3. Form Tambah Kategori
Deskripsi: Form tambah kategori yang terdiri dari field nama wajib, deskripsi opsional, tombol Batal, dan tombol Simpan. Validasi ditampilkan di bawah field sesuai kebutuhan.

Input: Field nama kategori, field deskripsi, tombol Simpan/Batal.

Output: Pesan validasi per field dan SweetAlert keberhasilan atau error setelah submit (menggunakan modal tipe C).

Method/Algoritma:  
On 'Get'  
1. Tampilkan form kosong.  
2. Jika ada error sebelumnya, tampilkan di bawah field.

On 'Entry'  
1. Validasi field wajib.  
2. Simpan kategori baru ke database.  
3. Redirect ke daftar kategori dengan notifikasi sukses.

---

## 4. Form Edit Kategori
Deskripsi: Form edit dengan peringatan saat kategori memiliki menu. Admin bisa memilih menu untuk dipindahkan memakai checkbox, tombol “Pilih Semua”/“Batal Pilih”, dan dropdown tujuan sebelum menyimpan perubahan nama/deskripsi.

Input: Field nama kategori, field deskripsi, daftar checkbox menu, tombol pilih semua/batal, dropdown kategori tujuan, tombol Simpan/Batal.

Output: Validasi field, pesan status pemindahan menu, dan notifikasi setelah data tersimpan. Simpan perubahan memakai modal tipe C.

Method/Algoritma:  
On 'Get'  
1. Ambil data kategori beserta daftar menu yang terikat.  
2. Prefill nama dan deskripsi, tampilkan panel peringatan jika menu > 0.  
3. Render daftar checkbox dan dropdown tujuan.

On 'Update'  
1. Simpan perubahan nama/deskripsi.  
2. Jika admin menandai menu dan memilih tujuan, pindahkan menu tersebut, lalu tampilkan pesan sukses.  
3. Kembalikan ke daftar kategori dengan notifikasi.

---

## 5. Daftar Menu
Deskripsi: Halaman listing menu dengan tombol tambah, kolom pencarian, filter kategori dan status, tabel desktop (gambar, harga, stok, status, aksi), kartu mobile, serta empty state.

Input: Field pencarian, dropdown kategori, dropdown status, tombol Cari, tombol "Tambah Menu", tombol Edit/Hapus.

Output: Tabel menu, badge status (Aktif/Nonaktif), pesan jika tidak ada hasil, pagination, dan notifikasi ketika aksi berhasil atau gagal. Tombol Hapus memunculkan modal tipe B.

Method/Algoritma:  
On 'Get'  
1. Ambil menu beserta kategori, stok, status, dan gambar pratinjau.  
2. Render filter, tabel desktop, kartu mobile, serta pagination.

On 'Find'  
1. Terapkan filter pencarian, kategori, dan status.  
2. Reload tabel dengan parameter yang diminta.

On 'Delete'  
1. Saat tombol hapus diklik, tampilkan SweetAlert konfirmasi.  
2. Jika dikonfirmasi, kirim form DELETE dan tampilkan notifikasi hasil.

---

## 6. Form Tambah Menu
Deskripsi: Form dua kolom untuk menambah menu baru berisi nama, kategori pilihan, harga, stok, deskripsi, pratinjau dan upload gambar, serta checkbox "Aktifkan menu". Ada tombol Batal dan Simpan.

Input: Field nama, dropdown kategori, harga, stok, textarea deskripsi, upload foto, checkbox aktif, tombol Simpan/Batal.

Output: Pratinjau gambar (jika file dipilih), validasi field, dan konfirmasi SweetAlert tipe C saat submit.

Method/Algoritma:  
On 'Get'  
1. Tampilkan form kosong saat tambah, atau isi data saat edit.  
2. Sediakan pratinjau gambar default.

On 'Entry'  
1. Validasi semua field wajib dan tipe file foto.  
2. Simpan/update data ke database.  
3. Tampilkan SweetAlert bahwa menu berhasil disimpan lalu kembali ke daftar menu.

---

## 7. Form Edit Menu
Deskripsi: Form edit menampilkan data menu saat ini, pratinjau gambar lama, upload gambar baru opsional, textarea deskripsi, serta checkbox status aktif. Tombol yang disediakan: Batal dan Simpan Perubahan.

Input: Field nama/kategori/harga/stok/deskripsi, upload gambar baru, checkbox aktif, tombol Simpan/Batal.

Output: Pratinjau gambar terbaru jika diganti, validasi field, dan SweetAlert tipe C sebelum menyimpan.

Method/Algoritma:  
On 'Get'  
1. Prefill seluruh field dari menu terpilih dan tampilkan gambar saat ini.  
2. Set checkbox sesuai status `is_active`.

On 'Update'  
1. Saat submit, munculkan SweetAlert untuk konfirmasi penyimpanan.  
2. Jika disetujui, simpan perubahan (termasuk file baru bila ada) dan arahkan kembali ke daftar menu dengan notifikasi.

---

## 8. Daftar Pesanan
Deskripsi: Tabel daftar pesanan dengan pencarian ID/nama/email, filter status, badge status, dan tombol menuju detail. Versi mobile memakai kartu. Empty state menampilkan ikon keranjang.

Input: Field pencarian, dropdown status, tombol Cari, tautan "Detail".

Output: Tabel pesanan, kartu mobile, pagination, notifikasi sukses/error dari session.

Method/Algoritma:  
On 'Get'  
1. Ambil daftar pesanan termasuk user dan ringkasan items.  
2. Tampilkan filter, tabel desktop, kartu mobile, dan pagination.

On 'Find'  
1. Terapkan pencarian atau filter status.  
2. Render ulang tabel sesuai parameter.

---

## 9. Detail Pesanan
Deskripsi: Menampilkan header dengan ID pesanan dan status, timeline status (pending→selesai/batal), informasi pelanggan, tabel item, panel pembayaran, ringkasan total, form update status, dan tombol download nota.

Input: Tombol kembali, dropdown update status, tombol Simpan, tombol unduh nota PDF.

Output: Detail lengkap pesanan, badge status, daftar item dengan catatan, informasi pembayaran, ringkasan total, SweetAlert tipe C ketika status diperbarui.

Method/Algoritma:  
On 'Get'  
1. Ambil data order, detail item, user, dan pembayaran.  
2. Render timeline, panel informasi, tabel item, ringkasan, dan tombol aksi.

On 'Update'  
1. Ketika admin mengganti status, validasi nilai dropdown.  
2. Simpan perubahan dan tampilkan notifikasi sukses.

On 'Entry'  
1. Saat tombol unduh nota ditekan, buat PDF invoice dari data order.  
2. Kirim file ke browser untuk diunduh.

---

## 10. Daftar Review
Deskripsi: Ada kartu ringkasan (total/menunggu/disetujui/disembunyikan), filter pencarian + status, dropdown aksi massal, tabel desktop dengan checkbox, versi mobile card, serta tombol tindakan (Lihat, Setujui, Sembunyikan, Tampilkan, Tolak).

Input: Field pencarian, dropdown status, dropdown aksi massal, checkbox per review, tombol Lihat/Setujui/Sembunyikan/Tolak.

Output: Tabel review, kartu mobile, badge status, hasil aksi massal, notifikasi SweetAlert untuk approve/hide/reject. Tolak memakai modal tipe B, aksi Setujui/Sembunyikan/Tampilkan memakai modal tipe C.

Method/Algoritma:  
On 'Get'  
1. Ambil daftar review beserta user, menu, status, dan rating.  
2. Hitung statistik untuk kartu ringkasan.  
3. Render tabel desktop, kartu mobile, dan pagination.

On 'Find'  
1. Terapkan pencarian teks dan filter status.  
2. Reload daftar review sesuai parameter.

On 'Update'  
1. Saat lakukan aksi massal atau tombol Setujui/Sembunyikan/Tampilkan, jalankan perubahan status yang diminta.  
2. Tampilkan notifikasi hasil.

On 'Delete'  
1. Saat tombol Tolak diklik, tampilkan SweetAlert konfirmasi.  
2. Jika disetujui, hapus review dan tampilkan pesan sukses.

---

## 11. Detail Review
Deskripsi: Menampilkan panel informasi review (rating, status, tanggal, komentar), panel pengguna (nama, email, total review), panel menu (nama, kategori, harga, status, deskripsi), serta deretan tombol aksi (Setujui, Sembunyikan/Tampilkan, Tolak).

Input: Tombol Kembali, tombol Setujui, tombol Sembunyikan/Tampilkan, tombol Tolak.

Output: Informasi lengkap review, status saat ini, hasil SweetAlert setelah aksi (modal tipe C untuk Setujui/Sembunyikan, tipe B untuk Tolak).

Method/Algoritma:  
On 'Get'  
1. Ambil data review termasuk relasi user dan menu.  
2. Render panel informasi dan tombol tindakan.

On 'Update'  
1. Ketika admin menekan Setujui/Sembunyikan/Tampilkan, tampilkan SweetAlert dan ubah status sesuai pilihan.  
2. Redirect kembali dengan pesan sukses.

On 'Delete'  
1. Saat tombol Tolak diklik, konfirmasi melalui SweetAlert.  
2. Jika disetujui, hapus review dari sistem.

---

## 12. Statistik Review
Deskripsi: Halaman metrik yang menampilkan kartu ringkasan (total review, disetujui, rata-rata rating, pending), distribusi bintang, tren penilaian 6 bulan terakhir, daftar menu terpopuler, dan blok review per status.

Input: Tidak ada input selain navigasi.

Output: Angka total, persentase distribusi bintang, daftar tren bulanan, ranking menu favorit, jumlah review per status.

Method/Algoritma:  
On 'Get'  
1. Kumpulkan data agregat (total, approved, pending, hidden, average rating).  
2. Hitung distribusi bintang dan tren rata-rata per bulan.  
3. Ambil menu dengan rating tertinggi.  
4. Render semua kartu dan grafik low-fidelity.

---

## 13. Profil Admin
Deskripsi: Dua kartu utama: (1) form informasi profil (nama, email, telepon, alamat) dengan tombol Simpan dan konfirmasi SweetAlert; (2) form ubah kata sandi berisi tiga field dengan tombol toggle mata serta tombol Simpan Kata Sandi. Catatan untuk hapus akun diarahkan ke pola modal terpisah pada bagian Modal Konfirmasi.

Input: Field nama/email/telepon/alamat, tombol Simpan; field password lama/baru/konfirmasi, tombol “Ubah Password”.

Output: Validasi per field, notifikasi SweetAlert sukses atau error (modal tipe C), info email verifikasi, serta catatan bahwa hapus akun memakai modal tipe A.

Method/Algoritma:  
On 'Get'  
1. Tampilkan data admin saat ini beserta status verifikasi email.  
2. Render dua kartu form secara vertikal agar responsif.

On 'Update'  
1. Saat form profil disubmit, tampilkan SweetAlert konfirmasi, lalu simpan perubahan dan kirim notifikasi.  
2. Saat form password disubmit, verifikasi password lama, simpan password baru, dan tampilkan pesan sukses.

---

## 14. Pola Modal
Deskripsi: Bagian referensi untuk tiga tipe modal: (A) konfirmasi berkode dengan judul kapital + field kode “HAPUS”; (B) SweetAlert hapus dengan ikon seru, teks “Hapus menu ini?”, tombol merah “Ya, hapus” dan tombol abu “Batal”; (C) SweetAlert simpan dengan ikon tanda tanya, teks “Simpan perubahan ...?”, tombol oranye “Ya, simpan” dan tombol abu “Batal”.

Input: Tombol tutup/Batal/Konfirmasi, serta field teks kode (khusus tipe A).

Output: Visual panduan untuk modal yang dipanggil dari halaman lain: A untuk hapus akun, B untuk aksi delete data, C untuk konfirmasi penyimpanan.

Method/Algoritma:  
On 'Get'  
1. Tampilkan pola modal yang sesuai ketika aksi diminta (hapus atau simpan).  
2. Fokuskan kursor ke field kode pada tipe A.

On 'Entry'  
1. Jika tombol konfirmasi ditekan (dan kode valid pada tipe A), jalankan aksi delete/simpan sesuai konteks.  
2. Tutup modal jika pengguna memilih Batal atau ikon X.

