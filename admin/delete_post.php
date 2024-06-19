<?php
session_start();

// Check if admin_id is set in session
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Database connection
include 'db.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echoes of Engineers</title>
    <link rel="icon" href="../favicon.png" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts (Font Dynamo) -->

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <!-- Platform Name and Logo -->
                <div class="platform-name">
                    <img src="../favicon.png" alt="Echoes of Engineers" style="background-color: #fff;">
                    <h1>Echoes of Engineers</h1>
                </div>
                <!-- Sidebar Navigation -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <svg class="bi mr-2" width="20" height="20" fill="currentColor">
                                <use xlink:href="bootstrap-icons.svg#house-door" />
                            </svg>
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">
                            <svg class="bi mr-2" width="20" height="20" fill="currentColor">
                                <use xlink:href="bootstrap-icons.svg#person" />
                            </svg>
                            Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="post.php">
                            <svg class="bi mr-2" width="20" height="20" fill="currentColor">
                                <use xlink:href="bootstrap-icons.svg#person" />
                            </svg>
                            Posts
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">
                            <svg class="bi mr-2" width="20" height="20" fill="currentColor">
                                <use xlink:href="bootstrap-icons.svg#envelope"/>
                            </svg>
                            Messages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <svg class="bi mr-2" width="20" height="20" fill="currentColor">
                                <use xlink:href="bootstrap-icons.svg#gear"/>
                            </svg>
                            Settings
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <svg class="bi mr-2" width="20" height="20" fill="currentColor">
                                <use xlink:href="bootstrap-icons.svg#box-arrow-right" />
                            </svg>
                            Logout
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Main content -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
                <?php
                if (isset($_GET['id'])) {
                    $delete_id = decodeString($_GET['id']);
                    $query = "DELETE FROM posts WHERE id = :id and admin_id = :admin";
                    $stmt = $conn->prepare($query);
                    $stmt->bindValue(':id', $delete_id);
                    $stmt->bindValue(':admin', $_SESSION['admin_id']);

                    if ($stmt->execute()) {
                ?>
                        <script>
                            alert('Post deleted successfully.');
                            window.location.href = "dashboard.php";
                        </script>
                    <?php
                        exit;
                    } else {
                    ?>
                        <script>
                            alert('Failed to delete the post.');
                            window.location.href = "dashboard.php";
                        </script>
                    <?php                    }
                } else {
                    ?>
                    <script>
                        alert('You cannot access this page with invalid token.');
                        window.location.href = "dashboard.php";
                    </script>
                <?php
                }
                ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar function
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    </script>
</body>

</html>