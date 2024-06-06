<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">

            <?php
                include("connection.php");

                if(isset($_POST['submit'])) {
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $password = mysqli_real_escape_string($conn, $_POST['password']);

                    $result = mysqli_query($conn, "SELECT * FROM users WHERE Email='$email' AND Password=md5('$password')") or die("Select Error");
                    $row = mysqli_fetch_assoc($result);

                    if(is_array($row) && !empty($row)) {
                        $_SESSION['valid'] = $row['Email'];
                        $_SESSION['username'] = $row['Username'];
                        $_SESSION['age'] = $row['Age'];
                        $_SESSION['id'] = $row['Id'];

                    if ($row['Role'] === 'admin') {
                        $_SESSION['logged_in'] = true;
                        date_default_timezone_set('Asia/Beirut');
                        $present_time = date("H:i:s-m/d/y");
                        $expiry = 30 * 24 * 60 * 60 + time();
                        setcookie("Lastvisit", $present_time, $expiry);

                        $_SESSION['Role'] = 'admin';
                        header("Location: admin_dashboard.php");
                    } else {
                        $_SESSION['logged_in'] = true;
                        date_default_timezone_set('Asia/Beirut');
                        $present_time = date("H:i:s-m/d/y");
                        $expiry = 30 * 24 * 60 * 60 + time();
                        setcookie("Lastvisit", $present_time, $expiry);

                        $_SESSION['Role'] = 'user';
                        header("Location: user_dashboard.php");
                    }
                    } else {
                        echo "<div class='message'>
                            <p>Invalid username or password.</p>
                        </div> <br>";
                        echo "<a href='signin.php'>
                            <button class='btn'>Go Back</button>";
                    }
                }else{
            ?>

            <div class="exit-icon">&times;</div>
            <header>Sign In</header>

            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" required />
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required />
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Sign In" required />
                </div>
                <br />
                <div class="links">
                    Don't have an account? <a href="signup.php">Sign Up Now</a>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
    <script src="login.js"></script>
</body>
</html>
