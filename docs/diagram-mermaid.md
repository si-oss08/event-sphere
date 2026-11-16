# Diagram Sistem EventSphere (Mermaid)

Semua diagram di bawah dapat dirender langsung di GitHub, VS Code, Obsidian, atau
[Mermaid Live Editor](https://mermaid.live). Sumber draw.io tersedia di folder
`docs/drawio/` untuk versi yang dapat diedit secara visual.

---

## 1. DFD Diagram Konteks

Menunjukkan sistem sebagai satu proses tunggal (`0`) beserta entitas eksternal dan
arus data utama yang melewati batas sistem.

```mermaid
flowchart LR
    classDef entity fill:#DAE8FC,stroke:#6C8EBF,color:#111,stroke-width:1.5px
    classDef process fill:#FFF2CC,stroke:#D6B656,color:#111,stroke-width:1.5px

    E1["Pengunjung /<br/>Peserta"]:::entity
    E2["Penyelenggara"]:::entity
    E3["Administrator"]:::entity
    P0(("0<br/>Sistem<br/>EventSphere")):::process

    E1 -->|"Data akun, kredensial login,<br/>kriteria pencarian, pendaftaran event"| P0
    P0 -->|"Info dan detail event, tiket digital,<br/>status pendaftaran"| E1

    E2 -->|"Kredensial login, data event,<br/>poster, status pendaftaran"| P0
    P0 -->|"Statistik event, daftar pendaftar,<br/>laporan pendapatan"| E2

    E3 -->|"Kredensial login, data kategori,<br/>peran pengguna, status event"| P0
    P0 -->|"Statistik global, daftar pengguna,<br/>event, pendaftaran, laporan"| E3
```

---

## 2. DFD Level 0

Dekomposisi proses `0` menjadi tujuh proses utama dan empat penyimpanan data:
`D1 users`, `D2 categories`, `D3 events`, dan `D4 registrations`.

> Mermaid menata posisi simpul secara otomatis, sehingga urutan angka proses tidak
> selalu kiri ke kanan. Untuk tata letak yang terkontrol dan siap cetak, gunakan
> `docs/drawio/02-dfd-level-0.drawio` atau halaman **DFD Level 0** pada file
> `EventSphere-semua-diagram.drawio`.

```mermaid
flowchart TB
    classDef entity fill:#DAE8FC,stroke:#6C8EBF,color:#111,stroke-width:1.5px
    classDef process fill:#FFF2CC,stroke:#D6B656,color:#111,stroke-width:1.5px
    classDef store fill:#D5E8D4,stroke:#82B366,color:#111,stroke-width:1.5px

    subgraph EXT["Entitas Eksternal"]
        direction TB
        E1["Pengunjung /<br/>Peserta"]:::entity
        E2["Penyelenggara"]:::entity
        E3["Administrator"]:::entity
    end

    subgraph PRO["Proses"]
        direction LR
        P1(("1.0<br/>Autentikasi dan<br/>Profil")):::process
        P2(("2.0<br/>Manajemen<br/>Kategori")):::process
        P3(("3.0<br/>Manajemen<br/>Event")):::process
        P4(("4.0<br/>Katalog dan<br/>Pencarian Event")):::process
        P5(("5.0<br/>Pendaftaran<br/>Event")):::process
        P6(("6.0<br/>Verifikasi dan<br/>Kehadiran")):::process
        P7(("7.0<br/>Dasbor dan<br/>Laporan")):::process
    end

    subgraph DS["Penyimpanan Data"]
        direction LR
        D1[("D1<br/>users")]:::store
        D2[("D2<br/>categories")]:::store
        D3[("D3<br/>events")]:::store
        D4[("D4<br/>registrations")]:::store
    end

    E1 -->|"data akun dan kredensial"| P1
    P1 -->|"sesi dan konfirmasi"| E1
    E1 -->|"pendaftaran atau pembatalan"| P5
    P5 -->|"tiket digital dan status"| E1
    E1 -->|"kriteria pencarian"| P4
    P4 -->|"daftar dan detail event"| E1
    E1 -->|"permintaan dasbor"| P7
    P7 -->|"ringkasan aktivitas"| E1

    E2 -->|"kredensial dan profil"| P1
    P1 -->|"sesi"| E2
    E2 -->|"data event dan poster"| P3
    P3 -->|"konfirmasi dan daftar event"| E2
    E2 -->|"status pendaftar"| P6
    P6 -->|"daftar hadir"| E2
    E2 -->|"permintaan laporan"| P7
    P7 -->|"statistik dan pendapatan"| E2

    E3 -->|"kredensial"| P1
    P1 -->|"sesi"| E3
    E3 -->|"data kategori"| P2
    P2 -->|"konfirmasi kategori"| E3
    E3 -->|"status atau hapus event"| P3
    P3 -->|"konfirmasi"| E3
    E3 -->|"filter laporan"| P7
    P7 -->|"statistik global"| E3

    P1 <-->|"data pengguna"| D1
    P2 <-->|"data kategori"| D2
    P3 <-->|"data event"| D3
    D2 -->|"referensi kategori"| P3
    D3 -->|"data event"| P4
    D2 -->|"data kategori"| P4
    D3 -->|"kuota dan jadwal"| P5
    P5 <-->|"data pendaftaran"| D4
    D3 -->|"data event"| P6
    P6 <-->|"status kehadiran"| D4
    D1 -->|"data pengguna"| P7
    D2 -->|"data kategori"| P7
    D3 -->|"data event"| P7
    D4 -->|"data pendaftaran"| P7
```

### Keterangan proses

| Proses | Nama | Deskripsi singkat |
| --- | --- | --- |
| 1.0 | Autentikasi dan Profil | Registrasi, login/logout, pengelolaan profil dan avatar |
| 2.0 | Manajemen Kategori | CRUD kategori oleh administrator |
| 3.0 | Manajemen Event | CRUD event, poster, dan perubahan status oleh penyelenggara/admin |
| 4.0 | Katalog dan Pencarian Event | Beranda, daftar event, filter, pencarian, dan detail event |
| 5.0 | Pendaftaran Event | Pendaftaran, pembatalan, aktivasi ulang, dan pembuatan tiket |
| 6.0 | Verifikasi dan Kehadiran | Perubahan status pendaftaran dan pencatatan kehadiran |
| 7.0 | Dasbor dan Laporan | Statistik, ringkasan aktivitas, dan laporan pendapatan |

---

## 3. ERD (Entity Relationship Diagram)

Relasi utama: satu penyelenggara memiliki banyak event, satu kategori memiliki banyak
event, satu peserta memiliki banyak pendaftaran, dan satu event memiliki banyak
pendaftaran. Kombinasi `event_id + user_id` pada `registrations` bersifat unik.

```mermaid
erDiagram
    USERS ||--o{ EVENTS : "menyelenggarakan"
    USERS ||--o{ REGISTRATIONS : "membuat"
    CATEGORIES |o--o{ EVENTS : "mengelompokkan"
    EVENTS ||--o{ REGISTRATIONS : "memiliki"

    USERS {
        bigint id PK
        string name
        string email UK
        string password
        string role "admin | organizer | participant"
        string phone
        string organization_name
        text bio
        string avatar_path
        timestamp email_verified_at
        timestamp created_at
        timestamp updated_at
    }

    CATEGORIES {
        bigint id PK
        string name
        string slug UK
        text description
        string color
        string icon
        timestamp created_at
        timestamp updated_at
    }

    EVENTS {
        bigint id PK
        bigint organizer_id FK
        bigint category_id FK "nullable"
        string title
        string slug UK
        text description
        string venue
        string city
        string address
        datetime starts_at
        datetime ends_at
        int capacity
        decimal price
        string poster_path
        string status "draft | published | cancelled | completed"
        boolean featured
        timestamp created_at
        timestamp updated_at
    }

    REGISTRATIONS {
        bigint id PK
        bigint event_id FK
        bigint user_id FK
        string ticket_code UK
        string status "pending | confirmed | cancelled | attended"
        text notes
        datetime checked_in_at
        timestamp created_at
        timestamp updated_at
    }
```

Catatan: unique gabungan `(event_id, user_id)` tidak dapat digambarkan sebagai atribut
tunggal pada Mermaid, sehingga dicatat sebagai aturan tabel.

---

## 4. UML: Use Case Diagram

Aktor: Pengunjung, Peserta, Penyelenggara, dan Administrator. Relasi `«include»`
menunjukkan use case yang selalu melibatkan login.

```mermaid
flowchart LR
    classDef actor fill:#F8CECC,stroke:#B85450,color:#111,stroke-width:1.5px
    classDef usecase fill:#FFF2CC,stroke:#D6B656,color:#111,stroke-width:1.2px
    classDef shared fill:#DAE8FC,stroke:#6C8EBF,color:#111,stroke-width:1.2px

    G(["👤 Pengunjung"]):::actor
    P(["👤 Peserta"]):::actor
    O(["👤 Penyelenggara"]):::actor
    A(["👤 Administrator"]):::actor

    subgraph SIS["Sistem EventSphere"]
        direction TB
        UC01(["Melihat beranda dan statistik"]):::usecase
        UC02(["Mencari dan memfilter event"]):::usecase
        UC03(["Melihat detail event"]):::usecase
        UC04(["Registrasi akun"]):::usecase
        UC05(["Login / Logout"]):::shared

        UC06(["Mendaftar event"]):::usecase
        UC07(["Melihat tiket digital"]):::usecase
        UC08(["Membatalkan pendaftaran"]):::usecase
        UC09(["Melihat dasbor peserta"]):::usecase

        UC10(["Mengelola event sendiri"]):::usecase
        UC11(["Melihat daftar pendaftar"]):::usecase
        UC12(["Memverifikasi dan mencatat kehadiran"]):::usecase
        UC13(["Melihat dasbor penyelenggara"]):::usecase

        UC14(["Mengelola kategori"]):::usecase
        UC15(["Mengelola seluruh event"]):::usecase
        UC16(["Mengelola pengguna"]):::usecase
        UC17(["Melihat semua pendaftaran"]):::usecase
        UC18(["Melihat dasbor admin"]):::usecase

        UC19(["Mengelola profil"]):::shared
    end

    G --- UC01
    G --- UC02
    G --- UC03
    G --- UC04
    G --- UC05

    P --- UC05
    P --- UC06
    P --- UC07
    P --- UC08
    P --- UC09
    P --- UC19

    O --- UC05
    O --- UC10
    O --- UC11
    O --- UC12
    O --- UC13
    O --- UC19

    A --- UC05
    A --- UC14
    A --- UC15
    A --- UC16
    A --- UC17
    A --- UC18
    A --- UC19

    UC06 -.->|"«include»"| UC05
    UC07 -.->|"«include»"| UC05
    UC08 -.->|"«include»"| UC05
    UC10 -.->|"«include»"| UC05
    UC11 -.->|"«include»"| UC05
    UC12 -.->|"«include»"| UC05
    UC14 -.->|"«include»"| UC05
    UC15 -.->|"«include»"| UC05
    UC16 -.->|"«include»"| UC05
    UC17 -.->|"«include»"| UC05
    UC19 -.->|"«include»"| UC05
```

---

## 5. UML: Class Diagram

Model domain utama beserta enum status dan relasi antar kelas.

```mermaid
classDiagram
    class User {
        +int id
        +string name
        +string email
        +string password
        +UserRole role
        +string phone
        +string organization_name
        +string bio
        +string avatar_path
        +organizedEvents() HasMany~Event~
        +registrations() HasMany~Registration~
        +isAdmin() bool
        +isOrganizer() bool
        +isParticipant() bool
        +avatarUrl() string
    }

    class Category {
        +int id
        +string name
        +string slug
        +string description
        +string color
        +string icon
        +events() HasMany~Event~
        +uniqueSlug(name) string
    }

    class Event {
        +int id
        +int organizer_id
        +int category_id
        +string title
        +string slug
        +string description
        +string venue
        +string city
        +string address
        +datetime starts_at
        +datetime ends_at
        +int capacity
        +decimal price
        +string poster_path
        +EventStatus status
        +bool featured
        +organizer() BelongsTo~User~
        +category() BelongsTo~Category~
        +registrations() HasMany~Registration~
        +seatsTaken() int
        +seatsRemaining() int
        +isSoldOut() bool
        +isFree() bool
        +hasFinished() bool
        +occupancyPercentage() int
    }

    class Registration {
        +int id
        +int event_id
        +int user_id
        +string ticket_code
        +RegistrationStatus status
        +string notes
        +datetime checked_in_at
        +event() BelongsTo~Event~
        +user() BelongsTo~User~
        +generateTicketCode() string
    }

    class UserRole {
        <<enumeration>>
        Admin
        Organizer
        Participant
    }

    class EventStatus {
        <<enumeration>>
        Draft
        Published
        Cancelled
        Completed
    }

    class RegistrationStatus {
        <<enumeration>>
        Pending
        Confirmed
        Cancelled
        Attended
    }

    User "1" --> "0..*" Event : menyelenggarakan
    Category "0..1" --> "0..*" Event : mengelompokkan
    User "1" --> "0..*" Registration : membuat
    Event "1" --> "0..*" Registration : memiliki
    User ..> UserRole : menggunakan
    Event ..> EventStatus : menggunakan
    Registration ..> RegistrationStatus : menggunakan
```

---

## 6. Activity Diagram: Pendaftaran Event oleh Peserta

Alur utama ketika peserta mendaftar event, termasuk penanganan gagal login, peran yang
salah, event berakhir, kuota penuh, dan pendaftaran ganda.

```mermaid
flowchart TD
    Start((Mulai)) --> A["Buka halaman detail event"]
    A --> B{"Sudah login?"}
    B -->|"Tidak"| C["Buka halaman login atau registrasi"]
    B -->|"Ya"| E{"Role pengguna = peserta?"}

    C --> D{"Login berhasil?"}
    D -->|"Tidak"| C
    D -->|"Ya"| E

    E -->|"Tidak"| F["Tampilkan pesan 403"]
    F --> End((Selesai))

    E -->|"Ya"| G{"Event terbit dan belum berakhir?"}
    G -->|"Tidak"| H["Tampilkan 404 atau pesan event berakhir"]
    H --> End

    G -->|"Ya"| I{"Kuota masih tersedia?"}
    I -->|"Tidak"| J["Tampilkan pesan kuota penuh"]
    J --> End

    I -->|"Ya"| K{"Sudah punya pendaftaran aktif?"}
    K -->|"Ya"| L["Tampilkan pesan sudah terdaftar"]
    L --> End

    K -->|"Tidak / berstatus batal"| M["Buat atau aktifkan pendaftaran"]
    M --> N["Generate kode tiket EVS-XXXXXXXX"]
    N --> O["Tampilkan tiket digital dan QR"]
    O --> End
```

---

## 7. Activity Diagram: Pengelolaan Event oleh Penyelenggara

Alur membuat, mengubah, dan menghapus event milik penyelenggara.

```mermaid
flowchart TD
    Start((Mulai)) --> A["Login sebagai penyelenggara"]
    A --> B["Buka dasbor penyelenggara"]
    B --> C["Pilih menu Event Saya"]
    C --> D{"Aksi yang dipilih?"}

    D -->|"Buat event"| E["Isi form event: judul, kategori, jadwal, lokasi, kuota, harga"]
    E --> F["Unggah poster (opsional)"]
    F --> G{"Validasi input berhasil?"}
    G -->|"Tidak"| H["Tampilkan pesan validasi"]
    H --> E
    G -->|"Ya"| I["Simpan event sebagai draf atau terbit"]
    I --> J["Event tampil di daftar Event Saya"]
    J --> End((Selesai))

    D -->|"Ubah event"| K["Pilih event milik sendiri"]
    K --> L["Ubah data event atau poster"]
    L --> M{"Validasi berhasil?"}
    M -->|"Tidak"| N["Tampilkan pesan validasi"]
    N --> L
    M -->|"Ya"| O["Simpan perubahan"]
    O --> End

    D -->|"Hapus event"| P["Pilih event milik sendiri"]
    P --> Q["Konfirmasi penghapusan"]
    Q --> R{"Yakin menghapus?"}
    R -->|"Tidak"| C
    R -->|"Ya"| S["Hapus event, poster, dan pendaftaran terkait"]
    S --> End
```

---

## 8. Activity Diagram: Verifikasi Pendaftaran dan Kehadiran

Alur penyelenggara saat memverifikasi pendaftar dan mencatat kehadiran.

```mermaid
flowchart TD
    Start((Mulai)) --> A["Login sebagai penyelenggara"]
    A --> B["Buka daftar event milik sendiri"]
    B --> C["Pilih event"]
    C --> D["Buka daftar pendaftar"]
    D --> E["Cari atau filter pendaftar"]
    E --> F["Pilih pendaftaran peserta"]
    F --> G{"Status yang ditetapkan?"}

    G -->|"Menunggu"| H["Simpan status pending"]
    G -->|"Terkonfirmasi"| I["Simpan status confirmed"]
    G -->|"Dibatalkan"| J["Simpan status cancelled"]
    G -->|"Hadir"| K["Simpan status attended dan isi checked_in_at"]

    H --> L["Perbarui ringkasan pendaftaran"]
    I --> L
    J --> L
    K --> L
    L --> End((Selesai))
```
