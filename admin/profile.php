<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

include 'db.php';

$admin_id = $_SESSION['admin_id'];

// Fetch user information from the database
try {
    $stmt = $conn->prepare("SELECT * FROM admins WHERE id = :id");
    $stmt->bindParam(':id', $admin_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $nick_name = $_POST['nick_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // If the password field is not empty, update the password
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE admins SET full_name = :full_name, nick_name = :nick_name, email = :email, password = :password WHERE id = :id");
            $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':nick_name', $nick_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':id', $admin_id);
        } else {
            // Otherwise, update only the full name, nick name, and email
            $stmt = $conn->prepare("UPDATE admins SET full_name = :full_name, nick_name = :nick_name, email = :email WHERE id = :id");
            $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':nick_name', $nick_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $admin_id);
        }

        $stmt->execute();
        header("Location: profile.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Echoes of Engineers</title>
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
                        <a class="nav-link active" href="profile.php">
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
                    <h1 class="h2">Profile</h1>
                    <!-- Toggle button for sidebar in mobile -->
                    <button class="btn d-block d-md-none" id="sidebarToggle">
                        <div style="width: 35px; height: 30px; display: flex; flex-direction: column; justify-content: space-between; cursor: pointer;">
                            <div style="width: 100%; height: 5px; background-color: #333;"></div>
                            <div style="width: 100%; height: 5px; background-color: #333;"></div>
                            <div style="width: 100%; height: 5px; background-color: #333;"></div>
                        </div>
                    </button>
                </div>

                <!-- User Profile Information -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Profile Information</h5>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="username">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="nick">Nick Name</label>
                                <input type="text" class="form-control" id="nick" name="nick_name" value="<?php echo htmlspecialchars($user['nick_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <small class="form-text text-muted">Leave blank to keep the current password.</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
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