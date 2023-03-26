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
$rekening = $_POST['rekening'];
$bank = $_POST['bank'];
$akun = $_POST['akun'];
$jenis_transaksi = $_POST['jenis_transaksi'];
$biaya_transfer =$_POST['biaya_transfer'];
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

		move_uploaded_file($tmp_name, '../file_kasir_pbj/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}



if ($jenis_transaksi == 'Sisa Saldo Bulan Lalu') {

	$query = mysqli_query($koneksi,"INSERT INTO riwayat_pencatatan_saldo VALUES ('','$tanggal','$rekening','$bank','$akun','Masuk','$jenis_transaksi','$biaya_transfer','$jumlah','$keterangan','$file')");

			
			if ($query != "") {
				echo "<script> window.location='../view/VPencatatanSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
}
elseif ($jenis_transaksi == 'Penambahan Saldo') {
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pencatatan_saldo VALUES ('','$tanggal','$rekening','$bank','$akun','Masuk','$jenis_transaksi','$biaya_transfer','$jumlah','$keterangan','$file')");

			
			if ($query != "") {
				echo "<script> window.location='../view/VPencatatanSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
}
elseif ($jenis_transaksi == 'Pengeluaran Saldo') {
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pencatatan_saldo VALUES ('','$tanggal','$rekening','$bank','$akun','Keluar','$jenis_transaksi','$biaya_transfer','$jumlah','$keterangan','$file')");

			
			if ($query != "") {
				echo "<script> window.location='../view/VPencatatanSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}