<?php
include("dbconninc.php");

if(!isset($_POST["sUsername"])||!isset($_POST["sPassword"]))die("not posted!");
$sUsername=$_POST["sUsername"];
$sPassword=$_POST["sPassword"];

$query="select uid from tb_users where Username =? or Email=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $sUsername, $sUsername);
$stmt->execute();
$stmt->store_result();
$row = $stmt->num_rows();
$stmt->bind_result($uid);
$stmt->fetch();

if ($row == 0) {
    echo "No account exist";
}
else {
    $query = "select Password from tb_users where Username=? or Email=?";
    $stmt2=$conn->prepare($query);
    $stmt2->bind_param("ss", $sUsername, $sUsername);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($hash);
    $stmt2->fetch();

    $verify = password_verify($sPassword, $hash);
  
    // Print the result depending if they match
    if ($verify) {
        $query = "Update tb_users set lastlogin=Now() where Username=? or Email=?";
        $stmt2=$conn->prepare($query);
        $stmt2->bind_param("ss", $sUsername, $sUsername);
        $stmt2->execute();
        
        echo 'Login Success';
    } else {
        echo 'Incorrect Password';
    }
    $stmt2->close();
}
$stmt->close(); // Close Statement
$conn->close(); // Close connection
?>