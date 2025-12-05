# 🚀 SIRAGA Deployment Guide

Panduan lengkap untuk deploy SIRAGA ke production server.

---

## 📋 Pre-Deployment Checklist

Sebelum deploy, pastikan:

- [ ] Semua fitur telah ditest di development
- [ ] Database migration sudah berjalan dengan baik
- [ ] File .env sudah dikonfigurasi untuk production
- [ ] SSL certificate sudah ready
- [ ] Backup sistem sudah disetup
- [ ] Monitoring tools sudah dikonfigurasi
- [ ] Domain sudah pointing ke server

---

## 🌐 Server Requirements

### Minimum Specifications

- **OS**: Ubuntu 20.04 LTS / CentOS 8 / Debian 11
- **RAM**: 2GB minimum (4GB recommended)
- **Storage**: 10GB minimum (20GB recommended)
- **CPU**: 2 cores minimum
- **Bandwidth**: 100GB/month minimum

### Software Stack

- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **PHP**: 7.4 or 8.0
- **Database**: MySQL 8.0 or MariaDB 10.5+
- **SSL**: Let's Encrypt (free) or commercial certificate
- **Composer**: Latest version

---

## 📦 Deployment Methods

### Method 1: Manual Deployment (Recommended for Learning)

#### Step 1: Prepare Server

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install Apache, PHP, MySQL
sudo apt install apache2 php php-mysql php-mbstring php-curl php-json php-xml php-gd mysql-server -y

# Enable required Apache modules
sudo a2enmod rewrite ssl headers

# Restart Apache
sudo systemctl restart apache2
```

#### Step 2: Setup MySQL

```bash
# Secure MySQL installation
sudo mysql_secure_installation

# Create database and user
sudo mysql -u root -p
```

```sql
CREATE DATABASE siraga_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'siraga_user'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON siraga_production.* TO 'siraga_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Step 3: Upload Files

```bash
# Via Git (Recommended)
cd /var/www
sudo git clone https://github.com/yourusername/siraga.git
cd siraga

# Or via FTP/SFTP
# Upload all files to /var/www/siraga
```

#### Step 4: Install Dependencies

```bash
cd /var/www/siraga

# Install Composer if not installed
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install PHP dependencies
composer install --no-dev --optimize-autoloader
```

#### Step 5: Configure Environment

```bash
# Copy and edit .env
cp .env.example .env
nano .env
```

**Production .env settings:**

```env
# Application
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
APP_KEY=generate-random-32-chars-key

# Database
DB_HOST=localhost
DB_NAME=siraga_production
DB_USER=siraga_user
DB_PASS=strong_password_here

# Mail (use production credentials)
MAIL_HOST=smtp.gmail.com
MAIL_USERNAME=production@yourdomain.com
MAIL_PASSWORD=your_production_password

# Google OAuth (production)
GOOGLE_CLIENT_ID=production_client_id
GOOGLE_CLIENT_SECRET=production_client_secret
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback

# Twilio (production)
TWILIO_ACCOUNT_SID=production_sid
TWILIO_AUTH_TOKEN=production_token
```

#### Step 6: Run Migrations

```bash
php database/migrations/migrate.php
```

#### Step 7: Set Permissions

```bash
# Set ownership
sudo chown -R www-data:www-data /var/www/siraga

# Set directory permissions
sudo find /var/www/siraga -type d -exec chmod 755 {} \;
sudo find /var/www/siraga -type f -exec chmod 644 {} \;

# Set writable directories
sudo chmod -R 777 /var/www/siraga/logs
sudo chmod -R 777 /var/www/siraga/public/uploads
sudo chmod -R 777 /var/www/siraga/storage
```

#### Step 8: Configure Apache

Create VirtualHost file:

```bash
sudo nano /etc/apache2/sites-available/siraga.conf
```

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    DocumentRoot /var/www/siraga
    
    <Directory /var/www/siraga>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/siraga-error.log
    CustomLog ${APACHE_LOG_DIR}/siraga-access.log combined
    
    # Redirect to HTTPS
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</VirtualHost>

<VirtualHost *:443>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    DocumentRoot /var/www/siraga
    
    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/yourdomain.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/yourdomain.com/privkey.pem
    
    <Directory /var/www/siraga>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/siraga-ssl-error.log
    CustomLog ${APACHE_LOG_DIR}/siraga-ssl-access.log combined
</VirtualHost>
```

Enable site:

```bash
sudo a2ensite siraga.conf
sudo systemctl reload apache2
```

#### Step 9: Setup SSL with Let's Encrypt

```bash
# Install Certbot
sudo apt install certbot python3-certbot-apache -y

# Get certificate
sudo certbot --apache -d yourdomain.com -d www.yourdomain.com

# Test auto-renewal
sudo certbot renew --dry-run
```

---

### Method 2: Docker Deployment

#### Dockerfile

Create `Dockerfile`:

```dockerfile
FROM php:8.0-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache modules
RUN a2enmod rewrite ssl headers

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/logs \
    && chmod -R 777 /var/www/html/public/uploads

EXPOSE 80

CMD ["apache2-foreground"]
```

#### docker-compose.yml

```yaml
version: '3.8'

