<?php
session_start();

include("connection.php");
if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="EditProf.css" />
    <title>Change Profile</title>
</head>

<body>
    <div class="nav"></div>
    <div class="container">
        <div class="box form-box">
            <?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $password = $_POST['password'];

    $id = $_SESSION['id'];

    $edit_query = mysqli_query($conn, "UPDATE users SET Username='$username', Email='$email', Age='$age' WHERE Id=$id ") or die("error occurred");

    if (!empty($password)) {
        $hashedPassword = md5($password);

        $edit_query = mysqli_query($conn, "UPDATE users SET Password='$hashedPassword' WHERE Id=$id") or die("Error occurred");
    }
}

$id = $_SESSION['id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE Id=$id ");

while ($result = mysqli_fetch_assoc($query)) {
    $res_Uname = $result['Username'];
    $res_Email = $result['Email'];
    $res_Age = $result['Age'];
}
            ?>
            <h1>Change Profile</h1>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo $res_Uname; ?>"
                        autocomplete="off" required />
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo $res_Email; ?>" autocomplete="off"
                        required />
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" />
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo $res_Age; ?>" autocomplete="off"
                        required />
                </div>

                <div class="field">
                    <div class="btn-container">
                        <input type="submit" class="btn" name="submit" value="Update" required />
                        <a href="user_dashboard.php" id="b" class="btn">Back</a>
                    </div>
                </div>

            </form>
            <?php if (isset($_POST['submit']) && $edit_query) { ?>
            <div id="message" class="message">
                <p>Profile Updated!</p>
            </div>
            <script>
                setTimeout(function() {
                    var message = document.getElementById('message');
                    message.style.display = 'none';
                }, 3000);
            </script>
            <?php } ?>
        </div>
    </div>
</body>

</html>
