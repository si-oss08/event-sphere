# Dokumen Pengujian Sistem EventSphere

**Sistem Informasi Penyelenggaraan Event Berbasis Web**

| Atribut | Keterangan |
| --- | --- |
| Proyek | EventSphere |
| Kelompok | ErrorWeb — Kelas 5.2 |
| Penguji | Ozra Ferdian (20105111054), Muhammed Ferdy (20105111058) |
| Dosen Pengampu | Zikrul Khalid |
| Tanggal pengujian | 17 November 2026 |
| Versi aplikasi | Laravel 13.40.0, PHP 8.4.27 |
| Repositori | <https://github.com/si-oss08/event-sphere> |
| Status akhir | **Lulus** — 58 test otomatis, 180 assertion, 0 kegagalan |

---

## 1. Ringkasan Eksekutif

Pengujian dilakukan pada dua lapis: **pengujian otomatis** menggunakan PHPUnit dan
**pengujian manual black-box** melalui browser terhadap aplikasi yang berjalan di
`http://eventsphere.test`.

| Metrik | Hasil |
| --- | --- |
| Test otomatis | **58 lulus** dari 58 test |
| Assertion | **180** |
| Waktu eksekusi | ± 2,5–4 detik |
| Skenario black-box | **61** skenario, seluruhnya lulus |
| Skenario UAT | **12** skenario, seluruhnya lulus |
| Cacat fungsional pada lingkup uji | **0** |
| Kebutuhan fungsional tertelusuri | **32 dari 32** (F-01 s.d. F-32) |

Pada tahap ini ditambahkan **25 test baru** (dari 33 menjadi 58 test) untuk menutup celah
pengujian pada modul administrasi, pengelolaan event, profil, pembatalan pendaftaran, dan
validasi form.

---

## 2. Tujuan dan Ruang Lingkup

### 2.1 Tujuan

1. Memverifikasi seluruh kebutuhan fungsional F-01 s.d. F-32 pada dokumen analisis kebutuhan.
2. Memastikan aturan bisnis BR-01 s.d. BR-14 berjalan sesuai rancangan.
3. Memverifikasi pembatasan akses berbasis peran dan kepemilikan data.
4. Memastikan validasi input dan penanganan kesalahan berjalan konsisten.
5. Menyediakan bukti pengujian yang dapat direproduksi untuk laporan akhir.

### 2.2 Lingkup

| Termasuk | Tidak termasuk |
| --- | --- |
| Autentikasi, registrasi, logout, profil | Pembayaran online (belum diimplementasikan) |
| Katalog, pencarian, filter, detail event | Pemindaian QR fisik (QR masih visual) |
| Pendaftaran, tiket digital, pembatalan, aktivasi ulang | Notifikasi email dan verifikasi email |
| CRUD event oleh penyelenggara | Uji beban dan uji penetrasi |
| Verifikasi kehadiran dan status pendaftaran | Reset kata sandi (belum tersedia) |
| Moderasi event, kategori, pengguna oleh admin | Ekspor laporan CSV/PDF |
| Dasbor dan statistik per peran | Integrasi payment gateway |

---

## 3. Lingkungan Pengujian

| Komponen | Keterangan |
| --- | --- |
| Sistem operasi | Windows (Laravel Herd) |
| Web server | nginx bawaan Herd — `http://eventsphere.test` |
| PHP | 8.4.27 (NTS, Visual C++ 2022 x64) |
| Framework | Laravel 13.40.0 |
| Basis data aplikasi | SQLite (`database/database.sqlite`) |
| Basis data pengujian | SQLite in-memory (`:memory:`) |
| Node.js / npm | Node 26.12.1 |
| Composer | 2.11.1 |
| Framework test | PHPUnit 12.5.12 |
| Build aset | Vite 8 + `scripts/build-assets.mjs` + Tailwind CSS 4 |
| Browser | Microsoft Edge (headless untuk tangkapan layar) |
| Formatter | Laravel Pint |

---

## 4. Data Uji

Data uji dibuat melalui `php artisan migrate --seed` (`DatabaseSeeder`).

| Entitas | Jumlah | Rincian |
| --- | ---: | --- |
| Pengguna | 30 | 1 admin, 4 penyelenggara, 25 peserta |
| Kategori | 8 | Teknologi, Bisnis, Musik, Pendidikan, Seni & Budaya, Olahraga, Kesehatan, Komunitas |
| Event | 15 | 12 terbit, 2 selesai, 1 draf |
| Pendaftaran | 162 | 105 terkonfirmasi, 21 menunggu, 21 hadir, 15 dibatalkan |

