<?php
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
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

        .create-panel {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px 60px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 350px;
        }

        .create-panel img {
            width: 100px;
        }

        .create-panel h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #185a9d;
        }

        .create-panel h1 {
            margin-bottom: 20px;
            color: #ff6f61;
        }

        .create-panel input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        .create-panel button {
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

        .create-panel button:hover {
            background-color: #154c75;
        }

        .create-panel .create-links {
            display: block;
            margin-top: 15px;
            color: #185a9d;
            text-decoration: none;
        }

        .create-panel .create-links:hover {
            text-decoration: underline;
        }

        .home_icon {
            text-decoration: none;
        }

        .home_icon:hover {
            text-decoration: none;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <div class="create-panel">
        <a href="../index.php" class="home_icon">
            <img src="../favicon.png" alt="Echoes of Engineers Logo">
            <h1>Echoes of Engineers</h1>
        </a>
        <h2>Create Account</h2>
        <form action="create_account.php" method="post">
            <?php
            if (isset($error_message)) {
                echo "<p style='color:red;'>$error_message</p>";
            }
            ?>
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="text" name="nick_name" placeholder="Nick Name(To be displayed on posts)" required>
            <input type="text" name="admin_id" placeholder="Admin Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <div class="g-recaptcha" data-sitekey="6Lf7WvwpAAAAAANXrjX0Pv8mXdBERs_qS6cxI3Hb"></div>
            <button type="submit">Create Account</button>
        </form>
        <a href="index.php" class="create-links">Back to Login</a>
    </div>

    <script>
        // Optional: You can enhance the form submission handling with JavaScript
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting normally
            var form = this;

            // Validate form fields here if needed

            // Submit the form via AJAX or let it submit normally
            form.submit();
        });
    </script>
</body>

</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $secretKey = "6Lf7WvwpAAAAAJWkcMnucyzCxaYsaKaL3wLvhGhB";
    $responseKey = $_POST['g-recaptcha-response'];
    $userIP = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";

    $response = file_get_contents($url);
    $response = json_decode($response);

    if ($response->success) {
        // Process form data
        include 'db.php';

        $email = trim($_POST['admin_id']);
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);
        $full_name = trim($_POST['full_name']);
        $nick_name = trim($_POST['nick_name']);


        // Prepare SQL statement
        $stmt1 = $conn->prepare("SELECT * FROM admins WHERE email = :email");
        $stmt1->bindParam(':email', $email);
        $stmt1->execute();
        if ($stmt1->rowCount() <= 0) {
            if (!empty($email) && !empty($password) && !empty($confirm_password)) {
                if ($password === $confirm_password) {
                    // Hash the password
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                    // Prepare the SQL statement
                    $stmt = $conn->prepare("INSERT INTO admins (full_name,nick_name,email, password) VALUES (:full_name,:nick_name,:email, :password)");
                    $stmt->bindParam(':full_name', $full_name);
                    $stmt->bindParam(':nick_name', $nick_name);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $hashed_password);

                    if ($stmt->execute()) {
                        // Account created successfully
                        echo '<script>';
                        echo 'Swal.fire({';
                        echo '  icon: "success",';
                        echo '  title: "Account Created!",';
                        echo '  text: "Your admin account has been created successfully. Please Log in",';
                        echo '}).then(function() {';
                        echo '  window.location.href = "index.php";';
                        echo '});';
                        echo '</script>';
                        exit;
                    } else {
                        $error_message = "Error creating account";
                    }
                } else {
                    $error_message = "Passwords do not match";
                }
            } else {
                $error_message = "Please fill in all fields";
            }
        } else {
            $error_message = "Email Already Exists! Try logging in!";
        }
    } else {
        $error_message = "Please complete the CAPTCHA";
    }
}
?>