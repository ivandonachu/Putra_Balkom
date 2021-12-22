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

$kode_perta = $_POST['kode_perta'];
$lokasi = $_POST['lokasi'];
$sp = $_POST['sp'];
$sh = $_POST['sh'];



	$query = mysqli_query($koneksi,"INSERT INTO pertashop VALUES ('$kode_perta','$lokasi','$sp','$sh')");


			if ($query != "") {
				echo "<script> window.location='../view/VPertashop';</script>";exit;
			}
