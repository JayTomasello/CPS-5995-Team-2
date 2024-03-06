<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LD4NJ</title>
    <link rel="icon" href="./NJLawDigest Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        body {
            background-image: url(./Courthouse.jpg);
            background-size: cover;
            background-position: center -100px;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .message-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 80%;
            text-align: center;
        }

        h4 {
            margin: 0;
        }
    </style>
</head>

<body class="container">

    <?php

    if (isset($_COOKIE['email'])) {
        $email = $_COOKIE['email'];
        setcookie("email", $email, time() - 3600, "/");
        echo "<div class='message-box'><h4>You have successfully deleted your subscribed account. You will be redirected to the main page in 5 seconds...</h4></div>";
        header("refresh:5 ; url=./index.php");
    }

    ?>

</body>

</html>
