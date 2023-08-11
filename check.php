<!DOCTYPE html>
<html>
<head>
  <title>Redirect!</title>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <h1>Redirecting...</h1>
  <?php
  // Check if the form is submitted
  require_once "config.php";
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs
    $name = $_POST['name'];
    $ph = $_POST['ph'];
    $a=$_POST['a'];
    $g = $_POST['gender'];
    $bp1=$_POST['bp1'];
    $bp2=$_POST['bp2'];
    $pulse=$_POST['pulse'];
    $al=$_POST['allergies'];
    $h=$_POST['h'];
    $w=$_POST['w'];
    $pd=$_POST['pd'];

   

    // Create a database connection
    $conn = mysqli_connect($server, $user, $pass);
            // Select the database
            mysqli_select_db($conn, "HOSPITALDB");
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    $sql="INSERT INTO HOSPITAL (PH, NAME, AGE, GENDER, BP1, BP2, PULSE, ALLERGIES, HEIGHT, WEIGHT, PATIENT_DETAILS) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
            NAME = VALUES(NAME), AGE = VALUES(AGE), GENDER = VALUES(GENDER), BP1 = VALUES(BP1), BP2 = VALUES(BP2), 
            PULSE = VALUES(PULSE), ALLERGIES = VALUES(ALLERGIES), HEIGHT = VALUES(HEIGHT), WEIGHT = VALUES(WEIGHT), 
            PATIENT_DETAILS = VALUES(PATIENT_DETAILS)";
   $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isisiiisiis", $ph,$name,$a,$g,$bp1,$bp2,$pulse,$al,$h,$w,$pd);
    if (mysqli_stmt_execute($stmt)) {
      echo "Response recorded successfully.";
    } else {
      echo "Error: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
    // Close the database connection
    mysqli_close($conn);}
    ?>
    <script>
      window.setTimeout(function(){window.location.href = "./index.html";}, 3000);
    </script>
</body>
</html>