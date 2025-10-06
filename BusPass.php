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
    background: rgb(142, 232, 232);
    padding: 20px;
    margin-top: 10px;
    text-align: center;
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
    text-decoration: none;
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
 </style>  
</head>
<body>

<?php
$nameErr = $typeErr = $routeErr = "";
$name = $type = $route = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            $nameErr = "Only letters and spaces allowed";
        }
    }

    if (empty($_POST["type"])) {
        $typeErr = "Please select type";
    } else {
        $type = test_input($_POST["type"]);
    }

    if (empty($_POST["route"])) {
        $routeErr = "Route is required";
    } else {
        $route = test_input($_POST["route"]);
        if (!preg_match("/^[a-zA-Z0-9 ]*$/",$route)) {
            $routeErr = "Only letters, numbers and spaces allowed";
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
  <h2>Bus Pass Application</h2>
  <a href="Home.php" style="color:aliceblue;">HOME</a>
</header>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><br><br>
  <label>Name:</label>
  <input type="text" id="name" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>

  <label>Student/Regular:</label>
  <select id="type" name="type">
    <option value="">--Select--</option>
    <option value="Student" <?php if($type=="Student") echo "selected";?>>Student</option>
    <option value="Regular" <?php if($type=="Regular") echo "selected";?>>Regular</option>
  </select>
  <span class="error">* <?php echo $typeErr;?></span>
  <br><br>

  <label>Route:</label>
  <input type="text" id="route" name="route" value="<?php echo $route;?>">
  <span class="error">* <?php echo $routeErr;?></span>
  <br><br>

  <button type="submit" class="hover-link">Apply for Pass</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && $nameErr=="" && $typeErr=="" && $routeErr=="") {
    echo "<h3 style='color:green; text-align:center;'>Form Submitted Successfully!</h3>";
    echo "<p><b>Your Details:</b></p>";
    echo "Name: $name <br>";
    echo "Type: $type <br>";
    echo "Route: $route <br>";
}
?>

<br><br><br><br><br><br>

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
