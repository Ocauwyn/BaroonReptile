<?php
require_once 'config/database.php';

echo "<h2>Creating care_reports table...</h2>";

try {
    $db = getDB();
    
    if (!$db) {
        throw new Exception('Database connection failed');
    }
    
    // Create care_reports table
    $sql = "
        CREATE TABLE IF NOT EXISTS care_reports (
            id INT AUTO_INCREMENT PRIMARY KEY,
            reptile_id INT NOT NULL,
            booking_id INT NOT NULL,
            report_date DATE NOT NULL,
            health_status ENUM('excellent', 'good', 'fair', 'poor') DEFAULT 'good',
            food_given TEXT,
            notes TEXT,
            staff_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (reptile_id) REFERENCES reptiles(id) ON DELETE CASCADE,
            FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
            FOREIGN KEY (staff_id) REFERENCES users(id)
        )
    ";
    
    $db->exec($sql);
    echo "<div style='color: green; padding: 10px; border: 1px solid green; margin: 10px 0;'>✅ Table 'care_reports' created successfully!</div>";
    
    // Check if table exists and show structure
    $stmt = $db->query("DESCRIBE care_reports");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Table Structure:</h3>";
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th style='padding: 8px;'>Field</th><th style='padding: 8px;'>Type</th><th style='padding: 8px;'>Null</th><th style='padding: 8px;'>Key</th></tr>";
    foreach ($columns as $col) {
        echo "<tr><td style='padding:8px;'>{$col['Field']}</td><td style='padding:8px;'>{$col['Type']}</td><td style='padding:8px;'>{$col['Null']}</td><td style='padding:8px;'>{$col['Key']}</td></tr>";
    }
    echo "</table>";
    
    // Insert sample data for testing
    echo "<h3>Inserting sample data...</h3>";
    
    // First, check if we have any bookings to create reports for
    $stmt = $db->query("SELECT b.id, b.reptile_id FROM bookings b WHERE b.status IN ('confirmed', 'in_progress', 'completed') LIMIT 1");
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($booking) {
        // Get admin user ID
        $stmt = $db->query("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($admin) {
            $insert_sql = "
                INSERT IGNORE INTO care_reports (reptile_id, booking_id, report_date, health_status, food_given, notes, staff_id) VALUES 
                (?, ?, CURDATE(), 'good', 'Crickets and vegetables', 'Reptile is healthy and active. Eating well.', ?),
                (?, ?, DATE_SUB(CURDATE(), INTERVAL 1 DAY), 'excellent', 'Mice and water', 'Excellent condition. Very active today.', ?)
            ";
            
            $stmt = $db->prepare($insert_sql);
            $stmt->execute([
                $booking['reptile_id'], $booking['id'], $admin['id'],
                $booking['reptile_id'], $booking['id'], $admin['id']
            ]);
            
            echo "<div style='color: blue; padding: 10px; border: 1px solid blue; margin: 10px 0;'>📝 Sample care reports inserted successfully!</div>";
        } else {
            echo "<div style='color: orange; padding: 10px; border: 1px solid orange; margin: 10px 0;'>⚠️ No admin user found for sample data.</div>";
        }
    } else {
        echo "<div style='color: orange; padding: 10px; border: 1px solid orange; margin: 10px 0;'>⚠️ No active bookings found for sample data.</div>";
    }
    
    // Count records
    $count_stmt = $db->query("SELECT COUNT(*) as total FROM care_reports");
    $total = $count_stmt->fetch()['total'];
    echo "<div style='color: green; padding: 10px; margin: 10px 0;'>📊 Total care reports: $total</div>";
    
} catch (Exception $e) {
    echo "<div style='color: red; padding: 10px; border: 1px solid red; margin: 10px 0;'>❌ Error: " . $e->getMessage() . "</div>";
    echo "<div style='color: red; padding: 10px; margin: 10px 0;'>Stack trace: " . $e->getTraceAsString() . "</div>";
}

echo "<br><a href='admin/dashboard.php' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Go to Admin Dashboard</a>";
echo "<br><br><a href='customer/dashboard.php' style='padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;'>Go to Customer Dashboard</a>";
?>