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


$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_penjualan = $_POST['no_penjualan'];
$lokasi = $_POST['lokasi'];



		$query3 = mysqli_query($koneksi,"UPDATE penjualan SET persetujuan = 1  WHERE no_penjualan = 
		'$no_penjualan'");



			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi';</script>";exit;
