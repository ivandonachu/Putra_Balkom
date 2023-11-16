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

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$lokasix = $_GET['lokasix'];
$tanggal = $_POST['tanggal'];
$lokasi = $_POST['lokasi'];
$stok_awal = $_POST['stok_awal'];
$bbm_masuk = $_POST['bbm_masuk'];
$bbm_keluar = $_POST['bbm_keluar'];
$losis = $_POST['losis'];
$stok_akhir = ($stok_awal + $bbm_masuk) - ($bbm_keluar + $losis);



	$query = mysqli_query($koneksi,"INSERT INTO laporan_stok_bbm VALUES ('','$tanggal','$lokasi','$stok_awal','$bbm_masuk','$bbm_keluar','$losis','$stok_akhir','$id1')");


			if ($query != "") {
				echo "<script> window.location='../view/VStokBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasix';</script>";exit;
			}
