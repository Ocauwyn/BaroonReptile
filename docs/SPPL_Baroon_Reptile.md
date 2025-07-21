# SPESIFIKASI PERANCANGAN PERANGKAT LUNAK (SPPL)
# SISTEM INFORMASI PENITIPAN REPTIL "BAROON REPTILE"

---

## 1. PENDAHULUAN

### 1.1 Tujuan Dokumen
Dokumen ini berisi spesifikasi perancangan perangkat lunak untuk Sistem Informasi Penitipan Reptil "Baroon Reptile". Dokumen ini menjelaskan arsitektur sistem, desain database, desain interface, dan implementasi teknis dari sistem yang akan dikembangkan.

### 1.2 Ruang Lingkup
Dokumen ini mencakup:
- Arsitektur sistem dan komponen
- Desain database dan struktur data
- Desain interface pengguna
- Spesifikasi teknis implementasi
- Diagram alur sistem
- Security design

### 1.3 Referensi
- SKPL Baroon Reptile v1.0
- IEEE Std 1016-2009 - IEEE Standard for Information Technology
- PHP Best Practices Documentation
- MySQL Design Guidelines

---

## 2. ARSITEKTUR SISTEM

### 2.1 Arsitektur Umum

```
┌─────────────────────────────────────────────────────────┐
│                    CLIENT LAYER                         │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐    │
│  │   Desktop   │  │   Tablet    │  │   Mobile    │    │
│  │   Browser   │  │   Browser   │  │   Browser   │    │
│  └─────────────┘  └─────────────┘  └─────────────┘    │
└─────────────────────────────────────────────────────────┘
                            │
                     HTTP/HTTPS
                            │
┌─────────────────────────────────────────────────────────┐
│                 PRESENTATION LAYER                      │
│  ┌─────────────────────────────────────────────────────┐│
│  │              Apache Web Server                      ││
│  │  ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐  ││
│  │  │   HTML  │ │   CSS   │ │   JS    │ │Bootstrap│  ││
│  │  └─────────┘ └─────────┘ └─────────┘ └─────────┘  ││
│  └─────────────────────────────────────────────────────┘│
└─────────────────────────────────────────────────────────┘
                            │
                      PHP Include
                            │
┌─────────────────────────────────────────────────────────┐
│                 APPLICATION LAYER                       │
│  ┌─────────────────────────────────────────────────────┐│
│  │                  PHP Engine                         ││
│  │  ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐  ││
│  │  │  Auth   │ │Customer │ │  Admin  │ │ Config  │  ││
│  │  │ Module  │ │ Module  │ │ Module  │ │ Module  │  ││
│  │  └─────────┘ └─────────┘ └─────────┘ └─────────┘  ││
│  └─────────────────────────────────────────────────────┘│
└─────────────────────────────────────────────────────────┘
                            │
                         PDO/SQL
                            │
┌─────────────────────────────────────────────────────────┐
│                    DATA LAYER                           │
│  ┌─────────────────────────────────────────────────────┐│
│  │                MySQL Database                       ││
│  │  ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐  ││
│  │  │  Users  │ │Reptiles │ │Bookings │ │Payments │  ││
│  │  │  Table  │ │  Table  │ │  Table  │ │  Table  │  ││
│  │  └─────────┘ └─────────┘ └─────────┘ └─────────┘  ││
│  └─────────────────────────────────────────────────────┘│
└─────────────────────────────────────────────────────────┘
```

### 2.2 Komponen Sistem

#### 2.2.1 Presentation Layer
- **Web Server**: Apache HTTP Server
- **Frontend Framework**: Bootstrap 5.3
- **CSS Framework**: Custom CSS + Bootstrap
- **JavaScript**: Vanilla JS + Chart.js
- **Icons**: Font Awesome 6.0
- **Fonts**: Google Fonts (Poppins)

#### 2.2.2 Application Layer
- **Backend Language**: PHP 8.0+
- **Database Abstraction**: PDO (PHP Data Objects)
- **Session Management**: PHP Sessions
- **File Upload**: PHP File Handling
- **Security**: Password Hashing, Input Validation

#### 2.2.3 Data Layer
- **Database**: MySQL 8.0+
- **Storage Engine**: InnoDB
- **Character Set**: UTF-8
- **Backup Strategy**: Daily automated backup

---

## 3. DESAIN DATABASE

### 3.1 Entity Relationship Diagram (ERD)

```
                    ┌─────────────────┐
                    │      Users      │
                    │─────────────────│
                    │ id (PK)         │
                    │ username        │
                    │ email           │
                    │ password        │
                    │ full_name       │
                    │ phone           │
                    │ address         │
                    │ role            │
                    │ status          │
                    │ created_at      │
                    │ updated_at      │
                    └─────────────────┘
                            │
                            │ 1:N
                            │
                    ┌─────────────────┐
                    │    Reptiles     │
                    │─────────────────│
                    │ id (PK)         │
                    │ customer_id (FK)│
                    │ category_id (FK)│
                    │ name            │
                    │ species         │
                    │ age             │
                    │ weight          │
                    │ length          │
                    │ gender          │
                    │ photo           │
                    │ special_needs   │
                    │ status          │
                    │ created_at      │
                    │ updated_at      │
                    └─────────────────┘
                            │
                            │ N:1
                            │
            ┌─────────────────────────────────┐
            │                                 │
    ┌─────────────────┐              ┌─────────────────┐
    │ReptileCategories│              │    Bookings     │
    │─────────────────│              │─────────────────│
    │ id (PK)         │              │ id (PK)         │
    │ name            │              │ customer_id (FK)│
    │ description     │              │ reptile_id (FK) │
    │ price_per_day   │              │ start_date      │
    │ status          │              │ end_date        │
    │ created_at      │              │ total_days      │
    │ updated_at      │              │ base_price      │
    └─────────────────┘              │ facility_price  │
                                     │ total_amount    │
                                     │ special_notes   │
                                     │ status          │
                                     │ created_at      │
                                     │ updated_at      │
                                     └─────────────────┘
                                             │
                                             │ 1:N
                                             │
                                     ┌─────────────────┐
                                     │    Payments     │
                                     │─────────────────│
                                     │ id (PK)         │
                                     │ booking_id (FK) │
                                     │ amount          │
                                     │ payment_method  │
                                     │ payment_date    │
                                     │ status          │
                                     │ notes           │
                                     │ created_at      │
                                     │ updated_at      │
                                     └─────────────────┘

    ┌─────────────────┐              ┌─────────────────┐
    │   Facilities    │              │BookingFacilities│
    │─────────────────│              │─────────────────│
    │ id (PK)         │              │ booking_id (FK) │
    │ name            │              │ facility_id (FK)│
    │ description     │              │ quantity        │
    │ price           │              │ price           │
    │ status          │              └─────────────────┘
    │ created_at      │
    │ updated_at      │
    └─────────────────┘

    ┌─────────────────┐              ┌─────────────────┐
    │  DailyReports   │              │  Testimonials   │
    │─────────────────│              │─────────────────│
    │ id (PK)         │              │ id (PK)         │
    │ report_date     │              │ customer_id (FK)│
    │ total_bookings  │              │ rating          │
    │ total_revenue   │              │ comment         │
    │ active_reptiles │              │ status          │
    │ notes           │              │ created_at      │
    │ created_at      │              └─────────────────┘
    │ updated_at      │
    └─────────────────┘
```

