<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chart.js Test</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .status { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
    </style>
</head>
<body>
    <h1>Chart.js Loading Test</h1>
    <div id="status" class="status info">Testing Chart.js loading...</div>
    
    <div style="width: 400px; height: 300px; margin: 20px 0;">
        <canvas id="testChart"></canvas>
    </div>
    
    <!-- Try loading Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>
    
    <script>
        const statusDiv = document.getElementById('status');
        
        function updateStatus(message, type = 'info') {
            statusDiv.textContent = message;
            statusDiv.className = 'status ' + type;
            console.log(message);
        }
        
        function testChart() {
            updateStatus('Checking if Chart.js is available...', 'info');
            
            if (typeof Chart === 'undefined') {
                updateStatus('Chart.js is NOT loaded!', 'error');
                return;
            }
            
            updateStatus('Chart.js is loaded! Version: ' + (Chart.version || 'unknown'), 'success');
            
            // Try to create a simple chart
            try {
                const canvas = document.getElementById('testChart');
                const ctx = canvas.getContext('2d');
                
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar'],
                        datasets: [{
                            label: 'Test Data',
                            data: [10, 20, 15],
                            backgroundColor: ['#ff6384', '#36a2eb', '#ffce56']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
                
                updateStatus('Chart created successfully!', 'success');
            } catch (error) {
                updateStatus('Error creating chart: ' + error.message, 'error');
            }
        }
        
        // Test immediately
        setTimeout(testChart, 100);
        
        // Also test after a delay
        setTimeout(function() {
            if (typeof Chart === 'undefined') {
                updateStatus('Chart.js still not loaded after 2 seconds - CDN issue!', 'error');
            }
        }, 2000);
    </script>
</body>
</html>