<?php
session_start();
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title>Login</title>
</head>
<body>

  <form method="post" action = "original.php"><!--removed action = 'login.php'-->
    <fieldset>
      <legend style="color:blue;font-size:30px">Login</legend>
      <label for="custid">Customer ID:</label>
      custid: <input type="INTEGER" name="custid" id="custid">
      <label for="password">Password:</label>
      password: <input type=password name="password" id="password">
    </fieldset>
    <input type="submit" value="Submit">
    <input type="reset" value="Reset">
  </form>

  <form method="post" action= "CustomerInput.php">
    <fieldset>
      <legend style="color:blue;font-size:30px">Create Account</legend>
      <label for="custname">Name:</label>
      <input type="text" name="custname" id="custname">
      <label for="password">Password:</label>
      <input type="password" name="password" id="password">
      <label for="password">Credit Card Number:</label>
      <input type="integer" name="CreditCardNo" id="CreditCardNo">
    </fieldset>
    <input type="submit" value="Submit">
    <input type="reset" value="Reset">
  </form>
</body>
</html>
<!-- </br> </br> </br> </br> </br> -->

<!--
<html lang="en">
<head>
        <meta charset="utf-8"/>
      <title>Create Account</title>
   </head>
   <body>
   <form method="post" action= "CustomerInput.php">
  <fieldset>
                <legend style="color:blue;font-size:30px">Create Account</legend>
            <label for="custname">Name:</label>
                <input type="text" name="custname" id="custname">
                        <label for="password">Password:</label>
                <input type="password" name="password" id="password">
				<label for="password">Credit Card Number:</label>
                <input type="integer" name="CreditCardNo" id="CreditCardNo">
        </fieldset>
        <input type="submit" value="Submit">
        <input type="reset" value="Reset">
      </form>
        </body>
     </html>

        </body>
     </html> -->
