# Website Resmi SMA Negeri 24 Bandung

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/Vite-7.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![Database](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)

Aplikasi **Website Resmi SMA Negeri 24 Bandung** yang berlokasi di **Jl. A.H. Nasution No. 27, Kota Bandung, Jawa Barat 40614**. 

Aplikasi ini dikembangkan dengan arsitektur modular, rapi, aman, responsif, dan mudah dipelihara untuk menyajikan informasi publik sekolah serta portal administrasi sekolah.

---

## 📌 Status Tahap Pengembangan

- [x] **Tahap 1: Setup & Arsitektur Dasar Proyek (Selesai)**
  - Setup Laravel 12 & MySQL database `website_sman24bdg`.
  - Sistem autentikasi dasar (Login, Logout, Hashing Bcrypt, Proteksi CSRF, Session handling, Validasi FormRequest).
  - Layer Arsitektur Modular (Controllers, Services, Requests, Middleware, Models).
  - Pemisahan Routing publik (`routes/web.php`) & portal admin (`routes/admin.php`).
  - Layout Website Publik responsif (10 menu navigasi) & Layout Admin profesional (Sidebar, Header, Breadcrumb, Content, Footer).
  - Automated Testing (`php artisan test`) & Frontend Build (`npm run build`).
- [ ] **Tahap 2: Manajemen Konten & Data Sekolah (Tahap Berikutnya)**
  - CRUD Berita, Pengumuman, Agenda Sekolah.
  - Direktori Profil, Guru, dan Tenaga Kependidikan.
- [ ] **Tahap 3: Modul Media & Informasi PPDB (Tahap Mendatang)**
  - Galeri Dokumentasi Foto & Pusat Unduhan Dokumen.
  - Informasi & Portal Pendaftaran PPDB Online.

---

## 📋 Persyaratan Sistem (Requirements)

Sebelum menjalankan project di local environment, pastikan perangkat Anda memenuhi persyaratan berikut:

- **PHP**: `>= 8.2` (dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`)
- **Database**: MySQL `>= 8.0` / MariaDB `>= 10.4`
- **Package Manager PHP**: Composer `>= 2.x`
- **Node.js Environment**: Node.js `>= 18.x` & NPM `>= 9.x`
- **VCS**: Git

---

## 🚀 Panduan Instalasi & Pengoperasian

### 1. Clone Repository
```bash
git clone <repository_url> website_sman24bdg
cd website_sman24bdg
```

### 2. Install Dependensi (PHP & Node.js)
```bash
composer install
npm install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
# Windows PowerShell
copy .env.example .env

# Linux / MacOS
cp .env.example .env
```

Generate **APP_KEY** aplikasi:
```bash
php artisan key:generate
```

Pastikan variabel database pada file `.env` sudah dikonfigurasi sesuai dengan MySQL server lokal Anda:
```env
APP_NAME="SMA Negeri 24 Bandung"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=website_sman24bdg
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Konfigurasi Database & Seeder
Buat database MySQL bernama `website_sman24bdg` di MySQL server lokal (misalnya via phpMyAdmin atau CLI MySQL):
```sql
CREATE DATABASE website_sman24bdg CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Jalankan migrasi tabel dan seeder akun administrator default:
```bash
php artisan migrate:fresh --seed
```

Kredensial **Administrator Default**:
- **Email**: `admin@sman24bdg.sch.id`
- **Password**: `Password24!`
- **Role**: `admin`

### 5. Kompilasi Asset Frontend (Vite)
Kompilasi asset Tailwind CSS & JavaScript untuk mode produksi:
```bash
npm run build
```

Jika Anda ingin menjalankan Vite dalam mode pengawasan perubahan (Development Hot Reloading):
```bash
npm run dev
```

### 6. Menjalankan Server Aplikasi Laravel
Jalankan development server Laravel:
```bash
php artisan serve
```

Akses aplikasi melalui browser:
- **Website Utama (Publik)**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Portal Login Admin**: [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)
- **Dashboard Admin**: [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)

---

## 🧪 Pengujian Aplikasi (Testing)

Jalankan suite pengujian otomatis fitur dan arsitektur aplikasi:
```bash
php artisan test
```

Command pemeriksaan status diagnostik lengkap:
```bash
php artisan about
php artisan route:list
php artisan migrate
php artisan test
npm run build
```

---

## 📂 Struktur Direktori Proyek

```text
website_sman24bdg/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── DashboardController.php      # Controller Dashboard Admin
│   │   │   ├── Auth/
│   │   │   │   └── AuthController.php           # Controller Login & Logout
│   │   │   └── Public/
│   │   │       └── HomeController.php           # Controller Website Utama
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php              # Authorization Admin Check
│   │   └── Requests/
│   │       └── Auth/
│   │           └── LoginRequest.php             # Form Request Validation
│   ├── Models/
│   │   └── User.php                             # User Model (Role & Helpers)
│   └── Services/
│       └── AuthService.php                      # Business Logic Authentication
├── bootstrap/
│   └── app.php                                  # Routing & Middleware Registration
├── database/
│   ├── migrations/                              # Skema Migrasi Database
│   └── seeders/
│       └── DatabaseSeeder.php                   # Seeder User Admin Default
├── resources/
│   ├── css/
│   │   └── app.css                              # Tailwind CSS v4 Styles
│   ├── js/
│   │   └── app.js                              # Alpine.js & JS Bundle
│   └── views/
│       ├── admin/
│       │   └── dashboard.blade.php              # View Dashboard Admin
│       ├── auth/
│       │   └── login.blade.php                  # View Form Login
│       ├── layouts/
│       │   ├── admin/
│       │   │   └── app.blade.php                # Layout Admin Portal
│       │   └── public/
│       │       └── app.blade.php                # Layout Website Publik
│       └── public/
│           └── home.blade.php                   # View Halaman Depan Publik
├── routes/
│   ├── admin.php                                # Route Group Admin (/admin)
│   └── web.php                                  # Route Group Publik & Auth
├── .env.example                                 # Template Environment
├── package.json                                 # Config Dependensi Frontend
├── vite.config.js                               # Config Bundler Vite
└── README.md
```

---

## 🔒 Keamanan (Security Features)

1. **CSRF Protection**: Aktif secara otomatis pada seluruh endpoint form POST (`@csrf`).
2. **Password Hashing**: Menggunakan driver Bcrypt bawaan Laravel (`Hash::make`).
3. **Input Validation**: Menggunakan kustom `FormRequest` untuk mencegah masukan tidak sah.
4. **Isolated Secrets**: Konfigurasi sensitif terisolasi di `.env` yang dikecualikan dari Git repository via `.gitignore`.
5. **No Raw SQL**: Menggunakan Query Builder dan Eloquent ORM.

---

## 🏫 Identitas Sekolah

- **Nama Sekolah**: SMA Negeri 24 Bandung
- **Alamat**: Jl. A.H. Nasution No. 27, Kota Bandung, Jawa Barat 40614
- **Telepon**: (022) 7800540
- **Email**: info@sman24bdg.sch.id
- **Akreditasi**: A (Unggul)
