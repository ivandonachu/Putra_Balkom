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

$no_bon = $_POST['no_bon'];
$tanggal = $_POST['tanggal'];
$jumlah_bon = $_POST['jumlah_bon'];
$jumlah_bayar = $_POST['jumlah_bon'];
$total_bayar = $jumlah_bayar;
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

		move_uploaded_file($tmp_name, '../file_toko/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}
	

	$status_bayar = 'Lunas';
	if ($file == '') {
		$query3 = mysqli_query($koneksi,"UPDATE bon_karyawan SET tanggal_bayar = '$tanggal' , jumlah_bayar = '$total_bayar' , status_bayar = '$status_bayar'  WHERE no_bon = 
		'$no_bon'");
	}
	else{
		$query3 = mysqli_query($koneksi,"UPDATE bon_karyawan SET tanggal_bayar = '$tanggal' , jumlah_bayar = '$total_bayar' , status_bayar = '$status_bayar' , file_bukti = '$file' WHERE no_bon = 
		'$no_bon'");
	}
	echo "<script> alert('Pembayaran Berhasil!'); window.location='../view/VBonKaryawan';</script>";exit;

	
