<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Book your Room</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
  <h1> Book your Rooms </h1>
  <p> You have selected the following rooms </p>
  <?php /*List the types of rooms selected */ ?>
  <?php /*Calculate TotalCost taking into account Group_Packages and Seasonal_Discount */?>
  <h3> The total cost for all of your rooms is <?php echo TotalCost ?> </h3>
  <form action="bookRoom()" method="post">
    <input type="text" name="custname" placeholder="Customer Name*" required>
    <input type="checkbox" name="returning"> Are you a returning Customer?
    <input type="text" name="rewardsno" placeholder="Rewards Number*">
    <!-- I don't know how we are going to offer the Rewards Member to select their exact room -->
    <input type="password" name = "creditcardno" placeholder="Credit Card Number*" required>
    <input type="submit" value="Pay for Your Rooms">
  </form>
  <a href="selectroom.php" class="button">Select Different Rooms</a>
</body>
</html>
<?php
/* If new customer then CustomerName and CreditCardNo gets added to Customer table,
Select Available Rooms for each of the room types and mark them as unavailable and update Availibility_Calendar,
For each Room add Room Number and CustomerId and Room Price to the Charges table
TotalCost and CustID gets added to Rewards points
*/
?>
