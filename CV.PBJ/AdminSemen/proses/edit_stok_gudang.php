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

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_laporan = $_POST['no_laporan'];
$tanggal = $_POST['tanggal'];
$gudang = $_POST['gudang'];
$stok = $_POST['stok'];

		$query3 = mysqli_query($koneksi,"UPDATE stok_gudang SET tanggal = '$tanggal' ,gudang = '$gudang', stok = '$stok'   WHERE no_laporan = '$no_laporan'");



		echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VStokGudang?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;



  ?>