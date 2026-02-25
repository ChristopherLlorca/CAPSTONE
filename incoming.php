<?php
include 'db.php';
include 'header.php';

// Fetch all documents from database (you can later filter by status = 'Pending' or 'Incoming')
$sql = "SELECT * FROM documents ORDER BY id DESC";
$result = $conn->query($sql);
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        
                <?php include 'sidebar.php'; ?>

                
    

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Incoming Documents</h1>
                <a href="NewDocument.php" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Add New
                </a>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Incoming Documents</h5>
                    <form class="d-flex" method="GET" action="">
                        <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search...">
                        <button class="btn btn-sm btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Tracking #</th>
                                    <th>Document Type</th>
                                    <th>Student Name</th>
                                    <th>Grade & Section</th>
                                    <th>From School</th>
                                    <th>Date Created</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $status_class = 'status-pending';
                                        if ($row['status'] == 'Approved') $status_class = 'status-approved';
                                        elseif ($row['status'] == 'Rejected') $status_class = 'status-rejected';
                                        elseif ($row['status'] == 'Completed') $status_class = 'status-completed';

                                        echo "
                                        <tr>
                                            <td>{$row['tracking_number']}</td>
                                            <td>{$row['doc_type']}</td>
                                            <td>{$row['student_name']}</td>
                                            <td>{$row['grade_section']}</td>
                                            <td>{$row['from_school']}</td>
                                            <td>{$row['date_created']}</td>
                                            <td><span class='status-badge $status_class'>{$row['status']}</span></td>
                                            <td>
                                                <a href='DocumentView.php?id={$row['id']}' class='btn btn-sm btn-outline-primary'>
                                                    <i class='bi bi-eye'></i> View
                                                </a>
                                            </td>
                                        </tr>
                                        ";
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center text-muted'>No incoming documents found.</td></tr>";
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
