-- Database: baroon_reptile
-- Sistem Penitipan Hewan Reptile

CREATE DATABASE IF NOT EXISTS baroon_reptile;
USE baroon_reptile;

-- Tabel Users (Admin dan Customer)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role ENUM('admin', 'customer') DEFAULT 'customer',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Kategori Reptile
CREATE TABLE reptile_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    price_per_day DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Reptile yang dititipkan
CREATE TABLE reptiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    category_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    species VARCHAR(100),
    age VARCHAR(20),
    weight DECIMAL(5,2),
    length DECIMAL(5,2),
    gender ENUM('male', 'female', 'unknown'),
    special_needs TEXT,
    photo VARCHAR(255),
    status ENUM('active', 'completed', 'cancelled') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES reptile_categories(id)
);

-- Tabel Booking/Penitipan
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    reptile_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_days INT NOT NULL,
    price_per_day DECIMAL(10,2) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'confirmed', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reptile_id) REFERENCES reptiles(id) ON DELETE CASCADE
);

-- Tabel Pembayaran
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('cash', 'transfer', 'credit_card') NOT NULL,
    payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending',
    payment_date TIMESTAMP NULL,
    proof_image VARCHAR(255),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
);

-- Tabel Laporan Harian Perawatan
CREATE TABLE daily_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reptile_id INT NOT NULL,
    booking_id INT NOT NULL,
    report_date DATE NOT NULL,
    feeding_time TIME,
    feeding_notes TEXT,
    health_status ENUM('excellent', 'good', 'fair', 'poor') DEFAULT 'good',
    activity_level ENUM('very_active', 'active', 'normal', 'low', 'inactive') DEFAULT 'normal',
    temperature DECIMAL(4,1),
    humidity DECIMAL(4,1),
    notes TEXT,
    photos VARCHAR(500),
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reptile_id) REFERENCES reptiles(id) ON DELETE CASCADE,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Tabel Fasilitas
CREATE TABLE facilities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    capacity INT DEFAULT 1,
    price_per_day DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    status ENUM('available', 'occupied', 'maintenance') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Testimoni
CREATE TABLE testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert data default
-- Password untuk admin: admin123
-- Password untuk customer1: customer123
INSERT INTO users (username, email, password, full_name, phone, role) VALUES
('admin', 'admin@baroonreptile.com', '$2y$10$8K1p/wgyQ1uIiWi3jqjrNOKKre/32D0.LKe.JEBWxibfkVaAJmeO6', 'Administrator', '081234567890', 'admin'),
('customer1', 'customer@example.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 'John Doe', '081234567891', 'customer');

INSERT INTO reptile_categories (name, description, price_per_day) VALUES
('Ular Kecil', 'Ular dengan panjang kurang dari 1 meter', 25000.00),
('Ular Sedang', 'Ular dengan panjang 1-2 meter', 35000.00),
('Ular Besar', 'Ular dengan panjang lebih dari 2 meter', 50000.00),
('Kadal Kecil', 'Gecko, tokek, dan kadal kecil lainnya', 20000.00),
('Kadal Sedang', 'Iguana, bearded dragon, monitor kecil', 40000.00),
('Kadal Besar', 'Monitor besar, iguana dewasa', 60000.00),
('Kura-kura Darat', 'Kura-kura darat berbagai ukuran', 30000.00),
('Kura-kura Air', 'Kura-kura air dan semi-aquatic', 35000.00);

INSERT INTO facilities (name, description, capacity, price_per_day) VALUES
('Terrarium Kecil A1', 'Terrarium 60x40x40cm untuk reptile kecil', 1, 25000.00),
('Terrarium Kecil A2', 'Terrarium 60x40x40cm untuk reptile kecil', 1, 25000.00),
('Terrarium Sedang B1', 'Terrarium 100x50x50cm untuk reptile sedang', 1, 35000.00),
('Terrarium Sedang B2', 'Terrarium 100x50x50cm untuk reptile sedang', 1, 35000.00),
('Terrarium Besar C1', 'Terrarium 150x80x80cm untuk reptile besar', 1, 50000.00),
('Aquarium Kura-kura D1', 'Aquarium 100x50x40cm untuk kura-kura air', 1, 30000.00),
('Kandang Outdoor E1', 'Kandang outdoor untuk kura-kura darat', 2, 40000.00);