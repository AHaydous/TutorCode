<?php

if (isset($_GET['Id'])) {
    $userID = $_GET['Id'];

    include("connection.php");

    $query = "DELETE FROM users WHERE Id = '$userID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "User deleted successfully.";
    } else {
        echo "Error: Unable to delete user.";
    }

    mysqli_close($conn);
} else {
    echo "User ID not provided.";
}
?>
