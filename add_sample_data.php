<?php
require_once 'config/database.php';

try {
    $db = getDB();
    
    if (!$db) {
        throw new Exception('Database connection failed');
    }
    
    echo "<h2>Adding Sample Data for Charts</h2>";
    
    // Add sample reptiles
    $stmt = $db->prepare("
        INSERT IGNORE INTO reptiles (customer_id, category_id, name, species, age, weight, length, gender, status, created_at) 
        VALUES 
        (2, 1, 'Python Kecil', 'Ball Python', '2 years', 1.5, 80, 'female', 'active', '2024-01-15'),
        (2, 2, 'Boa Sedang', 'Boa Constrictor', '3 years', 5.2, 150, 'male', 'active', '2024-02-10'),
        (2, 3, 'Python Besar', 'Reticulated Python', '5 years', 15.0, 300, 'female', 'active', '2024-03-05'),
        (2, 4, 'Gecko Leopard', 'Leopard Gecko', '1 year', 0.08, 20, 'male', 'active', '2024-04-12'),
        (2, 5, 'Iguana Hijau', 'Green Iguana', '4 years', 3.5, 120, 'female', 'active', '2024-05-20'),
        (2, 6, 'Monitor Besar', 'Asian Water Monitor', '6 years', 8.0, 180, 'male', 'active', '2024-06-08'),
        (2, 7, 'Kura-kura Darat', 'Russian Tortoise', '10 years', 2.0, 25, 'female', 'active', '2024-07-15'),
        (2, 8, 'Kura-kura Air', 'Red-eared Slider', '3 years', 1.2, 30, 'male', 'active', '2024-08-22')
    ");
    $stmt->execute();
    echo "<p>✓ Sample reptiles added</p>";
    
    // Add sample bookings for different months
    $stmt = $db->prepare("
        INSERT IGNORE INTO bookings (customer_id, reptile_id, start_date, end_date, total_days, price_per_day, total_price, status, created_at) 
        VALUES 
        (2, 1, '2024-01-20', '2024-01-27', 7, 25000, 175000, 'completed', '2024-01-20'),
        (2, 2, '2024-02-15', '2024-02-22', 7, 35000, 245000, 'completed', '2024-02-15'),
        (2, 3, '2024-03-10', '2024-03-17', 7, 50000, 350000, 'completed', '2024-03-10'),
        (2, 4, '2024-04-18', '2024-04-25', 7, 20000, 140000, 'completed', '2024-04-18'),
        (2, 5, '2024-05-25', '2024-06-01', 7, 40000, 280000, 'completed', '2024-05-25'),
        (2, 6, '2024-06-12', '2024-06-19', 7, 60000, 420000, 'completed', '2024-06-12'),
        (2, 7, '2024-07-20', '2024-07-27', 7, 30000, 210000, 'completed', '2024-07-20'),
        (2, 8, '2024-08-28', '2024-09-04', 7, 35000, 245000, 'completed', '2024-08-28'),
        (2, 1, '2024-09-15', '2024-09-22', 7, 25000, 175000, 'confirmed', '2024-09-15'),
        (2, 2, '2024-10-10', '2024-10-17', 7, 35000, 245000, 'in_progress', '2024-10-10'),
        (2, 3, '2024-11-05', '2024-11-12', 7, 50000, 350000, 'pending', '2024-11-05'),
        (2, 4, '2024-12-01', '2024-12-08', 7, 20000, 140000, 'pending', '2024-12-01')
    ");
    $stmt->execute();
    echo "<p>✓ Sample bookings added</p>";
    
    // Verify data
    $stmt = $db->query("SELECT COUNT(*) as count FROM reptiles WHERE status = 'active'");
    $reptile_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "<p>Total active reptiles: $reptile_count</p>";
    
    $stmt = $db->query("SELECT COUNT(*) as count FROM bookings");
    $booking_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "<p>Total bookings: $booking_count</p>";
    
    // Test chart data
    echo "<h3>Chart Data Preview</h3>";
    
    // Monthly booking data
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
    $monthly_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<p>Monthly booking data:</p>";
    echo "<pre>" . print_r($monthly_stats, true) . "</pre>";
    
    // Category data
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
    echo "<p>Category distribution:</p>";
    echo "<pre>" . print_r($category_stats, true) . "</pre>";
    
    echo "<h3>✅ Sample data added successfully!</h3>";
    echo "<p><a href='admin/dashboard.php'>Go to Admin Dashboard</a></p>";
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>Error: " . $e->getMessage() . "</h2>";
    echo "<p>Please check your database configuration and make sure XAMPP MySQL is running.</p>";
}
?>