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
if ($jabatan_valid == 'Staff Admin') {

}

else{  header("Location: logout.php");
exit;
}
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_laporan = $_POST['no_laporan'];

var_dump($no_laporan);
		//hapus
	   mysqli_query($koneksi,"DELETE FROM bon_pribadi WHERE no_bon = '$no_laporan'");

	
		echo "<script> window.location='../view/VBonPribadi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
