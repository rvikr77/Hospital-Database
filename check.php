<!DOCTYPE html>
<html>
<head>
  <title>Redirect!</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <h1>Redirecting...</h1>

  <script>
    $(document).ready(function() {
      // Collect form data from previous page or form submission
      var data = {
        ph: "<?php echo $_POST['ph']; ?>",
        name: "<?php echo $_POST['name']; ?>",
        age: "<?php echo $_POST['a']; ?>",
        gender: "<?php echo $_POST['gender']; ?>",
        bp1: "<?php echo $_POST['bp1']; ?>",
        bp2: "<?php echo $_POST['bp2']; ?>",
        pulse: "<?php echo $_POST['pulse']; ?>",
        allergies: "<?php echo $_POST['allergies']; ?>",
        height: "<?php echo $_POST['h']; ?>",
        weight: "<?php echo $_POST['w']; ?>",
        patient_details: "<?php echo $_POST['pd']; ?>"
      };

      $.ajax({
        url: 'http://localhost/Hospital-Database-main/Hospital-Database-main/api.php?action=post',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
          console.log(response);
          $('body').append("<p>Response recorded successfully.</p>");
          setTimeout(function(){
            window.location.href = "./index.html";
          }, 3000);
        },
        error: function(xhr, status, error) {
          console.error('Error: Could not connect to API', error);
          $('body').append("<p>Error: Could not connect to API.</p>");
        }
      });
    });
  </script>

</body>
</html>
