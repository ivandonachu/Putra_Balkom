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
$wilayah_operasi = $_POST['wilayah_operasi'];


	

		$query = mysqli_query($koneksi,"UPDATE kendaraan SET tgl_perbaikan = '$tanggal' WHERE no_polisi = '$no_polisi'");
		$query2 = mysqli_query($koneksi,"UPDATE kendaraan SET tgl_perbaikan = '$tanggal' WHERE no_polisi = '$no_polisi'");


		if($wilayah_operasi == 'Balongan'){
			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VRitaseBA?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			
		}
		elseif($wilayah_operasi == 'Padalarang'){
			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VRitasePA?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		elseif($wilayah_operasi == 'Plumpang'){
			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VRitasePL?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		elseif($wilayah_operasi == 'Tanjung Gerem'){
			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VRitaseTG?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		elseif($wilayah_operasi == 'Ujung Berung'){
			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VRitaseUB?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}

			



  ?>