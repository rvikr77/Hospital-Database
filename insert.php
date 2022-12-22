<?php
session_start();
include('config.php');
$d="aa";
$conn=mysqli_connect($server,$user,$pass,$d);

if(!$conn)
echo "not connected";

$name=$_POST["fname"];
$age=$_POST["age"];
$bpp=$_POST["bp"];
$allergies=$_POST["allergies"];
$wh=$_POST["wh"];
$description=$_POST["d"];
$sql3="INSERT  INTO `TestData`(`Name`,`Age`,`BPP`,`WH`,`Allergies`,`Description`) 
VALUES('$name','$age','$bpp','$wh','$allergies','$description')";
if(!mysqli_query($conn,$sql3))
echo "error".mysqli_error($conn);

mysqli_close($conn);
?>
<html>
    <body style="background-color:yellow;">
        <h3>Thanks! Response Recorded.</h3>
        <h3>Redirecting ...</h3>
        
        <body onload="setTimeout(function() { window.history.back(); }, 3000)">
</body>
</html>
