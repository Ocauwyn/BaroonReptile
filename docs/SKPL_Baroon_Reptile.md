# SPESIFIKASI KEBUTUHAN PERANGKAT LUNAK (SKPL)
# SISTEM INFORMASI PENITIPAN REPTIL "BAROON REPTILE"

---

## 1. PENDAHULUAN

### 1.1 Tujuan Dokumen
Dokumen ini berisi spesifikasi kebutuhan perangkat lunak untuk Sistem Informasi Penitipan Reptil "Baroon Reptile". Dokumen ini menjelaskan kebutuhan fungsional dan non-fungsional sistem yang akan dikembangkan.

### 1.2 Ruang Lingkup Produk
Baroon Reptile adalah sistem informasi berbasis web yang dirancang untuk mengelola layanan penitipan hewan reptil. Sistem ini memungkinkan pelanggan untuk mendaftarkan reptil mereka, membuat booking penitipan, dan mengelola akun mereka. Administrator dapat mengelola seluruh operasional bisnis melalui dashboard admin.

### 1.3 Definisi dan Istilah
- **Customer**: Pengguna yang menitipkan reptil
- **Admin**: Pengelola sistem dan bisnis penitipan
- **Reptil**: Hewan yang dititipkan (ular, kadal, gecko, dll)
- **Booking**: Pemesanan layanan penitipan
- **Facility**: Fasilitas tambahan yang tersedia

### 1.4 Referensi
- IEEE Std 830-1998 - IEEE Recommended Practice for Software Requirements Specifications
- PHP 8.0+ Documentation
- MySQL 8.0+ Documentation
- Bootstrap 5.3 Documentation

---

## 2. DESKRIPSI UMUM

### 2.1 Perspektif Produk
Sistem Baroon Reptile adalah aplikasi web standalone yang terdiri dari:
- Frontend: HTML, CSS (Bootstrap 5), JavaScript
- Backend: PHP 8.0+
- Database: MySQL 8.0+
- Web Server: Apache (XAMPP)

### 2.2 Fungsi Produk
#### 2.2.1 Fungsi untuk Customer
- Registrasi dan login akun
- Manajemen profil dan pengaturan
- Pendaftaran reptil
- Pembuatan dan pengelolaan booking
- Melihat riwayat transaksi
- Komunikasi dengan admin

#### 2.2.2 Fungsi untuk Admin
- Dashboard monitoring bisnis
- Manajemen customer dan reptil
- Manajemen booking dan pembayaran
- Manajemen fasilitas
- Laporan harian dan bulanan
- Pengaturan sistem

### 2.3 Karakteristik Pengguna
#### 2.3.1 Customer
- Pemilik reptil yang membutuhkan layanan penitipan
- Usia 18+ tahun
- Memiliki kemampuan dasar menggunakan internet
- Menggunakan smartphone atau komputer

#### 2.3.2 Admin
- Pengelola bisnis penitipan reptil
- Memiliki pengetahuan tentang perawatan reptil
- Terlatih menggunakan sistem informasi
- Bertanggung jawab atas operasional harian

### 2.4 Batasan
- Sistem hanya mendukung bahasa Indonesia
- Akses internet diperlukan untuk menggunakan sistem
- Pembayaran dilakukan secara offline (belum terintegrasi payment gateway)
- Sistem berjalan pada web browser modern

---

## 3. KEBUTUHAN SPESIFIK

### 3.1 Kebutuhan Fungsional

#### 3.1.1 Modul Autentikasi (AUTH)
**AUTH-001: Login Pengguna**
- **Deskripsi**: Sistem harus dapat memverifikasi identitas pengguna dengan aman
- **Input**: Username/email dan password
- **Proses**: 
  - Validasi format input
  - Hash password verification
  - Check account status (active/inactive)
  - Generate secure session
- **Output**: Redirect ke dashboard sesuai role dengan session token
- **Prioritas**: Tinggi
- **Acceptance Criteria**:
  - Login berhasil dengan kredensial valid
  - Error message untuk kredensial invalid
  - Account lockout setelah 5 percobaan gagal
  - Session timeout setelah 2 jam inaktif

**AUTH-002: Registrasi Customer**
- **Deskripsi**: Calon customer dapat mendaftar akun baru dengan validasi lengkap
- **Input**: Data pribadi (nama, email, username, password, phone, address)
- **Proses**: 
  - Validasi format email dan phone
  - Check duplicate username/email
  - Password strength validation
  - Hash password dengan bcrypt
  - Send welcome email
- **Output**: Akun customer baru terbuat dengan status active
- **Prioritas**: Tinggi
- **Acceptance Criteria**:
  - Email dan username harus unique
  - Password minimal 8 karakter dengan kombinasi huruf dan angka
  - Validasi format email dan nomor telepon
  - Auto-generate customer ID

**AUTH-003: Logout**
- **Deskripsi**: Pengguna dapat keluar dari sistem dengan aman
- **Input**: Permintaan logout dari user
- **Proses**: 
  - Destroy session data
  - Clear authentication cookies
  - Log logout activity
  - Redirect to landing page
- **Output**: User kembali ke halaman utama tanpa session
- **Prioritas**: Tinggi
- **Acceptance Criteria**:
  - Session completely destroyed
  - No cached sensitive data
  - Logout activity logged

**AUTH-004: Password Reset**
- **Deskripsi**: User dapat mereset password yang terlupa
- **Input**: Email address
- **Proses**:
  - Validate email exists in system
  - Generate secure reset token
  - Send reset link via email
  - Token expires in 1 hour
- **Output**: Password reset email sent
- **Prioritas**: Sedang

**AUTH-005: Change Password**
- **Deskripsi**: User dapat mengubah password dari dashboard
- **Input**: Current password, new password, confirm password
- **Proses**:
  - Verify current password
  - Validate new password strength
  - Hash new password
  - Update database
- **Output**: Password successfully updated
- **Prioritas**: Sedang

#### 3.1.2 Modul Customer (CUST)
**CUST-001: Dashboard Customer**
- **Deskripsi**: Menampilkan ringkasan informasi customer dengan statistik lengkap
- **Input**: Session customer
- **Proses**: 
  - Ambil data statistik reptil (total, aktif, dalam penitipan)
  - Hitung total booking dan status
  - Tampilkan booking mendatang
  - Show recent activities
- **Output**: Dashboard dengan statistik, grafik, dan aktivitas terbaru
- **Prioritas**: Tinggi
- **Acceptance Criteria**:
  - Widget statistik (total reptil, booking aktif, riwayat)
  - Calendar view untuk booking mendatang
  - Quick actions (add reptil, create booking)
  - Recent activity timeline

**CUST-002: Manajemen Profil**
- **Deskripsi**: Customer dapat mengelola informasi pribadi secara lengkap
- **Input**: Data profil (nama, email, phone, alamat, foto profil, preferensi)
- **Proses**: 
  - Validasi format email dan phone
  - Check duplicate email
  - Upload foto profil (optional)
  - Update database dengan transaction
  - Send confirmation email
- **Output**: Profil terupdate dengan notifikasi sukses
- **Prioritas**: Sedang
- **Acceptance Criteria**:
  - Email validation dan uniqueness check
  - Phone number format validation
  - Profile photo upload (max 2MB)
  - Password change dengan current password verification

**CUST-003: Pendaftaran Reptil**
- **Deskripsi**: Customer dapat mendaftarkan reptil untuk dititipkan dengan data lengkap
- **Input**: Data reptil (nama, spesies, kategori, umur, gender, berat, panjang, warna, foto, deskripsi, kebutuhan khusus, kondisi kesehatan)
- **Proses**: 
  - Validasi input sesuai tipe data
  - Upload multiple photos (max 5 files)
  - Generate unique reptile ID
  - Save to database dengan foreign key
  - Create initial health record
- **Output**: Reptil terdaftar dalam sistem dengan ID unik
- **Prioritas**: Tinggi
- **Acceptance Criteria**:
  - Multiple photo upload (JPG, PNG max 5MB each)
  - Required fields validation
  - Auto-generate reptile code (REP-XXXX)
  - Health record initialization

**CUST-004: Manajemen Reptil**
- **Deskripsi**: Customer dapat melihat, mengedit, dan mengelola data reptil miliknya
- **Input**: ID reptil dan data yang akan diubah
- **Proses**: 
  - Validasi kepemilikan reptil
  - Check active bookings sebelum delete
  - Update data dengan validation
  - Manage photo gallery
  - Track modification history
- **Output**: Data reptil terupdate dengan audit trail
- **Prioritas**: Tinggi
- **Acceptance Criteria**:
  - View reptil dalam grid/list format
  - Search dan filter (nama, kategori, status)
  - Edit dengan pre-filled form
  - Cannot delete reptil dengan booking aktif
  - Photo gallery management

