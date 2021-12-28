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
if ($jabatan_valid == 'Admin Kebun') {

}

else{  header("Location: logout.php");
exit;
}

$no = $_POST['no'];
$no_polisi = $_POST['no_polisi'];





	

		$query = mysqli_query($koneksi,"UPDATE kendaraan_sawit SET no_polisi = '$no_polisi' WHERE no_kendaraan = '$no'");
	
	
			echo "<script>alert('Edit Data Berhasil :)'); window.location='../view/VMobilS';</script>";exit;



  ?>