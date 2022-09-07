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
if ($jabatan_valid == 'Staff HRD') {

}

else{  header("Location: logout.php");
exit;
}

$no_surat = $_POST['no_surat'];
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];





	$query = mysqli_query($koneksi,"DELETE FROM surat_izin WHERE no_surat = '$no_surat'");

			echo "<script> window.location='../view/VSuratIzin?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	