<?php
session_start();
session_unset();
session_destroy();

// Clear cookies
setcookie("email", "", time() - 3600, "/");
setcookie("password", "", time() - 3600, "/");

header("Location: Home.php");
exit();
?>