<?php //DeleteAllScores.php
// Connect database
include("dbconninc.php");
// Prepare Statement (SQL query)

$query="delete from tb_leaderboard";
$stmt=$conn->prepare($query);
// Execute Statement
$stmt->execute();
echo "<p>Num rows added:$stmt->affected_rows";

$stmt->close(); // Close Statement
$conn->close(); // Close connection
?>
