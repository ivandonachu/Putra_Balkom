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



$nama_driver = $_POST['nama_driver'];
$no_polisi = $_POST['no_polisi'];
$status = $_POST['status'];
$id_driver = $_POST['id_driver'];
$nama_pt = $_POST['nama_pt'];
$bpjs_kesehatan = $_POST['bpjs_kesehatan'];
$bpjs_ketenagakerjaan = $_POST['bpjs_ketenagakerjaan'];


	$query3 = mysqli_query($koneksi,"UPDATE driver SET  nama_driver = '$nama_driver', no_polisi = '$no_polisi', nama_pt = '$nama_pt', status = '$status' , bpjs_kesehatan = '$bpjs_kesehatan' , bpjs_ketenagakerjaan = '$bpjs_ketenagakerjaan' WHERE id_driver = '$id_driver' ");

			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VListDriver';</script>";exit;



  ?>