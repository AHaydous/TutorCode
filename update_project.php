<?php
include("connection.php");

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $isFree = isset($_POST['is_free']) ? $_POST['is_free'] : 0;

    if ($_FILES['projectFile']['error'] === UPLOAD_ERR_OK) {
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

        $stmt = $conn->prepare("UPDATE projects SET name = ?, description = ?, price = ?, is_free = ?, file_path = ? WHERE id = ?");
        $stmt->bind_param("ssidsi", $name, $description, $price, $isFree, $destination, $id);
    } else {
        $stmt = $conn->prepare("UPDATE projects SET name = ?, description = ?, price = ?, is_free = ? WHERE id = ?");
        $stmt->bind_param("ssidi", $name, $description, $price, $isFree, $id);
    }

    if ($stmt->execute()) {
        echo "Project updated successfully.";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error updating project: " . $stmt->error;
    }

    $stmt->close();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
        $isFree = $row['is_free'];
    } else {
        echo "Project not found.";
        exit();
    }

    $stmt->close();
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="updateProject.css" />
    <title>Update Project</title>
</head>
<body>
    <h1>Update Project</h1>

    <div class="container">
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <label for="name">Project Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" /><br /><br />

            <textarea id="description" name="description">
                <?php echo $description; ?>
            </textarea><br /><br />

            <label for="projectFile">Project File:</label>
            <input type="file" name="projectFile" /><br /><br />

            <div class="checkbox-group">
                <label for="is_free" style="margin-right: 1px;">Is Free:</label>
                <input type="checkbox" id="is_free" name="is_free" <?php if($isFree) echo "checked"; ?> />
            </div>
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" value="<?php echo $price; ?>" /><br /><br />
            <div class="button-group">
                <input type="submit" name="submit" value="Update" />
                <button id="back-button" onclick="goBack()">Back</button>
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
