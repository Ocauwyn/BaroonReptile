<?php
echo "<h1>Test Simple PHP</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Name: " . $_SERVER['SCRIPT_NAME'] . "</p>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";

// Test database connection without complex config
try {
    $pdo = new PDO('mysql:host=localhost:3307;dbname=baroon_reptile', 'root', '');
    echo "<p style='color:green;'>✅ Database Connection: SUCCESS</p>";
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Database Connection: FAILED - " . $e->getMessage() . "</p>";
}

echo "<p><a href='auth/login.php'>Go to Login Page</a></p>";
?>