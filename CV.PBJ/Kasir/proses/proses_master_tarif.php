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
if ($jabatan_valid == 'Kasir') {

}

else{  header("Location: logout.php");
exit;
}

$nm_perusahaan = $_POST['nm_perusahaan'];
$nm_lokasi = $_POST['nm_lokasi'];
$jarak = $_POST['jarak'];
$harga = $_POST['harga'];
$uj = $_POST['uj'];
$gaji = $_POST['gaji'];



	$query = mysqli_query($koneksi,"INSERT INTO lokasi_kirim VALUES('','$nm_perusahaan','$nm_lokasi','$jarak','$harga','$uj','$gaji')");

			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VLokasiKirim';</script>";exit;

}

  ?>