<?php
include 'db.php';
include 'header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Document Search</h1>
            </div>

            <!-- Search Form -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Advanced Search</h5>
                    <form method="GET" action="Search.php">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="searchKeywords" class="form-label">Keywords</label>
                                <input type="text" class="form-control" id="searchKeywords" name="keywords" placeholder="Enter search terms" 
                                       value="<?php echo isset($_GET['keywords']) ? htmlspecialchars($_GET['keywords']) : ''; ?>">
                            </div>

                            <div class="col-md-4">
                                <label for="searchType" class="form-label">Document Type</label>
                                <select class="form-select" id="searchType" name="type">
                                    <option value="">All Types</option>
                                    <option value="Academic Records">Academic Records</option>
                                    <option value="Enrollment Records">Enrollment Records</option>
                                    <option value="Disciplinary Records">Disciplinary Records</option>
                                    <option value="Health Records">Health Records</option>
                                    <option value="Certificate of Good Moral">Certificate of Good Moral</option>
                                    <option value="Form 137">Form 137</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="searchStatus" class="form-label">Status</label>
                                <select class="form-select" id="searchStatus" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="searchFromDate" class="form-label">From Date</label>
                                <input type="date" class="form-control" id="searchFromDate" name="from_date"
                                       value="<?php echo isset($_GET['from_date']) ? htmlspecialchars($_GET['from_date']) : ''; ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="searchToDate" class="form-label">To Date</label>
                                <input type="date" class="form-control" id="searchToDate" name="to_date"
                                       value="<?php echo isset($_GET['to_date']) ? htmlspecialchars($_GET['to_date']) : ''; ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="searchTracking" class="form-label">Tracking Number</label>
                                <input type="text" class="form-control" id="searchTracking" name="tracking" placeholder="e.g. LHS-2025-001"
                                       value="<?php echo isset($_GET['tracking']) ? htmlspecialchars($_GET['tracking']) : ''; ?>">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="Search.php" class="btn btn-outline-secondary me-2">Reset</a>
                            <button type="submit" class="btn btn-primary">Search Documents</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search Results -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Search Results</h5>
                </div>
                <div class="card-body">
                    <?php
                    $where = [];

                    if (!empty($_GET['keywords'])) {
                        $kw = $conn->real_escape_string($_GET['keywords']);
                        $where[] = "(student_name LIKE '%$kw%' OR from_school LIKE '%$kw%' OR doc_type LIKE '%$kw%' OR tracking_number LIKE '%$kw%' OR contact LIKE '%$kw%')";
                    }

                    if (!empty($_GET['type'])) {
                        $type = $conn->real_escape_string($_GET['type']);
                        $where[] = "doc_type LIKE '%$type%'";
                    }

                    if (!empty($_GET['status'])) {
                        $status = $conn->real_escape_string($_GET['status']);
                        $where[] = "status = '$status'";
                    }

                    if (!empty($_GET['from_date'])) {
                        $from = $conn->real_escape_string($_GET['from_date']);
                        $where[] = "date_created >= '$from'";
                    }

                    if (!empty($_GET['to_date'])) {
                        $to = $conn->real_escape_string($_GET['to_date']);
                        $where[] = "date_created <= '$to'";
                    }

                    if (!empty($_GET['tracking'])) {
                        $track = $conn->real_escape_string($_GET['tracking']);
                        $where[] = "tracking_number LIKE '%$track%'";
                    }

                    $sql = "SELECT * FROM documents";
                    if (!empty($where)) {
                        $sql .= " WHERE " . implode(" AND ", $where);
                    }
                    $sql .= " ORDER BY date_created DESC";

                    $result = $conn->query($sql);

                    if (!empty($_GET)) {
                        if ($result && $result->num_rows > 0) {
                            echo '<div class="table-responsive">';
                            echo '<table class="table table-hover align-middle">';
                            echo '<thead><tr>
                                    <th>Tracking #</th>
                                    <th>Student Name</th>
                                    <th>Document Type</th>
                                    <th>From School</th>
                                    <th>Date Created</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                  </tr></thead><tbody>';

                            while ($row = $result->fetch_assoc()) {
                                $status_class = 'status-pending';
                                if ($row['status'] == 'Approved') $status_class = 'status-approved';
                                elseif ($row['status'] == 'Completed') $status_class = 'status-completed';
                                elseif ($row['status'] == 'Rejected') $status_class = 'status-rejected';

                                echo "
                                <tr>
                                    <td>{$row['tracking_number']}</td>
                                    <td>{$row['student_name']}</td>
                                    <td>{$row['doc_type']}</td>
                                    <td>{$row['from_school']}</td>
                                    <td>{$row['date_created']}</td>
                                    <td><span class='status-badge $status_class'>{$row['status']}</span></td>
                                    <td>
                                        <a href='DocumentView.php?id={$row['id']}' class='btn btn-sm btn-outline-primary'>
                                            <i class='bi bi-eye'></i> View
                                        </a>
                                    </td>
                                </tr>";
                            }

                            echo '</tbody></table></div>';
                        } else {
                            echo "<div class='alert alert-warning'><i class='bi bi-exclamation-circle'></i> No documents found matching your search criteria.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-info'><i class='bi bi-info-circle'></i> Enter search criteria above to find documents.</div>";
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'footer.php'; ?>
