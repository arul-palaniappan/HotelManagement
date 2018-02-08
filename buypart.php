<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Manager's View - Ordering Parts</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
  <h3> Ordering Parts </h3>
  <?php
  $conn=oci_connect('','', '//dbserver.engr.scu.edu/db11g');
  if($conn) {
    $query = oci_parse($conn, "SELECT PartID, PartName, MinQty - Qty, Qty FROM Inventory WHERE Qty < MinQty");
    oci_execute($query);
    $id = array();
    $qty = array();
    echo '<form method = "post">';
    echo '<table>';
    echo '<tr>';
    echo '<th> Part Name </th>';
    echo '<th> Quantity to Buy </th>';
    echo '</tr>';
    $echostr = '';
    while (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
      array_push($id, strval($row[0]));
      array_push($qty, $row[3]);
      $echostr.= '<tr> <td>'.$row[1].'</td> <td> <input type = "number" name='.$row[0].' min = '.$row[2].' required> </td> </tr>';
    }
    echo $echostr;
    echo '<tr> <td> <input type = "submit" name ="submit" value = "Buy Parts"> </td><td></td></tr></table>';
    echo "</form>";
    if(isset($_POST['submit'])){
      $size = count($id);
      for ($j = 0; $j < $size; $j++){
        $partid = $id[$j];
        $new = $qty[$j] + $_POST[$partid];
        $update = oci_parse($conn, "UPDATE Inventory SET Qty = :new WHERE PartID = :partid");
        oci_bind_by_name($update, ':partid', $partid);
        oci_bind_by_name($update, ':new', $new);
        $res = oci_execute($update);
        if(!$res){
          $e = oci_error($update);
          echo $e['message'];
          break;
        }
      }
      echo '<br><br> <p style="color:green;font-size:20px">Data successfully inserted</p>';
      header("refresh:2;url=manager.php");
    }
  }
  OCILogoff($conn);
  ?>
</body>
</html>
