# Deskripsi Wireframe Owner Rumah Makan Cita Rasa

Dokumen ini menjelaskan setiap halaman backoffice (owner) yang tercantum pada `docs/wireframes-owner-bw.html`. Struktur yang digunakan: **Deskripsi**, **Input**, **Output**, dan **Method/Algoritma**.

**Catatan Sidebar & Pola Modal:**
- Semua halaman owner menampilkan sidebar kiri dengan menu navigasi (Profil, Dashboard, Laporan Harian, Laporan Bulanan, Laporan Menu Terlaris, Laporan Aktivitas) dan tombol Logout di bagian bawah.
- Menu aktif ditandai dengan background lebih gelap untuk menunjukkan halaman yang sedang diakses.
- Modal konfirmasi menggunakan pola yang sama dengan admin: modal tipe C untuk konfirmasi simpan, modal tipe D untuk konfirmasi hapus sederhana.

---

## 1. Dashboard Owner
Deskripsi: Halaman utama owner menampilkan header dengan ucapan selamat datang, metrik utama (total pendapatan, pendapatan hari ini, pendapatan bulan ini dengan persentase pertumbuhan, total pesanan), metrik tambahan (total pelanggan, rata-rata nilai pesanan, rating rata-rata), dua grafik tren penjualan (7 hari terakhir dan 6 bulan), serta ringkasan status pesanan.

Input: Klik pada menu sidebar, navigasi ke halaman laporan atau profil.

Output: Angka metrik utama dan tambahan, grafik tren penjualan, ringkasan status pesanan dengan jumlah per status.

Method/Algoritma:  
On 'Get'  
1. Ambil data pengguna login, tanggal hari ini, dan semua metrik (pendapatan total/hari/bulan, total pesanan, pelanggan, rating, status pesanan).  
2. Hitung persentase pertumbuhan pendapatan bulan ini vs bulan lalu.  
3. Ambil data tren penjualan 7 hari terakhir dan 6 bulan terakhir untuk grafik.  
4. Render header, kartu metrik, grafik, dan ringkasan status pesanan.  
5. Sediakan tautan ke modul laporan dan profil.

---

## 2. Laporan Harian Penjualan
Deskripsi: Halaman laporan harian berisi header dengan judul dan tanggal laporan, form filter tanggal, kartu ringkasan (total pesanan, total omzet, total pelanggan, rata-rata pesanan), tabel menu populer hari ini dengan kolom rank, menu, kategori, terjual, dan omzet, serta tombol download PDF.

Input: Field tanggal dengan ikon kalender, tombol Filter, submenu Download PDF di sidebar.

Output: Ringkasan angka harian, tabel menu populer, file PDF laporan harian jika diunduh melalui submenu sidebar, pesan jika tidak ada data.

Method/Algoritma:  
On 'Get'  
1. Ambil data penjualan untuk tanggal yang dipilih (default: hari ini).  
2. Hitung ringkasan (total pesanan, omzet, pelanggan unik, rata-rata pesanan).  
3. Ambil top 10 menu terlaris hari tersebut.  
4. Render header, form filter, kartu ringkasan, dan tabel menu populer.

On 'Find'  
1. Baca parameter tanggal dari form filter.  
2. Terapkan query untuk tanggal yang dipilih dan reload ringkasan serta tabel.  
3. Jika hasil kosong, tampilkan empty state.


1. Saat submenu Download PDF di sidebar ditekan, buat dokumen PDF laporan harian dari data yang ditampilkan.  
2. Kirim file ke browser untuk diunduh.

---

## 3. Laporan Bulanan Penjualan
Deskripsi: Halaman laporan bulanan memuat header dengan judul dan bulan laporan, form filter bulan, kartu ringkasan (total pesanan, total omzet, total pelanggan, rata-rata pesanan), grafik tren penjualan harian dalam bulan tersebut, tabel top 10 menu terlaris bulanan, serta tombol download PDF.

Input: Field bulan dengan ikon kalender, tombol Filter, submenu Download PDF di sidebar.

Output: Ringkasan angka bulanan, grafik tren harian, tabel menu terlaris, file PDF laporan bulanan jika diunduh melalui submenu sidebar.

Method/Algoritma:  
On 'Get'  
1. Ambil data penjualan untuk bulan yang dipilih (default: bulan ini).  
2. Hitung ringkasan bulanan (total pesanan, omzet, pelanggan, rata-rata pesanan).  
3. Ambil data tren penjualan per hari dalam bulan untuk grafik.  
4. Ambil top 10 menu terlaris bulan tersebut.  
5. Render header, form filter, kartu ringkasan, grafik, dan tabel menu.

On 'Find'  
1. Baca parameter bulan dari form filter.  
2. Terapkan query untuk bulan yang dipilih dan reload semua data.  
3. Render ulang grafik dan tabel sesuai periode.

