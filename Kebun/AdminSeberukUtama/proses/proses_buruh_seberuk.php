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

$nama_buruh = $_POST['nama_buruh'];



	$query = mysqli_query($koneksi,"INSERT INTO list_buruh_seberuk VALUES('','$nama_buruh')");

			if ($query != "") {
			echo "<script>alert('Data Berhasil Ditambah'); window.location='../view/VListBuruh';</script>";exit;

}

  ?>