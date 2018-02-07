<?php
session_start();
$startDate = $_SESSION['startDate'];
$endDate = $_SESSION['endDate'];
$roomType = $_SESSION['roomType'];
$numRooms =  $_SESSION['numRooms'];
$custID = $_SESSION['custid'];
$password = $_SESSION['password'];
$cardNo = $_SESSION['cardNo'];
//echo $roomType;
//echo $startDate;
//echo "__".$custID;
$conn = oci_connect('sdesai2', 'kusabi', '//dbserver.engr.scu.edu/db11g');

$ccn = oci_parse($conn, 'SELECT creditCardNo FROM Customer Where custID = :custID');
oci_bind_by_name ($ccn, ':custID', $custID);
oci_execute($ccn);
$cardNo = oci_fetch_array($ccn)[0];
$date_startDate = strtotime($startDate);
$date_endDate = strtotime($endDate);
$stayLength = $date_startDate - $date_endDate;
$stayLength = abs($stayLength)/3600/24;
//echo "StayLength: ";
//echo $stayLength;
//echo "StartDate: ";
//echo $startDate;
//echo "EndDate: ";
//echo $endDate;



// $query = oci_parse($conn, 'SELECT CreditCardNo from customer where custID = :custID');
// oci_bind_by_name( $query, ':custID', $custID);
// oci_execute($query);
// $cardNo = oci_fetch_array($query)[0];

$query = oci_parse($conn, 'SELECT tier From Rewards Where custID = :custID');
oci_bind_by_name( $query, ':custID', $custID);
oci_execute($query);
$tier = oci_fetch_array($query)[0];

if ($tier == 0){
  //print "tier 0 \n";
    $rooms = getAvailableRooms($conn, $numRooms, $roomType, $startDate, $endDate);
    //echo $rooms;
    // if ($rooms = -1){
    //   //Refresh page and ask for reservation info again..
    //   print "didn't trigger";
    // } else {
        for ($i = 0; $i < $numRooms; $i++){
            $roomNo = oci_fetch_array($rooms)[0];
            makeReservation ($conn, $roomNo, $custID, $startDate, 1500, $endDate, 800);
        }
        chargeForRoom($conn, $stayLength, $custID, $cardNo, $roomType, $numRooms, $startDate);
        $query = oci_parse ($conn, 'SELECT points FROM REWARDS where custID = :custID');
        oci_bind_by_name($query, ':custID', $custID);
        oci_execute ($query);
        echo "Reservation Created";
    //}
}

if ($tier == 1){
    //print "late checkout activated \n";
    $rooms = getAvailableRooms($conn, $numRooms, $roomType, $startDate, $endDate);
    //print $rooms;
    // if ($rooms = -1){
    //   //Refresh page and ask for reservation info again..
    // } else {
        for ($i = 0; $i < $numRooms; $i++){
            $roomNo = oci_fetch_array($rooms)[0];
            makeReservation ($conn, $roomNo, $custID, $startDate, 1500, $endDate, 1100);
        }
        chargeForRoom($conn, $stayLength, $custID, $cardNo, $roomType, $numRooms, $startDate);
        $query = oci_parse ($conn, 'SELECT points FROM REWARDS where custID = :custID');
        oci_bind_by_name($query, ':custID', $custID);
        oci_execute ($query);
        $oldPoints = oci_fetch_array($query)[0];
        $subbedPoints = $oldPoints - (1000+500*1);
        $updatePoints = oci_parse ($conn, 'UPDATE REWARDS SET points = :subbedPoints, tier = 0 where custID = :custID');
        oci_bind_by_name($updatePoints, ':subbedPoints', $subbedPoints);
        oci_bind_by_name($updatePoints, ':custID', $custID);
        oci_execute ($updatePoints);
        echo "Reservation Created";
    // }
}

if ($tier == 2){
    //print "Last night is on us \n";
    $rooms = getAvailableRooms($conn, $numRooms, $roomType, $startDate, $endDate);
    // if ($rooms = -1){
    //   //Refresh page and ask for reservation info again..
    // } else {
        for ($i = 0; $i < $numRooms; $i++){
            $roomNo = oci_fetch_array($rooms)[0];
            makeReservation ($conn, $roomNo, $custID, $startDate, 1500, $endDate, 1100);
        }
        $stayLength = $stayLength -1;
        chargeForRoom($conn, $stayLength, $custID, $cardNo, $roomType, $numRooms, $startDate);
        $query = oci_parse ($conn, 'SELECT points FROM REWARDS where custID = :custID');
        oci_bind_by_name($query, ':custID', $custID);
        oci_execute ($query);
        $oldPoints = oci_fetch_array($query)[0];
        $subbedPoints = $oldPoints - (1000+500*2);
        $updatePoints = oci_parse ($conn, 'UPDATE REWARDS SET points = :subbedPoints, tier = 1 where custID = :custID');
        oci_bind_by_name($updatePoints, ':subbedPoints', $subbedPoints);
        oci_bind_by_name($updatePoints, ':custID', $custID);
        oci_execute ($updatePoints);
        echo "Reservation Created";
  //  }
}

