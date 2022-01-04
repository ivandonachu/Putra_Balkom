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

$no_polisi = $_POST['no_polisi'];
$jenis_kendaraan = $_POST['jenis_kendaraan'];
$wilayah_operasi = $_POST['wilayah_operasi'];




	$query = mysqli_query($koneksi,"INSERT INTO kendaraan VALUES('','$no_polisi','','$jenis_kendaraan','$wilayah_operasi')");

			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VMT';</script>";exit;

}

  ?>