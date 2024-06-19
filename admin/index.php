<?php
include 'db.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['admin_id']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT * FROM admins WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if ($admin && password_verify($password, $admin['password'])) {
            session_start();
            // Store user information in session
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['email'] = $admin['email'];
            // echo $_SESSION['admin_id'];
            // echo $_SESSION['email'];
            // Redirect to admin dashboard or some secure page
            header("Location: dashboard.php");
            exit;
        } else {
            $error_message = "Invalid Email or Password";
        }
    } else {
        $error_message = "Please fill in all fields";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echoes of Engineers</title>
    <link rel="icon" href="../favicon.png" type="image/x-icon">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #43cea2, #185a9d);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-panel {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px 60px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 350px;
        }

        .login-panel img {
            width: 100px;
        }

        .login-panel h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #185a9d;
        }

        .login-panel h1 {
            margin-bottom: 20px;
            color: #ff6f61;
        }

        .login-panel input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        .login-panel button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #185a9d;
            color: #fff;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-panel button:hover {
            background-color: #154c75;
        }

        .login-panel .another {
            display: block;
            margin-top: 15px;
            color: #185a9d;
            text-decoration: none;
        }

        .login-panel .another:hover {
            text-decoration: underline;
        }

        .home_icon {
            text-decoration: none;
        }

        .home_icon {
            text-decoration: none;
        }

        .home_icon:hover {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="login-panel">
        <a href="../index.php" class="home_icon">
            <img src="../favicon.png" alt="Echoes of Engineers Logo">
            <h1>Echoes of Engineers</h1>
        </a>
        <h2>Admin Login</h2>
        <form action="" method="post">
            <?php
            if (!empty($error_message)) {
                echo "<p style='color:red;'>$error_message</p>";
            }
            ?>
            <input type="text" name="admin_id" placeholder="Admin Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign In</button>
        </form>
        <a href="create_account.php" class="another">Create Account</a>
        <a href="forgot_password.php" class="another">Forgot Password?</a>
    </div>
</body>

</html>