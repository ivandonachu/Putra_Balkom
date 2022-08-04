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

$no_laporan = $_POST['no_laporan'];
$no_piutang = $_POST['no_piutang'];
$tanggal_bayar = $_POST['tanggal_bayar'];
$total_bayar = $_POST['total_bayar'];
$pembayaran = $_POST['pembayaran'];

$table = mysqli_query($koneksi, "SELECT * FROM piutang_dagang a INNER JOIN riwayat_penjualan b ON a.no_transaksi=b.no_transaksi INNER JOIN baja c ON c.kode_baja=b.kode_baja WHERE a.no_transaksi = '$no_laporan' ");
$data_piutang = mysqli_fetch_array($table);

$jumlah_bon = $data_piutang['jumlah'];
$jumlah_bon_2 = $data_piutang['jumlah_bayar'];

$total_bayarx = $jumlah_bon_2 + $total_bayar;

if ($total_bayarx > $jumlah_bon ) {
	echo "<script> alert('Kembalinya Kebanyakan Gaes!'); window.location='../view/VRiwayatBonPembelian1';</script>";exit;
}

elseif ($total_bayarx < $jumlah_bon) {
	if ($pembayaran == 'Cash') {
	//aktifitas rekening
	$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111' ");
	$data_rekening = mysqli_fetch_array($akses_rekening);
	$jumlah_rekening = $data_rekening['jumlah'];
	$jumlah_rekening_new = $jumlah_rekening + $total_bayar;

	$query1 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_rekening_new' WHERE kode_akun = '1-111' ");
	$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal_bayar','$no_laporan','1','Masuk','$total_bayar')");
	//piutang_dagang
	$query3 = mysqli_query($koneksi,"UPDATE piutang_dagang SET tanggal_bayar = '$tanggal_bayar', pembayaran_piutang = '$pembayaran', jumlah_bayar = '$total_bayarx' WHERE no_piutang = '$no_piutang' ");
	echo "<script> window.location='../view/VRiwayatBonPembelian1';</script>";exit;
	}
	elseif ($pembayaran == 'Transfer') {
	//aktifitas rekening
	$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114' ");
	$data_rekening = mysqli_fetch_array($akses_rekening);
	$jumlah_rekening = $data_rekening['jumlah'];
	$jumlah_rekening_new = $jumlah_rekening + $total_bayar;

	$query1 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_rekening_new' WHERE kode_akun = '1-114' ");
	$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal_bayar','$no_laporan','4','Masuk','$total_bayar')");
	//piutang_dagang
	$query3 = mysqli_query($koneksi,"UPDATE piutang_dagang SET tanggal_bayar = '$tanggal_bayar', pembayaran_piutang = '$pembayaran' , jumlah_bayar = '$total_bayarx' WHERE no_piutang = '$no_piutang' ");
	echo "<script> window.location='../view/VRiwayatBonPembelian1';</script>";exit;
	}
	
}
elseif ($total_bayarx == $jumlah_bon) {
	$status_piutang = 'Sudah di Bayar';
	if ($pembayaran == 'Cash') {
	//aktifitas rekening
	$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111' ");
	$data_rekening = mysqli_fetch_array($akses_rekening);
	$jumlah_rekening = $data_rekening['jumlah'];
	$jumlah_rekening_new = $jumlah_rekening + $total_bayar;

	$query1 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_rekening_new' WHERE kode_akun = '1-111' ");
	$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal_bayar','$no_laporan','1','Masuk','$total_bayar')");
	//piutang_dagang
	$query3 = mysqli_query($koneksi,"UPDATE piutang_dagang SET tanggal_bayar = '$tanggal_bayar', pembayaran_piutang = '$pembayaran', jumlah_bayar = '$total_bayarx', status_piutang = '$status_piutang' WHERE no_piutang = '$no_piutang' ");
	echo "<script> window.location='../view/VRiwayatBonPembelian1';</script>";exit;
	}
	elseif ($pembayaran == 'Transfer') {
	//aktifitas rekening
	$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114' ");
	$data_rekening = mysqli_fetch_array($akses_rekening);
	$jumlah_rekening = $data_rekening['jumlah'];
	$jumlah_rekening_new = $jumlah_rekening + $total_bayar;

	$query1 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_rekening_new' WHERE kode_akun = '1-114' ");
	$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal_bayar','$no_laporan','4','Masuk','$total_bayar')");
	//piutang_dagang
	$query3 = mysqli_query($koneksi,"UPDATE piutang_dagang SET tanggal_bayar = '$tanggal_bayar', pembayaran_piutang = '$pembayaran', jumlah_bayar = '$total_bayarx', status_piutang = '$status_piutang' WHERE no_piutang = '$no_piutang' ");
	echo "<script> window.location='../view/VRiwayatBonPembelian1';</script>";exit;
	}
}
