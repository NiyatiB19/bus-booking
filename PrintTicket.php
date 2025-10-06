<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}
?>

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
     .error {
        color: red;
        font-weight: bold;
     }
     #message {
        font-weight: bold;
        margin-top: 10px;
     }
   </style> 
</head>
<body>

<?php
$emailErr = $ticketErr = "";
$email = $ticket = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["ticket"])) {
        $ticketErr = "Ticket number is required";
    } else {
        $ticket = test_input($_POST["ticket"]);
        if (!preg_match("/^[0-9]{6,10}$/", $ticket)) {
            $ticketErr = "Ticket number must be 6–10 digits only";
        }
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
  <h2>Print Your Ticket</h2>
  <a href="Home.php" style="color:aliceblue;">HOME</a>
</header>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
 <br><br><br><br>

 <label for="email">Email:</label>
 <input type="text" id="email" name="email" value="<?php echo $email; ?>">
 <span class="error">* <?php echo $emailErr; ?></span>
 <br><br>

 <label>Ticket Number:</label>
 <input type="text" id="ticket" name="ticket" value="<?php echo $ticket; ?>">
 <span class="error">* <?php echo $ticketErr; ?></span>
 <br><br>

 <button type="submit" class="hover-link">Print</button>
 <br>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && $emailErr=="" && $ticketErr=="") {
    echo "<h3 style='color:green; text-align:center;'>Ticket Found! Ready to Print.</h3>";
    echo "<p><b>Details:</b></p>";
    echo "Email: $email <br>";
    echo "Ticket Number: $ticket <br>";
}
?>

<br><br><br><br><br><br><br><br><br>

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
