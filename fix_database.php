<?php
echo "<h1>Database Fix Script - Final Solution</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;background:#f5f5f5;} .container{background:white;padding:20px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.1);} .success{color:#28a745;background:#d4edda;padding:8px;border-radius:4px;margin:5px 0;} .error{color:#dc3545;background:#f8d7da;padding:8px;border-radius:4px;margin:5px 0;} .info{color:#0c5460;background:#d1ecf1;padding:8px;border-radius:4px;margin:5px 0;} .btn{background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;display:inline-block;margin:10px 5px 0 0;}</style>";
echo "<div class='container'>";

try {
    // Database connection parameters
    $host = 'localhost';
    $dbname = 'baroon_reptile';
    $username = 'root';
    $password = '';
    
    echo "<div class='info'>🔄 Connecting to database: $dbname@$host</div>";
    
    // Create PDO connection
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);
    
    echo "<div class='success'>✅ Database connection successful!</div>";
    
    // Check current database
    $stmt = $pdo->query("SELECT DATABASE() as current_db");
    $current_db = $stmt->fetch()['current_db'];
    echo "<div class='info'>📊 Current database: $current_db</div>";
    
    // Drop table if exists
    echo "<div class='info'>🗑️ Dropping existing table (if exists)...</div>";
    $pdo->exec("DROP TABLE IF EXISTS daily_business_reports");
    echo "<div class='success'>✅ Table dropped successfully</div>";
    
    // Create table with explicit database name
    echo "<div class='info'>🔨 Creating daily_business_reports table...</div>";
    $create_sql = "
    CREATE TABLE `baroon_reptile`.`daily_business_reports` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `report_date` DATE NOT NULL,
        `total_bookings` INT NOT NULL DEFAULT 0,
        `total_revenue` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
        `active_reptiles` INT NOT NULL DEFAULT 0,
        `notes` TEXT NULL,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE INDEX `report_date_UNIQUE` (`report_date` ASC)
    ) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci";
    
    $pdo->exec($create_sql);
    echo "<div class='success'>✅ Table daily_business_reports created successfully!</div>";
    
    // Insert sample data
    echo "<div class='info'>📝 Inserting sample data...</div>";
    $insert_sql = "
    INSERT INTO `baroon_reptile`.`daily_business_reports` 
    (`report_date`, `total_bookings`, `total_revenue`, `active_reptiles`, `notes`) VALUES
    ('2025-01-15', 5, 750000.00, 12, 'Hari normal dengan booking stabil'),
    ('2025-01-16', 8, 1200000.00, 15, 'Hari sibuk dengan banyak booking'),
    ('2025-01-17', 3, 450000.00, 10, 'Hari sepi karena hujan'),
    ('2025-01-18', 6, 900000.00, 13, 'Weekend dengan aktivitas tinggi'),
    ('2025-01-19', 7, 1050000.00, 14, 'Minggu dengan performa baik'),
    ('2025-01-20', 4, 600000.00, 11, 'Hari kerja biasa')";
    
    $pdo->exec($insert_sql);
    echo "<div class='success'>✅ Sample data inserted successfully!</div>";
    
    // Verify table creation and data
    echo "<div class='info'>🔍 Verifying table and data...</div>";
    
    // Check table exists
    $check_table = $pdo->query("SHOW TABLES LIKE 'daily_business_reports'");
    if ($check_table->rowCount() > 0) {
        echo "<div class='success'>✅ Table exists in database</div>";
    } else {
        echo "<div class='error'>❌ Table not found!</div>";
    }
    
    // Count records
    $count_stmt = $pdo->query("SELECT COUNT(*) as total FROM daily_business_reports");
    $total_records = $count_stmt->fetch()['total'];
    echo "<div class='success'>✅ Total records: $total_records</div>";
    
    // Show sample data
    $sample_stmt = $pdo->query("SELECT * FROM daily_business_reports ORDER BY report_date DESC LIMIT 3");
    $samples = $sample_stmt->fetchAll();
    
    echo "<h3>📋 Sample Records:</h3>";
    echo "<table border='1' style='border-collapse:collapse;width:100%;'><tr style='background:#e9ecef;'><th style='padding:8px;'>Date</th><th style='padding:8px;'>Bookings</th><th style='padding:8px;'>Revenue</th><th style='padding:8px;'>Active Reptiles</th><th style='padding:8px;'>Notes</th></tr>";
    foreach ($samples as $row) {
        echo "<tr><td style='padding:8px;'>{$row['report_date']}</td><td style='padding:8px;'>{$row['total_bookings']}</td><td style='padding:8px;'>Rp " . number_format($row['total_revenue'], 0, ',', '.') . "</td><td style='padding:8px;'>{$row['active_reptiles']}</td><td style='padding:8px;'>{$row['notes']}</td></tr>";
    }
    echo "</table>";
    
    // Test the exact query used in reports.php
    echo "<div class='info'>🧪 Testing reports.php queries...</div>";
    $test_query = "SELECT r.*, DATE_FORMAT(r.report_date, '%d/%m/%Y') as formatted_date FROM daily_business_reports r ORDER BY r.report_date DESC LIMIT 5";
    $test_stmt = $pdo->query($test_query);
    $test_results = $test_stmt->fetchAll();
    echo "<div class='success'>✅ Query test successful - Found " . count($test_results) . " records</div>";
    
    echo "<h2 style='color:#28a745;'>🎉 Database Fix Completed Successfully!</h2>";
    echo "<p>The daily_business_reports table has been created and populated with sample data.</p>";
    echo "<a href='admin/reports.php' class='btn'>🔗 Test Reports Page</a>";
    echo "<a href='admin/dashboard.php' class='btn' style='background:#28a745;'>🏠 Go to Dashboard</a>";
    
} catch (PDOException $e) {
    echo "<div class='error'>❌ Database Error: " . $e->getMessage() . "</div>";
    echo "<h3>🔧 Error Details:</h3>";
    echo "<ul>";
    echo "<li><strong>Error Code:</strong> " . $e->getCode() . "</li>";
    echo "<li><strong>SQL State:</strong> " . (isset($e->errorInfo[0]) ? $e->errorInfo[0] : 'N/A') . "</li>";
    echo "<li><strong>Driver Error:</strong> " . (isset($e->errorInfo[1]) ? $e->errorInfo[1] : 'N/A') . "</li>";
    echo "<li><strong>Error Message:</strong> " . (isset($e->errorInfo[2]) ? $e->errorInfo[2] : $e->getMessage()) . "</li>";
    echo "</ul>";
    
    echo "<h3>💡 Troubleshooting Steps:</h3>";
    echo "<ol>";
    echo "<li>Make sure XAMPP MySQL service is running</li>";
    echo "<li>Check if database 'baroon_reptile' exists</li>";
    echo "<li>Verify database credentials in config/database.php</li>";
    echo "<li>Try accessing phpMyAdmin to check database status</li>";
    echo "</ol>";
} catch (Exception $e) {
    echo "<div class='error'>❌ General Error: " . $e->getMessage() . "</div>";
}

echo "</div>";
?>