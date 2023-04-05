<?php //AddScoreBackEnd.php
//check if POST fields are received, else quit
if(!isset($_POST["sUsername"])||!isset($_POST["sItem"]))die("not posted!");
$sPlayerName=$_POST["sUsername"];
$sItem=$_POST["sItem"];

// Connect database 
include("dbconninc.php");

$query="select tb_users.uid
from tb_users_inventory 
Inner join tb_users
ON tb_users.uid = tb_users_inventory.uid
where tb_users_inventory.itemNameFromList=? and tb_users.username =?"; // check if player owns the item

$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $sItem, $sPlayerName);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($sPlayerUID);
$stmt->fetch();
$row = $stmt->num_rows();


$query="select uid from tb_users where Username=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $sPlayerName);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($sPlayerUID);
$stmt->fetch();

if ($row == 0) {
    $query="insert into tb_users_inventory (uid,itemNameFromList, quantity) values (?,?,1)";
    $stmt=$conn->prepare($query);
    //s - string, i - integer...to link the php variables to ? earlier
    $stmt->bind_param("is",$sPlayerUID,$sItem);
    $stmt->execute();
    
    echo "Successfully added ".$sItem."!";
}
else {
    $query="Update tb_users_inventory set quantity=quantity+1 where uid=? and itemNameFromList=?";
    $stmt=$conn->prepare($query);
    //s - string, i - integer...to link the php variables to ? earlier
    $stmt->bind_param("is",$sPlayerUID, $sItem);
    $stmt->execute();
    
    echo "Successfully update ".$sItem."!";
}


$stmt->close(); // Close Statement
$conn->close(); // Close connection
?>
