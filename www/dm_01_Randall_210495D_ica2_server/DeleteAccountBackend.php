<?php
include("dbconninc.php");

if(!isset($_POST["sUsername"])||!isset($_POST["sPassword"]))die("not posted!");
$sUsername=$_POST["sUsername"];
$sPassword=$_POST["sPassword"];

$query="Delete from tb_users where Username =? and Password =?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $sUsername, $sPassword);
$stmt->execute();
$row = $stmt->affected_rows;

if ($row == 0) {
    echo "Delete Failed, Incorrect Username or Password";
}
else {
    echo "Delete Success, Username '".$sUsername."' deleted";
}
$stmt->close(); // Close Statement
$conn->close(); // Close connection
?>