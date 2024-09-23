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
        body{
    background-image: url(./images/background.jpg);
    background-repeat: no-repeat;
    background-size: cover;
}
#forme{
    border: 2px solid lime;
    width:50%;
    height:100%;
    font-size: 3vh;
    padding:10%;
    opacity:0.7;
}
#sub{
    border-radius: 10%;
    padding:2%;
    color:lime;
    background-color: black;
}
#reset{
    background: none;
    padding:2%;
    color:lime;
}
.wrapper {
    height: 100vh;
    /*This part is important for centering*/
    display: grid;
    place-items: center;
  }
  
  .typing-demo {
    width: 17ch;
    animation: typing 2s steps(17), blink .5s step-end infinite alternate;
    white-space:nowrap;
    overflow:hidden;
    border-right: 3px solid;
    font-family: monospace;
    font-size: 4.5vw;
  }
  .parent {
    width: 100vw;
    height: 100%;
    /* Aligns the children items in a row direction */
    display: flex;
}
.two{
    width:50%;
    height:100%;
    overflow:hidden;
} 
  @keyframes typing {
    from {
      width: 0
    }
  }
    </style>
</head>
<body>
    <header id="head1"><a href="index.php"><img src="./images/logo.png" id="logo" /></a>
        <h2 style="display: inline-block;margin:0;margin-left:1%;"> <i> Sharing is Caring!</i></h2>
        </header><hr><br>
        <div class="parent">
        <div  id="forme" style="padding:2%;color: lime;background-color: grey;">
            <h1>Fill the form!</h1>
            <p>Already visited</p>
            <a href="index.php">First time / New problem ?</a>
        <form action="./check2.php" method="POST" >
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" placeholder="Name" required><br>
            <label for="ph">Phone number:</label><br>
            <input type="tel" id="ph" name="ph" required><br>
            <input type="submit" id="sub" value="Submit"> <input type="reset" id="reset"value="Reset">     
        </form>
    </div>
    <div class="two">
    <div class="wrapper" >
        <div class="typing-demo">
             Health is Wealth.
    </div>
    </div>
    </div>
        </div>
        <br>
    <hr>
    <div style="display:block;">
    <footer id="footer1"><br>
        <list>
            <ul><a href="terms.html" style="color: black;">Terms of Service</a></ul>
            <ul><a href="privacy.html" style="color: black;">Privacy Policy</a></ul>
        </list>
        <br>
    </footer>
    </div>
    <script>
        const SESSION_TIMEOUT = 10 * 1000; // 10 seconds in milliseconds
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