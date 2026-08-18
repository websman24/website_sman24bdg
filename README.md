# Website Resmi SMA Negeri 24 Bandung

Portal Website Resmi **SMA Negeri 24 Bandung** (*Jl. A.H. Nasution No. 27, Kota Bandung, Jawa Barat 40614*). Aplikasi ini dikembangkan menggunakan **Laravel 12**, **PHP 8.2+**, **Tailwind CSS v4**, **Alpine.js**, dan **Vite** dengan arsitektur clean code, Eloquent relationships, unit & feature testing otomatis, serta Portal Admin CMS terpadu.

---

## 📌 Fitur Utama Aplikasi

1. **Website Publik (Public Frontend)**:
   - **Profil Sekolah**: Sejarah Singkat, Visi & Misi, dan Identitas Sekolah.
   - **Berita & Informasi**: Pencarian berita, filter per kategori, paginasi, hitung jumlah tayangan (*views counter*), dan berita terkait.
   - **Akademik**: Direktori Guru & Tenaga Kependidikan (NIP, Gelar, Mapel) dan Kalender Akademik per Semester.
   - **Kesiswaan**: Sub-menu dropdown mencakup **OSIS & MPK** (Profil Kabinet, Visi-Misi, Sambutan Ketua OSIS, Struktur BPH & Sekbid 1-10), **Ekstrakurikuler** (jadwal & pembina), dan **Prestasi Siswa** (Tingkat Kota, Provinsi, Nasional, Internasional).
   - **Galeri Media**: Album foto kegiatan dan embed galeri video YouTube resmi sekolah.
   - **Pusat Unduhan**: Unduh berkas dokumen & formulir resmi dengan pelacak jumlah unduhan (*download counter*).
   - **Layanan SPMB**: Informasi pendaftaran murid baru & alur verifikasi daftar ulang.
   - **Kontak & Lokasi**: Informasi telepon `(022) 7800540`, email `info@sman24bdg.sch.id`, alamat kampus, dan peta lokasi.

2. **Portal Administrasi CMS (`/admin`)**:
   - **Pengaturan Website Dinamis**: Kelola Nama Sekolah, Alamat, Telepon, Email, NPSN, dan Akreditasi.
   - **Manajemen Sekolah & Kesiswaan**: Menu terpisah untuk **Guru** (CRUD, Import CSV, Template), **Tendik** (CRUD, Import CSV, Template), **OSIS & MPK** (Profil Kabinet & CRUD Pengurus BPH/Sekbid), **Prestasi**, dan **Ekstrakurikuler**.
   - **Manajemen Konten CMS**: Berita, Kategori Berita, Pengumuman, Agenda Sekolah, Galeri Foto, Video YouTube, dan Dokumen Unduhan.
   - **Upload Handling**: Upload foto guru/tendik, foto pengurus OSIS, banner kabinet, thumbnail berita, dan berkas PDF/DOCX/ZIP.
   - **Real-time Dashboard Metrics**: Statistik angka riil dari MySQL untuk publikasi dan aktivitas.

---

## 📋 Requirements

- **PHP**: `^8.2` (dengan ekstensi `pdo_mysql`, `mbstring`, `fileinfo`, `openssl`, `curl`)
- **Composer**: `^2.x`
- **Node.js**: `^18.x` atau `^20.x` & **npm**: `^9.x`
- **Database**: MySQL `^8.0` / MariaDB `^10.4` (XAMPP Server)
- **Web Server**: Apache / Nginx (XAMPP)

---

## 🚀 Instalasi & Konfigurasi

### 1. Clone Repositori
```bash
git clone https://github.com/websman24/website_sman24bdg.git
cd website_sman24bdg
```

### 2. Install Dependency PHP & Node.js
```bash
composer install
npm install
```

### 3. Konfigurasi Environment (`.env`)
Salin berkas `.env.example` ke `.env`:
```bash
cp .env.example .env
```

