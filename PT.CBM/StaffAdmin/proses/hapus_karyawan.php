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
if ($jabatan_valid == 'Staff Admin') {

}

else{  header("Location: logout.php");
exit;
}


$id_karyawan = $_POST['id_karyawan'];



	$query = mysqli_query($koneksi,"DELETE FROM karyawan WHERE id_karyawan = '$id_karyawan'");

			echo "<script> window.location='../view/VKaryawan';</script>";exit;
	