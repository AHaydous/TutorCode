<?php
    include("connection.php");
    session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: signin.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $projectName = $_POST['projectName'];
        $projectDescription = $_POST['projectDescription'];
        $isFree = isset($_POST['isFree']) ? 1 : 0;
        $price = isset($_POST['price']) ? $_POST['price'] : null;

        $file = $_FILES['projectFile'];
        $fileName = $file['name'];
        $fileTmp = $file['tmp_name'];
        $fileSize = $file['size'];

        $uploadDirectory = "C:/Users/User/OneDrive/Desktop/TutorCodeProjects/";

        $sanitizedFileName = preg_replace("/[^a-zA-Z0-9_.]/", "_", $fileName);
        $uniqueFileName = uniqid() . '_' . $sanitizedFileName;

        $destination = $uploadDirectory . $uniqueFileName;
        if (!move_uploaded_file($fileTmp, $destination)) {
            $error = "Error uploading project file.";
        }

        $stmt = $conn->prepare("INSERT INTO projects (name, description, is_free, price, file_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssids", $projectName, $projectDescription, $isFree, $price, $destination);

        if ($stmt->execute()) {
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Error adding project: " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Project</title>
    <link rel="stylesheet" href="addProject.css" />

</head>
<body>
    <h1>Add New Project</h1>
    <?php if (isset($error)) { ?>
    <p>
        Error: <?php echo $error; ?>
    </p>
    <?php } ?>
    <div class="container">
        <form method="post" action="add_project.php" enctype="multipart/form-data">
            <label for="projectName">Project Name:</label>
            <input type="text" name="projectName" required />

            <label for="projectDescription">Project Description:</label>
            <textarea name="projectDescription" required></textarea>

            <label for="projectFile">Project File:</label>
            <input type="file" name="projectFile" required />

            <div class="checkbox-group">
                <label for="isFree">Is Free</label>
                <input type="checkbox" name="isFree" id="isFree" />               
            </div>

            <label for="price">Price:</label>
            <input type="number" name="price" step="0.01" />

            <div class="button-group">
                <input type="submit" value="Add Project" />
                <button onclick="goBack()">Back</button>
            </div>
        </form>
    </div>

    <script>
    function goBack() {
        window.history.back();
    }
    </script>
</body>
</html>
