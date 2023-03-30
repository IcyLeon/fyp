 <?php //ReadScoreBoardJSON.php
// Connect database
include("dbconninc.php");

$query="select XP,Level,Cash,totaltimesplayed, tb_playerstats.username, tb_users.lastlogin from tb_playerstats inner join tb_users ON tb_users.username = tb_playerstats.username;";
$stmt=$conn->prepare($query);
// Execute Statement
$stmt->execute();
//Link results to variables
$stmt->bind_result($sXP,$sLevel,$sCash,$stotaltimeplayed, $username, $lastlogin);


$arr=Array(); //JSON use: create main array 
//Fetch results
while($stmt->fetch()){
    //JSON use: create associative array for each record //4json
    $playerstats=array("username"=>$username,"xp"=>$sXP, "level"=>$sLevel, "cash"=>$sCash, "totaltimesplayed"=>$stotaltimeplayed, "lastlogin"=>$lastlogin);
    //JSON use: add to main index array 
    array_push($arr,$playerstats); //corrected typo
}


$stmt->close(); // Close Statement
$conn->close(); // Close connection


http_response_code(200); //JSON use: tell the client everything ok //4json
echo json_encode($arr); //JSON use: encode the json format

?>
