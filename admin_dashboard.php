<?php
session_start();

include("connection.php");
if (!isset($_SESSION['valid'])) {
    header("Location: signin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eventName = $_POST['event_name'];
    $eventDescription = $_POST['event_description'];
    $eventDateTime = $_POST['event_datetime'];
    $eventName = mysqli_real_escape_string($conn, $eventName);
    $eventDescription = mysqli_real_escape_string($conn, $eventDescription);
    $eventDateTime = date('Y-m-d H:i:s', strtotime($eventDateTime));

    $query = "INSERT INTO events (name, description, date) VALUES ('$eventName', '$eventDescription', '$eventDateTime')";

    if (mysqli_query($conn, $query)) {
        $EventsuccessMessage = "Event added successfully.";
    } else {
        $EventerrorMessage = "Error adding event: " . mysqli_error($conn);
    }
}

if (isset($_GET['delete_project'])) {
    $projectID = $_GET['delete_project'];

    include("connection.php");

    $query = "DELETE FROM projects WHERE id = '$projectID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $deleteSuccessMessage = "Project deleted successfully.";
    } else {
        $deleteErrorMessage = "Error: Unable to delete project.";
    }

    mysqli_close($conn);
}

if (isset($_GET['delete_user'])) {
    $userID = $_GET['delete_user'];

    include("connection.php");

    $query = "DELETE FROM users WHERE Id = '$userID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $UserdeleteSuccessMessage = "User deleted successfully.";
    } else {
        $UserdeleteErrorMessage = "Error: Unable to delete user.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="adminDash.css" />
    <script defer src="activePage.js"></script>
    <title>Admin Dashboard</title>

    <script>
        setTimeout(function() {
            var deleteMessage = document.getElementById("delete-message");
            if (deleteMessage) {
                deleteMessage.style.display = "none";
            }
        }, 3000);

        setTimeout(function() {
            var UserdeleteMessage = document.getElementById("Userdelete-message");
            if (UserdeleteMessage) {
                UserdeleteMessage.style.display = "none";
            }
        }, 3000);

                setTimeout(function() {
            var EventMessage = document.getElementById("Event-message");
            if (EventMessage) {
                EventMessage.style.display = "none";
            }
        }, 3000);
    </script>
</head>
<body>
    <nav>
        <ul>
            <?php include 'header.php'; ?>
        </ul>
    </nav>

    <h1>Welcome Admin</h1>
    <?php
    if (isset($_COOKIE["Lastvisit"])) {
        echo "<p class='lastVisit'>Last Visited on " . $_COOKIE["Lastvisit"] . "</p>";
    } else {
        echo "<p class='lastVisit'>You have some old cookies</p>";
    }
    ?>
    <br>
    <section>
        <h2>Projects</h2>
        <table>
            <tr>
                <th>Project ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price($)</th>
                <th>Action</th>
            </tr>
            <?php
            include("connection.php");

            $query = "SELECT * FROM projects";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $title = $row['name'];
                    $description = $row['description'];
                    $price = $row['price'];

                    echo "<tr>";
                    echo "<td>$id</td>";
                    echo "<td>$title</td>";
                    echo "<td>$description</td>";
                    echo "<td>$price</td>";
                    echo "<td><a href='update_project.php?id=$id' class='button'>Update</a> | <a href='?delete_project=$id' class='button'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No projects found.</td></tr>";
            }

            mysqli_close($conn);
            ?>
        </table>
        <br />

        <?php if (isset($deleteSuccessMessage)) : ?>
        <p id="delete-message">
            <?php echo $deleteSuccessMessage; ?>
        </p>
        <?php elseif (isset($deleteErrorMessage)) : ?>
        <p id="delete-message">
            <?php echo $deleteErrorMessage; ?>
        </p>
        <?php endif; ?>

        <br />
        <a href="add_project.php" class="button">Add Project</a>
    </section>

    <section>
        <h2>Events</h2>
        <div class="flex-container">
            <div class="form-container">
                <form action="" method="post">
                    <label for="event_name">Event Name:</label>
                    <input type="text" id="event_name" name="event_name" required /><br />

                    <label for="event_description">Event Description:</label>
                    <textarea id="event_description" name="event_description" required></textarea><br />

                    <label for="event_datetime">Event Date and Time:</label>
                    <input type="datetime-local" id="event_datetime" name="event_datetime" required /><br />

                    <?php if (isset($successMessage)) : ?>
                    <p id="success-message">
                        <?php echo $successMessage; ?>
                    </p>
                    <?php endif; ?>

                    <br />
                    <button type="submit" class="button">Add Event</button>
                </form>

                <?php if (isset($EventsuccessMessage)) : ?>
                <p id="Event-message" class="eventMessage">
                    <?php echo $EventsuccessMessage; ?>
                </p>
                <?php elseif (isset($EventerrorMessage)) : ?>
                <p id="Event-message" class="eventMessage">
                    <?php echo $EventerrorMessage; ?>
                </p>
                <?php endif; ?>
            </div>

            <div class="image-container">
                <img src="https://icoservice.co/img/blog/story_ser_22.png" />
            </div>
        </div>
    </section>

    <section>
        <h2>Users</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php
            include("connection.php");

            $query = "SELECT * FROM users WHERE Role='user'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['Id'];
                    $name = $row['Username'];
                    $email = $row['Email'];

                    echo "<tr>";
                    echo "<td>$id</td>";
                    echo "<td>$name</td>";
                    echo "<td>$email</td>";
                    echo "<td><a href='?delete_user=$id' class='button'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No users found.</td></tr>";
            }

            mysqli_close($conn);
            ?>
        </table>
        <br />

        <?php if (isset($UserdeleteSuccessMessage)) : ?>
        <p id="Userdelete-message">
            <?php echo $UserdeleteSuccessMessage; ?>
        </p>
        <?php elseif (isset($UserdeleteErrorMessage)) : ?>
        <p id="Userdelete-message">
            <?php echo $UserdeleteErrorMessage; ?>
        </p>
        <?php endif; ?>

    </section>

    <footer>
        <p>&copy; 2023 TutorCode. All rights reserved.</p>
    </footer>
</body>
</html>
