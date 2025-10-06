<?php
session_start();

if (!isset($_SESSION['email']) && isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    $_SESSION['username'] = "";
    $_SESSION['email'] = $_COOKIE['email'];
}

$servername = "localhost";
$username   = "root";
$password   = "root";
$dbname     = "bus_booking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT email, created_at FROM users ORDER BY id ASC");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bus Ticket Booking</title>
    <style>
        /* General styles */
        body {
            text-align: center;
            font-family: 'Gill Sans', Calibri, sans-serif;
            background-color: rgb(142, 232, 232);
            padding: 10px;
        }
        header, footer {
            text-align: center;
            background-color: #333;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
        .menu {
            position: relative;
            display: inline-block;
        }
        .menu-button {
            background-color: #f2f2f2;
            padding: 10px 20px;
            border: 1px solid #ccc;
            cursor: pointer;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 220px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            border: 1px solid #ccc;
            z-index: 1;
        }
        .dropdown-content a {
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            color: #333;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .menu:hover .dropdown-content {
            display: block;
        }
        nav {
            margin: 10px 0;
            background: #ffdcdc;
            padding: 10px;
        }
        .hover-link {
            color: #007BFF;
            transition: color 0.3s, background-color 0.3s;
            padding: 10px 15px;
            border: 2px solid transparent;
            text-decoration: none;
        }
        .hover-link:hover {
            color: black;
            background-color: aliceblue;
            border: 2px solid black;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 60%;
        }
        table, th, td { border: 1px solid black; padding: 8px; }
        th { background-color: #86ebe9; }
        .faq-question {
            cursor: pointer;
            background: #f1f1f1;
            padding: 10px;
            margin: 5px 0;
            border-left: 4px solid #86ebe9;
        }
        .faq-answer {
            display: none;
            padding: 10px;
            background: #fff;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }
        #popup {
            display: none;
            position: fixed;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -30%);
            background: white;
            border: 2px solid #000;
            padding: 20px;
            z-index: 1000;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }
        #popupOverlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Slider styles (fixed) */
        #slider {
            position: relative;
            max-width: 800px;
            margin: 20px auto;
            overflow: hidden;
            border-radius: 8px;
            background: #fff;
        }
        #slider .slide {
            display: none; /* hide all slides by default */
            width: 100%;
            height: auto;
        }
        #slider .slide img {
            display: block;
            width: 100%;
            height: auto;
        }
        #prev, #next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.5);
            color: white;
            border: none;
            padding: 10px 14px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 18px;
            z-index: 10;
        }
        #prev { left: 10px; }
        #next { right: 10px; }
        #prev:hover, #next:hover { background: rgba(0,0,0,0.7); }

        /* small-screen adjustments */
        @media (max-width: 700px) {
            table { width: 95%; }
            #slider { width: 95%; }
        }
    </style>
</head>
<body>
<header>
    <div>
        <h2>Welcome to Bus Booking System</h2>
        <h3>Hello, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Guest"; ?>!</h3>
    </div>
    <img src="Bus.jpg" width="150" height="135" alt="Bus image">
</header>

<nav>
    <a href="Login.php" class="hover-link">Login</a>
    <div class="menu">
        <div class="menu-button"> Online Users </div>
        <div class="dropdown-content">
            <a href="Booking.php" class="hover-link">Book Ticket</a>
            <a href="TrackingBus.php" class="hover-link">Track Bus</a>
            <a href="CancelTicket.php" class="hover-link">Cancel Ticket</a>
            <a href="RefundEnquiry.php" class="hover-link">Refund Enquiry</a>
            <a href="PrintTicket.php" class="hover-link">Print Ticket</a>
        </div>
    </div>
    <a href="Rescheduling.php" class="hover-link">Reschedule Ticket</a>
    <a href="ScheduleOfBuses.php" class="hover-link">Schedule Of Buses</a>
    <a href="BusPass.php" class="hover-link">Bus Pass</a>
    <a href="History.php" class="hover-link">History</a>
    <button class="hover-link" style="background:red; color:white; border:none; padding:8px 15px; border-radius:5px;">
        <a href="Logout.php" style="color:white; text-decoration:none;">Logout</a>
    </button>
</nav>

