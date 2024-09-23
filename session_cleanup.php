<?php
session_start();
session_destroy(); // Destroy the session
header('Location: ./allow_patients.php'); // Redirect to login page after session is destroyed
exit();
?>
