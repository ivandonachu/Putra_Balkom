<?php
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

$no_transaksi=$_POST['no_transaksi'];
$tanggal_awal=$_POST['tanggal1'];
$tanggal_akhir=$_POST['tanggal2'];


				$query4 = mysqli_query($koneksi,"DELETE FROM penjualan_pangkalan WHERE no_transaksi = '$no_transaksi'");


	
	
				echo "<script> window.location='../view/VPenjualanPangkalan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
