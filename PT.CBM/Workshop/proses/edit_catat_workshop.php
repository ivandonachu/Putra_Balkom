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
if ($jabatan_valid == 'Admin Workshop') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_laporan = $_POST['no_laporan'];
$tanggal = $_POST['tanggal'];
$nama_driver = $_POST['nama_driver'];
$no_polisi = $_POST['no_polisi'];
$jumlah_bengkel = $_POST['jumlah_bengkel'];
$jumlah_sparepart = $_POST['jumlah_sparepart'];

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

		move_uploaded_file($tmp_name, '../gambar/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}	

	if ($file == '') {
		$query3 = mysqli_query($koneksi,"UPDATE riwayat_pengeluaran_workshop SET tanggal = '$tanggal' , nama_driver = '$nama_driver' , no_polisi = '$no_polisi' , jumlah_bengkel = '$jumlah_bengkel' , jumlah_sparepart = '$jumlah_sparepart' WHERE no_laporan = '$no_laporan'");
	}
	else{
		$query3 = mysqli_query($koneksi,"UPDATE riwayat_pengeluaran_workshop SET tanggal = '$tanggal' , nama_driver = '$nama_driver' , no_polisi = '$no_polisi' , jumlah_bengkel = '$jumlah_bengkel' , jumlah_sparepart = '$jumlah_sparepart', file_bukti = '$file'   WHERE no_laporan = '$no_laporan'");
	}
	


		echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VPengeluaranWorkshop?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;



  ?>