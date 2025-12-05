# 📦 Panduan Instalasi SIRAGA

Dokumen ini berisi panduan lengkap instalasi SIRAGA dari awal hingga siap digunakan.

---

## 📋 Persiapan

### 1. System Requirements Check

Sebelum instalasi, pastikan sistem Anda memenuhi requirements:

```bash
# Check PHP version (minimum 7.4)
php -v

# Check PHP extensions
php -m | grep -E 'pdo_mysql|mbstring|openssl|curl|json|gd'

# Check MySQL/MariaDB
mysql --version

# Check Composer
composer --version
```

### 2. Download/Clone Project

#### Via Git Clone
```bash
git clone https://github.com/yourusername/siraga.git
cd siraga
```

#### Via Download ZIP
1. Download ZIP dari GitHub
2. Extract ke folder web server (htdocs/www)
3. Rename folder ke `siraga`

---

## 🔧 Instalasi Step-by-Step

### Step 1: Install Dependencies

```bash
cd siraga
composer install
```

Jika muncul error, coba:
```bash
composer install --no-dev --optimize-autoloader
```

Expected output:
```
Loading composer repositories with package information
Installing dependencies from lock file
...
Generating optimized autoload files
```

### Step 2: Setup Environment File

```bash
# Copy template .env
cp .env.example .env

# Edit file .env
nano .env
# atau
vim .env
# atau buka dengan text editor
```

**Konfigurasi minimal yang HARUS diisi:**

```env
# Database (WAJIB)
DB_HOST=localhost
DB_NAME=siraga_db
DB_USER=root
DB_PASS=your_mysql_password

# Application (WAJIB)
APP_URL=http://localhost/siraga
APP_KEY=generateRandomString32Characters

# Email (OPTIONAL tapi recommended)
MAIL_USERNAME=your.email@gmail.com
MAIL_PASSWORD=your_app_password
```

**Generate APP_KEY:**
```bash
# Linux/Mac
openssl rand -base64 32

# Windows (PowerShell)
[Convert]::ToBase64String((1..32 | ForEach-Object { Get-Random -Maximum 256 }))
```

### Step 3: Create Database

#### Option A: Via Migration Script (Recommended)

```bash
php database/migrations/migrate.php
```

Expected output:
```
Creating database 'siraga_db' if not exists...
✓ Database created/verified

Running migrations...
--------------------------------------------------
Running: 001_create_users_table.sql
✓ Completed: 001_create_users_table.sql

Running: 002_create_children_table.sql
✓ Completed: 002_create_children_table.sql

Running: 003_create_measurements_table.sql
✓ Completed: 003_create_measurements_table.sql

Running: 004_create_immunizations_table.sql
✓ Completed: 004_create_immunizations_table.sql

Running: 005_create_sessions_table.sql
✓ Completed: 005_create_sessions_table.sql

Running: 006_create_notifications_table.sql
✓ Completed: 006_create_notifications_table.sql

Running: 007_create_activity_logs_table.sql
✓ Completed: 007_create_activity_logs_table.sql

--------------------------------------------------
✓ All migrations completed successfully!

Database Summary:
--------------------------------------------------
- users: 1 row(s)
- children: 0 row(s)
- measurements: 0 row(s)
- immunizations: 0 row(s)
- sessions: 0 row(s)
- notifications: 0 row(s)
- activity_logs: 0 row(s)

✓ Migration process completed!
```

#### Option B: Manual via MySQL

```bash
# Login ke MySQL
mysql -u root -p

# Create database
CREATE DATABASE siraga_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Use database
USE siraga_db;

# Import SQL files satu per satu
SOURCE /path/to/siraga/database/migrations/001_create_users_table.sql;
SOURCE /path/to/siraga/database/migrations/002_create_children_table.sql;
SOURCE /path/to/siraga/database/migrations/003_create_measurements_table.sql;
SOURCE /path/to/siraga/database/migrations/004_create_immunizations_table.sql;
SOURCE /path/to/siraga/database/migrations/005_create_sessions_table.sql;
SOURCE /path/to/siraga/database/migrations/006_create_notifications_table.sql;
SOURCE /path/to/siraga/database/migrations/007_create_activity_logs_table.sql;

# Exit MySQL
EXIT;
```

### Step 4: Set File Permissions

#### Linux/Mac:
```bash
# Set ownership (ganti www-data dengan user web server Anda)
sudo chown -R www-data:www-data /path/to/siraga

# Set permissions
chmod -R 755 /path/to/siraga
chmod -R 777 /path/to/siraga/logs
chmod -R 777 /path/to/siraga/public/uploads

# Create required directories
mkdir -p logs public/uploads storage/cache
chmod -R 777 logs public/uploads storage
```

#### Windows (XAMPP):
```
Tidak perlu setting khusus, pastikan folder bisa diakses oleh Apache
```

### Step 5: Configure Web Server

#### Apache (Recommended)

File `.htaccess` sudah included, tapi pastikan `mod_rewrite` enabled:

```bash
# Enable mod_rewrite
sudo a2enmod rewrite

# Restart Apache
sudo systemctl restart apache2
# atau
sudo service apache2 restart
```

**VirtualHost Configuration (Optional):**

Edit file: `/etc/apache2/sites-available/siraga.conf`

