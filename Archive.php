<?php
include 'db.php';
include 'header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <!-- Archive Page -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Document Archive</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">2025</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">2024</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">2023</button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Archived Documents</h5>
                        <form method="GET" class="input-group" style="width: 300px;">
                            <input type="text" name="search" class="form-control" placeholder="Search archive..." 
                                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Tracking #</th>
                                    <th>Document Type</th>
                                    <th>Student Name</th>
                                    <th>Date Archived</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Search
                                $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
                                $sql = "SELECT * FROM documents WHERE status='Completed'";

                                if (!empty($search)) {
                                    $sql .= " AND (tracking_number LIKE '%$search%' 
                                                OR student_name LIKE '%$search%' 
                                                OR doc_type LIKE '%$search%' 
                                                OR from_school LIKE '%$search%')";
                                }

                                $sql .= " ORDER BY date_created DESC";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "
                                        <tr>
                                            <td>{$row['tracking_number']}</td>
                                            <td>{$row['doc_type']}</td>
                                            <td>{$row['student_name']}</td>
                                            <td>{$row['date_created']}</td>
                                            <td><span class='status-badge status-completed'>{$row['status']}</span></td>
                                            <td>
                                                <form method='POST' action='' onsubmit='return confirm(\"Retrieve this document?\");'>
                                                    <input type='hidden' name='doc_id' value='{$row['id']}'>
                                                    <button type='submit' name='retrieve' class='btn btn-sm btn-outline-primary'>
                                                        <i class='bi bi-arrow-counterclockwise'></i> Retrieve
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center text-muted'>No archived documents found.</td></tr>";
                                }

                                // Handle "Retrieve"
                                if (isset($_POST['retrieve'])) {
                                    $doc_id = intval($_POST['doc_id']);
                                    $update = "UPDATE documents SET status='Pending' WHERE id=$doc_id";
                                    if ($conn->query($update)) {
                                        echo "<script>alert('Document retrieved successfully!'); window.location='Archive.php';</script>";
                                    } else {
                                        echo "<script>alert('Error retrieving document.');</script>";
                                    }
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
