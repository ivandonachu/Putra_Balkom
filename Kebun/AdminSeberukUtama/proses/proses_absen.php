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



$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal =$_POST['tanggal'];
$nama_buruh =$_POST['nama_buruh'];
$sif = 1;

$query = mysqli_query($koneksi,"INSERT INTO absensi_seberuk VALUES('','$tanggal','$nama_buruh','$sif')");



if ($query != "") {
	echo "<script>alert('Proses Absensi Berhasil :)'); window.location='../view/VAbsensiBuruh?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}
?>