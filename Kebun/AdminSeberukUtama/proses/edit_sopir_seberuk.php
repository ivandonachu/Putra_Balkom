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
if ($jabatan_valid == 'Admin Seberuk Utama') {

}

else{  header("Location: logout.php");
exit;
}

$no_sopir= $_POST['no_sopir'];
$nama_sopir = $_POST['nama_sopir'];





	

		$query = mysqli_query($koneksi,"UPDATE list_sopir_seberuk SET nama_sopir = '$nama_sopir' WHERE no_sopir = '$no_sopir'");
	
	
			echo "<script>alert('Data Berhasil Diedit'); window.location='../view/VListSopir';</script>";exit;



  ?>