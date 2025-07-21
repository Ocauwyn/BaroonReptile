<?php
/**
 * Baroon Reptile - Backup Script
 * This script creates backups of database and files
 * Run this script manually or via cron job
 */

// Security check - only allow access from localhost
if (!in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    die('Access denied. This script can only be run from localhost.');
}

// Include database configuration
require_once 'config/database.php';

// Set timezone
date_default_timezone_set('Asia/Jakarta');

// Backup directory
$backupDir = __DIR__ . '/backups';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}

// Current timestamp
$timestamp = date('Y-m-d_H-i-s');

/**
 * Create database backup
 */
function createDatabaseBackup($host, $username, $password, $database, $backupDir, $timestamp) {
    $backupFile = $backupDir . '/db_backup_' . $timestamp . '.sql';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Get all tables
        $tables = [];
        $result = $pdo->query('SHOW TABLES');
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            $tables[] = $row[0];
        }
        
        $sql = "-- Baroon Reptile Database Backup\n";
        $sql .= "-- Generated on: " . date('Y-m-d H:i:s') . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";
        
        foreach ($tables as $table) {
            // Get table structure
            $result = $pdo->query("SHOW CREATE TABLE `$table`");
            $row = $result->fetch(PDO::FETCH_NUM);
            $sql .= "DROP TABLE IF EXISTS `$table`;\n";
            $sql .= $row[1] . ";\n\n";
            
            // Get table data
            $result = $pdo->query("SELECT * FROM `$table`");
            if ($result->rowCount() > 0) {
                $sql .= "INSERT INTO `$table` VALUES\n";
                $rows = [];
                while ($row = $result->fetch(PDO::FETCH_NUM)) {
                    $row = array_map(function($value) use ($pdo) {
                        return $value === null ? 'NULL' : $pdo->quote($value);
                    }, $row);
                    $rows[] = '(' . implode(', ', $row) . ')';
                }
                $sql .= implode(",\n", $rows) . ";\n\n";
            }
        }
        
        $sql .= "SET FOREIGN_KEY_CHECKS = 1;\n";
        
        file_put_contents($backupFile, $sql);
        return $backupFile;
        
    } catch (Exception $e) {
        throw new Exception('Database backup failed: ' . $e->getMessage());
    }
}

/**
 * Create files backup
 */
function createFilesBackup($sourceDir, $backupDir, $timestamp) {
    $backupFile = $backupDir . '/files_backup_' . $timestamp . '.zip';
    
    if (!class_exists('ZipArchive')) {
        throw new Exception('ZipArchive class not found. Please install php-zip extension.');
    }
    
    $zip = new ZipArchive();
    if ($zip->open($backupFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
        throw new Exception('Cannot create zip file: ' . $backupFile);
    }
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($iterator as $file) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($sourceDir) + 1);
        
        // Skip backup directory and sensitive files
        if (strpos($relativePath, 'backups') === 0 || 
            strpos($relativePath, '.git') === 0 ||
            strpos($relativePath, 'backup.php') !== false) {
            continue;
        }
        
        if ($file->isDir()) {
            $zip->addEmptyDir($relativePath);
        } else {
            $zip->addFile($filePath, $relativePath);
        }
    }
    
    $zip->close();
    return $backupFile;
}

/**
 * Clean old backups (keep only last 5)
 */
function cleanOldBackups($backupDir) {
    $files = glob($backupDir . '/*_backup_*.{sql,zip}', GLOB_BRACE);
    if (count($files) > 10) { // Keep 5 database + 5 files backups
        usort($files, function($a, $b) {
            return filemtime($a) - filemtime($b);
        });
        
        $filesToDelete = array_slice($files, 0, count($files) - 10);
        foreach ($filesToDelete as $file) {
            unlink($file);
        }
    }
}

// HTML Output
?><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup System - Baroon Reptile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="fas fa-database me-2"></i>Backup System</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
                            try {
                                if ($_POST['action'] === 'database') {
                                    echo '<div class="alert alert-info"><i class="fas fa-spinner fa-spin me-2"></i>Creating database backup...</div>';
                                    $dbBackup = createDatabaseBackup(DB_HOST, DB_USER, DB_PASS, DB_NAME, $backupDir, $timestamp);
                                    echo '<div class="alert alert-success"><i class="fas fa-check me-2"></i>Database backup created: ' . basename($dbBackup) . '</div>';
                                    
                                } elseif ($_POST['action'] === 'files') {
                                    echo '<div class="alert alert-info"><i class="fas fa-spinner fa-spin me-2"></i>Creating files backup...</div>';
                                    $filesBackup = createFilesBackup(__DIR__, $backupDir, $timestamp);
                                    echo '<div class="alert alert-success"><i class="fas fa-check me-2"></i>Files backup created: ' . basename($filesBackup) . '</div>';
                                    
                                } elseif ($_POST['action'] === 'full') {
                                    echo '<div class="alert alert-info"><i class="fas fa-spinner fa-spin me-2"></i>Creating full backup...</div>';
                                    $dbBackup = createDatabaseBackup(DB_HOST, DB_USER, DB_PASS, DB_NAME, $backupDir, $timestamp);
                                    $filesBackup = createFilesBackup(__DIR__, $backupDir, $timestamp);
                                    echo '<div class="alert alert-success"><i class="fas fa-check me-2"></i>Full backup created:<br>';
                                    echo '- Database: ' . basename($dbBackup) . '<br>';
                                    echo '- Files: ' . basename($filesBackup) . '</div>';
                                }
                                
                                cleanOldBackups($backupDir);
                                
                            } catch (Exception $e) {
                                echo '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Error: ' . $e->getMessage() . '</div>';
                            }
                        }
                        ?>
                        
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <button type="submit" name="action" value="database" class="btn btn-primary w-100">
                                        <i class="fas fa-database me-2"></i>Backup Database
                                    </button>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <button type="submit" name="action" value="files" class="btn btn-warning w-100">
                                        <i class="fas fa-folder me-2"></i>Backup Files
                                    </button>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <button type="submit" name="action" value="full" class="btn btn-success w-100">
                                        <i class="fas fa-download me-2"></i>Full Backup
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <hr>
                        
                        <h5>Existing Backups:</h5>
                        <?php
                        $backupFiles = glob($backupDir . '/*_backup_*.{sql,zip}', GLOB_BRACE);
                        if (empty($backupFiles)) {
                            echo '<p class="text-muted">No backups found.</p>';
                        } else {
                            usort($backupFiles, function($a, $b) {
                                return filemtime($b) - filemtime($a);
                            });
                            
                            echo '<div class="table-responsive">';
                            echo '<table class="table table-sm">';
                            echo '<thead><tr><th>File</th><th>Size</th><th>Date</th></tr></thead><tbody>';
                            
                            foreach ($backupFiles as $file) {
                                $filename = basename($file);
                                $size = formatBytes(filesize($file));
                                $date = date('Y-m-d H:i:s', filemtime($file));
                                $icon = strpos($filename, 'db_backup') !== false ? 'fas fa-database' : 'fas fa-folder';
                                
                                echo "<tr><td><i class='$icon me-2'></i>$filename</td><td>$size</td><td>$date</td></tr>";
                            }
                            
                            echo '</tbody></table></div>';
                        }
                        
                        function formatBytes($size, $precision = 2) {
                            $units = array('B', 'KB', 'MB', 'GB', 'TB');
                            for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
                                $size /= 1024;
                            }
                            return round($size, $precision) . ' ' . $units[$i];
                        }
                        ?>
                        
                        <div class="mt-3">
                            <a href="/baroonreptil/" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>