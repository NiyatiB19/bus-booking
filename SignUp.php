<?php
session_start();

$servername = "localhost";
$username = "root";   
$password = "root";   
$dbname = "bus_booking";    

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
$success = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirmPassword']); // match HTML input name


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {

        $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $hashedPassword);

            if ($stmt->execute()) {
                $success = "Signup successful! <a href='Login.php'>Login here</a>";
                $email = "";
            } else {
                $error = "Error: Could not register user.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up - Bus Ticket Booking</title>
    <style>
        body { font-family: 'Gill Sans', Calibri, sans-serif; background-color: rgb(142, 232, 232); padding: 10px; }
        main { text-align: center; color: black; padding: 20px; }
        header, footer { background-color: #333; color: white; padding: 10px; display: flex; justify-content: space-around; align-items: center; }
        input { padding: 8px; margin: 5px; width: 250px; border-radius: 5px; border: 1px solid #ccc; }
        .hover-link { padding: 10px 15px; background: #007BFF; color: white; border: none; cursor: pointer; border-radius: 5px; transition: 0.3s; }
        .hover-link:hover { background-color: red; color: white; }
        .error { color:red; font-weight:bold; }
        .success { color:green; font-weight:bold; }
    </style>
</head>
<body>
    <header>
        <img src="Bus.jpg" width="80" height="80">
        <h1>Sign Up - Bus Booking System</h1>
        <a href="Home.php" style="color:aliceblue;">HOME</a>
    </header>

    <main>
        <h2>Create Your Account</h2>
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (!empty($success)) { echo "<p class='success'>$success</p>"; } ?>

        <form method="post" action="">
            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required><br>
            <input type="password" id="password" name="password" placeholder="Password" required><br>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required><br><br>
            <button type="submit" class="hover-link">Sign Up</button>
        </form>

        <p>Already have an account? <a href="Login.php">Login</a></p>
    </main>

    <footer>
        <p>Contact Us:- Email: support@busbooking.com | Phone: +91-1234567890<br>
           &copy; 2025 Bus Booking System. All rights reserved.</p>
    </footer>
</body>
</html>
