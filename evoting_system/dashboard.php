<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?><!DOCTYPE html><html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-image: url('https://www.ohchr.org/sites/default/files/styles/hero_5_image_desktop/public/2024-03/20240301-hero-story-2024-elections-are-testing-democracy-health-main.jpg?itok=AoG_KIv_');
      background-size: cover;
      background-position: center;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }.dashboard-container {
  text-align: center;
  background: rgba(255, 255, 255, 0.9);
  padding: 40px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

h1 {
  margin-bottom: 30px;
  color: #333;
}

.btn {
  display: block;
  background-color: #007bff;
  color: white;
  border: none;
  padding: 14px 28px;
  margin: 12px auto;
  font-size: 16px;
  border-radius: 6px;
  cursor: pointer;
  width: 260px;
  transition: 0.3s;
  text-decoration: none;
}

.btn:hover {
  background-color: #0056b3;
}

.top-right-management {
  position: absolute;
  top: 20px;
  right: 20px;
  background: rgba(255, 255, 255, 0.85);
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.top-right-management h3 {
  margin-top: 0;
  color: #222;
  font-size: 18px;
}

.manage-btn {
  display: block;
  background-color: #28a745;
  color: white;
  border: none;
  padding: 10px 16px;
  margin: 8px 0;
  font-size: 14px;
  border-radius: 5px;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
}

.manage-btn:hover {
  background-color: #1e7e34;
}

  </style>
</head>
<body>  <div class="top-right-management">
    <h3>Management</h3>
    <a href="add_students.php" class="manage-btn">Add Students</a>
    <a href="add_candidates.php" class="manage-btn">Add Candidates</a>
    <a href="add_admins.php" class="manage-btn">Add Admins</a>
  </div>  <div class="dashboard-container">
    <h1>Welcome, Admin</h1>
    <a href="scan.php" class="btn">Insert Your ID Card to Vote</a>
    <a href="results.php" class="btn">View Results</a>
  </div></body>
</html>