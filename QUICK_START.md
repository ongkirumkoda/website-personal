# 🚀 SIRAGA Quick Start Guide

Panduan cepat untuk menjalankan SIRAGA dalam 5 menit!

---

## ⚡ Super Quick Setup (Development)

### Prerequisites
- ✅ PHP 7.4+
- ✅ MySQL 5.7+
- ✅ Composer
- ✅ XAMPP/WAMP/LAMP (or Apache + MySQL)

---

## 📝 5-Minute Setup

### Step 1: Download & Extract (30 seconds)
```bash
# Jika menggunakan Git
git clone https://github.com/yourusername/siraga.git
cd siraga

# Atau download ZIP dan extract ke htdocs/www
```

### Step 2: Install Dependencies (1-2 minutes)
```bash
composer install
```

**Jika Composer belum installed:**
```bash
# Download Composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"

# Then install
php composer.phar install
```

### Step 3: Configure Environment (30 seconds)
```bash
# Copy .env file
cp .env.example .env

# Edit .env - Minimal configuration:
# - DB_NAME=siraga_db
# - DB_USER=root
# - DB_PASS=your_mysql_password
```

**Quick .env edit:**
```env
DB_HOST=localhost
DB_NAME=siraga_db
DB_USER=root
DB_PASS=

APP_URL=http://localhost/siraga
APP_KEY=randomstring12345678901234567890
```

### Step 4: Create Database (1 minute)
```bash
# Option A: Auto migration (Recommended)
php database/migrations/migrate.php

# Option B: Manual via phpMyAdmin
# - Open phpMyAdmin
# - Create database: siraga_db
# - Import all SQL files from database/migrations/
```

### Step 5: Access Website (10 seconds)
```
Open browser: http://localhost/siraga
```

**Default Login:**
- Email: `admin@siraga.com`
- Password: `admin123`

---

## 🎯 That's It! You're Ready!

Your SIRAGA is now running locally. Next steps:

1. **Change Admin Password** - Go to Profile → Change Password
2. **Explore Features** - Try adding a child, measurements, etc.
3. **Read Documentation** - See README.md for full features

---

## 📂 Project Structure Overview

```
siraga/
├── app/                    # Application code
│   ├── controllers/        # Page logic
│   ├── models/            # Database operations
│   ├── views/             # HTML pages
│   ├── services/          # External integrations
│   └── middleware/        # Security & access control
├── database/              # Database setup
│   └── migrations/        # SQL files
├── routes/                # URL routing
│   ├── web.php           # Website routes
│   └── api.php           # API routes
├── public/                # Static files (CSS, JS, images)
├── logs/                  # Application logs
├── .env                   # Configuration (create from .env.example)
└── index.php             # Entry point
```

---

## 🔧 Common Issues & Quick Fixes

### Issue 1: "Database connection failed"
**Fix:**
```bash
# Check MySQL is running
# XAMPP: Start MySQL from control panel
# Linux: sudo systemctl start mysql

# Check credentials in .env file
```

### Issue 2: "Page not found" or blank page
**Fix:**
```bash
# Check .htaccess exists
# Enable mod_rewrite in Apache
# Restart Apache
```

### Issue 3: Permission errors
**Fix:**
```bash
chmod -R 755 .
chmod -R 777 logs/
chmod -R 777 public/uploads/
```

### Issue 4: Composer errors
**Fix:**
```bash
composer clear-cache
composer install --no-dev
```

---

## 📖 Documentation Quick Links

| What You Need | Where to Find It |
|---------------|------------------|
| **Full Installation Guide** | [INSTALLATION.md](INSTALLATION.md) |
| **Feature Overview** | [README.md](README.md) |
| **API Documentation** | [API_DOCUMENTATION.md](API_DOCUMENTATION.md) |
| **Deployment to Production** | [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md) |
| **Contributing** | [CONTRIBUTING.md](CONTRIBUTING.md) |
| **Project Status** | [PROJECT_STATUS.md](PROJECT_STATUS.md) |

