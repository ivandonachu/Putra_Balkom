<?php
session_start();
include'koneksi.php';
if(!isset($_SESSION["login"])){
	header("Location: logout.php");
	exit;
}
$id=$_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account WHERE id_karyawan = '$id'");
$data1 = mysqli_fetch_array($result1);
$id1 = $data1['id_karyawan'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Administrasi') {

}

else{  header("Location: logout.php");
exit;
}


$no_driver = $_POST['no_driver'];



	
		

		//Hapusriwayat keberangkatan
		mysqli_query($koneksi,"DELETE FROM driver_1 WHERE no_driver_1 = '$no_driver'");
		mysqli_query($koneksi,"DELETE FROM driver_2 WHERE no_driver_2 = '$no_driver'");



	
				echo "<script> window.location='../view/VAMT';</script>";exit;
	