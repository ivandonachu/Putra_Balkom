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



$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$no_riwayat = $_POST['no_riwayat'];
$tanggal = $_POST['tanggal'];
$nama_penyadap =$_POST['nama_penyadap'];
$berat = $_POST['berat'];
$harga_gaji = $_POST['harga_gaji'];
$total_gaji = $_POST['total_gaji'];




	$query = mysqli_query($koneksi,"UPDATE rekap_gaji_penyadap_seberuk SET tanggal = '$tanggal', nama_penyadap = '$nama_penyadap', berat = '$berat' , harga_gaji = '$harga_gaji' , total_gaji = '$total_gaji'  WHERE no_riwayat = '$no_riwayat'");


if ($query != "") {

    echo "<script>alert('Data Berhasil di Ubah :)'); window.location='../view/VRekapGajiPenyadap?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>