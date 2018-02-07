<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // collect input data

	// Get the custname
     $name = $_POST['custname'];

  // Request password
     $password = $_POST['password'];
//Get those digits
$CreditCardNo = $_POST['CreditCardNo'];

     if (!empty($name)){
		$name = prepareInput($name);
     }
		$id = checkId();

   $password = prepareInput($password);
	 if (!empty($CreditCardNo)){
		$CreditCardNo = prepareInput($CreditCardNo);
     }

// into Customer table
	insertCustomerIntoDB($id,$name,$password,$CreditCardNo);


}
function prepareInput($inputData){
	$inputData = trim($inputData);
  	$inputData  = htmlspecialchars($inputData);
  	return $inputData;
}
function checkId(){
//connect to your database. Type in your username, password and the DB path
$conn=oci_connect('', '', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
        exit;
	}
     $rando = rand();
     $check = oci_parse($conn, "Select custid from Customer Where custid = :id;");
    while($check == $rando){
      $rando = rand();
    }
    return $rando;
}
function insertCustomerIntoDB($id,$name,$password,$CreditCardNo){
	//connect to your database. Type in your username, password and the DB path
$conn=oci_connect('sdesai2', 'kusabi', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
        exit;
	}
	$query = oci_parse($conn, "Insert Into Customer(CustId, password, CustName, CreditCardNo) values(:custid, :custname, :password, :CreditCardNo)");

	oci_bind_by_name($query, ':custid', $id);
	oci_bind_by_name($query, ':custname', $name);
  	oci_bind_by_name($query, ':password', $password);
	oci_bind_by_name($query, ':CreditCardNo', $CreditCardNo);


	// Execute the query
	$res = oci_execute($query);
	if ($res)
		echo '<br><br> <p style="color:green;font-size:20px">Your new customer id is</p>';
		echo $id;
		echo file_get_contents("initialLogin.php");
  $query = oci_parse($conn, "Insert Into rewards(CustId, points, tier) values(:custid, 0, 0)");
  oci_bind_by_name($query, ':custid', $id);
  $res = oci_execute($query);




	OCILogoff($conn);
}


?>
