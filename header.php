<?php
include('dbconfig.php');

// Test Cookie for development
$_COOKIE = true;

if ($_COOKIE == true):
    continue;
else:
?>

<!-- <script>
    if (!confirm("Please accept the terms to continue.")) {
        window.location.href = "terms.php";
    }
</script> -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NJLaw Digest</title>
    <link rel="icon" href="NJLawDigest Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<!-- 80, 104, 148 -->
<!-- (170, 159, 91) -->

<nav class="navbar navbar-expand-lg bg" style="background-color:white">
    <div class="container-fluid">
        <img src="../NJLawDigest Logo.png" class="img" width="75px" alt="...">
        <label class="navbar-brand fs-4 text-dark m-3" style="font-family:Georgia, 'Times New Roman', Times, serif;">NJLaw Digest</label>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active text-dark" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-dark" aria-current="page" href="assign_course_evaluations.php">Course Evaluations</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Tables</a>
                    <ul class="dropdown-menu">

                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="../signout.php">Sign Out</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="container-fluid flex-row-reverse">
        <form class="d-flex" role="search" method="GET">
            <label class="p-2 navbar-brand fs-6 text-dark" href="./index.php">Search System Database:</label>
            <input class="form-control me-2" type="search" name="search" placeholder="Enter table name..." aria-label="Search">
            <button class="btn btn-outline-dark text-dark bg-white" name="submit" type="submit">Go</button>
        </form>
    </div>
</nav>