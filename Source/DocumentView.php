<?php
include 'db.php';
include 'header.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='alert alert-danger text-center mt-5'>No document selected.</div>";
    include 'footer.php';
    exit;
}

$doc_id = intval($_GET['id']);
$sql = "SELECT * FROM documents WHERE id = $doc_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<div class='alert alert-danger text-center mt-5'>Document not found.</div>";
    include 'footer.php';
    exit;
}

$doc = $result->fetch_assoc();

// HANDLE STATUS UPDATES
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['approve'])) {
        // Sets status to 'Approved' so it appears in Archive.php
        $conn->query("UPDATE documents SET status='Approved' WHERE id=$doc_id");
        echo "<script>alert('Document Approved and Moved to Archive'); window.location='incoming.php';</script>";
    } elseif (isset($_POST['mark_final_complete'])) {
        // Sets status to 'Completed' when viewed from Outgoing page
        $conn->query("UPDATE documents SET status='Completed' WHERE id=$doc_id");
        echo "<script>alert('Document status finalized as Completed'); window.location='Outgoing.php';</script>";
    } elseif (isset($_POST['reject'])) {
        $conn->query("UPDATE documents SET status='Rejected' WHERE id=$doc_id");
        echo "<script>alert('Document Rejected'); window.location='Rejected.php';</script>";
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h1 class="h2 border-bottom pb-2">Document Details</h1>

            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0 text-primary"><?php echo htmlspecialchars($doc['tracking_number']); ?></h4>
                        <?php
                            $status_badge = 'bg-warning text-dark';
                            if ($doc['status'] == 'Approved') $status_badge = 'bg-success';
                            if ($doc['status'] == 'Out Going') $status_badge = 'bg-info text-dark';
                            if ($doc['status'] == 'Completed') $status_badge = 'bg-dark';
                        ?>
                        <span class="badge <?php echo $status_badge; ?> p-2 px-3"><?php echo $doc['status']; ?></span>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Student Name:</strong> <?php echo htmlspecialchars($doc['student_name']); ?></p>
                            <p><strong>Student ID:</strong> <?php echo htmlspecialchars($doc['student_id']); ?></p>
                        </div>
                    </div>

                    <div class="mt-4 border-top pt-4 text-center">
                        <?php if(!empty($doc['document_file'])): ?>
                            <img src="uploads/<?php echo $doc['document_file']; ?>" class="img-fluid rounded border" style="max-height: 500px;">
                        <?php else: ?>
                            <div class="alert alert-light border py-5">No digital file attached.</div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-end mt-4 gap-2">
                        <form action="" method="POST">
                            <?php if($doc['status'] == 'Pending'): ?>
                                <button type="submit" name="approve" class="btn btn-success">Approve & Archive</button>
                                <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                            <?php endif; ?>

                            <?php if($doc['status'] == 'Out Going'): ?>
                                <button type="submit" name="mark_final_complete" class="btn btn-dark">Mark as Completed</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php include 'footer.php'; ?>