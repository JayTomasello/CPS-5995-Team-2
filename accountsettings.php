<?php
include 'dbconfig.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LD4NJ - Settings</title>
    <link rel="icon" href="NJLawDigest Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url(./Courthouse.jpg);
            background-size: cover;
            background-position: center -100px;
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: #fff;
        }

        .container {
            padding-top: 50px;
            /* Adjust top padding to fit below navbar */
        }

        .btn-check:checked+.btn-outline-dark {
            color: #000;
        }
    </style>
</head>

<body>

    <?php
    if (!isset($_COOKIE['email'])) {
        echo "<style>
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

        <body class='container'>;
            <div class='message-box text-dark'><h4>You must login as a Subscribed User to view this page.</h4></div>

            </body>

            </html>";
        die();
    }
    ?>

    <?php include('headerSettings.php'); ?>

    <?php

    $query = "SELECT name FROM subjects";
    $result = pg_query($conn, $query);
    $lawCategories = array();
    while ($row = pg_fetch_assoc($result)) {
        $lawCategories[] = $row['name'];
    }
    sort($lawCategories); // Sort the array alphabetically

    ?>

    <div class="container">

        <h3>User Account Settings</h3>

        <form class="text-center rounded-3" id="deregisterForm" action="" method="POST">
            <p style='color: red;'><b>To deregister your account, confirm your email below and click "De-Register".</b></p>
            <input name="Email" type="email" placeholder="Enter Email" required>
            <input type="hidden" id="userEmail" name="true_email" value="<?php echo $_COOKIE['email']; ?>">
            <button name="deregister" type="submit" value="submit" class="btn btn-primary mx-5">De-Register</button>
        </form><br>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['deregister'])) {
                $email = $_POST['Email'];
                $true_email = $_POST['true_email'];
                if ($email == $true_email) {
                    $command = "python userDeregister.py $true_email";
                    exec($command, $output, $return_var);
                    if (isset($output[0])) {
                        if ($output[0] == 'Deleted') {
                            header("Location: ./regout.php");
                        } else {
                            echo "<h4 style='color:red;text-align:center;'>" . $output[0] . "</h4>";
                        }
                    } else {
                        echo "<h4 style='color:red;text-align:center;'>Could not delete.</h4>";
                    }
                } else {
                    echo "<h4 style='color:red;text-align:center;'>Incorrect Email</h4>";
                }
            }
        }

        ?>

        <?php
        // Identify which subjects the user currently has selected
        $query = "SELECT uid FROM sub_user WHERE email = '" . $_COOKIE['email'] . "'";
        $result = pg_query($conn, $query);
        $uid = pg_fetch_assoc($result)['uid'];

        $query = "SELECT subject FROM user_subject WHERE uid = $uid";
        $result = pg_query($conn, $query);
        $selectedCategories = array();
        while ($row = pg_fetch_assoc($result)) {
            $selectedCategories[] = $row['subject'];
        }
        ?>

        <form class="bg-secondary rounded-5 p-3" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h3 class="text-light">I wish to receive updates on laws regarding...</h3>
            <div class="d-flex flex-wrap rounded-5 p-2">
                <?php
                foreach ($lawCategories as $category) {
                    $categoryNoSpace = str_replace(' ', '_', $category);
                    if (in_array($category, $selectedCategories)) {
                        echo ('<input class="btn-check visually-hidden" type="checkbox" id="' . $categoryNoSpace . '" name="selectedCategories[]" value="' . $category . '" checked>');
                        echo ('<label class="btn text-light btn-outline-dark m-2" for="' . $categoryNoSpace . '">' . $category . '</label>');
                    } else {
                        echo ('<input class="btn-check visually-hidden" type="checkbox" id="' . $categoryNoSpace . '" name="selectedCategories[]" value="' . $category . '">');
                        echo ('<label class="btn text-light btn-outline-dark m-2" for="' . $categoryNoSpace . '">' . $category . '</label>');
                    }
                }
                ?>
            </div>
            <button type="submit" name="save_legal_preferences" class="btn btn-primary">Save Preferences</button>
        </form>

        <?php
        // Check if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_legal_preferences'])) {
            $query = "SELECT uid FROM sub_user WHERE email = '" . pg_escape_string($conn, $_COOKIE['email']) . "'";
            $result = pg_query($conn, $query);
            $uid = pg_fetch_assoc($result)['uid'];


            // Insert new preferences
            if (isset($_POST['selectedCategories'])) {
                    if (count($_POST['selectedCategories']) > 5) {
                        echo "<h4 style='color:red;text-align:center;'>You can only select 5 subjects.</h4>";
                    } else {
                        // Delete existing user_subject entries for this user
                        $deleteQuery = "DELETE FROM user_subject WHERE uid = $uid";
                        pg_query($conn, $deleteQuery);
                        
                        foreach ($_POST['selectedCategories'] as $category) {

                        $insertQuery = "INSERT INTO user_subject (uid, subject) VALUES ($uid, '" . pg_escape_string($conn, $category) . "')";
                        pg_query($conn, $insertQuery);
                }
            }
        }
    }
        ?>

    </div>

</body>

</html>