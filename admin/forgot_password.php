<?php
require 'db.php';
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
    </style>
</head>

<body>
    <div class="forgot-panel">
        <a href="../index.php" class="home_icon">
            <img src="../favicon.png" alt="Echoes of Engineers Logo">
            <h1>Echoes of Engineers</h1>
        </a>
        <h2>Forgot Password</h2>
        <?php if (!empty($errorMessage)) : ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <form action="forgot_password.php" method="post">
            <input type="text" name="admin_id" placeholder="Admin Email" required>
            <button type="submit">Reset Password</button>
        </form>
        <a href="index.php" class="another">Back to Login</a>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Path to PHPMailer autoload.php
$errorMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_id = trim($_POST['admin_id']);
    // Check if admin ID exists in database
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = :admin_id");
    $stmt->bindParam(':admin_id', $admin_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Generate OTP
        $otp = rand(100000, 999999);
        $id = $user['id'];

        // Update OTP in database
        $stmt = $conn->prepare("UPDATE admins SET otp = :otp WHERE id = :admin_id");
        $stmt->bindParam(':otp', $otp);
        $stmt->bindParam(':admin_id', $id);
        $stmt->execute();

        // Send OTP via email
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'vaikartangroup@gmail.com'; // SMTP username
            $mail->Password = 'dhhxzxsmmciaeane'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // TCP port to connect to

            //Recipients
            $mail->setFrom('vaikartangroup@gmail.com', 'Echoes of Engineers');
            $mail->addAddress($user['email']); // Add a recipient

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "Your OTP for password reset is: <strong>$otp</strong>. <br>Regards,<br>Vaikartan Groups<br>";

            $mail->send();

            $encrypt_id = encodeString($id);

            // Redirect to reset password page with success message
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>';
            echo 'Swal.fire({';
            echo '  icon: "success",';
            echo '  title: "OTP Sent!",';
            echo '  text: "Check your email for the OTP to reset your password.",';
            echo '}).then(function() {';
            echo '  window.location.href = "reset_password.php?admin_id=' . $encrypt_id . '";'; // Redirect to reset password page
            echo '});';
            echo '</script>';
            exit;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>';
        echo 'Swal.fire({';
        echo '  icon: "error",';
        echo '  title: "Admin ID Not Found",';
        echo '  text: "This admin ID is not registered. Please enter a valid admin ID.",';
        echo '}).then(function() {';
        echo '  window.location.href = "forgot_password.php";'; // Redirect back to forgot password page
        echo '});';
        echo '</script>';
        exit;
    }
}
?>