### 4.1 Akun Demo

| Peran | Email | Kata sandi |
| --- | --- | --- |
| Administrator | `admin@eventsphere.test` | `password` |
| Penyelenggara | `organizer@eventsphere.test` | `password` |
| Peserta | `participant@eventsphere.test` | `password` |

### 4.2 Isolasi Data

Setiap test menggunakan trait `RefreshDatabase` sehingga basis data diuji dari kondisi
kosong. Data dibangun dengan factory (`UserFactory`, `CategoryFactory`, `EventFactory`,
`RegistrationFactory`) agar hasil test deterministik dan tidak bergantung pada data demo.

---

## 5. Strategi dan Metode

| Level | Metode | Cakupan |
| --- | --- | --- |
| Unit | PHPUnit | Konfigurasi dasar aplikasi (`ExampleTest`) |
| Feature/integration | PHPUnit + `actingAs` + HTTP request | Autentikasi, otorisasi, CRUD, validasi, alur pendaftaran |
| Black-box | Manual melalui browser + request HTTP | Alur pengguna per peran, tampilan, pesan kesalahan |
| UAT | Simulasi pengguna akhir | Skenario utama peserta, penyelenggara, admin |

**Kriteria lulus:**

- Seluruh test otomatis berstatus *passed* tanpa error atau warning.
- Setiap skenario black-box menghasilkan output sesuai yang diharapkan.
- Tidak ada cacat fungsional terbuka pada fitur *must have*.
- Setiap kebutuhan F-01 s.d. F-32 memiliki minimal satu bukti pengujian.

**Perintah eksekusi:**

```bash
php artisan test --compact
```

Untuk menjalankan satu modul:

```bash
php artisan test --filter=AdminManagementTest
php artisan test --filter=EventRegistrationTest
```

---

## 6. Hasil Pengujian Otomatis

### 6.1 Ringkasan

```text
php artisan test --compact

passed · 58 test · 180 assertion · ± 2,5–4 detik
```

### 6.2 Sebaran Test per Kelas

| No | Kelas test | Jumlah | Cakupan utama |
| ---: | --- | ---: | --- |
| 1 | `AuthenticationTest` | 8 | Registrasi peserta/organizer, email duplikat, login, logout |
| 2 | `EventRegistrationTest` | 12 | Daftar event, kuota, pendaftaran ganda, tiket, pembatalan, aktivasi ulang |
| 3 | `PublicPagesTest` | 6 | Beranda, katalog, pencarian, filter kota/kategori, detail, visibilitas draf |
| 4 | `RoleAccessTest` | 10 | Middleware peran, redirect dasbor, kepemilikan event, verifikasi kehadiran |
| 5 | `AdminManagementTest` | 10 | Kategori, pengguna, peran, proteksi akun sendiri, moderasi event |
| 6 | `OrganizerEventManagementTest` | 6 | Buat/ubah/hapus event, validasi jadwal, pencarian pendaftar |
| 7 | `ProfileTest` | 5 | Lihat/ubah profil, email unik, unggah avatar, proteksi tamu |
| 8 | `ExampleTest` (Unit) | 1 | Konfigurasi dasar aplikasi |
| | **Total** | **58** | |

### 6.3 Test Baru pada Tahap Ini

| Modul | Test baru | Contoh |
| --- | ---: | --- |
| Administrasi | 10 | `test_admin_can_create_a_category`, `test_admin_cannot_demote_their_own_account` |
| Pengelolaan event | 6 | `test_organizer_cannot_update_another_organizers_event`, `test_event_end_time_must_be_after_start_time` |
| Profil | 5 | `test_user_can_update_their_profile`, `test_user_can_upload_an_avatar` |
| Pendaftaran | 3 | `test_participant_cannot_cancel_registration_after_event_started` |
| Autentikasi | 1 | `test_registration_rejects_duplicate_email` |
| **Total** | **25** | |

---

## 7. Matriks Keterlacakan Kebutuhan

