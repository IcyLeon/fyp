<?php
// Connect database //RegisterBackend.php
include('dbconninc.php');
//check if POST fields are received, else quit
if(!isset($_POST["sUsername"])||!isset($_POST["sPassword"])||!isset($_POST["sEmail"]))die("not posted!");
$sUsername=$_POST["sUsername"];
$sPassword=$_POST["sPassword"];
$sEmail=$_POST["sEmail"];

$selectallusers = "select uid from tb_users where Username=?";
$stmt2=$conn->prepare($selectallusers);
$stmt2->bind_param("s", $sUsername);
$stmt2->execute();
$stmt2->store_result();
$stmt2->fetch();
$row = $stmt2->num_rows();

if ($row == 0) {
    $selectallusers = "select uid from tb_users where Email=?";
    $stmt2=$conn->prepare($selectallusers);
    $stmt2->bind_param("s", $sEmail);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->fetch();
    $row = $stmt2->num_rows();
    if ($row == 0) {
        if (strlen($sEmail) > 0) {
            if (strlen($sUsername) > 0) {
                if (strlen($sPassword) >= 10) {
                    $hash = password_hash($sPassword, PASSWORD_DEFAULT);
                    // Prepare Statement...? denotes to link to php variables later
                    $query="insert into tb_users (Username,Password,Email,creation,lastlogin) values (?,?,?,Now(),Now())";
                    $stmt=$conn->prepare($query);
                    //s - string, i - integer...to link the php variables to ? earlier
                    $stmt->bind_param("sss",$sUsername,$hash,$sEmail);
                    // Execute Statement
                    $stmt->execute();
                    echo "Account Created Successfully";

                    $stmt->close(); // Close Statement
                }
                else {
                    echo "Passwords must be at least 10 characters in length!";
                }
            }
            else {
                echo "Username cannot be empty!";
            }
        }
        else {
            echo "Email cannot be empty!";
        }
    }
    else {
        echo "Email already existed!";
    }
}
else {
    echo "Username already taken!";
}
$conn->close(); // Close connection
?>