```apache
<VirtualHost *:80>
    ServerName siraga.local
    ServerAlias www.siraga.local
    DocumentRoot /path/to/siraga
    
    <Directory /path/to/siraga>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/siraga-error.log
    CustomLog ${APACHE_LOG_DIR}/siraga-access.log combined
</VirtualHost>
```

Enable site:
```bash
sudo a2ensite siraga.conf
sudo systemctl restart apache2
```

Add to `/etc/hosts`:
```
127.0.0.1   siraga.local
```

#### Nginx

Create file: `/etc/nginx/sites-available/siraga`

```nginx
server {
    listen 80;
    server_name siraga.local;
    root /path/to/siraga;
    
    index index.php index.html;
    
    # Logging
    access_log /var/log/nginx/siraga-access.log;
    error_log /var/log/nginx/siraga-error.log;
    
    # Main location
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    # PHP processing
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    # Deny access to sensitive files
    location ~ /\.(ht|env|git) {
        deny all;
    }
    
    # Security headers
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";
}
```

Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/siraga /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

---

## 🧪 Testing Installation

### 1. Test Database Connection

Create file: `test-db.php`
```php
<?php
require_once 'config/env.php';
require_once 'app/core/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    echo "✓ Database connection successful!\n";
    
    $stmt = $db->query("SELECT COUNT(*) as count FROM users");
    $result = $stmt->fetch();
    echo "✓ Users table exists with {$result['count']} users\n";
} catch (Exception $e) {
    echo "✗ Database error: " . $e->getMessage() . "\n";
}
```

Run:
```bash
php test-db.php
```

### 2. Test Web Access

Open browser and navigate to:
```
http://localhost/siraga
atau
http://siraga.local
```

You should see the SIRAGA landing page.

### 3. Test Login

Default admin account:
- **Email**: admin@siraga.com
- **Password**: admin123

Navigate to:
```
http://localhost/siraga/login
```

Try logging in with default credentials.

---

## 🔑 Post-Installation Setup

### 1. Change Default Admin Password

1. Login sebagai admin
2. Go to Profile → Change Password
3. Masukkan password baru yang kuat

### 2. Configure Email (Optional)

Untuk fitur email notifications:

#### Gmail Setup:
1. Enable 2-Factor Authentication
2. Generate App Password: https://myaccount.google.com/apppasswords
3. Add to .env:
```env
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your.email@gmail.com
MAIL_PASSWORD=generated_app_password
MAIL_ENCRYPTION=tls
```

#### Test email:
```php
// test-email.php
<?php
require_once 'index.php';

$emailService = new EmailService();
$result = $emailService->send(
    'test@example.com',
    'Test Email',
    '<h1>Test email from SIRAGA</h1>'
);

echo $result ? "✓ Email sent successfully" : "✗ Email failed";
```

### 3. Configure Google OAuth (Optional)

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create new project "SIRAGA"
3. Enable Google+ API
4. Create OAuth 2.0 Client ID:
   - Application type: Web application
   - Authorized redirect URIs: `http://localhost/siraga/auth/google/callback`
5. Copy Client ID & Secret to .env

### 4. Configure Twilio (Optional)

For WhatsApp/SMS notifications:

1. Sign up at [Twilio](https://www.twilio.com/)
2. Get phone number
3. Get Account SID & Auth Token
4. Add to .env:
```env
TWILIO_ACCOUNT_SID=your_account_sid
TWILIO_AUTH_TOKEN=your_auth_token
TWILIO_PHONE_NUMBER=+1234567890
```

---

## 🐛 Troubleshooting

### Error: "Database connection failed"

**Solution:**
1. Check MySQL service is running:
   ```bash
   sudo systemctl status mysql
   ```
2. Verify credentials in `.env`
3. Check if database exists:
   ```bash
   mysql -u root -p -e "SHOW DATABASES;"
   ```

### Error: "Page not found" or 404 on all pages

**Solution:**
1. Check `.htaccess` exists in root
2. Enable mod_rewrite:
   ```bash
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```
3. Check Apache config allows AllowOverride All

### Error: "Permission denied" on logs or uploads

**Solution:**
```bash
chmod -R 777 logs/
chmod -R 777 public/uploads/
```

### Composer install fails

**Solution:**
```bash
# Update composer
composer self-update

# Clear cache
composer clear-cache

# Install with verbose
composer install -vvv
```

### Google OAuth not working

**Solution:**
1. Verify redirect URI matches exactly
2. Enable Google+ API in Console
3. Check Client ID & Secret in .env
4. Clear browser cache

---

## 📚 Next Steps

Setelah instalasi berhasil:

1. ✅ [Baca User Guide](USER_GUIDE.md)
2. ✅ [Baca API Documentation](API_DOCS.md)
3. ✅ [Configure backups](BACKUP_GUIDE.md)
4. ✅ [Setup SSL for production](SSL_SETUP.md)

---

## 💡 Tips

- **Backup** `.env` file Anda secara teratur
- **Never commit** `.env` ke version control
- **Enable SSL** untuk production
- **Regular backups** database dan uploads
- **Monitor** logs untuk errors
- **Update** dependencies secara berkala

---

## 🆘 Need Help?

- 📧 Email: support@siraga.com
- 💬 WhatsApp: +62 812-3456-7890
- 🐛 [Report Issues](https://github.com/yourusername/siraga/issues)
- 📖 [Documentation](https://docs.siraga.com)

---

**Happy Coding! 🚀**
