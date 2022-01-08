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
if ($jabatan_valid == 'Admin Kebun') {

}

else{  header("Location: logout.php");
exit;
}

$no_laporan = $_POST['no_laporan'];
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$tanggal = $_POST['tanggal'];
$nama_karyawan = $_POST['nama_karyawan'];
$potongan_bon = $_POST['potongan_bon'];

$result = mysqli_query($koneksi, "SELECT * FROM karyawan_lengkiti WHERE nama_karyawan = '$nama_karyawan' ");
$data_perta = mysqli_fetch_array($result);
$upah_kerja = $data_perta['upah_kerja'];




			$query3 = mysqli_query($koneksi,"UPDATE absensi_lengkiti SET tanggal = '$tanggal' , nama_karyawan = '$nama_karyawan' , upah_kerja = '$upah_kerja' , potongan_bon = '$potongan_bon' WHERE no_laporan = '$no_laporan'");



echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VLAbsensiL?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

?>