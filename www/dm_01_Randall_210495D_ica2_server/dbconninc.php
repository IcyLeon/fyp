<?php //dbconninc.php
// database settings
$hostaddress="localhost";
$dbuser="root";
$password="";
$dbname="dm_01_Randall_210495D_ica2"; //change to the dbname based on your naming convention
// Connect database
$conn=new mysqli($hostaddress,$dbuser,$password,$dbname);
?>
