# Analisis Kebutuhan Sistem EventSphere

## 1. Gambaran Umum

EventSphere adalah sistem informasi penyelenggaraan event berbasis web yang menghubungkan
peserta dengan penyelenggara event. Sistem menyediakan katalog event publik, pendaftaran
peserta secara online dengan tiket digital, pengelolaan event oleh penyelenggara, serta
moderasi dan pelaporan oleh administrator.

Berdasarkan implementasi pada aplikasi Laravel, sistem memiliki tiga peran pengguna
(`admin`, `organizer`, `participant`) dan satu pengunjung publik yang belum login.

| Aspek | Keterangan |
| --- | --- |
| Nama sistem | EventSphere |
| Jenis aplikasi | Web application (server-side rendered) |
| Framework | Laravel 13, PHP 8.4 |
| Tampilan | Blade + Tailwind CSS 4 (tema gelap "Midnight Gold") |
| Basis data | MySQL / SQLite (Eloquent ORM) |
| Autentikasi | Session-based (Laravel Auth), role-based access control |
| Bahasa antarmuka | Bahasa Indonesia |

## 2. Aktor dan Hak Akses

| Aktor | Deskripsi | Hak akses utama |
| --- | --- | --- |
| Pengunjung | Pengguna yang belum login | Melihat beranda, mencari/memfilter event, melihat detail event, registrasi akun, login |
| Peserta (*participant*) | Pengguna terdaftar yang menghadiri event | Semua akses pengunjung, mendaftar event, melihat dan membatalkan pendaftaran, melihat tiket digital, mengelola profil, melihat dasbor peserta |
| Penyelenggara (*organizer*) | Pengguna yang membuat dan mengelola event | Semua akses pengunjung, membuat/mengubah/menghapus event miliknya, melihat daftar pendaftar, mengubah status pendaftaran dan kehadiran, melihat dasbor dan pendapatan, mengelola profil |
| Administrator | Pengelola sistem | Semua akses pengunjung, mengelola kategori, melihat dan memoderasi seluruh event, mengelola pengguna dan peran, melihat seluruh pendaftaran, melihat dasbor dan laporan global, mengelola profil |

Pembatasan akses diterapkan berlapis melalui middleware `auth`, middleware `role:*`,
`EventPolicy`, dan validasi pada `FormRequest`.

## 3. Kebutuhan Fungsional

### 3.1 Autentikasi dan Profil

| ID | Kebutuhan | Aktor | Deskripsi |
| --- | --- | --- | --- |
| F-01 | Registrasi akun | Pengunjung | Mendaftar sebagai peserta atau penyelenggara. Penyelenggara wajib mengisi nama organisasi. |
| F-02 | Login dan logout | Semua pengguna | Autentikasi dengan email dan kata sandi, opsi *remember me*, serta logout dan regenerasi sesi. |
| F-03 | Pengalihan dasbor berbasis peran | Pengguna terautentikasi | Setelah login, pengguna diarahkan ke dasbor admin, penyelenggara, atau peserta sesuai perannya. |
| F-04 | Pengelolaan profil | Semua pengguna | Mengubah nama, email, telepon, nama organisasi, bio, dan mengunggah avatar (maks. 2 MB). |
| F-05 | Proteksi rute berbasis peran | Sistem | Rute `/admin`, `/organizer`, dan `/peserta` hanya dapat diakses peran yang berwenang. |

### 3.2 Katalog dan Penelusuran Event (Publik)

| ID | Kebutuhan | Aktor | Deskripsi |
| --- | --- | --- | --- |
| F-06 | Beranda publik | Pengunjung | Menampilkan event unggulan, event mendatang, kategori populer, dan statistik agregat sistem. |
| F-07 | Daftar event | Pengunjung | Menampilkan event berstatus terbit/selesai yang belum berakhir, dengan paginasi. |
| F-08 | Pencarian dan filter | Pengunjung | Mencari berdasarkan judul, lokasi, atau kota; memfilter kategori dan kota; mengurutkan berdasarkan terdekat, terbaru, termurah, atau terpopuler. |
| F-09 | Detail event | Pengunjung | Menampilkan deskripsi, jadwal, lokasi, harga, kuota tersisa, penyelenggara, kategori, dan event terkait. |
| F-10 | Pembatasan visibilitas event | Sistem | Event berstatus draf atau dibatalkan hanya dapat dilihat oleh pemiliknya dan administrator. |

