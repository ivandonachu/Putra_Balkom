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
if ($jabatan_valid == 'Admin Kebun') {

}

else{  header("Location: logout.php");
exit;
}

$nama_karyawan = $_POST['nama_karyawan'];



	$query = mysqli_query($koneksi,"INSERT INTO karyawan_karet VALUES('','$nama_karyawan')");

			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VKaryawanK';</script>";exit;

}

  ?>