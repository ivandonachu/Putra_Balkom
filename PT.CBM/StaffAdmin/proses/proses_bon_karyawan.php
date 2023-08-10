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
if ($jabatan_valid == 'Staff Admin') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$nama = $_POST['nama'];
$tanggal = $_POST['tanggal'];
$jumlah = $_POST['jumlah'];
$keterangan = $_POST['keterangan'];
$pembayaran = $_POST['pembayaran'];
$nama_file = $_FILES['file']['name'];
$kode_akun = '5-510';
$status_bon = 'Belum Bayar';
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

		move_uploaded_file($tmp_name, '../file_staff_admin/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}
	
		$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE nama_karyawan = '$nama' ");
		$data_karyawan = mysqli_fetch_array($result);
		$id_karyawan = $data_karyawan['id_karyawan'];
		$nama_karyawan = $data_karyawan['nama_karyawan'];


if ($pembayaran == 'Cash') {
	//riwayat pengeluran
	$query = mysqli_query($koneksi,"INSERT INTO bon_karyawan VALUES ('','$tanggal',0000-00-00,'$kode_akun','$id_karyawan','$nama_karyawan','$jumlah',0,'$status_bon','$keterangan','$file')");
	//aktivitas rekening
	$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
	$data_rekening = mysqli_fetch_array($akses_rekening);
	$jumlah_uang = $data_rekening['jumlah'];
	$jumlah_uang_new = $jumlah_uang - $jumlah;
	$query1 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

	if ($query != "") {
				echo "<script> window.location='../view/VBonKaryawan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
}
elseif ($pembayaran == 'Transfer') {
	
}
