<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart Debug - Baroon Reptile</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .chart-container { width: 400px; height: 300px; margin: 20px 0; border: 1px solid #ccc; padding: 10px; }
        .debug-info { background: #f5f5f5; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Chart Debug Page</h1>
    
    <div class="debug-info">
        <h3>Chart.js Status</h3>
        <p id="chartStatus">Checking...</p>
    </div>
    
    <div class="debug-info">
        <h3>Sample Data Test</h3>
        <div class="chart-container">
            <canvas id="testChart"></canvas>
        </div>
    </div>
    
    <?php
    require_once 'config/database.php';
    
    // Get real data from database
    $monthly_data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    $month_labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $category_labels = ['No Data'];
    $category_data = [0];
    
    try {
        $db = getDB();
        
        if ($db) {
            // Get monthly booking data
            $stmt = $db->query("
                SELECT 
                    MONTH(created_at) as month,
                    COUNT(*) as count
                FROM bookings 
                WHERE created_at >= DATE_SUB(CURRENT_DATE(), INTERVAL 12 MONTH)
                GROUP BY MONTH(created_at)
                ORDER BY month
            ");
            $booking_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($booking_stats as $stat) {
                $month_index = $stat['month'] - 1;
                if ($month_index >= 0 && $month_index < 12) {
                    $monthly_data[$month_index] = (int)$stat['count'];
                }
            }
            
            // Get category data
            $stmt = $db->query("
                SELECT 
                    rc.name as category_name,
                    COUNT(r.id) as count
                FROM reptile_categories rc
                LEFT JOIN reptiles r ON rc.id = r.category_id AND r.status = 'active'
                GROUP BY rc.id, rc.name
                HAVING count > 0
                ORDER BY count DESC
            ");
            $category_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($category_stats)) {
                $category_labels = [];
                $category_data = [];
                foreach ($category_stats as $stat) {
                    $category_labels[] = $stat['category_name'];
                    $category_data[] = (int)$stat['count'];
                }
            }
        }
    } catch (Exception $e) {
        echo '<div class="debug-info"><p style="color: red;">Database Error: ' . $e->getMessage() . '</p></div>';
    }
    ?>
    
    <div class="debug-info">
        <h3>Real Database Data</h3>
        <p><strong>Monthly Data:</strong> <?php echo json_encode($monthly_data); ?></p>
        <p><strong>Category Labels:</strong> <?php echo json_encode($category_labels); ?></p>
        <p><strong>Category Data:</strong> <?php echo json_encode($category_data); ?></p>
        
        <div style="display: flex; gap: 20px;">
            <div class="chart-container">
                <h4>Monthly Bookings</h4>
                <canvas id="monthlyChart"></canvas>
            </div>
            <div class="chart-container">
                <h4>Category Distribution</h4>
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
    
    <script>
        // Check Chart.js availability
        const statusElement = document.getElementById('chartStatus');
        if (typeof Chart !== 'undefined') {
            statusElement.innerHTML = '✅ Chart.js loaded successfully (Version: ' + Chart.version + ')';
            statusElement.style.color = 'green';
        } else {
            statusElement.innerHTML = '❌ Chart.js failed to load';
            statusElement.style.color = 'red';
        }
        
        // Wait for DOM to load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Chart === 'undefined') {
                return;
            }
            
            // Test chart with sample data
            const testCtx = document.getElementById('testChart').getContext('2d');
            new Chart(testCtx, {
                type: 'bar',
                data: {
                    labels: ['Test 1', 'Test 2', 'Test 3'],
                    datasets: [{
                        label: 'Sample Data',
                        data: [12, 19, 3],
                        backgroundColor: ['#4a7c59', '#2c5530', '#6fa86f']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
            
            // Monthly chart with real data
            const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($month_labels); ?>,
                    datasets: [{
                        label: 'Bookings',
                        data: <?php echo json_encode($monthly_data); ?>,
                        borderColor: '#4a7c59',
                        backgroundColor: 'rgba(74, 124, 89, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            
            // Category chart with real data
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: <?php echo json_encode($category_labels); ?>,
                    datasets: [{
                        data: <?php echo json_encode($category_data); ?>,
                        backgroundColor: ['#4a7c59', '#2c5530', '#6fa86f', '#8bc34a', '#a4d65e', '#7cb342', '#689f38', '#558b2f']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>
</body>
</html>