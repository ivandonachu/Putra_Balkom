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


$no_riwayat = $_POST['no_riwayat'];
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];

$tablex = mysqli_query($koneksi, "SELECT * FROM riwayat_pembayaran_piutang WHERE no_riwayat = '$no_riwayat' ");
$data_riw_piutang = mysqli_fetch_array($tablex);

$no_piutang = $data_riw_piutang['no_piutang'];
$qty_bayar = $data_riw_piutang['qty_bayar_x'];
$total_bayar = $data_riw_piutang['jumlah_bayar_x'];


$table = mysqli_query($koneksi, "SELECT * FROM piutang_penjualan WHERE no_piutang = '$no_piutang' ");
$data_piutang = mysqli_fetch_array($table);

$total_qty_baja = $data_piutang['total_qty_baja'];
$total_piutang = $data_piutang['total_piutang'];

$total_qty_baja_baru = $total_qty_baja + $qty_bayar;
$total_piutang_baru = $total_piutang + $total_bayar;



	//riwayat_pembayaranpiutang
	mysqli_query($koneksi,"DELETE FROM riwayat_pembayaran_piutang WHERE no_riwayat = '$no_riwayat'");
    $queryx = mysqli_query($koneksi, "SELECT * FROM riwayat_pembayaran_piutang ORDER BY no_riwayat DESC LIMIT 1");
    $data_x = mysqli_fetch_array($queryx);
    $tanggal_bayar = $data_x['tanggal_bayar_x'];
	//piutang_dagang
	mysqli_query($koneksi,"UPDATE piutang_penjualan SET tanggal = '$tanggal_bayar', total_qty_baja = '$total_qty_baja_baru', total_piutang = '$total_piutang_baru' WHERE no_piutang = '$no_piutang' ");

	echo "<script> window.location='../view/VRiwayatBonPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

