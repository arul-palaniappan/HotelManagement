<!DOCTYPE html>
<html>
<body>
<?php
session_start();
?>
<!-- <form action="/useRewards" method = "POST">
  <fieldset>
    <label for="custid">Customer ID:</label>
    <input type="INTEGER" name="custid" id="custid">
    <label for="password">Password:</label>
    <input type=password name="password" id="password">
  </fieldset>
  <br><br> -->
  <?php if (isset($_POST['index'])){
    $smonth = $_POST['startMonth'];
    $sday = $_POST['startDay'];
    $syear = $_POST['startYear'];
    $emonth = $_POST['endMonth'];
    $eday = $_POST['endDay'];
    $eyear = $_POST['endYear'];
    $sdate = $smonth." ".$sday." ".$syear;
    $edate = $emonth." ".$eday." ".$eyear;
    //$sdate = strtotime($smonth." ".$sday." ".$syear);
    //$edate = strtotime($emonth." ".$eday." ".$eyear);
    //$startdate = date('Y-m-d', $sdate);
    //$enddate = date('Y-m-d', $edate);
    //$startdate = DateTime::createFromFormat('Y-m-d', $sdate);
    //$enddate = DateTime::createFromFormat('Y-m-d', $edate);
    $_SESSION['startDate'] = $sdate;
    $_SESSION['endDate'] = $edate;
    $_SESSION['roomType'] = $_POST['roomType'];
    $_SESSION['numRooms'] = $_POST['numRooms'];
    header ('Location: http://linux.students.engr.scu.edu/~sdesai2/HMS/amit/useRewards.php');
  }

  ?>
 <form method="post">
  Desired Check-in Date<br>
   <select name="startMonth" required>
         <option value="January">January</option>
         <option value="February">February</option>
         <option value="March">March</option>
         <option value="April">April</option>
         <option value="May">May</option>
         <option value="June">June</option>
         <option value="July">July</option>
         <option value="August">August</option>
         <option value="September">September</option>
         <option value="October">October</option>
         <option value="November">November</option>
         <option value="December">December</option>
  </select>
   <select name="startDay">
         <option value="01">01</option>
         <option value="02">02</option>
         <option value="03">03</option>
         <option value="04">04</option>
         <option value="05">05</option>
         <option value="06">06</option>
         <option value="07">07</option>
         <option value="08">08</option>
         <option value="09">09</option>
         <option value="10">10</option>
         <option value="11">11</option>
         <option value="12">12</option>
         <option value="13">13</option>
         <option value="14">14</option>
         <option value="15">15</option>
         <option value="16">16</option>
         <option value="17">17</option>
         <option value="18">18</option>
         <option value="19">19</option>
         <option value="20">20</option>
         <option value="21">21</option>
         <option value="22">22</option>
         <option value="23">23</option>
         <option value="24">24</option>
         <option value="25">25</option>
         <option value="26">26</option>
         <option value="27">27</option>
         <option value="28">28</option>
         <option value="29">29</option>
         <option value="30">30</option>
         <option value="31">31</option>
  </select>
   <select name="startYear">
         <option value="2017">2017</option>
         <option value="2018">2018</option>
  </select>
  <br><br>
  <br>Desired Checkout Date<br>

  <select name="endMonth" required>
           <option value="January">January</option>
           <option value="February">February</option>
           <option value="March">March</option>
           <option value="April">April</option>
           <option value="May">May</option>
           <option value="June">June</option>
           <option value="July">July</option>
           <option value="August">August</option>
           <option value="September">September</option>
           <option value="October">October</option>
           <option value="November">November</option>
           <option value="December">December</option>
    </select>
     <select name="endDay">
           <option value="01">01</option>
           <option value="02">02</option>
           <option value="03">03</option>
           <option value="04">04</option>
           <option value="05">05</option>
           <option value="06">06</option>
           <option value="07">07</option>
           <option value="08">08</option>
           <option value="09">09</option>
           <option value="10">10</option>
           <option value="11">11</option>
           <option value="12">12</option>
           <option value="13">13</option>
           <option value="14">14</option>
           <option value="15">15</option>
           <option value="16">16</option>
           <option value="17">17</option>
           <option value="18">18</option>
           <option value="19">19</option>
           <option value="20">20</option>
           <option value="21">21</option>
           <option value="22">22</option>
           <option value="23">23</option>
           <option value="24">24</option>
           <option value="25">25</option>
           <option value="26">26</option>
           <option value="27">27</option>
           <option value="28">28</option>
           <option value="29">29</option>
           <option value="30">30</option>
           <option value="31">31</option>
    </select>
     <select name="endYear">
           <option value="2017">2017</option>
           <option value="2018">2018</option>
    </select>
    <select name = "roomType">
      <option value="Presidential Suite">Presidential Suite</option>
      <option value="Deluxe Suite">Deluxe Suite</option>
      <option value="Suite">Suite</option>
      <option value="Conference Room">Conference Room</option>
      <option value="Ball Room">Ball Room</option>
    </select>
    <input type="number" min="1" max = "7" name="numRooms">
    <br><br>
  <input type="submit" name ="index" value="Continue">
</form>

</body>
</html>