### 3.2 Spesifikasi Tabel

#### 3.2.1 Tabel Users
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role ENUM('admin', 'customer') DEFAULT 'customer',
    status ENUM('active', 'inactive', 'deleted') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_status (status)
);
```

#### 3.2.2 Tabel Reptile_Categories
```sql
CREATE TABLE reptile_categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    price_per_day DECIMAL(10,2) NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_name (name),
    INDEX idx_status (status)
);
```

#### 3.2.3 Tabel Reptiles
```sql
CREATE TABLE reptiles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    category_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    species VARCHAR(100) NOT NULL,
    age INT,
    weight DECIMAL(5,2),
    length DECIMAL(5,2),
    gender ENUM('male', 'female', 'unknown') DEFAULT 'unknown',
    photo VARCHAR(255),
    special_needs TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES reptile_categories(id),
    
    INDEX idx_customer (customer_id),
    INDEX idx_category (category_id),
    INDEX idx_name (name),
    INDEX idx_status (status)
);
```

#### 3.2.4 Tabel Bookings
```sql
CREATE TABLE bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    reptile_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_days INT NOT NULL,
    base_price DECIMAL(10,2) NOT NULL,
    facility_price DECIMAL(10,2) DEFAULT 0,
    total_amount DECIMAL(10,2) NOT NULL,
    special_notes TEXT,
    status ENUM('pending', 'confirmed', 'active', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reptile_id) REFERENCES reptiles(id) ON DELETE CASCADE,
    
    INDEX idx_customer (customer_id),
    INDEX idx_reptile (reptile_id),
    INDEX idx_dates (start_date, end_date),
    INDEX idx_status (status)
);
```

### 3.3 Normalisasi Database

#### 3.3.1 First Normal Form (1NF)
- Semua atribut memiliki nilai atomik
- Tidak ada repeating groups
- Setiap baris unik dengan primary key

#### 3.3.2 Second Normal Form (2NF)
- Memenuhi 1NF
- Tidak ada partial dependency
- Non-key attributes fully dependent pada primary key

#### 3.3.3 Third Normal Form (3NF)
- Memenuhi 2NF
- Tidak ada transitive dependency
- Non-key attributes tidak bergantung pada non-key attributes lain

---

## 4. DESAIN INTERFACE

### 4.1 Prinsip Desain UI/UX

#### 4.1.1 Design Principles
- **Consistency**: Konsistensi dalam layout, warna, dan typography
- **Simplicity**: Interface yang sederhana dan tidak membingungkan
- **Accessibility**: Dapat diakses oleh semua pengguna
- **Responsiveness**: Adaptif terhadap berbagai ukuran layar
- **Feedback**: Memberikan feedback yang jelas untuk setiap aksi

#### 4.1.2 Color Scheme
```css
:root {
    --primary-color: #4a7c59;
    --primary-dark: #2c5530;
    --secondary-color: #6c757d;
    --success-color: #28a745;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
    --info-color: #17a2b8;
    --light-color: #f8f9fa;
    --dark-color: #343a40;
    --white: #ffffff;
}
```

#### 4.1.3 Typography
```css
/* Font Family */
font-family: 'Poppins', sans-serif;

/* Font Weights */
--font-light: 300;
--font-regular: 400;
--font-medium: 500;
--font-semibold: 600;
--font-bold: 700;

