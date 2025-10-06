<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}
?>

<?php
$pnr = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["pnr"])) {
        $message = "PNR number is required!";
    } else {
        $pnr = trim($_POST["pnr"]);
        if (!ctype_digit($pnr)) {
            $message = "PNR must contain only numbers!";
        } elseif (strlen($pnr) != 6) { 
            $message = "PNR must be exactly 6 digits!";
        } else {
            $message = "✅ Tracking bus with PNR: " . htmlspecialchars($pnr);
            // Later you can add database lookup here
        }
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
      background-color: #333;
      color: white;
      padding: 10px;
      text-align: center;
      display: flex;
      justify-content: space-around;
      align-items: center;
    } 
    .hover-link { 
        color: #007BFF; 
        transition: color 0.3s, background-color 0.3s; 
        padding: 10px 15px; 
        border: 2px solid transparent; 
        cursor: pointer;
    } 
    .hover-link:hover { 
        color: whitesmoke; 
        background-color: red;
        border: 2px solid black; 
    } 
    #message {
      font-weight: bold;
      margin-top: 10px;
      color: darkblue;
    }
  </style>
</head>
<body>
    <header>
      <img src="Bus.jpg" width="50" height="100">
      <h2>Track Your Bus</h2>
      <a href="Home.php" style="color:aliceblue;">HOME</a>
    </header> 

    <form id="trackBus" method="post" action="">
      <br><br><br><br>
      <label>Enter PNR Number:</label>
      <input type="text" id="pnr" name="pnr" value="<?php echo htmlspecialchars($pnr); ?>">
      <br><br><br><br>
      <button type="submit" class="hover-link">Track</button>
      <p id="message"><?php echo $message; ?></p>
      <br><br><br><br><br><br><br><br><br><br><br><br>
    </form>  

    <footer>
      <p>Contact Us:- &nbsp;&nbsp;&nbsp; Email: support@busbooking.com<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Phone: +91-1234567890<br>
        &copy; 2025 Bus Booking System. All rights reserved.<br>
      </p>
    </footer>
</body>
</html>
