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
if ($jabatan_valid == 'Admin Workshop') {

}


else{  header("Location: logout.php");
exit;
}
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_laporan = $_POST['no_laporan'];






	$query = mysqli_query($koneksibalsri,"DELETE FROM riwayat_pengeluaran_workshop_gg WHERE no_laporan = '$no_laporan'");

			echo "<script> window.location='../view/VWorkshopGG?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	