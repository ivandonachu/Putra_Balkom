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
$nama_buruh =$_POST['nama_buruh'];
    $keping =$_POST['keping'];


		$query3 = mysqli_query($koneksi,"UPDATE produksi_karet SET tanggal = '$tanggal' , nama_buruh = '$nama_buruh' , keping = '$keping' WHERE no_laporan = 
		'$no_laporan'");



			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VDataProduksi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;



  ?>