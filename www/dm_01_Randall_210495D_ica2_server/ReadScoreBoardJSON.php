<?php //ReadScoreBoardJSON.php
// Connect database
include("dbconninc.php");

// Prepare Statement (SQL query)
if(!isset($_POST["sort"])) die("not posted!");
$sortvalue = $_POST["sort"];
$query="";

if ($sortvalue == "0") {
    $query="select tb_leaderboard.Username,Score,tb_playerstats.totaltimesplayed from tb_leaderboard inner join tb_playerstats on tb_playerstats.username = tb_leaderboard.username ORDER BY Score DESC LIMIT 10";
}
else if ($sortvalue == "1") {
    $query="select tb_leaderboard.Username,Score,tb_playerstats.totaltimesplayed from tb_leaderboard inner join tb_playerstats on tb_playerstats.username = tb_leaderboard.username ORDER BY Username ASC LIMIT 10";
}
else {
    $query="select tb_leaderboard.Username,Score,tb_playerstats.totaltimesplayed from tb_leaderboard inner join tb_playerstats on tb_playerstats.username = tb_leaderboard.username ORDER BY tb_playerstats.totaltimesplayed DESC LIMIT 10";
}


$stmt=$conn->prepare($query);
// Execute Statement
$stmt->execute();
//Link results to variables
$stmt->bind_result($sPlayerName,$iScore, $stotaltimeplayed);

$arr=Array(); //JSON use: create main array 
$arr["scores"]=Array(); //JSON use: create associate array item 

//Fetch results
while($stmt->fetch()){
    //JSON use: create associative array for each record //4json
    $oneScore=array("username"=>$sPlayerName,"score"=>$iScore, "totaltimesplayed"=>$stotaltimeplayed);
    //JSON use: add to main index array 
    array_push($arr["scores"],$oneScore); //corrected typo

}

$stmt->close(); // Close Statement
$conn->close(); // Close connection

http_response_code(200); //JSON use: tell the client everything ok //4json
echo json_encode($arr); //JSON use: encode the json format
?>
