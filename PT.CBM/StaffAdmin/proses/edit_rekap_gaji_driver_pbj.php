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
if ($jabatan_valid == 'Staff Admin') {

}

else{  header("Location: logout.php");
exit;
}


$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$no_riwayat = $_POST['no_riwayat'];
$tanggal = $_POST['tanggal'];
$nama_driver =$_POST['nama_driver'];
$rit_semen = $_POST['rit_semen'];
$upah_semen = $_POST['upah_semen'];
$rit_batu = $_POST['rit_batu'];
$upah_batu = $_POST['upah_batu'];
$bon = $_POST['bon'];
$bpjs_ketenagakerjaan = $_POST['bpjs_ketenagakerjaan'];
$bpjs_kesehatan = $_POST['bpjs_kesehatan'];
$total_gaji = $total_gaji_semen + $total_gaji_batu;
$total_gaji_diterima =  $total_gaji_semen + $total_gaji_batu - $bpjs_ketenagakerjaan - $bpjs_kesehatan- $bon;
$keterangan = $_POST['keterangan'];






	$query = mysqli_query($koneksi,"UPDATE rekap_gaji_driver_pbj SET tanggal = '$tanggal', nama_driver = '$nama_driver', rit_semen = '$rit_semen' , upah_semen = '$upah_semen' , rit_batu = '$rit_batu' , 
                                                             upah_batu = '$upah_batu', bon = '$bon' , bpjs_ketenagakerjaan = '$bpjs_ketenagakerjaan', bpjs_kesehatan = '$bpjs_kesehatan', total_gaji = '$total_gaji' , 
                                                             total_gaji_diterima = '$total_gaji_diterima' , keterangan = '$keterangan'   WHERE no_riwayat = '$no_riwayat'");


if ($query != "") {
	echo "<script>alert('Data Berhasil di Ubah :)'); window.location='../view/VRekapGajiDriverPBJ?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>