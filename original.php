<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST") {
  echo $_POST['custid'];
  echo $_POST['password'];
  $_SESSION['custid']= $_POST['custid'];
  $_SESSION['password']= $_POST['password'];
  $_SESSION['cardNo'] = $_POST['CreditCardNo'];
  header('Location: http://linux.students.engr.scu.edu/~sdesai2/HMS/amit/index.php');
}
?>
