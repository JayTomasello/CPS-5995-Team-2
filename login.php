<?php
include "dbconfig.php";
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LD4NJ</title>
    <link rel="icon" href="./NJLawDigest Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<?php

if (isset($_COOKIE['email'])) {
    $email = $_COOKIE['email'];
    setcookie("email", $email, time() - 3600, "/");
}

?>

<?php include('header2.php'); ?>

<body class="justify-content-center" style="background-image: url(./Courthouse.jpg); background-size:cover; background-position:center -100px">
    <h3 class="text-center" style="margin-top: 50px; font-family:Georgia, 'Times New Roman', Times, serif">By Xavier Amparo, Matthew Fernandez, Eric Landaverde, Julio Rodriguez, and Joseph Tomasello</h3>
    <form class="text-center m-5" action="" method="POST">
        <h1 class="card-title" style="font-family:Georgia, 'Times New Roman', Times, serif">Law Digest 4 New Jersey</h1><br>
        <h2 class="card-title" style="font-family:Georgia, 'Times New Roman', Times, serif">Login</h2>
        <div class="mb-3">
            <input name="Email" type="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter Email" required>
        </div>

        <div class="mb-3">
            <input name="Password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password" required>
        </div>

        <a type="button" class="btn btn-secondary mx-2" href="./newpass.php">Forgot Password?</a>

        <a type="button" class="btn btn-secondary mx-2" href="./register.php">Sign Up</a>

        <button name="login" type="submit" value="submit" class="btn btn-primary mx-5">Submit</button>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['login']) && isset($_POST['Email']) && isset($_POST['Password'])) {
            $email = $_POST['Email'];
            $password = $_POST['Password'];
            $query = "SELECT * FROM sub_user WHERE email='$email'";
            $result = pg_query($conn, $query);

            if ($result) {
                $output = pg_fetch_assoc($result);
                if (!$output) {
                    echo "<h4 style='color:red;text-align:center;'>User does not exist.</h4>";
                    exit;
                } else {
                    $dbemail = $output['email'];
                    $dbpassword = $output['password'];
                    if ($dbemail == $email && $dbpassword == $password) {
                        setcookie("email", $email, time() + 3600, "/");
                        header("Location: ./index.php");
                    } else {
                        echo "<h4 style='color:red;text-align:center;'>Incorrect password.</h4>";
                    }
                }
            } else {
                echo "An error occurred.\n";
                exit;
            }
        }


        //     if (isset($output[0])) {
        //         if ($output[0] == 'Correct password') {
        //             setcookie("email", $email, time() + 3600, "/");
        //             header("Location: ./index.php");
        //         } else {
        //             echo "<h4 style='color:red;text-align:center;'>" . $output[0] . "</h4>";
        //         }
        //     } else {
        //         echo "<h4 style='color:red;text-align:center;'>Incorrect</h4>";
        //     }
        // } else {
        //     echo "<h2 class='text-center'>Login failed!</h2>";
        // }
    }

    ?>
</body>

</html>