/* Font Sizes */
--font-xs: 0.75rem;    /* 12px */
--font-sm: 0.875rem;   /* 14px */
--font-base: 1rem;     /* 16px */
--font-lg: 1.125rem;   /* 18px */
--font-xl: 1.25rem;    /* 20px */
--font-2xl: 1.5rem;    /* 24px */
--font-3xl: 1.875rem;  /* 30px */
--font-4xl: 2.25rem;   /* 36px */
```

### 4.2 Layout Structure

#### 4.2.1 Landing Page Layout
```
┌─────────────────────────────────────────────────────────┐
│                    NAVIGATION BAR                       │
│  Logo    Home  Services  About  Contact    Login/Reg   │
└─────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────┐
│                     HERO SECTION                       │
│              Welcome to Baroon Reptile                 │
│           Professional Reptile Care Service            │
│                   [Get Started]                        │
└─────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────┐
│                   SERVICES SECTION                     │
│  [Service 1]    [Service 2]    [Service 3]            │
└─────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────┐
│                  STATISTICS SECTION                    │
│   [Stat 1]      [Stat 2]      [Stat 3]     [Stat 4]   │
└─────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────┐
│                     FOOTER                             │
│        Contact Info    Links    Social Media           │
└─────────────────────────────────────────────────────────┘
```

#### 4.2.2 Dashboard Layout
```
┌─────────────┬───────────────────────────────────────────┐
│             │              TOP NAVBAR                   │
│             │  Dashboard Title        User Menu         │
│   SIDEBAR   ├───────────────────────────────────────────┤
│             │                                           │
│ - Dashboard │              MAIN CONTENT                 │
│ - Reptiles  │                                           │
│ - Bookings  │  ┌─────────┐ ┌─────────┐ ┌─────────┐    │
│ - Profile   │  │ Stat 1  │ │ Stat 2  │ │ Stat 3  │    │
│ - Settings  │  └─────────┘ └─────────┘ └─────────┘    │
│             │                                           │
│             │  ┌─────────────────────────────────────┐  │
│             │  │           Data Table            │  │
│             │  └─────────────────────────────────────┘  │
└─────────────┴───────────────────────────────────────────┘
```

### 4.3 Component Design

#### 4.3.1 Button Styles
```css
/* Primary Button */
.btn-primary {
    background: linear-gradient(135deg, #4a7c59, #2c5530);
    border: none;
    border-radius: 10px;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2c5530, #1a3d1f);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
```

#### 4.3.2 Card Styles
```css
.card {
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    border: none;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
```

#### 4.3.3 Form Styles
```css
.form-control {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4a7c59;
    box-shadow: 0 0 0 0.2rem rgba(74, 124, 89, 0.25);
}
```

---

## 5. DESAIN MODUL

### 5.1 Authentication Module

#### 5.1.1 Class Diagram
```
┌─────────────────────────────────┐
│           AuthManager           │
├─────────────────────────────────┤
│ - db: PDO                       │
│ - session: Session              │
├─────────────────────────────────┤
│ + login(username, password)     │
│ + register(userData)            │
│ + logout()                      │
│ + isLoggedIn()                  │
│ + getCurrentUser()              │
│ + validatePassword(password)    │
│ + hashPassword(password)        │
└─────────────────────────────────┘
```

#### 5.1.2 Sequence Diagram - Login Process
```
User        LoginPage       AuthManager      Database
 │              │               │              │
 │─────────────▶│               │              │
 │ Enter creds  │               │              │
 │              │──────────────▶│              │
 │              │ validateLogin │              │
 │              │               │─────────────▶│
 │              │               │ checkUser    │
 │              │               │◀─────────────│
 │              │               │ userData     │
 │              │◀──────────────│              │
 │              │ loginResult   │              │
 │◀─────────────│               │              │
 │ redirect     │               │              │
```

### 5.2 Customer Module

#### 5.2.1 Class Diagram
```
┌─────────────────────────────────┐
│         CustomerManager         │
├─────────────────────────────────┤
│ - db: PDO                       │
│ - customerId: int               │
├─────────────────────────────────┤
│ + getReptiles()                 │
│ + addReptile(reptileData)       │
│ + updateReptile(id, data)       │
│ + deleteReptile(id)             │
│ + getBookings()                 │
│ + createBooking(bookingData)    │
│ + cancelBooking(id)             │
│ + updateProfile(profileData)    │
└─────────────────────────────────┘
```

### 5.3 Admin Module

#### 5.3.1 Class Diagram
```
┌─────────────────────────────────┐
│          AdminManager           │
├─────────────────────────────────┤
│ - db: PDO                       │
├─────────────────────────────────┤
│ + getAllCustomers()             │
│ + getAllReptiles()              │
│ + getAllBookings()              │
│ + updateBookingStatus(id, stat) │
│ + generateReport(date)          │
│ + getStatistics()               │
│ + manageFacilities()            │
│ + managePayments()              │
└─────────────────────────────────┘
```

---

## 6. ALGORITMA DAN FLOWCHART

### 6.1 Algoritma Login

```
ALGORITHM Login
INPUT: username, password
OUTPUT: login_result

BEGIN
    1. Validate input (not empty)
    2. IF input invalid THEN
         RETURN error_message
       END IF
    
    3. Query user from database WHERE username = input_username
    4. IF user not found THEN
         RETURN "User not found"
       END IF
    
    5. Verify password using password_verify()
    6. IF password incorrect THEN
         RETURN "Invalid password"
       END IF
    
    7. Check user status
    8. IF status != 'active' THEN
         RETURN "Account inactive"
       END IF
    
    9. Create session
    10. Set session variables (user_id, role, etc.)
    11. RETURN success
END
```

### 6.2 Flowchart - Booking Process

```
    [START]
       │
       ▼
 [Select Reptile]
       │
       ▼
 [Choose Dates]
       │
       ▼
  [Check Availability] ──No──▶ [Show Error]
       │                           │
      Yes                         │
       ▼                          │
 [Select Facilities]              │
       │                          │
       ▼                          │
 [Calculate Total Cost]           │
       │                          │
       ▼                          │
 [Confirm Booking]                │
       │                          │
       ▼                          │
 [Save to Database] ──Error──────┘
       │
     Success
       ▼
 [Send Confirmation]
       │
       ▼
     [END]
```

### 6.3 Algoritma Perhitungan Biaya

```
ALGORITHM CalculateBookingCost
INPUT: reptile_id, start_date, end_date, facilities[]
OUTPUT: total_cost

BEGIN
    1. Get reptile category and price_per_day
    2. Calculate total_days = end_date - start_date + 1
    3. base_cost = price_per_day * total_days
    
    4. facility_cost = 0
    5. FOR each facility in facilities[]
         facility_cost += facility.price * total_days
       END FOR
    
    6. total_cost = base_cost + facility_cost
    7. RETURN total_cost
END
```

---

## 7. SECURITY DESIGN

### 7.1 Authentication Security

#### 7.1.1 Password Security
```php
// Password Hashing
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Password Verification
$isValid = password_verify($inputPassword, $storedHash);

// Password Strength Requirements
- Minimum 6 characters
- Combination of letters and numbers recommended
- Special characters encouraged
```

#### 7.1.2 Session Security
```php
// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_strict_mode', 1);

// Session Timeout
$timeout = 2 * 60 * 60; // 2 hours
if (time() - $_SESSION['last_activity'] > $timeout) {
    session_destroy();
    header('Location: login.php');
}
$_SESSION['last_activity'] = time();
```

### 7.2 Input Validation

#### 7.2.1 SQL Injection Prevention
```php
// Use Prepared Statements
$stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);

// Input Sanitization
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
```

#### 7.2.2 File Upload Security
```php
// File Type Validation
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($_FILES['photo']['type'], $allowedTypes)) {
    throw new Exception('Invalid file type');
}

// File Size Validation
$maxSize = 5 * 1024 * 1024; // 5MB
if ($_FILES['photo']['size'] > $maxSize) {
    throw new Exception('File too large');
}

// Secure File Naming
$filename = uniqid() . '_' . basename($_FILES['photo']['name']);
```

### 7.3 Access Control

#### 7.3.1 Role-Based Access Control
```php
function checkAccess($requiredRole) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
    
    if ($_SESSION['role'] !== $requiredRole) {
        header('Location: unauthorized.php');
        exit;
    }
}

// Usage
checkAccess('admin'); // For admin pages
checkAccess('customer'); // For customer pages
```

---

## 8. PERFORMANCE OPTIMIZATION

### 8.1 Database Optimization

#### 8.1.1 Indexing Strategy
```sql
-- Primary Indexes
ALTER TABLE users ADD INDEX idx_username (username);
ALTER TABLE users ADD INDEX idx_email (email);
ALTER TABLE reptiles ADD INDEX idx_customer (customer_id);
ALTER TABLE bookings ADD INDEX idx_dates (start_date, end_date);

