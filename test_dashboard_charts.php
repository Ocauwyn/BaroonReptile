<?php
// Simple test to verify dashboard chart functionality
require_once 'config/database.php';

// Get sample data for testing
$month_labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
$monthly_data = [5, 8, 12, 7, 15, 10];
$category_labels = ['Snake', 'Lizard', 'Turtle', 'Gecko'];
$category_data = [15, 8, 5, 12];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Charts Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chart-container { height: 400px; position: relative; }
        .loading-spinner { text-align: center; padding: 50px; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>Dashboard Charts Test</h1>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Monthly Bookings</h5>
                    </div>
                    <div class="card-body chart-container">
                        <div id="bookingChartLoading" class="loading-spinner">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p id="chartLoadingStatus">Loading Chart.js...</p>
                        </div>
                        <canvas id="bookingChart" style="display: none;"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Reptile Categories</h5>
                    </div>
                    <div class="card-body chart-container">
                        <div id="categoryChartLoading" class="loading-spinner">
                            <div class="spinner-border text-success" role="status"></div>
                            <p id="categoryLoadingStatus">Loading Chart.js...</p>
                        </div>
                        <canvas id="categoryChart" style="display: none;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Debug Information</h5>
                    </div>
                    <div class="card-body">
                        <div id="debugInfo"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>
    
    <script>
        function updateLoadingStatus(message) {
            const statusElements = document.querySelectorAll('#chartLoadingStatus, #categoryLoadingStatus');
            statusElements.forEach(el => {
                if (el) el.textContent = message;
            });
        }
        
        function showChartError(customMessage) {
            const defaultMessage = 'Chart.js library failed to load.';
            const message = customMessage || defaultMessage;
            
            const errorHTML = `
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-triangle mb-2" style="font-size: 2rem;"></i>
                    <h6>Chart Loading Failed</h6>
                    <p class="mb-2">${message}</p>
                    <button class="btn btn-sm btn-outline-danger" onclick="location.reload()">
                        Refresh Page
                    </button>
                </div>
            `;
            
            const bookingChartContainer = document.getElementById('bookingChartLoading');
            const categoryChartContainer = document.getElementById('categoryChartLoading');
            
            if (bookingChartContainer) {
                bookingChartContainer.innerHTML = errorHTML;
            }
            if (categoryChartContainer) {
                categoryChartContainer.innerHTML = errorHTML;
            }
        }
        
        function logDebug(message) {
            const debugDiv = document.getElementById('debugInfo');
            const timestamp = new Date().toLocaleTimeString();
            debugDiv.innerHTML += `<p><strong>[${timestamp}]</strong> ${message}</p>`;
            console.log(message);
        }
        
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            logDebug('DOM loaded, starting chart initialization...');
            
            // Simple function to check and initialize charts
            function checkAndInitializeCharts() {
                let attempts = 0;
                const maxAttempts = 20; // 10 seconds total (500ms * 20)
                
                function tryInitialize() {
                    attempts++;
                    
                    if (typeof Chart !== 'undefined') {
                        // Chart.js is loaded, proceed with initialization
                        logDebug('Chart.js loaded successfully! Version: ' + (Chart.version || 'unknown'));
                        updateLoadingStatus('Initializing charts...');
                        
                        try {
                            initializeCharts();
                        } catch (error) {
                            logDebug('Error initializing charts: ' + error.message);
                            showChartError('Error occurred while initializing charts: ' + error.message);
                        }
                        return;
                    }
                    
                    if (attempts < maxAttempts) {
                        logDebug(`Waiting for Chart.js to load... (attempt ${attempts}/${maxAttempts})`);
                        updateLoadingStatus(`Waiting for Chart.js to load... (${attempts}/${maxAttempts})`);
                        setTimeout(tryInitialize, 500);
                    } else {
                        logDebug('Chart.js failed to load after maximum attempts!');
                        updateLoadingStatus('Chart.js failed to load.');
                        showChartError('Chart.js library could not be loaded. Please check your internet connection and refresh the page.');
                    }
                }
                
                // Start trying to initialize
                tryInitialize();
            }
            
            // Start checking for Chart.js
            setTimeout(checkAndInitializeCharts, 100);
        });
        
        function initializeCharts() {
            // Booking Chart
            const bookingCanvas = document.getElementById('bookingChart');
            const bookingLoading = document.getElementById('bookingChartLoading');
            
            if (!bookingCanvas) {
                logDebug('Booking chart canvas not found!');
                if (bookingLoading) bookingLoading.innerHTML = '<p class="text-center text-danger">Chart canvas not found</p>';
                return;
            }
            
            try {
                const bookingCtx = bookingCanvas.getContext('2d');
                new Chart(bookingCtx, {
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
                        maintainAspectRatio: false
                    }
                });
                
                // Hide loading and show chart
                if (bookingLoading) bookingLoading.style.display = 'none';
                bookingCanvas.style.display = 'block';
                logDebug('Booking chart created successfully');
            } catch (error) {
                logDebug('Error creating booking chart: ' + error.message);
                if (bookingLoading) {
                    bookingLoading.innerHTML = '<p class="text-center text-danger">Error loading booking chart: ' + error.message + '</p>';
                }
            }
            
            // Category Chart
            const categoryCanvas = document.getElementById('categoryChart');
            const categoryLoading = document.getElementById('categoryChartLoading');
            
            if (!categoryCanvas) {
                logDebug('Category chart canvas not found!');
                if (categoryLoading) categoryLoading.innerHTML = '<p class="text-center text-danger">Chart canvas not found</p>';
                return;
            }
            
            try {
                const categoryCtx = categoryCanvas.getContext('2d');
                const categoryColors = ['#4a7c59', '#2c5530', '#6fa86f', '#8bc34a'];
                
                new Chart(categoryCtx, {
                    type: 'doughnut',
                    data: {
                        labels: <?php echo json_encode($category_labels); ?>,
                        datasets: [{
                            data: <?php echo json_encode($category_data); ?>,
                            backgroundColor: categoryColors,
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
                
                // Hide loading and show chart
                if (categoryLoading) categoryLoading.style.display = 'none';
                categoryCanvas.style.display = 'block';
                logDebug('Category chart created successfully');
            } catch (error) {
                logDebug('Error creating category chart: ' + error.message);
                if (categoryLoading) {
                    categoryLoading.innerHTML = '<p class="text-center text-danger">Error loading category chart: ' + error.message + '</p>';
                }
            }
        }
    </script>
</body>
</html>