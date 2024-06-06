<?php
session_start();
include("connection.php");

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $loggedIn = true;
} else {
    $loggedIn = false;
}

if (isset($_POST['action'])) {
    $projectId = $_POST['project_id'];
    $action = $_POST['action'];

    if ($action === 'download') {
        if ($loggedIn) {           
            $sql = "SELECT file_path FROM projects WHERE id = $projectId";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $filePath = $row['file_path'];

                if (file_exists($filePath)) {
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename=' . basename($filePath));
                    header('Content-Length: ' . filesize($filePath));
                    readfile($filePath);
                    exit;
                } else {
                    echo "File not found.";
                }
            } else {
                echo "Project not found.";
            }
        } else {
            header("Location: signin.php");
            exit();
        }
    } elseif ($action === 'buy') {
        if ($loggedIn) {
            header("Location: purchase.php?project_id=$projectId");
            exit();
        }else{
            header("Location: signin.php");
            exit();
        }
    }
}

if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];

    $sql = "SELECT * FROM projects WHERE name LIKE '%$searchTerm%'";
    $result = $conn->query($sql);

    $filteredProjects = array();
    while ($row = $result->fetch_assoc()) {
        $filteredProjects[] = $row;
    }
} else {
    $sql = "SELECT * FROM projects";
    $result = $conn->query($sql);

    $filteredProjects = array();
    while ($row = $result->fetch_assoc()) {
        $filteredProjects[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Projects</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-LfFDvGxUx9g2XOziyKTqAXUvbtbUbg+x0UTc8/zMT0i/a2vWyBxudfPhprteJpmtjROAKytzckwPAGk09nZZw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="projects.css" />
    <script defer src="activePage.js"></script>
</head>
<body>
    <nav>
        <ul>
            <?php include 'header.php'; ?>
            <li>
                <button class="toggle-btn">&#9776;</button>
            </li>
        </ul>
    </nav>

    <div class="project-container">
        <?php if (!empty($filteredProjects)) { ?>
        <?php foreach ($filteredProjects as $row) { ?>
        <div class="project-box">
            <h2>
                <?php echo $row['name']; ?>
            </h2>
            <div class="project-description">
                <div>
                    <p>
                        <?php echo $row['description']; ?>
                    </p>
                </div>
                <div>
                    <form method="post">
                        <input type="hidden" name="project_id" value="<?php echo $row['id']; ?>" />
                        <?php if ($row['is_free'] == 1) { ?>
                        <input type="hidden" name="action" value="download" />
                        <button class="project-button" name="download" value="Download" >Download</button>
                        <?php } else { ?>
                        <input type="hidden" name="action" value="buy" />
                        <button class="project-button" name="buy" value="Buy" >Buy</button>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php } else { ?>
        <p>No projects found.</p>
        <?php } ?>
    </div>



    <aside class="sidebar">
        <div class="search-bar">
            <button type="submit" id="si">&#128269;</button>
            <form method="post" action="">
                <input type="text" name="search" id="myInput" onkeyup="myFunction()" placeholder="Search" />                
                <button type="submit" name="cancel" class="cancel-button">Cancel Search</button>                
            </form>
        </div>
    </aside>

    <footer>
        <p>&copy; 2023 TutorCode. All rights reserved.</p>
    </footer>
    <script src="projects.js"></script>
</body>
</html>