### 3.3 Pendaftaran Event (Peserta)

| ID | Kebutuhan | Aktor | Deskripsi |
| --- | --- | --- | --- |
| F-11 | Mendaftar event | Peserta | Mendaftar pada event yang terbit, belum berakhir, dan masih memiliki kuota. |
| F-12 | Pencegahan pendaftaran ganda | Sistem | Satu pengguna hanya boleh memiliki satu pendaftaran aktif per event (unique `event_id` + `user_id`). |
| F-13 | Tiket digital | Peserta | Sistem membuat kode tiket unik berformat `EVS-XXXXXXXX` dan menampilkan tiket beserta visual QR. |
| F-14 | Daftar dan detail tiket | Peserta | Melihat riwayat pendaftaran dan detail tiket miliknya sendiri. |
| F-15 | Pembatalan pendaftaran | Peserta | Membatalkan pendaftaran sebelum event dimulai; kuota kembali tersedia. |
| F-16 | Aktivasi ulang pendaftaran | Peserta | Pendaftaran yang telah dibatalkan dapat diaktifkan kembali menjadi terkonfirmasi. |
| F-17 | Dasbor peserta | Peserta | Menampilkan statistik pendaftaran, event mendatang, riwayat, dan rekomendasi event. |

### 3.4 Pengelolaan Event (Penyelenggara)

| ID | Kebutuhan | Aktor | Deskripsi |
| --- | --- | --- | --- |
| F-18 | Dasbor penyelenggara | Penyelenggara | Menampilkan jumlah event, event terbit, total pendaftaran, pendapatan terkonfirmasi, dan aktivitas terbaru. |
| F-19 | Membuat event | Penyelenggara | Mengisi data event, memilih kategori, menentukan jadwal, kuota, harga, status draf/terbit, dan mengunggah poster (maks. 4 MB). |
| F-20 | Mengubah event | Penyelenggara | Mengubah data dan poster event miliknya sendiri. |
| F-21 | Menghapus event | Penyelenggara | Menghapus event miliknya beserta poster dan data pendaftaran terkait. |
| F-22 | Daftar event sendiri | Penyelenggara | Melihat, mencari, dan memfilter event berdasarkan status. |
| F-23 | Daftar pendaftar | Penyelenggara | Melihat pendaftar per event, mencari berdasarkan kode tiket/nama/email, dan memfilter status. |
| F-24 | Verifikasi dan kehadiran | Penyelenggara | Mengubah status pendaftaran menjadi menunggu, terkonfirmasi, dibatalkan, atau hadir; status hadir mengisi `checked_in_at`. |

### 3.5 Administrasi Sistem

| ID | Kebutuhan | Aktor | Deskripsi |
| --- | --- | --- | --- |
| F-25 | Dasbor administrator | Administrator | Menampilkan statistik pengguna, event, pendaftaran, pendapatan, event terbaru, pendaftaran terbaru, dan kategori teratas. |
| F-26 | Mengelola kategori | Administrator | Menambah, mengubah, dan menghapus kategori (nama, deskripsi, warna). |
| F-27 | Moderasi event | Administrator | Melihat seluruh event, mengubah status (termasuk selesai), dan menghapus event. |
| F-28 | Mengelola pengguna | Administrator | Melihat pengguna, memfilter berdasarkan peran, mengubah peran, dan menghapus pengguna. |
| F-29 | Proteksi akun sendiri | Administrator | Tidak dapat menurunkan peran atau menghapus akunnya sendiri. |
| F-30 | Melihat seluruh pendaftaran | Administrator | Melihat dan memfilter semua pendaftaran berdasarkan status, kode tiket, nama/email peserta, atau judul event. |

### 3.6 Dasbor dan Laporan

| ID | Kebutuhan | Aktor | Deskripsi |
| --- | --- | --- | --- |
| F-31 | Statistik publik | Pengunjung | Menampilkan jumlah event, penyelenggara, peserta, dan pendaftaran terkonfirmasi/hadir. |
| F-32 | Laporan pendapatan | Penyelenggara, Administrator | Menghitung nilai pendapatan dari harga event dikali pendaftaran berstatus terkonfirmasi/hadir. |

## 4. Kebutuhan Non-Fungsional

