<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LD4NJ</title>
    <link rel="icon" href="NJLawDigest Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        .dropdown-menu-scrollable {
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <?php
    if ((!isset($_COOKIE['email'])) && ((!isset($_SESSION['agree'])) || ($_SESSION['agree'] == FALSE))) {
        echo ('<div class="z-2 position-absolute w-100 h-100 opacity-50 bg-black"></div>');
    }
    ?>

    <nav class="navbar navbar-expand-lg bg-white">

        <div class="container-fluid justify-content-start">
            <img src="./NJLawDigest Logo.png" class="img me-4" width="100px" alt="...">
            <label class="navbar-brand fs-1 text-dark me-4" style="font-family: Georgia, 'Times New Roman', Times, serif">Law Digest 4 New Jersey</label>


            <div class="container-fluid justify-content-end">
                <?php
                if (isset($_COOKIE['email'])) {
                    echo (' <a type="button" class="btn btn-secondary mx-4" href="disclaimer.php">View Disclaimer</a>
                <div class="btn-group m-3">
                            <button type="button" class="btn btn-secondary dropdown-toggle" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                Welcome, ' . $_COOKIE['email'] . '
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="userMenu">
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                <li><a class="dropdown-item" href="accountSettings.php">Settings</a></li>
                            </ul>
                        </div>');
                } else {
                    echo ('<label class="navbar-brand fs-4 text-dark me-4" style="font-family: Georgia, ' . 'Times New Roman' . ' , Times, serif">Welcome, Guest.</label>
                    <a type="button" class="btn btn-secondary mx-4" href="disclaimer.php">View Disclaimer</a>
                    <a type="button" class="btn btn-secondary mx-4" href="register.php">Sign Up</a>
                    <a type="button" class="btn btn-secondary mx-4" href="login.php">Login</a>
                ');
                }
                ?>
            </div>
        </div>

        <!-- Categories -->
        <div class="container-fluid justify-content-evenly">
            <ul class="navbar-nav">
                <li><a href="#">Development & Infrastructure</a></li>
                <li><a href="#">Domestic & Environmental</a></li>
                <li><a href="#">Money & Business</a></li>
                <li><a href="#">Health & Safety</a></li>
                <li><a href="#">Government & Jersey Heritage</a></li>
                <li><a href="#">Crime & Judicial</a></li>
            </ul>
        </div>

    </nav>
</body>

</html>