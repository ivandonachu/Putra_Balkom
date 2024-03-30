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
if ($jabatan_valid == 'Admin Semen') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = $_POST['tanggal'];
$gudang = $_POST['gudang'];
$stok = $_POST['stok'];






	$query = mysqli_query($koneksi,"INSERT INTO stok_gudang VALUES ('','$tanggal','$gudang','$stok')");

			
			if ($query != "") {
				echo "<script> window.location='../view/VStokGudang?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
