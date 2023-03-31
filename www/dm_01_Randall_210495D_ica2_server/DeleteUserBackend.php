<?php //DeleteUserBackend.php
// Connect database
include("dbconninc.php");
// Prepare Statement (SQL query)

if(!isset($_POST["sPlayerName"])) die("not posted!");
$sPlayerName=$_POST["sPlayerName"];

$query="Delete from tb_playerstats where Username =?";
$query2="Delete from tb_leaderboard where Username =?";
$query3="Delete from tb_items_inventory where Username =?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $sPlayerName);
$stmt->execute();
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("s", $sPlayerName);
$stmt2->execute();
$stmt3 = $conn->prepare($query3);
$stmt3->bind_param("s", $sPlayerName);
$stmt3->execute();

$query="delete from tb_users where Username=?";
$stmt=$conn->prepare($query);
$stmt->bind_param("s",$sPlayerName);
// Execute Statement
$stmt->execute();

$row = $stmt->affected_rows;

if ($row == 0) {
    echo "Delete Player's stats failed";
}
else {
    echo "Delete '".$sPlayerName."' stats and its status";
}
$stmt->close(); // Close Statement
$stmt2->close();
$stmt3->close();
$conn->close(); // Close connection

?>

