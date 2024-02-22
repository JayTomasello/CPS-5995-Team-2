<?php

# Defines the details of the target database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "";

# Makes the connection with the target database
$con = mysqli_connect($host, $username, $password, $dbname)
    or die("<br>Cannot connect to DB:$dbname on $host\n");

/* In other files, include this line of code to establish the connection:

include "dbconfig.php";

*/