---

## 🎨 What Can You Do Now?

### As Parent (Orang Tua):
1. ✅ Register new account
2. ✅ Add your children
3. ✅ View growth charts
4. ✅ Check immunization schedule
5. ✅ Export reports

### As Nakes (Tenaga Kesehatan):
1. ✅ All Parent features
2. ✅ Input measurements for any child
3. ✅ Update immunization status
4. ✅ View statistics
5. ✅ Monitor missed immunizations

### As Government:
1. ✅ All Nakes features
2. ✅ View regional statistics
3. ✅ GIS map visualization
4. ✅ Aggregate reports
5. ✅ Coverage analysis

---

## 🔑 Test Accounts

After running migrations, you have:

**Admin/Government Account:**
- Email: `admin@siraga.com`
- Password: `admin123`
- Role: Government

**Create Additional Users:**
- Go to `/register`
- Choose your role (Parent/Nakes/Government)

---

## 🚀 Next Steps

### For Development:
1. Read [INSTALLATION.md](INSTALLATION.md) for detailed setup
2. Configure external services (optional):
   - Google OAuth for social login
   - Email SMTP for notifications
   - Twilio for WhatsApp/SMS

### For Production:
1. Read [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md)
2. Setup SSL certificate
3. Configure production .env
4. Setup backups and monitoring

### For API Development:
1. Read [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
2. Test API endpoints with Postman/cURL
3. Integrate with mobile app

---

## 📊 Feature Checklist

After quick start, you should be able to:

- [x] Access landing page
- [x] Login with admin account
- [x] View dashboard
- [x] Add new child
- [x] Input measurements
- [x] View growth charts
- [x] Check immunization schedule
- [x] Export reports (PDF/Excel)
- [x] View statistics
- [x] Access API endpoints

---

## 🆘 Need Help?

### Quick Help Resources:

**1. Documentation**
- All MD files in root folder
- Inline code comments

**2. Logs**
- Check `logs/app.log` for errors
- Check Apache error log

**3. Contact**
- Email: support@siraga.com
- WhatsApp: +62 812-3456-7890

**4. Common Commands**
```bash
# Restart Apache (Linux)
sudo systemctl restart apache2

# Check PHP version
php -v

# Check MySQL connection
mysql -u root -p

# View logs
tail -f logs/app.log

# Re-run migrations
php database/migrations/migrate.php
```

---

## 🎯 Quick Reference

### Important URLs:
```
Landing:     http://localhost/siraga
Login:       http://localhost/siraga/login
Register:    http://localhost/siraga/register
Dashboard:   http://localhost/siraga/dashboard
API Base:    http://localhost/siraga/api
```

### Important Directories:
```
Views:       app/views/
Controllers: app/controllers/
Models:      app/models/
Routes:      routes/
Config:      .env
Logs:        logs/
Uploads:     public/uploads/
```

### Important Commands:
```bash
# Install dependencies
composer install

# Run migrations
php database/migrations/migrate.php

# Check logs
tail -f logs/app.log

# Set permissions
chmod -R 777 logs/ public/uploads/
```

---

## ✅ Success Checklist

After setup, verify:

- [ ] Landing page loads without errors
- [ ] Can login with admin account
- [ ] Dashboard displays correctly
- [ ] Can add new child
- [ ] Can input measurement
- [ ] Charts display data
- [ ] Can export to PDF
- [ ] No errors in logs

---

## 🎉 Congratulations!

You've successfully set up SIRAGA! 

**What's Next?**
1. Explore all features
2. Customize for your needs
3. Configure external services
4. Deploy to production
5. Train your users

---

## 📚 Learn More

- **Full Features**: See [README.md](README.md#-fitur-lengkap)
- **Architecture**: See [README.md](README.md#-teknologi-stack)
- **API**: See [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
- **Production**: See [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md)

---

**Happy Coding! 🚀**

*SIRAGA - Making child healthcare monitoring easier and better*
