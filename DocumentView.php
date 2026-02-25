<?php
include 'db.php';
include 'header.php';

// Check if "id" is passed in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='alert alert-danger text-center mt-5'>No document selected.</div>";
    include 'footer.php';
    exit;
}

// Get document ID safely
$doc_id = intval($_GET['id']);
$sql = "SELECT * FROM documents WHERE id = $doc_id";
$result = $conn->query($sql);

// If not found, show error message

$doc = $result->fetch_assoc();
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Document Details</h1>
                <a href="Incoming.php" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back to Incoming
                </a>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="mb-3 text-primary"><?php echo htmlspecialchars($doc['tracking_number']); ?></h4>

                    <table class="table table-borderless">
                        <tr>
                            <th>Student Name:</th>
                            <td><?php echo htmlspecialchars($doc['student_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Grade & Section:</th>
                            <td><?php echo htmlspecialchars($doc['grade_section']); ?></td>
                        </tr>
                        <tr>
                            <th>Contact:</th>
                            <td><?php echo htmlspecialchars($doc['contact']); ?></td>
                        </tr>
                        <tr>
                            <th>From School:</th>
                            <td><?php echo htmlspecialchars($doc['from_school']); ?></td>
                        </tr>
                        <tr>
                            <th>Document Type:</th>
                            <td><?php echo htmlspecialchars($doc['doc_type']); ?></td>
                        </tr>
                        <tr>
                            <th>Date Created:</th>
                            <td><?php echo htmlspecialchars($doc['date_created']); ?></td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <?php
                                $status_class = 'status-pending';
                                if ($doc['status'] == 'Approved') $status_class = 'status-approved';
                                elseif ($doc['status'] == 'Rejected') $status_class = 'status-rejected';
                                elseif ($doc['status'] == 'Completed') $status_class = 'status-completed';
                                ?>
                                <span class="status-badge <?php echo $status_class; ?>">
                                    <?php echo htmlspecialchars($doc['status']); ?>
                                </span>
                            </td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-end mt-4">
                        <form action="" method="POST">
                            <button type="submit" name="approve" class="btn btn-success me-2">
                                <i class="bi bi-check2-circle"></i> Approve
                            </button>
                            <button type="submit" name="complete" class="btn btn-info me-2">
                                <i class="bi bi-clipboard-check"></i> Complete
                            </button>
                            <button type="submit" name="reject" class="btn btn-danger">
                                <i class="bi bi-x-circle"></i> Reject
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php
// Handle status updates when form buttons are clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['approve'])) {
        $conn->query("UPDATE documents SET status='Approved' WHERE id=$doc_id");
        echo "<script>alert('Document marked as Approved'); window.location='DocumentView.php?id=$doc_id';</script>";
    } elseif (isset($_POST['complete'])) {
        $conn->query("UPDATE documents SET status='Completed' WHERE id=$doc_id");
        echo "<script>alert('Document marked as Completed'); window.location='DocumentView.php?id=$doc_id';</script>";
    } elseif (isset($_POST['reject'])) {
        $conn->query("UPDATE documents SET status='Rejected' WHERE id=$doc_id");
        echo "<script>alert('Document marked as Rejected'); window.location='DocumentView.php?id=$doc_id';</script>";
    }
}

include 'footer.php';
?>
