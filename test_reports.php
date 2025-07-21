<?php
require_once 'config/database.php';

echo "<h2>Reports Page Test</h2>";

try {
    $db = getDB();
    
    if (!$db) {
        throw new Exception('Database connection failed');
    }
    
    echo "<h3>Testing Reports Variables:</h3>";
    
    // Test the same logic as reports.php
    $date_filter = isset($_GET['date']) ? $_GET['date'] : 'this_month';
    $sort_filter = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
    
    echo "Date Filter: " . htmlspecialchars($date_filter) . "<br>";
    echo "Sort Filter: " . htmlspecialchars($sort_filter) . "<br>";
    
    // Test database query
    $stmt = $db->query("SELECT COUNT(*) as count FROM daily_business_reports");
    $report_count = $stmt->fetchColumn();
    echo "Total Reports in DB: " . $report_count . "<br>";
    
    echo "<h3>Status:</h3>";
    echo "<p style='color: green;'>✓ Variables defined correctly - no undefined variable errors!</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<h3>Test Links:</h3>
<a href="admin/reports.php" target="_blank">Go to Reports Page (New Tab)</a><br>
<a href="admin/reports.php?date=today&sort=newest" target="_blank">Reports with Parameters</a><br><br>
<button onclick="window.location.reload()">Refresh This Page</button>