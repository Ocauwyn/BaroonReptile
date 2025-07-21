<?php
require_once 'config/database.php';

echo "<h2>Database Users Check</h2>";

try {
    $db = getDB();
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    // Check if users table exists
    $stmt = $db->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ Users table exists</p>";
        
        // Check users count
        $stmt = $db->query("SELECT COUNT(*) as count FROM users");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "<p>Total users: $count</p>";
        
        // Show all users
        $stmt = $db->query("SELECT id, username, email, full_name, role, status FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($users) > 0) {
            echo "<h3>Existing Users:</h3>";
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Full Name</th><th>Role</th><th>Status</th></tr>";
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>{$user['id']}</td>";
                echo "<td>{$user['username']}</td>";
                echo "<td>{$user['email']}</td>";
                echo "<td>{$user['full_name']}</td>";
                echo "<td>{$user['role']}</td>";
                echo "<td>{$user['status']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: red;'>❌ No users found in database</p>";
            
            // Create default users
            echo "<h3>Creating default users...</h3>";
            
            $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $customerPassword = password_hash('customer123', PASSWORD_DEFAULT);
            
            $stmt = $db->prepare("INSERT INTO users (username, email, password, full_name, role, status) VALUES (?, ?, ?, ?, ?, ?)");
            
            // Create admin user
            $stmt->execute(['admin', 'admin@baroonreptile.com', $adminPassword, 'Administrator', 'admin', 'active']);
            echo "<p style='color: green;'>✓ Admin user created (username: admin, password: admin123)</p>";
            
            // Create customer user
            $stmt->execute(['customer1', 'customer1@example.com', $customerPassword, 'Customer One', 'customer', 'active']);
            echo "<p style='color: green;'>✓ Customer user created (username: customer1, password: customer123)</p>";
        }
        
    } else {
        echo "<p style='color: red;'>❌ Users table does not exist</p>";
        
        // Create users table
        echo "<h3>Creating users table...</h3>";
        $createTable = "
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) UNIQUE NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                full_name VARCHAR(100) NOT NULL,
                role ENUM('admin', 'customer') DEFAULT 'customer',
                status ENUM('active', 'inactive') DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";
        
        $db->exec($createTable);
        echo "<p style='color: green;'>✓ Users table created</p>";
        
        // Insert default users
        $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $customerPassword = password_hash('customer123', PASSWORD_DEFAULT);
        
        $stmt = $db->prepare("INSERT INTO users (username, email, password, full_name, role, status) VALUES (?, ?, ?, ?, ?, ?)");
        
        // Create admin user
        $stmt->execute(['admin', 'admin@baroonreptile.com', $adminPassword, 'Administrator', 'admin', 'active']);
        echo "<p style='color: green;'>✓ Admin user created (username: admin, password: admin123)</p>";
        
        // Create customer user
        $stmt->execute(['customer1', 'customer1@example.com', $customerPassword, 'Customer One', 'customer', 'active']);
        echo "<p style='color: green;'>✓ Customer user created (username: customer1, password: customer123)</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<br><a href='auth/login.php'>Go to Login Page</a>";
?>