<main>
    <h3>Welcome <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Guest"; ?>!</h3>

    <h2>Book Bus Tickets Online</h2>
    <p>Use our service to check the schedule of buses, book your tickets, track your bus, apply for refunds, and more!</p>
    <p>Our online bus ticket booking platform provides a fast, secure, and convenient way to plan your journeys. Users can easily search for bus routes, view schedules, and book tickets from the comfort of their homes or on the go. The system supports real-time seat availability, ensuring that you can reserve your preferred seats without waiting in queues. In addition, passengers can track their buses, cancel or reschedule bookings, and apply for refunds directly through the platform. With a user-friendly interface, safe payment options, and instant confirmation, our service is designed to make bus travel stress-free and accessible for everyone.</p>

    <!-- FAQ Section -->
    <div>
        <div class="faq-question">➤  What is a bus ticket booking system?</div>
        <div class="faq-answer">It is an online platform to book, cancel, and manage bus tickets.</div>

        <div class="faq-question">➤ Why is online bus booking useful?</div>
        <div class="faq-answer">It saves time, offers convenience, and reduces physical travel.</div>
    </div>

    <br>
    <button id="popupBtn">Open Popup</button>
    <div id="popupOverlay"></div>
    <div id="popup">
        <p>This is an online bus ticket booking platform.</p>
        <button id="closePopup">OK</button>
    </div>

    <!-- Image Slider (fixed) -->
    <div id="slider" aria-label="Bus images slider">
        <div class="slide"><img src="Bus1.avif" alt="Bus 1"></div>
        <div class="slide"><img src="BusAd.gif" alt="Bus advertisement"></div>
        <div class="slide"><img src="Bus2.webp" alt="Bus 2"></div>

        <button id="prev" aria-label="Previous">❮</button>
        <button id="next" aria-label="Next">❯</button>
    </div>

    <!-- Display Users from Database -->
    <h2>Registered Users</h2>
    <?php
    if ($result && $result->num_rows > 0) {
        echo "<table>
                <tr><th>Email</th><th>Registered At</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".htmlspecialchars($row['email'])."</td>
                    <td>".htmlspecialchars($row['created_at'])."</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No users found.</p>";
    }

    $conn->close();
    ?>
</main>

<footer>
    <p>Contact Us: Email: support@busbooking.com | Phone: +91-1234567890<br>
    &copy; 2025 Bus Booking System. All rights reserved.</p>
</footer>

<script>
window.onload = function () {
    // FAQ toggle
    document.querySelectorAll(".faq-question").forEach(q => {
        q.addEventListener("click", () => {
            const answer = q.nextElementSibling;
            answer.style.display = answer.style.display === "block" ? "none" : "block";
        });
    });

    // Popup
    const popupBtn = document.getElementById("popupBtn");
    const popup = document.getElementById("popup");
    const popupOverlay = document.getElementById("popupOverlay");
    const closePopup = document.getElementById("closePopup");

    popupBtn.onclick = () => { popup.style.display = "block"; popupOverlay.style.display = "block"; };
    closePopup.onclick = () => { popup.style.display = "none"; popupOverlay.style.display = "none"; };
    popupOverlay.onclick = () => { popup.style.display = "none"; popupOverlay.style.display = "none"; };

    // Slider
    let currentSlide = 0;
    const slides = document.querySelectorAll("#slider .slide");
    const nextBtn = document.getElementById("next");
    const prevBtn = document.getElementById("prev");

    function showSlide(index) {
        if (!slides || slides.length === 0) return;
        slides.forEach((s, i) => {
            s.style.display = (i === index) ? "block" : "none";
        });
    }

    // initialize slider
    showSlide(currentSlide);

    if (nextBtn) {
        nextBtn.addEventListener("click", function() {
            if (!slides || slides.length === 0) return;
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener("click", function() {
            if (!slides || slides.length === 0) return;
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        });
    }

    // optional: auto-advance every 5 seconds (comment out if you don't want)
    // setInterval(function() {
    //     if (!slides || slides.length === 0) return;
    //     currentSlide = (currentSlide + 1) % slides.length;
    //     showSlide(currentSlide);
    // }, 5000);
};
</script>
</body>
</html>
