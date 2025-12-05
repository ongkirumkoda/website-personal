# 🚀 CARA INSTALL SIRAGA FIX

**Versi:** 1.0.1 (Fixed)  
**Tanggal:** Desember 2024

---

## 📋 Yang Ada di Package Ini

File-file perbaikan untuk mengatasi error "404 Not Found" di SIRAGA:

```
siraga-fix/
├── .htaccess           ← Apache rewrite configuration (FIXED)
├── .env                ← Environment configuration (FIXED)
├── index.php           ← Entry point (FIXED)
├── Router.php          ← Router class (FIXED)
├── test.php            ← System diagnostic tool
├── httpd.conf.example  ← Apache configuration reference
└── CARA_INSTALL.md     ← Panduan ini
```

---

## ⚡ INSTALL CEPAT (5 Menit)

### Step 1: Backup File Lama

```bash
# Backup file yang akan diganti
cp .htaccess .htaccess.backup
cp .env .env.backup
cp index.php index.php.backup
cp app/core/Router.php app/core/Router.php.backup
```

### Step 2: Copy File Baru

```bash
# Copy file dari siraga-fix ke root project
cp siraga-fix/.htaccess ./
cp siraga-fix/.env ./
cp siraga-fix/index.php ./
cp siraga-fix/test.php ./
cp siraga-fix/Router.php app/core/
```

**Atau manual:**
- Copy `siraga-fix/.htaccess` → `siraga/.htaccess`
- Copy `siraga-fix/.env` → `siraga/.env`
- Copy `siraga-fix/index.php` → `siraga/index.php`
- Copy `siraga-fix/Router.php` → `siraga/app/core/Router.php`
- Copy `siraga-fix/test.php` → `siraga/test.php`

### Step 3: Sesuaikan Konfigurasi

Edit file `.htaccess`, cari baris ini:

```apache
RewriteBase /siraga/
```

**Sesuaikan dengan lokasi folder Anda:**
- Jika di `http://localhost/siraga/` → `RewriteBase /siraga/`
- Jika di `http://localhost/` → `RewriteBase /`
- Jika di `http://localhost/myproject/` → `RewriteBase /myproject/`

Edit file `.env`, cari baris ini:

```env
APP_URL=http://localhost/siraga
BASE_PATH=/siraga
```

**Sesuaikan dengan lokasi folder Anda:**
- Jika di `http://localhost/siraga/`:
  ```env
  APP_URL=http://localhost/siraga
  BASE_PATH=/siraga
  ```
- Jika di `http://localhost/`:
  ```env
  APP_URL=http://localhost
  BASE_PATH=/
  ```

### Step 4: Aktifkan mod_rewrite di Apache

**XAMPP/WAMP:**

1. Buka file `httpd.conf` (biasanya di `C:\xampp\apache\conf\httpd.conf`)

2. Cari baris ini dan **hapus tanda #** di depannya:
   ```apache
   LoadModule rewrite_module modules/mod_rewrite.so
   ```

3. Cari bagian `<Directory>` dan ubah `AllowOverride None` menjadi `AllowOverride All`:
   ```apache
   <Directory "C:/xampp/htdocs">
       AllowOverride All
       Require all granted
   </Directory>
   ```

4. **Save** dan **Restart Apache** dari XAMPP Control Panel

### Step 5: Test Sistem

Buka browser dan akses:
```
http://localhost/siraga/test.php
```

Cek apakah semua status menunjukkan ✅ (hijau).

**Yang harus ✅:**
- PHP Version: ✅ 7.4+
- mod_rewrite: ✅ Aktif
- .htaccess: ✅ Exists
- .env: ✅ Exists

### Step 6: Test Website

Akses halaman utama:
```
http://localhost/siraga/
```

Jika muncul homepage SIRAGA, **SELAMAT! Instalasi berhasil!** 🎉

Test halaman lain:
- Login: `http://localhost/siraga/auth/login`
- Register: `http://localhost/siraga/auth/register`
- Dashboard: `http://localhost/siraga/dashboard`

