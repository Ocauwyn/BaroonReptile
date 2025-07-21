<?php
require_once 'config/database.php';

echo "<h1>🔍 Diagnose Admin Reports Issues</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;background:#e8f5e8;padding:10px;border-radius:5px;margin:10px 0;} .error{color:red;background:#ffe8e8;padding:10px;border-radius:5px;margin:10px 0;} .info{color:blue;background:#e8f0ff;padding:10px;border-radius:5px;margin:10px 0;} .warning{color:orange;background:#fff3cd;padding:10px;border-radius:5px;margin:10px 0;}</style>";

try {
    $db = getDB();
    echo "<div class='success'>✅ Database connection successful!</div>";
    
    // Check if daily_business_reports table exists
    $stmt = $db->query("SHOW TABLES LIKE 'daily_business_reports'");
    if ($stmt->rowCount() > 0) {
        echo "<div class='success'>✅ Table 'daily_business_reports' exists</div>";
        
        // Check table structure
        $stmt = $db->query("DESCRIBE daily_business_reports");
        $columns = $stmt->fetchAll();
        echo "<div class='info'>📋 Table structure:</div>";
        echo "<table border='1' style='border-collapse:collapse;margin:10px 0;'>";
        echo "<tr style='background:#f0f0f0;'><th style='padding:8px;'>Field</th><th style='padding:8px;'>Type</th><th style='padding:8px;'>Null</th><th style='padding:8px;'>Key</th></tr>";
        foreach ($columns as $col) {
            echo "<tr><td style='padding:8px;'>{$col['Field']}</td><td style='padding:8px;'>{$col['Type']}</td><td style='padding:8px;'>{$col['Null']}</td><td style='padding:8px;'>{$col['Key']}</td></tr>";
        }
        echo "</table>";
        
        // Count records
        $count_stmt = $db->query("SELECT COUNT(*) as total FROM daily_business_reports");
        $total = $count_stmt->fetch()['total'];
        echo "<div class='info'>📊 Total records: $total</div>";
        
    } else {
        echo "<div class='error'>❌ Table 'daily_business_reports' does not exist!</div>";
        echo "<div class='warning'>Creating table now...</div>";
        
        // Create the table
        $create_sql = "
            CREATE TABLE daily_business_reports (
                id INT AUTO_INCREMENT PRIMARY KEY,
                report_date DATE NOT NULL UNIQUE,
                total_bookings INT DEFAULT 0,
                total_revenue DECIMAL(15,2) DEFAULT 0.00,
                active_reptiles INT DEFAULT 0,
                notes TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";
        
        if ($db->exec($create_sql)) {
            echo "<div class='success'>✅ Table 'daily_business_reports' created successfully!</div>";
        } else {
            echo "<div class='error'>❌ Failed to create table!</div>";
        }
    }
    
    // Check other required tables
    $required_tables = ['bookings', 'payments', 'reptiles', 'users'];
    foreach ($required_tables as $table) {
        $stmt = $db->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "<div class='success'>✅ Table '$table' exists</div>";
            
            // Count records
            $count_stmt = $db->query("SELECT COUNT(*) as total FROM $table");
            $total = $count_stmt->fetch()['total'];
            echo "<div class='info'>📊 Records in '$table': $total</div>";
        } else {
            echo "<div class='error'>❌ Table '$table' missing!</div>";
        }
    }
    
    // Test specific queries from reports.php
    echo "<div class='info'>🧪 Testing reports.php queries...</div>";
    
    // Test today's bookings query
    $today = date('Y-m-d');
    try {
        $stmt = $db->prepare("SELECT COUNT(*) as today_bookings FROM bookings WHERE DATE(created_at) = ?");
        $stmt->execute([$today]);
        $today_bookings = $stmt->fetchColumn();
        echo "<div class='success'>✅ Today's bookings query: $today_bookings bookings</div>";
    } catch (Exception $e) {
        echo "<div class='error'>❌ Today's bookings query failed: " . $e->getMessage() . "</div>";
    }
    
    // Test today's revenue query
    try {
        $stmt = $db->prepare("SELECT COALESCE(SUM(amount), 0) as today_revenue FROM payments WHERE DATE(created_at) = ? AND payment_status = 'paid'");
        $stmt->execute([$today]);
        $today_revenue = $stmt->fetchColumn();
        echo "<div class='success'>✅ Today's revenue query: Rp " . number_format($today_revenue, 0, ',', '.') . "</div>";
    } catch (Exception $e) {
        echo "<div class='error'>❌ Today's revenue query failed: " . $e->getMessage() . "</div>";
    }
    
    // Test active reptiles query
    try {
        $stmt = $db->query("SELECT COUNT(*) as active_reptiles FROM reptiles WHERE status = 'active'");
        $active_reptiles = $stmt->fetchColumn();
        echo "<div class='success'>✅ Active reptiles query: $active_reptiles reptiles</div>";
    } catch (Exception $e) {
        echo "<div class='error'>❌ Active reptiles query failed: " . $e->getMessage() . "</div>";
    }
    
    // Test summary statistics query
    try {
        $stmt = $db->query("
            SELECT 
                COUNT(*) as total_reports,
                SUM(total_bookings) as total_bookings_sum,
                SUM(total_revenue) as total_revenue_sum,
                AVG(total_revenue) as avg_daily_revenue,
                AVG(total_bookings) as avg_daily_bookings,
                MAX(total_revenue) as max_daily_revenue,
                MIN(total_revenue) as min_daily_revenue
            FROM daily_business_reports
            WHERE MONTH(report_date) = MONTH(CURDATE()) AND YEAR(report_date) = YEAR(CURDATE())
        ");
        $summary = $stmt->fetch();
        echo "<div class='success'>✅ Summary statistics query successful</div>";
        echo "<div class='info'>📊 This month: {$summary['total_reports']} reports, Rp " . number_format($summary['total_revenue_sum'], 0, ',', '.') . " total revenue</div>";
    } catch (Exception $e) {
        echo "<div class='error'>❌ Summary statistics query failed: " . $e->getMessage() . "</div>";
    }
    
    // Test monthly comparison query
    try {
        $stmt = $db->query("
            SELECT 
                MONTH(report_date) as month,
                YEAR(report_date) as year,
                SUM(total_revenue) as monthly_revenue,
                SUM(total_bookings) as monthly_bookings,
                COUNT(*) as report_days
            FROM daily_business_reports
            WHERE report_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
            GROUP BY YEAR(report_date), MONTH(report_date)
            ORDER BY year DESC, month DESC
            LIMIT 6
        ");
        $monthly_data = $stmt->fetchAll();
        echo "<div class='success'>✅ Monthly comparison query: " . count($monthly_data) . " months of data</div>";
    } catch (Exception $e) {
        echo "<div class='error'>❌ Monthly comparison query failed: " . $e->getMessage() . "</div>";
    }
    
    echo "<div class='info'>🎯 All diagnostic tests completed!</div>";
    echo "<p style='margin-top:20px;'><a href='admin/reports.php' style='background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Test Reports Page</a></p>";
    
} catch (Exception $e) {
    echo "<div class='error'>❌ Critical Error: " . $e->getMessage() . "</div>";
    echo "<div class='error'>Error Code: " . $e->getCode() . "</div>";
    echo "<div class='error'>File: " . $e->getFile() . " Line: " . $e->getLine() . "</div>";
}
?>