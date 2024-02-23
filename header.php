<?php
include('dbconfig.php');

// Test Cookie for development
$_COOKIE = false;

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

<div class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg bg" style="background-color:white">
    <div class="container-fluid d-flex justify-content-start">
        <img src="../NJLawDigest Logo.png" class="img me-4" width="100px" alt="...">
        <label class="navbar-brand fs-1 text-dark me-4" style="font-family: Georgia, 'Times New Roman', Times, serif">NJLaw Digest</label>
        <div class="dropdown me-4">
            <button type="button" class="btn btn-secondary dropdown-toggle" id="dropdownMenuOffset" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="10,20">
                Search Laws by Category
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </div>

        <div class="dropdown me-4">
            <button type="button" class="btn btn-secondary dropdown-toggle" id="dropdownMenuOffset" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="10,20">
                Search Laws by Legislative Session
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </div>

    </div>


</nav>