<?php
// Was deregister comitted?
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deregister'])) {
    // Include userDeregister.py script
    $command = "python userDeregister.py " . $_COOKIE['email']; //makes command to execute the deregister
    exec($command, $output, $return_var);
    // Were they deregistered?
    if ($return_var === 0) {
        // Delete cookie
        setcookie("email", "", time() - 3600, "/");
        // Redirect to home
        header("Location: /index.php");
        exit();
    } else {
        echo "<h2 class='text-center'>Failed to deregister user.</h2>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account Settings</title>
    <!--I guess this is Matthew's time to shine... but not too brightly please (html stuff) -->
</head>
<body>
    <h1>User Account Settings</h1>

    <form id="deregisterForm" action="userDeregister.py" method="POST">
        <p>To deregister your account, click the button below.</p>
        <button type="button" id="deregisterButton">Deregister Account</button>
        <input type="hidden" id="userEmail" name="email" value="<?php echo $_COOKIE['email']; ?>">

    </form>

    <script>
        document.getElementById('deregisterButton').addEventListener('click', function() {
            var userEmail = document.getElementById('userEmail').value;
            var confirmation = prompt("To confirm deregistration, please type your account email:");
            if (confirmation && confirmation === userEmail) {
                document.getElementById('deregisterForm').submit();
            } else {
                alert("Email confirmation does not match.");
            }
        });
    </script>
</body>
</html>