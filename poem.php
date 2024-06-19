<?php
include 'db.php';
if (isset($_GET['id'])) {
    $id = decodeString($_GET['id']);
    $stmt = $conn->prepare('SELECT posts.*, admins.nick_name AS author_nickname 
                            FROM posts 
                            INNER JOIN admins ON posts.admin_id = admins.id 
                            WHERE posts.id = :id');

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    // Execute the query
    $stmt->execute();
    
    // Fetch the post details as an associative array
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
        $postId = $post['id'];
        $postDate = new DateTime($post['post_date']);
        $formattedDate = $postDate->format('jS F, Y'); // Example output: 20th June, 2024
        $title = $post['title'];
        $paragraph = nl2br(htmlspecialchars($post['paragraph']));
        $authorNickname = $post['author_nickname'];
} else { 
    ?>
    <script>
        alert("You haven't selected any creations. Please select a valid creation");
        window.location.href = 'index.php';
    </script>
<?php
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="icon" href="favicon.png" type="image/x-icon">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #ffecd2, #fcb69f);
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px 50px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            max-width: 700px;
            text-align: center;
            position: relative;
            animation: fadeIn 2s;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #ff6f61;
        }

        p {
            font-size: 1.2em;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background-color: #ff6f61;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #ff4b3a;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 0.9em;
            color: #555;
        }

        .message-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.95);
            padding: 20px 40px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 0.5s;
        }

        .message-popup p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .close-btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background-color: #ff6f61;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .close-btn:hover {
            background-color: #ff4b3a;
        }
    </style>
</head>

<body>
            <div class="container">
                <h1><?php echo $title; ?>❤️</h1>
                <p><?php echo $paragraph; ?></p>

                <div class="footer">
                    <span><?php echo $formattedDate; ?></span>
                    <span>--<?php echo $authorNickname; ?></span>
                </div>
                <button class="btn" onclick="showMessage()">Send Love</button>
            </div>

    <div id="messagePopup" class="message-popup">
        <p>I hope it's you, my dear friend.</p>
        <button class="close-btn" onclick="closeMessage()">Close</button>
    </div>

    <script>
        function showMessage() {
            document.getElementById('messagePopup').style.display = 'block';
        }

        function closeMessage() {
            document.getElementById('messagePopup').style.display = 'none';
        }
    </script>

</body>

</html>