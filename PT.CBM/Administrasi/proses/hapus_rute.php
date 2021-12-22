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

$no_rute = $_POST['no_rute'];



	$query = mysqli_query($koneksi,"DELETE FROM rute_driver WHERE no_rute = '$no_rute'");

			echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VListRute';</script>";exit;



  ?>