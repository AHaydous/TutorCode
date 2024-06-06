<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $loggedIn = true;
} else {
    $loggedIn = false;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="book.css">
    <script defer src="activePage.js"></script>
    <style>
        .alert {
            position: fixed;
            top: 45px;
            left: 0;
            width: 100%;
            padding: 10px;
            background-color: #2cb04b;
            color: white;
            text-align: center;
        }
    </style>
    <script>
        function showAlert(message) {
            var alertBox = document.createElement('div');
            alertBox.className = 'alert';
            alertBox.textContent = message;
            document.body.appendChild(alertBox);

            setTimeout(function() {
                document.body.removeChild(alertBox);
            }, 3000);
        }
    </script>

</head>
<body>
<nav>
    <ul>
        <?php include 'header.php'; ?>
    </ul>
</nav>
<div class="content">
    <section class="offers">
        <div class="offer-box">
            <h3>Offer 1</h3>
            <p>Online tutoring all levels</p>
            <p>1 to 1 Price: $40/hour</p>
            <p>group tutoring Price: $30/hour</p>
        </div>
        <div class="offer-box">
            <h3>Offer 2</h3>
            <p>Website Development</p>
            <p>Frontend & Backend</p>
            <p>Price: ranges from $400 to $700</p>
        </div>
        <div class="offer-box">
            <h3>Offer 3</h3>
            <p>Coding</p>
            <p>Java & Python</p>
            <p>Price: ranges from $150 to $300</p>
        </div>
    </section>
    <div class="booking">
        <?php
        include("connection.php");

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $service = isset($_POST['service']) ? $_POST['service'] : 'N/A';
            $deadline = isset($_POST['date']) && isset($_POST['time']) ? $_POST['date'] . ' ' . $_POST['time'] : 'N/A';
            $message = $_POST['message'];

            if (!empty($_FILES['file']['name'])) {
                $file = $_FILES['file'];
                $filename = $file['name'];
                $filetmp = $file['tmp_name'];
                $fileSize = $file['size'];

                $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'zip', 'java'];
                $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                if (!in_array($fileExtension, $allowedExtensions)) {
                    echo '<script>showAlert("Error: Invalid file type.");</script>';
                    exit;
                }

                $maxFileSize = 5 * 1024 * 1024;
                if ($fileSize > $maxFileSize) {
                    echo '<script>showAlert("Error: File size exceeds the limit.");</script>';
                    exit;
                }

                $sanitizedFilename = preg_replace("/[^a-zA-Z0-9_.]/", "_", $filename);
                $uniqueFilename = uniqid() . '_' . $sanitizedFilename;

                $uploadDirectory = "C:/Users/User/OneDrive/Desktop/uploadsTutorCode/";

                $destination = $uploadDirectory . $uniqueFilename;
                if (!move_uploaded_file($filetmp, $destination)) {
                    echo '<script>showAlert("Error: Failed to move the uploaded file.");</script>';
                    exit;
                }
            }

            $query = "INSERT INTO bookings (name, email, service, deadline, message, file_name, file_size) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssssssi", $name, $email, $service, $deadline, $message, $uniqueFilename, $fileSize);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo '<script>showAlert("Booking saved successfully.");</script>';
            } else {
                echo '<script>showAlert("Error: Unable to save booking.");</script>';
            }

            mysqli_stmt_close($stmt);
        }
        ?>

        <form class="booking-form" method="post" enctype="multipart/form-data">
            <table class="form">
                <tr>
                    <td><label for="name">Name:</label></td>
                    <td><input type="text" id="name" name="name" required></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" id="email" name="email" required></td>
                </tr>
                <tr>
                    <td><label for="service">Service:</label></td>
                    <td>
                        <select id="service" name="service">
                            <option disabled selected>Select offer</option>
                            <option value="tutoring">Offer 1</option>
                            <option value="web">Offer 2</option>
                            <option value="coding">Offer 3</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="deadline">Deadline:</label></td>
                    <td>
                        <input type="date" id="date" name="date">
                        <input type="time" id="time" name="time">
                    </td>
                </tr>
                <tr>
                    <td><label for="message">Message:</label></td>
                    <td><textarea id="message" name="message" required></textarea></td>
                </tr>
                <tr>
                    <td><label for="file">Upload File:</label></td>
                    <td><input type="file" id="file" name="file"></td>
                </tr>
            </table>
            <button class="book" type="submit" name="submit" value="Book">Book</button>
        </form>
        <div class="left">
            <h1 class="title">Book a Service</h1>
            <img src="https://th.bing.com/th/id/R.0047e8c16bb131570062f12df9a40e69?rik=Z%2b724tB3AL5tig&riu=http%3a%2f%2fwww.clipartbest.com%2fcliparts%2fMcL%2fMxE%2fMcLMxEeXi.png&ehk=X2w12gvYlVDA4QhSmogXvrtgw%2b6U2rQx77Ou39CAQ08%3d&risl=&pid=ImgRaw&r=0">
        </div>
    </div>
</div>
<footer>
    <p>&copy; 2023 TutorCode. All rights reserved.</p>
</footer>
</body>
</html>
