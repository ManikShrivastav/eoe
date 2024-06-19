<?php
    include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echoes of Engineers</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="icon" href="favicon.png" type="image/x-icon">

    <style>
        .container {
            margin-right: 10%;
            margin-left: 10%;

        }

        .container-club {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .member-card {
            /* width: 45%; */
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .member-card:hover {
            transform: translateY(-10px);
        }

        .member-info {
            padding: 20px;
        }

        .member-info img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #ccc;
        }


        h1,
        h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #ff6f61;
        }

        p {
            font-size: 1.2em;
            line-height: 1.8;
            margin-bottom: 20px;
            color: #000;
        }

        a:hover {
            text-decoration: none;
        }

        /* .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 0.9em;
            color: #555;
        } */
        /* Custom styles for footer */
        .footer {
            background-color: #f8f9fa; /* Light grey background */
            padding: 20px 0;
            border-top: 1px solid #ddd; /* Light grey border on top */
        }

        .footer-links {
            text-align: center;
        }

        .footer-links a {
            color: #555; /* Dark grey link color */
            margin: 0 10px;
        }

        .footer-links a:hover {
            color: #ff6f61; /* Reddish hover color */
            text-decoration: none;
        }

        /* Adjustments for smaller screens */
        @media (max-width: 768px) {
            .footer-links {
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>
    <!-- Hero Start -->
    <div class="container-fluid py-5 hero-header mb-5" style="background: linear-gradient(to right, #d8d5d1, #ffffff);">
        <div class="row align-items-end">
            <div class="col-md-12 text-center">
                <h1 class="display-3 text-white animated zoomIn">Echoes of Engineers</h1>
            </div>
        </div>

    </div>

    <div class="col-md-12 text-right mt-4">
        <a href="admin/" class="btn btn-danger btn-lg btn-sm float-md-right">Share your Feelings</a>
    </div>

    <div class="container row">
<?php 
// Assuming you have $conn variable containing PDO connection

try {
    // Query to fetch posts data
    $stmt = $conn->query('SELECT posts.*,admins.nick_name from posts inner join admins on posts.admin_id = admins.id;');

    // Fetch all rows as an associative array
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if($posts){
    // Iterate through each post and generate HTML
    foreach ($posts as $post) {
        $postId = encodeString($post['id']);
        $featuredImage = $post['featured_image'];
        $title = $post['title'];
        $paragraph = substr($post['paragraph'], 0, 50);
        $authorNickname = $post['nick_name'];

        // Output HTML for each post
        echo '<div class="container-club col-lg-4">';
        echo '<div class="member-card">';
        echo '<a href="poem.php?id=' . $postId . '">';
        echo '<div class="member-info">';
        echo '<img src="pictures/' . $featuredImage . '" alt="' . $title . '">';
        echo '<h2>' . $title . '</h2>';
        echo '<p>' . $paragraph . '</p>';
        echo '<br>';
        echo '<p style="color:#555;">Author: ' . $authorNickname . '</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
        echo '</div>';
    }
    }
    else{
        echo "No Creations available for now";
    }
} catch(PDOException $e) {
    // Handle database connection or query errors
    echo 'Error: ' . $e->getMessage();
}


?>
    <!-- <div class="container-club col-lg-4">
            <div class="member-card">
                <a href="poem.php?id=1">
                    <div class="member-info">
                        <img src="pic1.jpeg">
                        <h2>I am sorry</h2>
                        <p>This message is for my rossy that I am sorry for wahtever I did to you. </p>
                        <br>
                        <p style="color:#555;">Author: Cruiser</p>
                    </div>
                </a>
            </div>
        </div> -->
        <!-- <div class="container-club col-lg-4">
            <div class="member-card">
                <a href="poem.php?id=1">
                    <div class="member-info">
                        <img src="pic1.jpeg">
                        <h2>I am sorry</h2>
                        <p>This message is for my rossy that I am sorry for wahtever I did to you. </p>
                        <br>
                        <p style="color:#555;">Author: Cruiser</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="container-club col-lg-4">
            <div class="member-card">
                <a href="poem.php?id=2">
                    <div class="member-info">
                        <img src="pic2.jpeg">
                        <h2>The relation we had</h2>
                        <p>This post is for my girlfriend who believes me blindly. I just want to say you that I love you my rosyy. </p>
                        <br>
                        <p style="color:#555;">Author: Cruiser</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="container-club col-lg-4">
            <div class="member-card">
                <a href="poem.php?id=3">
                    <div class="member-info">
                        <img src="pic3.jpeg">
                        <h2>You are my best friend❤️</h2>
                        <p>Maybe we fight, maybe I am wrong but at least I love you my dear best friend. Everytime I fight but I am with you always my girl. </p>
                        <br>
                        <p style="color:#555;">Author: Alien</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="container-club col-lg-4">
            <div class="member-card">
                <a href="poem.php?id=4">
                    <div class="member-info">
                        <img src="pic4.jpg">
                        <h2>I miss you❤️</h2>
                        <p>This creation is just to remind my girl that I miss her so much. I don't know she will be able to read it or not but this is for you hamar babi. I miss you. My girl</p>
                        <br>
                        <p style="color:#555;">Author: Alien</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="container-club col-lg-4">
            <div class="member-card">
                <a href="poem.php?id=5">
                    <div class="member-info">
                        <img src="pic5.jpg">
                        <h2>My Prettiest Doctor❤️</h2>
                        <p>This poem is dedicated to my bestfriend whom I lost due to my half information. Now she don't want me to listen up. My Dear Babi, Hai tohra la. I am sorry. My girl.</p>
                        <br>
                        <p style="color:#555;">Author: Alien</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="container-club col-lg-4">
            <div class="member-card">
                <a href="poem.php?id=6">
                    <div class="member-info">
                        <img src="pic6.jpeg">
                        <h2>Please Come back my love💕</h2>
                        <p>This is for my girl. It is a reminder to her that she was not only my girlfriend but my bestfriend, my caretaker and the light of my life</p>
                        <br>
                        <p style="color:#555;">Author: Shaan</p>
                    </div>
                </a>
            </div>
        </div> -->
    </div>

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <p class="text-muted">&copy; 2024 Echoes of Engineers</p>
                </div>
                <div class="col-md-8 footer-links">
                    <a href="index.php">Home</a>
                    <a href="contact.php">Contact Us</a>
                    <a href="about.php">About Us</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>