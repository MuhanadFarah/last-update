<?php
session_start();

// Destroy all session data
$_SESSION = [];
session_unset();
session_destroy();

// Redirect to login page
header("Location: http://localhost:8080/university_attendance/");
exit();
?>
