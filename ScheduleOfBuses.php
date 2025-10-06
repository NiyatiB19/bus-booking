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
  text-align: center;
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
table{
   background-color: rgb(142, 232, 232);
   margin: 50px auto;
  padding: 20px;
  margin-top: 10px;
   text-align: center;
   color: black;  
}
hover-link { 
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
<header>
  <img src="Bus.jpg" width=""50" height="100">
<h2>Bus Schedule</h2>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="Home.php"  style="color:aliceblue;">HOME</a>
</header>
<table border="2" align="center">
  <tr><th>Route</th><th>Time</th><th>Days</th></tr>
  <tr><td>Ahmedabad to Surat</td><td>09:00 AM</td><td>Mon–Sun</td></tr>
  <tr><td>Rajkot to Bhuj</td><td>05:00 PM</td><td>Mon–Sat</td></tr>
   <tr><td>Mumbai to Vadodra</td><td>06:30 AM</td><td>Mon–Thu</td></tr>
    <tr><td>Navsari to Rajkot</td><td>07:00 PM</td><td>Mon–Sun</td></tr>
     <tr><td>Ahmedabad to Junagadh</td><td>11:00 AM</td><td>Mon–Sat</td></tr>
<br><br><br></table>
<form>
<button type="submit" class="hover-link"><a href="Booking.php">Book your tickets now </a> </button>

</form >
<?php 
echo " ";
?>
<br><br><br>
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