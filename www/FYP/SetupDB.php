<?php //SetupDB.php
//check if POST fields are received, else quit
// Connect database 
include("dbconninc.php");
// Prepare Statement...? denotes to link to php variables later
$query=["
CREATE TABLE tb_users (
    uid INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    lastlogin datetime NOT NULL,
    creation datetime NOT NULL,
    PRIMARY KEY (uid)
);"
,"
CREATE TABLE tb_playerstats (
        Username VARCHAR(100) NOT NULL,
        cash INT
);"
,"
CREATE TABLE tb_itemlist (
    itemName VARCHAR(100) NOT NULL,
    itemDesc VARCHAR(255),
    PRIMARY KEY (itemName)
);"  
// ,"
// CREATE TABLE tb_users_inventory (
//     itemNameFromList VARCHAR(100) NOT NULL,
//     uid INT NOT NULL,
//     FOREIGN KEY (uid) REFERENCES tb_users(uid),
//     Quantity INT NOT NULL
// );"  
,"
CREATE TABLE tb_users_inventory (
   itemNameFromList VARCHAR(100) NOT NULL,
   uid INT NOT NULL,
   FOREIGN KEY (uid) REFERENCES tb_users(uid),
   FOREIGN KEY (itemNameFromList) REFERENCES tb_itemlist(itemName),
   Quantity INT NOT NULL
);"   
];
foreach($query as $a){

if(mysqli_query($conn,$a)){
    echo "Table created<br>";
}else{
    echo "Broken".mysqli_error($conn);
}
}
$conn->close(); // Close connection

?>
