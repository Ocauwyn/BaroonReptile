<?php
require_once 'config/database.php';

try {
    $db = getDB();
    
    echo "<h2>Creating Sample Bookings for Testing</h2>";
    
    // First, let's create a sample reptile for customer1
    $stmt = $db->prepare("
        INSERT INTO reptiles (customer_id, category_id, name, species, age, gender, status) 
        VALUES (2, 1, 'Sanca Hijau Mini', 'Morelia viridis', '6 months', 'female', 'active')
        ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)
    ");
    $stmt->execute();
    $reptile_id = $db->lastInsertId();
    
    if (!$reptile_id) {
        // Get existing reptile if insert failed
        $stmt = $db->prepare("SELECT id FROM reptiles WHERE customer_id = 2 LIMIT 1");
        $stmt->execute();
        $reptile_id = $stmt->fetchColumn();
    }
    
    echo "<p>✅ Reptile ID: $reptile_id</p>";
    
    // Create a sample booking
    $start_date = date('Y-m-d', strtotime('-5 days'));
    $end_date = date('Y-m-d', strtotime('+5 days'));
    $total_days = 10;
    $price_per_day = 25000;
    $total_price = $total_days * $price_per_day;
    
    $stmt = $db->prepare("
        INSERT INTO bookings (customer_id, reptile_id, start_date, end_date, total_days, price_per_day, total_price, status, notes) 
        VALUES (2, ?, ?, ?, ?, ?, ?, 'in_progress', 'Sample booking for testing daily reports')
        ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)
    ");
    $stmt->execute([$reptile_id, $start_date, $end_date, $total_days, $price_per_day, $total_price]);
    $booking_id = $db->lastInsertId();
    
    if (!$booking_id) {
        // Get existing booking if insert failed
        $stmt = $db->prepare("SELECT id FROM bookings WHERE reptile_id = ? LIMIT 1");
        $stmt->execute([$reptile_id]);
        $booking_id = $stmt->fetchColumn();
    }
    
    echo "<p>✅ Booking ID: $booking_id</p>";
    echo "<p>📅 Booking Period: $start_date to $end_date</p>";
    echo "<p>💰 Total Price: Rp " . number_format($total_price, 0, ',', '.') . "</p>";
    
    // Create some sample care reports
    $sample_reports = [
        [
            'report_date' => date('Y-m-d', strtotime('-2 days')),
            'health_status' => 'excellent',
            'food_given' => 'Jangkrik 3 ekor, sayuran hijau',
            'notes' => 'Reptile sangat aktif dan sehat. Makan dengan lahap.'
        ],
        [
            'report_date' => date('Y-m-d', strtotime('-1 day')),
            'health_status' => 'good',
            'food_given' => 'Jangkrik 2 ekor, buah-buahan',
            'notes' => 'Kondisi baik, sedikit kurang aktif dari biasanya.'
        ],
        [
            'report_date' => date('Y-m-d'),
            'health_status' => 'excellent',
            'food_given' => 'Jangkrik 4 ekor, vitamin',
            'notes' => 'Sangat sehat dan aktif. Sudah mulai ganti kulit.'
        ]
    ];
    
    foreach ($sample_reports as $report) {
        $stmt = $db->prepare("
            INSERT INTO care_reports (reptile_id, booking_id, report_date, health_status, food_given, notes, staff_id, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, 1, NOW())
            ON DUPLICATE KEY UPDATE 
                health_status = VALUES(health_status),
                food_given = VALUES(food_given),
                notes = VALUES(notes)
        ");
        $stmt->execute([
            $reptile_id, 
            $booking_id, 
            $report['report_date'], 
            $report['health_status'], 
            $report['food_given'], 
            $report['notes']
        ]);
        echo "<p>✅ Care report created for " . $report['report_date'] . "</p>";
    }
    
    echo "<hr>";
    echo "<h3>Test Links:</h3>";
    echo "<p><a href='admin/daily_report.php?booking_id=$booking_id' target='_blank'>🔗 Open Daily Report for Booking #$booking_id</a></p>";
    echo "<p><a href='admin/booking_detail.php?id=$booking_id' target='_blank'>🔗 Open Booking Detail for Booking #$booking_id</a></p>";
    echo "<p><a href='admin/bookings.php' target='_blank'>🔗 Open Bookings List</a></p>";
    
    echo "<hr>";
    echo "<h3>Database Status:</h3>";
    
    // Check tables
    $tables = ['users', 'reptiles', 'bookings', 'care_reports'];
    foreach ($tables as $table) {
        $stmt = $db->query("SELECT COUNT(*) FROM $table");
        $count = $stmt->fetchColumn();
        echo "<p>📊 Table '$table': $count records</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>Stack trace: <pre>" . $e->getTraceAsString() . "</pre></p>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h2, h3 { color: #333; }
p { margin: 5px 0; }
a { color: #007bff; text-decoration: none; }
a:hover { text-decoration: underline; }
hr { margin: 20px 0; }
</style>