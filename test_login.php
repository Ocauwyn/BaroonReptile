<?php
echo "<h1>Tes Diagnostik Halaman Login</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;background:#e8f5e8;padding:10px;border-radius:5px;margin:10px 0;} .error{color:red;background:#ffe8e8;padding:10px;border-radius:5px;margin:10px 0;} .info{color:blue;background:#e8f0ff;padding:10px;border-radius:5px;margin:10px 0;} .warning{color:orange;background:#fff3cd;padding:10px;border-radius:5px;margin:10px 0;}</style>";

echo "<h2>🔍 Diagnostik Sistem</h2>";

// Test 1: PHP Version
echo "<div class='info'>📋 PHP Version: " . phpversion() . "</div>";

// Test 2: Session functionality
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
echo "<div class='success'>✅ Sesi berhasil dimulai</div>";

// Test 3: Database connection
try {
    require_once 'config/database.php';
    $db = getDB();
    if ($db) {
        echo "<div class='success'>✅ Koneksi database berhasil</div>";
        
        // Test users table
        $stmt = $db->query("SHOW TABLES LIKE 'users'");
        if ($stmt->rowCount() > 0) {
            echo "<div class='success'>✅ Tabel pengguna ada</div>";
            
            // Count users
            $count_stmt = $db->query("SELECT COUNT(*) as total FROM users");
            $total_users = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'];
            echo "<div class='info'>👥 Total pengguna dalam database: $total_users</div>";
            
            // Check for admin user
            $admin_stmt = $db->query("SELECT COUNT(*) as admin_count FROM users WHERE role = 'admin'");
            $admin_count = $admin_stmt->fetch(PDO::FETCH_ASSOC)['admin_count'];
            echo "<div class='info'>👨‍💼 Pengguna admin: $admin_count</div>";
            
        } else {
            echo "<div class='error'>❌ Tabel pengguna tidak ada!</div>";
        }
    } else {
        echo "<div class='error'>❌ Koneksi database gagal</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Kesalahan database: " . $e->getMessage() . "</div>";
}

// Test 4: File permissions
echo "<h2>📁 Tes Sistem File</h2>";

$files_to_check = [
    'auth/login.php',
    'config/database.php',
    'admin/dashboard.php',
    'customer/dashboard.php'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        if (is_readable($file)) {
            echo "<div class='success'>✅ $file - ada dan dapat dibaca</div>";
        } else {
            echo "<div class='warning'>⚠️ $file - ada tapi tidak dapat dibaca</div>";
        }
    } else {
        echo "<div class='error'>❌ $file - tidak ada</div>";
    }
}

// Test 5: Server environment
echo "<h2>🖥️ Lingkungan Server</h2>";
echo "<div class='info'>🌐 Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</div>";
echo "<div class='info'>📍 Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</div>";
echo "<div class='info'>📂 Current Directory: " . getcwd() . "</div>";

// Test 6: Required PHP extensions
echo "<h2>🔧 Ekstensi PHP</h2>";
$required_extensions = ['pdo', 'pdo_mysql', 'session', 'json'];

foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<div class='success'>✅ Ekstensi $ext dimuat</div>";
    } else {
        echo "<div class='error'>❌ Ekstensi $ext tidak dimuat</div>";
    }
}

// Test 7: Try to include login.php
echo "<h2>🔗 Tes Halaman Login</h2>";
try {
    ob_start();
    $login_url = 'http://localhost/baroonreptil/auth/login.php';
    
    // Use cURL to test the login page
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $login_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HEADER, true);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            echo "<div class='error'>❌ Kesalahan cURL: $error</div>";
        } else {
            echo "<div class='info'>🌐 HTTP Response Code: $http_code</div>";
            if ($http_code == 200) {
                echo "<div class='success'>✅ Halaman login dapat diakses via HTTP</div>";
            } else {
                echo "<div class='error'>❌ Halaman login mengembalikan HTTP $http_code</div>";
            }
        }
    } else {
        echo "<div class='warning'>⚠️ cURL tidak tersedia untuk tes HTTP</div>";
    }
    
    ob_end_clean();
} catch (Exception $e) {
    ob_end_clean();
    echo "<div class='error'>❌ Kesalahan saat menguji halaman login: " . $e->getMessage() . "</div>";
}

echo "<h2>🔗 Tautan Cepat</h2>";
echo "<p><a href='auth/login.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin:5px;display:inline-block;'>🔑 Ke Halaman Login</a></p>";
echo "<p><a href='index.php' style='background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin:5px;display:inline-block;'>🏠 Ke Halaman Utama</a></p>";
echo "<p><a href='test_connection.php' style='background:#17a2b8;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin:5px;display:inline-block;'>🔍 Tes Database</a></p>";

echo "<hr><p style='color:#666;font-size:0.9em;'>Diagnostik selesai pada " . date('Y-m-d H:i:s') . "</p>";
?>