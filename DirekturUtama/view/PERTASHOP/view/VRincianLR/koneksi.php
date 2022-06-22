<?php

$hostname = "localhost";
$username = "root";
$password = "";
$db_name= "cbm";


$koneksicbm = new mysqli($hostname,$username,$password,$db_name);

$hostname2 = "localhost";
$username2 = "root";
$password2 = "";
$db_name2 = "pertashop";

$koneksiperta = new mysqli($hostname2,$username2,$password2,$db_name2);
?>