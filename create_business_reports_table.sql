-- Create daily_business_reports table for admin reports functionality

USE baroon_reptile;

-- Tabel Laporan Bisnis Harian
CREATE TABLE IF NOT EXISTS daily_business_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    report_date DATE NOT NULL UNIQUE,
    total_bookings INT NOT NULL DEFAULT 0,
    total_revenue DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    active_reptiles INT NOT NULL DEFAULT 0,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data for testing
INSERT IGNORE INTO daily_business_reports (report_date, total_bookings, total_revenue, active_reptiles, notes) VALUES
(CURDATE(), 1, 50000.00, 1, 'Sample daily report for today'),
(DATE_SUB(CURDATE(), INTERVAL 1 DAY), 2, 85000.00, 2, 'Sample report for yesterday'),
(DATE_SUB(CURDATE(), INTERVAL 2 DAY), 0, 0.00, 1, 'No bookings on this day');

SELECT 'daily_business_reports table created successfully!' as status;