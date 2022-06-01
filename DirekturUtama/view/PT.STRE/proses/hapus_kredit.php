<?php
session_start();
include'koneksi.php';
if(!isset($_SESSION["login"])){
  header("Location: logout.php");
  exit;
}
$id=$_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksicbm, "SELECT * FROM super_account WHERE username = '$id'");
$data1 = mysqli_fetch_array($result1);
$nama = $data1['nama_pemilik'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Direktur Utama') {

}

else{ header("Location: logout.php");
exit;
}
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_laporan = $_POST['no_laporan'];



	
		

		//Hapusriwayat keberangkatan
		$query = mysqli_query($koneksistre,"DELETE FROM kredit_kendaraan WHERE no_laporan = '$no_laporan'");



	
				echo "<script> window.location='../view/VBayarKredit?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	