**CUST-005: Pembuatan Booking**
- **Deskripsi**: Customer dapat membuat booking penitipan dengan validasi lengkap
- **Input**: Reptil, tanggal check-in/check-out, fasilitas tambahan, catatan khusus
- **Proses**: 
  - Validasi ketersediaan tanggal
  - Check reptil availability
  - Calculate total cost (base + facilities)
  - Validate facility capacity
  - Generate booking invoice
  - Send confirmation email
- **Output**: Booking baru terbuat dengan status pending dan invoice
- **Prioritas**: Tinggi
- **Acceptance Criteria**:
  - Date picker dengan disabled past dates
  - Real-time cost calculation
  - Facility selection dengan availability check
  - Booking confirmation dengan invoice PDF
  - Email notification

**CUST-006: Manajemen Booking**
- **Deskripsi**: Customer dapat melihat, mengelola, dan track booking
- **Input**: Filter status, tanggal, reptil
- **Proses**: 
  - Query dengan multiple filters
  - Pagination untuk performance
  - Status tracking (pending, confirmed, in-progress, completed)
  - Payment status monitoring
  - Cancel booking dengan rules
- **Output**: Daftar booking dengan detail lengkap dan opsi aksi
- **Prioritas**: Tinggi
- **Acceptance Criteria**:
  - Filter kombinasi (status + date range + reptil)
  - Status badges dengan color coding
  - Cancel booking (hanya status pending/confirmed)
  - View booking details modal
  - Payment status indicator

**CUST-007: Pembayaran Booking**
- **Deskripsi**: Customer dapat melakukan pembayaran dan upload bukti transfer
- **Input**: Booking ID, metode pembayaran, bukti transfer, nominal
- **Proses**:
  - Validate booking status (confirmed)
  - Upload payment proof dengan validation
  - Update payment status
  - Generate payment receipt
  - Send payment confirmation
- **Output**: Payment record created, booking status updated
- **Prioritas**: Tinggi
- **Acceptance Criteria**:
  - Multiple payment methods support
  - File upload validation (PDF, JPG, PNG max 10MB)
  - Payment amount validation
  - Auto-generate receipt

**CUST-008: Laporan Harian Reptil**
- **Deskripsi**: Customer dapat melihat laporan harian perawatan reptil selama penitipan
- **Input**: Booking ID, tanggal
- **Proses**:
  - Fetch daily reports dari admin
  - Display care activities timeline
  - Show photos dan videos
  - Health monitoring data
- **Output**: Daily care report dengan multimedia dan catatan detail
- **Prioritas**: Sedang
- **Acceptance Criteria**:
  - Timeline view aktivitas harian
  - Photo/video gallery per hari
  - Health status indicators
  - Care notes dari staff

**CUST-009: Feedback dan Rating**
- **Deskripsi**: Customer dapat memberikan feedback dan rating setelah booking selesai
- **Input**: Booking ID, rating (1-5), komentar, foto (optional)
- **Proses**:
  - Validate booking status (completed)
  - Save feedback dengan timestamp
  - Update service rating average
  - Moderate content sebelum publish
- **Output**: Feedback tersimpan dan tampil di testimonial
- **Prioritas**: Rendah
- **Acceptance Criteria**:
  - Star rating component
  - Text feedback dengan character limit
  - Optional photo upload
  - Feedback moderation system

**CUST-010: Notifikasi dan Komunikasi**
- **Deskripsi**: Customer dapat menerima dan mengelola notifikasi sistem
- **Input**: Notification preferences
- **Proses**:
  - Real-time notifications
  - Email notifications
  - In-app message center
  - Communication dengan admin
- **Output**: Notification center dengan message history
- **Prioritas**: Sedang
- **Acceptance Criteria**:
  - Real-time notification badges
  - Email notification settings
  - Message thread dengan admin
  - Notification history

#### 3.1.3 Modul Admin (ADMIN)
**ADMIN-001: Dashboard Admin**
- **Deskripsi**: Menampilkan overview sistem komprehensif untuk admin
- **Input**: Session admin dengan role validation
- **Proses**: 
  - Agregasi data real-time dari seluruh sistem
  - Generate charts dan graphs
  - Calculate KPI metrics
  - Monitor system health
  - Track recent activities
- **Output**: Dashboard dengan statistik, grafik, dan alert system
- **Prioritas**: Tinggi
- **Acceptance Criteria**:
  - Widget statistik (total users, bookings, revenue)
  - Interactive charts (booking trends, revenue analysis)
  - System health indicators
  - Recent activity feed
  - Quick action buttons

**ADMIN-002: Manajemen Customer**
- **Deskripsi**: Admin dapat mengelola akun customer dan admin lainnya
- **Input**: Data customer, role assignment, status changes
- **Proses**: 
  - CRUD operations dengan validation
  - Role-based access control
  - Account activation/deactivation
  - Password reset untuk users
  - Audit trail untuk perubahan
- **Output**: Data customer terupdate dengan log aktivitas
- **Prioritas**: Tinggi
- **Acceptance Criteria**:
  - Customer list dengan search dan filter
  - Role management (customer, admin, super admin)
  - Bulk operations (activate, deactivate)
  - Customer activity history
  - Export customer data

**ADMIN-003: Manajemen Reptil**
- **Deskripsi**: Admin dapat melihat dan mengelola semua reptil dengan detail lengkap
- **Input**: Filter kategori, status, customer, health condition
- **Proses**: 
  - View all reptiles dengan advanced filter
  - Update reptile information
  - Track health records
  - Manage reptile categories
  - Generate reptile reports
- **Output**: Daftar reptil dengan opsi manajemen dan health tracking
- **Prioritas**: Tinggi
- **Acceptance Criteria**:
  - Advanced filtering (kategori, status, customer, health)
  - Reptile profile dengan photo gallery
  - Health record tracking
  - Category management
  - Export reptile data

**ADMIN-004: Manajemen Booking**
- **Deskripsi**: Admin dapat mengelola semua booking dengan workflow lengkap
- **Input**: Filter booking, status updates, payment confirmation
- **Proses**: 
  - View all bookings dengan advanced filter
  - Update booking status workflow
  - Confirm payments
  - Assign facilities dan staff
  - Generate booking reports
- **Output**: Status booking terupdate dengan notification ke customer
- **Prioritas**: Tinggi
- **Acceptance Criteria**:
  - Advanced filtering (date, status, customer, reptil)
  - Booking status workflow (pending → confirmed → in-progress → completed)
  - Payment verification dan confirmation
  - Facility assignment
  - Bulk status updates

**ADMIN-005: Manajemen Pembayaran**
- **Deskripsi**: Admin dapat memverifikasi dan mengelola pembayaran
- **Input**: Payment proofs, verification status, refund requests
- **Proses**:
  - Review payment submissions
  - Verify payment amounts
  - Update payment status
  - Process refunds
  - Generate financial reports
- **Output**: Payment status updated dengan notification
- **Prioritas**: Tinggi
- **Acceptance Criteria**:
  - Payment verification workflow
  - Image viewer untuk bukti transfer
  - Payment status tracking
  - Refund processing
  - Financial reconciliation

**ADMIN-006: Manajemen Fasilitas**
- **Deskripsi**: Admin dapat mengelola fasilitas penitipan dan kapasitasnya
- **Input**: Data fasilitas, kapasitas, harga, status
- **Proses**: 
  - CRUD operations untuk fasilitas
  - Manage capacity dan availability
  - Set pricing dan special rates
  - Track facility utilization
  - Maintenance scheduling
- **Output**: Data fasilitas terupdate dengan availability calendar
- **Prioritas**: Sedang
- **Acceptance Criteria**:
  - Facility list dengan status indicators
  - Capacity management
  - Pricing configuration
  - Availability calendar
  - Maintenance tracking

**ADMIN-007: Laporan Harian Perawatan**
- **Deskripsi**: Admin dapat membuat dan mengelola laporan harian perawatan reptil
- **Input**: Booking ID, care activities, photos, health notes
- **Proses**:
  - Create daily care reports
  - Upload photos/videos
  - Track health status
  - Schedule care activities
  - Notify customers
- **Output**: Daily care report dengan multimedia
- **Prioritas**: Tinggi
- **Acceptance Criteria**:
  - Daily report template
  - Photo/video upload
  - Health status tracking
  - Care activity checklist
  - Customer notification

**ADMIN-008: Laporan Sistem**
- **Deskripsi**: Admin dapat melihat dan generate berbagai laporan bisnis
- **Input**: Parameter laporan (date range, type, format)
- **Proses**: 
  - Generate laporan dari multiple data sources
  - Export dalam berbagai format
  - Schedule automated reports
  - Data visualization
  - Performance analytics
