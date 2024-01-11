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

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_laporan = $_POST['no_laporan'];



	
		

		//Hapusriwayat keberangkatan
		$query = mysqli_query($koneksi,"DELETE FROM laporan_stok_pesan_antar WHERE no_laporan = '$no_laporan'");



	
				echo "<script> window.location='../view/VLStok?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	