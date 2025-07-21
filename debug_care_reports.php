<?php
require_once 'config/database.php';

try {
    $db = getDB();
    
    echo "<h2>Debug Care Reports</h2>";
    
    // Check all care reports
    $stmt = $db->query("SELECT * FROM care_reports ORDER BY id DESC");
    $all_reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>All Care Reports (" . count($all_reports) . "):</h3>";
    foreach ($all_reports as $report) {
        echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
        echo "<strong>ID:</strong> " . $report['id'] . "<br>";
        echo "<strong>Booking ID:</strong> " . $report['booking_id'] . "<br>";
        echo "<strong>Reptile ID:</strong> " . $report['reptile_id'] . "<br>";
        echo "<strong>Report Date:</strong> " . $report['report_date'] . "<br>";
        echo "<strong>Health Status:</strong> " . $report['health_status'] . "<br>";
        echo "<strong>Food Given:</strong> " . $report['food_given'] . "<br>";
        echo "<strong>Notes:</strong> " . $report['notes'] . "<br>";
        echo "<strong>Staff ID:</strong> " . $report['staff_id'] . "<br>";
        echo "</div>";
    }
    
    // Check specific booking
    $booking_id = 4;
    echo "<h3>Care Reports for Booking #$booking_id:</h3>";
    
    $stmt = $db->prepare("
        SELECT cr.*, u.full_name as staff_name
        FROM care_reports cr
        LEFT JOIN users u ON cr.staff_id = u.id
        WHERE cr.booking_id = ?
        ORDER BY cr.report_date DESC
    ");
    $stmt->execute([$booking_id]);
    $care_reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p>Found " . count($care_reports) . " care reports for booking #$booking_id</p>";
    
    foreach ($care_reports as $report) {
        echo "<div style='border: 1px solid #4a7c59; margin: 10px; padding: 15px; background: #f8f9fa;'>";
        echo "<h6>" . date('d M Y', strtotime($report['report_date'])) . "</h6>";
        echo "<p><strong>Health Status:</strong> " . htmlspecialchars($report['health_status']) . "</p>";
        echo "<p><strong>Food Given:</strong> " . htmlspecialchars($report['food_given']) . "</p>";
        echo "<p><strong>Notes:</strong> " . htmlspecialchars($report['notes']) . "</p>";
        echo "<small>by " . htmlspecialchars($report['staff_name']) . "</small>";
        echo "</div>";
    }
    
    // Check booking details
    echo "<h3>Booking Details for #$booking_id:</h3>";
    $stmt = $db->prepare("SELECT * FROM bookings WHERE id = ?");
    $stmt->execute([$booking_id]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($booking) {
        echo "<p><strong>Customer ID:</strong> " . $booking['customer_id'] . "</p>";
        echo "<p><strong>Status:</strong> " . $booking['status'] . "</p>";
        echo "<p><strong>Start Date:</strong> " . $booking['start_date'] . "</p>";
        echo "<p><strong>End Date:</strong> " . $booking['end_date'] . "</p>";
    } else {
        echo "<p>Booking not found!</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h2, h3 { color: #333; }
p { margin: 5px 0; }
</style>