| ID | Kategori | Kebutuhan |
| --- | --- | --- |
| NF-01 | Keamanan | Kata sandi di-hash, proteksi CSRF, validasi sisi server, escaping Blade, policy kepemilikan event, dan middleware peran. |
| NF-02 | Otorisasi | Pengguna hanya dapat mengubah data miliknya; administrator memiliki akses penuh, kecuali menghapus/menurunkan perannya sendiri. |
| NF-03 | Performa | Eager loading relasi, `withCount` untuk kuota terisi, paginasi daftar, dan indeks komposit `status + starts_at` pada tabel event. |
| NF-04 | Konsistensi data | Foreign key, unique constraint (`email`, `slug`, `ticket_code`, `event_id + user_id`), serta cascade/null-on-delete yang eksplisit. |
| NF-05 | Usability | Antarmuka responsif, tema gelap, umpan balik flash message, keadaan kosong, dan navigasi berbasis peran. |
| NF-06 | Kompatibilitas | PHP 8.4, Laravel 13, MySQL/SQLite, serta browser modern. |
| NF-07 | Maintainability | Pola MVC, Form Request, Enum, Policy, komponen Blade, dan formatter Pint. |
| NF-08 | Lokalisasi | Seluruh teks antarmuka dan pesan validasi menggunakan Bahasa Indonesia. |
| NF-09 | Penyimpanan berkas | Poster dan avatar disimpan pada disk `public`; validasi tipe dan ukuran berkas. |
| NF-10 | Auditabilitas | Setiap entitas memiliki timestamp; kehadiran dicatat melalui `checked_in_at`; tiket memiliki kode unik. |
| NF-11 | Skalabilitas | Kapasitas event dibatasi 1-100.000 dan daftar menggunakan paginasi agar tetap ringan. |

## 5. Aturan Bisnis

| ID | Aturan |
| --- | --- |
| BR-01 | Hanya pengguna berperan peserta yang dapat mendaftar event. |
| BR-02 | Event harus berstatus `published` atau `completed` agar dapat diakses publik dan didaftari. |
| BR-03 | Pendaftaran ditolak jika event sudah berakhir (`ends_at` telah lewat). |
| BR-04 | Pendaftaran ditolak jika kuota habis. Kursi terisi dihitung dari status `pending`, `confirmed`, dan `attended`. |
| BR-05 | Satu pengguna hanya boleh memiliki satu pendaftaran per event; pendaftaran batal dapat diaktifkan kembali. |
| BR-06 | Pendaftaran baru langsung berstatus `confirmed` dan memperoleh kode tiket unik. |
| BR-07 | Pembatalan hanya boleh dilakukan sebelum `starts_at`; pembatalan mengembalikan kursi. |
| BR-08 | Penyelenggara hanya dapat mengelola event miliknya; administrator dapat mengelola semua event. |
| BR-09 | Status event yang dapat dipilih penyelenggara: `draft`, `published`, `cancelled`. Administrator dapat menetapkan `completed`. |
| BR-10 | Event berstatus `draft` atau `cancelled` tidak tampil di katalog publik. |
| BR-11 | Kategori yang dihapus membuat `category_id` pada event terkait menjadi `null` (event tetap ada). |
| BR-12 | Penghapusan event menghapus seluruh pendaftaran terkait; penghapusan pengguna menghapus event dan pendaftarannya. |
| BR-13 | Administrator tidak dapat mengubah peran akunnya sendiri menjadi non-admin dan tidak dapat menghapus akunnya sendiri. |
| BR-14 | Harga tiket bersifat informatif; belum ada integrasi payment gateway, sehingga pendapatan dihitung dari data pendaftaran. |

## 6. Entitas Data dan Relasi

| Entitas | Atribut kunci | Relasi |
| --- | --- | --- |
| `users` | `id`, `name`, `email` (unik), `password`, `role`, `phone`, `organization_name`, `bio`, `avatar_path` | 1 pengguna dapat menyelenggarakan banyak event dan membuat banyak pendaftaran |
| `categories` | `id`, `name`, `slug` (unik), `description`, `color`, `icon` | 1 kategori memiliki banyak event (opsional) |
| `events` | `id`, `organizer_id`, `category_id`, `title`, `slug` (unik), `description`, `venue`, `city`, `starts_at`, `ends_at`, `capacity`, `price`, `poster_path`, `status`, `featured` | Milik 1 penyelenggara dan 1 kategori; memiliki banyak pendaftaran |
| `registrations` | `id`, `event_id`, `user_id`, `ticket_code` (unik), `status`, `notes`, `checked_in_at` | Milik 1 event dan 1 peserta; unik per pasangan event-peserta |

