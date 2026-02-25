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


$id_kar_perta= $_POST['id_kar_perta'];



$lokasi = $_POST['lokasi'];

$kode_perta = $_POST['kode_perta'];




	$query3 = mysqli_query($koneksi,"UPDATE akun_perta SET nama = '$lokasi', kode_perta = '$kode_perta' WHERE id_kar_perta = '$id_kar_perta'");

		if ($query3!= "") {
			echo "<script>alert('Lokasi Berhasil Di Edit :)'); window.location='../view/VAkunKaryawan';</script>";exit;
}


  ?>