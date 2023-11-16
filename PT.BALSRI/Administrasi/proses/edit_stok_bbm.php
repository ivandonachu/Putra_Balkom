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
if ($jabatan_valid == 'Administrasi') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$lokasix = $_POST['lokasix'];
$no_laporan = $_POST['no_laporan'];
$tanggal = $_POST['tanggal'];
$lokasi = $_POST['lokasi'];
$stok_awal = $_POST['stok_awal'];
$bbm_masuk = $_POST['bbm_masuk'];
$bbm_keluar = $_POST['bbm_keluar'];
$losis = $_POST['losis'];
$stok_akhir = ($stok_awal + $bbm_masuk) - ($bbm_keluar + $losis);

		$query3 = mysqli_query($koneksi,"UPDATE laporan_stok_bbm SET tanggal = '$tanggal' , lokasi = '$lokasi' , stok_awal = '$stok_awal' , bbm_masuk = '$bbm_masuk' , bbm_keluar = '$bbm_keluar' , losis = '$losis' , stok_akhir = '$stok_akhir' , kode_input = '$id1' WHERE no_laporan = 
		'$no_laporan'");
	



			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VStokBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasix';</script>";exit;



  ?>