services:
  app:
    build: .
    container_name: siraga_app
    restart: unless-stopped
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./:/var/www/html
      - ./logs:/var/www/html/logs
      - ./public/uploads:/var/www/html/public/uploads
    environment:
      - APP_ENV=production
    depends_on:
      - db
    networks:
      - siraga_network

  db:
    image: mysql:8.0
    container_name: siraga_db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: siraga_production
      MYSQL_USER: siraga_user
      MYSQL_PASSWORD: strong_password
      MYSQL_ROOT_PASSWORD: root_password
    volumes:
      - db_data:/var/lib/mysql
    networks:
      - siraga_network

volumes:
  db_data:

networks:
  siraga_network:
    driver: bridge
```

#### Deploy with Docker

```bash
# Build and run
docker-compose up -d

# Run migrations
docker exec siraga_app php database/migrations/migrate.php

# View logs
docker-compose logs -f
```

---

## 🔒 Security Hardening

### 1. Disable PHP exposure

Edit `php.ini`:
```ini
expose_php = Off
```

### 2. Limit file upload size

```ini
upload_max_filesize = 5M
post_max_size = 6M
```

### 3. Setup Firewall

```bash
# UFW (Ubuntu)
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

### 4. Fail2Ban for brute force protection

```bash
sudo apt install fail2ban -y
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

### 5. Regular Updates

```bash
# Setup automatic updates
sudo apt install unattended-upgrades -y
sudo dpkg-reconfigure --priority=low unattended-upgrades
```

---

## 📊 Performance Optimization

### 1. PHP OPcache

Edit `php.ini`:
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
```

### 2. MySQL Optimization

Edit `/etc/mysql/mysql.conf.d/mysqld.cnf`:
```ini
[mysqld]
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
max_connections = 200
```

### 3. Enable GZIP Compression

Apache `.htaccess` already includes this.

### 4. Browser Caching

Already configured in `.htaccess`.

---

## 📦 Backup Strategy

### Database Backup

Create backup script:

```bash
#!/bin/bash
# backup-db.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/siraga"
DB_NAME="siraga_production"
DB_USER="siraga_user"
DB_PASS="password"

mkdir -p $BACKUP_DIR

mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# Delete backups older than 30 days
find $BACKUP_DIR -name "db_*.sql.gz" -mtime +30 -delete
```

Setup cron:
```bash
# Edit crontab
crontab -e

# Add daily backup at 2 AM
0 2 * * * /path/to/backup-db.sh
```

### File Backup

```bash
#!/bin/bash
# backup-files.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/siraga"
APP_DIR="/var/www/siraga"

tar -czf $BACKUP_DIR/files_$DATE.tar.gz \
  $APP_DIR/public/uploads \
  $APP_DIR/.env \
  $APP_DIR/logs

# Delete backups older than 30 days
find $BACKUP_DIR -name "files_*.tar.gz" -mtime +30 -delete
```

---

## 📈 Monitoring

### 1. Setup Logging

Configure log rotation:

```bash
sudo nano /etc/logrotate.d/siraga
```

```
/var/www/siraga/logs/*.log {
    daily
    rotate 30
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    sharedscripts
}
```

### 2. Monitor Disk Space

```bash
# Check disk usage
df -h

# Setup alerts (example with email)
echo "df -h | mail -s 'Disk Usage Report' admin@yourdomain.com" | crontab -e
```

### 3. Uptime Monitoring

Use services like:
- UptimeRobot (free)
- Pingdom
- StatusCake

---

## 🔄 Deployment Updates

### Zero-Downtime Deployment

```bash
#!/bin/bash
# deploy.sh

echo "Starting deployment..."

cd /var/www/siraga

# Enable maintenance mode
echo "<?php echo 'Under Maintenance'; ?>" > maintenance.php

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php database/migrations/migrate.php

# Clear cache if any
# php artisan cache:clear (if using Laravel)

# Restart services
sudo systemctl reload apache2

# Disable maintenance mode
rm maintenance.php

echo "Deployment completed!"
```

---

## 🆘 Troubleshooting

### Issue: 500 Internal Server Error

**Check:**
1. Apache error logs: `tail -f /var/log/apache2/error.log`
2. PHP errors: `tail -f /var/www/siraga/logs/app.log`
3. File permissions
4. .htaccess configuration

### Issue: Database Connection Failed

**Check:**
1. MySQL is running: `sudo systemctl status mysql`
2. Credentials in .env
3. Database exists
4. User has proper privileges

### Issue: Email Not Sending

**Check:**
1. SMTP credentials in .env
2. Port not blocked by firewall
3. Email service logs
4. Test with mail command

---

## 📚 Post-Deployment

After successful deployment:

1. ✅ Test all major features
2. ✅ Check error logs
3. ✅ Monitor server resources
4. ✅ Setup monitoring alerts
5. ✅ Document deployment date and version
6. ✅ Notify stakeholders
7. ✅ Update documentation if needed

---

## 📞 Support

For deployment help:

- 📧 Email: devops@siraga.com
- 💬 Slack: #deployment-help
- 📖 Docs: https://docs.siraga.com/deployment

---

**Deployment Checklist:** https://deployment-checklist.siraga.com

**Remember:** Always test in staging before deploying to production!
