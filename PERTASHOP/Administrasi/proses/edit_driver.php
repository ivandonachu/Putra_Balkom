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
$nm_pt = $_POST['nm_pt'];




	

		$query = mysqli_query($koneksi,"UPDATE driver SET nama_driver = '$nm_driver' , nama_perusahaan = '$nm_pt'  WHERE no_driver = '$no_driver'");
	
	
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VDriver';</script>";exit;



  ?>