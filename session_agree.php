<?php
session_start();
$_SESSION['agree'] = TRUE;
header('Location: index.php');
