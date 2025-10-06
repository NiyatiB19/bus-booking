<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}


$pnr = $newdate = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["pnr"])) {
        $error = "PNR Number is required.";
    } elseif (!preg_match("/^[0-9]{6,10}$/", $_POST["pnr"])) {  
       
        $error = "PNR must be between 6 to 10 digits.";
    } elseif (empty($_POST["newdate"])) {
        $error = "New Date is required.";
    } elseif ($_POST["newdate"] < date("Y-m-d")) {
        $error = "New Date cannot be in the past.";
    } else {
        $pnr = htmlspecialchars($_POST["pnr"]);
        $newdate = $_POST["newdate"];
        $error = " Ticket Reschedule request submitted successfully for PNR: $pnr on $newdate.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
 <style>
     body {
  font-family: Arial;
  padding: 10px;
  background-color: rgb(142, 232, 232);
        }
form {
  background-color: rgb(142, 232, 232);
  padding: 20px;
  margin-top: 10px;
   text-align: center;
   color: black;
}
header, footer {
  background-color:  #333;
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
#message {
       font-weight: bold;
       margin-top: 10px;
       color: darkred;
     }
 </style>  
</head>
<body>
<header>
  <img src="Bus.jpg" width="50" height="100">
<h2>Reschedule Ticket</h2>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="Home.php"  style="color:aliceblue;">HOME</a>
</header>

<form method="post" action="">
  <br><br><br>
  <label>PNR Number:</label>
  <input type="text" name="pnr" value="<?php echo $pnr; ?>"><br>
  <br>
  <label>New Date:</label>
  <input type="date" name="newdate" value="<?php echo $newdate; ?>"><br>
  <br>
  <button type="submit" class="hover-link">Reschedule</button>
  <p id="message"><?php echo $error; ?></p>
  <br><br><br><br><br><br><br><br><br>
</form>

<footer>
 <p>Contact Us:- &nbsp;&nbsp;&nbsp;  Email: support@busbooking.com<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Phone: +91-1234567890<br>
      &copy; 2025 Bus Booking System. All rights reserved.<br>
      </p>
</footer>
</body>
</html>
