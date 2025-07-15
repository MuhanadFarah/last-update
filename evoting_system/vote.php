<?php
session_start();
require 'dB.php';

// Check if student session exists
if (!isset($_SESSION['student_id'], $_SESSION['student_name'], $_SESSION['student_faculty'])) {
    die("Unauthorized access. Please scan your ID first.");
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    die("Error: Admin not identified. Please log in as admin to supervise voting.");
}

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];
$admin_id = $_SESSION['admin_id']; // Required to log who supervised

// Handle vote submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $candidate_id = $_POST['candidate_id'] ?? '';

    if (!$candidate_id) {
        $error = "Please select a candidate.";
    } else {
        // Double-check if student already voted
        $stmt = $conn->prepare("SELECT id FROM votes WHERE student_id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "You have already voted.";
        } else {
            // Insert vote
            $stmt = $conn->prepare("INSERT INTO votes (candidate_id, student_id, student_name, admin_id, vote_time) VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("iisi", $candidate_id, $student_id, $student_name, $admin_id);

            if ($stmt->execute()) {
                // ✅ Clear only student session
                unset($_SESSION['student_id'], $_SESSION['student_name'], $_SESSION['student_faculty']);

                // ✅ Redirect back to scan for next student
                header("Location: scan.php?success=1");
                exit;
            } else {
                $error = "❌ Failed to record your vote. Try again.";
            }
        }
    }
}

// Fetch candidates
$candidates = [];
$result = $conn->query("SELECT id, name FROM candidates");
while ($row = $result->fetch_assoc()) {
    $candidates[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Vote - University E-Voting</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700&display=swap" rel="stylesheet" />
  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: url('https://wallpaperaccess.com/full/1732392.jpg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .vote-box {
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(12px);
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.4);
      max-width: 500px;
      width: 90%;
      text-align: center;
      color: #fff;
    }
    h2 {
      margin-bottom: 25px;
      font-weight: 700;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    label {
      background: rgba(255,255,255,0.1);
      padding: 10px 15px;
      border-radius: 10px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-weight: 500;
    }
    input[type="radio"] {
      transform: scale(1.4);
    }
    button {
      margin-top: 20px;
      background: linear-gradient(to right, #00b894, #00cec9);
      border: none;
      color: white;
      padding: 14px;
      font-size: 16px;
      font-weight: 700;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    button:hover {
      background: linear-gradient(to right, #00cec9, #00b894);
    }
    .error {
      background: rgba(255,0,0,0.2);
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 8px;
      color: #ffdada;
    }
  </style>
</head>
<body>
  <div class="vote-box">
    <h2>🗳 Cast Your Vote</h2>

    <?php if (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <?php foreach ($candidates as $candidate): ?>
        <label>
          <?= htmlspecialchars($candidate['name']) ?>
          <input type="radio" name="candidate_id" value="<?= $candidate['id'] ?>" required />
        </label>
      <?php endforeach; ?>
      <button type="submit">Submit Vote</button>
    </form>
  </div>
</body>
</html>