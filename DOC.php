<!DOCTYPE html>
<html>
<head>
  <title>View db</title>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30">
    <style>
        #tables{
            border:2px solid black;
            border-collapse: collapse;
        }
        #tabbox{
            border: 2px solid lime;
            padding:2%;
            width:fit-content;
        }
        body{
            background-image: url(./images/doct.jpeg);
            background-repeat: no-repeat;
            background-size: cover;
        }
        #but{
            color:lime;
            background-color: black;
            margin:1%;
        }
        tr,td,th{
            border: none;
            padding:1%;
        }
    </style>
</head>
<body>
  <h1>Patient details ...</h1>
  <?php
require_once "config.php";

// Create a database connection
$conn = mysqli_connect($server, $user, $pass);
mysqli_select_db($conn, "HOSPITALDB");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        $idToDelete = $_POST['delete'];

        // Get data to move
        $moveSql = "SELECT * FROM HOSPITAL WHERE PH = ?";
        $stmt = mysqli_prepare($conn, $moveSql);
        mysqli_stmt_bind_param($stmt, "i", $idToDelete);
        mysqli_stmt_execute($stmt);

        $moveResult = mysqli_stmt_get_result($stmt);
        $moveRow = mysqli_fetch_assoc($moveResult);

        // Delete the row from the main table
        $deleteSql = "DELETE FROM HOSPITAL WHERE PH = ?";
        $stmt = mysqli_prepare($conn, $deleteSql);
        mysqli_stmt_bind_param($stmt, "i", $idToDelete);
        mysqli_stmt_execute($stmt);

        // Insert or update the row in the storage table
        $storageSql = "INSERT INTO STORAGE (PH, NAME, AGE, GENDER, BP1, BP2, PULSE, ALLERGIES, HEIGHT, WEIGHT, PATIENT_DETAILS) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                       ON DUPLICATE KEY UPDATE 
                       AGE = VALUES(AGE), GENDER = VALUES(GENDER), BP1 = VALUES(BP1), BP2 = VALUES(BP2), 
                       PULSE = VALUES(PULSE), ALLERGIES = VALUES(ALLERGIES), HEIGHT = VALUES(HEIGHT), 
                       WEIGHT = VALUES(WEIGHT), PATIENT_DETAILS = VALUES(PATIENT_DETAILS)";

        $stmt = mysqli_prepare($conn, $storageSql);
        mysqli_stmt_bind_param($stmt, "isisiiisiis",
            $moveRow['PH'], $moveRow['NAME'], $moveRow['AGE'], $moveRow['GENDER'],
            $moveRow['BP1'], $moveRow['BP2'], $moveRow['PULSE'], $moveRow['ALLERGIES'],
            $moveRow['HEIGHT'], $moveRow['WEIGHT'], $moveRow['PATIENT_DETAILS']);
        mysqli_stmt_execute($stmt);
    }
}

$sql = "SELECT * FROM HOSPITAL;";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div id='tabbox'><table border='1' id='tables'>";
    foreach ($row as $column => $value) {
        echo "<tr><td>$column : </td><td>$value</td></tr>";
    }
    echo "<tr><td colspan='2'>
            <form method='post' action=''>
            <input type='hidden' name='delete' value='{$row['PH']}' />
            <button type='submit' id='but'>Done!</button>
            </form>
          </td></tr>";
    echo "</table><br></div><br>";
}

// Close the database connection
mysqli_close($conn);
?>


</body>
</html>