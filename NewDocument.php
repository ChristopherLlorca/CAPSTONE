<?php
include 'db.php';
include 'header.php';

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tracking_number = $_POST['tracking_number'];
    $doc_type = $_POST['doc_type'];
    $student_name = $_POST['student_name'];
    $grade_section = $_POST['grade_section'];
    $contact = $_POST['contact'];
    $from_school = $_POST['from_school'];
    $current_location = $_POST['current_location'];
    $date_created = date('Y-m-d');
    $status = "Pending";

    // Handle file upload
    $file_name = '';
    if (isset($_FILES['document_file']) && $_FILES['document_file']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $file_name = basename($_FILES['document_file']['name']);
        $target_file = $target_dir . $file_name;
        move_uploaded_file($_FILES['document_file']['tmp_name'], $target_file);
    }

    $sql = "INSERT INTO documents 
            (tracking_number, doc_type, student_name, grade_section, contact, from_school, date_created, status, current_location, document_file)
            VALUES 
            ('$tracking_number', '$doc_type', '$student_name', '$grade_section', '$contact', '$from_school', '$date_created', '$status', '$current_location', '$file_name')";

    if ($conn->query($sql)) {
        $message = "<div class='alert alert-success'>Document successfully added!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="border-bottom mb-3 pb-2">
                <h1 class="h2">New Document</h1>
            </div>

            <?php echo $message; ?>

            <div class="card p-4 shadow-sm">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Tracking Number</label>
                        <input type="text" name="tracking_number" class="form-control" placeholder="e.g., LHS-2025-001" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Document Type</label>
                        <select name="doc_type" class="form-select" required>
                            <option value="">Select Document Type</option>
                            <option value="Academic Records">Academic Records</option>
                            <option value="Enrollment Records">Enrollment Records</option>
                            <option value="Disciplinary Records">Disciplinary Records</option>
                            <option value="Health Records">Health Records</option>
                            <option value="Certificate of Good Moral">Certificate of Good Moral</option>
                            <option value="Form 137">Form 137</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Student Name</label>
                        <input type="text" name="student_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Grade & Section</label>
                        <input type="text" name="grade_section" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact</label>
                        <input type="text" name="contact" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">From School</label>
                        <input type="text" name="from_school" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Current Location</label>
                        <input type="text" name="current_location" class="form-control" value="Registrar" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Attach File</label>
                        <input type="file" name="document_file" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Save Document
                    </button>
                </form>
            </div>
        </main>
    </div>
</div>

<?php include 'footer.php'; ?>
