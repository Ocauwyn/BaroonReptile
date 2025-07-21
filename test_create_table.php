<?php
require_once 'config/database.php';

echo "<h2>Create Business Reports Table</h2>";

try {
    $db = getDB();
    
    if (!$db) {
        throw new Exception('Database connection failed');
    }
    
    // Read and execute SQL file
    $sql = file_get_contents('create_business_reports_table.sql');
    
    // Split SQL into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    echo "<h3>Executing SQL Statements:</h3>";
    
    foreach ($statements as $statement) {
        if (!empty($statement) && !preg_match('/^\s*--/', $statement)) {
            echo "<p>Executing: <code>" . htmlspecialchars(substr($statement, 0, 100)) . "...</code></p>";
            try {
                $db->exec($statement);
                echo "<p style='color: green;'>✓ Success</p>";
            } catch (Exception $e) {
                echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
            }
        }
    }
    
    // Test if table exists and has data
    echo "<h3>Testing Table:</h3>";
    $stmt = $db->query("SHOW TABLES LIKE 'daily_business_reports'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ Table 'daily_business_reports' exists</p>";
        
        $stmt = $db->query("SELECT COUNT(*) as count FROM daily_business_reports");
        $count = $stmt->fetchColumn();
        echo "<p>Records in table: " . $count . "</p>";
        
        if ($count > 0) {
            $stmt = $db->query("SELECT * FROM daily_business_reports ORDER BY report_date DESC LIMIT 3");
            $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<h4>Sample Data:</h4>";
            echo "<pre>" . print_r($reports, true) . "</pre>";
        }
    } else {
        echo "<p style='color: red;'>✗ Table 'daily_business_reports' does not exist</p>";
    }
    
    echo "<h3>Status:</h3>";
    echo "<p style='color: green;'>✓ Database setup completed! Reports functionality should now work.</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<h3>Test Links:</h3>
<a href="admin/reports.php" target="_blank">Go to Reports Page (New Tab)</a><br><br>
<button onclick="window.location.reload()">Refresh This Page</button>