-- Composite Indexes
ALTER TABLE bookings ADD INDEX idx_customer_status (customer_id, status);
ALTER TABLE reptiles ADD INDEX idx_customer_status (customer_id, status);
```

#### 8.1.2 Query Optimization
```sql
-- Use LIMIT for pagination
SELECT * FROM bookings 
WHERE customer_id = ? 
ORDER BY created_at DESC 
LIMIT 10 OFFSET 0;

-- Use EXISTS instead of IN for subqueries
SELECT * FROM reptiles r
WHERE EXISTS (
    SELECT 1 FROM bookings b 
    WHERE b.reptile_id = r.id 
    AND b.status = 'active'
);
```

### 8.2 Frontend Optimization

#### 8.2.1 CSS Optimization
```css
/* Minimize CSS */
/* Use CSS Grid and Flexbox for layouts */
/* Avoid deep nesting */
/* Use efficient selectors */

/* Example: Efficient grid layout */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}
```

#### 8.2.2 JavaScript Optimization
```javascript
// Lazy loading for images
const images = document.querySelectorAll('img[data-src]');
const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.classList.remove('lazy');
            imageObserver.unobserve(img);
        }
    });
});

images.forEach(img => imageObserver.observe(img));
```

---

## 9. ERROR HANDLING

### 9.1 Exception Handling Strategy

```php
// Custom Exception Classes
class DatabaseException extends Exception {}
class ValidationException extends Exception {}
class AuthenticationException extends Exception {}

// Global Error Handler
function handleError($errno, $errstr, $errfile, $errline) {
    error_log("Error: [$errno] $errstr in $errfile on line $errline");
    
    if (ini_get('display_errors')) {
        echo "<div class='alert alert-danger'>An error occurred. Please try again.</div>";
    }
}

set_error_handler('handleError');
```

### 9.2 User-Friendly Error Messages

```php
// Error Message Mapping
$errorMessages = [
    'DUPLICATE_EMAIL' => 'Email sudah terdaftar. Silakan gunakan email lain.',
    'INVALID_LOGIN' => 'Username atau password salah.',
    'FILE_TOO_LARGE' => 'Ukuran file terlalu besar. Maksimal 5MB.',
    'BOOKING_CONFLICT' => 'Tanggal yang dipilih tidak tersedia.',
    'INSUFFICIENT_PERMISSION' => 'Anda tidak memiliki akses untuk halaman ini.'
];

function getErrorMessage($errorCode) {
    global $errorMessages;
    return $errorMessages[$errorCode] ?? 'Terjadi kesalahan sistem.';
}
```

---

## 10. TESTING STRATEGY

### 10.1 Unit Testing

```php
// Example Unit Test for Authentication
class AuthTest extends PHPUnit\Framework\TestCase {
    
    public function testValidLogin() {
        $auth = new AuthManager($this->mockDatabase);
        $result = $auth->login('testuser', 'password123');
        $this->assertTrue($result['success']);
    }
    
    public function testInvalidLogin() {
        $auth = new AuthManager($this->mockDatabase);
        $result = $auth->login('testuser', 'wrongpassword');
        $this->assertFalse($result['success']);
    }
    
    public function testPasswordHashing() {
        $auth = new AuthManager($this->mockDatabase);
        $hash = $auth->hashPassword('password123');
        $this->assertTrue(password_verify('password123', $hash));
    }
}
```

### 10.2 Integration Testing

```php
// Example Integration Test
class BookingIntegrationTest extends PHPUnit\Framework\TestCase {
    
    public function testCreateBookingFlow() {
        // 1. Login as customer
        $this->loginAsCustomer();
        
        // 2. Add reptile
        $reptileId = $this->addTestReptile();
        
        // 3. Create booking
        $bookingData = [
            'reptile_id' => $reptileId,
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-07'
        ];
        
        $booking = new BookingManager($this->database);
        $result = $booking->create($bookingData);
        
        $this->assertTrue($result['success']);
        $this->assertNotNull($result['booking_id']);
    }
}
```

---

## 11. DEPLOYMENT STRATEGY

### 11.1 Environment Configuration

#### 11.1.1 Development Environment
```php
// config/development.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'baroon_reptile_dev');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DEBUG_MODE', true);
define('BASE_URL', 'http://localhost/baroonreptil/');
```

#### 11.1.2 Production Environment
```php
// config/production.php
define('DB_HOST', 'production-server');
define('DB_NAME', 'baroon_reptile_prod');
define('DB_USER', 'prod_user');
define('DB_PASS', 'secure_password');
define('DEBUG_MODE', false);
define('BASE_URL', 'https://baroonreptile.com/');
```

### 11.2 Deployment Checklist

- [ ] Database migration scripts ready
- [ ] Environment variables configured
- [ ] SSL certificate installed
- [ ] File permissions set correctly
- [ ] Backup strategy implemented
- [ ] Monitoring tools configured
- [ ] Error logging enabled
- [ ] Performance optimization applied

---

## 12. MAINTENANCE PLAN

### 12.1 Regular Maintenance Tasks

#### 12.1.1 Daily Tasks
- Database backup
- Log file rotation
- System health check
- Security scan

#### 12.1.2 Weekly Tasks
- Performance monitoring
- User activity analysis
- Security updates
- Code review

#### 12.1.3 Monthly Tasks
- Full system backup
- Database optimization
- Security audit
- Feature usage analysis

### 12.2 Monitoring and Alerting

```php
// System Health Monitor
class SystemMonitor {
    
    public function checkDatabaseConnection() {
        try {
            $db = getDB();
            $stmt = $db->query('SELECT 1');
            return true;
        } catch (Exception $e) {
            $this->sendAlert('Database connection failed: ' . $e->getMessage());
            return false;
        }
    }
    
    public function checkDiskSpace() {
        $freeSpace = disk_free_space('/');
        $totalSpace = disk_total_space('/');
        $usagePercent = (($totalSpace - $freeSpace) / $totalSpace) * 100;
        
        if ($usagePercent > 90) {
            $this->sendAlert('Disk space usage is at ' . round($usagePercent, 2) . '%');
        }
    }
    
