<?php //ReadScoreboard.php
// Connect database
include("dbconninc.php");
// Prepare Statement (SQL query)

if((!isset($_POST["sPlayerName"]) || !isset($_POST["newxp"]) || !isset($_POST["newcash"]) || !isset($_POST["newlevel"]) || !isset($_POST["newtimeplayed"]))) die("not posted!");
$sPlayerName=$_POST["sPlayerName"];
$sXP=$_POST["newxp"];
$sCash=$_POST["newcash"];
$sLevel=$_POST["newlevel"];
$sTimePlayed=$_POST["newtimeplayed"];

$query2 = "select Username from tb_playerstats where Username=?";
$stmt2=$conn->prepare($query2);
$stmt2->bind_param("s", $sPlayerName);
$stmt2->execute();
$stmt2->store_result();
$stmt2->fetch();
$row = $stmt2->num_rows();

if ($row == 0) {
    $query="insert into tb_playerstats (Level,xp,cash,Username,totaltimesplayed) values(?,?,?,?,?)";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("iiisi",$sLevel, $sXP, $sCash, $sPlayerName, $sTimePlayed);
    // Execute Statement
    $stmt->execute();
    echo "<p>Num rows added:$stmt->affected_rows";

    $stmt->close(); // Close Statement
}
$stmt2->close(); // Close Statement
$conn->close(); // Close connection
?>