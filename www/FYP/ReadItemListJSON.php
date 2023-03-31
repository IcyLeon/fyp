<?php
// Connect database //RegisterBackend.php
include('dbconninc.php');

$query = "select * from tb_itemlist";
$stmt=$conn->prepare($query);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($itemname, $itemdesc);

$arr=Array(); //JSON use: create main array 
//Fetch results
while($stmt->fetch()){
    //JSON use: create associative array for each record //4json
    $playerstats=array("itemname"=>$itemname,"itemdesc"=>$itemdesc);
    //JSON use: add to main index array 
    array_push($arr, $playerstats); //corrected typo
}

$stmt->close(); // Close Statement
$conn->close(); // Close connection

http_response_code(200); //JSON use: tell the client everything ok //4json
echo json_encode($arr); //JSON use: encode the json format

?>