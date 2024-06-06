<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <?php
            include("connection.php");

            if (isset($_POST['submit'])) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $age = $_POST['age'];
                $password = $_POST['password'];

                $verify_query = mysqli_query($conn, "SELECT Email FROM users WHERE Email='$email'");

                if (mysqli_num_rows($verify_query) != 0) {
                    echo "<div class='message'>
                        <p>This email is already used. Please try another one.</p>
                    </div><br>";
                    echo "<a href='javascript:self.history.back()'>
                        <button class='btn'>Go Back</button>";
                } else {
                    $role = 'user';

                    if ($email === 'admin@gmail.com' && $password === 'admin1234') {
                        $role = 'admin';
                    }

                    mysqli_query($conn, "INSERT INTO users (Username, Email, Age, Password, Role)
                        VALUES ('$username', '$email', '$age', md5('$password'), '$role')")
                        or die("Error Occurred");

                    header("Location: signin.php");
                }
            } else {
            ?>
            <div class="exit-icon">&times;</div>
            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required />
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" required />
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" autocomplete="off" required />
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required />
                </div>

                <div class="field">

                    <input type="submit" class="btn" name="submit" value="Sign Up" required />
                </div>
                <br />
                <div class="links">
                    Already a member? <a href="signin.php">Sign In</a>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
    <script src="login.js"></script>
</body>
</html>