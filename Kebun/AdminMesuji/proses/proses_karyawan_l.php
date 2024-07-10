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
if ($jabatan_valid == 'Admin Mesuji') {

}

else{  header("Location: logout.php");
exit;
}

$nama_karyawan = $_POST['nama_karyawan'];

$upah_kerja = $_POST['upah_kerja'];



	$query = mysqli_query($koneksi,"INSERT INTO karyawan_mesuji VALUES('','$nama_karyawan','$upah_kerja')");

			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VKaryawanL';</script>";exit;

}

  ?>