- **Output**: Laporan dalam format PDF/Excel/CSV dengan charts
- **Prioritas**: Sedang
- **Acceptance Criteria**:
  - Multiple report types (booking, revenue, customer, facility)
  - Date range selection
  - Export formats (PDF, Excel, CSV)
  - Scheduled reports via email
  - Interactive charts dan graphs

**ADMIN-009: Manajemen Kategori Reptil**
- **Deskripsi**: Admin dapat mengelola kategori dan spesies reptil
- **Input**: Category data, care requirements, pricing
- **Proses**:
  - CRUD operations untuk kategori
  - Set care requirements per kategori
  - Configure pricing tiers
  - Manage species database
- **Output**: Category system updated
- **Prioritas**: Sedang
- **Acceptance Criteria**:
  - Category hierarchy
  - Care requirement templates
  - Pricing configuration
  - Species database

**ADMIN-010: Sistem Notifikasi**
- **Deskripsi**: Admin dapat mengelola sistem notifikasi dan komunikasi
- **Input**: Notification templates, broadcast messages
- **Proses**:
  - Create notification templates
  - Send broadcast messages
  - Manage email templates
  - Configure notification rules
- **Output**: Notification system configured
- **Prioritas**: Rendah
- **Acceptance Criteria**:
  - Template management
  - Broadcast messaging
  - Email template editor
  - Notification scheduling

**ADMIN-011: Backup dan Maintenance**
- **Deskripsi**: Admin dapat melakukan backup data dan maintenance sistem
- **Input**: Backup schedules, maintenance tasks
- **Proses**:
  - Schedule automated backups
  - Database maintenance
  - System health monitoring
  - Log management
- **Output**: System maintained dengan backup terjadwal
- **Prioritas**: Sedang
- **Acceptance Criteria**:
  - Automated backup scheduling
  - Database optimization
  - Log rotation
  - System health dashboard

**ADMIN-012: Pengaturan Sistem**
- **Deskripsi**: Admin dapat mengatur konfigurasi sistem dan business rules
- **Input**: Parameter konfigurasi, business rules, system settings
- **Proses**: 
  - Update pengaturan sistem
  - Configure business rules
  - Manage user permissions
  - Set system parameters
  - Configure integrations
- **Output**: Sistem terkonfigurasi sesuai kebutuhan bisnis
- **Prioritas**: Rendah
- **Acceptance Criteria**:
  - System configuration panel
  - Business rules engine
  - Permission management
  - Integration settings
  - Configuration backup/restore

### 3.2 Kebutuhan Non-Fungsional

#### 3.2.1 Performance Requirements
**PERF-001: Response Time**
- **Requirement**: Halaman harus load dalam waktu < 2 detik untuk 95% requests
- **Measurement**: Average response time monitoring
- **Target**: 
  - Homepage: < 1.5 detik
  - Dashboard: < 2 detik
  - Search results: < 3 detik
  - File uploads: < 10 detik
- **Tools**: Performance monitoring dengan New Relic/Google Analytics

**PERF-002: Throughput**
- **Requirement**: Sistem dapat menangani 500 concurrent users
- **Measurement**: Load testing dengan Apache JMeter
- **Target**:
  - Peak load: 500 concurrent users
  - Normal load: 100 concurrent users
  - Database connections: Max 50 connections
- **Scaling**: Auto-scaling berdasarkan CPU usage

**PERF-003: Database Performance**
- **Requirement**: Query response time < 500ms untuk 95% queries
- **Optimization**: 
  - Database indexing pada foreign keys
  - Query optimization
  - Connection pooling
  - Caching untuk frequent queries
- **Monitoring**: Slow query log analysis

#### 3.2.2 Security Requirements
**SEC-001: Authentication & Authorization**
- **Authentication**: 
  - Session-based authentication dengan secure cookies
  - Password hashing menggunakan bcrypt (cost factor 12)
  - Account lockout setelah 5 failed attempts
  - Session timeout setelah 2 jam inaktivitas
- **Authorization**: 
  - Role-based access control (RBAC)
  - Permission-based feature access
  - API endpoint protection

**SEC-002: Data Protection**
- **Encryption**: 
  - HTTPS untuk semua communications
  - Database encryption untuk sensitive data
  - File encryption untuk uploaded documents
- **Privacy**: 
  - GDPR compliance untuk data handling
  - Data anonymization untuk reports
  - Right to be forgotten implementation

**SEC-003: Input Validation & Sanitization**
- **Validation**: 
  - Server-side validation untuk semua inputs
  - File type validation untuk uploads
  - SQL injection prevention
  - XSS protection dengan output encoding
- **Sanitization**: 
  - HTML sanitization untuk user content
  - File name sanitization
  - URL validation

**SEC-004: Security Monitoring**
- **Logging**: 
  - Security event logging
  - Failed login attempt tracking
  - Suspicious activity detection
- **Monitoring**: 
  - Real-time security alerts
  - Regular security audits
  - Vulnerability scanning

#### 3.2.3 Usability Requirements
**USA-001: User Interface Design**
- **Design Principles**: 
  - Intuitive navigation dengan breadcrumbs
  - Consistent UI components
  - Clear visual hierarchy
  - Accessible color scheme (contrast ratio 4.5:1)
- **User Experience**: 
  - Maximum 3 clicks to reach any feature
  - Clear error messages dengan actionable solutions
  - Progress indicators untuk long operations

**USA-002: Responsive Design**
- **Device Support**: 
  - Desktop (1920x1080, 1366x768)
  - Tablet (768x1024, 1024x768)
  - Mobile (375x667, 414x896)
- **Breakpoints**: 
  - Mobile: < 768px
  - Tablet: 768px - 1024px
  - Desktop: > 1024px

**USA-003: Accessibility**
- **Standards**: WCAG 2.1 Level AA compliance
- **Features**: 
  - Keyboard navigation support
  - Screen reader compatibility
  - Alt text untuk images
  - Focus indicators
  - Skip navigation links

**USA-004: Internationalization**
- **Language Support**: 
  - Bahasa Indonesia (primary)
  - English (secondary)
- **Localization**: 
  - Date/time format localization
  - Currency format (IDR)
  - Number format localization

#### 3.2.4 Reliability Requirements
**REL-001: Availability**
- **Target**: 99.5% uptime (maksimal 3.65 jam downtime per bulan)
- **Monitoring**: 
  - 24/7 system monitoring
  - Automated health checks
  - Uptime monitoring dengan external services
- **Recovery**: 
  - Automatic failover untuk critical services
  - Disaster recovery plan
  - RTO (Recovery Time Objective): 4 jam
  - RPO (Recovery Point Objective): 1 jam

**REL-002: Error Handling**
- **Graceful Degradation**: 
  - System tetap functional meski ada component failure
  - Fallback mechanisms untuk external services
  - User-friendly error pages
- **Error Recovery**: 
  - Automatic retry untuk transient errors
  - Circuit breaker pattern untuk external APIs
  - Transaction rollback untuk data consistency

**REL-003: Data Backup & Recovery**
- **Backup Strategy**: 
  - Daily full database backup
  - Hourly incremental backup
  - File system backup untuk uploaded files
  - Off-site backup storage
- **Recovery Testing**: 
  - Monthly backup restoration testing
  - Disaster recovery drills
  - Data integrity verification

#### 3.2.5 Portability Requirements
**PORT-001: Browser Compatibility**
- **Supported Browsers**: 
  - Chrome 90+ (primary)
  - Firefox 88+ 
  - Safari 14+
  - Edge 90+
- **Testing**: Cross-browser testing untuk major features

**PORT-002: Mobile Compatibility**
- **Mobile Browsers**: 
  - Chrome Mobile
  - Safari Mobile
  - Samsung Internet
- **Features**: 
  - Touch-friendly interface
  - Mobile-optimized forms
  - Offline capability untuk basic features

**PORT-003: Platform Independence**
- **Server**: 
  - Linux (Ubuntu 20.04 LTS recommended)
  - Windows Server 2019+
  - Docker containerization support
- **Database**: 
  - MySQL 8.0+
  - MariaDB 10.5+
  - PostgreSQL 13+ (alternative)

#### 3.2.6 Maintainability Requirements
**MAIN-001: Code Quality**
- **Standards**: 
  - PSR-12 coding standards untuk PHP
  - ESLint rules untuk JavaScript
  - Code coverage minimum 80%
- **Documentation**: 
  - Inline code documentation
  - API documentation dengan Swagger
  - Database schema documentation

