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
if ($jabatan_valid == 'Staff HRD') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_bekerja = $_POST['tanggal_bekerja'];
$nama_karyawan = $_POST['nama_karyawan'];

$jenis_kontrak = $_POST['jenis_kontrak'];
$result2 = mysqli_query($koneksi, "SELECT * FROM seluruh_karyawan WHERE nama_karyawan = '$nama_karyawan' ");
$data_karyawan = mysqli_fetch_array($result2);
$nik = $data_karyawan['nik'];


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

		move_uploaded_file($tmp_name, '../../StaffAdmin/file_staff_admin/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}

	$query = mysqli_query($koneksi,"INSERT INTO kontrak_kerja VALUES ('','$jenis_kontrak','$nik','$tanggal_bekerja','$file')");


			if ($query != "") {
				echo "<script> window.location='../view/VKontrakKerja';</script>";exit;
			}