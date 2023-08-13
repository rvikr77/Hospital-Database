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

    $db = "HOSPITALDB";

    $conn = mysqli_connect($server, $user, $pass, $db);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT `AGE`, `GENDER`, `BP1`, `BP2`, `PULSE`, `ALLERGIES`, `HEIGHT`, `WEIGHT`, `PATIENT_DETAILS` FROM STORAGE WHERE `PH`='$ph' AND `NAME`='$name'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $a = $row['AGE'];
            $g = $row['GENDER'];
            $bp1 = $row['BP1'];
            $bp2 = $row['BP2'];
            $pulse = $row['PULSE'];
            $al = $row['ALLERGIES'];
            $h = $row['HEIGHT'];
            $w = $row['WEIGHT'];
            $pd = $row['PATIENT_DETAILS'];
        } else {
            echo '<script>
            alert("New user!");
            window.location.href = "index.html";
            </script>';
            exit;
        }
    } else {
        echo "Error: " . mysqli_error($conn);
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