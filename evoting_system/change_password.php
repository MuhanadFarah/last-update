<?php
session_start();
require 'dB.php';

// Redirect if not logged in or not first login
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

// Fetch admin info from database
$admin_id = $_SESSION['admin_id'];
$stmt = $conn->prepare("SELECT is_first_login FROM admins WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    session_destroy();
    header("Location: index.php");
    exit;
}
$admin = $result->fetch_assoc();

if ($admin['is_first_login'] != 1) {
    // Already changed password, redirect to dashboard
    header("Location: dashboard.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($new_password) || empty($confirm_password)) {
        $error = 'Please fill in all fields.';
    } elseif ($new_password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (strlen($new_password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        // Hash new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password and is_first_login
        $update_stmt = $conn->prepare("UPDATE admins SET password = ?, is_first_login = 0 WHERE id = ?");
        $update_stmt->bind_param("si", $hashed_password, $admin_id);
        if ($update_stmt->execute()) {
            $success = 'Password changed successfully! Redirecting...';
            // Redirect after 2 seconds
            header("refresh:2;url=dashboard.php");
        } else {
            $error = 'Failed to update password. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Change Password - University E-Voting</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #333;
    }
    .change-password-container {
        background: rgba(255, 255, 255, 0.95);
        padding: 40px 30px;
        border-radius: 10px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        width: 360px;
    }
    h2 {
        text-align: center;
        margin-bottom: 24px;
        font-weight: 700;
        color: #222;
    }
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
    }
    input[type="password"] {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 20px;
        border: 1.5px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }
    input[type="password"]:focus {
        border-color: #0056b3;
        outline: none;
    }
    .btn-submit {
        width: 100%;
        padding: 14px;
        font-size: 18px;
        font-weight: 700;
        border: none;
        border-radius: 6px;
        background-color: #0056b3;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .btn-submit:hover {
        background-color: #003d80;
    }
    .error {
        background-color: #f8d7da;
        color: #842029;
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 6px;
        border: 1px solid #f5c2c7;
        font-weight: 600;
        text-align: center;
    }
    .success {
        background-color: #d1e7dd;
        color: #0f5132;
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 6px;
        border: 1px solid #badbcc;
        font-weight: 600;
        text-align: center;
    }
</style>
</head>
<body>

<div class="change-password-container">
    <h2>Change Your Password</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php else: ?>
        <form method="POST" action="">
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" required minlength="6" />

            <label for="confirm_password">Confirm New Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required minlength="6" />

            <button type="submit" class="btn-submit">Change Password</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>