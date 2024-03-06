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
            padding-top: 50px; /* Adjust top padding to fit below navbar */
        }

        .btn-check:checked + .btn-outline-dark {
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
            <div class='message-box'><h4>You must login as a Subscribed User to view this page.</h4></div>

            </body>

            </html>";
        die();
    }
    ?>

    <?php include('headerSettings.php'); ?>

    <?php 
    $lawCategories = [
        "Abortion",
        "Agriculture",
        "Alcohol",
        "Animals",
        "Arts & Culture",
        "Authorities",
        "Aviation",
        "Banking & Finance",
        "Boating",
        "Bonds",
        "Charities/Non-Profits",
        "Child Support",
        "Children",
        "Civil Actions",
        "Civil Rights",
        "Civil Service",
        "Commemorations",
        "Commerce",
        "Commissions",
        "Communications",
        "Community Development",
        "Constitutional Amendments",
        "Consumer Affairs",
        "Corporations",
        "Corrections",
        "Crime Victims",
        "Crimes and Penalties",
        "Criminal Procedures",
        "Domestic Relations",
        "Domestic Violence",
        "Economic Development",
        "Education",
        "Elections",
        "Energy",
        "Environment",
        "Ethics",
        "Federal Regulations",
        "Food",
        "Gambling",
        "Governor",
        "Health",
        "Higher Education",
        "Historic Preservation",
        "Housing",
        "Human Services",
        "Immigration",
        "Initiative and Referendum",
        "Insurance",
        "International Affairs",
        "Interstate Relations",
        "Judiciary",
        "Juvenile Justice",
        "Labor",
        "Land Use/Zoning",
        "Legislature",
        "Libraries",
        "Lobbying",
        "Local Budget",
        "Local Government",
        "Local Officers",
        "Marijuana",
        "Minority and Ethnic Affairs",
        "Motor Vehicles",
        "Natural Disasters",
        "New Jersey History",
        "Parole",
        "Pensions",
        "Probation",
        "Property",
        "Prosecutors",
        "Public Contracts",
        "Public Employees",
        "Public Fees",
        "Public Records",
        "Public Safety",
        "Public Utilities",
        "Regulated Professions",
        "Regulatory Oversight",
        "Science and Technology",
        "Senior Citizens",
        "Smoking and Tobacco",
        "Sports and Recreation",
        "State Government",
        "Taxation",
        "Terrorism",
        "Transportation",
        "Veterans and Military",
        "Wills, Trusts, and Estates",
        "Women"
    ];?>

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

        <form class="bg-secondary rounded-5 p-3">
            <h3 class="text-light">I wish to receive updates on laws regarding...</h3>

            <div class="d-flex flex-wrap rounded-5 p-2">
                <?php foreach ($lawCategories as $category) : ?>
                    <?php $categoryId = str_replace(' ', '', strtolower($category)); ?>
                    <div class="form-check form-check-inline m-1">
                        <input type="checkbox" class="btn-check" id="<?php echo $categoryId; ?>" autocomplete="off">
                        <label class="form-checked-success btn btn-outline-dark text-light" for="<?php echo $categoryId; ?>"><?php echo $category; ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="btn btn-primary">Save Preferences</button>
        </form>

    </div>

</body>

</html>
