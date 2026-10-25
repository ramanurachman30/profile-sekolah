# 🏫 Portal Resmi & Backoffice Website Profil Sekolah Dasar
**Sistem Informasi Profil Sekolah, PPDB Online, dan Manajemen Backoffice Terpadu**

[![Laravel Version](https://img.shields.io/badge/Laravel-13.x-red.svg?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-blue.svg?style=flat-square&logo=php)](https://php.net)
[![Admin Panel](https://img.shields.io/badge/Backoffice-Filament%20v5-orange.svg?style=flat-square&logo=livewire)](https://filamentphp.com)
[![Database](https://img.shields.io/badge/Database-MySQL%208.0%2B-00758F.svg?style=flat-square&logo=mysql)](https://mysql.com)
[![Akreditasi](https://img.shields.io/badge/BAN--S%2FM-Akreditasi%20A-success.svg?style=flat-square)](#)
[![Kurikulum](https://img.shields.io/badge/Kurikulum-Kurikulum%20Merdeka%20SD-informational.svg?style=flat-square)](#)

---

## 📌 Latar Belakang & Gambaran Sistem

Sistem ini merupakan aplikasi web profil sekolah terpadu untuk institusi pendidikan dasar formal (Sekolah Dasar Negeri). Dirancang dengan standar pendidikan modern ramah anak, platform ini mengintegrasikan implementasi **Kurikulum Merdeka** (Fase A, Fase B, dan Fase C), Projek Penguatan Profil Pelajar Pancasila (P5), pembiasaan budi pekerti 5S (*Senyum, Salam, Sapa, Sopan, Santun*), serta tata kelola administrasi sekolah berbasis lingkungan Adiwiyata.

Aplikasi ini dibangun menggunakan arsitektur **satu sistem monolit terpadu (*Single Workspace Unified Architecture*)** yang menyatukan portal publik dan panel manajemen internal:
1. **Frontoffice (Portal Publik)**: Sarana transparansi informasi bagi calon orang tua murid, masyarakat, dan dinas pendidikan terkait profil sekolah, kurikulum, prestasi siswa, warta kegiatan, formulir pendaftaran PPDB online interaktif, hingga layanan tiket aduan dan reservasi kunjungan (*School Visit*).
2. **Backoffice (Admin Panel)**: Pusat operasional berbasis peran (RBAC 4 Role) untuk verifikasi berkas PPDB calon peserta didik baru, penataan rombongan belajar (rombel), inventaris sarana prasarana, publikasi dokumentasi kegiatan, serta disposisi tindak lanjut pesan aduan.

---

## 🛠️ Tech Stack & Ekosistem Teknologi

### 1. Backend & Framework Core
- **Framework Core**: [Laravel 13](https://laravel.com) (PHP 8.3+)
- **Architecture**: Monolit Terpadu (MVC + Service Layer + Filament Panel)
- **Database Engine**: MySQL 8.0+ / MariaDB 10.5+ (InnoDB `ROW_FORMAT=DYNAMIC`)
- **Autentikasi**: Custom Auth Guard berbasis tabel `sys_users` dengan password hashing Bcrypt.

### 2. Backoffice (Admin Panel)
- **Admin Engine**: [Filament Admin PHP v5](https://filamentphp.com) (TALL Stack)
- **Komponen**: Livewire 4, Alpine.js, Tailwind CSS
- **Fitur Khusus**: Modal preview berkas KK/Akta/KIA, filter multi-kolom, tindakan 1-klik *Auto-Enrollment* siswa baru ke master data, badge status tiket interaktif, dan ekspor data.

### 3. Frontoffice (Portal Publik)
- **Templating**: Laravel Blade Components + Partial Layouts
- **Styling**: Tailwind CSS (JIT Engine) dengan palet warna pendidikan formal:
  - `primary`: `#00236f` (Navy berwibawa khas pendidikan formal)
  - `secondary`: `#ffb020` (Emas cerah keceriaan pendidikan dasar)
  - `surface`: `#f7f9fb` (Latar modern ramah mata)
- **Tipografi**: [Plus Jakarta Sans](https://fonts.google.com/specimen/Plus+Jakarta+Sans) (Google Fonts)
- **Ikonografi**: [Google Material Symbols Outlined](https://fonts.google.com/icons)
- **Frontend Script**: Vanilla JavaScript ES6+ (Mobile navigation drawer, filter galeri & prestasi, lightbox modal foto, serta validasi formulir)

### 4. Media & Storage Infrastructure
- **Sentralisasi Aset (`sys_media_assets`)**: Mencegah duplikasi penyimpanan file fisik pada server.
- **Auto-WebP Converter**: Layanan `MediaAssetService` mengonversi seluruh gambar unggahan ke format `.webp` berkualitas optimal (85%) secara otomatis menggunakan PHP GD extension.

---

## 🗄️ Arsitektur Database & Konvensi Penamaan

Basis data dirancang dengan standar **3NF (Third Normal Form)**, ultra-ringan, dan hemat penggunaan memori RAM server. Semua tabel dikelompokkan dengan awalan fungsional:

```
database_sekolah
├── 1. sys_* : Sistem & Infrastruktur Keamanan
│   ├── sys_media_assets         : Repositori sentral metadata file foto/dokumen (WebP)
│   └── sys_users                : Akun otentikasi 4 role RBAC & log aktivitas
│
├── 2. mst_* : Master Data & Referensi Entitas
│   ├── mst_school_profile       : Profil resmi sekolah (NPSN, akreditasi, visi-misi)
│   ├── mst_academic_years       : Tahun ajaran & semester aktif (contoh: 2026/2027)
│   ├── mst_curriculum_phases    : Fase Kurikulum Merdeka (Fase A, Fase B, Fase C)
│   ├── mst_grades               : Tingkat kelas 1–6 SD & jadwal jam kepulangan bertahap
│   ├── mst_subjects             : Mata pelajaran SD (wajib, muatan lokal, pilihan)
│   ├── mst_teachers             : Dewan guru/GTK, NIP 18 digit, jam konsultasi ortu
│   ├── mst_character_habits     : Pembiasaan karakter (5S, Dhuha, Pojok Baca, Adiwiyata)
│   ├── mst_extracurriculars     : Katalog 8 ekskul SD & relasi guru pembina
│   ├── mst_facility_categories  : Kategori sarpras (Ruang Belajar, Lab Komputer, UKS)
│   ├── mst_facilities           : Data fisik fasilitas dan status kondisi
│   ├── mst_achievement_categories: Kategori lomba (FLS2N, O2SN, OSN, Pramuka)
│   ├── mst_gallery_categories   : Album dokumentasi (P5, Belajar, Seni, Upacara)
│   ├── mst_news_categories      : Kategori warta & pengumuman resmi
│   └── mst_students             : Master peserta didik (NISN, NIK, alamat, data wali)
│
├── 3. rel_* : Pemetaan & Junction Table (Many-to-Many)
│   ├── rel_classes              : Rombel kelas aktif, penugasan wali kelas & kapasitas
│   ├── rel_student_extracurriculars : Pendaftaran anggota ekskul per tahun ajaran
│   └── rel_achievement_recipients  : Multi-siswa penerima penghargaan kejuaraan
│
├── 4. trn_* : Transaksi Operasional & Layanan Publik
│   ├── trn_achievements         : Pencatatan perolehan medali & foto bersama ortu/guru
│   ├── trn_gallery_items        : Publikasi foto dokumentasi & video embed YouTube
│   ├── trn_news_articles        : Publikasi artikel berita, agenda & pengumuman
│   ├── trn_ppdb_periods         : Gelombang pendaftaran PPDB SD & target kuota kursi
│   ├── trn_ppdb_registrations   : Formulir pendaftaran online (NIK, zonasi, KK, Akta, KIA)
│   ├── trn_contact_inquiries    : Layanan tiket pesan/aduan orang tua (PESAN-SD-xxxx)
│   └── trn_school_visits        : Reservasi janji temu kunjungan sekolah (KUNJUNGAN-SD-xxxx)
│
└── 5. v_*   : Database Views untuk Query Berkecepatan Tinggi
    ├── v_active_students        : Data siswa aktif terintegrasi rombel, tingkat, dan wali
    ├── v_achievement_showcase   : Showcase prestasi siap tayang di beranda
    └── v_ppdb_dashboard         : Rekap pendaftar per gelombang vs kuota penerimaan
```

---

## 👥 Matriks Hak Akses Pengguna (RBAC 4 Role)

Sistem membagi hak akses ke dalam 4 tingkatan peran yang diatur melalui kolom `role` pada tabel `sys_users`:

| Modul / Menu Backoffice | Superadmin (Kepsek / IT) | Admin TU (Tata Usaha) | Guru Humas (Publikasi) | Panitia PPDB |
| :--- | :---: | :---: | :---: | :---: |
| **Dashboard Utama & Statistik** | 🟢 Akses Penuh | 🟡 Ringkasan TU | 🟡 Ringkasan Humas | 🟡 Statistik PPDB |
| **Identitas & Profil Sekolah** | 🟢 Akses Penuh | 🔵 Baca Saja | 🔵 Baca Saja | ❌ Tidak Ada |
| **Tahun Ajaran & Kurikulum SD** | 🟢 Akses Penuh | 🟢 Akses Penuh | 🔵 Baca Saja | 🔵 Baca Saja |
| **Dewan Guru & GTK (`mst_teachers`)** | 🟢 Akses Penuh | 🟢 Akses Penuh | 🔵 Baca Saja | ❌ Tidak Ada |
| **Rombel & Data Siswa (`mst_students`)** | 🟢 Akses Penuh | 🟢 Akses Penuh | 🔵 Baca Saja | 🔵 Baca Saja |
| **Inventaris Sarana & Prasarana** | 🟢 Akses Penuh | 🟢 Akses Penuh | ❌ Tidak Ada | ❌ Tidak Ada |
| **Katalog Ekskul & Pembiasaan 5S** | 🟢 Akses Penuh | 🔵 Baca Saja | 🟢 Akses Penuh | ❌ Tidak Ada |
| **Berita & Dokumentasi Galeri** | 🟢 Akses Penuh | 🔵 Baca Saja | 🟢 Akses Penuh | ❌ Tidak Ada |
| **Pencatatan Prestasi Kejuaraan** | 🟢 Akses Penuh | 🔵 Baca Saja | 🟢 Akses Penuh | ❌ Tidak Ada |
| **Verifikasi Calon Siswa PPDB** | 🟢 Akses Penuh | 🔵 Baca Saja | ❌ Tidak Ada | 🟢 Akses Penuh |
| **Tiket Aduan & Kunjungan Sekolah** | 🟢 Akses Penuh | 🟢 Akses Penuh (PIC) | 🟡 Disposisi Tugas | ❌ Tidak Ada |
| **Pusat Media (`sys_media_assets`)** | 🟢 Akses Penuh | 🟢 Upload / Pilih | 🟢 Upload / Pilih | 🟢 Upload Berkas |
| **Manajemen Pengguna (`sys_users`)** | 🟢 Akses Penuh | ❌ Tidak Ada | ❌ Tidak Ada | ❌ Tidak Ada |

### Kredensial Pengujian Bawaan (Demo / Development)
> **Password Standar untuk seluruh akun demo**: `password123`

| Username | Role | Peruntukan Tugas Operasional |
|:---|:---|:---|
| `superadmin` | `superadmin` | Kepala Sekolah / Administrator Sistem (Hak Akses Penuh) |
| `admin_tu` | `admin_tu` | Staf Tata Usaha (Administrasi Siswa, Sarpras & Tiket Layanan) |
| `guru_humas` | `guru_humas` | Tim Humas & Dewan Guru (Publikasi Berita, Galeri & Prestasi) |
| `panitia_ppdb` | `panitia_ppdb` | Panitia PPDB (Verifikasi Berkas Pendaftaran Calon Siswa Baru) |

---

## 🌐 Struktur 10 Halaman Frontoffice (Portal Publik)

| No | Rute Halaman | View Blade | Sumber Data Utama | Deskripsi Konten |
|:---:|:---|:---|:---|:---|
| 1 | `/` (`home`) | `frontend.home` | `mst_school_profile`, `v_achievement_showcase`, `trn_news_articles`, `trn_ppdb_periods` | Sambutan Kepala Sekolah, keunggulan akreditasi, ringkasan prestasi, warta terkini, dan CTA pendaftaran PPDB. |
| 2 | `/profil` (`profile`) | `frontend.profile` | `mst_school_profile`, `mst_teachers` | Sejarah sekolah, visi & misi Profil Pelajar Pancasila, struktur organisasi, dan direktori dewan guru kelas 1–6. |
| 3 | `/akademik` (`academic`) | `frontend.academic` | `mst_curriculum_phases`, `mst_grades`, `mst_subjects` | Penjelasan Kurikulum Merdeka Fase A (Kls 1–2), B (Kls 3–4), C (Kls 5–6), jam kepulangan bertahap (10.30–12.30 WIB), dan daftar mata pelajaran. |
| 4 | `/kesiswaan` (`student-affairs`) | `frontend.student-affairs` | `mst_extracurriculars`, `mst_character_habits` | Katalog 8 ekskul ramah anak (Pramuka Siaga, Futsal, Tari Tradisional, Dokcil UKS) dan pembiasaan budi pekerti 5S & Sholat Dhuha. |
| 5 | `/fasilitas` (`facilities`) | `frontend.facilities` | `mst_facility_categories`, `mst_facilities` | Dokumentasi ruang kelas nyaman, perpustakaan ramah anak, lab komputer ANBK SD, ruang UKS, musholla, dan lapangan olahraga. |
| 6 | `/prestasi` (`achievements`) | `frontend.achievements` | `v_achievement_showcase`, `mst_achievement_categories` | Galeri piala dan medali kejuaraan lomba (FLS2N, O2SN, OSN, Pramuka) di tingkat kecamatan, kabupaten, dan provinsi. |
| 7 | `/berita` (`news.index`) | `frontend.news.index` | `trn_news_articles`, `mst_news_categories` | Pengumuman resmi sekolah, dokumentasi Gelar Karya P5, kegiatan hari besar nasional, dan warta Adiwiyata. |
| 8 | `/galeri` (`gallery`) | `frontend.gallery` | `trn_gallery_items`, `mst_gallery_categories` | Dokumentasi visual interaktif foto kegiatan sekolah dan penampil video YouTube terintegrasi. |
| 9 | `/ppdb` (`ppdb.index`) | `frontend.ppdb.index` | `trn_ppdb_periods`, `trn_ppdb_registrations` | Informasi kuota gelombang aktif, syarat usia masuk SD, formulir pendaftaran interaktif (upload KK/Akta/KIA), dan kode tiket `PPDB-SD-2027-xxxx`. |
| 10 | `/kontak` (`contact.index`) | `frontend.contact` | `mst_school_profile`, `trn_contact_inquiries`, `trn_school_visits` | Peta lokasi Google Maps, formulir pesan aduan orang tua (`PESAN-SD-xxxx`), dan formulir reservasi kunjungan sekolah (`KUNJUNGAN-SD-xxxx`). |

---

## 📁 Struktur Direktori Proyek

```
profile-sekolah/
├── app/
│   ├── Filament/                        # Modul Backoffice Filament Admin
│   │   ├── Pages/
│   │   │   └── Auth/
│   │   │       └── Login.php            # Custom Login mendukung username/email
│   │   ├── Resources/                   # Resource CRUD untuk masing-masing modul
│   │   └── Widgets/                     # Widget statistik dashboard
│   ├── Http/
│   │   └── Controllers/
│   │       └── Frontend/                # Controller untuk halaman Frontoffice
│   ├── Models/                          # 24 Model Eloquent Lengkap
│   │   ├── User.php                     # Authenticatable + FilamentUser + HasName
│   │   ├── MediaAsset.php               # Model sentral metadata file
│   │   ├── SchoolProfile.php            # Identitas sekolah (Singleton)
│   │   ├── AcademicYear.php
│   │   ├── CurriculumPhase.php
│   │   ├── Grade.php
│   │   ├── Subject.php
│   │   ├── Teacher.php
│   │   ├── CharacterHabit.php
│   │   ├── Extracurricular.php
│   │   ├── FacilityCategory.php
│   │   ├── Facility.php
│   │   ├── AchievementCategory.php
│   │   ├── GalleryCategory.php
│   │   ├── NewsCategory.php
│   │   ├── Student.php
│   │   ├── ClassRoom.php
│   │   ├── Achievement.php
│   │   ├── GalleryItem.php
│   │   ├── NewsArticle.php
│   │   ├── PpdbPeriod.php
│   │   ├── PpdbRegistration.php
│   │   ├── ContactInquiry.php
│   │   └── SchoolVisit.php
│   ├── Providers/
│   │   ├── AppServiceProvider.php
│   │   └── Filament/
│   │       └── AdminPanelProvider.php   # Registrasi panel /admin & RBAC
│   └── Services/
│       ├── MediaAssetService.php        # Service kompresi otomatis WebP via GD
│       ├── PpdbEnrollmentService.php    # Alur 1-klik approval pendaftaran siswa baru
│       └── InquiryTicketService.php     # Service penomoran tiket pesan & booking
│
├── bootstrap/
│   ├── app.php
│   └── providers.php
│
├── config/                              # Konfigurasi sistem Laravel
├── database/                            # Migrations & database factory
│
├── public/
│   ├── frontend/                        # Aset publik untuk Frontoffice Portal
│   │   ├── css/
│   │   │   └── styles.css               # Styling kustom (scrollbar, shadow, glass-card)
│   │   └── js/
│   │       ├── main.js                  # Script interaktif (drawer, modal, filter)
│   │       └── tailwind-config.js       # Konfigurasi warna sekolah kustom
│   ├── storage/                         # Symlink ke storage/app/public
│   ├── index.php
│   └── robots.txt
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── frontend.blade.php       # Layout master Portal Publik
│       ├── partials/
│       │   ├── frontend-header.blade.php# Header topbar, navigasi & drawer mobile
│       │   └── frontend-footer.blade.php# Footer resmi, link halaman & kontak
│       └── frontend/                    # View 10 halaman portal sekolah
│           ├── home.blade.php
│           ├── profile.blade.php
│           ├── academic.blade.php
│           ├── student-affairs.blade.php
│           ├── facilities.blade.php
│           ├── achievements.blade.php
│           ├── news/
│           │   ├── index.blade.php
│           │   └── show.blade.php
│           ├── gallery.blade.php
│           ├── ppdb/
│           │   ├── index.blade.php
│           │   └── success.blade.php
│           └── contact.blade.php
│
├── routes/
│   ├── web.php                          # 10 rute publik & rute internal
│   └── console.php
│
├── storage/
│   └── app/
│       └── public/
│           └── uploads/                 # Berkas terunggah (organisasi tahun/bulan)
│
├── .env                                 # Konfigurasi database & environment
├── artisan                              # Laravel CLI
├── composer.json
├── package.json
└── README.md
```

---

## 🚀 Panduan Memulai (Instalasi & Pengoperasian)

### 1. Prasyarat Sistem
- **PHP**: Versi `>= 8.3` dengan ekstensi aktif: `pdo_mysql`, `gd` (dengan WebP support), `mbstring`, `fileinfo`, `intl`, `curl`.
- **Composer**: Versi `>= 2.2`
- **Database**: MySQL `>= 8.0` atau MariaDB `>= 10.5`
- **Web Browser**: Google Chrome, Mozilla Firefox, Microsoft Edge, atau Safari modern.

### 2. Langkah Instalasi

1. **Clone / Buka Repositori**:
   Pastikan direktori aktif berada di folder `profile-sekolah`.

2. **Instal Dependensi Composer**:
   ```bash
   composer install
   ```

3. **Konfigurasi Environment (`.env`)**:
   Salin berkas `.env.example` ke `.env` (jika belum ada) dan sesuaikan konfigurasi basis data:
   ```ini
   APP_NAME="SDN Cikereteg 01"
   APP_ENV=local
   APP_URL=http://localhost:8000
   APP_TIMEZONE="Asia/Jakarta"
   APP_LOCALE=id

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_sdn_[nama_sekolah]
   DB_USERNAME=root
   DB_PASSWORD=

   FILESYSTEM_DISK=public
   ```

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Hubungkan Storage Link**:
   ```bash
   php artisan storage:link
   ```

6. **Impor Basis Data & Data Awal**:
   Impor berkas skema [sdn_[nama_sekolah]_schema.sql](file:///e:/project-pribadi/coding/laravel/profile-sekolah/sdn_[nama_sekolah]_schema.sql) ke database MySQL `db_sdn_[nama_sekolah]`:
   ```bash
   mysql -u root db_sdn_[nama_sekolah] < sdn_[nama_sekolah]_schema.sql
   ```

7. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   - **Portal Publik (Frontoffice)**: [http://localhost:8000](http://localhost:8000)
   - **Panel Admin (Backoffice)**: [http://localhost:8000/admin](http://localhost:8000/admin)

---

## 🔒 Keamanan & Praktik Terbaik

- **Proteksi CSRF**: Seluruh formulir pendaftaran publik dan panel admin dilindungi oleh token CSRF Laravel.
- **Validasi Berkas Ketat**: Berkas yang diunggah divalidasi tipe MIME dan ekstensi aslinya untuk mencegah eksekusi skrip berbahaya.
- **Sanitasi Data Input**: Mencegah serangan *SQL Injection* menggunakan *Prepared Statements* Eloquent ORM.
- **Rate Limiting Login**: Pembatasan percobaan login pada panel Filament untuk mencegah serangan *brute-force*.

---

## 📄 Lisensi & Hak Cipta

© 2026–2027 **[NAMA SEKOLAH]**. Seluruh hak cipta dilindungi undang-undang.  
Dikembangkan untuk mendukung kemajuan pendidikan dasar negeri di [Kecamatan], [Kabupaten], [Provinsi].
