-- Script untuk membuat tabel daily_business_reports
-- Jalankan dengan: mysql -u root -p baroon_reptile < create_table.sql

USE baroon_reptile;

-- Drop table jika sudah ada (untuk memastikan clean install)
DROP TABLE IF EXISTS daily_business_reports;

-- Buat tabel daily_business_reports
CREATE TABLE daily_business_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    report_date DATE NOT NULL UNIQUE,
    total_bookings INT DEFAULT 0,
    total_revenue DECIMAL(10,2) DEFAULT 0.00,
    active_reptiles INT DEFAULT 0,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data
INSERT INTO daily_business_reports (report_date, total_bookings, total_revenue, active_reptiles, notes) VALUES
('2025-01-15', 5, 750000.00, 12, 'Hari normal dengan booking stabil'),
('2025-01-16', 8, 1200000.00, 15, 'Hari sibuk dengan banyak booking'),
('2025-01-17', 3, 450000.00, 10, 'Hari sepi karena hujan'),
('2025-01-18', 6, 900000.00, 13, 'Weekend dengan aktivitas tinggi'),
('2025-01-19', 7, 1050000.00, 14, 'Minggu dengan performa baik'),
('2025-01-20', 4, 600000.00, 11, 'Hari kerja biasa');

-- Verifikasi tabel dibuat
SELECT 'Table created successfully' as status;
SELECT COUNT(*) as total_records FROM daily_business_reports;
SELECT * FROM daily_business_reports ORDER BY report_date DESC LIMIT 3;