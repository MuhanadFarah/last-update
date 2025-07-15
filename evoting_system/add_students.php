<?php
session_start();
require 'dB.php';

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id']);
    $name = trim($_POST['name']);
    $faculty = trim($_POST['faculty']);

    if ($id === '' || $name === '' || $faculty === '') {
        $message = 'Please fill in all fields.';
    } else {
        // Check if student ID already exists
        $stmt = $conn->prepare("SELECT id FROM students WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Student ID already exists.";
        } else {
            // Insert student
            $stmt = $conn->prepare("INSERT INTO students (id, name, faculty) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $id, $name, $faculty);
            if ($stmt->execute()) {
                $message = "Student added successfully.";
            } else {
                $message = "Error adding student. Please try again.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Add Student - Admin</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: url('https://i.pinimg.com/1200x/84/3b/0f/843b0f70a7b4ee8e302c27513afc2da2.jpg') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .container {
        background-color: rgba(255, 255, 255, 0.95);
        padding: 40px 30px;
        border-radius: 12px;
        width: 380px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    h2 {
        text-align: center;
        margin-bottom: 24px;
        color: #222;
    }
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #444;
    }
    input[type="text"] {
        width: 100%;
        padding: 12px 14px;
        margin-bottom: 20px;
        border: 1.5px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }
    input[type="text"]:focus {
        border-color: #007BFF;
        outline: none;
    }
    .btn-submit {
        width: 100%;
        padding: 14px;
        background-color: #007BFF;
        border: none;
        color: white;
        font-size: 18px;
        font-weight: 700;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-bottom: 15px;
    }
    .btn-submit:hover {
        background-color: #0056b3;
    }
    .btn-back {
        display: block;
        width: 100%;
        text-align: center;
        padding: 12px 0;
        background-color: #6c757d;
        color: white;
        font-weight: 600;
        border-radius: 8px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    .btn-back:hover {
        background-color: #495057;
    }
    .message {
        margin-bottom: 20px;
        padding: 12px;
        border-radius: 6px;
        font-weight: 600;
        color: #155724;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        text-align: center;
    }
    /* Button fixed at top right of viewport */
    .btn-view-students {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 10px 16px;
        background-color: #28a745;
        color: white;
        font-weight: 600;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        transition: background-color 0.3s ease;
        border: none;
        cursor: pointer;
        z-index: 9999;
    }
    .btn-view-students:hover {
        background-color: #1e7e34;
    }
</style>
</head>
<body>
    <a href="view_students.php" class="btn-view-students">View All Students</a>

<div class="container">
    <h2>Add New Student</h2>

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="id">Student ID</label>
        <input
            type="text"
            id="id"
            name="id"
            placeholder="e.g. 2023001"
            required
            pattern="^[a-zA-Z0-9\-]+$"
            title="Alphanumeric student ID"
            value="<?= isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '' ?>"
        />

        <label for="name">Full Name</label>
        <input
            type="text"
            id="name"
            name="name"
            placeholder="Full student name"
            required
            value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>"
        />

        <label for="faculty">Faculty</label>
        <input
            type="text"
            id="faculty"
            name="faculty"
            placeholder="Faculty or Department"
            required
            value="<?= isset($_POST['faculty']) ? htmlspecialchars($_POST['faculty']) : '' ?>"
        />

        <button type="submit" class="btn-submit">Add Student</button>
    </form>

    <a href="dashboard.php" class="btn-back">← Back to Dashboard</a>
</div>
</body>
</html>

