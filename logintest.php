<?php
include "dbconfig.php";

if (isset($_POST["Email"]) && isset($_POST["Password"]) && isset($_POST["Enter"]) && !isset($_COOKIE["signedIn"])) {
    $email = mysqli_real_escape_string($con, $_POST["Email"]);
    $password = mysqli_real_escape_string($con, $_POST["Password"]);

    $sql_email = "SELECT 'cps5301t3.administrator' AS source_table, Fname, Lname, AID AS ID, Email, Password FROM cps5301t3.administrator
    WHERE Email = '" . $email . "' AND Password = '" . $password . "' UNION ALL
    SELECT 'cps5301t3.faculty' AS source_table, Fname, Lname, FID AS ID, Email, Password FROM cps5301t3.faculty
    WHERE Email = '" . $email . "' AND Password = '" . $password . "' UNION ALL
    SELECT 'cps5301t3.student' AS source_table, Fname, Lname, SID AS ID, Email, Password FROM cps5301t3.student
    WHERE Email = '" . $email . "' AND Password = '" . $password . "'";

    $result = mysqli_query($con, $sql_email);


    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $data = mysqli_fetch_assoc($result);
            $values = array(
                $userType = $data["source_table"],
                $userName = $data["Fname"],
                $lastName = $data["Lname"],
                $UID = $data["ID"],
                $userEmail = $data["Email"]
            );
            $cookieValue = json_encode($values);
            $sessionValue = json_encode($values);
            setcookie("signedIn", $cookieValue, time() + 86400, "/");
            // session_start();
            // $sessionValue = $_SESSION["sessionValue"];

            if ($data["source_table"] == "cps5301t3.administrator") {
                header("Location: Admin/index.php");
                exit;
            } elseif ($data["source_table"] == "cps5301t3.faculty") {
                header("Location: Faculty/index.php");
                exit;
            } elseif ($data["source_table"] == "cps5301t3.student") {
                header("Location: Student/index.php");
                exit;
            } else {
                die("Page not found...");
                exit;
            }
        } else {
            die("User does not exist.");
        }
    } else {
        die("Something is wrong with SQL: " . mysqli_error($con));
    }
} else {
    $values = json_decode($_COOKIE["signedIn"]);

    $userType = $values[0];
    $userName = $values[1];
    $lastName = $values[2];
    $UID = $values[3];
    $userEmail = $values[4];

    if ($userType == "cps5301t3.administrator") {
        header("Location: Admin/index.php");
        exit;
    } elseif ($userType == "cps5301t3.faculty") {
        header("Location: Faculty/index.php");
        exit;
    } elseif ($userType == "cps5301t3.student") {
        header("Location: Student/index.php");
        exit;
    } else {
        echo "hello";
        die("Page not found...");
        exit;
    }
}
mysqli_close($con);
