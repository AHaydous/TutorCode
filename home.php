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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Home</title>
    <link rel="stylesheet" href="home.css">
    <script defer src="activePage.js"></script>

</head>
<body>
    <header>
        <nav>
            <ul>
                <?php include 'header.php'; ?>
            </ul>
        </nav>
        <div class="head">
            <h1>TutorCode</h1>
            <h2>Your One-Stop Destination for Coding</h2>
            <pre class="code">
            <code id="codeSnippet"></code>
</pre>

        </div>
    </header>



    <footer>
        <p>&copy; 2023 TutorCode. All rights reserved.</p>
    </footer>

    <script src="home.js"></script>
</body>
</html>