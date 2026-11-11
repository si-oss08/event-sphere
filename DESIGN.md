# EventSphere — Style Guide "Midnight Gold"

Sistem desain premium untuk EventSphere: hitam pekat, panel arang, aksen emas, dan tipografi tegas.
Diterapkan melalui token Tailwind v4 di `resources/css/app.css`.

---

## 1. Warna

### Permukaan

| Token | Hex | Pemakaian |
| --- | --- | --- |
| `canvas` | `#09090B` | Background utama, sidebar, header |
| `surface` | `#18181B` | Kartu, panel, kolom form |
| `surface-2` | `#1F1F23` | Panel sekunder, footer kartu, hover |
| `raised` | `#242428` | Hover state tombol sekunder |
| `line` | `#27272A` | Border kartu, input, tabel |
| `line-strong` | `#3F3F46` | Border hover / fokus kuat |

### Teks

| Token | Hex | Pemakaian |
| --- | --- | --- |
| `ink` | `#FAFAFA` | Judul dan teks utama |
| `muted` | `#A1A1AA` | Paragraf dan keterangan |
| `faint` | `#71717A` | Metadata, placeholder, label tabel |

### Aksen

| Token | Hex | Pemakaian |
| --- | --- | --- |
| `accent` | `#FBBF24` | CTA, menu aktif, ikon utama, harga, badge penting |
| `accent-hover` | `#F59E0B` | Hover CTA |
| `accent-soft` | `#FCD34D` | Teks emas pada latar gelap |
| `danger` | `#E11D48` | Hapus, peringatan, badge stok kritis |

### Aturan mutlak

- Tidak ada biru, ungu, atau warna neon dalam bentuk apa pun.
- Emas hanya untuk satu tujuan per layar: aksi utama atau penanda status penting.
- Merah crimson hanya untuk destruktif, peringatan, dan badge stok (`Sisa 5 Tiket`).
- Status "Terkonfirmasi" dan "Terbit" memakai emas; "Dibatalkan" memakai crimson; status netral memakai zinc.

---

## 2. Tipografi

| Peran | Font | Ukuran / berat |
| --- | --- | --- |
| Display / H1 | Montserrat | 48–60px, 800 |
| H2 section | Montserrat | 30–36px, 800 |
| H3 kartu / panel | Montserrat | 16–20px, 700 |
| Body | Inter | 14–16px, 400 |
| Label / eyebrow | Inter | 10–11px, 700, uppercase, tracking 0.18–0.22em |
| Angka statistik | Montserrat | 20–32px, 800 |

Aturan:

- Judul selalu memakai `font-display` (Montserrat) dan `tracking-tight`.
- Eyebrow memakai huruf kapital, emas, dengan garis emas 28px di depannya.
- Teks paragraf memakai `text-zinc-400`; jangan turunkan kontras di bawah `zinc-500` untuk teks yang harus dibaca.

---

## 3. Bentuk & Elevation

- Radius: `rounded-md` untuk tombol/input, `rounded-lg` untuk kartu dan panel.
- Border: 1px `line` pada semua kartu, input, dan tabel.
- Tanpa glassmorphism, tanpa `backdrop-blur`, tanpa drop shadow besar.
- Pemisah tabel: border bawah `line`, header tabel uppercase 10px.
- Garis emas 1–2px dipakai sebagai penanda struktural (tepi panel, progress kuota, aksen banner).

---

## 4. Komponen

### Tombol

| Kelas | Tampilan |
| --- | --- |
| `.btn-primary` | Latar emas, teks hitam, hover amber |
| `.btn-secondary` | Latar `surface-2`, border `line`, teks `zinc-200` |
| `.btn-ghost` | Transparan, teks `zinc-400` |
| `.btn-danger` | Border crimson tipis, teks rose, hover crimson 10% |

### Form

- `.input` / `.select`: latar `canvas`, border `line`, fokus border emas + ring emas 20%.
- Checkbox: kotak 3px radius, tercentang emas dengan centang hitam.
- Label: 14px medium `zinc-300`.

### Kartu event

- Latar `surface`, border `line`, hover border emas 40%.
- Kategori: badge hitam dengan teks emas uppercase.
- Harga: blok emas solid, teks hitam.
- Kuota: garis progress emas 1px.
- Stok ≤ 5: badge crimson `Sisa N Tiket`.

### Sidebar dashboard

- Latar `canvas`, border kanan `line`.
- Menu aktif: latar emas 10%, teks dan ikon emas, indikator batang emas di sisi kiri.
- Menu pasif: `zinc-400`, hover `surface-2`.

### Tiket peserta

- Kartu `surface`, header `canvas` dengan garis emas di atas.
- Kode tiket mono, aksen emas.
- Status "Terkonfirmasi": latar emas 10%, teks emas, ring emas 30%.
- QR tetap pada bidang putih agar terbaca.

---

## 5. Checklist implementasi

- [x] Landing page: hero, search bar, kartu event, kategori, CTA penyelenggara.
- [x] Login / Register: split screen hitam–arang, heading emas.
- [x] Dashboard admin & penyelenggara: sidebar hitam, menu aktif emas, tabel border bawah.
- [x] Halaman tiket peserta: kartu arang, status terkonfirmasi emas.
- [x] Flash message, badge status, stat card, pagination.
- [x] Tidak ada kelas `emerald`, `blue`, `indigo`, `purple`, `violet`, `sky`, `cyan`, atau `teal`.
