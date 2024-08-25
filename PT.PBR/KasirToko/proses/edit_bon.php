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

$nama = $_POST['nama'];
$tanggal = $_POST['tanggal'];
$referensi = $_POST['referensi'];
$pembayaran = $_POST['pembayaran'];
$jumlah = $_POST['jumlah'];
$no_bon = $_POST['no_bon'];

	
		$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE nama_karyawan = '$nama' ");
		$data_karyawan = mysqli_fetch_array($result);
		$id_karyawan = $data_karyawan['id_karyawan'];
		$nama_karyawan = $data_karyawan['nama_karyawan'];



	
    
	$query = mysqli_query($koneksi,"UPDATE bon_karyawan SET tanggal = '$tanggal' , id_karyawan = '$id_karyawan' , nama_karyawan = '$nama_karyawan' , jumlah_bon = '$jumlah' WHERE no_bon = '$no_bon'");



				echo "<script> window.location='../view/VBonKaryawan';</script>";exit;

