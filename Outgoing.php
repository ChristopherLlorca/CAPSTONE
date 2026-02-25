<?php
include 'db.php';
include 'header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <!-- Outgoing Documents Page -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Outgoing Documents</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Today</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Week</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Month</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Outgoing Documents</h5>
                        <form method="GET" class="input-group" style="width: 300px;">
                            <input type="text" name="search" class="form-control" placeholder="Search outgoing..." 
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
                                    <th>Student Name</th>
                                    <th>Document Type</th>
                                    <th>From School</th>
                                    <th>Current Location</th>
                                    <th>Date Created</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
                                $sql = "SELECT * FROM documents WHERE (status='Approved' OR status='Completed')";

                                if (!empty($search)) {
                                    $sql .= " AND (tracking_number LIKE '%$search%' 
                                                OR student_name LIKE '%$search%' 
                                                OR doc_type LIKE '%$search%' 
                                                OR from_school LIKE '%$search%' 
                                                OR current_location LIKE '%$search%')";
                                }

                                $sql .= " ORDER BY date_created DESC";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $status_class = 'status-pending';
                                        if ($row['status'] == 'Approved') $status_class = 'status-approved';
                                        elseif ($row['status'] == 'Completed') $status_class = 'status-completed';
                                        elseif ($row['status'] == 'Rejected') $status_class = 'status-rejected';

                                        echo '
                                        <tr>
                                            <td>' . $row['tracking_number'] . '</td>
                                            <td>' . $row['student_name'] . '</td>
                                            <td>' . $row['doc_type'] . '</td>
                                            <td>' . $row['from_school'] . '</td>
                                            <td>' . $row['current_location'] . '</td>
                                            <td>' . $row['date_created'] . '</td>
                                            <td><span class="status-badge ' . $status_class . '">' . $row['status'] . '</span></td>
                                            <td>
                                                <a href="DocumentView.php?id=' . $row['id'] . '" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                                <a href="TrackDocument.php?id=' . $row['id'] . '" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-map"></i> Track
                                                </a>
                                            </td>
                                        </tr>';
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center text-muted'>No outgoing documents found.</td></tr>";
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
