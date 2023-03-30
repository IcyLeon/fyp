<?php //AddScoreBackEnd.php
//check if POST fields are received, else quit
if(!isset($_POST["sPlayerName"])||!isset($_POST["sItem"]))die("not posted!");
$sPlayerName=$_POST["sUsername"];
$sItem=$_POST["sItem"];

// Connect database 
include("dbconninc.php");

$query="select itemNameFromList from tb_users_items_inventory where itemNameFromList=? and Username=?"; // check if player owns the item
$stmt2 = $conn->prepare($query);
$stmt2->bind_param("ss", $sItem, $sPlayerName);
$stmt2->execute();
$stmt2->store_result();
$stmt2->fetch();
$row = $stmt2->num_rows();

if ($row == 0) {
    $query="insert into tb_users_items_inventory (Username,itemNameFromList, quantity) values (?,?,1)";
    $stmt=$conn->prepare($query);
    //s - string, i - integer...to link the php variables to ? earlier
    $stmt->bind_param("ss",$sPlayerName,$sItem);
    $stmt->execute();
    $stmt->close(); // Close Statement
}
else {
    $query="Update tb_users_items_inventory set quantity=quantity+1 where username=? and itemNameFromList=?";
    $stmt=$conn->prepare($query);
    //s - string, i - integer...to link the php variables to ? earlier
    $stmt->bind_param("ss",$sPlayerName, $sItem);
    $stmt->execute();
    $stmt->close(); // Close Statement
}

echo "Successfully added ".$ShopItem."!";

$stmt2->close(); // Close Statement
$conn->close(); // Close connection
?>
