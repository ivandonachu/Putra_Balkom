05<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
  header("Location: logout.php");
  exit;
}
$id = $_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account WHERE id_karyawan = '$id'");
$data1 = mysqli_fetch_array($result1);
$id1 = $data1['id_karyawan'];
$foto_profile = $data1['foto_profile'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'CS Pesan Antar Non PSO') {
} else {
  header("Location: logout.php");
  exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = $_POST['tanggal'];
$stok_area = $_POST['stok_area'];
$B12K11 = $_POST['B12K11'];
$B12K10 = $_POST['B12K10'];
$B12K00 = $_POST['B12K00'];
$B05K11 = $_POST['B05K11'];
$B05K10 = $_POST['B05K10'];
$B05K00 = $_POST['B05K00'];


	$query = mysqli_query($koneksi,"INSERT INTO laporan_stok_pesan_antar VALUES('','$tanggal','$stok_area','$B12K11','$B12K10','$B12K00','$B05K11','$B05K10','$B05K00')");

			if ($query != "") {
		echo "<script>alert('Input Data Penjualan Berhasil :)'); window.location='../view/VLStok?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

  ?>