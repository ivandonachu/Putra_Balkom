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


$no_rute = $_POST['no_rute'];
$posisi_bongkar = $_POST['posisi_bongkar'];
$tujuan_berangkat = $_POST['tujuan_berangkat'];
$tambahan = $_POST['tambahan'];
$jumlah = $_POST['jumlah'];




	$query3 = mysqli_query($koneksi,"UPDATE rute_driver SET  posisi_bongkar = '$posisi_bongkar', tujuan_berangkat = '$tujuan_berangkat', tambahan = '$tambahan', jumlah = '$jumlah' WHERE no_rute = '$no_rute' ");

			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VListRute';</script>";exit;



  ?>