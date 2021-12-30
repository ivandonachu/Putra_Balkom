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
if ($jabatan_valid == 'Admin Kebun') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal_muat = $_POST['tanggal_muat'];
$tanggal_timbang = $_POST['tanggal_timbang'];
$nama_driver = $_POST['nama_driver'];
$no_polisi = $_POST['no_polisi'];
$gross = $_POST['gross'];
$tare = $_POST['tare'];
$deduction = $_POST['deduction'];
$sortasi = $_POST['sortasi'];
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

		move_uploaded_file($tmp_name, '../file_kebun/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}


	$query = mysqli_query($koneksi,"INSERT INTO laporan_sawit VALUES('','$tanggal_muat','$nama_driver','$no_polisi','$gross','$tare','$deduction','$sortasi','$tanggal_timbang','$keterangan','$file')");

			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VLSawit?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

  ?>