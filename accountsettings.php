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
