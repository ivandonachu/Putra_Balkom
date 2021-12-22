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
if ($jabatan_valid == 'Kepala Oprasional') {

}

else{  header("Location: logout.php");
exit;
}

$nama_driver = $_POST['nama_driver'];
$no_polisi = $_POST['no_polisi'];
$status = $_POST['status'];
$id_driver = $_POST['id_driver'];


		$query = mysqli_query($koneksi,"INSERT INTO driver VALUES ('$id_driver','$nama_driver','$no_polisi','$status')");

		
		if ($query != "") {
					echo "<script>alert('Data Berhasil Di Tambah :)'); window.location='../view/VListDriver';</script>";exit;
			}