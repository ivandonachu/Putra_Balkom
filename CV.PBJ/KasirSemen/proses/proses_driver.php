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
if ($jabatan_valid == 'Kasir Semen') {

}

else{  header("Location: logout.php");
exit;
}

$nama_driver = $_POST['nm_driver'];
$bpjs_ketenagakerjaan = $_POST['bpjs_ketenagakerjaan'];
$bpjs_kesehatan = $_POST['bpjs_kesehatan'];



	$query = mysqli_query($koneksi,"INSERT INTO driver_semen VALUES('','$nama_driver','$bpjs_kesehatan ','$bpjs_ketenagakerjaan')");

			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VDriverSemen';</script>";exit;

}

  ?>