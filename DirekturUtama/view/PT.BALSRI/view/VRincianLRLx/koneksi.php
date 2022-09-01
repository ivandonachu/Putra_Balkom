<?php

$hostname = "localhost";
$username = "root";
$password = "";
$db_name  = "cbm";


$koneksicbm = new mysqli($hostname,$username,$password,$db_name);

$hostname2 = "localhost";
$username2 = "root";
$password2 = "";
$db_name2 = "balsri";

$koneksibalsri = new mysqli($hostname2,$username2,$password2,$db_name2);

$hostname3 = "localhost";
$username3 = "root";
$password3 = "";
$db_name3 = "stre";

$koneksistre = new mysqli($hostname3,$username3,$password3,$db_name3);

$hostname4 = "localhost";
$username4 = "root";
$password4 = "";
$db_name4 = "latex";

$koneksilatex = new mysqli($hostname4,$username4,$password4,$db_name4);
?>