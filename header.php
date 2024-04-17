<?php
session_start();
include('dbconfig.php');
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
</head>

<body>
    <?php
    if ((!isset($_COOKIE['email'])) && ((!isset($_SESSION['agree'])) || ($_SESSION['agree'] == FALSE))) {
        echo ('<div class="z-2 position-absolute w-100 h-100 opacity-50 bg-black"></div>');
    }
    ?>

    <nav class="navbar navbar-expand-lg bg-white justify-content-between">

        <div class="container-fluid">

            <!-- LOGO -->
            <div class="d-flex align-items-center">
                <img src="./NJLawDigest Logo.png" class="img me-4" width="100px" alt="...">
                <label class="navbar-brand fs-1 text-dark" style="font-family: Georgia, 'Times New Roman', Times, serif">Law Digest 4 New Jersey</label>
            </div>

            <!-- FUNCTIONS -->
            <div class="d-flex align-items-center">
                <?php
                if (isset($_COOKIE['email'])) {
                    echo ('
                    <a type="button" class="btn btn-secondary mx-4" href="disclaimer.php">View Disclaimer</a>
                    <div class="btn-group m-3">
                        <button type="button" class="btn btn-secondary dropdown-toggle" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        Welcome, ' . $_COOKIE['email'] . '
                        </button>
                            <ul class="dropdown-menu" aria-labelledby="userMenu">
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                <li><a class="dropdown-item" href="accountSettings.php">Settings</a></li>
                            </ul>
                    </div>
                    ');
                } else {
                    echo ('
                    <label class="navbar-brand fs-4 text-dark" style="font-family: Georgia, ' . 'Times New Roman' . ' , Times, serif">Welcome, Guest.</label>
                    <a type="button" class="btn btn-primary mx-2" href="disclaimer.php">View Disclaimer</a>
                    <a type="button" class="btn btn-primary mx-2" href="register.php">Sign Up</a>
                    <a type="button" class="btn btn-primary mx-2" href="login.php">Login</a>
                ');
                }
                ?>
            </div>

        </div>
    </nav>


    <!-- SELECT FUNCTION -->
    <script>
        function select(head_category_name) {
            // Deselect the active Button
            if (document.getElementById("head_" + head_category_name).ariaPressed == "false") {
                document.getElementById("head_" + head_category_name).classList.remove("active");
                document.getElementById("popup_" + head_category_name).classList.add("visually-hidden");
            } else {
                // Activate the Button
                let elements = document.getElementsByName("head_category");
                for (let i = 0; i < elements.length; i++) {
                    elements[i].classList.remove("active");
                }
                document.getElementById("head_" + head_category_name).classList.add("active");

                // Display the Popup
                let elements2 = document.getElementsByName("head_category_display");
                for (let i = 0; i < elements2.length; i++) {
                    elements2[i].classList.add("visually-hidden");
                }

                document.getElementById("popup_" + head_category_name).classList.remove("visually-hidden");

            }
        }
    </script>

    <!-- HEAD CATEGORIES -->
    <nav class="navbar navbar-expand-lg bg-secondary">
        <div class="container-fluid p-1 justify-content-around">
            <?php
            $query = "SELECT DISTINCT head_category FROM subjects";
            $result = pg_query($conn, $query);
            while ($row = pg_fetch_assoc($result)) {
                echo ('<div class="list-group-item" >');
                $headCategory = str_replace(' ', '_', $row['head_category']);
                echo ('<button class="btn btn-dark text-light" data-bs-toggle="button" name="head_category" id="head_' . $headCategory . '" onclick="select(\'' . $headCategory . '\')" aria-expanded="false">' . $row['head_category'] . '</button>');
                echo ('</div>');
            }
            ?>
        </div>
    </nav>

    <!-- SUBCATEGORIES -->
    <?php
    $query1 = "SELECT DISTINCT head_category FROM subjects ORDER BY head_category";
    $result1 = pg_query($conn, $query1);
    // $firstletter = 

    $result1 = pg_query($conn, $query1);
    while ($row = pg_fetch_assoc($result1)) {
        $headCategory = str_replace(' ', '_', $row['head_category']);
        echo ('<div class="d-flex m-3 flex-wrap dropdown-menu visually-hidden" name="head_category_display" id="popup_' . $headCategory . '" style="z-index:1000">');
        echo ('<form action="index.php" class="d-flex flex-wrap" name="subject_search" method="GET">');
        $query2 = "SELECT name FROM subjects WHERE head_category = '" . $row['head_category'] . "' ORDER BY name";
        $result2 = pg_query($conn, $query2);
        while ($row2 = pg_fetch_assoc($result2)) {
            $name = $row2['name'];
            echo ("<button class='btn btn-outline-dark m-2' name='subject_search' value=" . str_replace(' ', '_', $name) . ">" . $name . "</button>");
        }
        echo ('</form>');
        echo ('</div>');
    }
    ?>

</body>

</html>