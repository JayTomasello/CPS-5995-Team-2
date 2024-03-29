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

            <div class="btn-group m-3">
                <button type="button" class="btn btn-secondary dropdown-toggle" id="dropdownMenuOffset1" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="10,20">
                    Search Laws by Subject
                </button>
                <ul class="dropdown-menu dropdown-menu-scrollable">
                <li><a class="dropdown-item" href="#">Abortion</a></li>
                        <li><a class="dropdown-item" href="#">Agriculture</a></li>
                        <li><a class="dropdown-item" href="#">Alcohol</a></li>
                        <li><a class="dropdown-item" href="#">Animals</a></li>
                        <li><a class="dropdown-item" href="#">Arts & Culture</a></li>
                        <li><a class="dropdown-item" href="#">Authorities</a></li>
                        <li><a class="dropdown-item" href="#">Aviation</a></li>
                        <li><a class="dropdown-item" href="#">Banking & Finance</a></li>
                        <li><a class="dropdown-item" href="#">Boating</a></li>
                        <li><a class="dropdown-item" href="#">Bonds</a></li>
                        <li><a class="dropdown-item" href="#">Charities/Non-Profits</a></li>
                        <li><a class="dropdown-item" href="#">Child Support</a></li>
                        <li><a class="dropdown-item" href="#">Children</a></li>
                        <li><a class="dropdown-item" href="#">Civil Actions</a></li>
                        <li><a class="dropdown-item" href="#">Civil Rights</a></li>
                        <li><a class="dropdown-item" href="#">Civil Service</a></li>
                        <li><a class="dropdown-item" href="#">Commemorations</a></li>
                        <li><a class="dropdown-item" href="#">Commerce</a></li>
                        <li><a class="dropdown-item" href="#">Commissions</a></li>
                        <li><a class="dropdown-item" href="#">Communications</a></li>
                        <li><a class="dropdown-item" href="#">Community Development</a></li>
                        <li><a class="dropdown-item" href="#">Constitutional Amendments</a></li>
                        <li><a class="dropdown-item" href="#">Consumer Affairs</a></li>
                        <li><a class="dropdown-item" href="#">Corporations</a></li>
                        <li><a class="dropdown-item" href="#">Corrections</a></li>
                        <li><a class="dropdown-item" href="#">Crime Victims</a></li>
                        <li><a class="dropdown-item" href="#">Crimes and Penalties</a></li>
                        <li><a class="dropdown-item" href="#">Criminal Procedures</a></li>
                        <li><a class="dropdown-item" href="#">Domestic Relations</a></li>
                        <li><a class="dropdown-item" href="#">Domestic Violence</a></li>
                        <li><a class="dropdown-item" href="#">Economic Development</a></li>
                        <li><a class="dropdown-item" href="#">Education</a></li>
                        <li><a class="dropdown-item" href="#">Elections</a></li>
                        <li><a class="dropdown-item" href="#">Energy</a></li>
                        <li><a class="dropdown-item" href="#">Environment</a></li>
                        <li><a class="dropdown-item" href="#">Ethics</a></li>
                        <li><a class="dropdown-item" href="#">Federal Regulations</a></li>
                        <li><a class="dropdown-item" href="#">Food</a></li>
                        <li><a class="dropdown-item" href="#">Gambling</a></li>
                        <li><a class="dropdown-item" href="#">Governor</a></li>
                        <li><a class="dropdown-item" href="#">Health</a></li>
                        <li><a class="dropdown-item" href="#">Higher Education</a></li>
                        <li><a class="dropdown-item" href="#">Historic Preservation</a></li>
                        <li><a class="dropdown-item" href="#">Housing</a></li>
                        <li><a class="dropdown-item" href="#">Human Services</a></li>
                        <li><a class="dropdown-item" href="#">Immigration</a></li>
                        <li><a class="dropdown-item" href="#">Initiative and Referendum</a></li>
                        <li><a class="dropdown-item" href="#">Insurance</a></li>
                        <li><a class="dropdown-item" href="#">International Affairs</a></li>
                        <li><a class="dropdown-item" href="#">Interstate Relations</a></li>
                        <li><a class="dropdown-item" href="#">Judiciary</a></li>
                        <li><a class="dropdown-item" href="#">Juvenile Justice</a></li>
                        <li><a class="dropdown-item" href="#">Labor</a></li>
                        <li><a class="dropdown-item" href="#">Land Use/Zoning</a></li>
                        <li><a class="dropdown-item" href="#">Legislature</a></li>
                        <li><a class="dropdown-item" href="#">Libraries</a></li>
                        <li><a class="dropdown-item" href="#">Lobbying</a></li>
                        <li><a class="dropdown-item" href="#">Local Budget</a></li>
                        <li><a class="dropdown-item" href="#">Local Government</a></li>
                        <li><a class="dropdown-item" href="#">Local Officers</a></li>
                        <li><a class="dropdown-item" href="#">Marijuana</a></li>
                        <li><a class="dropdown-item" href="#">Minority and Ethnic Affairs</a></li>
                        <li><a class="dropdown-item" href="#">Motor Vehicles</a></li>
                        <li><a class="dropdown-item" href="#">Natural Disasters</a></li>
                        <li><a class="dropdown-item" href="#">New Jersey History</a></li>
                        <li><a class="dropdown-item" href="#">Parole</a></li>
                        <li><a class="dropdown-item" href="#">Pensions</a></li>
                        <li><a class="dropdown-item" href="#">Probation</a></li>
                        <li><a class="dropdown-item" href="#">Property</a></li>
                        <li><a class="dropdown-item" href="#">Prosecutors</a></li>
                        <li><a class="dropdown-item" href="#">Public Contracts</a></li>
                        <li><a class="dropdown-item" href="#">Public Employees</a></li>
                        <li><a class="dropdown-item" href="#">Public Fees</a></li>
                        <li><a class="dropdown-item" href="#">Public Records</a></li>
                        <li><a class="dropdown-item" href="#">Public Safety</a></li>
                        <li><a class="dropdown-item" href="#">Public Utilities</a></li>
                        <li><a class="dropdown-item" href="#">Regulated Professions</a></li>
                        <li><a class="dropdown-item" href="#">Regulatory Oversight</a></li>
                        <li><a class="dropdown-item" href="#">Science and Technology</a></li>
                        <li><a class="dropdown-item" href="#">Senior Citizens</a></li>
                        <li><a class="dropdown-item" href="#">Smoking and Tobacco</a></li>
                        <li><a class="dropdown-item" href="#">Sports and Recreation</a></li>
                        <li><a class="dropdown-item" href="#">State Government</a></li>
                        <li><a class="dropdown-item" href="#">Taxation</a></li>
                        <li><a class="dropdown-item" href="#">Terrorism</a></li>
                        <li><a class="dropdown-item" href="#">Transportation</a></li>
                        <li><a class="dropdown-item" href="#">Veterans and Military</a></li>
                        <li><a class="dropdown-item" href="#">Wills, Trusts, and Estates</a></li>
                        <li><a class="dropdown-item" href="#">Women</a></li>
                </ul>
            </div>

            <div class="btn-group m-3">
                <button type="button" class="btn btn-secondary dropdown-toggle" id="dropdownMenuOffset2" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="10,20">
                    Search Laws by Legislative Session
                </button>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">2024-2025 Session</a></li>
                    <li><a class="dropdown-item" href="#">2022-2023 Session</a></li>
                    <li><a class="dropdown-item" href="#">2020-2021 Session</a></li>
                    <li><a class="dropdown-item" href="#">2018-2019 Session</a></li>
                    <li><a class="dropdown-item" href="#">2016-2017 Session</a></li>
                    <li><a class="dropdown-item" href="#">2014-2015 Session</a></li>
                    <li><a class="dropdown-item" href="#">2012-2013 Session</a></li>
                    <li><a class="dropdown-item" href="#">2010-2011 Session</a></li>
                    <li><a class="dropdown-item" href="#">2008-2009 Session</a></li>
                    <li><a class="dropdown-item" href="#">2006-2007 Session</a></li>
                    <li><a class="dropdown-item" href="#">2004-2005 Session</a></li>
                    <li><a class="dropdown-item" href="#">2002-2003 Session</a></li>
                    <li><a class="dropdown-item" href="#">2000-2001 Session</a></li>
                </ul>
            </div>

        </div>

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
    </nav>
</body>

</html>