**MAIN-002: Monitoring & Logging**
- **Application Monitoring**: 
  - Performance metrics collection
  - Error tracking dengan Sentry
  - User behavior analytics
- **Logging**: 
  - Structured logging dengan JSON format
  - Log rotation dan archival
  - Centralized log management

**MAIN-003: Deployment & DevOps**
- **CI/CD Pipeline**: 
  - Automated testing
  - Code quality checks
  - Automated deployment
- **Environment Management**: 
  - Development, staging, production environments
  - Configuration management
  - Database migration scripts

---

## 4. MODEL DATA

### 4.1 Entity Relationship Diagram (ERD)

```
[Users] ||--o{ [Reptiles] : owns
[Users] ||--o{ [Bookings] : makes
[Users] ||--o{ [DailyReports] : creates
[Users] ||--o{ [Testimonials] : writes
[Reptiles] ||--o{ [Bookings] : booked_for
[Reptiles] ||--o{ [HealthRecords] : has
[Bookings] ||--o{ [Payments] : has
[Bookings] ||--o{ [DailyReports] : generates
[Bookings] }o--o{ [Facilities] : uses (BookingFacilities)
[ReptileCategories] ||--o{ [Reptiles] : categorizes
[Facilities] ||--o{ [BookingFacilities] : included_in
[Bookings] ||--o{ [Testimonials] : receives
```

### 4.2 Deskripsi Entitas

