<?php
session_start();
include'koneksi.php';
if(!isset($_SESSION["login"])){
	header("Location: logout.php");
	exit;
}
$id=$_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account WHERE id_karyawan = '$id'");
$_POST1 = mysqli_fetch_array($result1);
$id1 = $_POST1['id_karyawan'];
$jabatan_valid = $_POST1['jabatan'];
if ($jabatan_valid == 'Admin Seberuk Utama') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal =$_POST['tanggal'];
$keping = $_POST['keping'];
$stok = $_POST['stok'];
$kg_timbang = $_POST['kg_timbang'];
$kg_pabrik = $_POST['kg_pabrik'];
$harga = $_POST['harga'];


	$query = mysqli_query($koneksi,"INSERT INTO timbangan_getah VALUES ('','$tanggal','$keping','$stok','$kg_timbang','$kg_pabrik','$harga')");


			if ($query != "") {
				echo "<script> window.location='../view/VTimbanganGetah?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
