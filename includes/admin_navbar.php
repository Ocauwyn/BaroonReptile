<?php
// Get current page name for active menu highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">
            <i class="fas fa-paw me-2"></i>Baroon Reptile Admin
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'reptiles.php' ? 'active' : ''; ?>" href="reptiles.php">
                        <i class="fas fa-dragon me-1"></i>Reptil
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'bookings.php' ? 'active' : ''; ?>" href="bookings.php">
                        <i class="fas fa-calendar-alt me-1"></i>Booking
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo in_array($current_page, ['payments.php', 'view_payment.php', 'edit_payment.php', 'print_receipt.php']) ? 'active' : ''; ?>" href="payments.php">
                        <i class="fas fa-credit-card me-1"></i>Pembayaran
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'customers.php' ? 'active' : ''; ?>" href="customers.php">
                        <i class="fas fa-users me-1"></i>Pelanggan
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'facilities.php' ? 'active' : ''; ?>" href="facilities.php">
                        <i class="fas fa-building me-1"></i>Fasilitas
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'reports.php' ? 'active' : ''; ?>" href="reports.php">
                        <i class="fas fa-chart-bar me-1"></i>Laporan
                    </a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i>
                        <?php echo isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : 'Admin'; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="settings.php">
                                <i class="fas fa-cog me-2"></i>Pengaturan
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="../auth/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i>Keluar
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>