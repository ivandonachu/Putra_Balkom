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
if ($jabatan_valid == 'Kepala Gudang') {

}

else{  header("Location: logout.php");
exit;
}

$no_laporan = $_POST['no_laporan'];

	$query = mysqli_query($koneksi,"DELETE FROM laporan_inventory WHERE no_laporan = '$no_laporan' ");


			echo "<script> window.location='../view/VLaporanInventory';</script>";exit;
	
