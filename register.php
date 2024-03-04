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
    <form class="text-center m-5" action="" method="POST">
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
    Wereits0easy!
    <?php

    use function PHPSTORM_META\type;

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
                } else {
                    $command = "python3 send_email.py $email";
                    exec($command, $output, $return_var);
                    $verif_code = $output[0];
                    echo $verif_code;
                    echo "<h2>A verification code has been sent to $email. Please input it below to complete your account registration.</h2>";
                    echo "<form class='text-center m-5' action='' method='POST'>";
                    echo "<div class='mb-3'>
                        <input name='Verification' type='number' class='form-control' placeholder='Enter Verification Code' required>
                    </div>";
                    echo "<input type='hidden' id='email2' name='email2' value='$email'>";
                    echo "<input type='hidden' id='password2' name='password2' value='$password'>";
                    echo "<input type='hidden' id='verification_true' name='verification_true' value='$verif_code'>";
                    echo "<button name='Verify' type='submit' value='submit' class='btn btn-primary'>Verify Code</button>
                    </form>";
                    // echo "<h2 class='text-center'>Account created successfully!</h2>";
                    // $command = "python userrRegistration.py $email $password";
                    // exec($command, $output, $return_var);
                }
            }
        }
        // Check if the verification code matches
        if (isset($_POST['Verify'])) {
            $input_code = $_POST['Verification'];
            $email = $_POST['email2'];
            $password = $_POST['password2'];
            $verif_code = $_POST['verification_true'];
            if ($input_code != $verif_code) {
                echo "<h2 class='text-center'>Error: Verification code does not match</h2>";
                echo "<h2>A verification code has been sent to $email. Please input it below to complete your account registration.</h2>";
                echo "<form class='text-center m-5' action='' method='POST'>";
                echo "<div class='mb-3'>
                        <input name='Verification' type='number' class='form-control' placeholder='Enter Verification Code' required>
                    </div>";
                echo "<input type='hidden' id='email2' name='email2' value='$email'>";
                echo "<input type='hidden' id='password2' name='password2' value='$password'>";
                echo "<input type='hidden' id='verification_true' name='verification_true' value='$verif_code'>";
                echo "<button name='Verify' type='submit' value='submit' class='btn btn-primary'>Verify Code</button>
                    </form>";
            } else {
                $command = "python3 userrRegistration.py $email $password";
                exec($command, $output, $return_var);
                setcookie("email", $email, time() + 3600, "/");
                echo $output[0];
                // header("Location: ./select_notifications.php")sss;
            }
        }
    }
    ?>
</body>

</html>