# Changelog

All notable changes to SIRAGA project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2024-01-15

### Added - Initial Release

#### Core System
- Custom MVC framework with Router, Controller, Model architecture
- Database connection with PDO and singleton pattern
- Middleware system (Auth, Guest, Role-based)
- Logger system for error tracking
- Helper functions for common operations
- Environment configuration with .env support

#### Authentication & Security
- User registration with email verification
- Login with email/password
- Google OAuth 2.0 integration
- Password reset via email with token
- CSRF protection
- SQL injection prevention (prepared statements)
- XSS prevention with input sanitization
- bcrypt password hashing
- Session management
- Activity logging

#### User Management
- Multi-role system (Parent, Nakes, Government)
- User profile management
- Role-based access control
- Last login tracking
- Account status management

#### Children Management
- Complete child registration with personal data
- NIK (National ID) support
- Birth data tracking (weight, height, head circumference)
- Photo upload
- Address with GPS coordinates
- Search and filter capabilities
- Update and delete operations
- Parent-child relationship

#### Measurements
- Periodic growth measurements
- Weight, height, head circumference tracking
- Arm circumference and body temperature
- Auto BMI calculation
- Growth status determination (weight-for-age, height-for-age, weight-for-height)
- Measurement history
- Growth charts with Chart.js
- Nutritional status monitoring

#### Immunizations
- Auto-generate immunization schedule based on birth date
- Support for standard vaccines (BCG, Hepatitis B, Polio, DPT, HIB, PCV, MMR, etc.)
- Schedule tracking (scheduled, completed, missed, postponed)
- Batch number and manufacturer tracking
- Injection site recording
- Reaction monitoring
- Reminder system (email, WhatsApp, SMS)
- Immunization coverage statistics

#### Dashboard
- Role-specific dashboards
- Parent dashboard: children overview, growth charts, upcoming immunizations
- Nakes dashboard: statistics, recent measurements, missed immunizations
- Government dashboard: aggregate statistics, regional distribution, visualizations
- Real-time data updates
- Interactive charts with Chart.js

#### GIS & Mapping
- Leaflet.js integration
- Children distribution visualization
- Regional clustering
- Heat maps for nutritional status
- Interactive markers
- Filter by region

#### Reports & Export
- Export to Excel (PHPSpreadsheet)
- Export to PDF (DomPDF)
- Individual child growth reports
- Immunization cards
- Aggregate reports for government
- Custom date ranges
- Multiple export formats

#### Notifications
- Multi-channel notifications:
  - In-app notifications
  - Email notifications (PHPMailer)
  - WhatsApp notifications (Twilio)
  - SMS notifications (Twilio)
- Notification types:
  - Immunization reminders
  - Measurement due alerts
  - System announcements
- Notification read status tracking

#### API for Mobile
- RESTful API architecture
- JWT authentication
- JSON request/response format
- Complete CRUD operations:
  - Auth endpoints (login, register, refresh, me)
  - Children endpoints
  - Measurements endpoints
  - Immunizations endpoints
  - Statistics endpoints
  - Notifications endpoints
- Error handling
- Rate limiting
- API documentation

#### Frontend
- Responsive design with Bootstrap 5
- Modern UI/UX with medical theme colors
- Landing page with features showcase
- Authentication pages (login, register, forgot password, reset password)
- Dashboard interfaces for all roles
- Forms with validation
- Loading overlays
- Animations with AOS (Animate On Scroll)
- Font Awesome icons
- Google Fonts integration
- WhatsApp floating button
- Error pages (404, 500)

#### Database
- 7 main tables:
  - users
  - children
  - measurements
  - immunizations
  - sessions
  - notifications
  - activity_logs
- Foreign key relationships
- Indexes for performance
- Migration system
- UTF-8mb4 support

#### Services
- GoogleOAuthService for social login
- EmailService with PHPMailer
- TwilioService for WhatsApp and SMS
- ExportService for PDF and Excel
- Modular and reusable service classes

#### Configuration
- .env environment configuration
- .htaccess security configuration
- .gitignore for sensitive files
- Composer dependency management
- Apache and Nginx support

#### Documentation
- Comprehensive README.md
- Installation guide (INSTALLATION.md)
- API documentation (API_DOCUMENTATION.md)
- Inline code comments
- Database schema documentation

### Security
- CSRF token protection
- SQL injection prevention with PDO prepared statements
- XSS prevention with input sanitization
- Password hashing with bcrypt
- Secure session management
- Protected sensitive files (.env, logs)
- Security headers in .htaccess
- Input validation
- Output escaping

### Performance
- Database query optimization with indexes
- Lazy loading for large datasets
- Pagination support
- Caching strategies
- Optimized autoloader
- CDN integration for frontend libraries

---

## [Unreleased]

### Planned Features
- [ ] Multi-language support (English, Indonesian)
- [ ] Push notifications for mobile app
- [ ] Advanced analytics dashboard
- [ ] Data import/export wizard
- [ ] Appointment scheduling system
- [ ] Vaccination certificate generation
- [ ] Integration with National Health System
- [ ] SMS gateway integration (local provider)
- [ ] Bulk operations for data management
- [ ] Advanced search with filters
- [ ] Custom report builder
- [ ] Two-factor authentication (2FA)
- [ ] Audit trail for all operations
- [ ] Data backup automation
- [ ] Performance monitoring dashboard
- [ ] API rate limiting per user
- [ ] Webhook support for integrations
- [ ] Dark mode theme
- [ ] Offline mode for mobile app
- [ ] QR code for child ID

---

## Version History

- **v1.0.0** (2024-01-15) - Initial production-ready release

---

## Contributors

- SIRAGA Development Team

---

## License

MIT License - see [LICENSE](LICENSE) file for details
