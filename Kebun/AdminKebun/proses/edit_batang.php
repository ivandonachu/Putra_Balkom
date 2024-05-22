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
$no_blok = $_POST['no_blok'];
$nama_penyadap = $_POST['nama_penyadap'];
$jumlah_batang = $_POST['jumlah_batang'];
$jumlah_batang_mati = $_POST['jumlah_batang_mati'];




	
			$query3 = mysqli_query($koneksi,"UPDATE laporan_batang SET tanggal = '$tanggal' , no_blok = '$no_blok' , nama_penyadap = '$nama_penyadap' , jumlah_batang = '$jumlah_batang' , jumlah_batang_mati = '$jumlah_batang_mati'WHERE no_laporan = '$no_laporan'");


	

echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VLBatang?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

?>