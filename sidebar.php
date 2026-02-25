<?php
// Ensure database connection
include_once 'db.php';

// Query document counts by status
$pendingCount   = $conn->query("SELECT COUNT(*) AS total FROM documents WHERE status = 'Pending'")->fetch_assoc()['total'];
$approvedCount  = $conn->query("SELECT COUNT(*) AS total FROM documents WHERE status = 'Approved'")->fetch_assoc()['total'];
$completedCount = $conn->query("SELECT COUNT(*) AS total FROM documents WHERE status = 'Completed'")->fetch_assoc()['total'];
$rejectedCount  = $conn->query("SELECT COUNT(*) AS total FROM documents WHERE status = 'Rejected'")->fetch_assoc()['total'];
?>

<div class="col-md-3 col-lg-2 d-md-block sidebar collapse py-3 bg-white" id="sidebarMenu">
    <ul class="nav flex-column">

        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'Dashboard.php' ? 'active' : ''; ?>" href="Dashboard.php">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'NewDocument.php' ? 'active' : ''; ?>" href="NewDocument.php">
                <i class="bi bi-file-earmark-plus"></i> New Document
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'Incoming.php' ? 'active' : ''; ?>" href="Incoming.php">
                <i class="bi bi-inbox"></i> Incoming
                <?php if ($pendingCount > 0): ?>
                    <span class="badge bg-danger float-end"><?php echo $pendingCount; ?></span>
                <?php endif; ?>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'Outgoing.php' ? 'active' : ''; ?>" href="Outgoing.php">
                <i class="bi bi-send"></i> Outgoing
                <?php if ($approvedCount > 0): ?>
                    <span class="badge bg-primary float-end"><?php echo $approvedCount; ?></span>
                <?php endif; ?>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'Search.php' ? 'active' : ''; ?>" href="Search.php">
                <i class="bi bi-search"></i> Search
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'Reports.php' ? 'active' : ''; ?>" href="Reports.php">
                <i class="bi bi-bar-chart"></i> Reports
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'Users.php' ? 'active' : ''; ?>" href="Users.php">
                <i class="bi bi-people"></i> Users
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'Archive.php' ? 'active' : ''; ?>" href="Archive.php">
                <i class="bi bi-archive"></i> Archive
                <?php if ($completedCount > 0): ?>
                    <span class="badge bg-success float-end"><?php echo $completedCount; ?></span>
                <?php endif; ?>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-danger <?php echo basename($_SERVER['PHP_SELF']) == 'Rejected.php' ? 'active' : ''; ?>" href="Rejected.php">
                <i class="bi bi-x-circle"></i> Rejected
                <?php if ($rejectedCount > 0): ?>
                    <span class="badge bg-danger float-end"><?php echo $rejectedCount; ?></span>
                <?php endif; ?>
            </a>
        </li>

    </ul>
</div>
