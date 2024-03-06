<html>
 <body>
  <head>
   <title>
     run
   </title>
  </head>

   <form method="post">

    <input type="submit" value="GO" name="GO">
   </form>
 </body>
</html>

<?php
	if(isset($_POST['GO']))
	{
		$output = exec("/usr/bin/env python3 /Applications/XAMPP/xamppfiles/htdocs/py-tests/send_email.py");
        echo $output;
	}
?>