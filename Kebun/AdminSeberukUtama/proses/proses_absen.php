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

$nama_buruh_1 =$_POST['nama_buruh_1'];
$nama_buruh_2 =$_POST['nama_buruh_2'];
$nama_buruh_3 =$_POST['nama_buruh_3'];
$nama_buruh_4 =$_POST['nama_buruh_4'];
$nama_buruh_5 =$_POST['nama_buruh_5'];
$nama_buruh_6 =$_POST['nama_buruh_6'];
$nama_buruh_7 =$_POST['nama_buruh_7'];
$nama_buruh_8 =$_POST['nama_buruh_8'];
$nama_buruh_9 =$_POST['nama_buruh_9'];
$nama_buruh_10 =$_POST['nama_buruh_10'];




if($nama_buruh_1 != "") {
    $nama_buruh_1 =$_POST['nama_buruh_1'];
    $sif = 1;
	$tanggal =$_POST['tanggal'];
    $query1 = mysqli_query($koneksi,"INSERT INTO absensi_seberuk VALUES('','$tanggal','$nama_buruh_1','$sif')");
}
if($nama_buruh_2 != "") {
    $nama_buruh_2 =$_POST['nama_buruh_2'];
    $sif = 1;
	$tanggal =$_POST['tanggal'];
    $query1 = mysqli_query($koneksi,"INSERT INTO absensi_seberuk VALUES('','$tanggal','$nama_buruh_2','$sif')");
}
if($nama_buruh_3 != "") {
    $nama_buruh_3 =$_POST['nama_buruh_3'];
    $sif = 1;
	$tanggal =$_POST['tanggal'];
    $query1 = mysqli_query($koneksi,"INSERT INTO absensi_seberuk VALUES('','$tanggal','$nama_buruh_3','$sif')");
}
if($nama_buruh_4 != "") {
    $nama_buruh_4 =$_POST['nama_buruh_4'];
    $sif = 1;
	$tanggal =$_POST['tanggal'];
    $query1 = mysqli_query($koneksi,"INSERT INTO absensi_seberuk VALUES('','$tanggal','$nama_buruh_4','$sif')");
}
if($nama_buruh_5 != "") {
    $nama_buruh_5 =$_POST['nama_buruh_5'];
    $sif = 1;
	$tanggal =$_POST['tanggal'];
    $query1 = mysqli_query($koneksi,"INSERT INTO absensi_seberuk VALUES('','$tanggal','$nama_buruh_5','$sif')");
}
if($nama_buruh_6 != "") {
    $nama_buruh_6 =$_POST['nama_buruh_6'];
    $sif = 1;
	$tanggal =$_POST['tanggal'];
    $query1 = mysqli_query($koneksi,"INSERT INTO absensi_seberuk VALUES('','$tanggal','$nama_buruh_6','$sif')");
}
if($nama_buruh_7 != "") {
    $nama_buruh_7 =$_POST['nama_buruh_7'];
    $sif = 1;
	$tanggal =$_POST['tanggal'];
    $query1 = mysqli_query($koneksi,"INSERT INTO absensi_seberuk VALUES('','$tanggal','$nama_buruh_7','$sif')");
}
if($nama_buruh_8 != "") {
    $nama_buruh_8 =$_POST['nama_buruh_8'];
    $sif = 1;
	$tanggal =$_POST['tanggal'];
    $query1 = mysqli_query($koneksi,"INSERT INTO absensi_seberuk VALUES('','$tanggal','$nama_buruh_8','$sif')");
}
if($nama_buruh_9 != "") {
    $nama_buruh_9 =$_POST['nama_buruh_9'];
    $sif = 1;
	$tanggal =$_POST['tanggal'];
    $query1 = mysqli_query($koneksi,"INSERT INTO absensi_seberuk VALUES('','$tanggal','$nama_buruh_9','$sif')");
}
if($nama_buruh_10 != "") {
    $nama_buruh_10 =$_POST['nama_buruh_10'];
    $sif = 1;
	$tanggal =$_POST['tanggal'];
    $query1 = mysqli_query($koneksi,"INSERT INTO absensi_seberuk VALUES('','$tanggal','$nama_buruh_10','$sif')");
}






	echo "<script>alert('Proses Absensi Berhasil :)'); window.location='../view/VAbsensiBuruh?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;


?>