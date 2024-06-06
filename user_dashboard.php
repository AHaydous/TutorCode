<?php
    session_start();

    include("connection.php");
    if(!isset($_SESSION['valid'])){
        header("Location: signin.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="dash.css" />
    <script defer src="activePage.js"></script>
    <title>Dash</title>
</head>
<body>
    <nav>
        <ul>
            <?php include 'header.php'; ?>
        </ul>
    </nav>

    <div class="right-links">
        <?php
        $id = $_SESSION['id'];
        $query = mysqli_query($conn, "SELECT * FROM users WHERE Id = $id");

            while($result = mysqli_fetch_assoc($query)){
                $res_Uname = $result['Username'];
                $res_Email = $result['Email'];
                $res_Age = $result['Age'];
                $res_id = $result['Id'];
            }
            echo "<a href='edit.php?Id=$res_id' class='button'>Change Profile</a>";
        ?>
    </div>

    <main>
        <h1>Welcome <?php echo $res_Uname ?></h1>
        <?php
        if (isset($_COOKIE["Lastvisit"])) {
            echo "<p class='lastVisit'>Last Visited on " . $_COOKIE["Lastvisit"] . "</p>";
        } else {
            echo "<p class='lastVisit'>You have some old cookies</p>";
        }
        ?>
        
        <div class="main-box">
            <div class="box">
                <h2>Projects Bought</h2>
                <?php       
        $query = mysqli_query($conn, "SELECT projects.name, projects.price FROM projects INNER JOIN boughtProjects ON projects.id = boughtProjects.project_id WHERE boughtProjects.buyer_id = $id");

        if(mysqli_num_rows($query) > 0) {
            echo "<ul>";
            while($row = mysqli_fetch_assoc($query)) {
                echo "<li>" . $row['name'] . " - $" . $row['price'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No projects bought yet.</p>";
        }
                ?>
            </div>

            <div class="box">
                <h2>Services Booked</h2>
                <div class="container">
                    <div class="servicesInfo">
                <?php
                    $email = mysqli_real_escape_string($conn, $res_Email);
                    $query = mysqli_query($conn, "SELECT * FROM bookings WHERE email = '$email'");

                    if(mysqli_num_rows($query) > 0) {
                        echo "<ul>";
                        while($row = mysqli_fetch_assoc($query)) {
                        echo "<li><span style='color: #a7eeb8;'>Service:</span> <span style='color: #88a5ba;'>" . $row['service'] . "</span></li>";
                        echo "<li><span style='color: #a7eeb8;'>Date: </span> <span style='color: #88a5ba;'>". $row['deadline'] . "</li>";
                            echo "<li><span style='color: #a7eeb8;'>Message:</span> <span style='color: #88a5ba;'>". $row['message'] . "</li>";
                            echo "<br>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>No services booked yet.</p>";
                    }
                ?>
                    </div>
                    <div class="ServicesImg">
                        <img src="https://intellectualpoint.com/wp-content/uploads/2020/09/Program-Coding-2048x2048.png" />
                    </div>
                </div>
            </div>

            <div class="box">
                <h2>Upcoming Events</h2>
                <div class="container">
                    <div class="eventsInfo">
                        <?php
            $currentDateTime = date('Y-m-d H:i:s');
            $query = mysqli_query($conn, "SELECT * FROM bookings WHERE email = '$res_Email' AND deadline >= '$currentDateTime'");

            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<p><span style='color: #a7eeb8;'>Booking:</span> <span style='color: #88a5ba;'>" . $row['service'] . "</p>";
                    echo "<p><span style='color: #a7eeb8;'>Date:</span> <span style='color: #88a5ba;'>" . $row['deadline'] . "</p>";
                    echo "<p><span style='color: #a7eeb8;'>Details:</span> <span style='color: #88a5ba;'>" . $row['message'] . "</p>";
                    echo "<br>";
                }
            } else {
                echo "<p>No bookings found.</p>";
            }

            $eventQuery = mysqli_query($conn, "SELECT * FROM events WHERE date >= '$currentDateTime'");

            if (mysqli_num_rows($eventQuery) > 0) {
                while ($eventRow = mysqli_fetch_assoc($eventQuery)) {
                    echo "<p><span style='color: #a7eeb8;'>Event:</span> <span style='color: #88a5ba;'>" . $eventRow['name'] . "</p>";
                    echo "<p><span style='color: #a7eeb8;'>Date:</span> <span style='color: #88a5ba;'>" . $eventRow['date'] . "</p>";
                    echo "<p><span style='color: #a7eeb8;'>Details:</span> <span style='color: #88a5ba;'>" . $eventRow['description'] . "</p>";
                    echo "<br>";
                }
            } else {
                echo "<p>No events found.</p>";
            }
                        ?>
                    </div>
                    <div class="speakerImg">
                        <img src="https://e-learn.cisateducation.com/wp-content/uploads/2020/07/flat_megaphone.png" />
                    </div>
                </div>
            </div>


        </div>
    </main>

    <footer>
        <p>&copy; 2023 TutorCode. All rights reserved.</p>
    </footer>
</body>
</html>
