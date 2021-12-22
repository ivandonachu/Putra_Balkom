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

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = $_POST['tanggal'];
$nama_driver = $_POST['nama_driver'];
$no_polisi = $_POST['no_polisi'];
$posisi_bongkar = $_POST['posisi_bongkar'];
$uang_tambahan = $_POST['uang_tambahan'];
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

		move_uploaded_file($tmp_name, '../file_toko/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}
	
		$result = mysqli_query($koneksi, "SELECT * FROM rute_driver WHERE posisi_bongkar = '$posisi_bongkar' ");
		$data_rute = mysqli_fetch_array($result);
		$jumlah = $data_rute['jumlah'];
		$tambahan = $data_rute['tambahan'];
		$tujuan_berangkat = $data_rute['tujuan_berangkat'];

		$total_UJ = $jumlah + $tambahan + $uang_tambahan;

		$result2 = mysqli_query($koneksi, "SELECT * FROM driver WHERE nama_driver = '$nama_driver' ");
		$data_driver = mysqli_fetch_array($result2);
		$id_driver = $data_driver['id_driver'];

		//input riwayat keberangkatan
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_keberangkatan VALUES ('','$tanggal','$id_driver','$no_polisi','$posisi_bongkar','$tujuan_berangkat','$total_UJ',1,'$keterangan','$file')");

		//rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $total_UJ;
		$query1 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
				echo "<script> window.location='../view/VKeberangkatan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}