<li>
    <a href="home.php">Home</a>
</li>
<li>
    <a href="contact.php">Contact</a>
</li>
<li>
    <a href="services.php">Services</a>
</li>
<li>
    <a href="projects.php">Projects</a>
</li>
<li>
    <a href="book.php">Book</a>
</li>
<?php
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {  
    if (isset($_SESSION['Role']) && $_SESSION['Role'] === 'admin') {
        echo '<li><a href="admin_dashboard.php">Dash</a></li>';
    } else {
        echo '<li><a href="user_dashboard.php">Dashboard</a></li>';
    }

    echo '<li><a href="logout.php">Logout</a></li>';
    echo '<style>nav { padding-left: 600px; }</style>';

    $current_page = basename($_SERVER['PHP_SELF']);

    if ($current_page === 'projects.php') {
        echo '<style>nav { padding-left: 550px; }</style>';
    }
} else {
    echo '<li><a href="signin.php">Login</a></li>';
}
?>
