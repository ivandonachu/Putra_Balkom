<?php
session_start();
include'koneksi.php';
if(!isset($_SESSION["login"])){
  header("Location: logout.php");
  exit;
}
$id=$_COOKIE['id_cookie'];



$lokasi =  $_POST['lokasi'];

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
date_default_timezone_set('Asia/Jakarta');
$tanggal = date("Y-m-d G:i:s");
$nama_karyawan = $_POST['nama_karyawan'];
$status = $_POST['status'];
$keterangan = $_POST['keterangan'];



$nama_file = $_FILES['file']['name'];
if ($nama_file == "") {
	$file = "";
}

else if ( $nama_file != "" ) {

	function upload(){
		$nama_file = $_FILES['file']['name'];
		$ukuran_file = $_FILES['file']['size'];
		$error = $_FILES['file']['error'];
		$tmp_name = $_FILES['file']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
		$ekstensi_file = explode(".", $nama_file);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

		move_uploaded_file($tmp_name, '../file_karyawan/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}


	$query = mysqli_query($koneksi,"INSERT INTO absensi VALUES ('','$tanggal','$status','$nama_karyawan','$lokasi','$keterangan','$file')");


			if ($query != "") {
			echo "<script> window.location='../view/VAbsensi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
