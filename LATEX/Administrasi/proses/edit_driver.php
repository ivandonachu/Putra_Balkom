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

$no_driver = $_POST['no_driver'];
$nm_driver = $_POST['nm_driver'];
$no_hp = $_POST['no_hp'];
$alamat = $_POST['alamat'];



	

		$query = mysqli_query($koneksi,"UPDATE driver_1 SET nama_driver_1 = '$nm_driver' , no_hp_1 = '$no_hp', alamat_1 = '$alamat'  WHERE no_driver_1 = '$no_driver'");
		$query = mysqli_query($koneksi,"UPDATE driver_2 SET nama_driver_2 = '$nm_driver' , no_hp_2 = '$no_hp', alamat_2 = '$alamat'  WHERE no_driver_2 = '$no_driver'");
	
	
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VAMT';</script>";exit;



  ?>