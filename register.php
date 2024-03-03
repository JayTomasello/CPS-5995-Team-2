<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LD4NJ</title>
    <link rel="icon" href="./NJLawDigest Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body class="container align-middle justify-content-center" style="background-image: url(./Courthouse.jpg); background-size:cover; background-position:center -100px">
    <h3 class="text-center" style="margin-top: 50px; font-family:Georgia, 'Times New Roman', Times, serif">By Xavier Amparo, Matthew Fernandez, Eric Landaverde, Julio Rodriguez, and Joseph Tomasello</h3>
    <form class="text-center m-5" action="http://localhost:5000/register" method="POST">
        <h1 class="card-title" style="font-family:Georgia, 'Times New Roman', Times, serif">Law Digest 4 New Jersey</h1>

        <div class="mb-3">
            <input name="Email" type="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter Email" required>
        </div>

        <div class="mb-3">
            <input name="Password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password" required>
        </div>

        <div class="mb-3">
            <input name="Confirm_Password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Confirm Password" required>
        </div>


        <button name="Enter" type="submit" value="submit" class="btn btn-primary">Submit</button>
    </form>

    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['Enter'])) {
            $email = $_POST['Email'];
            $password = $_POST['Password'];
            $confirm_password = $_POST['Confirm_Password'];
            if ($password != $confirm_password) {
                echo "<h2>Passwords do not match</h2>";
            } else {
                if (
                    strlen($password) < 8 || !preg_match("/[A-Z]/", $password)
                    || !preg_match("/[0-9]/", $password) || !preg_match("/[^A-Za-z0-9]/", $password)
                ) {
                    echo "<h2 class='text-center'>Password must be at least 8 characters long and contain at least one uppercase letter, one number, and one special character.</h2>";
                }
            }
        }
    }
    ?>
</body>

</html>