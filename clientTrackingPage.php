<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Document Tracker</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0056b3;
            --secondary-color: #e9ecef;
        }
 .navbar-brand img {
            height: 40px;
        }
        .sidebar {
            background-color: white;
            min-height: calc(100vh - 56px);
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: #495057;
            border-radius: 5px;
            margin: 2px 0;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }

        body {          
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .search-section {
            margin-bottom: 20px;
            text-align: center;
        }
        input[type="text"] {
            padding: 10px;
            width: 200px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .no-results {
            text-align: center;
            color: #888;
            margin-top: 20px;
        }
        .error {
            text-align: center;
            color: #dc3545;
            margin-top: 10px;
            padding: 10px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
        }
        .success {
            text-align: center;
            color: #155724;
            margin-top: 10px;
            padding: 10px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
        }

        
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand"  href="login.php">
                <img src="lhs-reglogo.png" alt="LHS Logo">
                <span class="ms-2">LHS - Document Tracking System</span>
            </a>
        </div>
    </nav>

    <div class="container">
        <h1>Student Document Tracker</h1>
        <div class="search-section">
            <form method="POST" action="">
                <label for="studentId">Enter Student ID:</label>
                <input type="text" id="studentId" name="studentId" placeholder="e.g., 12345" value="<?php echo isset($_POST['studentId']) ? htmlspecialchars($_POST['studentId']) : ''; ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <?php
        // Example lang to dapat yung data na galing sa db yung lalabas dito
        $studentData = [
            "12345" => [
                "name" => "Christopher Llorca",
                "documents" => [
                    ["type" => "Form 137", "status" => "Approved", "date" => "2025-10-01"],
                    ["type" => "Diploma", "status" => "Pending", "date" => "2025-09-15"]
                ]
            ],
            "67890" => [
                "name" => "Christian Camacho",
                "documents" => [
                    ["type" => "Diploma", "status" => "Approved", "date" => "2025-08-20"]
                ]
            ],
            "11111" => [
                "name" => "Raphael Ong",
                "documents" => [
                    ["type" => "Form 137", "status" => "Rejected", "date" => "2025-07-10"],
                    ["type" => "Good Moral", "status" => "Approved", "date" => "2025-06-05"]
                ]
            ],
            "22222" => [
                "name" => "Aiden Ignacio",
                "documents" => [
                    ["type" => "Form 138", "status" => "Approved", "date" => "2025-11-12"]
                ]
            ],
            "33333" => [
                "name" => "RAin Josh Soriquez",
                "documents" => [
                    ["type" => "Health Record", "status" => "Pending", "date" => "2025-09-30"]
                ]
            ]
        ];

        // Process form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['studentId'])) {
            $inputId = trim($_POST['studentId']);
            
            // Input validation
            if (empty($inputId)) {
                echo '<div class="error">Please enter a Student ID.</div>';
            } elseif (!preg_match('/^[0-9]+$/', $inputId)) {
                echo '<div class="error">Please enter a valid Student ID (numbers only).</div>';
            } else {
                // Find matching student
                if (isset($studentData[$inputId])) {
                    $student = $studentData[$inputId];
                    $documentCount = count($student['documents']);
                    ?>
                    <div class="success">
                        Found <?php echo $documentCount; ?> document(s) for Student ID: <?php echo htmlspecialchars($inputId); ?>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Document Type</th>
                                <th>Status</th>
                                <th>Submission Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($student['documents'] as $doc): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($inputId); ?></td>
                                    <td><?php echo htmlspecialchars($student['name']); ?></td>
                                    <td><?php echo htmlspecialchars($doc['type']); ?></td>
                                    <td>
                                        <span style="color: 
                                            <?php 
                                            switch($doc['status']) {
                                                case 'Approved': echo '#28a745'; break;
                                                case 'Pending': echo '#ffc107'; break;
                                                case 'Rejected': echo '#dc3545'; break;
                                                default: echo '#6c757d';
                                            }
                                            ?>
                                        ">
                                            <?php echo htmlspecialchars($doc['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($doc['date']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo '<div class="no-results">No documents found for Student ID: ' . htmlspecialchars($inputId) . '</div>';
                }
            }
        }
        ?>
    </div>
</body>
</html>