| Kebutuhan | Ringkasan | Bukti pengujian | Status |
| --- | --- | --- | --- |
| F-01 | Registrasi akun peserta/organizer | AUTH-01, AUTH-02, AUTH-03 | Lulus |
| F-02 | Login dan logout | AUTH-05, AUTH-06, AUTH-07 | Lulus |
| F-03 | Redirect dasbor sesuai peran | AUTH-09 | Lulus |
| F-04 | Pengelolaan profil dan avatar | PRF-01 s.d. PRF-05 | Lulus |
| F-05 | Proteksi rute berbasis peran | SEC-02 | Lulus |
| F-06 | Beranda publik dan statistik | CAT-01 | Lulus |
| F-07 | Daftar event terbit | CAT-02 | Lulus |
| F-08 | Pencarian dan filter event | CAT-03, CAT-04, CAT-05 | Lulus |
| F-09 | Detail event | CAT-06 | Lulus |
| F-10 | Visibilitas event draf/dibatalkan | CAT-07, CAT-08, SEC-03 | Lulus |
| F-11 | Mendaftar event | REG-01 | Lulus |
| F-12 | Pencegahan pendaftaran ganda | REG-02 | Lulus |
| F-13 | Tiket digital dan kode unik | REG-06, REG-12 | Lulus |
| F-14 | Daftar dan detail tiket | REG-06, REG-07 | Lulus |
| F-15 | Pembatalan pendaftaran | REG-08, REG-09, REG-10 | Lulus |
| F-16 | Aktivasi ulang pendaftaran | REG-11 | Lulus |
| F-17 | Dasbor peserta | UAT-01 | Lulus |
| F-18 | Dasbor penyelenggara | UAT-04 | Lulus |
| F-19 | Membuat event | ORG-01, ORG-02 | Lulus |
| F-20 | Mengubah event sendiri | ORG-03, ORG-04 | Lulus |
| F-21 | Menghapus event sendiri | ORG-05, ORG-06 | Lulus |
| F-22 | Daftar event sendiri | ORG-07 | Lulus |
| F-23 | Daftar dan pencarian pendaftar | ORG-08 | Lulus |
| F-24 | Verifikasi kehadiran | ORG-09 | Lulus |
| F-25 | Dasbor administrator | UAT-08 | Lulus |
| F-26 | Pengelolaan kategori | ADM-02 s.d. ADM-05 | Lulus |
| F-27 | Moderasi event | ADM-10, ADM-11 | Lulus |
| F-28 | Pengelolaan pengguna dan peran | ADM-06, ADM-09 | Lulus |
| F-29 | Proteksi akun administrator sendiri | ADM-07, ADM-08 | Lulus |
| F-30 | Melihat seluruh pendaftaran | ADM-12 | Lulus |
| F-31 | Statistik publik | CAT-01 | Lulus |
| F-32 | Laporan pendapatan | UAT-04, UAT-08 | Lulus |

---

## 8. Skenario Black-Box

Metode: **O** = otomatis (PHPUnit), **M** = manual (browser), **I** = inspeksi kode/konfigurasi.

### 8.1 Autentikasi dan Profil

| ID | Skenario | Hasil yang diharapkan | Metode | Status |
| --- | --- | --- | :---: | :---: |
| AUTH-01 | Registrasi peserta dengan data valid | Akun dibuat, pengguna langsung login, diarahkan ke dasbor | O | Lulus |
| AUTH-02 | Registrasi organizer tanpa nama organisasi | Validasi `organization_name` gagal, akun tidak dibuat | O | Lulus |
| AUTH-03 | Registrasi organizer lengkap | Akun dan nama organisasi tersimpan | O | Lulus |
| AUTH-04 | Registrasi dengan email terdaftar | Validasi *unique* gagal, jumlah akun tidak bertambah | O | Lulus |
| AUTH-05 | Login dengan kredensial valid | Sesi dibuat, diarahkan ke dasbor | O | Lulus |
| AUTH-06 | Login dengan kata sandi salah | Pesan kesalahan pada field email, pengguna tetap tamu | O | Lulus |
| AUTH-07 | Logout | Sesi dihapus dan diarahkan ke beranda | O | Lulus |
| AUTH-08 | Akses dasbor tanpa login | Dialihkan ke halaman login | O | Lulus |
| AUTH-09 | Redirect dasbor per peran | Admin, organizer, dan peserta diarahkan ke dasbor masing-masing | O | Lulus |
| PRF-01 | Membuka halaman profil | Data pengguna yang sedang login ditampilkan | O | Lulus |
| PRF-02 | Mengubah nama, email, telepon, bio | Perubahan tersimpan dan tampil kembali | O | Lulus |
| PRF-03 | Mengubah email menjadi milik pengguna lain | Validasi *unique* gagal | O | Lulus |
| PRF-04 | Mengunggah avatar JPG 200×200 | Berkas tersimpan pada disk `public` | O | Lulus |
| PRF-05 | Tamu membuka halaman profil | Dialihkan ke halaman login | O | Lulus |

