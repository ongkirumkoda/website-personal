# SIRAGA - Sistem Pencatatan Tumbuh Kembang Anak

<div align="center">

![SIRAGA Logo](https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f476.svg)

**Production-Ready Child Growth Monitoring System**

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange)](https://www.mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple)](https://getbootstrap.com/)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

</div>

---

## 📋 Daftar Isi

- [Tentang SIRAGA](#-tentang-siraga)
- [Fitur Lengkap](#-fitur-lengkap)
- [Teknologi Stack](#-teknologi-stack)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Struktur Proyek](#-struktur-proyek)
- [Penggunaan](#-penggunaan)
- [API Documentation](#-api-documentation)
- [Screenshots](#-screenshots)
- [FAQ](#-faq)
- [Contributing](#-contributing)
- [License](#-license)

---

## 🌟 Tentang SIRAGA

**SIRAGA** (Sistem Pencatatan Tumbuh Kembang Anak) adalah aplikasi web berbasis PHP dengan arsitektur MVC yang dirancang untuk membantu **Orang Tua**, **Tenaga Kesehatan**, dan **Pemerintah** dalam memantau dan mengelola data tumbuh kembang anak secara digital, efisien, dan terintegrasi.

### 🎯 Tujuan Utama

- ✅ Digitalisasi pencatatan kesehatan anak
- ✅ Monitoring pertumbuhan real-time dengan grafik interaktif
- ✅ Pengingat imunisasi otomatis via WhatsApp & Email
- ✅ Visualisasi data geografis dengan GIS
- ✅ Laporan lengkap dalam format PDF & Excel
- ✅ Integrasi API untuk aplikasi mobile

---

## ✨ Fitur Lengkap

### 🔐 Sistem Autentikasi Multi-Role

- **Login/Register** dengan email & password
- **Google OAuth 2.0** integration
- **Email Verification** otomatis
- **Password Reset** via email dengan token expiry
- **Role-Based Access Control** (RBAC):
  - 👨‍👩‍👧 **Parent** (Orang Tua)
  - 👨‍⚕️ **Nakes** (Tenaga Kesehatan)
  - 🏛️ **Government** (Pemerintah/Dinas)

### 📊 Dashboard Multi-Role

#### Dashboard Orang Tua
- Lihat semua data anak
- Grafik pertumbuhan individual
- Jadwal imunisasi upcoming
- Riwayat pengukuran lengkap

#### Dashboard Tenaga Kesehatan
- Input data pengukuran baru
- Kelola data imunisasi
- Lihat semua anak terdaftar
- Monitor missed immunizations
- Statistik real-time

#### Dashboard Pemerintah
- Statistik agregat regional
- Peta GIS distribusi data
- Analisis nutritional status
- Laporan cakupan imunisasi
- Data visualisasi Chart.js

### 👶 Manajemen Data Anak

- **Registrasi anak lengkap** dengan:
  - Data personal (NIK, nama, tanggal lahir, dll)
  - Data kelahiran (berat, tinggi, lingkar kepala)
  - Alamat lengkap dengan koordinat GPS
  - Foto profil
- **Update & delete** data anak
- **Search & filter** berdasarkan berbagai kriteria

### 📏 Pencatatan Pengukuran

- **Input pengukuran** periodic:
  - Berat badan (kg)
  - Tinggi badan (cm)
  - Lingkar kepala (cm)
  - Lingkar lengan (cm)
  - Suhu tubuh (°C)
- **Auto-calculation** BMI
- **Status determination**:
  - Weight-for-age
  - Height-for-age
  - Weight-for-height
- **Growth charts** dengan Chart.js

### 💉 Jadwal Imunisasi

- **Auto-generate** jadwal imunisasi berdasarkan tanggal lahir
- **Vaccine types**: BCG, Hepatitis B, Polio, DPT, HIB, PCV, MMR, dll
- **Status tracking**: Scheduled, Completed, Missed, Postponed
- **Reminder system**:
  - Email notifications
  - WhatsApp notifications (Twilio)
  - SMS notifications (Twilio)
- **Batch & manufacturer tracking**
- **Reaction monitoring**

### 🗺️ GIS & Peta Interaktif

- **Leaflet.js** integration
- Visualisasi distribusi anak per wilayah
- Heat map nutritional status
- Marker clustering
- Filter by region

### 📤 Export & Laporan

- **Export to Excel** (PHPSpreadsheet):
  - Data anak lengkap
  - Riwayat pengukuran
  - Data imunisasi
- **Export to PDF** (DomPDF):
  - Laporan pertumbuhan individual
  - Kartu imunisasi
  - Laporan aggregate
- **Custom report generation**

### 📱 API Mobile-Ready

- **RESTful API** endpoints
- **JWT Authentication**
- **JSON responses**
- **Rate limiting**
- **API Documentation** (Swagger-ready)

### 🔔 Notification System

- **Multi-channel**:
  - In-app notifications
  - Email (PHPMailer)
  - WhatsApp (Twilio)
  - SMS (Twilio)
- **Notification types**:
  - Immunization reminders
  - Measurement due alerts
  - System announcements

### 🔒 Security Features

- **CSRF Protection**
- **SQL Injection Prevention** (PDO prepared statements)
- **XSS Prevention**
- **Password hashing** (bcrypt)
- **Session management**
- **Input validation & sanitization**
- **Secure headers** (.htaccess)

### 📝 Activity Logging

- User login/logout tracking
- CRUD operation logs
- IP address logging
- User agent tracking
- Timestamp recording

---

## 🛠️ Teknologi Stack

### Backend
- **PHP 7.4+** - Server-side language
- **MySQL 5.7+** - Database
- **PDO** - Database abstraction
- **Custom MVC Framework** - Architecture pattern

### Frontend
- **HTML5 & CSS3**
- **Bootstrap 5.3** - UI Framework
- **JavaScript (Vanilla)**
- **Chart.js** - Data visualization
- **Leaflet.js** - Interactive maps
- **AOS** - Animation on scroll
- **Font Awesome** - Icons
- **Google Fonts** - Typography

### Libraries & Dependencies (Composer)
```json
{
  "require": {
    "phpmailer/phpmailer": "^6.8",
    "google/apiclient": "^2.15",
    "twilio/sdk": "^7.0",
    "phpoffice/phpspreadsheet": "^1.29",
    "dompdf/dompdf": "^2.0"
  }
}
```

### Services & Integrations
- **Google OAuth 2.0** - Social login
- **PHPMailer** - Email service
- **Twilio** - WhatsApp & SMS
- **Leaflet** - Mapping service

---

## 💻 Persyaratan Sistem

### Minimum Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher / MariaDB 10.2+
- Apache 2.4+ with mod_rewrite enabled
- Composer (for dependency management)
- 512MB RAM minimum
- 100MB disk space

### Recommended Requirements
- PHP 8.0+
- MySQL 8.0+ / MariaDB 10.6+
- Apache 2.4+ / Nginx
- 1GB RAM
- 500MB disk space
- SSL Certificate (for production)

### PHP Extensions Required
- `pdo_mysql`
- `mbstring`
- `openssl`
- `curl`
- `json`
- `gd` or `imagick`
- `zip`

---

## 📦 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/yourusername/siraga.git
cd siraga
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Environment

```bash
# Copy .env.example to .env
cp .env.example .env

# Edit .env dengan konfigurasi Anda
nano .env
```

### 4. Setup Database

```bash
# Jalankan migration untuk membuat database dan tabel
php database/migrations/migrate.php
```

Output yang diharapkan:
```
Creating database 'siraga_db' if not exists...
✓ Database created/verified

Running migrations...
--------------------------------------------------
Running: 001_create_users_table.sql
✓ Completed: 001_create_users_table.sql

Running: 002_create_children_table.sql
✓ Completed: 002_create_children_table.sql

...

✓ All migrations completed successfully!
```

### 5. Configure Web Server

#### Apache (.htaccess sudah included)

```apache
<VirtualHost *:80>
    ServerName siraga.local
    DocumentRoot /path/to/siraga
    
    <Directory /path/to/siraga>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/siraga-error.log
    CustomLog ${APACHE_LOG_DIR}/siraga-access.log combined
</VirtualHost>
```

#### Nginx

```nginx
server {
    listen 80;
    server_name siraga.local;
    root /path/to/siraga;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 6. Set Permissions

```bash
# Linux/Mac
chmod -R 755 .
chmod -R 777 logs/
chmod -R 777 public/uploads/

# Buat folder yang dibutuhkan
mkdir -p logs public/uploads storage/cache
```

### 7. Test Installation

Buka browser dan akses:
```
http://localhost/siraga
atau
http://siraga.local
```

Default admin account:
- **Email**: admin@siraga.com
- **Password**: admin123

---

## ⚙️ Konfigurasi

### Environment Variables (.env)

#### Database Configuration
```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=siraga_db
DB_USER=root
DB_PASS=your_password
```

#### Application Settings
```env
APP_NAME=SIRAGA
APP_ENV=production
APP_URL=https://yourdomain.com
APP_DEBUG=false
APP_KEY=your-secret-key-32-chars-minimum
```

#### Google OAuth Setup
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create new project
3. Enable Google+ API
4. Create OAuth 2.0 credentials
5. Add to .env:

```env
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
```

#### Email Configuration (Gmail Example)
1. Enable 2-Factor Authentication on Gmail
2. Generate App Password
3. Add to .env:

```env
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@siraga.com
MAIL_FROM_NAME=SIRAGA System
```

#### Twilio Configuration
1. Sign up at [Twilio](https://www.twilio.com/)
2. Get Account SID & Auth Token
3. Get phone number
4. Add to .env:

```env
TWILIO_ACCOUNT_SID=your-account-sid
TWILIO_AUTH_TOKEN=your-auth-token
TWILIO_PHONE_NUMBER=+1234567890
TWILIO_WHATSAPP_NUMBER=whatsapp:+14155238886
```

---

## 📁 Struktur Proyek

```
siraga/
├── app/
│   ├── controllers/          # Controllers (MVC)
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── ChildController.php
│   │   ├── MeasurementController.php
│   │   ├── ImmunizationController.php
│   │   └── ApiAuthController.php
│   ├── core/                 # Core system files
│   │   ├── Controller.php
│   │   ├── Database.php
│   │   ├── Logger.php
│   │   ├── Middleware.php
│   │   ├── Model.php
│   │   └── Router.php
│   ├── helpers/              # Helper functions
│   │   └── functions.php
│   ├── middleware/           # Middleware classes
│   │   ├── AuthMiddleware.php
│   │   ├── GuestMiddleware.php
│   │   └── RoleMiddleware.php
│   ├── models/               # Models (MVC)
│   │   ├── Child.php
│   │   ├── Immunization.php
│   │   ├── Measurement.php
│   │   └── User.php
│   ├── services/             # Service classes
│   │   ├── EmailService.php
│   │   ├── ExportService.php
│   │   ├── GoogleOAuthService.php
│   │   └── TwilioService.php
│   └── views/                # Views (MVC)
│       ├── auth/
│       │   ├── login.php
│       │   ├── register.php
│       │   ├── forgot-password.php
│       │   └── reset-password.php
│       ├── dashboard/
│       │   ├── parent.php
│       │   ├── nakes.php
│       │   └── government.php
│       ├── children/
│       ├── measurements/
│       ├── immunizations/
│       ├── errors/
│       │   ├── 404.php
│       │   └── 500.php
│       ├── landing.php
│       └── contact.php
├── config/
│   └── env.php               # Environment loader
├── database/
│   └── migrations/           # Database migrations
│       ├── 001_create_users_table.sql
│       ├── 002_create_children_table.sql
│       ├── 003_create_measurements_table.sql
│       ├── 004_create_immunizations_table.sql
│       └── migrate.php
├── logs/                     # Application logs
│   └── app.log
├── public/                   # Public assets
│   ├── css/
│   ├── js/
│   ├── images/
│   └── uploads/
├── routes/                   # Route definitions
│   ├── api.php
│   └── web.php
├── storage/                  # Storage directory
│   └── cache/
├── .env                      # Environment config (not in repo)
├── .env.example              # Environment template
├── .gitignore
├── .htaccess                 # Apache config
├── composer.json             # PHP dependencies
├── index.php                 # Application entry point
└── README.md                 # This file
```

---

## 🚀 Penggunaan

### User Roles & Capabilities

#### 1. Orang Tua (Parent)
- ✅ Registrasi dan login
- ✅ Tambah data anak
- ✅ Lihat riwayat pertumbuhan
- ✅ Lihat jadwal imunisasi
- ✅ Export laporan anak (PDF/Excel)
- ✅ Update profil
- ✅ Menerima notifikasi pengingat

#### 2. Tenaga Kesehatan (Nakes)
- ✅ Semua hak Parent
- ✅ Input data pengukuran untuk semua anak
- ✅ Update status imunisasi
- ✅ Lihat semua data anak terdaftar
- ✅ Generate laporan aggregate
- ✅ Monitoring missed immunizations

#### 3. Pemerintah (Government)
- ✅ Semua hak Nakes
- ✅ Akses dashboard statistik lengkap
- ✅ Visualisasi peta GIS
- ✅ Analisis tren regional
- ✅ Export laporan pemerintah
- ✅ Monitoring cakupan program

### Workflow Example

#### Registrasi Anak Baru (Parent)
1. Login sebagai Parent
2. Dashboard → Tambah Anak
3. Isi formulir lengkap
4. Upload foto (optional)
5. Simpan data
6. Sistem auto-generate jadwal imunisasi

#### Input Pengukuran (Nakes)
1. Login sebagai Nakes
2. Pilih anak dari daftar
3. Input data pengukuran:
   - Berat badan
   - Tinggi badan
   - Lingkar kepala
4. Sistem auto-calculate BMI dan status
5. Simpan data
6. Notifikasi dikirim ke Parent

#### Monitoring Regional (Government)
1. Login sebagai Government
2. Dashboard → Lihat statistik
3. Analisis grafik & peta
4. Filter by region
5. Export laporan PDF/Excel
6. Share dengan stakeholders

---

## 📡 API Documentation

### Base URL
```
Production: https://yourdomain.com/api
Development: http://localhost/siraga/api
```

### Authentication

All API requests require JWT token in header:
```http
Authorization: Bearer {your-jwt-token}
```

### Endpoints

#### 1. Authentication

**POST /api/auth/login**
```json
Request:
{
  "email": "user@example.com",
  "password": "password123"
}

Response:
{
  "success": true,
  "token": "eyJ0eXAiOiJKV1QiLCJh...",
  "user": {
    "id": 1,
    "email": "user@example.com",
    "full_name": "John Doe",
    "role": "parent"
  }
}
```

**POST /api/auth/register**
```json
Request:
{
  "full_name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "phone": "081234567890",
  "role": "parent"
}

Response:
{
  "success": true,
  "message": "Registration successful",
  "user": {...}
}
```

#### 2. Children

**GET /api/children**
```json
Response:
{
  "success": true,
  "data": [
    {
      "id": 1,
      "full_name": "Jane Doe",
      "birth_date": "2020-01-15",
      "gender": "female",
      ...
    }
  ]
}
```

**POST /api/children**
```json
Request:
{
  "full_name": "Jane Doe",
  "birth_date": "2020-01-15",
  "gender": "female",
  "birth_weight": 3.2,
  "birth_height": 50
}

Response:
{
  "success": true,
  "data": {...}
}
```

#### 3. Measurements

**GET /api/children/{id}/measurements**
```json
Response:
{
  "success": true,
  "data": [
    {
      "id": 1,
      "measurement_date": "2024-01-15",
      "weight": 10.5,
      "height": 75,
      "head_circumference": 45
    }
  ]
}
```

**POST /api/measurements**
```json
Request:
{
  "child_id": 1,
  "measurement_date": "2024-01-15",
  "age_months": 12,
  "weight": 10.5,
  "height": 75,
  "head_circumference": 45
}

Response:
{
  "success": true,
  "data": {...}
}
```

#### 4. Immunizations

**GET /api/children/{id}/immunizations**
```json
Response:
{
  "success": true,
  "data": [
    {
      "id": 1,
      "vaccine_name": "BCG",
      "scheduled_date": "2020-02-15",
      "status": "completed"
    }
  ]
}
```

**PATCH /api/immunizations/{id}/complete**
```json
Request:
{
  "immunization_date": "2020-02-15",
  "location": "Puskesmas XYZ",
  "batch_number": "ABC123"
}

Response:
{
  "success": true,
  "message": "Immunization marked as completed"
}
```

### Error Responses

```json
{
  "success": false,
  "message": "Error description",
  "code": 400
}
```

HTTP Status Codes:
- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `500` - Server Error

---

## 📸 Screenshots

### Landing Page
![Landing Page](https://via.placeholder.com/800x400?text=SIRAGA+Landing+Page)

### Dashboard Orang Tua
![Parent Dashboard](https://via.placeholder.com/800x400?text=Parent+Dashboard)

### Dashboard Tenaga Kesehatan
![Nakes Dashboard](https://via.placeholder.com/800x400?text=Nakes+Dashboard)

### GIS Map
![GIS Map](https://via.placeholder.com/800x400?text=GIS+Map+Visualization)

---

## ❓ FAQ

### Q: Bagaimana cara mengubah password default admin?
**A:** Login sebagai admin, masuk ke Profile → Change Password.

### Q: Apakah data aman?
**A:** Ya, SIRAGA menggunakan enkripsi bcrypt untuk password, prepared statements untuk SQL, dan berbagai security measures lainnya.

### Q: Apakah bisa digunakan offline?
**A:** SIRAGA memerlukan koneksi internet untuk fitur seperti Google OAuth, email, dan WhatsApp notifications. Namun fitur core bisa berjalan di local network.

### Q: Bagaimana cara backup database?
**A:**
```bash
mysqldump -u root -p siraga_db > backup_$(date +%Y%m%d).sql
```

### Q: Support multi-language?
**A:** Saat ini hanya Bahasa Indonesia. Multi-language support bisa ditambahkan sebagai enhancement.

### Q: Lisensi penggunaan?
**A:** MIT License - gratis untuk penggunaan personal maupun komersial.

---

## 🤝 Contributing

Kontribusi sangat diterima! Silakan:

1. Fork repository
2. Buat branch feature (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buka Pull Request

### Code Style
- Follow PSR-12 coding standard
- Write meaningful commit messages
- Add comments for complex logic
- Update documentation

---

## 📜 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👨‍💻 Developer

**SIRAGA Development Team**

- Website: https://siraga.com
- Email: support@siraga.com
- WhatsApp: +62 812-3456-7890

---

## 🙏 Acknowledgments

- Bootstrap team for the amazing UI framework
- Chart.js for data visualization
- Leaflet.js for mapping
- All open-source contributors

---

<div align="center">

**Made with ❤️ for better child healthcare in Indonesia**

⭐ Star this repo if you find it helpful!

[Report Bug](https://github.com/yourusername/siraga/issues) · [Request Feature](https://github.com/yourusername/siraga/issues)

</div>
