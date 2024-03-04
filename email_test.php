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
    $email = 'ridinonall4s@gmail.com';
    $command = "python3 send_email.py $email";
    exec($command, $output, $return_var);
    echo $output[0];
	}
?>