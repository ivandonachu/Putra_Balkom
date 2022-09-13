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
if ($jabatan_valid == 'Kasir') {

}

else{  header("Location: logout.php");
exit;
}

$id_driver = $_POST['id_driver'];



	$query = mysqli_query($koneksi,"DELETE FROM driver WHERE id_driver = '$id_driver'");

			echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VListDriver';</script>";exit;



  ?>