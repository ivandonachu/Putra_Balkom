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
if ($jabatan_valid == 'Admin Semen') {

}

else{  header("Location: logout.php");
exit;
}


$no = $_POST['no'];



	
		

		//Hapusriwayat keberangkatan
		$query = mysqli_query($koneksi,"DELETE FROM kendaraan_sl WHERE no_kendaraan = '$no'");



	
				echo "<script> window.location='../view/VKendaraan';</script>";exit;
	