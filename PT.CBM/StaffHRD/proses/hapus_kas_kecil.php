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
if ($jabatan_valid == 'Staff Admin') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_transaksi = $_POST['no_transaksi'];
$akun = $_POST['akun'];
$jumlah = $_POST['jumlah'];




if ($akun == 'Saldo Awal') {
	$query = mysqli_query($koneksi,"DELETE FROM riwayat_kas_kecil WHERE no_transaksi = '$no_transaksi'");

			//rekening
			$akses_saldo1 = mysqli_query($koneksi, "SELECT * FROM rekening WHERE nama_rekening = 'Kas Kecil'");
			$data_saldo1 = mysqli_fetch_array($akses_saldo1);
			$jumlah_rekening1 = $data_saldo1['jumlah'];
			$jumlah_rekening1_new = $jumlah_rekening1 - $jumlah;

			$query1= mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_rekening1_new' WHERE nama_rekening = 'Kas Kecil' ");
			echo "<script> window.location='../view/VKasKecil2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			
}
else {
	$query = mysqli_query($koneksi,"DELETE FROM riwayat_kas_kecil WHERE no_transaksi = '$no_transaksi'");

			//rekening
			$akses_saldo1 = mysqli_query($koneksi, "SELECT * FROM rekening WHERE nama_rekening = 'Kas Kecil'");
			$data_saldo1 = mysqli_fetch_array($akses_saldo1);
			$jumlah_rekening1 = $data_saldo1['jumlah'];
			$jumlah_rekening1_new = $jumlah_rekening1 + $jumlah;

			$query1= mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_rekening1_new' WHERE nama_rekening = 'Kas Kecil' ");
			echo "<script> window.location='../view/VKasKecil2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			
}