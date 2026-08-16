# 🚀 PANDUAN DEPLOYMENT PRODUKSI & PELUNCURAN LIVE
**Official Website & CMS Management — SMA Negeri 24 Bandung**

---

## 📌 1. Prasyarat Server (Server Requirements)

- **PHP**: ^8.2 (dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `gd` / `imagick`)
- **Database Engine**: MySQL ^8.0 / MariaDB ^10.4
- **Web Server**: Apache dengan `mod_rewrite` aktif / Nginx
- **Komposisi Asset**: Node.js & NPM (untuk kompilasi `npm run build`)
- **Composer**: ^2.6

---

## ⚙️ 2. Langkah-Langkah Deployment (Deployment Steps)

### Langkah 1: Kloning & Pengaturan Berkas Lingkungan (.env)
```bash
# 1. Masuk ke direktori web server
cd /var/www/website_sman24bdg

# 2. Salin contoh berkas .env
cp .env.example .env

# 3. Kembangkan kunci aplikasi
php artisan key:generate
```

### Langkah 2: Konfigurasi Berkas `.env` Mode Produksi
Edit berkas `.env` pada server dengan nilai berikut:
```env
APP_NAME="SMA Negeri 24 Bandung"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sman24bdg.sch.id

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_produksi
DB_USERNAME=user_database_produksi
DB_PASSWORD=kata_sandi_database_produksi

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
```

### Langkah 3: Install Dependensi & Migrate Database
```bash
# Install paket PHP produksi
composer install --no-dev --optimize-autoloader

# Jalankan migrasi skema database & data awal (Seeder)
php artisan migrate --force
php artisan db:seed --force

# Hubungkan direktori storage publik
php artisan storage:link
```

### Langkah 4: Kompilasi Asset Frontend (Vite)
```bash
npm install
npm run build
```

### Langkah 5: Optimasi Cache Laravel (Production Performance Caching)
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

---

## 🛡️ 3. Hak Akses Direktori Server (Directory Permissions)

Pastikan direktori `storage` dan `bootstrap/cache` memiliki hak akses yang aman dan dapat ditulis oleh web server (`www-data`):

```bash
sudo chown -R www-data:www-data /var/www/website_sman24bdg
sudo chmod -R 775 /var/www/website_sman24bdg/storage
sudo chmod -R 775 /var/www/website_sman24bdg/bootstrap/cache
```

---

## 🔁 4. Pemeliharaan & Prosedur Update Rutin

Saat melakukan pembaruan kode di server live:
```bash
# 1. Aktifkan mode pemeliharaan
php artisan down --secret="sman24-admin-access"

# 2. Tarik update terbaru & jalankan optimasi
git pull origin main
composer install --no-dev --optimize-autoloader
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Matikan mode pemeliharaan
php artisan up
```

---

## ✅ 5. Verifikasi Akhir
- Akses website di `https://sman24bdg.sch.id`
- Akses Portal Admin di `https://sman24bdg.sch.id/admin/login`
- Lakukan pengujian form kontak & pusat unduhan.
