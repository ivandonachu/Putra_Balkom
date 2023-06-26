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
if ($jabatan_valid == 'Admin Seberuk') {

}

else{  header("Location: logout.php");
exit;
}

$no_kendaraan = $_POST['no_kendaraan'];
$no_polisi = $_POST['no_polisi'];





	

		$query = mysqli_query($koneksi,"UPDATE list_kendaraan_seberuk SET no_polisi = '$no_polisi' WHERE no_kendaraan = '$no_kendaraan'");
	
	
			echo "<script>alert('Data Berhasil Diedit'); window.location='../view/VListKendaraan';</script>";exit;



  ?>