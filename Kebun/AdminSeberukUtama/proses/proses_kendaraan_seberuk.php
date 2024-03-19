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
if ($jabatan_valid == 'Admin Seberuk Utama') {

}

else{  header("Location: logout.php");
exit;
}

$no_polisi = $_POST['no_polisi'];



	$query = mysqli_query($koneksi,"INSERT INTO list_kendaraan_seberuk VALUES('','$no_polisi')");

			if ($query != "") {
			echo "<script>alert('Data Berhasil Ditambah'); window.location='../view/VListKendaraan';</script>";exit;

}

  ?>