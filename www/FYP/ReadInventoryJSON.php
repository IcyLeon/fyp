<?php
// Connect database //RegisterBackend.php
include('dbconninc.php');
//check if POST fields are received, else quit
if(!isset($_POST["sUsername"]))die("not posted!");
$sUsername=$_POST["sUsername"];


$selectusers = "select * from tb_items_inventory where Username=?";
$stmt=$conn->prepare($selectusers);
$stmt->bind_param("s", $sUsername);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($sUsername, $itemname, $itemdesc);
$row = $stmt->num_rows();

$arr=Array(); //JSON use: create main array 
//Fetch results
while($stmt->fetch()){
    //JSON use: create associative array for each record //4json
    $playerstats=array("username"=>$sUsername,"itemown"=>$itemname,"itemdesc"=>$itemdesc);
    //JSON use: add to main index array 
    array_push($arr, $playerstats); //corrected typo
}

$stmt->close(); // Close Statement
$conn->close(); // Close connection

http_response_code(200); //JSON use: tell the client everything ok //4json
echo json_encode($arr); //JSON use: encode the json format

?>