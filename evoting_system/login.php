<?php
session_start();
require 'dB.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];

    if (!$phone || !$password) {
        $error = 'Please fill in all fields.';
    } else {
        // Query admin by phone
        $stmt = $conn->prepare("SELECT * FROM admins WHERE phone = ?");
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();

            // Verify password (hashed)
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_phone'] = $admin['phone'];

                if ($admin['is_first_login'] == 1) {
                    header("Location: change_password.php");
                    exit;
                } else {
                    header("Location: dashboard.php");
                    exit;
                }
            } else {
                $error = 'Incorrect phone number or password.';
            }
        } else {
            $error = 'Incorrect phone number or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Login - University E-Voting</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('https://images.unsplash.com/photo-1526045612212-70caf35c14df?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            position: relative;
        }
        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background-color: #555;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.3s ease;
            z-index: 1000;
        }
        .back-button:hover {
            background-color: #333;
        }
        .login-container {
            background: #ffffffcc;
            padding: 40px 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 24px;
            color: #333;
            font-weight: 700;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            text-align: left;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1.8px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #0056b3;
            outline: none;
        }
        .btn-login {
            width: 100%;
            background-color: #0056b3;
            border: none;
            color: white;
            padding: 14px;
            font-size: 18px;
            font-weight: 700;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-login:hover {
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
    </style>
</head>
<body>

<a href="index.php" class="back-button">← Back</a>

<div class="login-container">
    <h2>Admin Login</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="phone">Phone Number</label>
        <input
            type="text"
            id="phone"
            name="phone"
            placeholder="+25290xxxxxxx"
            required
            pattern="^\+2529\d{7,8}$"
            title="Phone number should start with +2529 followed by 7 or 8 digits"
            value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>"
        />

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />

        <button type="submit" class="btn-login">Login</button>
    </form>
</div>

</body>
</html>