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

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = $_POST['tanggal'];
$tanggal_awal_jual = $_POST['tanggal_awal_jual'];
$tanggal_akhir_jual = $_POST['tanggal_akhir_jual'];
$penyetor = $_POST['penyetor'];
$jumlah = $_POST['jumlah'];
$nama_barang = $_POST['nama_barang'];
$lokasi = $_POST['lokasi'];
$no_rekening = $_POST['no_rekening'];
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

		move_uploaded_file($tmp_name, '../file_administrasi/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}

$result = mysqli_query($koneksi, "SELECT * FROM pertashop WHERE lokasi = '$lokasi' ");
$data_perta = mysqli_fetch_array($result);
$kode_perta = $data_perta['kode_perta'];


	$query = mysqli_query($koneksi,"INSERT INTO setoran VALUES ('','$kode_perta','$tanggal','$tanggal_awal_jual','$tanggal_akhir_jual','$penyetor','$nama_barang','$jumlah','$no_rekening','$file')");


			if ($query != "") {
				echo "<script> window.location='../view/VSetoran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi';</script>";exit;
			}
