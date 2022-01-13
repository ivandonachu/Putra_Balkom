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
$no_polisi = $_POST['no_polisi'];
$jenis_kendaraan = $_POST['jenis_kendaraan'];




	

		$query = mysqli_query($koneksi,"UPDATE kendaraan_sl SET no_polisi = '$no_polisi' , status_kendaraan = '$jenis_kendaraan' WHERE no_kendaraan = '$no'");
	
	
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VKendaraan';</script>";exit;



  ?>