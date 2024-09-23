<?php
session_start();

// Update last activity time
$_SESSION['last_activity'] = time();

// Check if the user is already logged in
if (!isset($_SESSION['role'])) {
    header('Location: ./allow_patients.php'); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Database</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-image: url(./images/background.jpg);
            background-repeat: no-repeat;
            background-size: cover;
        }
        #forme {
            border: 2px solid lime;
            width: 50%;
            height: 100%;
            font-size: 3vh;
            padding: 10%;
            opacity: 0.7;
        }
        #sub {
            border-radius: 10%;
            padding: 2%;
            color: lime;
            background-color: black;
        }
        #reset {
            background: none;
            padding: 2%;
            color: lime;
        }
        .wrapper {
            height: 100vh;
            display: grid;
            place-items: center;
        }
        .typing-demo {
            width: 17ch;
            animation: typing 2s steps(17), blink .5s step-end infinite alternate;
            white-space: nowrap;
            overflow: hidden;
            border-right: 3px solid;
            font-family: monospace;
            font-size: 4.5vw;
        }
        .parent {
            width: 100vw;
            height: 100%;
            display: flex;
        }
        .two {
            width: 50%;
            height: 100%;
            overflow: hidden;
        }
        @keyframes typing {
            from {
                width: 0;
            }
        }
    </style>
</head>
<body>
    <header id="head1">
        <a href="index.php"><img src="./images/logo.png" id="logo" /></a>
        <h2 style="display: inline-block; margin: 0; margin-left: 1%;"> <i> Sharing is Caring!</i></h2>
    </header>
    <hr><br>
    <div class="parent">
        <div id="forme" style="padding: 2%; color: lime; background-color: grey;">
            <h1>Fill the form!</h1>
            <p>First time/ New problem...</p>
            <a href="login.php">Already visited?</a>
            <form action="./check.php" method="POST">
                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name" placeholder="Name" required><br>
                <label for="ph">Phone number:</label><br>
                <input type="tel" id="ph" name="ph" required><br>
                <label for="a">Age:</label><br>
                <input type="number" id="a" name="a" required><br>
                <label for="gender">Gender:</label><br>
                <input type="radio" id="male" name="gender" value="male" required>
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="female" required>
                <label for="female">Female</label><br>
                <label for="bp">Blood pressure:</label><br>
                <input type="number" id="bp1" name="bp1" required placeholder="Systolic"> /
                <input type="number" id="bp2" name="bp2" required placeholder="Diastolic"><br>
                <label for="pulse">Pulse:</label><br>
                <input type="number" id="pulse" name="pulse" required><br>
                <label for="allergies">Allergies:</label><br>
                <input type="text" id="allergies" name="allergies"><br>
                <label for="h">Height:</label><br>
                <input type="number" id="h" name="h" required placeholder="in cm"><br>
                <label for="w">Weight:</label><br>
                <input type="number" id="w" name="w" required placeholder="in kgs"><br>
                <label for="pd">Problem Description:</label><br>
                <textarea id="pd" name="pd" placeholder="Describe your problem"></textarea><br>
                <input type="submit" id="sub" value="Submit">
                <input type="reset" id="reset" value="Reset">     
            </form>
        </div>
        <div class="two">
            <div class="wrapper">
                <div class="typing-demo">
                    Health is Wealth.
                </div>
            </div>
        </div>
    </div>
    <br>
    <hr>
    <div style="display: block;">
        <footer id="footer1"><br>
            <list>
                <ul><a href="terms.html" style="color: black;">Terms of Service</a></ul>
                <ul><a href="privacy.html" style="color: black;">Privacy Policy</a></ul>
            </list>
            <br>
        </footer>
    </div>
    <script>
        const SESSION_TIMEOUT = 30 * 1000; // 10 seconds in milliseconds
        let lastActivity = Date.now();

        // Function to check for session expiration
        function checkSession() {
            if (Date.now() - lastActivity > SESSION_TIMEOUT) {
                window.location.href = './session_cleanup.php'; // Redirect if session expired
            }
        }

        // Set interval to check session every 10 seconds
        setInterval(checkSession, 5000);

        // Update last activity on any user interaction
        window.addEventListener('mousemove', () => { lastActivity = Date.now(); });
        window.addEventListener('keypress', () => { lastActivity = Date.now(); });
    </script>
</body>
</html>
