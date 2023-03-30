<?php
include("dbconninc.php");

if(!isset($_POST["sEmail"])||!isset($_POST["sPassword"]))die("not posted!");
$sEmail=$_POST["sEmail"];
$sPassword=$_POST["sPassword"];

$query="select uid from tb_users where Email =?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $sEmail);
$stmt->execute();
$stmt->store_result();
$row = $stmt->num_rows();
$stmt->bind_result($uid);
$stmt->fetch();

if ($row == 0) {
    echo "Email does not exist!";
}
else {
    $query="Update tb_users Set Password=? where uid=?";
    $stmt2 = $conn->prepare($query);
    $stmt2->bind_param("si", $sPassword, $uid);

    if (strlen($sPassword) >= 10) {
        $stmt2->execute();
        echo "Passwords successfully changed! You can return to the login menu";
    }
    else {
        echo "Passwords must be at least 10 characters in length!";
    }

    $stmt2->close(); // Close Statement
}
$stmt->close(); // Close Statement
$conn->close(); // Close connection
?>