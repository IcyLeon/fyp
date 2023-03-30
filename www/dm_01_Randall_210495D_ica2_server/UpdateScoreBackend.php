<?php //AddScoreBackEnd.php
//check if POST fields are received, else quit
// Connect database 
include("dbconninc.php");
if(!isset($_POST["sPlayerName"])||!isset($_POST["iScore"]))die("not posted!");
$sPlayerName=$_POST["sPlayerName"];
$iScore=$_POST["iScore"];

// Prepare Statement...? denotes to link to php variables later
$query="Update tb_leaderboard set Score=? where Username=?";
$stmt=$conn->prepare($query);
//s - string, i - integer...to link the php variables to ? earlier
$stmt->bind_param("is",$iScore,$sPlayerName);


$query2="select Score from tb_leaderboard where Username=?";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("s", $sPlayerName);
$stmt2->execute();
$stmt2->bind_result($CurrentScore);
$stmt2->store_result();
$stmt2->fetch();
$row = $stmt2->num_rows();

if ($row == 0) {
    $query="insert into tb_leaderboard (Username,Score) values (?,?)";
    $stmt=$conn->prepare($query);

    //s - string, i - integer...to link the php variables to ? earlier
    $stmt->bind_param("si",$sPlayerName,$iScore);
    $stmt->execute();
    echo "<p>Num rows added:$stmt->affected_rows";
}
else {
    if ($iScore > $CurrentScore) { // if its bigger, update it
        $stmt->execute();
        $stmt->store_result();
        echo "<p>Num rows added:$stmt->affected_rows";
    }
}
$stmt2->close();
$stmt->close(); // Close Statement
$conn->close(); // Close connection
?>
