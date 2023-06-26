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

$no_buruh= $_POST['no_buruh'];
$nama_buruh = $_POST['nama_buruh'];





	

		$query = mysqli_query($koneksi,"UPDATE list_burhar_seberuk SET nama_buruh = '$nama_buruh' WHERE no_buruh = '$no_buruh'");
	
	
			echo "<script>alert('Data Berhasil Diedit'); window.location='../view/VListBuruhHarian';</script>";exit;



  ?>