### 8.2 Katalog Publik

| ID | Skenario | Hasil yang diharapkan | Metode | Status |
| --- | --- | --- | :---: | :---: |
| CAT-01 | Membuka beranda | Event unggulan mendatang dan statistik platform tampil; event lampau tidak tampil | M | Lulus |
| CAT-02 | Membuka katalog event | Hanya event berstatus terbit/selesai yang tampil; draf dan batal tidak tampil | O | Lulus |
| CAT-03 | Mencari kata kunci "Bali" | Hanya event yang judul/lokasi/kotanya cocok | O | Lulus |
| CAT-04 | Memfilter kota "Jakarta" | Hanya event di Jakarta yang tampil | O | Lulus |
| CAT-05 | Memfilter kategori | Hanya event pada kategori tersebut yang tampil | O | Lulus |
| CAT-06 | Membuka detail event terbit | Judul, jadwal, lokasi, harga, kuota, dan penyelenggara tampil | O | Lulus |
| CAT-07 | Membuka detail event draf sebagai tamu | Halaman mengembalikan 404 | O | Lulus |
| CAT-08 | Membuka detail event draf sebagai pemilik/admin | Halaman dapat diakses | I | Sesuai |

### 8.3 Pendaftaran Event

| ID | Skenario | Hasil yang diharapkan | Metode | Status |
| --- | --- | --- | :---: | :---: |
| REG-01 | Peserta mendaftar event terbit | Pendaftaran berstatus `confirmed`, kode tiket dibuat | O | Lulus |
| REG-02 | Peserta mendaftar dua kali pada event yang sama | Ditolak, jumlah pendaftaran tetap satu | O | Lulus |
| REG-03 | Mendaftar pada event yang kuotanya penuh | Ditolak dengan pesan kuota penuh | O | Lulus |
| REG-04 | Mendaftar pada event yang sudah berakhir | Ditolak dengan pesan event berakhir | O | Lulus |
| REG-05 | Organizer mencoba mendaftar event | Ditolak dengan status 403 | O | Lulus |
| REG-06 | Peserta membuka tiket miliknya | Halaman tiket tampil beserta kode tiket | O | Lulus |
| REG-07 | Peserta membuka tiket peserta lain | Ditolak dengan status 403 | O | Lulus |
| REG-08 | Membatalkan pendaftaran sebelum event dimulai | Status berubah menjadi `cancelled` | O | Lulus |
| REG-09 | Membatalkan pendaftaran setelah event dimulai | Ditolak, status tidak berubah | O | Lulus |
| REG-10 | Membatalkan pendaftaran yang sudah dibatalkan | Ditolak, status tetap `cancelled` | O | Lulus |
| REG-11 | Mengaktifkan kembali pendaftaran yang dibatalkan | Status kembali `confirmed` dan tiket dapat dibuka | O | Lulus |
| REG-12 | Memeriksa format kode tiket | Kode sesuai pola `EVS-` + 8 karakter alfanumerik | O | Lulus |

### 8.4 Pengelolaan Event (Penyelenggara)

| ID | Skenario | Hasil yang diharapkan | Metode | Status |
| --- | --- | --- | :---: | :---: |
| ORG-01 | Membuat event terbit | Event tersimpan dengan `organizer_id` pengguna dan status terbit | O | Lulus |
| ORG-02 | Mengisi waktu selesai lebih awal dari waktu mulai | Validasi `ends_at` gagal, event tidak dibuat | O | Lulus |
| ORG-03 | Mengubah event milik sendiri | Data event berubah sesuai input | O | Lulus |
| ORG-04 | Mengubah event milik penyelenggara lain | Ditolak dengan status 403 | O | Lulus |
| ORG-05 | Menghapus event milik sendiri | Event terhapus | O | Lulus |
| ORG-06 | Menghapus event milik penyelenggara lain | Ditolak dengan status 403, event tetap ada | O | Lulus |
| ORG-07 | Membuka daftar event sendiri | Hanya event milik pengguna yang tampil beserta status dan jumlah peserta | M | Lulus |
| ORG-08 | Mencari pendaftar berdasarkan kode tiket | Hanya pendaftar yang cocok yang tampil | O | Lulus |
| ORG-09 | Mengubah status pendaftaran menjadi hadir | Status menjadi `attended` dan `checked_in_at` terisi | O | Lulus |

