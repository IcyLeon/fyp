<?php //AddScoreBackEnd.php
//check if POST fields are received, else quit
if(!isset($_POST["sItemName"])||!isset($_POST["iCost"])||!isset($_POST["iLevel"]))die("not posted!");
$sItemname=$_POST["sItemName"];
$iCost=$_POST["iCost"];
$iLevel=$_POST["iLevel"];

// Connect database 
include("dbconninc.php");

$query="select itemname from tb_shop where itemname=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $sItemname);
$stmt->execute();
$stmt->store_result();
$stmt->fetch();
$row = $stmt->num_rows();

if ($row == 0) {
    // Prepare Statement...? denotes to link to php variables later
    $query="insert into tb_shop (itemname,price,minlevel) values (?,?,?)";
    $stmt=$conn->prepare($query);
    //s - string, i - integer...to link the php variables to ? earlier
    $stmt->bind_param("sii",$sItemname,$iCost,$iLevel);
    $stmt->execute();
    echo "<p>Num rows added:$stmt->affected_rows";
}

$stmt->close(); // Close Statement
$conn->close(); // Close connection
?>
