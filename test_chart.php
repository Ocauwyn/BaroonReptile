<?php
require_once 'config/database.php';

// Test chart data generation
try {
    $db = getDB();
    
    if (!$db) {
        throw new Exception('Database connection failed');
    }
    
    // Test category data
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
    
    $category_labels = [];
    $category_data = [];
    foreach ($category_stats as $stat) {
        $category_labels[] = $stat['category_name'];
        $category_data[] = (int)$stat['count'];
    }
    
    if (empty($category_labels)) {
        $category_labels = ['No Data'];
        $category_data = [0];
    }
    
    echo "<h2>Chart Data Test</h2>";
    echo "<h3>Category Labels:</h3>";
    echo "<pre>" . print_r($category_labels, true) . "</pre>";
    echo "<h3>Category Data:</h3>";
    echo "<pre>" . print_r($category_data, true) . "</pre>";
    echo "<h3>Count Test:</h3>";
    echo "is_array: " . (is_array($category_labels) ? 'true' : 'false') . "<br>";
    echo "is_null: " . (is_null($category_labels) ? 'true' : 'false') . "<br>";
    echo "count: " . ((is_array($category_labels) && $category_labels !== null) ? count($category_labels) : 1) . "<br>";
    
    echo "<h3>JSON Output:</h3>";
    echo "Category Labels JSON: " . json_encode($category_labels) . "<br>";
    echo "Category Data JSON: " . json_encode($category_data) . "<br>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<h3>Dashboard Link:</h3>
<a href="admin/dashboard.php">Go to Dashboard</a>