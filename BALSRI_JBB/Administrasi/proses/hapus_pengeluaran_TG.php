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
$no_transaksi = $_POST['no_transaksi'];



	
		

		//Hapusriwayat keberangkatan
		$query = mysqli_query($koneksi,"DELETE FROM pengeluaran_pul_tg WHERE no_transaksi = '$no_transaksi'");



	
				echo "<script> window.location='../view/VPengeluaranPulTG?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	