On 'Entry'  
1. Saat submenu Download PDF di sidebar ditekan, buat dokumen PDF laporan bulanan lengkap dengan grafik dan tabel.  
2. Kirim file ke browser untuk diunduh.

---

## 4. Laporan Menu Terlaris
Deskripsi: Halaman laporan menu terlaris berisi header dengan judul, form filter periode (tanggal mulai dan akhir), tabel top 10 menu terlaris dengan kolom rank, menu, kategori, terjual, omzet, dan rata-rata rating, serta tombol download PDF.

Input: Field tanggal mulai dengan ikon kalender, field tanggal akhir dengan ikon kalender, tombol Filter, submenu Download PDF di sidebar.

Output: Tabel menu terlaris berdasarkan periode, file PDF laporan jika diunduh melalui submenu sidebar, pesan jika tidak ada data.

Method/Algoritma:  
On 'Get'  
1. Ambil data menu terlaris untuk periode default (misal: bulan ini).  
2. Hitung total terjual, omzet, dan rata-rata rating per menu.  
3. Urutkan berdasarkan jumlah terjual dan ambil top 10.  
4. Render header, form filter, dan tabel menu terlaris.

On 'Find'  
1. Baca parameter tanggal mulai dan akhir dari form filter.  
2. Validasi bahwa tanggal akhir tidak lebih awal dari tanggal mulai.  
3. Terapkan query untuk periode yang dipilih dan reload tabel.  
4. Jika hasil kosong, tampilkan empty state.

On 'Entry'  
1. Saat submenu Download PDF di sidebar ditekan, buat dokumen PDF laporan menu terlaris dengan tabel lengkap.  
2. Kirim file ke browser untuk diunduh.

---

## 5. Laporan Aktivitas Sistem
Deskripsi: Halaman laporan aktivitas sistem memuat header dengan judul dan total aktivitas, form filter (tanggal mulai, tanggal akhir, jenis aksi, tabel target, pengguna admin), dua kartu statistik (aktivitas berdasarkan aksi dan berdasarkan tabel), tabel daftar aktivitas dengan kolom waktu, pengguna, aksi, tabel, dan deskripsi, pagination, serta tombol download PDF.

Input: Field tanggal mulai dengan ikon kalender, field tanggal akhir dengan ikon kalender, dropdown jenis aksi (Semua Aksi, CREATE, UPDATE, DELETE), dropdown tabel target (Semua Tabel, menus, categories, orders), dropdown pengguna (Semua Pengguna, Admin A, Admin B), tombol Filter, submenu Download PDF di sidebar.

Output: Statistik aktivitas per aksi dan per tabel, tabel daftar aktivitas, file PDF laporan jika diunduh melalui submenu sidebar, pagination.

Method/Algoritma:  
On 'Get'  
1. Ambil daftar aktivitas sistem dengan filter default (misal: 30 hari terakhir).  
2. Hitung statistik aktivitas berdasarkan aksi (CREATE, UPDATE, DELETE) dan berdasarkan tabel target.  
3. Ambil daftar aksi, tabel, dan pengguna yang tersedia untuk dropdown filter.  
4. Render header, form filter, kartu statistik, dan tabel aktivitas dengan pagination.

On 'Find'  
1. Baca semua parameter filter dari form.  
2. Validasi tanggal mulai dan akhir.  
3. Terapkan query sesuai filter dan reload statistik serta tabel.  
4. Jika hasil kosong, tampilkan empty state.

On 'Entry'  
1. Saat submenu Download PDF di sidebar ditekan, buat dokumen PDF laporan aktivitas dengan statistik dan tabel lengkap.  
2. Kirim file ke browser untuk diunduh.

---

## 6. Profil Owner
Deskripsi: Halaman profil owner terdiri dari dua kartu utama: (1) form informasi profil berisi field nama, email, telepon, dan alamat dengan tombol Simpan serta konfirmasi SweetAlert (modal tipe C); (2) form ubah kata sandi memuat tiga field (password lama, baru, konfirmasi) dengan tombol toggle mata dan tombol Ubah Password.

Input: Field nama/email/telepon/alamat, tombol Simpan; field password lama/baru/konfirmasi, tombol toggle mata, tombol "Ubah Password".

Output: Validasi per field, notifikasi SweetAlert sukses atau error (modal tipe C), info email verifikasi jika belum terverifikasi.

Method/Algoritma:  
On 'Get'  
1. Tampilkan data owner saat ini beserta status verifikasi email.  
2. Render dua kartu form secara vertikal agar responsif.

On 'Update'  
1. Saat form profil disubmit, tampilkan SweetAlert konfirmasi (modal tipe C), lalu simpan perubahan dan kirim notifikasi.  
2. Saat form password disubmit, verifikasi password lama, simpan password baru, dan tampilkan pesan sukses.

---

