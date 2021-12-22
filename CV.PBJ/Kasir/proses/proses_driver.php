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

$nama_driver = $_POST['nm_driver'];
$no_hp = $_POST['no_hp'];
$status_driver = $_POST['status_driver'];



	$query = mysqli_query($koneksi,"INSERT INTO driver VALUES('','$nama_driver','$no_hp','$status_driver')");

			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VDriver';</script>";exit;

}

  ?>