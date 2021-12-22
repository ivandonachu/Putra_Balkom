<?php
$hostname = "localhost";
$username = "u971562990_LaporanPerta";
$password = "@PertaJaya0613";
$db_name= "u971562990_Pertashop";

$koneksi = mysqli_connect($hostname,$username,$password);

if($koneksi){
	mysqli_select_db($koneksi,$db_name);
}else{
	echo "koneksi gagal";
}

?>