<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['role'])) {
    // Redirect based on the role already logged in
    if ($_SESSION['role'] === 'patient') {
        header('Location: ./index.php');
        exit();
    } elseif ($_SESSION['role'] === 'doctor') {
        header('Location: ./doc.php');
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Access</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
  function checkCredentials(event) {
    event.preventDefault();
    const username = $('#username').val();
    const password = $('#password').val();

    console.log("Username:", username);
    console.log("Password:", password);
    const data = {
    username: username,
    password: password
};

$.ajax({
    url: 'http://localhost/Hospital-Database-main/Hospital-Database-main/api.php?action=credentials',
    type: 'POST',
    contentType: 'application/json',
    data: JSON.stringify(data),
    success: function(response) {
        console.log(response); // Log the response from the server
        
        // Reload the page regardless of response
        window.location.reload();
    },
    error: function(xhr, status, error) {
        console.error('Error: Could not connect to API', error);
        $('#error-message').text("An error occurred while processing your request.");
    }
});
  }

    </script>
</head>
<body>
    <form id="login-form" onsubmit="checkCredentials(event)">
        <input type="text" id="username" name="username" placeholder="Username" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <div id="error-message"></div>
</body>
</html>