    private function sendAlert($message) {
        // Send email or SMS alert
        error_log('ALERT: ' . $message);
    }
}
```

---

## 13. ADVANCED ARCHITECTURE PATTERNS

### 13.1 Design Patterns Implementation

#### 13.1.1 Repository Pattern
```php
// Repository Interface
interface ReptileRepositoryInterface {
    public function findById($id);
    public function findByUserId($userId);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}

// Repository Implementation
class ReptileRepository implements ReptileRepositoryInterface {
    private $db;
    
    public function __construct(Database $db) {
        $this->db = $db;
    }
    
    public function findById($id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM reptiles WHERE id = ? AND deleted_at IS NULL"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function findByUserId($userId) {
        $stmt = $this->db->prepare(
            "SELECT * FROM reptiles WHERE user_id = ? AND deleted_at IS NULL ORDER BY created_at DESC"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function create(array $data) {
        $stmt = $this->db->prepare(
            "INSERT INTO reptiles (user_id, category_id, name, species, age, weight, description, photo, created_at) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())"
        );
        
        return $stmt->execute([
            $data['user_id'],
            $data['category_id'],
            $data['name'],
            $data['species'],
            $data['age'],
            $data['weight'],
            $data['description'],
            $data['photo']
        ]);
    }
}
```

#### 13.1.2 Service Layer Pattern
```php
// Service Layer for Business Logic
class BookingService {
    private $bookingRepo;
    private $reptileRepo;
    private $facilityRepo;
    private $notificationService;
    
    public function __construct(
        BookingRepositoryInterface $bookingRepo,
        ReptileRepositoryInterface $reptileRepo,
        FacilityRepositoryInterface $facilityRepo,
        NotificationService $notificationService
    ) {
        $this->bookingRepo = $bookingRepo;
        $this->reptileRepo = $reptileRepo;
        $this->facilityRepo = $facilityRepo;
        $this->notificationService = $notificationService;
    }
    
    public function createBooking(array $bookingData) {
        // Validate business rules
        $this->validateBookingRules($bookingData);
        
        // Check availability
        if (!$this->checkAvailability($bookingData)) {
            throw new BookingException('Tanggal tidak tersedia');
        }
        
        // Calculate total cost
        $totalCost = $this->calculateTotalCost($bookingData);
        $bookingData['total_cost'] = $totalCost;
        
        // Create booking
        $bookingId = $this->bookingRepo->create($bookingData);
        
        // Send notification
        $this->notificationService->sendBookingConfirmation($bookingId);
        
        return $bookingId;
    }
    
    private function validateBookingRules(array $data) {
        // Business rule validations
        if (strtotime($data['start_date']) < strtotime('today')) {
            throw new ValidationException('Tanggal mulai tidak boleh di masa lalu');
        }
        
        if (strtotime($data['end_date']) <= strtotime($data['start_date'])) {
            throw new ValidationException('Tanggal selesai harus setelah tanggal mulai');
        }
        
        // Check if reptile belongs to user
        $reptile = $this->reptileRepo->findById($data['reptile_id']);
        if (!$reptile || $reptile['user_id'] != $data['user_id']) {
            throw new AuthorizationException('Reptil tidak ditemukan atau bukan milik Anda');
        }
    }
}
```

#### 13.1.3 Factory Pattern
```php
// Factory for creating different types of reports
class ReportFactory {
    public static function createReport($type, $parameters = []) {
        switch ($type) {
            case 'daily':
                return new DailyReport($parameters);
            case 'monthly':
                return new MonthlyReport($parameters);
            case 'booking':
                return new BookingReport($parameters);
            case 'revenue':
                return new RevenueReport($parameters);
            default:
                throw new InvalidArgumentException('Unknown report type: ' . $type);
        }
    }
}

// Usage
$report = ReportFactory::createReport('monthly', [
    'month' => '2024-01',
    'format' => 'pdf'
]);
$reportData = $report->generate();
```

### 13.2 Dependency Injection Container

```php
// Simple DI Container
class Container {
    private $bindings = [];
    private $instances = [];
    
    public function bind($abstract, $concrete) {
        $this->bindings[$abstract] = $concrete;
    }
    
    public function singleton($abstract, $concrete) {
        $this->bind($abstract, $concrete);
        $this->instances[$abstract] = null;
    }
    
    public function resolve($abstract) {
        // Return singleton instance if exists
        if (isset($this->instances[$abstract]) && $this->instances[$abstract] !== null) {
            return $this->instances[$abstract];
        }
        
        // Get concrete implementation
        $concrete = $this->bindings[$abstract] ?? $abstract;
        
        // Create instance
        $instance = $this->build($concrete);
        
        // Store singleton
        if (isset($this->instances[$abstract])) {
            $this->instances[$abstract] = $instance;
        }
        
        return $instance;
    }
    
    private function build($concrete) {
        if ($concrete instanceof Closure) {
            return $concrete($this);
        }
        
        $reflector = new ReflectionClass($concrete);
        $constructor = $reflector->getConstructor();
        
        if (!$constructor) {
            return new $concrete;
        }
        
        $parameters = $constructor->getParameters();
        $dependencies = [];
        
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();
            if ($dependency) {
                $dependencies[] = $this->resolve($dependency->name);
            }
        }
        
        return $reflector->newInstanceArgs($dependencies);
    }
}

// Container setup
$container = new Container();
$container->singleton('Database', function() {
    return new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
});
$container->bind('ReptileRepositoryInterface', 'ReptileRepository');
$container->bind('BookingRepositoryInterface', 'BookingRepository');
```

---

## 14. SECURITY IMPLEMENTATION DETAILS

### 14.1 Advanced Authentication

#### 14.1.1 JWT Token Implementation
```php
class JWTManager {
    private $secretKey;
    private $algorithm = 'HS256';
    
    public function __construct($secretKey) {
        $this->secretKey = $secretKey;
    }
    
    public function generateToken($userId, $role, $expiresIn = 3600) {
        $payload = [
            'user_id' => $userId,
            'role' => $role,
            'iat' => time(),
            'exp' => time() + $expiresIn,
            'jti' => uniqid() // JWT ID for token revocation
        ];
        
        return $this->encode($payload);
    }
    
    public function validateToken($token) {
        try {
            $payload = $this->decode($token);
            
            // Check if token is expired
            if ($payload['exp'] < time()) {
                throw new TokenExpiredException('Token has expired');
            }
            
            // Check if token is revoked
            if ($this->isTokenRevoked($payload['jti'])) {
                throw new TokenRevokedException('Token has been revoked');
            }
            
            return $payload;
        } catch (Exception $e) {
            throw new InvalidTokenException('Invalid token: ' . $e->getMessage());
        }
    }
    
