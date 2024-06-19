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
            background-color: #f8f9fa;
            /* Light grey background */
            padding: 20px 0;
            border-top: 1px solid #ddd;
            /* Light grey border on top */
        }

        .footer-links {
            text-align: center;
        }

        .footer-links a {
            color: #555;
            /* Dark grey link color */
            margin: 0 10px;
        }

        .footer-links a:hover {
            color: #ff6f61;
            /* Reddish hover color */
            text-decoration: none;
        }

        /* Adjustments for smaller screens */
        @media (max-width: 768px) {
            .footer-links {
                margin-top: 10px;
            }

            .about-us-section {
                background-color: #f8f9fa;
                /* Light grey background */
                padding: 50px 0;
            }

            .about-us-content {
                max-width: 800px;
                margin: 0 auto;
                text-align: justify;
                display: flex;
                flex-wrap: wrap;
                /* Allow items to wrap on smaller screens */
            }

            .about-us-content h2 {
                color: #ff6f61;
                /* Reddish title color */
                font-size: 3em;
                margin-bottom: 20px;
                width: 100%;
                /* Ensure title spans full width */
            }

            .about-us-content p {
                font-size: 1.2em;
                line-height: 1.6;
                flex: 1 1 100%;
                /* Take full width on smaller screens */
            }

            .about-us-image {
                flex: 0 0 100%;
                /* Full width for the image on smaller screens */
                margin: 20px 0;
                margin-left: -30px;
            }

            .title-abt {
                display: none;
            }
        }

        /* Custom styles for the About Us page */
        .about-us-section {
            background-color: #f8f9fa;
            /* Light grey background */
            padding: 50px 0;
        }

        .about-us-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: justify;
            display: flex;
            align-items: center;
        }

        .about-us-content h2 {
            color: #ff6f61;
            /* Reddish title color */
            font-size: 3em;
            margin-bottom: 20px;
        }

        .about-us-content p {
            font-size: 1.2em;
            line-height: 1.6;
        }

        .about-us-image {
            flex: 0 0 300px;
            /* Fixed width for the image */
            margin-right: 30px;
        }

        /* Additional styles for the footer */
        .footer {
            background-color: #f8f9fa;
            /* Light grey background */
            padding: 20px 0;
            border-top: 1px solid #ddd;
            /* Light grey border on top */
        }

        .footer-links {
            text-align: center;
        }

        .footer-links a {
            color: #555;
            /* Dark grey link color */
            margin: 0 10px;
        }

        .footer-links a:hover {
            color: #ff6f61;
            /* Reddish hover color */
            text-decoration: none;
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
        <a href="admin/" class="btn btn-success btn-lg btn-sm float-md-right">Share your Feelings</a>
    </div>

    <div class="container row">
        <div class="about-us-section">
            <div class="container">
                <div class="about-us-content">
                    <div class="about-us-image">
                        <img src="eoe.png" alt="About Us Image" style="max-width: 100%;">
                    </div>
                    <div>
                        <h2 class="title-abt">About Us</h2>
                        <p>Welcome to Echoes of Engineers, where feelings and creativity meets technology. We are a community of engineers who express our emotions and experiences through poetry and storytelling. Our platform is dedicated to showcasing the human side of engineering, bringing together like-minded individuals who share a passion for both technology and creativity.</p>
                        <p>Founded in 2024, Echoes of Engineers has grown into a vibrant community with contributors from around the globe. Our mission is to bridge the gap between science and art, demonstrating that engineering is not just about numbers and equations but also about inspiration and imagination.</p>
                        <span><b>Note:</b>This Page is just for engineers to express their feelings and is copyright free. You can join the community and express your feelings. We protect your privacy here.<br>
            All the materials available here might be imaginary or true. The contents here is solely responsible by the author of the creation.
            <br>Any reponsibility is not taken by the owner of this website for any of the contents in this page. In case of any complaints or queries kindly mail at bhaskarenergetics@gmail.com</span>
                    </div>
                </div>
            </div>
        </div>
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