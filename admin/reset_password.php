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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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

        .forgot-panel {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px 60px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 350px;
        }

        .forgot-panel img {
            width: 100px;
        }

        .forgot-panel h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #185a9d;
        }

        .forgot-panel h1 {
            margin-bottom: 20px;
            color: #ff6f61;
        }

        .forgot-panel input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        .forgot-panel button {
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

        .forgot-panel button:hover {
            background-color: #154c75;
        }

        .forgot-panel .another {
            display: block;
            margin-top: 15px;
            color: #185a9d;
            text-decoration: none;
        }

        .forgot-panel .another:hover {
            text-decoration: underline;
        }

        .home_icon {
            text-decoration: none;
        }

        .home_icon:hover {
            text-decoration: none;
        }

        #change_password_form {
            display: none;
        }
    </style>
</head>
<?php
require 'db.php';
$errorMessage = '';

if (isset($_GET['admin_id'])) {
    $admin_id = decodeString($_GET['admin_id']);
} else {
?>
    <script>
        alert('You cannot access this page! Sorry for the inconvineince!');
        window.location.href = "forgot_password.php";
    </script>

<?php
}
?>


<body>
    <div class="forgot-panel">
        <a href="../index.php" class="home_icon">
            <img src="../favicon.png" alt="Echoes of Engineers Logo">
            <h1>Echoes of Engineers</h1>
        </a>
        <h2>Reset Password</h2>
        <?php if (!empty($errorMessage)) : ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <form action="" method="post" id="verify_otp_form">
            <input type="text" name="otp" placeholder="Enter OTP sent to your mail." required>
            <button type="submit" name="verify_otp">Verify</button>
        </form>

        <form action="" method="post" id="change_password_form">
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit" name="change_password">Change Password</button>
        </form>

        <a href="index.php" class="another">Back to Login</a>
    </div>
</body>


<?php


if (isset($_POST['verify_otp'])) {
    $otp = trim($_POST['otp']);

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT otp FROM admins WHERE id = :id");
    $stmt->bindParam(':id', $admin_id);
    $stmt->execute();

    // Check if email exists
    if ($stmt->rowCount() > 0) {
        // Fetch OTP value
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['otp'] == $otp) {
?>
            <script>
                let verify_form = document.getElementById('verify_otp_form');
                let password_form = document.getElementById('change_password_form');
                verify_form.style.display = 'none';
                password_form.style.display = 'block';
            </script>
        <?php
        } else {
        ?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Wrong OTP!',
                    text: 'The OTP you entered is incorrect. Please try again.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "forgot_password.php";
                    }
                });
            </script>
        <?php
        }
    } else {
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Internal Database Error!',
                text: 'Sorry for the inconvenience! Please try again.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "forgot_password.php";
                }
            });
        </script>

<?php
    }
}

if (isset($_POST['change_password'])) {
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql2 = "UPDATE admins SET password = :password WHERE id = :id";

        // Prepare the statement
        $stmt2 = $conn->prepare($sql2);

        // Bind parameters
        $stmt2->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt2->bindParam(':id', $admin_id, PDO::PARAM_INT);

        if ($stmt2->execute()) {
            // Account created successfully
            echo '<script>';
            echo "alert('Password Changed! Proceed to Log in ');";
            echo 'window.location.href = "index.php";';
            echo '</script>';
            exit;
        } else {
            $error_message = "Error changing password. Try Again!";
        }
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>