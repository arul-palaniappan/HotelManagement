<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Manager's View - Ordering Parts</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel = "stylesheet" href="style.css">
</head>
<body>
  <h3> Ordering Parts </h3>
  <?php
  $conn=oci_connect('','', '//dbserver.engr.scu.edu/db11g');
  if($conn) {
    $query = oci_parse($conn, "SELECT PartID, PartName, MinQty - Qty, Qty, Price FROM Inventory WHERE Qty < MinQty");
    oci_execute($query);
    $id = array();
    $names = array();
    $qty = array();
    $prices = array();
    echo '<form method = "post">';
    echo '<table>';
    echo '<colgroup> <col width="30%"/> <col width="30%"/> <col width = "30%"></colgroup>';
    echo '<tr>';
    echo '<th> Part Name </th>';
    echo '<th> Quantity to Buy </th>';
    echo '<th> Price of Part </th>';
    echo '</tr>';
    $echostr = '';
    while (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
      array_push($id, strval($row[0]));
      array_push($names, $row[1]);
      array_push($qty, $row[3]);
      array_push($prices, $row[4]);
      $echostr.= '<tr> <td>'.$row[1].'</td> <td> <input type = "number" name='.$row[0].' min = '.$row[2].' required> </td> <td> $'.$row[4].' </td> </tr>';
    }
    echo $echostr;
    echo '<tr> <td> <input type = "submit" name ="submit" class="btn" value = "Buy New Parts"></td><td></td><td></td></tr></table><br><br>';
    echo "</form>";
    $size = count($id);
    $total = 0;
    static $up = array();
    if(isset($_POST['submit'])){
      for ($i=0; $i < $size ; $i++) {
        $partid = $id[$i];
        array_push($up,$_POST[$partid]);
        $sub = $_POST[$partid] * $prices[$i];
        echo '<p> The price of <strong>'.$_POST[$partid].'</strong> '.$names[$i].' is <strong>$'.$sub.'</strong>.</p>';
        $total += $sub;
      }
      echo '<br><p id = "msg">The total price for all the parts is $'.$total.'<br><br>';
      for ($j = 0; $j < $size; $j++){
        $partid = $id[$j];
        $new = $qty[$j] + $up[$j];
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
      echo '<br><br> <p class = "success">Data successfully inserted</p>';
      header("refresh:5;url=manager.php");
    }
  }
  OCILogoff($conn);
  ?>
</body>
</html>
