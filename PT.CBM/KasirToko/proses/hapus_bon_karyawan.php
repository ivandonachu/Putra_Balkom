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
if ($jabatan_valid == 'Kasir') {

}

else{  header("Location: logout.php");
exit;
}

$no_laporan = $_POST['no_laporan'];

		$result = mysqli_query($koneksi, "SELECT * FROM bon_karyawan WHERE no_bon = '$no_laporan' ");
		$data_pengeluaran = mysqli_fetch_array($result);
		$jumlah = $data_pengeluaran['jumlah_bon'];

		//hapus
		$query = mysqli_query($koneksi,"DELETE FROM bon_karyawan WHERE no_bon = '$no_laporan'");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;
		$query1 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

	
		echo "<script> window.location='../view/VBonKaryawan';</script>";exit;
