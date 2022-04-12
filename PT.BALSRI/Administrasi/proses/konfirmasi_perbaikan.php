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
$no_polisi = $_POST['no_polisi'];
$tanggal = $_POST['tanggal'];
$lokasi = $_POST['lokasi'];


	

		$query = mysqli_query($koneksi,"UPDATE kendaraan SET tgl_perbaikan = '$tanggal' WHERE no_polisi = '$no_polisi'");
		$query2 = mysqli_query($koneksi,"UPDATE kendaraan SET tgl_perbaikan = '$tanggal' WHERE no_polisi = '$no_polisi'");

		if($lokasi == 'Lampung'){
			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VRitase2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			
		}
		elseif($lokasi == 'Palembang'){
			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VRitaseP2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		elseif($lokasi == 'Baturaja'){
			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VRitaseBr?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
			
			



  ?>