<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $loggedIn = true;
} else {
    $loggedIn = false;
}
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="services.css">
    <script defer src="activePage.js"></script>

</head>
<body>
    <header>
        <nav>
            <ul>
                <?php include 'header.php'; ?>
            </ul>
        </nav>
    </header>

    <div class="content">
        <h1>Our Services</h1>
        <div class="top">
            <div class="left">
                <div class="t"><h2>Tutoring</h2></div>
                <div class="c"><p>Looking to learn a new programming language? Our experienced tutors are here to help! We offer online sessions for students of all skill levels, from beginners to advanced. Our tutors are experts in Java, Python, and web development using HTML, CSS, and JavaScript. Book a session today and start your coding journey!</p></div>
            </div>
            <div class="right">
                <div class="t"><h2>Coding</h2></div>
                <div class="c"><p>Stuck on a coding problem or need help with a project? Our team of coding experts is here to help. Simply send us a message detailing your problem and our team will get back to you as soon as possible. Don't let coding problems slow you down, let us help you get back on track.</p></div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 TutorCode. All rights reserved.</p>
    </footer>
</body>
</html>