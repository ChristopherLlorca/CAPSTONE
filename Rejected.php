<?php
include 'db.php';
include 'header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <!-- Rejected Documents Page -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 text-danger">Rejected Documents</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">List of Rejected Documents</h5>
                        <form method="GET" class="input-group" style="width: 300px;">
                            <input type="text" name="search" class="form-control" placeholder="Search rejected..." 
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
                            <thead class="table-danger">
                                <tr>
                                    <th>Tracking #</th>
                                    <th>Student Name</th>
                                    <th>Document Type</th>
                                    <th>From School</th>
                                    <th>Date Created</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Build query
                                $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
                                $sql = "SELECT * FROM documents WHERE status='Rejected'";

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
                                            <td>{$row['student_name']}</td>
                                            <td>{$row['doc_type']}</td>
                                            <td>{$row['from_school']}</td>
                                            <td>{$row['date_created']}</td>
                                            <td><span class='status-badge status-rejected'>{$row['status']}</span></td>
                                            <td>
                                                <a href='DocumentView.php?id={$row['id']}' class='btn btn-sm btn-outline-danger'>
                                                    <i class='bi bi-eye'></i> View
                                                </a>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center text-muted'>No rejected documents found.</td></tr>";
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
