<?php
require_once 'config/database.php';

try {
    $db = getDB();
    
    if ($db) {
        echo "<h2>Database Connection: SUCCESS</h2>";
        
        // Test query untuk melihat tabel yang ada
        $stmt = $db->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo "<h3>Available Tables:</h3>";
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>$table</li>";
        }
        echo "</ul>";
        
        // Test query untuk booking statistics
        echo "<h3>Booking Statistics Test:</h3>";
        $stmt = $db->query("
            SELECT 
                MONTH(created_at) as month,
                YEAR(created_at) as year,
                COUNT(*) as count
            FROM bookings 
            WHERE created_at >= DATE_SUB(CURRENT_DATE(), INTERVAL 12 MONTH)
            GROUP BY YEAR(created_at), MONTH(created_at)
            ORDER BY year, month
        ");
        $booking_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>" . print_r($booking_stats, true) . "</pre>";
        
        // Test query untuk category statistics
        echo "<h3>Category Statistics Test:</h3>";
        $stmt = $db->query("
            SELECT 
                rc.name as category_name,
                COUNT(r.id) as count
            FROM reptile_categories rc
            LEFT JOIN reptiles r ON rc.id = r.category_id AND r.status = 'active'
            WHERE rc.status = 'active'
            GROUP BY rc.id, rc.name
            ORDER BY count DESC
        ");
        $category_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>" . print_r($category_stats, true) . "</pre>";
        
    } else {
        echo "<h2>Database Connection: FAILED</h2>";
    }
    
} catch (Exception $e) {
    echo "<h2>Error: " . $e->getMessage() . "</h2>";
}
?>