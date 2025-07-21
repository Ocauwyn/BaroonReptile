<?php
require_once 'config/database.php';

echo "<h2>Category Data Test - Fixed Query</h2>";

try {
    $db = getDB();
    
    if (!$db) {
        throw new Exception('Database connection failed');
    }
    
    // Test the FIXED query from dashboard (without WHERE rc.status = 'active')
    echo "<h3>Fixed Dashboard Category Query:</h3>";
    $stmt = $db->query("
        SELECT 
            rc.name as category_name,
            COUNT(r.id) as count
        FROM reptile_categories rc
        LEFT JOIN reptiles r ON rc.id = r.category_id AND r.status = 'active'
        GROUP BY rc.id, rc.name
        ORDER BY count DESC
    ");
    $category_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>" . print_r($category_stats, true) . "</pre>";
    
    // Prepare category data for chart (same as dashboard)
    $category_labels = [];
    $category_data = [];
    foreach ($category_stats as $stat) {
        $category_labels[] = $stat['category_name'];
        $category_data[] = (int)$stat['count'];
    }
    
    echo "<h3>Processed Data for Chart:</h3>";
    echo "Category Labels: <pre>" . print_r($category_labels, true) . "</pre>";
    echo "Category Data: <pre>" . print_r($category_data, true) . "</pre>";
    echo "JSON Labels: " . json_encode($category_labels) . "<br>";
    echo "JSON Data: " . json_encode($category_data) . "<br>";
    
    // Check monthly revenue
    echo "<h3>Monthly Revenue Test:</h3>";
    $stmt = $db->query("SELECT SUM(total_price) as revenue FROM bookings WHERE status = 'completed' AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");
    $revenue = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Revenue: Rp " . number_format($revenue['revenue'] ?? 0, 0, ',', '.') . "<br>";
    
    echo "<h3>Status:</h3>";
    echo "<p style='color: green;'>✓ Category query fixed - should now show data in dashboard charts!</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<h3>Dashboard Link:</h3>
<a href="admin/dashboard.php" target="_blank">Go to Dashboard (New Tab)</a>
<br><br>
<button onclick="window.location.reload()">Refresh This Page</button>