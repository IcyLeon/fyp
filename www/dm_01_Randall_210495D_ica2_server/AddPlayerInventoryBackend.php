<?php //AddScoreBackEnd.php
//check if POST fields are received, else quit
if(!isset($_POST["sPlayerName"])||!isset($_POST["ShopItem"]))die("not posted!");
$sPlayerName=$_POST["sPlayerName"];
$ShopItem=$_POST["ShopItem"];

// Connect database 
include("dbconninc.php");
$query="select price,minlevel from tb_shop where itemname=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $ShopItem);
$stmt->execute();
$stmt->bind_result($Cost,$minlevel);
$stmt->store_result();
$stmt->fetch();

$query="select cash,level from tb_playerstats where Username=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $sPlayerName);
$stmt->execute();
$stmt->bind_result($CurrentAmount, $CurrentLevel);
$stmt->store_result();
$stmt->fetch();

$query="select itemname from tb_items_inventory where itemname=? and Username=?"; // check if player owns the item
$stmt2 = $conn->prepare($query);
$stmt2->bind_param("ss", $ShopItem, $sPlayerName);
$stmt2->execute();
$stmt2->store_result();
$stmt2->fetch();
$row = $stmt2->num_rows();

if ($row == 0) {
    if ($CurrentAmount >= $Cost) {
        if ($CurrentLevel >= $minlevel) {
            $query="insert into tb_items_inventory (Username,itemname,itemboughttime) values (?,?,now())";
            $stmt=$conn->prepare($query);

            //s - string, i - integer...to link the php variables to ? earlier
            $stmt->bind_param("ss",$sPlayerName,$ShopItem);
            $stmt->execute();


            $Actual = $CurrentAmount - $Cost;
            $query="Update tb_playerstats set cash =? where username=?";
            $stmt=$conn->prepare($query);

            //s - string, i - integer...to link the php variables to ? earlier
            $stmt->bind_param("is",$Actual,$sPlayerName);
            $stmt->execute();

            echo "Successfully purchase ".$ShopItem."!";
        }
        else {
            echo "Sorry! You need to be level ".$minlevel." to buy ".$ShopItem."!";
        }
    }
    else {
        echo "Sorry! Insufficient Amount!";
    }
}
else {
    echo "You already owned this item!";
}

$stmt->close(); // Close Statement
$stmt2->close(); // Close Statement
$conn->close(); // Close connection
?>
