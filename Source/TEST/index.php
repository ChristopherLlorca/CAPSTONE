<?php
// PHP Backend Logic
// This file acts as the main router for the application.
// In a real scenario, you would include database connection,
// session management, and user authentication here.

// Include database connection
// require_once 'db_connect.php';

// Define the current page from the URL query parameter, default to 'dashboard'
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LHS - Document Tracking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="?page=dashboard">
                <img src="LHS.png" alt="LHS Logo" class="me-2" style="height: 40px;">
                <span class="d-none d-sm-inline">Document Tracking System</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> Juan Dela Cruz
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="?logout=true"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse py-3" id="sidebarMenu">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?= ($page == 'dashboard') ? 'active' : ''; ?>" href="?page=dashboard">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page == 'new-document') ? 'active' : ''; ?>" href="?page=new-document">
                            <i class="bi bi-file-earmark-plus"></i> New Document
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page == 'incoming') ? 'active' : ''; ?>" href="?page=incoming">
                            <i class="bi bi-inbox"></i> Incoming
                            <span class="badge bg-danger float-end">3</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page == 'outgoing') ? 'active' : ''; ?>" href="?page=outgoing">
                            <i class="bi bi-send"></i> Outgoing
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page == 'search') ? 'active' : ''; ?>" href="?page=search">
                            <i class="bi bi-search"></i> Search
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page == 'reports') ? 'active' : ''; ?>" href="?page=reports">
                            <i class="bi bi-bar-chart"></i> Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page == 'users') ? 'active' : ''; ?>" href="?page=users">
                            <i class="bi bi-people"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page == 'archive') ? 'active' : ''; ?>" href="?page=archive">
                            <i class="bi bi-archive"></i> Archive
                        </a>
                    </li>
                </ul>
            </div>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <?php
                // Load content based on the page parameter
                switch ($page) {
                    case 'new-document':
                        include 'pages/new-document.php';
                        break;
                    case 'incoming':
                        include 'pages/incoming.php';
                        break;
                    case 'outgoing':
                        include 'pages/outgoing.php';
                        break;
                    case 'search':
                        include 'pages/search.php';
                        break;
                    case 'reports':
                        include 'pages/reports.php';
                        break;
                    case 'users':
                        include 'pages/users.php';
                        break;
                    case 'archive':
                        include 'pages/archive.php';
                        break;
                    case 'dashboard':
                    default:
                        include 'pages/dashboard.php';
                        break;
                }
                ?>
            </main>
        </div>
    </div>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <span class="text-muted">© 2023 Parañaque City Government - Document Tracking System</span>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="text-muted">Version 1.0.0</span>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>

</body>
</html>