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


$no_polisi = $_POST['no_polisi'];
$nm_pt = $_POST['nm_pt'];





	

		$query = mysqli_query($koneksi,"UPDATE kendaraan SET nama_perusahaan = '$nm_pt'  WHERE no_polisi = '$no_polisi'");
	
	
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VKendaraan';</script>";exit;



  ?>