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
if ($jabatan_valid == 'Admin Workshop') {

}

else{  header("Location: logout.php");
exit;
}


$no_sparepart = $_POST['no_sparepart'];



	$query = mysqli_query($koneksi,"DELETE FROM list_sparepart WHERE no_sparepart = '$no_sparepart'");

			echo "<script> window.location='../view/VInventorySparepart';</script>";exit;
	