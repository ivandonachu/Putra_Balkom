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
    $keping_1 =$_POST['keping_1'];
    $query = mysqli_query($koneksi,"INSERT INTO produksi_karet VALUES('','$tanggal','$nama_buruh_1','$keping_1')");
}
if($nama_buruh_2 != "") {
    $nama_buruh_2 =$_POST['nama_buruh_2'];
    $keping_2 =$_POST['keping_2'];
    $query = mysqli_query($koneksi,"INSERT INTO produksi_karet VALUES('','$tanggal','$nama_buruh_2','$keping_2')");
}
if($nama_buruh_3 != "") {
    $nama_buruh_3 =$_POST['nama_buruh_3'];
    $keping_3 =$_POST['keping_3'];
    $query = mysqli_query($koneksi,"INSERT INTO produksi_karet VALUES('','$tanggal','$nama_buruh_3','$keping_3')");
}
if($nama_buruh_4 != "") {
    $nama_buruh_4 =$_POST['nama_buruh_4'];
    $keping_4 =$_POST['keping_4'];
    $query = mysqli_query($koneksi,"INSERT INTO produksi_karet VALUES('','$tanggal','$nama_buruh_4','$keping_4')");
}
if($nama_buruh_5 != "") {
    $nama_buruh_5 =$_POST['nama_buruh_5'];
    $keping_5 =$_POST['keping_5'];
    $query = mysqli_query($koneksi,"INSERT INTO produksi_karet VALUES('','$tanggal','$nama_buruh_5','$keping_5')");
}
if($nama_buruh_6 != "") {
    $nama_buruh_6 =$_POST['nama_buruh_6'];
    $keping_6 =$_POST['keping_6'];
    $query = mysqli_query($koneksi,"INSERT INTO produksi_karet VALUES('','$tanggal','$nama_buruh_6','$keping_6')");
}
if($nama_buruh_7 != "") {
    $nama_buruh_7 =$_POST['nama_buruh_7'];
    $keping_7 =$_POST['keping_7'];
    $query = mysqli_query($koneksi,"INSERT INTO produksi_karet VALUES('','$tanggal','$nama_buruh_7','$keping_7')");
}
if($nama_buruh_8 != "") {
    $nama_buruh_8 =$_POST['nama_buruh_8'];
    $keping_8 =$_POST['keping_8'];
    $query = mysqli_query($koneksi,"INSERT INTO produksi_karet VALUES('','$tanggal','$nama_buruh_8','$keping_8')");
}
if($nama_buruh_9 != "") {
    $nama_buruh_9 =$_POST['nama_buruh_9'];
    $keping_9 =$_POST['keping_9'];
    $query = mysqli_query($koneksi,"INSERT INTO produksi_karet VALUES('','$tanggal','$nama_buruh_9','$keping_9')");
}
if($nama_buruh_10 != "") {
    $nama_buruh_10 =$_POST['nama_buruh_10'];
    $keping_10 =$_POST['keping_10'];
    $query = mysqli_query($koneksi,"INSERT INTO produksi_karet VALUES('','$tanggal','$nama_buruh_10','$keping_10')");
}






	echo "<script>alert('Proses Berhasil :)'); window.location='../view/VDataProduksi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;


?>