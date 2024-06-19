<?php

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
}

include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard- Echoes of Engineers</title>
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

        .row a {
            text-decoration: none;
        }

        .row a h5,
        .row a p {
            color: #333;
        }

        .row a:hover {
            text-decoration: none;
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
                    <h1 class="h2">Posts</h1>
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
                    <!-- Card 1 -->
                    <?php
                    $admin_id = $_SESSION['admin_id'];
                    $stmt = $conn->prepare('SELECT * FROM posts WHERE admin_id = :admin_id');
                    $stmt->execute(['admin_id' => $admin_id]);
                    $posts = $stmt->fetchAll();
                    if ($posts) {
                        foreach ($posts as $post) {
                            $img_path = $post['featured_image'];
                    ?>
                            <a href="../../poem.php?id=<?php echo encodeString($post['id']); ?>">
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card">
                                        <img src="../pictures/<?php echo $img_path; ?>" class="card-img-top" alt="Featured Image">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo  htmlspecialchars($post['title']); ?></h5>
                                            <p class="card-text"><?php echo  substr($post['paragraph'], 0, 50);; ?></p>
                                            <a href="edit_post.php?id=<?php echo encodeString($post['id']); ?>" class="btn btn-primary">Edit</a>
                                            <a href="delete_post.php?id=<?php echo encodeString($post['id']); ?>" class="btn btn-danger float-right">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                    <?php
                        }
                    } else {
                        echo '<p>No posts found.</p>';
                    }
                    ?>

                    <!-- Card 2 -->
                    <!-- <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card">
                            <img src="../pic2.jpeg" class="card-img-top" alt="Featured Image 2">
                            <div class="card-body">
                                <h5 class="card-title">Card title 2</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="path/to/your/post2" class="btn btn-primary">Edit</a>
                                <button class="btn btn-danger float-right">Delete</button>
                            </div>
                        </div>
                    </div> -->
                    <!-- Card 3 -->
                    <!-- <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card">
                            <img src="../pic3.jpeg" class="card-img-top" alt="Featured Image 3">
                            <div class="card-body">
                                <h5 class="card-title">Card title 3</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="path/to/your/post3" class="btn btn-primary">Edit</a>
                                <button class="btn btn-danger float-right">Delete</button>
                            </div>
                        </div>
                    </div> -->
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