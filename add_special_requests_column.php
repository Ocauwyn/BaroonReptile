<?php
require_once 'config/database.php';

try {
    $db = getDB();
    
    // Check if special_requests column already exists
    $stmt = $db->prepare("SHOW COLUMNS FROM bookings LIKE 'special_requests'");
    $stmt->execute();
    $column_exists = $stmt->fetch();
    
    if (!$column_exists) {
        // Add special_requests column to bookings table
        $sql = "ALTER TABLE bookings ADD COLUMN special_requests TEXT AFTER notes";
        $db->exec($sql);
        echo "<div style='color: green; padding: 10px; border: 1px solid green; margin: 10px 0;'>✅ special_requests column added to bookings table successfully!</div>";
    } else {
        echo "<div style='color: blue; padding: 10px; border: 1px solid blue; margin: 10px 0;'>ℹ️ special_requests column already exists in bookings table.</div>";
    }
    
    // Show current table structure
    echo "<h3>Current bookings table structure:</h3>";
    $stmt = $db->prepare("DESCRIBE bookings");
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th style='padding: 8px;'>Field</th><th style='padding: 8px;'>Type</th><th style='padding: 8px;'>Null</th><th style='padding: 8px;'>Key</th><th style='padding: 8px;'>Default</th></tr>";
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td style='padding:8px;'>" . $column['Field'] . "</td>";
        echo "<td style='padding:8px;'>" . $column['Type'] . "</td>";
        echo "<td style='padding:8px;'>" . $column['Null'] . "</td>";
        echo "<td style='padding:8px;'>" . $column['Key'] . "</td>";
        echo "<td style='padding:8px;'>" . $column['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<br><a href='admin/dashboard.php' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Go to Admin Dashboard</a>";
    echo "<br><br><a href='customer/dashboard.php' style='padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;'>Go to Customer Dashboard</a>";
    
} catch (Exception $e) {
    echo "<div style='color: red; padding: 10px; border: 1px solid red; margin: 10px 0;'>❌ Error: " . $e->getMessage() . "</div>";
}
?>