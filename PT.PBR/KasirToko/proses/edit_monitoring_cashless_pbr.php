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

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_transaksi = $_POST['no_transaksi'];
$tanggal = $_POST['tanggal'];
$nama_pangkalan = $_POST['nama_pangkalan'];
$qty = $_POST['qty'];
$harga_satuan = $_POST['harga_satuan'];
$jumlah = $qty * $harga_satuan;
$briva = $_POST['briva'];
$transaksi_transfer = $_POST['transaksi_transfer'];
$status_valid = $_POST['status_valid'];
$referensi = $_POST['referensi'];
$status_verified = $_POST['status_verified'];
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
	if ($file == '') {
		$query3 = mysqli_query($koneksi,"UPDATE monitoring_cashless_pbr SET tanggal = '$tanggal' , nama_pangkalan = '$nama_pangkalan' , qty = '$qty' , harga_satuan = '$harga_satuan', jumlah = '$jumlah' , briva = '$briva', transaksi_transfer = '$transaksi_transfer', status_valid = '$status_valid', referensi = '$referensi', status_verified = '$status_verified', keterangan = '$keterangan' WHERE no_transaksi = '$no_transaksi'");
  
	}
	else{
		$query3 = mysqli_query($koneksi,"UPDATE monitoring_cashless_pbr SET tanggal = '$tanggal' , nama_pangkalan = '$nama_pangkalan' , qty = '$qty' , harga_satuan = '$harga_satuan', jumlah = '$jumlah' , briva = '$briva', transaksi_transfer = '$transaksi_transfer', status_valid = '$status_valid', referensi = '$referensi', status_verified = '$status_verified', keterangan = '$keterangan', file_bukti = '$file' WHERE no_transaksi = '$no_transaksi'");
	}

			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VMonitoringCashlessPBR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;



  ?>