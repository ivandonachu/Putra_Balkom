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
$tanggal = $_POST['tanggal'];
$akun = $_POST['akun'];
$jumlah = $_POST['jumlah'];
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

		move_uploaded_file($tmp_name, '../file_staff_admin/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}



if ($akun == 'Saldo Awal' || $akun == 'Tambahan Saldo') {
	$query = mysqli_query($koneksi,"INSERT INTO riwayat_kas_kecil VALUES ('','$tanggal','$akun','Masuk','$jumlah','$keterangan','$file')");

			//rekening
			$akses_saldo1 = mysqli_query($koneksi, "SELECT * FROM rekening WHERE nama_rekening = 'Kas Kecil'");
			$data_saldo1 = mysqli_fetch_array($akses_saldo1);
			$jumlah_rekening1 = $data_saldo1['jumlah'];
			$jumlah_rekening1_new = $jumlah_rekening1 + $jumlah;

			$query1= mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_rekening1_new' WHERE nama_rekening = 'Kas Kecil' ");

			if ($query != "") {
				echo "<script> window.location='../view/VKasKecil2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
}
else {
	$query = mysqli_query($koneksi,"INSERT INTO riwayat_kas_kecil VALUES ('','$tanggal','$akun','Keluar','$jumlah','$keterangan','$file')");

			//rekening
			$akses_saldo1 = mysqli_query($koneksi, "SELECT * FROM rekening WHERE nama_rekening = 'Kas Kecil'");
			$data_saldo1 = mysqli_fetch_array($akses_saldo1);
			$jumlah_rekening1 = $data_saldo1['jumlah'];
			$jumlah_rekening1_new = $jumlah_rekening1 - $jumlah;

			$query1= mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_rekening1_new' WHERE nama_rekening = 'Kas Kecil' ");

			if ($query != "") {
				echo "<script> window.location='../view/VKasKecil2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
}