# Changelog - Baroon Reptile System

Semua perubahan penting pada proyek ini akan didokumentasikan dalam file ini.

Format berdasarkan [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
dan proyek ini mengikuti [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2025-01-19

### Added
- **Sistem Autentikasi Lengkap**
  - Login untuk admin dan customer
  - Session management yang aman
  - Password hashing dengan bcrypt
  - Demo accounts (admin/admin123, customer1/customer123)

- **Dashboard Customer**
  - Statistik personal (total reptil, booking aktif, total pembayaran)
  - Manajemen profil reptil (tambah, edit, hapus)
  - Sistem booking dengan kalkulasi biaya otomatis
  - Riwayat booking dan pembayaran
  - Pengaturan profil dan akun

- **Dashboard Administrator**
  - Statistik monitoring sistem
  - Manajemen customer dan reptil
  - Manajemen booking dan pembayaran
  - Manajemen fasilitas
  - Laporan harian
  - Pengaturan sistem

- **Database Design**
  - 8 tabel utama dengan relasi yang tepat
  - Normalisasi database hingga 3NF
  - Foreign key constraints
  - Data demo untuk testing

- **UI/UX Design**
  - Responsive design dengan Bootstrap 5
  - Tema hijau yang konsisten
  - Typography menggunakan Google Fonts (Poppins)
  - Icons dari Font Awesome
  - Charts interaktif dengan Chart.js

- **Keamanan**
  - File .htaccess untuk konfigurasi Apache
  - Proteksi direktori sensitif
  - Input validation dan sanitization
  - Session security
  - File upload restrictions
  - Error pages (404, 403, 500)

- **Dokumentasi**
  - SKPL (Software Requirements Specification)
  - SPPL (Software Design Specification)
  - User Manual untuk customer dan admin
  - README.md dengan panduan instalasi
  - Changelog untuk tracking perubahan

- **Fitur Tambahan**
  - Backup system untuk database dan files
  - Robots.txt untuk SEO
  - Upload directory dengan security
  - Error handling yang comprehensive

### Technical Details
- **Backend**: PHP 8+ dengan PDO
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5.3
- **Database**: MySQL 8+
- **Libraries**: Chart.js, Font Awesome, Google Fonts
- **Security**: bcrypt hashing, session management, input validation

### File Structure
```
baroonreptil/
├── assets/           # CSS, JS, images
├── auth/            # Authentication files
├── config/          # Database configuration
├── customer/        # Customer dashboard
├── admin/           # Admin dashboard
├── includes/        # Shared PHP includes
├── uploads/         # File upload directory
├── docs/           # Documentation
├── database/       # SQL files
└── backups/        # Backup files
```

### Demo Accounts
- **Administrator**: admin / admin123
- **Customer**: customer1 / customer123

### Known Issues
- None at this time

### Future Enhancements
- Email notifications
- Payment gateway integration
- Mobile app
- Advanced reporting
- Multi-language support

---

## Template untuk Update Selanjutnya

### [Unreleased]

#### Added
- Fitur baru yang ditambahkan

#### Changed
- Perubahan pada fitur yang sudah ada

#### Deprecated
- Fitur yang akan dihapus di versi mendatang

#### Removed
- Fitur yang dihapus

#### Fixed
- Bug fixes

#### Security
- Perbaikan keamanan

---

**Catatan**: Untuk informasi lebih detail tentang setiap perubahan, silakan lihat commit history di repository atau hubungi tim development.