<?php
require 'dB.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = trim($_POST['phone']);

    if (!$phone) {
        $error = 'Phone Number is required.';
    } else {
        // Check if phone already exists
        $check = $conn->prepare("SELECT id FROM admins WHERE phone = ?");
        $check->bind_param("s", $phone);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = 'An admin with this phone number already exists.';
        } else {
            // Hash the default password 'admin'
            $defaultPassword = 'admin';
            $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);

            // Insert admin with is_first_login = 1
            $stmt = $conn->prepare("INSERT INTO admins (phone, password, is_first_login) VALUES (?, ?, 1)");
            $stmt->bind_param("ss", $phone, $hashedPassword);

            if ($stmt->execute()) {
                $success = 'New admin added successfully! Default password is "admin". Please make sure they change it on first login.';
            } else {
                $error = 'Failed to add admin. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add Admin</title>
    <style>
        body {
            background: url('https://sb.ecobnb.net/app/uploads/sites/3/2020/01/nature.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .top-buttons {
            position: fixed;
            top: 15px;
            left: 15px;
            right: 15px;
            display: flex;
            justify-content: space-between;
            z-index: 999;
        }

        .top-buttons a {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .top-buttons a:hover {
            background-color: #495057;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
            width: 400px;
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
            color: #444;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        .btn-submit {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            margin-bottom: 10px;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #0056b3;
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
    </style>
</head>
<body>

<div class="top-buttons">
    <a href="dashboard.php">← Back</a>
    <a href="view_admins.php">View Admins</a>
</div>

<div class="form-container">
    <h2>Add New Admin</h2>

    <?php if ($success): ?>
        <div class="message success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="phone">Phone Number</label>
        <input
            type="text"
            id="phone"
            name="phone"
            placeholder="+25290xxxxxxx"
            pattern="^\+2529\d{7,8}$"
            title="Phone number should start with +2529 followed by 7 or 8 digits"
            required
            value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>"
        />

        <button type="submit" class="btn-submit">Add Admin</button>
    </form>
</div>

</body>
</html>