### 8.5 Administrasi Sistem

| ID | Skenario | Hasil yang diharapkan | Metode | Status |
| --- | --- | --- | :---: | :---: |
| ADM-01 | Membuka dasbor administrator | Statistik 30 pengguna, 15 event, 162 pendaftaran, dan pendapatan tampil | M | Lulus |
| ADM-02 | Menambah kategori valid | Kategori tersimpan dan slug dibuat otomatis | O | Lulus |
| ADM-03 | Menambah kategori dengan nama duplikat | Validasi gagal, kategori tidak bertambah | O | Lulus |
| ADM-04 | Mengubah nama dan warna kategori | Data dan slug kategori diperbarui | O | Lulus |
| ADM-05 | Menghapus kategori yang memiliki event | Kategori terhapus, event tetap ada dengan `category_id` kosong | O | Lulus |
| ADM-06 | Mengubah peran pengguna lain | Peran berubah dan nama organisasi terisi bila menjadi organizer | O | Lulus |
| ADM-07 | Menurunkan peran akun sendiri | Ditolak, peran admin tetap | O | Lulus |
| ADM-08 | Menghapus akun sendiri | Ditolak, akun tetap ada | O | Lulus |
| ADM-09 | Menghapus pengguna lain | Akun pengguna terhapus | O | Lulus |
| ADM-10 | Mengubah status event menjadi selesai | Status event berubah | O | Lulus |
| ADM-11 | Menghapus event | Event dan seluruh pendaftaran terkait terhapus | O | Lulus |
| ADM-12 | Membuka seluruh data pendaftaran | Pendaftaran lintas event tampil beserta kode tiket dan status | M | Lulus |

### 8.6 Keamanan dan Validasi

| ID | Skenario | Hasil yang diharapkan | Metode | Status |
| --- | --- | --- | :---: | :---: |
| SEC-01 | Mengirim form tanpa token CSRF | Permintaan ditolak (419) | I | Sesuai |
| SEC-02 | Peserta mengakses area admin/organizer | Ditolak dengan status 403 | O | Lulus |
| SEC-03 | Penyelenggara mengelola event milik orang lain | Ditolak oleh `EventPolicy` (403) | O | Lulus |
| SEC-04 | Menampilkan input pengguna yang mengandung HTML | Karakter di-escape oleh Blade, tidak dieksekusi | I | Sesuai |
| SEC-05 | Memeriksa penyimpanan kata sandi | Kata sandi tersimpan sebagai hash, bukan teks biasa | I | Sesuai |
| SEC-06 | Mengirim input tidak valid pada form | Validasi server-side menolak dan menampilkan pesan | O | Lulus |

---

## 9. Skenario UAT

UAT disimulasikan menggunakan akun demo dan data seeder pada `http://eventsphere.test`.

| ID | Peran | Skenario | Hasil yang diharapkan | Bukti | Status |
| --- | --- | --- | --- | --- | :---: |
| UAT-01 | Peserta | Membuka dasbor dan tiket | Statistik, tiket mendatang, dan kode tiket tampil | Manual | Lulus |
| UAT-02 | Peserta | Mendaftar event terbit | Tiket digital langsung terbit | Otomatis | Lulus |
| UAT-03 | Peserta | Membatalkan pendaftaran | Status berubah menjadi dibatalkan | Otomatis | Lulus |
| UAT-04 | Penyelenggara | Membuka dasbor | Jumlah event, peserta, dan estimasi pendapatan tampil | Manual | Lulus |
| UAT-05 | Penyelenggara | Membuka daftar event | Event sendiri tampil dengan aksi peserta, edit, lihat, hapus | Manual | Lulus |
| UAT-06 | Penyelenggara | Mencari pendaftar dan mencatat kehadiran | Pendaftar ditemukan, status hadir tersimpan | Otomatis | Lulus |
| UAT-07 | Penyelenggara | Membuat event baru | Event tersimpan dengan status terbit | Otomatis | Lulus |
| UAT-08 | Admin | Membuka dasbor global | Statistik pengguna, event, pendaftaran, dan pendapatan tampil | Manual | Lulus |
| UAT-09 | Admin | Mengelola kategori | Tambah, ubah, dan hapus kategori berjalan | Manual + Otomatis | Lulus |
| UAT-10 | Admin | Mengelola pengguna | Daftar pengguna dan perubahan peran berjalan | Manual + Otomatis | Lulus |
| UAT-11 | Admin | Melihat seluruh pendaftaran | Data pendaftaran lintas event tampil | Manual | Lulus |
| UAT-12 | Pengunjung | Mencari dan memfilter event | Hasil pencarian dan filter sesuai kriteria | Manual + Otomatis | Lulus |

