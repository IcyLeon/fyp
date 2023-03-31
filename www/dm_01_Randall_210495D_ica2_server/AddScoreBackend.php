<?php //AddScoreBackEnd.php
//check if POST fields are received, else quit
if(!isset($_POST["sPlayerName"])||!isset($_POST["iScore"]))die("not posted!");
$sPlayerName=$_POST["sPlayerName"];
$iScore=$_POST["iScore"];
echo "Received=> $sPlayerName: $iScore"; //to show what has been received

// Connect database 
include("dbconninc.php");
// Prepare Statement...? denotes to link to php variables later
$query="insert into tb_leaderboard (Username,Score) values (?,?)";
$stmt=$conn->prepare($query);

//s - string, i - integer...to link the php variables to ? earlier
$stmt->bind_param("si",$sPlayerName,$iScore);
$stmt->execute();
echo "<p>Num rows added:$stmt->affected_rows";

$stmt->close(); // Close Statement
$conn->close(); // Close connection
?>
