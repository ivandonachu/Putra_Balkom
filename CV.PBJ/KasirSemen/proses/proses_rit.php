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
$foto_profile = $data1['foto_profile'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Kasir Semen') {

}

else{  header("Location: logout.php");
exit;
}


$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = $_POST['tanggal'];
$nama_driver = $_POST['nama_driver'];
$nama_rute = $_POST['nama_rute'];
$uang_gaji = $_POST['uang_gaji'];


$query = mysqli_query($koneksi,"INSERT INTO laporan_rit VALUES('','$tanggal','$nama_driver','$nama_rute','$uang_gaji',1)");

if ($query != "") {
	echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VRitDriver?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>