## 7. Alur Proses Utama

### 7.1 Registrasi dan Login

1. Pengunjung membuka halaman registrasi.
2. Pengunjung memilih peran peserta atau penyelenggara dan mengisi data akun.
3. Sistem memvalidasi keunikan email dan kecocokan konfirmasi kata sandi.
4. Sistem membuat pengguna, meng-hash kata sandi, dan langsung mengautentikasi pengguna.
5. Pengguna diarahkan ke dasbor sesuai perannya.

### 7.2 Pendaftaran Event

1. Peserta membuka detail event yang terbit dan belum berakhir.
2. Sistem memeriksa peran, status event, jadwal, kuota, dan pendaftaran yang sudah ada.
3. Jika valid, sistem membuat pendaftaran berstatus `confirmed` dan kode tiket unik.
4. Sistem menampilkan tiket digital yang dapat dibuka kembali dari menu pendaftaran.
5. Peserta dapat membatalkan pendaftaran sebelum event dimulai; kuota kembali tersedia.

### 7.3 Pengelolaan dan Verifikasi Event

1. Penyelenggara membuat event sebagai draf atau langsung menerbitkannya.
2. Event terbit muncul di katalog publik dan dapat didaftari peserta.
3. Penyelenggara memantau pendaftar melalui daftar pendaftar per event.
4. Penyelenggara mengubah status pendaftaran; status `attended` mencatat waktu kehadiran.
5. Administrator dapat memoderasi event, kategori, pengguna, dan melihat laporan global.

## 8. Matriks Aktor terhadap Fitur

| Fitur | Pengunjung | Peserta | Penyelenggara | Administrator |
| --- | :---: | :---: | :---: | :---: |
| Melihat katalog dan detail event | ✓ | ✓ | ✓ | ✓ |
| Registrasi, login, logout | ✓ | ✓ | ✓ | ✓ |
| Mengelola profil | - | ✓ | ✓ | ✓ |
| Mendaftar event dan melihat tiket | - | ✓ | - | - |
| Membatalkan pendaftaran | - | ✓ | - | - |
| Membuat/mengubah/menghapus event sendiri | - | - | ✓ | - |
| Melihat pendaftar dan mencatat kehadiran | - | - | ✓ | - |
| Mengelola kategori | - | - | - | ✓ |
| Memoderasi seluruh event | - | - | - | ✓ |
| Mengelola pengguna dan peran | - | - | - | ✓ |
| Melihat seluruh pendaftaran dan laporan | - | - | ✓ (milik sendiri) | ✓ (global) |

## 9. Kesenjangan dan Rekomendasi

| Temuan | Rekomendasi |
| --- | --- |
| Belum ada payment gateway; harga hanya informatif | Integrasikan penyedia pembayaran dan status pembayaran tiket bila transaksi nyata dibutuhkan. |
| Visual QR pada tiket belum tentu dapat dipindai perangkat standar | Gunakan pustaka QR standar dan tambahkan halaman/scan verifikasi tiket. |
| Verifikasi email belum diwajibkan | Aktifkan *email verification* dan notifikasi email transaksional. |
| Belum ada reset kata sandi | Tambahkan alur *forgot password*. |
| Belum ada pembatasan laju login | Tambahkan *rate limiting* pada rute autentikasi. |
| Penghapusan pengguna bersifat cascade ke event | Pertimbangkan *soft delete* atau pencegahan hapus bila event masih aktif. |
| Belum ada pengujian beban | Lakukan uji beban pada katalog dan proses pendaftaran saat event populer. |

## 10. Ringkasan Prioritas

| Prioritas | Kebutuhan |
| --- | --- |
| Wajib (*must have*) | Autentikasi, katalog event, pendaftaran dengan tiket, pengelolaan event, verifikasi kehadiran, moderasi admin |
| Sebaiknya ada (*should have*) | Pencarian/filter lanjutan, dasbor dan laporan, pengelolaan kategori/pengguna, pembatalan pendaftaran |
| Boleh ada (*could have*) | Notifikasi email, pembayaran online, pemindaian QR, ekspor laporan |