---

## 🔧 TROUBLESHOOTING

### Problem 1: Still 404 Error

**Solusi:**
1. Clear browser cache (Ctrl+F5)
2. Test di Incognito Mode
3. Pastikan mod_rewrite aktif
4. Check `RewriteBase` di `.htaccess` sudah sesuai
5. Check `BASE_PATH` di `.env` sudah sesuai

### Problem 2: mod_rewrite Not Active

**Solusi:**
```apache
# Edit httpd.conf, uncomment baris ini:
LoadModule rewrite_module modules/mod_rewrite.so

# Restart Apache
```

### Problem 3: Composer Dependencies Missing

**Solusi:**
```bash
composer install
```

Atau jika Composer belum terinstall:
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php composer.phar install
```

### Problem 4: Database Connection Error

**Solusi:**
Edit `.env`:
```env
DB_NAME=siraga_db
DB_USER=root
DB_PASS=           ← Kosongkan jika default XAMPP
```

Buat database:
```bash
php database/migrations/migrate.php
```

### Problem 5: Permission Denied

**Solusi (Linux/Mac):**
```bash
chmod 644 .htaccess
chmod 644 .env
chmod 755 storage/
chmod 755 storage/logs/
```

---

## 📚 File-File yang Diperbaiki

### 1. `.htaccess`
- ✅ Fixed RewriteBase configuration
- ✅ Added proper RewriteCond
- ✅ Improved security headers
- ✅ Added development mode settings

### 2. `.env`
- ✅ Added BASE_PATH configuration
- ✅ Fixed APP_URL format
- ✅ Added detailed comments
- ✅ Proper default values

### 3. `index.php`
- ✅ Better error handling
- ✅ Improved .env loader
- ✅ Added dependency checks
- ✅ Better debug messages

### 4. `Router.php`
- ✅ Fixed path matching logic
- ✅ Better URI normalization
- ✅ Improved base path handling
- ✅ Enhanced debug mode
- ✅ Better 404 handling

---

## ✅ Checklist Setelah Install

- [ ] Test homepage: `http://localhost/siraga/`
- [ ] Test login page: `http://localhost/siraga/auth/login`
- [ ] Test register: `http://localhost/siraga/auth/register`
- [ ] Test dashboard: `http://localhost/siraga/dashboard`
- [ ] Check system test: `http://localhost/siraga/test.php`
- [ ] Database terkoneksi dengan baik
- [ ] Tidak ada error 404
- [ ] Tidak ada error 500

---

## 🆘 Masih Bermasalah?

### Quick Debug Steps:

1. **Akses test.php:**
   ```
   http://localhost/siraga/test.php
   ```
   Lihat apa yang merah (❌)

2. **Check Apache Error Log:**
   ```
   C:\xampp\apache\logs\error.log  (Windows)
   /var/log/apache2/error.log       (Linux)
   ```

3. **Test direct access:**
   ```
   http://localhost/siraga/index.php?url=auth/login
   ```
   Jika ini work, berarti masalah di .htaccess

4. **Enable Debug Mode:**
   Edit `.env`:
   ```env
   APP_DEBUG=true
   ```
   
   Akses URL dengan parameter debug:
   ```
   http://localhost/siraga/?debug=1
   ```

---

## 📞 Support

Jika masih error, screenshot:
1. Hasil dari `test.php`
2. Error message yang muncul
3. Apache error log (5 baris terakhir)
4. Struktur folder Anda

---

## 🎉 Setelah Berhasil

Setelah website berjalan normal:

1. **Disable debug mode** (production):
   ```env
   APP_DEBUG=false
   ```

2. **Hapus test.php:**
   ```bash
   rm test.php
   ```

3. **Setup database:**
   ```bash
   php database/migrations/migrate.php
   ```

4. **Login dengan:**
   - Email: `admin@siraga.com`
   - Password: `admin123`

---

**Good luck! 🚀**
