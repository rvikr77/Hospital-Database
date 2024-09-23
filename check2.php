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
        name: "<?php echo $_POST['name']; ?>",
        ph: "<?php echo $_POST['ph']; ?>"
      };

      $.ajax({
        url: 'http://localhost/Hospital-Database-main/Hospital-Database-main/api.php?action=transfer',
        type: 'TRANSFER',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
          console.log(response);
          $('body').append("<p>Record transferred successfully.</p>");
          setTimeout(function(){
            window.location.href = "./index.php";
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