    public function revokeToken($jti) {
        // Store revoked token ID in database or cache
        $stmt = getDB()->prepare("INSERT INTO revoked_tokens (jti, revoked_at) VALUES (?, NOW())");
        return $stmt->execute([$jti]);
    }
    
    private function isTokenRevoked($jti) {
        $stmt = getDB()->prepare("SELECT 1 FROM revoked_tokens WHERE jti = ?");
        $stmt->execute([$jti]);
        return $stmt->fetch() !== false;
    }
}
```

#### 14.1.2 Rate Limiting
```php
class RateLimiter {
    private $redis;
    
    public function __construct($redis) {
        $this->redis = $redis;
    }
    
    public function isAllowed($identifier, $maxAttempts = 5, $timeWindow = 300) {
        $key = 'rate_limit:' . $identifier;
        $current = $this->redis->get($key);
        
        if ($current === null) {
            $this->redis->setex($key, $timeWindow, 1);
            return true;
        }
        
        if ($current >= $maxAttempts) {
            return false;
        }
        
        $this->redis->incr($key);
        return true;
    }
    
    public function getRemainingAttempts($identifier, $maxAttempts = 5) {
        $key = 'rate_limit:' . $identifier;
        $current = $this->redis->get($key) ?: 0;
        return max(0, $maxAttempts - $current);
    }
    
    public function reset($identifier) {
        $key = 'rate_limit:' . $identifier;
        $this->redis->del($key);
    }
}

// Usage in login
class AuthController {
    private $rateLimiter;
    
    public function login() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $email = $_POST['email'] ?? '';
        
        // Check rate limit by IP
        if (!$this->rateLimiter->isAllowed('login_ip:' . $ip, 10, 900)) {
            http_response_code(429);
            echo json_encode(['error' => 'Too many login attempts from this IP']);
            return;
        }
        
        // Check rate limit by email
        if (!$this->rateLimiter->isAllowed('login_email:' . $email, 5, 300)) {
            http_response_code(429);
            echo json_encode(['error' => 'Too many login attempts for this email']);
            return;
        }
        
        // Proceed with login logic
    }
}
```

### 14.2 Data Encryption

```php
class EncryptionService {
    private $key;
    private $cipher = 'AES-256-GCM';
    
    public function __construct($key) {
        $this->key = hash('sha256', $key, true);
    }
    
    public function encrypt($data) {
        $iv = random_bytes(16);
        $tag = '';
        
        $encrypted = openssl_encrypt(
            $data,
            $this->cipher,
            $this->key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );
        
        if ($encrypted === false) {
            throw new EncryptionException('Encryption failed');
        }
        
        return base64_encode($iv . $tag . $encrypted);
    }
    
    public function decrypt($encryptedData) {
        $data = base64_decode($encryptedData);
        
        if ($data === false || strlen($data) < 32) {
            throw new DecryptionException('Invalid encrypted data');
        }
        
        $iv = substr($data, 0, 16);
        $tag = substr($data, 16, 16);
        $encrypted = substr($data, 32);
        
        $decrypted = openssl_decrypt(
            $encrypted,
            $this->cipher,
            $this->key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );
        
        if ($decrypted === false) {
            throw new DecryptionException('Decryption failed');
        }
        
        return $decrypted;
    }
}
```

---

## 15. PERFORMANCE OPTIMIZATION

### 15.1 Database Optimization

#### 15.1.1 Query Optimization
```sql
-- Optimized queries with proper indexing

-- Index for user authentication
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_username ON users(username);

-- Composite index for booking queries
CREATE INDEX idx_bookings_user_status ON bookings(user_id, status);
CREATE INDEX idx_bookings_dates ON bookings(start_date, end_date);

-- Index for reptile searches
CREATE INDEX idx_reptiles_user_category ON reptiles(user_id, category_id);
CREATE INDEX idx_reptiles_species ON reptiles(species);

-- Full-text search index
CREATE FULLTEXT INDEX idx_reptiles_search ON reptiles(name, species, description);

-- Optimized booking availability query
SELECT COUNT(*) as conflict_count
FROM bookings 
WHERE reptile_id = ? 
  AND status IN ('confirmed', 'pending')
  AND (
    (start_date <= ? AND end_date >= ?) OR
    (start_date <= ? AND end_date >= ?) OR
    (start_date >= ? AND end_date <= ?)
  );
```

#### 15.1.2 Connection Pooling
```php
class ConnectionPool {
    private static $pool = [];
    private static $maxConnections = 10;
    private static $currentConnections = 0;
    
    public static function getConnection() {
        // Return existing connection from pool
        if (!empty(self::$pool)) {
            return array_pop(self::$pool);
        }
        
        // Create new connection if under limit
        if (self::$currentConnections < self::$maxConnections) {
            self::$currentConnections++;
            return new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false
                ]
            );
        }
        
        // Wait for available connection
        throw new ConnectionPoolException('Connection pool exhausted');
    }
    
    public static function releaseConnection($connection) {
        if (count(self::$pool) < self::$maxConnections) {
            self::$pool[] = $connection;
        }
    }
}
```

### 15.2 Caching Strategy

#### 15.2.1 Redis Cache Implementation
```php
class CacheManager {
    private $redis;
    private $defaultTTL = 3600; // 1 hour
    
    public function __construct() {
        $this->redis = new Redis();
        $this->redis->connect(REDIS_HOST, REDIS_PORT);
        if (REDIS_PASSWORD) {
            $this->redis->auth(REDIS_PASSWORD);
        }
    }
    
    public function get($key) {
        $data = $this->redis->get($key);
        return $data ? json_decode($data, true) : null;
    }
    
    public function set($key, $value, $ttl = null) {
        $ttl = $ttl ?: $this->defaultTTL;
        return $this->redis->setex($key, $ttl, json_encode($value));
    }
    
    public function delete($key) {
        return $this->redis->del($key);
    }
    
    public function flush() {
        return $this->redis->flushAll();
    }
    
    public function remember($key, $callback, $ttl = null) {
        $data = $this->get($key);
        
        if ($data === null) {
            $data = $callback();
            $this->set($key, $data, $ttl);
        }
        
        return $data;
    }
}

// Usage example
class ReptileService {
    private $cache;
    private $repository;
    
