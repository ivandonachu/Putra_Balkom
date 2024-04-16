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
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_laporan = $_POST['no_laporan'];
$tanggal =$_POST['tanggal'];
$keping = $_POST['keping'];
$stok = $_POST['stok'];
$timbang_keping = $_POST['timbang_keping'];
$kg_timbang = $_POST['kg_timbang'];
$kg_pabrik = $_POST['kg_pabrik'];
$harga = $_POST['harga'];


		$query3 = mysqli_query($koneksi,"UPDATE timbangan_getah SET tanggal = '$tanggal' , keping = '$keping' , stok = '$stok', timbang_keping = '$timbang_keping', kg_timbang = '$kg_timbang', kg_pabrik = '$kg_pabrik', harga = '$harga' WHERE no_laporan = 
		'$no_laporan'");



			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VTimbanganGetah?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;



  ?>