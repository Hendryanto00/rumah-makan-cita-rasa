# 3.4 Kebutuhan Non-Fungsional

Pada bagian kebutuhan non-fungsional ini, dijelaskan aspek kualitas dan batasan teknis dari sistem Rumah Makan Cita Rasa. Berbeda dengan kebutuhan fungsional yang menekankan apa yang dapat dilakukan sistem, kebutuhan non-fungsional menekankan bagaimana sistem beroperasi secara optimal. Kebutuhan pada bagian ini mencakup aspek security, maintainability, usability, portability, dan scalability.

## 3.4.1 Security

ID Requirement : NFR 3.4.1.1
Deskripsi : Sistem menggunakan autentikasi berbasis sesi (session cookie) dengan atribut HttpOnly dan SameSite, serta batas masa berlaku sesi maksimum 24 jam idle timeout.
Rasional : Menjamin hanya pengguna sah yang memiliki akses, meminimalkan risiko pencurian token pada browser, dan membatasi masa aktif sesi.

ID Requirement : NFR 3.4.1.2
Deskripsi : Sistem menerapkan Cross-Site Request Forgery (CSRF) token pada seluruh form/aksi yang dapat mengubah data.
Rasional : Melindungi sistem dari serangan CSRF pada request yang memodifikasi data.

ID Requirement : NFR 3.4.1.3
Deskripsi : Sistem menerapkan role-based access control (RBAC) dengan peran: owner, admin, dan pelanggan; setiap endpoint/fitur divalidasi terhadap peran.
Rasional : Membatasi hak akses sesuai tanggung jawab pengguna dan mencegah eskalasi hak akses.

ID Requirement : NFR 3.4.1.4
Deskripsi : Password disimpan menggunakan algoritma hashing kuat (Argon2id atau bcrypt dengan cost memadai) dan tidak pernah disimpan dalam bentuk plaintext.
Rasional : Melindungi kredensial pengguna apabila terjadi kebocoran data.

ID Requirement : NFR 3.4.1.5
Deskripsi : Sistem menerapkan rate limiting pada endpoint sensitif (login, reset password) minimal 5 percobaan per menit per IP/user dengan backoff.
Rasional : Mengurangi risiko brute force dan penyalahgunaan endpoint autentikasi.

ID Requirement : NFR 3.4.1.6
Deskripsi : Validasi server-side wajib untuk seluruh input pengguna, termasuk panjang, format, enumerasi nilai, dan sanitasi.
Rasional : Mencegah injeksi, XSS, dan korupsi data melalui input yang tidak tervalidasi.

ID Requirement : NFR 3.4.1.7
Deskripsi : Sistem mencatat audit log untuk aksi penting (login, CRUD menu/kategori, perubahan status pesanan/pembayaran, manajemen role).
Rasional : Mendukung keperluan audit, forensik insiden, dan akuntabilitas perubahan.

ID Requirement : NFR 3.4.1.8
Deskripsi : Komunikasi jaringan harus menggunakan HTTPS/TLS 1.2+; kredensial dan token tidak pernah terlihat pada URL/log.
Rasional : Menjaga kerahasiaan dan integritas data selama transmisi.

## 3.4.2 Maintainability

ID Requirement : NFR 3.4.2.1
Deskripsi : Sistem dibangun berbasis komponen yang dapat digunakan ulang (reusable), dengan pemisahan lapisan (controller, service, model) yang jelas.
Rasional : Memudahkan pemeliharaan, pengujian, dan pengembangan berkelanjutan.

ID Requirement : NFR 3.4.2.2
Deskripsi : Kode mengikuti standar gaya penulisan (PSR-12) dan praktik terbaik framework; dokumentasi teknis minimal untuk modul inti.
Rasional : Meningkatkan konsistensi dan keterbacaan kode antar pengembang.

ID Requirement : NFR 3.4.2.3
Deskripsi : Tersedia pengujian otomatis minimal pada modul inti (auth, pesanan, pembayaran) dengan target cakupan 60–80% untuk fungsi kritikal.
Rasional : Mengurangi regresi saat perubahan fitur dan memvalidasi perilaku sistem.

