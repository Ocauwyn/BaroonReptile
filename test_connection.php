<?php
echo "<h1>Test Database Connection</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;background:#e8f5e8;padding:10px;border-radius:5px;margin:10px 0;} .error{color:red;background:#ffe8e8;padding:10px;border-radius:5px;margin:10px 0;} .info{color:blue;background:#e8f0ff;padding:10px;border-radius:5px;margin:10px 0;}</style>";

try {
    // Test database connection
    $host = 'localhost';
    $dbname = 'baroon_reptile';
    $username = 'root';
    $password = '';
    
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    echo "<div class='success'>✅ Database connection successful!</div>";
    
    // Check if daily_business_reports table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'daily_business_reports'");
    if ($stmt->rowCount() > 0) {
        echo "<div class='success'>✅ Table 'daily_business_reports' exists</div>";
        
        // Count records
        $count_stmt = $pdo->query("SELECT COUNT(*) as total FROM daily_business_reports");
        $total = $count_stmt->fetch()['total'];
        echo "<div class='info'>📊 Total records in table: $total</div>";
        
        // Show sample data
        $sample_stmt = $pdo->query("SELECT * FROM daily_business_reports ORDER BY report_date DESC LIMIT 3");
        $samples = $sample_stmt->fetchAll();
        
        if (count($samples) > 0) {
            echo "<div class='info'>📋 Sample records:</div>";
            echo "<table border='1' style='border-collapse:collapse;width:100%;margin:10px 0;'><tr style='background:#f0f0f0;'><th style='padding:8px;'>Date</th><th style='padding:8px;'>Bookings</th><th style='padding:8px;'>Revenue</th><th style='padding:8px;'>Active Reptiles</th></tr>";
            foreach ($samples as $row) {
                echo "<tr><td style='padding:8px;'>{$row['report_date']}</td><td style='padding:8px;'>{$row['total_bookings']}</td><td style='padding:8px;'>Rp " . number_format($row['total_revenue'], 0, ',', '.') . "</td><td style='padding:8px;'>{$row['active_reptiles']}</td></tr>";
            }
            echo "</table>";
        }
        
    } else {
        echo "<div class='error'>❌ Table 'daily_business_reports' does not exist!</div>";
        echo "<p><a href='fix_database.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Run Database Fix</a></p>";
    }
    
    // Test the exact query from reports.php
    echo "<div class='info'>🧪 Testing reports.php query...</div>";
    $test_query = "SELECT r.*, DATE_FORMAT(r.report_date, '%d/%m/%Y') as formatted_date FROM daily_business_reports r ORDER BY r.report_date DESC LIMIT 5";
    $test_stmt = $pdo->query($test_query);
    $test_results = $test_stmt->fetchAll();
    echo "<div class='success'>✅ Query test successful - Found " . count($test_results) . " records</div>";
    
    echo "<p style='margin-top:20px;'><a href='admin/reports.php' style='background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Go to Reports Page</a></p>";
    
} catch (PDOException $e) {
    echo "<div class='error'>❌ Database Error: " . $e->getMessage() . "</div>";
    echo "<div class='error'>Error Code: " . $e->getCode() . "</div>";
} catch (Exception $e) {
    echo "<div class='error'>❌ General Error: " . $e->getMessage() . "</div>";
}
?>