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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Access</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        #login-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            transform: scale(2);

        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }

        #error-message {
            color: red;
            margin-top: 15px;
        }

        @media (max-width: 600px) {
            #login-form {
                width: 100%;
                padding: 20px;
            }
        }
    </style>
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
