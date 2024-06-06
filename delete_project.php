<?php
if (isset($_GET['id'])) {
    $projectID = $_GET['id'];

    include("connection.php");

    $query = "DELETE FROM projects WHERE id = '$projectID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Project deleted successfully.";
    } else {
        echo "Error: Unable to delete project.";
    }

    mysqli_close($conn);
} else {
    echo "Project ID not provided.";
}
?>
