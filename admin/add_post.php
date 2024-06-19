<?php
session_start();

// Check if admin_id is set in session
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Database connection
include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $paragraph = $_POST['paragraph'];
    $admin_id = $_SESSION['admin_id'];

    // Check if file is uploaded
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] == 0) {
        // Directory for uploaded images based on admin_id
        $upload_dir = '../pictures/' . $admin_id . '/';

        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Create directory with full permissions
        }

        // Generate unique filename
        $filename = uniqid() . '_' . $_FILES['featured_image']['name'];
        $target_file = $upload_dir . $filename;

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $target_file)) {
            $featured_image_path = $admin_id . '/' . $filename;
        } else {
            // Handle upload failure
            $error_message = "Failed to upload image.";
            // You can handle this error as per your application's requirements
        }
    } else {
        // Default image path if no image uploaded
        $featured_image_path = 'default.png';
    }

    // Insert post data into database
    try {
        $stmt = $conn->prepare("INSERT INTO posts (title, paragraph, admin_id, post_date, featured_image) 
                                VALUES (:title, :paragraph, :admin_id, NOW(), :featured_image)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':paragraph', $paragraph);
        $stmt->bindParam(':admin_id', $admin_id);
        $stmt->bindParam(':featured_image', $featured_image_path);
        $stmt->execute();

        // Redirect to success page
        header("Location: add_post.php?success=1");
        exit();
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
        // You can handle database errors as per your application's requirements
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post- Echoes of Engineers</title>
    <link rel="icon" href="../favicon.png" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts (Font Dynamo) -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Font+Dynamo&display=swap');

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            background-color: #343a40;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            width: 250px;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-heading {
            font-size: 1.2rem;
            padding: 1rem 0;
            text-align: center;
            background-color: #495057;
            margin-bottom: 1rem;
        }

        .platform-name {
            text-align: center;
            padding-top: 20px;
        }

        .platform-name h1 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            font-family: 'Font Dynamo', sans-serif;
            /* Applying Font Dynamo */
        }

        .platform-name img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .nav-item {
            padding: 0.5rem 1rem;
        }

        .nav-link {
            color: #adb5bd;
            transition: color 0.3s;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
        }

        .nav-link:hover {
            color: #fff;
            background-color: #6c757d;
        }

        .nav-link.active {
            color: #fff;
            background-color: #6c757d;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .card-img-top {
            width: 100%;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 250px;
                max-width: 100%;
                position: fixed;
                z-index: 1000;
                height: 100%;
                overflow-y: auto;
                background-color: #343a40;
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
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
                        <a class="nav-link active" href="post.php">
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
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Add Post</h1>
                    <!-- Toggle button for sidebar in mobile -->
                    <button class="btn  d-block d-md-none" id="sidebarToggle">
                        <div style="width: 35px; height: 30px; display: flex; flex-direction: column; justify-content: space-between; cursor: pointer;">
                            <div style="width: 100%; height: 5px; background-color: #333;"></div>
                            <div style="width: 100%; height: 5px; background-color: #333;"></div>
                            <div style="width: 100%; height: 5px; background-color: #333;"></div>
                        </div>
                    </button>
                    <a href="add_post.php" class="btn btn-primary">Add New</a>

                </div>
                <div class="row">

                    <div class="col-md-8">
                        <?php if (isset($error_message)) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error_message; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['success']) && $_GET['success'] == 1) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Post added successfully!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <form action="add_post.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="paragraph">Paragraph</label>
                                <textarea class="form-control" id="paragraph" name="paragraph" rows="6" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="featured_image">Featured Image</label>
                                <input type="file" class="form-control-file" id="featured_image" name="featured_image">
                                <small class="form-text text-muted">Upload an image (optional).</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Post</button>
                        </form>
                    </div>
                </div>
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