<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $loggedIn = true;
} else {
    $loggedIn = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" href="contact.css">
    <script defer src="activePage.js"></script>

</head>
<body>


    <nav>
        <ul>
            <?php include 'header.php'; ?>
        </ul>
    </nav>


    <main>
        <section class="contact-form">
            <h2>Contact us</h2>
            <form id="contact-form" method="post" action="send_email.php">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required />

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required />

                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <input type="submit" name="send" value="Send" id="submit-btn" />
            </form>
            <div id="status"></div>
        </section>

        <section class="contact-info">
            <h3>Contact Information</h3>
            <div class="links">
                <ul>
                    <li><a href="aya.haydous@gmail.com">aya.haydous@gmail.com</a></li>
                    <li><a href="tel:+1234567890">(123) 456-7890</a></li>
                    <li><a href="https://www.linkedin.com/in/aya-haydous-b9161b255/">LinkedIn</a></li>
                </ul>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 TutorCode. All rights reserved.</p>
    </footer>
    
    <script src="https://smtpjs.com/v3/smtp.js"></script>

</body>
</html>
