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

$posisi_bongkar = $_POST['posisi_bongkar'];
$tujuan_berangkat = $_POST['tujuan_berangkat'];
$tambahan = $_POST['tambahan'];
$jumlah = $_POST['jumlah'];



		
		
		$query = mysqli_query($koneksi,"INSERT INTO rute_driver VALUES ('','$posisi_bongkar','$tujuan_berangkat','$tambahan','$jumlah')");

		
		if ($query != "") {
					echo "<script>alert('Data Berhasil Di Tambah :)'); window.location='../view/VListRute';</script>";exit;
			}