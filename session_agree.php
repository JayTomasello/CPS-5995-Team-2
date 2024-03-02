<?php
session_start();
$_SESSION = 'agree';
header('Location: index.php');
