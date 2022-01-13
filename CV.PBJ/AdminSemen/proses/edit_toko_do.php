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
$nm_lokasi = $_POST['nm_lokasi'];






	

		$query = mysqli_query($koneksi,"UPDATE toko_do_l SET  nm_lokasi = '$nm_lokasi'   WHERE no_lokasi = '$no'");
	
	
			echo "<script>alert('Update Data Berhasil :)'); window.location='../view/VTokoDO';</script>";exit;



  ?>