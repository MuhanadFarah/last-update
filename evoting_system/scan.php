<?php
session_start();
require 'dB.php';

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data || !isset($data['qr'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid QR code data.']);
        exit;
    }

    $parts = explode(',', $data['qr']);
    if (count($parts) !== 3) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid QR code format.']);
        exit;
    }

    list($id, $name, $faculty) = array_map('trim', $parts);

    if (!$id || !$name || !$faculty) {
        echo json_encode(['status' => 'error', 'message' => 'QR code missing fields.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ? AND name = ? AND faculty = ?");
    $stmt->bind_param("iss", $id, $name, $faculty);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => '❌ Student not registered.']);
        exit;
    }

    $stmt2 = $conn->prepare("SELECT * FROM votes WHERE student_id = ?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $res2 = $stmt2->get_result();

    if ($res2->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => '❌ Student has already voted.']);
        exit;
    }

    $_SESSION['student_id'] = $id;
    $_SESSION['student_name'] = $name;
    $_SESSION['student_faculty'] = $faculty;

    echo json_encode(['status' => 'success']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Scan QR Code - University E-Voting</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: url('https://images.squarespace-cdn.com/content/v1/5d777de8109c315fd22faf3a/1693407136044-G90XQURX1GABMYGAS8K1/shutterstock_1288634614.jpg?format=2500w') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .container {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(15px);
      border-radius: 20px;
      padding: 40px 30px;
      width: 450px;
      max-width: 95%;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.35);
      text-align: center;
      animation: fadeIn 0.7s ease-in-out;
    }
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(20px);}
      to {opacity: 1; transform: translateY(0);}
    }
    h2 {
      color: #ffffff;
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 25px;
    }
    #reader {
      border-radius: 15px;
      overflow: hidden;
      width: 100%;
      background-color: #fefefe;
      box-shadow: 0 5px 20px rgba(0,0,0,0.2);
      margin-bottom: 20px;
    }
    .message {
      font-size: 16px;
      color: #fff;
      font-weight: 600;
      margin-top: 10px;
      text-shadow: 1px 1px 2px #000;
    }
    .btn {
      display: inline-block;
      background: linear-gradient(to right, #00b4db, #0083b0);
      color: #fff;
      padding: 13px 24px;
      font-size: 16px;
      font-weight: 600;
      border: none;
      border-radius: 10px;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
    }
    .btn:hover {
      background: linear-gradient(to right, #0083b0, #00b4db);
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(0, 179, 219, 0.4);
    }
    @media (max-width: 500px) {
      .container {
        padding: 25px 15px;
      }
      h2 {
        font-size: 22px;
      }
      .btn {
        width: 100%;
      }
    }
  </style>
</head>
<body>
<div class="container">
  <h2>📸 Scan Your University ID QR</h2>
  <div id="reader"></div>
  <div class="message" id="result">Point your QR code toward the camera...</div>
  <a href="dashboard.php" class="btn">⬅ Back to Dashboard</a>
</div>

<script>
function onScanSuccess(decodedText, decodedResult) {
  document.getElementById("result").innerText = "⏳ Validating...";

  fetch('scan.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ qr: decodedText })
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'success') {
      document.getElementById("result").innerText = "✅ Valid QR! Redirecting...";
      setTimeout(() => {
        window.location.href = "vote.php";
      }, 1000);
    } else {
      document.getElementById("result").innerText = data.message || "❌ QR code rejected.";
    }
  })
  .catch(() => {
    document.getElementById("result").innerText = "❌ Network or server error.";
  });
}

function onScanFailure(error) {
  // Optional: Handle scan failure silently
}

const html5QrcodeScanner = new Html5QrcodeScanner(
  "reader", { fps: 10, qrbox: 250 }
);
html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
</body>
</html>