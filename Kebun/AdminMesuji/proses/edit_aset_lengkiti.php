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

$no_aset = $_POST['no_aset'];
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$nama_aset = $_POST['nama_aset'];
$stok_aset = $_POST['stok_aset'];




	
			$query3 = mysqli_query($koneksi,"UPDATE list_aset_mesuji SET nama_aset = '$nama_aset' , stok_aset = '$stok_aset' WHERE no_aset = '$no_aset'");


	

echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VListAsetMesuji?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

?>