if ($tier >= 3){
    //print "BOGO \n";
    $rooms = getAvailableRooms($conn, $numRooms, $roomType, $startDate, $endDate);
    // if ($rooms = -1){
    //   //Refresh page and ask for reservation info again..
    // } else {
        for ($i = 0; $i < $numRooms; $i++){
            $roomNo = oci_fetch_array($rooms)[0];
            makeReservation ($conn, $roomNo, $custID, $startDate, 1500, $endDate, 1100);
        }
        $stayLength = floor($stayLength / 2);
        chargeForRoom($conn, $stayLength, $cardNo, $roomType, $numRooms, $startDate);
        $query = oci_parse ($conn, 'SELECT points FROM REWARDS where custID = :custID');
        oci_bind_by_name($query, ':custID', $custID);
        oci_execute ($query);
        $oldPoints = oci_fetch_array($query)[0];
        $subbedPoints = $oldPoints - (1000+500*3);
        $updatePoints = oci_parse ($conn, 'UPDATE REWARDS SET points = :subbedPoints, tier = 2 where custID = :custID');
        oci_bind_by_name($updatePoints, ':subbedPoints', $subbedPoints);
        oci_bind_by_name($updatePoints, ':custID', $custID);
        oci_execute ($updatePoints);
        echo "Reservation Created";
  //  }
}

?>

<?php
function makeReservation($conn, $roomNo, $custID,  $startDate, $startTime, $endDate, $endTime){
    //print "makeReservation \n";
    //echo ".-.-.-.-.-.-.-.".$startDate."-.-.-.-.-.-.-.-.-.-.";
     $procedure = oci_parse($conn, 'BEGIN makeReservation(:roomNo, :custID, TO_DATE(:startDate, \'Month dd YYYY\'), :startTime, TO_DATE(:endDate, \'Month dd YYYY\'), :endTime);  END;');
     oci_bind_by_name($procedure, ':roomNo', $roomNo);
     oci_bind_by_name($procedure, ':custID', $custID);
     oci_bind_by_name($procedure, ':startDate', $startDate);
     oci_bind_by_name($procedure, ':startTime', $startTime);
     oci_bind_by_name($procedure, ':endDate', $endDate);
     oci_bind_by_name($procedure, ':endTime', $endTime);
     oci_execute($procedure);
}

function chargeForRoom($conn, $stayLength, $custID, $cardNo, $roomType, $numRooms, $startDate){
    //print "charging \n";
    //echo "------dd-----";
    //echo $stayLength;
    $procedure = oci_parse($conn, 'BEGIN chargeForRoom(:stayLength, :custID, :cardNo, :roomType, :numRooms, TO_DATE(:startDate, \'Month dd YYYY\')); END;');
    oci_bind_by_name($procedure, ':stayLength', $stayLength);
    oci_bind_by_name($procedure, ':custID', $custID);
    oci_bind_by_name($procedure, ':cardNo', $cardNo);
    oci_bind_by_name($procedure, ':roomType', $roomType);
    oci_bind_by_name($procedure, ':numRooms', $numRooms);
    oci_bind_by_name($procedure, ':startDate', $startDate);
    oci_execute($procedure);
}

function getAvailableRooms ($conn, $numRooms, $roomType, $startDate, $endDate){
    //print "get available rooms \n";
    //find something else that links them besides roomNo.
     //echo $startDate;
     $query = oci_parse($conn, 'SELECT RoomNo from Room WHERE roomNo not in (SELECT roomNo FROM availibility_calendar WHERE ((TO_DATE(:startDate, \'Month dd YYYY\') BETWEEN checkInDate and checkOutDate) or (TO_DATE(:endDate, \'month dd YYYY\') BETWEEN CheckInDate and checkOutDate)) and roomNo in (select RoomNo from Room where roomType = :roomType)) and roomType = :roomType');
     oci_bind_by_name($query,':roomType',$roomType);
   	 oci_bind_by_name($query,':startDate',$startDate);
   	 oci_bind_by_name($query,':endDate',$endDate);
     oci_execute($query);
      //echo $query;
     //$query = oci_fetch_array($query);
     //$query2 = oci_parse($conn, '');
     //oci_bind_by_name($query2, ':query', $query);
     //oci_bind_by_name($query2, ':roomType', $roomType);
    // oci_execute($query2);
     //$result = oci_fetch_array($query);
     //echo "---arr---";
     //echo $result[0];
     if (isset($query)){
        return $query;
     }
}
//OCILogoff($conn);
?>