    public function getUserReptiles($userId) {
        $cacheKey = "user_reptiles:{$userId}";
        
        return $this->cache->remember($cacheKey, function() use ($userId) {
            return $this->repository->findByUserId($userId);
        }, 1800); // Cache for 30 minutes
    }
    
    public function invalidateUserCache($userId) {
        $this->cache->delete("user_reptiles:{$userId}");
    }
}
```

#### 15.2.2 Application-Level Caching
```php
class QueryCache {
    private static $cache = [];
    private static $maxSize = 100;
    
    public static function get($query, $params = []) {
        $key = md5($query . serialize($params));
        return self::$cache[$key] ?? null;
    }
    
    public static function set($query, $params, $result) {
        $key = md5($query . serialize($params));
        
        // Implement LRU eviction
        if (count(self::$cache) >= self::$maxSize) {
            array_shift(self::$cache);
        }
        
        self::$cache[$key] = $result;
    }
    
    public static function clear() {
        self::$cache = [];
    }
}

// Database class with query caching
class CachedDatabase extends Database {
    public function query($sql, $params = []) {
        // Check cache for SELECT queries
        if (stripos(trim($sql), 'SELECT') === 0) {
            $cached = QueryCache::get($sql, $params);
            if ($cached !== null) {
                return $cached;
            }
        }
        
        $result = parent::query($sql, $params);
        
        // Cache SELECT results
        if (stripos(trim($sql), 'SELECT') === 0) {
            QueryCache::set($sql, $params, $result);
        }
        
        return $result;
    }
}
```

### 15.3 Frontend Optimization

#### 15.3.1 Asset Optimization
```php
class AssetManager {
    private $assetsPath;
    private $publicPath;
    private $version;
    
    public function __construct($assetsPath, $publicPath) {
        $this->assetsPath = $assetsPath;
        $this->publicPath = $publicPath;
        $this->version = filemtime($assetsPath . '/manifest.json');
    }
    
    public function css($files) {
        if (ENVIRONMENT === 'production') {
            return $this->getMinifiedAsset($files, 'css');
        }
        
        $output = '';
        foreach ($files as $file) {
            $output .= '<link rel="stylesheet" href="' . $this->getAssetUrl($file) . '">' . "\n";
        }
        return $output;
    }
    
    public function js($files) {
        if (ENVIRONMENT === 'production') {
            return $this->getMinifiedAsset($files, 'js');
        }
        
        $output = '';
        foreach ($files as $file) {
            $output .= '<script src="' . $this->getAssetUrl($file) . '"></script>' . "\n";
        }
        return $output;
    }
    
    private function getMinifiedAsset($files, $type) {
        $hash = md5(implode('|', $files));
        $filename = $hash . '.' . $type;
        $filepath = $this->publicPath . '/dist/' . $filename;
        
        if (!file_exists($filepath)) {
            $this->createMinifiedFile($files, $filepath, $type);
        }
        
        $url = '/dist/' . $filename . '?v=' . $this->version;
        
        if ($type === 'css') {
            return '<link rel="stylesheet" href="' . $url . '">';
        } else {
            return '<script src="' . $url . '"></script>';
        }
    }
    
    private function createMinifiedFile($files, $outputPath, $type) {
        $content = '';
        
        foreach ($files as $file) {
            $filePath = $this->assetsPath . '/' . $file;
            if (file_exists($filePath)) {
                $content .= file_get_contents($filePath) . "\n";
            }
        }
        
        // Minify content
        if ($type === 'css') {
            $content = $this->minifyCSS($content);
        } else {
            $content = $this->minifyJS($content);
        }
        
        file_put_contents($outputPath, $content);
    }
    
    private function minifyCSS($css) {
        // Remove comments
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        // Remove whitespace
        $css = str_replace(["\r\n", "\r", "\n", "\t", '  ', '    ', '    '], '', $css);
        return $css;
    }
    
    private function minifyJS($js) {
        // Basic JS minification (consider using a proper minifier)
        $js = preg_replace('/\/\*[\s\S]*?\*\//', '', $js); // Remove comments
        $js = preg_replace('/\/\/.*$/', '', $js); // Remove single line comments
        $js = preg_replace('/\s+/', ' ', $js); // Compress whitespace
        return trim($js);
    }
}
```

---

## 16. MONITORING AND LOGGING

### 16.1 Application Monitoring

```php
class ApplicationMonitor {
    private $metrics = [];
    private $startTime;
    
    public function __construct() {
        $this->startTime = microtime(true);
    }
    
    public function startTimer($name) {
        $this->metrics[$name]['start'] = microtime(true);
    }
    
    public function endTimer($name) {
        if (isset($this->metrics[$name]['start'])) {
            $this->metrics[$name]['duration'] = microtime(true) - $this->metrics[$name]['start'];
        }
    }
    
    public function incrementCounter($name, $value = 1) {
        if (!isset($this->metrics[$name]['count'])) {
            $this->metrics[$name]['count'] = 0;
        }
        $this->metrics[$name]['count'] += $value;
    }
    
    public function recordMemoryUsage($name) {
        $this->metrics[$name]['memory'] = memory_get_usage(true);
        $this->metrics[$name]['peak_memory'] = memory_get_peak_usage(true);
    }
    
    public function getMetrics() {
        $this->metrics['total_execution_time'] = microtime(true) - $this->startTime;
        $this->metrics['final_memory_usage'] = memory_get_usage(true);
        return $this->metrics;
    }
    
    public function logMetrics() {
        $metrics = $this->getMetrics();
        error_log('METRICS: ' . json_encode($metrics));
        
        // Send to monitoring service
        $this->sendToMonitoringService($metrics);
    }
    
    private function sendToMonitoringService($metrics) {
        // Send metrics to external monitoring service
        // Example: New Relic, DataDog, etc.
    }
}

// Usage in application
$monitor = new ApplicationMonitor();

// Monitor database queries
$monitor->startTimer('database_query');
$result = $db->query($sql);
$monitor->endTimer('database_query');

// Monitor memory usage
$monitor->recordMemoryUsage('after_data_processing');

// Log metrics at end of request
register_shutdown_function(function() use ($monitor) {
    $monitor->logMetrics();
});
```

### 16.2 Structured Logging

```php
class Logger {
    private $logPath;
    private $context = [];
    
    public function __construct($logPath) {
        $this->logPath = $logPath;
    }
    
    public function setContext(array $context) {
        $this->context = array_merge($this->context, $context);
    }
    
    public function info($message, array $context = []) {
        $this->log('INFO', $message, $context);
    }
    
