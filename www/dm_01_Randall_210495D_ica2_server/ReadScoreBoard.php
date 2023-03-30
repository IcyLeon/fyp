<?php //ReadScoreboard.php
// Connect database
include("dbconninc.php");
// Prepare Statement (SQL query)
$query="select Username,Score from tb_leaderboard";
$stmt=$conn->prepare($query);
// Execute Statement

//Bind results to variables
$stmt->bind_result($sPlayerName,$iScore);
$stmt->execute();
// Fetch Results (select)
while($stmt->fetch()){
    echo "$sPlayerName:$iScore<br>";
}
$stmt->close();
// Close connection
$conn->close();
?>

