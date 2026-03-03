<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Document Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="login.php">
                <img src="lhs-reglogo.png" alt="LHS Logo" style="height: 40px;">
                <span class="ms-2">LHS - Document Tracking System</span>
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Document Tracking</h1>
        <div class="search-section text-center my-4">
            <form method="POST" action="">
                <label for="trackingNo" class="form-label fw-bold">Enter Tracking Number:</label>
                <div class="input-group justify-content-center">
                    <input type="text" id="trackingNo" name="trackingNo" class="form-control" style="max-width: 300px;" placeholder="e.g., LHS_..." value="<?php echo isset($_POST['trackingNo']) ? htmlspecialchars($_POST['trackingNo']) : ''; ?>" required>
                    <button class="btn btn-primary" type="submit">Track Document</button>
                </div>
            </form>
        </div>

        <?php
        include 'db.php'; 

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trackingNo'])) {
            $trackingNo = trim($_POST['trackingNo']);
            
            if (empty($trackingNo)) {
                echo '<div class="alert alert-danger text-center">Please enter a tracking number.</div>';
            } else {
                $stmt = $conn->prepare("SELECT * FROM documents WHERE tracking_number = ?");
                $stmt->bind_param("s", $trackingNo);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $doc = $result->fetch_assoc();
                    ?>
                    <div class="alert alert-success text-center shadow-sm">
                        Document Found for Tracking No: <strong><?php echo htmlspecialchars($trackingNo); ?></strong>
                    </div>
                    <table class="table table-bordered table-striped mt-4 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Tracking Number</th>
                                <th>Student ID</th> 
                                <th>Student Name</th>
                                <th>Document Type</th>
                                <th>Current Status</th>
                                <th>Current Location</th>
                                <th>Date & Time Requested</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($doc['tracking_number']); ?></td>
                                <td><?php echo htmlspecialchars($doc['student_id']); ?></td> 
                                <td><?php echo htmlspecialchars($doc['student_name']); ?></td>
                                <td><?php echo htmlspecialchars($doc['doc_type']); ?></td>
                                <td>
                                    <span class="badge" style="background-color: 
                                        <?php 
                                        switch($doc['status']) {
                                            case 'Completed': echo '#28a745'; break;
                                            case 'Pending': echo '#ffc107'; break;
                                            case 'Rejected': echo '#dc3545'; break;
                                            case 'Approved': echo '#198754'; break;
                                            default: echo '#6c757d';
                                        }
                                        ?>;">
                                        <?php echo htmlspecialchars($doc['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($doc['current_location']); ?></td>
                                <td>
                                    <strong><?php echo date('F j, Y', strtotime($doc['date_created'])); ?></strong><br>
                                    <small class="text-muted"><i class="bi bi-clock"></i> <?php echo date('g:i a', strtotime($doc['date_created'])); ?></small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo '<div class="alert alert-warning text-center">No records found for tracking number: ' . htmlspecialchars($trackingNo) . '</div>';
                }
                $stmt->close();
            }
        }
        ?>
    </div>
</body>
</html>