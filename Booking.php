<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}
?>

<html>
<head>
    <title>Book your Bus Ticket</title>
    <style>
       body {
  font-family: Arial;
  padding: 10px;
  background-color: rgb(142, 232, 232);
        }
        form {
  background: rgb(142, 232, 232);
  padding: 20px;
  margin-top: 10px;
  text-align: center;
  color: black;
}
.error {color: #FF0000;}
header, footer {
  background-color: #333;
  color: white;
  padding: 10px;
  text-align: center;
  display: flex;
  justify-content:space-around;
  align-items: center;
}
.hover-link { 
    color: #007BFF; 
    transition: color 0.3s, background-color 0.3s; 
    padding: 10px 15px; 
    border: 2px solid transparent; 
} 
.hover-link:hover { 
    color: whitesmoke; 
    background-color: red;
    border: 2px solid black; 
} 
    </style> 
</head>
<body>
<?php
$fromErr = $toErr = $dateErr = $passengersErr = "";
$from = $to = $date = $passengers = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["from"])) {
    $fromErr = "From field is required";
  } else {
    $from = test_input($_POST["from"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$from)) {
      $fromErr = "Only letters and white space allowed";
    }
  }

  if (empty($_POST["to"])) {
    $toErr = "Destination is required";
  } else {
    $to = test_input($_POST["to"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$to)) {
      $toErr = "Only letters and white space allowed";
    }
  }

  if (empty($_POST["date"])) {
    $dateErr = "Date is required";
  } else {
    $date = $_POST["date"];
    if ($date < date("Y-m-d")) {
      $dateErr = "Date cannot be in the past";
    }
  }

  if (empty($_POST["passengers"])) {
    $passengersErr = "Number of passengers is required";
  } else {
    $passengers = $_POST["passengers"];
    if (!is_numeric($passengers) || $passengers < 1) {
      $passengersErr = "Passengers must be at least 1";
    }
  }

  if ($fromErr == "" && $toErr == "" && $dateErr == "" && $passengersErr == "") {
    file_put_contents('Booking.txt', "User: $username |From: $from | To: $to | Date: $date | Passengers: $passengers\n", FILE_APPEND);
    echo "<p style='color:green; text-align:center;'>Thanks — Your Booking is saved.</p>";
    exit;
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<header>
  <img src="Bus.jpg" width="50" height="100">
  <h2>Book Your Bus Ticket</h2>
  <a href="Home.php" style="color:aliceblue">HOME</a>
</header>

<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <br><br><br>
  <label>From:</label>
  <input type="text" name="from" value="<?php echo $from; ?>"><br>
  <span class="error">* <?php echo $fromErr;?></span>

  <br>
  <label>To:</label>
  <input type="text" name="to" value="<?php echo $to; ?>"><br>
  <span class="error">* <?php echo $toErr;?></span>

  <br>
  <label>Date:</label>
  <input type="date" name="date" value="<?php echo $date; ?>"><br>
  <span class="error">* <?php echo $dateErr;?></span>

  <br>
  <label>Passengers:</label>
  <input type="number" name="passengers" min="1" value="<?php echo $passengers; ?>"><br>
  <span class="error">* <?php echo $passengersErr;?></span>

  <br>
  <button type="submit" class="hover-link">Search Buses</button>
  <br><br><br><br><br><br><br><br>
</form> 

<footer>
<p>Contact Us:- &nbsp;&nbsp;&nbsp; Email: support@busbooking.com<br>
Phone: +91-1234567890<br>
&copy; 2025 Bus Booking System. All rights reserved.<br>
</p>
</footer>
<a href="Booking.txt">Saved Data</a>
</body>
</html>
