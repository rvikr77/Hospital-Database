<?php
session_start();

// Update last activity time
$_SESSION['last_activity'] = time();

// Check if the user is logged in and has the doctor role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    header('Location: ./allow_patients.php'); // Redirect to login page if not logged in or not a doctor
    exit();
}

?>


<!DOCTYPE html>
<html>
<head>
  <title>View db</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="60">
  <link rel="stylesheet" href="styles.css">
  <style>
    #tables {
        border: 2px solid black;
        border-collapse: collapse;
    }
    #tabbox {
        border: 2px solid lime;
        padding: 2%;
        width: fit-content;
    }
    #but {
        color: lime;
        background-color: black;
        margin: 1%;
    }
    tr, td, th {
        border: none;
        padding: 1%;
    }
  </style>
</head>
<body>

<header id="head1">
  <a href="doc.php"><img src="./images/logo.png" id="logo" /></a>
  <h2 style="display: inline-block; margin: 0; margin-left: 1%;"> <i> Sharing is Caring!</i></h2>
</header>
<hr><br>
<h1>Patient details ..</h1>
<div id="patient-data"></div> <!-- Container for patient data -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function fetchData() {
  $.ajax({
    url: 'api.php?action=get',
    type: 'GET',
    success: function(response) {
      let html = '';
      response.forEach(row => {
        html += "<div id='tabbox'><table border='1' id='tables'>";
        for (const [key, value] of Object.entries(row)) {
          html += `<tr><td>${key} :</td><td>${value}</td></tr>`;
        }
        html += `<tr>
                    <td colspan='2'>
                      <button class='update-btn' data-ph='${row.PH}' data-name='${row.NAME}'>Done/Update!</button>
                    </td>
                    <td colspan='2'>
                      <button class='delete-btn' data-ph='${row.PH}' data-name='${row.NAME}'>Delete/Not update!</button>
                    </td>
                 </tr>`;
        html += "</table><br></div><br>";
      });
      $('#patient-data').html(html);
    },
    error: function(xhr, status, error) {
      console.error('Error fetching data:', error);
    }
  });
}

$(document).ready(function() {
  fetchData(); // Load data when the page is ready

  $('#patient-data').on('click', '.update-btn', function() {
    const ph = $(this).data('ph');
    const name = $(this).data('name');
    $.ajax({
      url: 'api.php?action=put',
      type: 'PUT',
      contentType: 'application/json',
      data: JSON.stringify({ ph, name }),
      success: function(response) {
        alert(response.message);
        fetchData(); // Refresh the data
      },
      error: function(xhr, status, error) {
        console.error('Error updating data:', error);
      }
    });
  });

  $('#patient-data').on('click', '.delete-btn', function() {
    const ph = $(this).data('ph');
    const name = $(this).data('name');
    $.ajax({
      url: 'api.php?action=delete',
      type: 'DELETE',
      contentType: 'application/json',
      data: JSON.stringify({ ph, name }),
      success: function(response) {
        alert(response.message);
        fetchData(); // Refresh the data
      },
      error: function(xhr, status, error) {
        console.error('Error deleting data:', error);
      }
    });
  });
});
</script>

<div style="display: block;">
  <footer id="footer1"><br>
    <ul>
      <li><a href="terms.html" style="color: black;">Terms of Service</a></li>
      <li><a href="privacy.html" style="color: black;">Privacy Policy</a></li>
    </ul>
    <br>
  </footer>
</div>
<script>
        const SESSION_TIMEOUT = 50 * 1000; // 10 seconds in milliseconds
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
