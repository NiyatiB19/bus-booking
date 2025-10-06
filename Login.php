<?php
session_start();
$servername = "localhost";
$username   = "root";
$password   = "root";
$dbname     = "bus_booking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $hashedPassword);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['email'] = $email;
                $_SESSION['username'] = explode("@", $email)[0];

                header("Location: Home.php");
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No account found with this email.";
        }
        $stmt->close();
    }
}

// Fetch all users (optional, for admin display)
$result = $conn->query("SELECT email, created_at FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Bus Ticket Booking</title>
    <style>
        body { font-family: 'Gill Sans', Calibri, sans-serif; padding: 10px; background-color: rgb(142, 232, 232); }
        header, footer { background-color: #333; color: white; padding: 10px; display: flex; justify-content: space-around; align-items: center; }
        main { text-align: center; padding: 10px; }
        .login-box { display: flex; flex-direction: column; background-color: rgb(228, 248, 247); padding: 40px; border-radius: 10px; width: 350px; margin: 50px auto; gap: 5px; box-shadow: 10px 10px 40px rgba(0,0,0,0.2); }
        input { padding: 8px; margin: 5px; width: 250px; border-radius: 5px; border: 1px solid #ccc; }
        .hover-link { color: #007BFF; padding: 10px 15px; border: 2px solid transparent; cursor: pointer; transition: 0.3s; }
        .hover-link:hover { color: whitesmoke; background-color: red; border: 2px solid black; }
        .error { color: red; font-weight: bold; }
        table { margin: 20px auto; border-collapse: collapse; width: 60%; background: #ffffff; box-shadow: 0 4px 8px rgba(0,0,0,0.2); border-radius: 10px; overflow: hidden; }
        th, td { border: 1px solid #ccc; padding: 10px; }
        th { background-color: #00796b; color: white; text-transform: uppercase; }
    </style>
</head>
<body>
<header>
    <img src="Bus.jpg" width="50" height="100">
    <h1>Login to Bus Booking System</h1>
    <a href="Home.php" style="color:aliceblue;">HOME</a>
</header>

<main>
    <div class="login-box">
        <h2>Login</h2>
        <form method="post" action="">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <button type="submit" class="hover-link">Login</button>
        </form>
        <p class="error"><?php echo $error; ?></p>
        <p>Don't have an account? <a href="SignUp.php">Sign Up</a></p>
    </div>

    <?php if ($result && $result->num_rows > 0): ?>
        <h2>Registered Users</h2>
        <table>
            <tr><th>Email</th><th>Registered At</th></tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

</main>

<footer>
    <p>Contact Us: Email: support@busbooking.com | Phone: +91-1234567890<br>
    &copy; 2025 Bus Booking System. All rights reserved.</p>
</footer>
</body>
</html>

<?php $conn->close(); ?>
