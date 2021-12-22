<?php

$hostname = "localhost";
$username = "u971562990_LaporanCBM";
$password = "@CBMjayasakti0613";
$db_name  = "u971562990_PTCBM";


$koneksicbm = new mysqli($hostname,$username,$password,$db_name);

$hostname2 = "localhost";
$username2 = "u971562990_LaporanPBJ";
$password2 = "@PBJjayasakti0613";
$db_name2 = "u971562990_CVPBJ";

$koneksipbj = new mysqli($hostname2,$username2,$password2,$db_name2);
?>