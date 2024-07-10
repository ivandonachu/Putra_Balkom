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
if ($jabatan_valid == 'Admin Mesuji') {

}

else{  header("Location: logout.php");
exit;
}

$no_driver = $_POST['no_driver'];
$nm_driver = $_POST['nm_driver'];




	

		$query = mysqli_query($koneksi,"UPDATE driver_sawit_msj SET nama_driver = '$nm_driver' WHERE no_driver = '$no_driver'");
	
	
			echo "<script>alert('Edit Data Berhasil :)'); window.location='../view/VDriverS';</script>";exit;



  ?>