---

## 10. Catatan Cacat dan Batasan

Tidak ditemukan cacat fungsional pada lingkup pengujian. Temuan berikut merupakan
keterbatasan yang sudah diketahui dan tercatat pada dokumen analisis kebutuhan.

| ID | Temuan | Tingkat | Status | Rencana |
| --- | --- | --- | --- | --- |
| DEF-01 | QR pada tiket bersifat visual dan belum dapat dipindai perangkat standar | Rendah | Terbuka | Gunakan pustaka QR standar dan halaman scan panitia |
| DEF-02 | Belum ada payment gateway; harga tiket bersifat informatif | Rendah | Sesuai desain | Di luar lingkup (BR-14) |
| DEF-03 | Belum ada pembatasan laju percobaan login (*rate limiting*) | Sedang | Terbuka | Tambahkan `throttle` pada rute autentikasi |
| DEF-04 | Belum ada reset kata sandi dan verifikasi email | Sedang | Terbuka | Tambahkan alur *forgot password* dan verifikasi email |
| DEF-05 | Belum ada ekspor laporan CSV/PDF | Rendah | Terbuka | Tambahkan ekspor pada dasbor penyelenggara/admin |
| DEF-06 | Pengujian beban dan penetrasi belum dilakukan | Rendah | Terbuka | Dilakukan sebelum event berskala besar |

---

## 11. Kesimpulan dan Rekomendasi

### 11.1 Kesimpulan

1. Seluruh **58 test otomatis** lulus dengan **180 assertion** tanpa kegagalan.
2. Seluruh **61 skenario black-box** berstatus lulus/sesuai, terdiri atas 53 skenario
   otomatis, 4 manual, dan 4 inspeksi.
3. Seluruh **12 skenario UAT** untuk peserta, penyelenggara, dan administrator lulus.
4. Seluruh kebutuhan fungsional **F-01 s.d. F-32** telah tertelusuri ke bukti pengujian.
5. Tidak ditemukan cacat fungsional pada fitur *must have*; aplikasi siap digunakan
   untuk demonstrasi dan penilaian proyek.

### 11.2 Rekomendasi

1. Tambahkan pembatasan laju login dan alur reset kata sandi sebelum rilis publik.
2. Ganti QR visual dengan QR standar dan sediakan halaman pemindaian tiket.
3. Tambahkan ekspor laporan untuk kebutuhan operasional penyelenggara.
4. Jalankan uji beban pada katalog dan proses pendaftaran saat event populer.
5. Tambahkan pengujian otomatis untuk unggah poster event dan unggah avatar berukuran besar.

---

## 12. Lampiran

### 12.1 Bukti Tangkapan Layar

| No | Berkas | Halaman |
| ---: | --- | --- |
| 1 | `docs/screenshots/01-beranda.png` | Beranda publik |
| 2 | `docs/screenshots/02-katalog-event.png` | Katalog dan filter event |
| 3 | `docs/screenshots/03-detail-event.png` | Detail event |
| 4 | `docs/screenshots/04-login.png` | Halaman login |
| 5 | `docs/screenshots/05-register.png` | Halaman registrasi |

### 12.2 Berkas Test

```text
tests/
├── Feature/
│   ├── AdminManagementTest.php
│   ├── AuthenticationTest.php
│   ├── EventRegistrationTest.php
│   ├── OrganizerEventManagementTest.php
│   ├── ProfileTest.php
│   ├── PublicPagesTest.php
│   └── RoleAccessTest.php
└── Unit/
    └── ExampleTest.php
```

### 12.3 Perintah Reproduksi

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan test --compact
```