    public function warning($message, array $context = []) {
        $this->log('WARNING', $message, $context);
    }
    
    public function error($message, array $context = []) {
        $this->log('ERROR', $message, $context);
    }
    
    public function critical($message, array $context = []) {
        $this->log('CRITICAL', $message, $context);
        // Send immediate alert
        $this->sendAlert($message, $context);
    }
    
    private function log($level, $message, array $context = []) {
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'level' => $level,
            'message' => $message,
            'context' => array_merge($this->context, $context),
            'request_id' => $_SERVER['HTTP_X_REQUEST_ID'] ?? uniqid(),
            'user_id' => $_SESSION['user_id'] ?? null,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'memory_usage' => memory_get_usage(true),
            'execution_time' => microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']
        ];
        
        $logLine = json_encode($logEntry) . "\n";
        
        // Write to file
        file_put_contents(
            $this->logPath . '/' . date('Y-m-d') . '.log',
            $logLine,
            FILE_APPEND | LOCK_EX
        );
        
        // Send to centralized logging service
        $this->sendToLogService($logEntry);
    }
    
    private function sendToLogService($logEntry) {
        // Send to ELK stack, Splunk, or other log aggregation service
    }
    
    private function sendAlert($message, $context) {
        // Send critical alerts via email, Slack, etc.
    }
}

// Global logger instance
$logger = new Logger('/var/log/baroon-reptile');
$logger->setContext([
    'application' => 'baroon-reptile',
    'version' => '1.0.0',
    'environment' => ENVIRONMENT
]);
```

---

## 17. KESIMPULAN DAN REKOMENDASI

### 17.1 Kesimpulan

Dokumen SPPL ini memberikan panduan teknis komprehensif untuk implementasi Sistem Informasi Penitipan Reptil "Baroon Reptile" dengan fokus pada:

**Arsitektur yang Robust:**
- Implementasi design patterns yang proven (Repository, Service Layer, Factory)
- Dependency injection untuk loose coupling
- Modular architecture yang scalable dan maintainable
- Clean code principles dengan separation of concerns

**Keamanan yang Comprehensive:**
- Multi-layer security dengan authentication, authorization, dan encryption
- JWT token management dengan revocation capability
- Rate limiting untuk mencegah abuse
- Input validation dan output sanitization
- SQL injection dan XSS protection

**Performance yang Optimal:**
- Database optimization dengan proper indexing
- Multi-level caching strategy (Redis, application-level)
- Connection pooling untuk database efficiency
- Asset optimization dan minification
- Query optimization dan connection management

**Monitoring yang Proactive:**
- Comprehensive application monitoring
- Structured logging dengan context
- Performance metrics tracking
- Error tracking dan alerting
- Health check endpoints

### 17.2 Keunggulan Desain

**Maintainability:**
- Modular code structure dengan clear separation
- Comprehensive documentation dan code comments
- Consistent coding standards dan conventions
- Automated testing dengan high coverage
- Version control dengan proper branching strategy

**Scalability:**
- Horizontal scaling capability dengan load balancing
- Database sharding readiness
- Caching layers untuk performance
- Microservices-ready architecture
- Cloud deployment compatibility

**Security:**
- Defense in depth strategy
- Regular security audits dan penetration testing
- Compliance dengan security best practices
- Data encryption at rest dan in transit
- Comprehensive access control

**User Experience:**
- Responsive design untuk multi-device support
- Fast loading times dengan optimization
- Intuitive interface dengan user-centric design
- Accessibility compliance
- Progressive enhancement

### 17.3 Rekomendasi Implementasi

#### 17.3.1 Development Best Practices
**Code Quality:**
- Implement PSR-12 coding standards untuk PHP
- Use ESLint dan Prettier untuk JavaScript
- Mandatory code reviews untuk semua changes
- Automated testing dengan CI/CD pipeline
- Regular refactoring untuk code improvement

**Security Practices:**
- Regular dependency updates dan vulnerability scanning
- Implement security headers (HSTS, CSP, etc.)
- Regular penetration testing
- Security training untuk development team
- Incident response plan untuk security breaches

**Performance Practices:**
- Regular performance audits
- Database query optimization
- CDN implementation untuk static assets
- Image optimization dan lazy loading
- Progressive web app features

#### 17.3.2 Deployment Strategy
**Environment Management:**
- Separate environments untuk development, staging, production
- Infrastructure as Code dengan Docker/Kubernetes
- Automated deployment dengan CI/CD
- Blue-green deployment untuk zero downtime
- Database migration automation

**Monitoring dan Alerting:**
- Application Performance Monitoring (APM)
- Infrastructure monitoring dengan Prometheus/Grafana
- Log aggregation dengan ELK stack
- Real-time alerting dengan PagerDuty/Slack
- Regular health checks dan uptime monitoring

#### 17.3.3 Future Enhancements
**Short-term (3-6 months):**
- API development untuk mobile app
- Advanced reporting dengan data visualization
- Real-time notifications dengan WebSockets
- Payment gateway integration
- Multi-language support

**Medium-term (6-12 months):**
- Machine learning untuk predictive analytics
- IoT integration untuk facility monitoring
- Advanced search dengan Elasticsearch
- Microservices migration
- Mobile application development

**Long-term (1-2 years):**
- AI-powered customer service chatbot
- Blockchain integration untuk secure transactions
- AR/VR features untuk virtual facility tours
- Advanced automation dengan workflow engine
- Multi-tenant architecture untuk franchise support

### 17.4 Success Metrics

**Technical Metrics:**
- 99.9% uptime target
- <2 second page load times
- 80%+ code coverage
- <1% error rate
- 95%+ user satisfaction score

**Business Metrics:**
- 50% reduction dalam manual processing time
- 30% increase dalam customer retention
- 25% improvement dalam operational efficiency
- 40% reduction dalam support tickets
- 20% increase dalam revenue per customer

**Quality Metrics:**
- Zero critical security vulnerabilities
- <5 bugs per release
- 100% accessibility compliance
- <24 hour bug fix time untuk critical issues
- 95%+ test automation coverage

Sistem "Baroon Reptile" dengan implementasi sesuai SPPL ini akan menjadi platform yang robust, secure, dan scalable untuk mendukung operasional penginapan reptil modern dengan kemampuan untuk berkembang seiring dengan pertumbuhan bisnis dan evolusi teknologi.

---

**Dokumen ini disusun oleh Tim Pengembang Baroon Reptile**  
**Tanggal: Desember 2024**  
**Versi: 2.0**