#### 4.2.1 Users
- **user_id** (PK): Unique identifier (INT AUTO_INCREMENT)
- **username**: Username untuk login (VARCHAR 50, UNIQUE)
- **email**: Email address (VARCHAR 100, UNIQUE)
- **password**: Hashed password (VARCHAR 255)
- **full_name**: Nama lengkap (VARCHAR 100)
- **phone**: Nomor telepon (VARCHAR 20)
- **address**: Alamat lengkap (TEXT)
- **profile_photo**: Path foto profil (VARCHAR 255)
- **role**: Role (ENUM: 'customer', 'admin', 'super_admin')
- **status**: Status akun (ENUM: 'active', 'inactive', 'suspended')
- **email_verified**: Status verifikasi email (BOOLEAN)
- **last_login**: Timestamp login terakhir (TIMESTAMP)
- **failed_login_attempts**: Jumlah percobaan login gagal (INT DEFAULT 0)
- **account_locked_until**: Waktu unlock akun (TIMESTAMP NULL)
- **created_at**: Timestamp pembuatan (TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
- **updated_at**: Timestamp update terakhir (TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

#### 4.2.2 ReptileCategories
- **category_id** (PK): Unique identifier (INT AUTO_INCREMENT)
- **category_name**: Nama kategori (VARCHAR 100, UNIQUE)
- **description**: Deskripsi kategori (TEXT)
- **base_price**: Harga dasar per hari (DECIMAL 10,2)
- **care_requirements**: Kebutuhan perawatan khusus (JSON)
- **temperature_range**: Range suhu optimal (VARCHAR 50)
- **humidity_range**: Range kelembaban optimal (VARCHAR 50)
- **feeding_schedule**: Jadwal pemberian makan (JSON)
- **special_equipment**: Peralatan khusus yang dibutuhkan (JSON)
- **status**: Status kategori (ENUM: 'active', 'inactive')
- **created_at**: Timestamp pembuatan (TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
- **updated_at**: Timestamp update terakhir (TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

#### 4.2.3 Reptiles
- **reptile_id** (PK): Unique identifier (INT AUTO_INCREMENT)
- **reptile_code**: Kode unik reptil (VARCHAR 20, UNIQUE)
- **user_id** (FK): Pemilik reptil (INT, REFERENCES Users.user_id)
- **category_id** (FK): Kategori reptil (INT, REFERENCES ReptileCategories.category_id)
- **name**: Nama reptil (VARCHAR 100)
- **species**: Spesies (VARCHAR 100)
- **age**: Umur (dalam bulan) (INT)
- **gender**: Jenis kelamin (ENUM: 'male', 'female', 'unknown')
- **weight**: Berat (gram) (DECIMAL 8,2)
- **length**: Panjang (cm) (DECIMAL 8,2)
- **color**: Warna (VARCHAR 100)
- **photos**: Array path foto (JSON)
- **description**: Deskripsi (TEXT)
- **special_needs**: Kebutuhan khusus (TEXT)
- **health_status**: Status kesehatan (ENUM: 'excellent', 'good', 'fair', 'poor', 'critical')
- **vaccination_status**: Status vaksinasi (JSON)
- **medical_history**: Riwayat medis (TEXT)
- **behavioral_notes**: Catatan perilaku (TEXT)
- **status**: Status (ENUM: 'active', 'inactive', 'in_boarding', 'quarantine')
- **created_at**: Timestamp pembuatan (TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
- **updated_at**: Timestamp update terakhir (TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

#### 4.2.4 Bookings
- **booking_id** (PK): Unique identifier (INT AUTO_INCREMENT)
- **booking_code**: Kode unik booking (VARCHAR 20, UNIQUE)
- **user_id** (FK): Customer yang booking (INT, REFERENCES Users.user_id)
- **reptile_id** (FK): Reptil yang dititipkan (INT, REFERENCES Reptiles.reptile_id)
- **check_in_date**: Tanggal masuk (DATE)
- **check_out_date**: Tanggal keluar (DATE)
- **actual_check_in**: Tanggal masuk aktual (TIMESTAMP NULL)
- **actual_check_out**: Tanggal keluar aktual (TIMESTAMP NULL)
- **total_days**: Total hari penitipan (INT)
- **base_cost**: Biaya dasar (DECIMAL 10,2)
- **facility_cost**: Biaya fasilitas tambahan (DECIMAL 10,2)
- **additional_cost**: Biaya tambahan lainnya (DECIMAL 10,2)
- **discount**: Diskon yang diberikan (DECIMAL 10,2 DEFAULT 0)
- **total_cost**: Total biaya (DECIMAL 10,2)
- **status**: Status booking (ENUM: 'pending', 'confirmed', 'in_progress', 'completed', 'cancelled')
- **cancellation_reason**: Alasan pembatalan (TEXT NULL)
- **notes**: Catatan khusus (TEXT)
- **emergency_contact**: Kontak darurat (VARCHAR 100)
- **pickup_person**: Orang yang akan menjemput (VARCHAR 100)
- **created_at**: Timestamp pembuatan (TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
- **updated_at**: Timestamp update terakhir (TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

#### 4.2.5 Payments
- **payment_id** (PK): Unique identifier (INT AUTO_INCREMENT)
- **payment_code**: Kode unik pembayaran (VARCHAR 20, UNIQUE)
- **booking_id** (FK): Booking terkait (INT, REFERENCES Bookings.booking_id)
- **amount**: Jumlah pembayaran (DECIMAL 10,2)
- **payment_method**: Metode pembayaran (ENUM: 'cash', 'bank_transfer', 'credit_card', 'e_wallet')
- **payment_proof**: Path bukti pembayaran (VARCHAR 255)
- **payment_date**: Tanggal pembayaran (TIMESTAMP)
- **verification_date**: Tanggal verifikasi (TIMESTAMP NULL)
- **status**: Status pembayaran (ENUM: 'pending', 'verified', 'rejected', 'refunded')
- **verified_by**: Admin yang verifikasi (INT NULL, REFERENCES Users.user_id)
- **rejection_reason**: Alasan penolakan (TEXT NULL)
- **refund_amount**: Jumlah refund (DECIMAL 10,2 DEFAULT 0)
- **refund_date**: Tanggal refund (TIMESTAMP NULL)
- **transaction_id**: ID transaksi dari payment gateway (VARCHAR 100)
- **created_at**: Timestamp pembuatan (TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
- **updated_at**: Timestamp update terakhir (TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

#### 4.2.6 Facilities
- **facility_id** (PK): Unique identifier (INT AUTO_INCREMENT)
- **facility_code**: Kode unik fasilitas (VARCHAR 20, UNIQUE)
- **facility_name**: Nama fasilitas (VARCHAR 100)
- **description**: Deskripsi fasilitas (TEXT)
- **price_per_day**: Harga per hari (DECIMAL 10,2)
- **capacity**: Kapasitas maksimal (INT)
- **current_occupancy**: Okupansi saat ini (INT DEFAULT 0)
- **facility_type**: Tipe fasilitas (ENUM: 'basic', 'premium', 'luxury', 'medical')
- **amenities**: Fasilitas yang tersedia (JSON)
- **maintenance_schedule**: Jadwal maintenance (JSON)
- **status**: Status fasilitas (ENUM: 'active', 'inactive', 'maintenance', 'full')
- **location**: Lokasi fasilitas (VARCHAR 100)
- **size**: Ukuran fasilitas (VARCHAR 50)
- **created_at**: Timestamp pembuatan (TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
- **updated_at**: Timestamp update terakhir (TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

#### 4.2.7 BookingFacilities (Junction Table)
- **booking_facility_id** (PK): Unique identifier (INT AUTO_INCREMENT)
- **booking_id** (FK): Booking terkait (INT, REFERENCES Bookings.booking_id)
- **facility_id** (FK): Fasilitas yang digunakan (INT, REFERENCES Facilities.facility_id)
- **quantity**: Jumlah yang digunakan (INT DEFAULT 1)
- **daily_rate**: Tarif harian saat booking (DECIMAL 10,2)
- **total_cost**: Total biaya fasilitas (DECIMAL 10,2)
- **start_date**: Tanggal mulai penggunaan (DATE)
- **end_date**: Tanggal selesai penggunaan (DATE)
- **created_at**: Timestamp pembuatan (TIMESTAMP DEFAULT CURRENT_TIMESTAMP)

#### 4.2.8 DailyReports
- **report_id** (PK): Unique identifier (INT AUTO_INCREMENT)
- **booking_id** (FK): Booking terkait (INT, REFERENCES Bookings.booking_id)
- **report_date**: Tanggal laporan (DATE)
- **created_by** (FK): Staff yang membuat laporan (INT, REFERENCES Users.user_id)
- **feeding_time**: Waktu pemberian makan (JSON)
- **feeding_notes**: Catatan pemberian makan (TEXT)
- **health_check**: Hasil pemeriksaan kesehatan (JSON)
- **behavior_notes**: Catatan perilaku (TEXT)
- **activities**: Aktivitas harian (JSON)
- **photos**: Array path foto harian (JSON)
- **videos**: Array path video harian (JSON)
- **temperature**: Suhu lingkungan (DECIMAL 5,2)
- **humidity**: Kelembaban lingkungan (DECIMAL 5,2)
- **special_incidents**: Kejadian khusus (TEXT)
- **medication_given**: Obat yang diberikan (JSON)
- **next_day_plan**: Rencana hari berikutnya (TEXT)
- **created_at**: Timestamp pembuatan (TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
- **updated_at**: Timestamp update terakhir (TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

#### 4.2.9 HealthRecords
- **health_record_id** (PK): Unique identifier (INT AUTO_INCREMENT)
- **reptile_id** (FK): Reptil terkait (INT, REFERENCES Reptiles.reptile_id)
- **record_date**: Tanggal pemeriksaan (DATE)
- **weight**: Berat saat pemeriksaan (DECIMAL 8,2)
- **length**: Panjang saat pemeriksaan (DECIMAL 8,2)
- **health_status**: Status kesehatan (ENUM: 'excellent', 'good', 'fair', 'poor', 'critical')
- **symptoms**: Gejala yang diamati (TEXT)
- **diagnosis**: Diagnosis (TEXT)
- **treatment**: Perawatan yang diberikan (TEXT)
- **medication**: Obat yang diberikan (JSON)
- **veterinarian**: Nama dokter hewan (VARCHAR 100)
- **next_checkup**: Tanggal pemeriksaan berikutnya (DATE)
- **notes**: Catatan tambahan (TEXT)
- **created_by** (FK): Yang membuat record (INT, REFERENCES Users.user_id)
- **created_at**: Timestamp pembuatan (TIMESTAMP DEFAULT CURRENT_TIMESTAMP)

#### 4.2.10 Testimonials
- **testimonial_id** (PK): Unique identifier (INT AUTO_INCREMENT)
- **booking_id** (FK): Booking terkait (INT, REFERENCES Bookings.booking_id)
- **user_id** (FK): Customer yang memberikan testimonial (INT, REFERENCES Users.user_id)
- **rating**: Rating (1-5) (TINYINT)
- **title**: Judul testimonial (VARCHAR 200)
- **content**: Isi testimonial (TEXT)
- **photos**: Array path foto testimonial (JSON)
- **service_aspects**: Aspek layanan yang dinilai (JSON)
- **recommendations**: Rekomendasi untuk improvement (TEXT)
- **status**: Status testimonial (ENUM: 'pending', 'approved', 'rejected')
- **moderated_by** (FK): Admin yang moderasi (INT NULL, REFERENCES Users.user_id)
- **moderation_notes**: Catatan moderasi (TEXT)
- **featured**: Apakah ditampilkan di homepage (BOOLEAN DEFAULT FALSE)
- **created_at**: Timestamp pembuatan (TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
- **updated_at**: Timestamp update terakhir (TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

---

## 5. ARSITEKTUR SISTEM

### 5.1 Arsitektur Umum
Sistem menggunakan arsitektur 3-tier dengan pattern MVC (Model-View-Controller):

#### 5.1.1 Presentation Tier (Client Layer)
- **Web Browser**: HTML5, CSS3, JavaScript ES6+
- **Responsive Framework**: Bootstrap 5.3
- **UI Components**: Custom components dengan accessibility support
- **State Management**: Local storage untuk user preferences
- **Real-time Updates**: WebSocket untuk notifications

#### 5.1.2 Application Tier (Server Layer)
- **Web Server**: Apache 2.4 dengan mod_rewrite
- **Application Framework**: Custom PHP framework dengan MVC pattern
- **Session Management**: PHP sessions dengan Redis untuk scaling
- **File Processing**: Image optimization dan validation
- **API Layer**: RESTful API untuk mobile app integration
- **Caching**: Redis untuk database query caching

#### 5.1.3 Data Tier (Database Layer)
- **Primary Database**: MySQL 8.0 dengan InnoDB engine
- **Backup Database**: MySQL replica untuk read operations
- **File Storage**: Local file system dengan backup to cloud
- **Search Engine**: MySQL Full-Text Search untuk content search

### 5.2 Struktur Direktori
```
baroonreptil/
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── CustomerController.php
│   │   ├── AdminController.php
│   │   ├── BookingController.php
│   │   ├── PaymentController.php
│   │   └── ApiController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Reptile.php
│   │   ├── Booking.php
│   │   ├── Payment.php
│   │   ├── Facility.php
│   │   └── DailyReport.php
│   ├── Views/
│   │   ├── layouts/
│   │   │   ├── header.php
│   │   │   ├── footer.php
│   │   │   ├── sidebar.php
│   │   │   └── navigation.php
│   │   ├── auth/
│   │   │   ├── login.php
│   │   │   ├── register.php
│   │   │   └── forgot-password.php
│   │   ├── customer/
│   │   │   ├── dashboard.php
│   │   │   ├── profile.php
│   │   │   ├── reptiles/
│   │   │   ├── bookings/
│   │   │   └── reports/
│   │   ├── admin/
│   │   │   ├── dashboard.php
│   │   │   ├── users/
│   │   │   ├── reptiles/
│   │   │   ├── bookings/
│   │   │   ├── facilities/
│   │   │   ├── payments/
│   │   │   └── reports/
│   │   └── errors/
│   │       ├── 404.php
│   │       ├── 500.php
│   │       └── maintenance.php
│   ├── Middleware/
│   │   ├── AuthMiddleware.php
│   │   ├── RoleMiddleware.php
│   │   ├── ValidationMiddleware.php
│   │   └── RateLimitMiddleware.php
│   └── Services/
│       ├── EmailService.php
│       ├── FileUploadService.php
│       ├── NotificationService.php
│       ├── PaymentService.php
│       └── ReportService.php
├── config/
│   ├── database.php
│   ├── app.php
│   ├── mail.php
│   ├── cache.php
│   └── security.php
├── public/
│   ├── index.php
│   ├── assets/
│   │   ├── css/
│   │   │   ├── bootstrap.min.css
│   │   │   ├── custom.css
│   │   │   └── responsive.css
│   │   ├── js/
│   │   │   ├── bootstrap.bundle.min.js
│   │   │   ├── jquery.min.js
│   │   │   ├── chart.js
│   │   │   ├── custom.js
│   │   │   └── validation.js
│   │   ├── images/
│   │   │   ├── logo/
│   │   │   ├── icons/
│   │   │   └── backgrounds/
│   │   └── fonts/
│   └── uploads/
│       ├── reptiles/
│       │   ├── photos/
│       │   └── documents/
│       ├── payments/
│       │   └── proofs/
│       ├── reports/
│       │   ├── daily/
│       │   └── generated/
│       └── testimonials/
├── database/
│   ├── migrations/
│   ├── seeds/
│   └── backups/
├── logs/
│   ├── application.log
│   ├── error.log
│   ├── security.log
│   └── performance.log
├── tests/
│   ├── Unit/
│   ├── Integration/
│   └── Feature/
├── docs/
│   ├── api/
│   ├── database/
│   └── deployment/
├── vendor/
├── .env
├── .htaccess
├── composer.json
├── README.md
└── deploy.sh
```

### 5.3 Teknologi yang Digunakan

#### 5.3.1 Frontend Technologies
- **HTML5**: Semantic markup dengan accessibility features
- **CSS3**: Modern styling dengan CSS Grid dan Flexbox
- **JavaScript ES6+**: Modern JavaScript dengan modules
- **Bootstrap 5.3**: Responsive framework dengan custom themes
- **jQuery 3.6**: DOM manipulation dan AJAX requests
- **Chart.js 4.0**: Data visualization dan reporting
- **SweetAlert2**: User-friendly modal dialogs
- **DataTables**: Advanced table features dengan server-side processing
- **Dropzone.js**: Drag & drop file uploads
- **Moment.js**: Date/time manipulation

#### 5.3.2 Backend Technologies
- **PHP 8.1+**: Server-side scripting dengan modern features
- **Composer**: Dependency management
- **PHPMailer**: Email sending dengan SMTP support
- **Intervention Image**: Image processing dan optimization
- **Carbon**: Date/time library untuk PHP
- **Monolog**: Logging library dengan multiple handlers
- **Respect/Validation**: Input validation library
- **Firebase JWT**: JSON Web Token implementation

#### 5.3.3 Database & Storage
- **MySQL 8.0**: Primary database dengan InnoDB engine
- **Redis 6.0**: Caching dan session storage
- **File System**: Local storage dengan organized directory structure
- **Cloud Storage**: AWS S3 atau Google Cloud Storage untuk backups

#### 5.3.4 Development & Deployment
- **Git**: Version control dengan GitFlow workflow
- **Docker**: Containerization untuk development dan production
- **Apache 2.4**: Web server dengan mod_rewrite dan mod_ssl
- **SSL/TLS**: HTTPS encryption dengan Let's Encrypt
- **Nginx**: Reverse proxy untuk load balancing (production)

### 5.4 Security Architecture

#### 5.4.1 Authentication & Authorization
- **Session-based Authentication**: Secure PHP sessions dengan regeneration
- **Role-based Access Control (RBAC)**: Granular permissions
- **Password Security**: bcrypt hashing dengan salt
- **Account Security**: Login attempt limiting dan account lockout

#### 5.4.2 Data Protection
- **Input Validation**: Server-side validation untuk semua inputs
- **SQL Injection Prevention**: Prepared statements dan parameterized queries
- **XSS Protection**: Output encoding dan Content Security Policy
- **CSRF Protection**: Token-based CSRF protection
- **File Upload Security**: Type validation, size limits, dan virus scanning

#### 5.4.3 Network Security
- **HTTPS Enforcement**: SSL/TLS untuk semua communications
- **Security Headers**: HSTS, X-Frame-Options, X-Content-Type-Options
- **Rate Limiting**: API rate limiting untuk prevent abuse
- **IP Whitelisting**: Admin access restriction

### 5.5 Performance Architecture

#### 5.5.1 Caching Strategy
- **Database Query Caching**: Redis untuk frequent queries
- **Page Caching**: Static page caching untuk public content
- **Object Caching**: Application-level caching untuk expensive operations
- **CDN Integration**: Content Delivery Network untuk static assets

#### 5.5.2 Database Optimization
- **Indexing Strategy**: Optimized indexes untuk frequent queries
- **Query Optimization**: Efficient SQL queries dengan EXPLAIN analysis
- **Connection Pooling**: Database connection management
- **Read Replicas**: Separate read dan write operations

#### 5.5.3 Frontend Optimization
- **Asset Minification**: CSS dan JavaScript compression
- **Image Optimization**: Automatic image compression dan WebP conversion
- **Lazy Loading**: Progressive loading untuk images dan content
- **Browser Caching**: Optimized cache headers

### 5.6 Monitoring & Logging

#### 5.6.1 Application Monitoring
- **Performance Monitoring**: Response time dan throughput tracking
- **Error Tracking**: Automatic error detection dan reporting
- **User Analytics**: User behavior dan feature usage tracking
- **Health Checks**: Automated system health monitoring

#### 5.6.2 Logging Strategy
- **Structured Logging**: JSON format untuk easy parsing
- **Log Levels**: DEBUG, INFO, WARNING, ERROR, CRITICAL
- **Log Rotation**: Automatic log file rotation dan archival
- **Centralized Logging**: Log aggregation untuk multiple servers

### 5.7 Scalability Architecture

#### 5.7.1 Horizontal Scaling
- **Load Balancing**: Multiple application servers dengan load balancer
- **Database Scaling**: Master-slave replication untuk read scaling
- **Session Storage**: Redis cluster untuk shared sessions
- **File Storage**: Distributed file storage untuk uploads

#### 5.7.2 Vertical Scaling
- **Resource Optimization**: CPU dan memory usage optimization
- **Database Tuning**: MySQL configuration optimization
- **Cache Optimization**: Intelligent caching strategies
- **Code Optimization**: Performance profiling dan optimization

---

## 6. TESTING STRATEGY

### 6.1 Testing Approach

#### 6.1.1 Testing Levels
**Unit Testing**
- **Scope**: Individual functions dan methods
- **Framework**: PHPUnit untuk backend, Jest untuk frontend
- **Coverage Target**: Minimum 80% code coverage
- **Focus Areas**:
  - Model methods (CRUD operations)
  - Validation functions
  - Utility functions
  - Business logic calculations

**Integration Testing**
- **Scope**: Component interactions dan API endpoints
- **Tools**: PHPUnit dengan database testing
- **Focus Areas**:
  - Database operations
  - File upload functionality
  - Email sending
  - Payment processing
  - External API integrations

**System Testing**
- **Scope**: End-to-end functionality
- **Tools**: Selenium WebDriver, Cypress
- **Focus Areas**:
  - Complete user workflows
  - Cross-browser compatibility
  - Performance testing
  - Security testing

**Acceptance Testing**
- **Scope**: Business requirements validation
- **Approach**: User Acceptance Testing (UAT)
- **Participants**: Stakeholders dan end users
- **Focus Areas**:
  - Feature completeness
  - Usability testing
  - Business process validation

#### 6.1.2 Testing Types

**Functional Testing**
- Authentication dan authorization
- CRUD operations untuk semua entities
- Business logic validation
- Data integrity checks
- Error handling

**Non-Functional Testing**
- **Performance Testing**:
  - Load testing (500 concurrent users)
  - Stress testing (peak load scenarios)
  - Volume testing (large datasets)
  - Response time validation

- **Security Testing**:
  - Authentication bypass attempts
  - SQL injection testing
  - XSS vulnerability testing
  - File upload security
  - Session management testing

- **Usability Testing**:
  - Navigation flow testing
  - Form usability
  - Mobile responsiveness
  - Accessibility compliance

- **Compatibility Testing**:
  - Browser compatibility (Chrome, Firefox, Safari, Edge)
  - Mobile device testing
  - Operating system compatibility

### 6.2 Test Cases

#### 6.2.1 Authentication Test Cases
**TC-AUTH-001: Valid Login**
- **Precondition**: User account exists dan active
- **Steps**: 
  1. Navigate to login page
  2. Enter valid username/email
  3. Enter valid password
  4. Click login button
- **Expected Result**: User redirected to dashboard
- **Priority**: High

**TC-AUTH-002: Invalid Login**
- **Precondition**: User account exists
- **Steps**:
  1. Navigate to login page
  2. Enter invalid credentials
  3. Click login button
- **Expected Result**: Error message displayed, login fails
- **Priority**: High

**TC-AUTH-003: Account Lockout**
- **Precondition**: User account exists
- **Steps**:
  1. Attempt login dengan wrong password 5 times
- **Expected Result**: Account locked for specified duration
- **Priority**: Medium

#### 6.2.2 Booking Test Cases
**TC-BOOK-001: Create Valid Booking**
- **Precondition**: User logged in, reptile registered
- **Steps**:
  1. Navigate to create booking page
  2. Select reptile
  3. Choose valid dates
  4. Select facilities
  5. Submit booking
- **Expected Result**: Booking created dengan status pending
- **Priority**: High

**TC-BOOK-002: Overlapping Booking**
- **Precondition**: Existing booking for same reptile
- **Steps**:
  1. Try to create booking dengan overlapping dates
- **Expected Result**: Error message, booking rejected
- **Priority**: High

#### 6.2.3 Payment Test Cases
**TC-PAY-001: Upload Payment Proof**
- **Precondition**: Confirmed booking exists
- **Steps**:
  1. Navigate to payment page
  2. Upload valid payment proof
  3. Submit payment
- **Expected Result**: Payment status updated to pending verification
- **Priority**: High

### 6.3 Test Environment

#### 6.3.1 Development Environment
- **Purpose**: Developer testing dan debugging
- **Database**: Local MySQL dengan test data
- **Configuration**: Debug mode enabled
- **Tools**: PHPUnit, browser dev tools

#### 6.3.2 Staging Environment
- **Purpose**: Integration testing dan UAT
- **Database**: Staging database dengan production-like data
- **Configuration**: Production-like settings
- **Tools**: Automated testing tools, performance monitoring

#### 6.3.3 Production Environment
- **Purpose**: Live system monitoring
- **Database**: Production database
- **Configuration**: Optimized production settings
- **Tools**: Monitoring tools, error tracking

### 6.4 Test Data Management

#### 6.4.1 Test Data Strategy
- **Synthetic Data**: Generated test data untuk development
- **Anonymized Data**: Production data dengan PII removed
- **Seed Data**: Consistent baseline data untuk testing
- **Dynamic Data**: Generated during test execution

#### 6.4.2 Data Cleanup
- **Automated Cleanup**: Test data removal after test completion
- **Database Reset**: Fresh database state untuk each test suite
- **File Cleanup**: Uploaded test files removal

### 6.5 Continuous Testing

#### 6.5.1 CI/CD Integration
- **Automated Testing**: Tests run pada every commit
- **Quality Gates**: Code coverage dan test pass requirements
- **Deployment Pipeline**: Automated testing dalam deployment process

#### 6.5.2 Monitoring & Reporting
- **Test Results Dashboard**: Real-time test execution results
- **Coverage Reports**: Code coverage tracking
- **Performance Metrics**: Test execution time monitoring
- **Defect Tracking**: Bug discovery dan resolution tracking

---

## 7. IMPLEMENTATION PLAN

### 7.1 Development Phases

#### 7.1.1 Phase 1: Foundation (Weeks 1-4)
**Sprint 1 (Week 1-2): Core Infrastructure**
- Database design dan creation
- Basic project structure setup
- Authentication system implementation
- User management (registration, login, logout)
- Basic admin panel setup

**Sprint 2 (Week 3-4): User Management**
- Customer profile management
- Admin user management
- Role-based access control
- Password reset functionality
- Email notification system

**Deliverables:**
- Working authentication system
- User management functionality
- Basic admin panel
- Database schema implemented

#### 7.1.2 Phase 2: Core Features (Weeks 5-10)
**Sprint 3 (Week 5-6): Reptile Management**
- Reptile category management
- Reptile registration system
- Photo upload functionality
- Reptile profile management
- Search dan filtering

**Sprint 4 (Week 7-8): Booking System**
- Booking creation workflow
- Date validation dan availability check
- Facility selection
- Booking status management
- Cost calculation

**Sprint 5 (Week 9-10): Payment System**
- Payment proof upload
- Payment verification workflow
- Payment status tracking
- Invoice generation
- Payment history

**Deliverables:**
- Complete reptile management system
- Functional booking system
- Payment processing workflow
- File upload system

#### 7.1.3 Phase 3: Advanced Features (Weeks 11-14)
**Sprint 6 (Week 11-12): Facility Management**
- Facility CRUD operations
- Capacity management
- Facility booking integration
- Maintenance scheduling
- Utilization tracking

**Sprint 7 (Week 13-14): Reporting System**
- Daily care reports
- Health record tracking
- Business reports generation
- Data visualization
- Export functionality

**Deliverables:**
- Facility management system
- Comprehensive reporting system
- Data visualization dashboard
- Export capabilities

#### 7.1.4 Phase 4: Enhancement & Polish (Weeks 15-18)
**Sprint 8 (Week 15-16): UI/UX Enhancement**
- Responsive design implementation
- User experience optimization
- Performance optimization
- Accessibility improvements
- Cross-browser testing

**Sprint 9 (Week 17-18): Testing & Deployment**
- Comprehensive testing
- Bug fixes dan optimization
- Security testing
- Performance testing
- Production deployment preparation

**Deliverables:**
- Polished user interface
- Optimized performance
- Comprehensive test coverage
- Production-ready system

### 7.2 Resource Allocation

#### 7.2.1 Team Structure
- **Project Manager**: 1 person (overall coordination)
- **Backend Developer**: 2 people (PHP, MySQL)
- **Frontend Developer**: 1 person (HTML, CSS, JavaScript)
- **UI/UX Designer**: 1 person (design dan user experience)
- **QA Tester**: 1 person (testing dan quality assurance)
- **DevOps Engineer**: 1 person (deployment dan infrastructure)

#### 7.2.2 Technology Stack
- **Development Environment**: XAMPP, VS Code, Git
- **Frontend**: HTML5, CSS3, Bootstrap 5, JavaScript, jQuery
- **Backend**: PHP 8.1, MySQL 8.0, Apache
- **Tools**: Composer, PHPUnit, Selenium, Docker

### 7.3 Risk Management

#### 7.3.1 Technical Risks
**Risk**: Database performance issues
- **Probability**: Medium
- **Impact**: High
- **Mitigation**: Database optimization, indexing, query optimization

**Risk**: Security vulnerabilities
- **Probability**: Medium
- **Impact**: Critical
- **Mitigation**: Security testing, code review, penetration testing

**Risk**: Integration complexity
- **Probability**: High
- **Impact**: Medium
- **Mitigation**: Incremental integration, thorough testing

#### 7.3.2 Project Risks
**Risk**: Scope creep
- **Probability**: High
- **Impact**: Medium
- **Mitigation**: Clear requirements documentation, change control process

**Risk**: Resource unavailability
- **Probability**: Medium
- **Impact**: High
- **Mitigation**: Cross-training, backup resources, flexible scheduling

### 7.4 Quality Assurance

#### 7.4.1 Code Quality Standards
- **Coding Standards**: PSR-12 untuk PHP, ESLint untuk JavaScript
- **Code Review**: Mandatory peer review untuk semua changes
- **Documentation**: Inline comments, API documentation
- **Version Control**: Git dengan feature branch workflow

#### 7.4.2 Testing Standards
- **Unit Test Coverage**: Minimum 80%
- **Integration Testing**: All API endpoints tested
- **User Acceptance Testing**: Stakeholder approval required
- **Performance Testing**: Load testing untuk 500 concurrent users

### 7.5 Deployment Strategy

#### 7.5.1 Environment Setup
**Development Environment**
- Local development dengan XAMPP
- Git repository untuk version control
- Automated testing setup

**Staging Environment**
- Production-like environment untuk testing
- Automated deployment dari development
- User acceptance testing environment

**Production Environment**
- Live system dengan optimized configuration
- Automated backup dan monitoring
- SSL certificate dan security hardening

#### 7.5.2 Deployment Process
1. **Code Review**: Peer review dan approval
2. **Testing**: Automated tests pass
3. **Staging Deployment**: Deploy to staging environment
4. **UAT**: User acceptance testing
5. **Production Deployment**: Deploy to production
6. **Monitoring**: Post-deployment monitoring

### 7.6 Maintenance Plan

#### 7.6.1 Ongoing Maintenance
**Daily Tasks**
- System health monitoring
- Backup verification
- Error log review
- Performance monitoring

**Weekly Tasks**
- Security updates
- Database optimization
- User feedback review
- Performance analysis

**Monthly Tasks**
- Full system backup
- Security audit
- Performance optimization
- Feature usage analysis

#### 7.6.2 Support Structure
- **Level 1 Support**: Basic user support dan troubleshooting
- **Level 2 Support**: Technical issues dan bug fixes
- **Level 3 Support**: Complex technical issues dan development
- **Emergency Support**: 24/7 support untuk critical issues

---

## 8. KEBUTUHAN SISTEM

### 8.1 Kebutuhan Hardware
#### 8.1.1 Server
- **Processor**: Intel Core i3 atau setara
- **RAM**: Minimal 4GB
- **Storage**: Minimal 20GB SSD
- **Network**: Koneksi internet stabil

#### 8.1.2 Client
- **Processor**: Dual-core 1GHz
- **RAM**: Minimal 2GB
- **Browser**: Chrome 90+, Firefox 88+, Safari 14+, Edge 90+
- **Network**: Koneksi internet minimal 1Mbps

### 8.2 Kebutuhan Software
#### 8.2.1 Server
- **Operating System**: Windows 10/11, Linux Ubuntu 20.04+, atau macOS 10.15+
- **Web Server**: Apache 2.4+
- **PHP**: Version 8.0+
- **Database**: MySQL 8.0+ atau MariaDB 10.5+
- **XAMPP**: Version 8.0+ (untuk development)

#### 8.2.2 Development Tools
- **Code Editor**: VS Code, PHPStorm, atau Sublime Text
- **Version Control**: Git
- **Database Tool**: phpMyAdmin, MySQL Workbench

---

## 9. INTERFACE PENGGUNA

### 9.1 Prinsip Desain
- **Responsif**: Dapat diakses dari berbagai ukuran layar
- **Konsisten**: Penggunaan warna, font, dan layout yang seragam
- **Intuitif**: Navigasi yang mudah dipahami
- **Accessible**: Memenuhi standar aksesibilitas web

### 9.2 Skema Warna
- **Primary**: #4a7c59 (Hijau)
- **Secondary**: #2c5530 (Hijau Gelap)
- **Success**: #28a745
- **Warning**: #ffc107
- **Danger**: #dc3545
- **Info**: #17a2b8

### 9.3 Typography
- **Font Family**: Poppins (Google Fonts)
- **Heading**: 600-700 weight
- **Body**: 400 weight
- **Small Text**: 300 weight

---

## 10. MAINTENANCE PLAN

### 10.1 Maintenance Strategy

#### 10.1.1 Maintenance Types
**Corrective Maintenance**
- **Purpose**: Fix bugs, errors, dan system failures
- **Trigger**: User reports, error logs, monitoring alerts
- **Response Time**: 
  - Critical issues: 2 hours
  - High priority: 24 hours
  - Medium priority: 72 hours
  - Low priority: 1 week

**Adaptive Maintenance**
- **Purpose**: Adapt system to environment changes
- **Examples**: PHP updates, browser compatibility, security patches
- **Schedule**: Monthly atau as needed

**Perfective Maintenance**
- **Purpose**: Improve performance dan add enhancements
- **Examples**: Performance optimization, UI improvements, new features
- **Schedule**: Quarterly releases

**Preventive Maintenance**
- **Purpose**: Prevent future problems
- **Activities**: Security audits, performance monitoring, code reviews
- **Schedule**: Monthly preventive checks

#### 10.1.2 Maintenance Schedule

**Daily Tasks (Automated)**
- System health monitoring
- Database backup verification
- Error log analysis
- Performance metrics collection
- Security monitoring

**Weekly Tasks**
- Security updates dan patches
- Database optimization
- Performance review
- User feedback analysis
- Code quality review

**Monthly Tasks**
- Comprehensive system backup
- Security audit
- Performance optimization
- Capacity planning
- Documentation updates

**Quarterly Tasks**
- Major system review
- Feature enhancement planning
- Technology stack evaluation
- Disaster recovery testing

### 10.2 Monitoring & Alerting

#### 10.2.1 System Monitoring
**Performance Monitoring**
- Page load time tracking
- Database query performance
- Server resource utilization
- User session analytics

**Security Monitoring**
- Failed login attempts
- Suspicious activity detection
- File integrity monitoring
- Access log analysis

**Application Monitoring**
- Error rate tracking
- Feature usage statistics
- User behavior analytics
- System availability monitoring

#### 10.2.2 Alert Configuration
**Critical Alerts (Immediate)**
- System down
- Database connection failure
- Security breach detection
- Data corruption

**Warning Alerts (24-hour)**
- High resource usage
- Slow performance
- Failed backups
- SSL certificate expiration

### 10.3 Backup & Recovery

#### 10.3.1 Backup Strategy
**Database Backup**
- Daily automated backups
- 30-day retention policy
- Cloud storage integration
- Automated restore testing

**File System Backup**
- Daily incremental backups
- Weekly full backups
- Encrypted storage
- Version control integration

#### 10.3.2 Disaster Recovery
**Recovery Objectives**
- Recovery Time Objective (RTO): 4 hours
- Recovery Point Objective (RPO): 1 hour
- Data integrity verification
- Business continuity planning

### 10.4 Support Structure

#### 10.4.1 Support Tiers
**Tier 1: Basic Support**
- User account issues
- Password resets
- General inquiries
- Response time: 4 hours

**Tier 2: Technical Support**
- Application bugs
- Performance issues
- Integration problems
- Response time: 24 hours

**Tier 3: Expert Support**
- System architecture issues
- Major bugs
- Security incidents
- Response time: 48 hours

#### 10.4.2 Documentation Maintenance
**Technical Documentation**
- System architecture updates
- API documentation
- Database schema changes
- Deployment procedures

**User Documentation**
- User manual updates
- Training materials
- FAQ maintenance
- Video tutorial updates

---

## 11. KESIMPULAN DAN REKOMENDASI

### 11.1 Kesimpulan

Sistem Informasi Penitipan Reptil "Baroon Reptile" telah dirancang sebagai solusi komprehensif untuk mengelola operasional penginapan reptil dengan pendekatan modern dan user-centric. Dokumen SKPL ini menguraikan:

**Aspek Fungsional:**
- Sistem autentikasi yang robust dengan keamanan berlapis
- Modul customer lengkap untuk manajemen reptil dan booking
- Modul admin powerful untuk operasional dan reporting
- Integrasi payment system dan notification system

**Aspek Non-Fungsional:**
- Performance requirements untuk 500 concurrent users
- Security framework comprehensive
- Usability design yang responsive dan accessible
- Reliability dengan 99.5% uptime target

**Aspek Teknis:**
- Arsitektur 3-tier yang scalable
- Technology stack modern (PHP 8.1, MySQL 8.0, Bootstrap 5)
- Comprehensive testing strategy dengan 80% coverage
- Detailed implementation plan 18-week timeline
- Robust maintenance plan dengan proactive monitoring

### 11.2 Keunggulan Sistem

**Untuk Customer:**
- Interface intuitif dan mobile-responsive
- Proses booking yang streamlined
- Real-time tracking status reptil
- Notification system untuk updates
- Transparent pricing dan payment

**Untuk Administrator:**
- Dashboard comprehensive dengan analytics
- Automated reporting dan business intelligence
- Efficient workflow untuk approval
- Scalable architecture untuk growth
- Audit trail untuk compliance

**Untuk Bisnis:**
- Operational efficiency dengan automation
- Data-driven decision making
- Enhanced customer satisfaction
- Competitive advantage dengan modern tech
- Cost-effective maintenance

### 11.3 Rekomendasi Implementasi

#### 11.3.1 Prioritas Phase
**Phase 1 (Critical - Weeks 1-4):**
- Setup development environment
- Core authentication system
- Basic user management
- Essential security measures

**Phase 2 (High Priority - Weeks 5-10):**
- Reptile management system
- Booking workflow
- Payment processing
- Basic reporting

**Phase 3 (Medium Priority - Weeks 11-14):**
- Advanced admin features
- Comprehensive reporting
- Notification system
- Performance optimization

**Phase 4 (Enhancement - Weeks 15-18):**
- UI/UX polishing
- Advanced analytics
- Mobile optimization
- Additional integrations

#### 11.3.2 Success Factors
**Technical:**
- Adherence to coding standards
- Comprehensive testing
- Regular code reviews
- Proper documentation
- CI/CD implementation

**Project Management:**
- Clear stakeholder communication
- Regular progress monitoring
- Risk management strategies
- Resource allocation
- Change management procedures

#### 11.3.3 Future Enhancements
**Short-term (6 months):**
- Payment gateway integration
- SMS/WhatsApp notifications
- Advanced reporting features
- Mobile app development

**Medium-term (1 year):**
- AI-powered analytics
- IoT integration untuk monitoring
- Multi-language support
- API untuk third-party integrations

**Long-term (2+ years):**
- Machine learning untuk predictive analytics
- Blockchain untuk secure transactions
- AR/VR untuk virtual facility tours
- Advanced automation features

### 11.4 Expected Outcomes

**Operational Benefits:**
- 50% reduction dalam manual tasks
- 30% improvement dalam customer satisfaction
- 25% increase dalam operational efficiency
- 40% reduction dalam booking processing time

**Business Benefits:**
- Enhanced customer experience
- Improved data visibility
- Scalable platform untuk expansion
- Competitive advantage

**Technical Benefits:**
- Maintainable codebase
- Scalable infrastructure
- Comprehensive monitoring
- Security framework

Sistem "Baroon Reptile" diharapkan menjadi foundation solid untuk operasional penginapan reptil modern, efisien, dan customer-centric, dengan kemampuan berkembang seiring pertumbuhan bisnis dan evolusi teknologi.

---

**Dokumen ini disusun oleh Tim Pengembang Baroon Reptile**  
**Tanggal: Desember 2024**  
**Versi: 1.0**