Pastikan konfigurasi database MySQL pada `.env`:
```env
APP_NAME="SMAN 24 Bandung"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=website_sman24bdg
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Jalankan Migration & Database Seeder
Perintah ini akan membuat 17 tabel entitas dan mengisi data awal (termasuk akun admin default & data sekolah):
```bash
php artisan migrate:fresh --seed
```

**Kredensial Login Administrator Default:**
- **URL Login**: `http://localhost:8000/admin/login`
- **Email**: `admin@sman24bdg.sch.id`
- **Password**: `Password24!`

### 6. Link Symbol Storage
```bash
php artisan storage:link
```

---

## 💻 Menjalankan Aplikasi

### 1. Kompilasi Aset Frontend (Vite)
Untuk pengembangan lokal:
```bash
npm run dev
```

Untuk build produksi:
```bash
npm run build
```

### 2. Jalankan Laravel Development Server
```bash
php artisan serve
```
Akses aplikasi melalui browser di [http://localhost:8000](http://localhost:8000).

---

## 🧪 Testing & Pemeriksaan Kualitas Kode

Jalankan test suite otomatis (Unit & Feature Testing):
```bash
php artisan test
```

Lakukan pengecekan status arsitektur & route aplikasi:
```bash
php artisan about
php artisan route:list
```

---

## 📂 Arsitektur & Struktur Folder Penting

```
website_sman24bdg/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/            # Admin CMS Controllers (News, Teachers, Events, Settings, etc.)
│   │   │   ├── Auth/             # Admin Authentication Controllers
│   │   │   └── Public/           # Public Frontend Controllers (Home, Profile, News, SPMB, etc.)
│   │   └── Middleware/           # Admin Access Middleware
│   ├── Models/                   # 17 Eloquent Domain Models
│   └── Services/                 # Business Logic & Upload Services (FileStorageService, NewsService, etc.)
├── database/
│   ├── factories/                # Eloquent Factories for testing & seeding
│   ├── migrations/               # 17 Migration Files for MySQL tables
│   └── seeders/                  # Master DatabaseSeeder
├── resources/
│   ├── css/
│   │   └── app.css               # Design System Tokens & Tailwind CSS v4 Utilities
│   ├── js/
│   │   └── app.js                # Alpine.js & Frontend Scripts
│   └── views/
│       ├── admin/                # Admin CMS Views & Dashboard
│       ├── components/           # Reusable Blade UI Components (button, card, alert, modal, etc.)
│       ├── layouts/              # Public & Admin Master Layouts
│       └── public/               # Public Frontend Views (Home, News, SPMB, Profile, etc.)
├── routes/
│   ├── admin.php                 # Protected Admin CMS Routes
│   └── web.php                   # Public Website Routes
└── tests/
    └── Feature/                  # Automated Test Suite (12 passed, 91 assertions)
```

---

## 📊 Informasi Tahap Pengembangan

| Tahap | Deskripsi | Status |
| :--- | :--- | :---: |
| **Tahap 1** | Setup & Arsitektur Dasar Proyek (Laravel 12, Auth, Layouts, SPMB Header) | **SELESAI** |
| **Tahap 2** | Database & Model (17 Domain Entities, Migrations, Seeders, Factories) | **SELESAI** |
| **Tahap 3** | Fitur & Halaman Website Publik (Profile, News, Teachers, Extracurriculars, Gallery, Downloads, SPMB, Contact) | **SELESAI** |
| **Tahap 3 UI/UX** | Design System & Reusable Component Suite (`<x-button>`, `<x-card>`, `<x-alert>`, `<x-modal>`, `<x-breadcrumb>`) | **SELESAI** |
| **Tahap 4** | Portal Admin CMS Lengkap & Pengaturan Website Dinamis | **SELESAI** |
| **Tahap 5** | File Storage Upload Handling, Automated Test Suite & Final README | **SELESAI** |

---

## 📤 Panduan Push ke GitHub Repository (`websman24`)

Repositori GitHub: [https://github.com/websman24/website_sman24bdg](https://github.com/websman24/website_sman24bdg)

Jalankan perintah berikut di terminal powershell/bash:
```bash
git remote add origin https://github.com/websman24/website_sman24bdg.git
git branch -M main
git push -u origin main
```
*(Gunakan GitHub Personal Access Token jika diminta autentikasi password)*.

---
&copy; {{ date('Y') }} **SMA Negeri 24 Bandung**. All rights reserved.
