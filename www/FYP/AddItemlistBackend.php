<?php //AddItemToBackend.php
//check if POST fields are received, else quit
if(!isset($_POST["sItemName"])||!isset($_POST["sItemDesc"]))die("not posted!");
$sItemname=$_POST["sItemName"];
$sItemDesc=$_POST["sItemDesc"];

// Connect database 
include("dbconninc.php");

$query="select itemname from tb_itemlist where itemname=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $sItemname);
$stmt->execute();
$stmt->store_result();
$stmt->fetch();
$row = $stmt->num_rows();

if ($row == 0) {
    // Prepare Statement...? denotes to link to php variables later
    $query="insert into tb_itemlist (itemname,itemdesc) values (?,?)";
    $stmt=$conn->prepare($query);
    //s - string, i - integer...to link the php variables to ? earlier
    $stmt->bind_param("ss",$sItemname,$sItemDesc);
    $stmt->execute();
    echo "<p>Num rows added:$stmt->affected_rows";
}

$stmt->close(); // Close Statement
$conn->close(); // Close connection
?>
