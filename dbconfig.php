<?php
$username = "postgres.zwmhjgftwvkcdirgvxwj";
$password = "Wereits0easy!";
$host = "aws-0-us-east-1.pooler.supabase.com";
$port = 5432;
$dbname = "postgres";

$con = mysqli_connect($username, $password, $host, $port, $dbname)
    or die("<br>Cannot connect to DB:$dbname on $host\n");
