<?php
session_start();

// Destroy ALL session data
session_unset();
session_destroy();

// Prevent back button after logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Redirect to login page
header("Location: login.php");
exit;
?>
