<?php
include 'db.php';
include 'header.php';

$message = '';
// Generate a unique tracking number
$auto_tracking = "LHS_" . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tracking_number = $_POST['tracking_number'];
    $doc_type = $_POST['doc_type'];
    $student_id = $_POST['student_id']; 
    $student_name = $_POST['student_name']; 
    $grade_section = $_POST['grade_section'];
    $contact = $_POST['contact'];
    $from_school = $_POST['from_school'];
    $current_location = "Registrar";
    
    // AUTOMATIC DATE AND TIME
    $date_created = date('Y-m-d H:i:s'); 
    $status = "Pending"; 

    // --- STEP 1: AUTOMATIC STUDENT REGISTRATION OR UPDATE ---
    $stmtCheck = $conn->prepare("SELECT student_id FROM students WHERE student_id = ?");
    $stmtCheck->bind_param("s", $student_id); 
    $stmtCheck->execute();
    $checkStudent = $stmtCheck->get_result();
    
    if ($checkStudent->num_rows == 0) {
        $name_parts = explode(' ', $student_name, 2);
        $fname = $name_parts[0];
        $lname = isset($name_parts[1]) ? $name_parts[1] : 'N/A';
        
        $stmtIns = $conn->prepare("INSERT INTO students (student_id, firstname, lastname, age, date_created) VALUES (?, ?, ?, '0', ?)");
        $stmtIns->bind_param("ssss", $student_id, $fname, $lname, $date_created);
        $stmtIns->execute();
    } else {
        // Refresh the student record timestamp
        $stmtUpdateStudent = $conn->prepare("UPDATE students SET date_created = ? WHERE student_id = ?");
        $stmtUpdateStudent->bind_param("ss", $date_created, $student_id);
        $stmtUpdateStudent->execute();
    }

    // --- STEP 2: HANDLE FILE UPLOAD ---
    $file_name = "";
    if (isset($_FILES['document_file']) && $_FILES['document_file']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . "_" . basename($_FILES["document_file"]["name"]);
        move_uploaded_file($_FILES["document_file"]["tmp_name"], $target_dir . $file_name);
    }

    // --- STEP 3: SAVE DOCUMENT ---
    $sql = "INSERT INTO documents (tracking_number, doc_type, student_id, student_name, grade_section, contact, from_school, date_created, status, current_location, file_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss", $tracking_number, $doc_type, $student_id, $student_name, $grade_section, $contact, $from_school, $date_created, $status, $current_location, $file_name);

    if ($stmt->execute()) {
        $message = "success";
    } else {
        $message = "error";
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h1 class="h2 border-bottom pb-2">File a New Document</h1>

            <?php if ($message == 'success'): ?>
                <div class="alert alert-success shadow-sm">Document filed successfully! Tracking No: <strong><?php echo $tracking_number; ?></strong></div>
            <?php elseif ($message == 'error'): ?>
                <div class="alert alert-danger shadow-sm">Error saving document. Please try again.</div>
            <?php endif; ?>

            <div class="card shadow-sm p-4 border-0">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Student ID / LRN</label>
                            <input type="text" name="student_id" class="form-control" placeholder="Enter ID Number" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" name="student_name" class="form-control" placeholder="Firstname Lastname" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Contact Number</label>
                            <input type="text" name="contact" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">From School</label>
                            <input type="text" name="from_school" class="form-control" value="N/A">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Document Type</label>
                            <select name="doc_type" class="form-select" required>
                                <option value="" disabled selected>Select Document</option>
                                <option value="Birth Certificate">Birth Certificate</option>
                                <option value="Form 137">Form 137</option>
                                <option value="Report Card">Report Card</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Grade & Section</label>
                            <input type="text" name="grade_section" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tracking Number</label>
                            <input type="text" name="tracking_number" class="form-control bg-light" value="<?php echo $auto_tracking; ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-success">Attach Digital Copy</label>
                            <input type="file" name="document_file" class="form-control" accept="image/*,application/pdf" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3 py-2 fw-bold">Save and Send to Incoming</button>
                </form>
            </div>
        </main>
    </div>
</div>
<?php include 'footer.php'; ?>