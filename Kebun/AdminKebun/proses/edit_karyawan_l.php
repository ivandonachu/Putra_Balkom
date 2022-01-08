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

$no_karyawan = $_POST['no_karyawan'];
$nama_karyawan = $_POST['nama_karyawan'];
$upah_kerja = $_POST['upah_kerja'];




	

		$query = mysqli_query($koneksi,"UPDATE karyawan_lengkiti SET nama_karyawan = '$nama_karyawan' , upah_kerja = '$upah_kerja' WHERE no_karyawan = '$no_karyawan'");
	
	
			echo "<script>alert('Edit Data Berhasil :)'); window.location='../view/VKaryawanL';</script>";exit;



  ?>