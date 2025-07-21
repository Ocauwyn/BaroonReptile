<?php
require_once 'config/database.php';

try {
    // Create daily_business_reports table
    $sql = "
    CREATE TABLE IF NOT EXISTS daily_business_reports (
        id INT AUTO_INCREMENT PRIMARY KEY,
        report_date DATE NOT NULL UNIQUE,
        total_bookings INT DEFAULT 0,
        total_revenue DECIMAL(10,2) DEFAULT 0.00,
        active_reptiles INT DEFAULT 0,
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "<h2>Tabel daily_business_reports berhasil dibuat!</h2>";
    
    // Insert sample data
    $insert_sql = "
    INSERT IGNORE INTO daily_business_reports (report_date, total_bookings, total_revenue, active_reptiles, notes) VALUES
    ('2025-01-15', 5, 750000.00, 12, 'Hari normal dengan booking stabil'),
    ('2025-01-16', 8, 1200000.00, 15, 'Hari sibuk dengan banyak booking'),
    ('2025-01-17', 3, 450000.00, 10, 'Hari sepi karena hujan'),
    ('2025-01-18', 6, 900000.00, 13, 'Weekend dengan aktivitas tinggi'),
    ('2025-01-19', 7, 1050000.00, 14, 'Minggu dengan performa baik')";
    
    $pdo->exec($insert_sql);
    echo "<h3>Sample data berhasil ditambahkan!</h3>";
    
    // Verify table creation
    $check_sql = "SELECT COUNT(*) as count FROM daily_business_reports";
    $stmt = $pdo->query($check_sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<p>Jumlah record dalam tabel: " . $result['count'] . "</p>";
    
    echo "<p><a href='admin/reports.php'>Kembali ke Reports</a></p>";
    
} catch (PDOException $e) {
    echo "<h2>Error: " . $e->getMessage() . "</h2>";
}
?>