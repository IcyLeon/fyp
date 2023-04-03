<?php
// Connect database //RegisterBackend.php
include('dbconninc.php');
//check if POST fields are received, else quit
if(!isset($_POST["sUsername"]))die("not posted!");
$sUsername=$_POST["sUsername"];


// $selectusers = "
// select itemNameFromList, tb_users.Username, Quantity
// from tb_users_items_inventory 
// inner join tb_users 
// on tb_users.uid = tb_users_items_inventory.uid  
// where tb_users.Username=?";

$selectusers = "
select itemNameFromList, tb_users.Username, tb_itemlist.itemDesc, Quantity
from tb_users_items_inventory 
inner join tb_users 
on tb_users.uid = tb_users_items_inventory.uid  
inner join tb_itemlist 
on tb_itemlist.itemName = itemNameFromList  
where tb_users.Username=?";


$stmt=$conn->prepare($selectusers);
$stmt->bind_param("s", $sUsername);
$stmt->execute();
$stmt->store_result();
//$stmt->bind_result($itemname, $sUsername, $quantity);
$stmt->bind_result($itemname, $sUsername, $itemdesc, $quantity);

$arr=Array(); //JSON use: create main array 
//Fetch results
while($stmt->fetch()){
    //JSON use: create associative array for each record //4json
    //$playerstats=array("username"=>$sUsername,"itemown"=>$itemname, "Quantity"=>$quantity);
    $playerstats=array("username"=>$sUsername,"itemown"=>$itemname,"itemdesc"=>$itemdesc, "Quantity"=>$quantity);
    //JSON use: add to main index array 
    array_push($arr, $playerstats); //corrected typo
}

$stmt->close(); // Close Statement
$conn->close(); // Close connection

http_response_code(200); //JSON use: tell the client everything ok //4json
echo json_encode($arr); //JSON use: encode the json format

?>