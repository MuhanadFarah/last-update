<?php
session_start();
require 'dB.php';

// Validate POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method.");
}

$name = trim($_POST['name'] ?? '');
$student_id = trim($_POST['student_id'] ?? '');
$faculty = trim($_POST['faculty'] ?? '');

if (!$name || !$student_id || !$faculty) {
    die("Missing required student data.");
}

// Check if student exists
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ? AND name = ? AND faculty = ?");
$stmt->bind_param("iss", $student_id, $name, $faculty);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("❌ You're not registered as a student.");
}

$student = $result->fetch_assoc();

// Check if student has voted
$stmt2 = $conn->prepare("SELECT * FROM votes WHERE student_id = ?");
$stmt2->bind_param("i", $student_id);
$stmt2->execute();
$result2 = $stmt2->get_result();

if ($result2->num_rows > 0) {
    die("❌ You already voted.");
}

// If valid, redirect to voting page passing student info in session
$_SESSION['student_id'] = $student_id;
$_SESSION['student_name'] = $name;
$_SESSION['faculty'] = $faculty;

header("Location: vote.php");
exit;
?>