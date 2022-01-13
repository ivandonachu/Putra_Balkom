<?php
$hostname = "localhost";
$username = "root";
$password = "";
$db_name= "pbj";

$koneksi = mysqli_connect($hostname,$username,$password);

if($koneksi){
	mysqli_select_db($koneksi,$db_name);
}else{
	echo "koneksi gagal";
}

?>