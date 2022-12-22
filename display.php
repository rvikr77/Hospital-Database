<!DOCTYPE html>
<html>
  <head>
  <meta http-equiv="refresh" content="30">
    <meta charset="UTF-8">
    <meta name="viewport" content="width:device-width, initial scale: 1.0;">
    
    <title>Trial</title>
    <style>
      div{
       border:5px solid white;
       content:500px;
       padding:30px;
 
      }
      body{
        background-color:black;
        color:white;
 background-image: url("img_tree.png");
  background-repeat: repeat-y;
  background-position: right top;
  margin-right: 200px;
      }
      </style>
    </head>
 <body>
   <h1>Display Details</h1>
   <?php
   include('config.php');
   $d="aa";
   $conn=mysqli_connect($server,$user,$pass,$d);
   
   if(!$conn)
   echo "not connected";
   $row="";
   $sql4="SELECT * FROM TestData";
   $res4=mysqli_query($conn,$sql4);
   echo "<p style='color:green;'>Date : ".date("d/m/y")."</p><br>";
   if($res4){
   
   while($row=mysqli_fetch_assoc($res4)){
    echo 
    "<table style='border:5px solid white;border-collapse:collpse;'>
    <tr><td><span style='color:red;'>ID :</span></td><td>".$row["id"]."</td></tr>"
    ."<tr><td>Name :</td><td>".$row["Name"]."</td></tr>"
    ."<tr><td>Age :</td><td>".$row["Age"]."</td></tr>"
    ."<tr><td>Blood Pressure Pulse :</td><td>".$row["BPP"]."</td></tr>"
    ."<tr><td>Weight and Height :</td><td>".$row["WH"]."</td></tr>"
    ."<tr><td>Allergies :</td><td>".$row["Allergies"]."</td></tr>"
    ."<tr><td>Description :</td><td><span style='color:brown;'>".$row["Description"]."</span></td></tr></table><br>"
    ;
   }
   }
   else
   echo "error".mysqli_error($conn);
   mysqli_close($conn);
  
   ?>
   
 </body>   
</html>