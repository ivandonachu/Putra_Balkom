<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
	header("Location: logout.php");
	exit;
}
$id = $_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account WHERE id_karyawan = '$id'");
$data1 = mysqli_fetch_array($result1);
$id1 = $data1['id_karyawan'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Kasir Semen') {
} else {
	header("Location: logout.php");
	exit;
}

$no_pengiriman = $_POST['no_pengiriman'];
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$tanggal_antar = $_POST['tanggal_antar'];
$driver = $_POST['driver'];
$no_polisi = $_POST['no_polisi'];
$toko_do = $_POST['toko_do'];
$tipe_semen = $_POST['tipe_semen'];
$uj = $_POST['uj'];
$ug = $_POST['ug'];
$om = $_POST['om'];
$bs = $_POST['bs'];
$tanggal_gaji = $_POST['tanggal_gaji'];
$tanggal_nota = $_POST['tanggal_nota'];
$keterangan = $_POST['keterangan'];
$nama_file = $_FILES['file']['name'];
if ($nama_file == "") {
	$file = "";
} else if ($nama_file != "") {

	function upload()
	{
		$nama_file = $_FILES['file']['name'];
		$ukuran_file = $_FILES['file']['size'];
		$error = $_FILES['file']['error'];
		$tmp_name = $_FILES['file']['tmp_name'];

		$ekstensi_valid = ['jpg', 'jpeg', 'pdf', 'doc', 'docs', 'xls', 'xlsx', 'docx', 'txt', 'png'];
		$ekstensi_file = explode(".", $nama_file);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

		move_uploaded_file($tmp_name, '../file_semen/' . $nama_file_baru);

		return $nama_file_baru;
	}

	$file = upload();
	if (!$file) {
		return false;
	}
}



if ($file == '') {
	$query3 = mysqli_query($koneksi, "UPDATE pengiriman_s SET tanggal_antar = '$tanggal_antar', driver = '$driver', no_polisi = '$no_polisi', 
			toko_do = '$toko_do', tipe_semen = '$tipe_semen', uj = '$uj', ug = '$ug', om = '$om', bs = '$bs', tanggal_gaji = '$tanggal_gaji', tanggal_nota = '$tanggal_nota', keterangan = '$keterangan' , kode_input = '$id1'  WHERE no_pengiriman = '$no_pengiriman'");


} else {
	$query3 = mysqli_query($koneksi, "UPDATE pengiriman_s SET tanggal_antar = '$tanggal_antar', driver = '$driver', no_polisi = '$no_polisi',
			toko_do = '$toko_do', tipe_semen = '$tipe_semen', uj = '$uj', ug = '$ug', om = '$om', bs = '$bs', tanggal_gaji = '$tanggal_gaji', tanggal_nota = '$tanggal_nota', keterangan = '$keterangan', file_bukti = '$file' , kode_input = '$id1'  WHERE no_pengiriman = '$no_pengiriman'");

}


echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VPengiriman?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";
exit;
