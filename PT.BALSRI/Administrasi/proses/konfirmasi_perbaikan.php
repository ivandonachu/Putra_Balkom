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

$result2 = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE no_polisi = '$no_polisi' ");
$data_kendaraan = mysqli_fetch_array($result2);
$lokasi = $data_kendaraan['wilayah_operasi'];
$jenis_kendaraan = $data_kendaraan['jenis_kendaraan'];


	

		$query = mysqli_query($koneksi,"UPDATE kendaraan SET tgl_perbaikan = '$tanggal' WHERE no_polisi = '$no_polisi'");

		if($jenis_kendaraan == '5000 L'){
			if($lokasi == 'Lampung'){
				echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VRitase2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
				
			}
			elseif($lokasi == 'Palembang'){
				echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VRitaseP2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			elseif($lokasi == 'Baturaja'){
				echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VRitaseBr?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			elseif($lokasi == 'Belitung'){
				echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VRitaseBl?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			elseif($lokasi == 'Bangka'){
				echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VRitaseBk?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else{
			if($lokasi == 'Lampung'){
				echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VRitaseL8?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
				
			}
			
		}
		
			
			



  ?>