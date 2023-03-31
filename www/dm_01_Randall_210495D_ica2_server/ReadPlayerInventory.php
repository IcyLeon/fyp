 <?php //ReadScoreBoardJSON.php
// Connect database
include("dbconninc.php");
// Prepare Statement (SQL query)
if(!isset($_POST["username"]))die("not posted!");
$sPlayerName=$_POST["username"];

$query="select itemname, itemboughttime from tb_items_inventory where username = ?";
$stmt=$conn->prepare($query);
$stmt->bind_param("s", $sPlayerName);
// Execute Statement
$stmt->execute();
//Link results to variables
$stmt->bind_result($itemname, $time);
$stmt->store_result();


$arr=Array(); //JSON use: create main array 
$arr["invlist"]=Array(); //JSON use: create associate array item 
//Fetch results
while($stmt->fetch()){
    //JSON use: create associative array for each record //4json
    $playerstats=array("username"=>$sPlayerName,"itemown"=>$itemname, "itemboughttime"=>$time);
    //JSON use: add to main index array 
    array_push($arr["invlist"],$playerstats); //corrected typo
}

$stmt->close(); // Close Statement
$conn->close(); // Close connection

http_response_code(200); //JSON use: tell the client everything ok //4json
echo json_encode($arr); //JSON use: encode the json format
?>
