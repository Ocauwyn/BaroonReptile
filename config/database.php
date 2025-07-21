<?php
// Konfigurasi Database Baroon Reptile

class Database {
    private $host = 'localhost';
    private $db_name = 'baroon_reptile';
    private $username = 'root';
    private $password = '';
    private $conn;
    
    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
}

// Fungsi helper untuk koneksi cepat
function getDB() {
    $database = new Database();
    return $database->getConnection();
}

// Konfigurasi aplikasi
define('BASE_URL', 'http://localhost/baroonreptil/');
define('UPLOAD_PATH', 'assets/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// Pengaturan session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>