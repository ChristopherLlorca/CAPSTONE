<?php
include 'db.php';
include 'header.php';

$sql = "SELECT * FROM documents WHERE status = 'Pending' ORDER BY date_created DESC";
$result = $conn->query($sql);
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Incoming Documents</h1>
                <a href="NewDocument.php" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Add New
                </a>
            </div>

            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-dark">Pending Document Requests</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tracking #</th>
                                    <th>Document Type</th>
                                    <th>Student Name</th>
                                    <th>Date Received</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "
                                        <tr>
                                            <td><span class='fw-bold text-primary'>{$row['tracking_number']}</span></td>
                                            <td>{$row['doc_type']}</td>
                                            <td>{$row['student_name']}</td>
                                            <td>
                                                <div class='fw-bold'>" . date('M d, Y', strtotime($row['date_created'])) . "</div>
                                                <small class='text-muted'><i class='bi bi-clock'></i> " . date('h:i A', strtotime($row['date_created'])) . "</small>
                                            </td>
                                            <td><span class='badge bg-warning text-dark'>{$row['status']}</span></td>
                                            <td class='text-center'>
                                                <a href='DocumentView.php?id={$row['id']}' class='btn btn-sm btn-outline-primary'>
                                                    <i class='bi bi-eye'></i> View Details
                                                </a>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center text-muted py-4'>No pending documents found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php include 'footer.php'; ?>