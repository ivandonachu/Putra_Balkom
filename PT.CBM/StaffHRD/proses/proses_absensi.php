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

$tanggal = $_POST['tanggal'];
$nama_karyawan = $_POST['nama_karyawan'];
$status = $_POST['status'];
$keterangan = $_POST['keterangan'];

		$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE nama_karyawan = '$nama_karyawan' ");
		$data_karyawan = mysqli_fetch_array($result);
		$id_karyawan = $data_karyawan['id_karyawan'];


		$query = mysqli_query($koneksi,"INSERT INTO riwayat_absensi VALUES ('','$tanggal','$id_karyawan','$status','$keterangan')");

		
		if ($query != "") {
					echo "<script> window.location='../view/VAbsensi';</script>";exit;
			}