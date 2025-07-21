<?php
require_once 'config/database.php';

// Test database connection and chart data
try {
    $db = getDB();
    
    if (!$db) {
        throw new Exception('Database connection failed');
    }
    
    echo "<h2>Database Connection: OK</h2>";
    
    // Test booking statistics
    echo "<h3>Booking Statistics Test</h3>";
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
    
    echo "<p>Booking data found: " . count($booking_stats) . " records</p>";
    echo "<pre>" . print_r($booking_stats, true) . "</pre>";
    
    // Test category statistics
    echo "<h3>Category Statistics Test</h3>";
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
    
    echo "<p>Category data found: " . count($category_stats) . " records</p>";
    echo "<pre>" . print_r($category_stats, true) . "</pre>";
    
    // Test basic counts
    echo "<h3>Basic Statistics Test</h3>";
    
    $stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'customer'");
    $customers = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "<p>Total customers: $customers</p>";
    
    $stmt = $db->query("SELECT COUNT(*) as count FROM reptiles WHERE status = 'active'");
    $reptiles = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "<p>Active reptiles: $reptiles</p>";
    
    $stmt = $db->query("SELECT COUNT(*) as count FROM bookings WHERE status IN ('confirmed', 'in_progress')");
    $active_bookings = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "<p>Active bookings: $active_bookings</p>";
    
    $stmt = $db->query("SELECT COUNT(*) as count FROM bookings WHERE status = 'pending'");
    $pending_bookings = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "<p>Pending bookings: $pending_bookings</p>";
    
    // Test Chart.js CDN
    echo "<h3>Chart.js Test</h3>";
    echo '<div style="width: 400px; height: 200px;"><canvas id="testChart"></canvas></div>';
    echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
    echo '<script>
        if (typeof Chart !== "undefined") {
            console.log("Chart.js loaded successfully");
            const ctx = document.getElementById("testChart").getContext("2d");
            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ["Test 1", "Test 2", "Test 3"],
                    datasets: [{
                        label: "Test Data",
                        data: [10, 20, 30],
                        backgroundColor: ["#4a7c59", "#2c5530", "#6fa86f"]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
            document.write("<p style=\"color: green;\">Chart.js is working!</p>");
        } else {
            document.write("<p style=\"color: red;\">Chart.js failed to load!</p>");
        }
    </script>';
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>Error: " . $e->getMessage() . "</h2>";
    echo "<p>Please check your database configuration and make sure XAMPP MySQL is running.</p>";
}
?>