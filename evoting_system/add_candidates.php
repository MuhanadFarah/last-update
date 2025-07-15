<?php
require 'dB.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id']);
    $name = trim($_POST['name']);

    if (!$id || !$name) {
        $error = 'Both ID and Candidate Name are required.';
    } else {
        // Check if ID already exists
        $check = $conn->prepare("SELECT id FROM candidates WHERE id = ?");
        $check->bind_param("i", $id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = 'Candidate with this ID already exists.';
        } else {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO candidates (id, name) VALUES (?, ?)");
            $stmt->bind_param("is", $id, $name);

            if ($stmt->execute()) {
                $success = 'Candidate added successfully!';
            } else {
                $error = 'Failed to add candidate. Try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Candidate</title>
    <style>
        body {
            background: url('https://st2.depositphotos.com/2001755/5408/i/450/depositphotos_54081723-Beautiful-nature-landscape.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
            width: 400px;
            position: relative;
            z-index: 1;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        .btn-submit, .btn-back {
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-submit {
            background-color: #007bff;
            color: white;
            width: 100%;
            margin-bottom: 10px;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
            display: block;
            text-align: center;
            text-decoration: none;
            margin-top: 10px;
        }
        .btn-back:hover {
            background-color: #495057;
        }
        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
        .btn-view-candidates {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 10px 18px;
            font-size: 15px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            z-index: 1000;
            box-shadow: 0 3px 6px rgba(0,0,0,0.2);
            transition: background-color 0.3s ease;
        }
        .btn-view-candidates:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<a href="view_candidates.php" class="btn-view-candidates">View All</a>

<div class="form-container">
    <h2>Add New Candidate</h2>

    <?php if ($success): ?>
        <div class="message success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="id">Candidate ID</label>
        <input type="number" id="id" name="id" required placeholder="Enter ID (e.g., 101)" />

        <label for="name">Candidate Full Name</label>
        <input type="text" id="name" name="name" required placeholder="Enter candidate name" />

        <button type="submit" class="btn-submit">Add Candidate</button>
    </form>

    <a href="dashboard.php" class="btn-back">← Back</a>
</div>

</body>
</html>

