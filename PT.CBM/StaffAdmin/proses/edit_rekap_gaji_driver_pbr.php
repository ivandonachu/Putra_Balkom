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
$jabatan = $_POST['jabatan'];
$rit_nje = $_POST['rit_nje'];
$upah_nje = 100000 * $rit_nje;
$rit_gas_palembang = $_POST['rit_gas_palembang'];
$upah_gas_palembang = 200000 * $rit_gas_palembang;
$rit_nje2 = $_POST['rit_nje2'];
$upah_nje2 = 100000 * $rit_nje2;
$bpjs_kesehatan = $_POST['bpjs_kesehatan'];
$bpjs_ketenagakerjaan = $_POST['bpjs_ketenagakerjaan'];
$uang_makan = $_POST['uang_makan'];
$angsuran_bon_bulanan = $_POST['angsuran_bon_bulanan'];
$total_gaji = $upah_nje + $uang_makan  + $upah_gas_palembang;
$total_gaji_diterima =  $upah_nje + $uang_makan  + $upah_gas_palembang - $bpjs_ketenagakerjaan;
$keterangan = $_POST['keterangan'];






	$query = mysqli_query($koneksi,"UPDATE rekap_gaji_driver_pbr SET tanggal = '$tanggal', nama_driver = '$nama_driver', jabatan = '$jabatan' , rit_nje = '$rit_nje' , upah_nje = '$upah_nje' , rit_gas_palembang = '$rit_gas_palembang' , rit_nje2 = '$rit_nje2' , upah_nje2 = '$upah_nje2',
                                                             upah_gas_palembang = '$upah_gas_palembang', bpjs_kesehatan = '$bpjs_kesehatan' , bpjs_ketenagakerjaan = '$bpjs_ketenagakerjaan', uang_makan = '$uang_makan', angsuran_bon_bulanan = '$angsuran_bon_bulanan', total_gaji = '$total_gaji' , 
                                                             total_gaji_diterima = '$total_gaji_diterima' , keterangan = '$keterangan'   WHERE no_riwayat = '$no_riwayat'");


if ($query != "") {
	echo "<script>alert('Data Berhasil di Ubah :)'); window.location='../view/VRekapGajiDriverPBR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>