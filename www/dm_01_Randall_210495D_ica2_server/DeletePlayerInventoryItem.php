<?php //DeleteUserBackend.php
// Connect database
include("dbconninc.php");
// Prepare Statement (SQL query)

if(!isset($_POST["sPlayerName"]) || !isset($_POST["ShopItem"])) die("not posted!");
$sPlayerName=$_POST["sPlayerName"];
$sShopName=$_POST["ShopItem"];

$query="select username,itemname from tb_items_inventory where username =? and itemname=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $sPlayerName, $sShopName);
$stmt->execute();
$stmt->store_result();
$stmt->fetch();
$row = $stmt->num_rows();

if ($row != 0) {
    $query="Delete from tb_items_inventory where Username =? and itemname=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $sPlayerName, $sShopName);

    $query2="Select cash,xp from tb_playerstats where username=?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("s", $sPlayerName);
    $stmt2->execute();
    $stmt2->bind_result($cash, $exp);
    $stmt2->store_result();
    $stmt2->fetch();

    $query2="Select price from tb_shop where itemname=?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("s", $sShopName);
    $stmt2->execute();
    $stmt2->bind_result($price);
    $stmt2->store_result();
    $stmt2->fetch();
    
    $cash = $cash + intval($price/2);
    $exp = $exp + 2;

    $query2="Update tb_playerstats set cash=?, XP=? where username=?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("iis", $cash,$exp,$sPlayerName);
    $stmt2->execute();

    $stmt->execute();
    $stmt2->close();
}

$stmt->close(); // Close Statement
$conn->close(); // Close connection
?>