ID Requirement : NFR 3.4.2.4
Deskripsi : Konfigurasi dipisahkan melalui variabel lingkungan (.env) untuk kredensial, database, email, dan Midtrans.
Rasional : Memudahkan pengelolaan konfigurasi lintas lingkungan (dev/stage/prod) tanpa ubah kode.

ID Requirement : NFR 3.4.2.5
Deskripsi : Skema basis data dikelola melalui migrasi terverifikasi dan backward-compatible saat memungkinkan.
Rasional : Menjamin konsistensi skema pada berbagai lingkungan dan memudahkan rollback.

## 3.4.3 Usability

ID Requirement : NFR 3.4.3.1
Deskripsi : Proses checkout dirancang ringkas (maksimum 3–4 langkah): keranjang → alamat/opsional → pembayaran → konfirmasi.
Rasional : Mengurangi friksi pengguna agar konversi pemesanan meningkat.

ID Requirement : NFR 3.4.3.2
Deskripsi : Antarmuka responsif dan konsisten (komponen, tipografi, warna) serta mendukung aksesibilitas dasar (kontras, label form, fokus jelas).
Rasional : Memudahkan penggunaan oleh berbagai profil pengguna dan perangkat.

ID Requirement : NFR 3.4.3.3
Deskripsi : Waktu muat halaman utama dan daftar menu memiliki Largest Contentful Paint (LCP) < 2.5 detik pada koneksi setara 4G, perangkat kelas menengah.
Rasional : Menjaga performa persepsi pengguna dan menurunkan bounce rate.

ID Requirement : NFR 3.4.3.4
Deskripsi : Pesan kesalahan dan keberhasilan harus jelas, spesifik, dan kontekstual di dekat elemen input.
Rasional : Membantu pengguna memperbaiki kesalahan dengan cepat.

## 3.4.4 Portability

ID Requirement : NFR 3.4.4.1
Deskripsi : Sistem dapat diakses pada browser modern (Chrome, Edge, Safari) versi 2 tahun terakhir.
Rasional : Memastikan kompatibilitas lintas platform untuk mayoritas pengguna.

ID Requirement : NFR 3.4.4.2
Deskripsi : Antarmuka responsif mendukung mobile dan desktop tanpa kehilangan fungsi.
Rasional : Memastikan pengalaman yang baik pada berbagai ukuran layar.

ID Requirement : NFR 3.4.4.3
Deskripsi : Aplikasi dapat dijalankan di berbagai lingkungan (Windows/Linux) dengan dependensi yang terdokumentasi, dan opsional kontainerisasi.
Rasional : Mempermudah deployment dan replikasi lingkungan.

## 3.4.5 Scalability

ID Requirement : NFR 3.4.5.1
Deskripsi : Aplikasi bersifat stateless pada layer web; sesi disimpan pada penyimpanan terpusat (mis. Redis/DB) untuk mendukung skala horizontal.
Rasional : Memungkinkan penambahan instance aplikasi tanpa perubahan arsitektur utama.

ID Requirement : NFR 3.4.5.2
Deskripsi : Proses intensif (pengiriman email, sinkronisasi pembayaran Midtrans, pembuatan PDF) dijalankan melalui antrean (queue) dan worker terpisah.
Rasional : Mengurangi beban request sinkron dan meningkatkan throughput.

ID Requirement : NFR 3.4.5.3
Deskripsi : Endpoints daftar (menu, pesanan, review) wajib paginasi dan memiliki indeks basis data pada kolom pencarian/relasi umum.
Rasional : Menjaga performa kueri saat volume data meningkat.

ID Requirement : NFR 3.4.5.4
Deskripsi : Sistem mampu menangani peningkatan pengguna aktif bersamaan hingga ambang yang ditetapkan (mis. 5–10×) dengan penyesuaian sumber daya.
Rasional : Menjamin sistem tetap responsif saat ada peningkatan trafik musiman/promosi.


