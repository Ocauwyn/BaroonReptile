<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart.js Loading Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h2>Chart.js Loading Test</h2>
                <p>This page tests the Chart.js loading mechanism with fallbacks.</p>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Test Chart 1</h5>
                    </div>
                    <div class="card-body" style="height: 300px; position: relative;">
                        <div id="testChartLoading" class="d-flex flex-column justify-content-center align-items-center h-100">
                            <div class="spinner-border text-primary mb-3" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="text-muted">
                                <small id="testLoadingStatus">Loading Chart.js library...</small>
                            </div>
                        </div>
                        <canvas id="testChart" style="display: none;"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Loading Status</h5>
                    </div>
                    <div class="card-body">
                        <div id="loadingLog">
                            <p><i class="fas fa-clock"></i> Initializing...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js with multiple fallbacks -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js" 
            onerror="loadChartJSFallback()" 
            onload="chartJSLoaded = true; logStatus('Primary CDN loaded successfully')"></script>
    <script>
        let chartJSLoaded = false;
        let fallbackAttempts = 0;
        const maxFallbackAttempts = 3;
        
        const fallbackCDNs = [
            'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js',
            'https://unpkg.com/chart.js@4.4.0/dist/chart.min.js',
            'https://cdn.skypack.dev/chart.js@4.4.0'
        ];
        
        function logStatus(message) {
            const log = document.getElementById('loadingLog');
            const timestamp = new Date().toLocaleTimeString();
            log.innerHTML += `<p><small class="text-muted">[${timestamp}]</small> ${message}</p>`;
            console.log(message);
        }
        
        function updateTestLoadingStatus(message) {
            const statusElement = document.getElementById('testLoadingStatus');
            if (statusElement) {
                statusElement.textContent = message;
            }
        }
        
        function loadChartJSFallback() {
            if (fallbackAttempts < maxFallbackAttempts && fallbackAttempts < fallbackCDNs.length) {
                logStatus(`<i class="fas fa-exclamation-triangle text-warning"></i> Primary CDN failed, trying fallback ${fallbackAttempts + 1}`);
                updateTestLoadingStatus(`Trying fallback CDN ${fallbackAttempts + 1}...`);
                
                const script = document.createElement('script');
                script.src = fallbackCDNs[fallbackAttempts];
                script.onload = function() {
                    chartJSLoaded = true;
                    logStatus(`<i class="fas fa-check text-success"></i> Chart.js loaded from fallback CDN: ${fallbackCDNs[fallbackAttempts]}`);
                    updateTestLoadingStatus('Chart.js loaded successfully!');
                };
                script.onerror = function() {
                    logStatus(`<i class="fas fa-times text-danger"></i> Fallback CDN ${fallbackAttempts + 1} failed`);
                    fallbackAttempts++;
                    if (fallbackAttempts < maxFallbackAttempts) {
                        loadChartJSFallback();
                    } else {
                        logStatus(`<i class="fas fa-times text-danger"></i> All Chart.js CDNs failed to load`);
                        updateTestLoadingStatus('All CDNs failed. Checking connection...');
                        testInternetConnection();
                    }
                };
                document.head.appendChild(script);
                fallbackAttempts++;
            } else {
                testInternetConnection();
            }
        }
        
        function testInternetConnection() {
            logStatus('<i class="fas fa-wifi"></i> Testing internet connection...');
            const img = new Image();
            img.onload = function() {
                logStatus('<i class="fas fa-check text-success"></i> Internet connection OK. Chart.js CDNs unavailable.');
                updateTestLoadingStatus('Internet connection OK. Chart.js CDNs unavailable.');
                showTestChartError('Chart.js library is currently unavailable from all CDN sources.');
            };
            img.onerror = function() {
                logStatus('<i class="fas fa-times text-danger"></i> No internet connection detected.');
                updateTestLoadingStatus('No internet connection detected.');
                showTestChartError('Please check your internet connection and refresh the page.');
            };
            img.src = 'https://www.google.com/favicon.ico?' + Date.now();
        }
        
        function showTestChartError(message) {
            const errorHTML = `
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-triangle mb-2" style="font-size: 2rem;"></i>
                    <h6>Chart Loading Failed</h6>
                    <p class="mb-2">${message}</p>
                    <button class="btn btn-sm btn-outline-danger" onclick="location.reload()">
                        <i class="fas fa-refresh"></i> Refresh Page
                    </button>
                </div>
            `;
            
            const testChartContainer = document.getElementById('testChartLoading');
            if (testChartContainer) {
                testChartContainer.innerHTML = errorHTML;
            }
        }
        
        function initializeTestChart() {
            const testCanvas = document.getElementById('testChart');
            const testLoading = document.getElementById('testChartLoading');
            
            if (!testCanvas) {
                logStatus('<i class="fas fa-times text-danger"></i> Test chart canvas not found!');
                return;
            }
            
            try {
                const ctx = testCanvas.getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                        datasets: [{
                            label: 'Test Data',
                            data: [12, 19, 3, 5, 2],
                            backgroundColor: 'rgba(74, 124, 89, 0.8)',
                            borderColor: '#4a7c59',
                            borderWidth: 1
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
                
                // Hide loading and show chart
                if (testLoading) testLoading.style.display = 'none';
                testCanvas.style.display = 'block';
                logStatus('<i class="fas fa-check text-success"></i> Test chart created successfully!');
            } catch (error) {
                logStatus(`<i class="fas fa-times text-danger"></i> Error creating test chart: ${error.message}`);
                if (testLoading) {
                    testLoading.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
                }
            }
        }
        
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            logStatus('<i class="fas fa-play"></i> DOM loaded, starting Chart.js check...');
            
            function checkAndInitializeTestChart() {
                if (typeof Chart === 'undefined') {
                    if (fallbackAttempts < maxFallbackAttempts) {
                        logStatus('<i class="fas fa-clock"></i> Waiting for Chart.js to load...');
                        updateTestLoadingStatus('Waiting for Chart.js to load...');
                        setTimeout(checkAndInitializeTestChart, 500);
                        return;
                    } else {
                        logStatus('<i class="fas fa-times text-danger"></i> Chart.js failed to load from all sources!');
                        updateTestLoadingStatus('Chart.js failed to load.');
                        showTestChartError('Chart.js library could not be loaded from any source.');
                        return;
                    }
                }
                
                logStatus(`<i class="fas fa-check text-success"></i> Chart.js loaded successfully! Version: ${Chart.version}`);
                updateTestLoadingStatus('Initializing test chart...');
                
                try {
                    initializeTestChart();
                } catch (error) {
                    logStatus(`<i class="fas fa-times text-danger"></i> Error initializing test chart: ${error.message}`);
                    showTestChartError('Error occurred while initializing chart: ' + error.message);
                }
            }
            
            setTimeout(checkAndInitializeTestChart, 100);
        });
    </script>
</body>
</html>