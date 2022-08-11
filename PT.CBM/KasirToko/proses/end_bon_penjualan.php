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


$no_piutang = $_POST['no_piutang'];
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$tanggal_bayar = $_POST['tanggal_bayar'];
$qty_bayar = $_POST['qty_bayar'];
$harga = $_POST['harga'];
$total_bayar = $_POST['total_bayar'];
$pembayaran = $_POST['pembayaran'];
$keterangan = $_POST['keterangan'];

$table = mysqli_query($koneksi, "SELECT * FROM piutang_penjualan WHERE no_piutang = '$no_piutang' ");
$data_piutang = mysqli_fetch_array($table);

$total_qty_baja = $data_piutang['total_qty_baja'];
$total_piutang = $data_piutang['total_piutang'];

$total_qty_baja_baru = $total_qty_baja - $qty_bayar;
$total_piutang_baru = $total_piutang - $total_bayar;

if ($total_qty_baja_baru < 0 ) {
	echo "<script> alert('Kembalinya Kebanyakan Gaes!'); window.location='../view/VRiwayatBonPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
}

elseif ($total_qty_baja_baru > 0 ) {

	//riwayat_pembayaranpiutang
	mysqli_query($koneksi,"INSERT INTO riwayat_pembayaran_piutang VALUES ('','$no_piutang','$pembayaran','$tanggal_bayar','$qty_bayar','$harga','$total_bayar','$keterangan')");
	//piutang_dagang
	mysqli_query($koneksi,"UPDATE piutang_penjualan SET tanggal = '$tanggal_bayar', total_qty_baja = '$total_qty_baja_baru', total_piutang = '$total_piutang_baru' WHERE no_piutang = '$no_piutang' ");

	echo "<script> window.location='../view/VRiwayatBonPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

	}
	
	
elseif ($total_qty_baja_baru == 0 ) {
	$status_piutang = 'Sudah di Bayar';

		//riwayat_pembayaranpiutang
		mysqli_query($koneksi,"INSERT INTO riwayat_pembayaran_piutang VALUES ('','$no_piutang','$pembayaran','$tanggal_bayar','$qty_bayar','$harga','$total_bayar','$keterangan')");
		//piutang_dagang
		mysqli_query($koneksi,"UPDATE piutang_penjualan SET tanggal = '$tanggal_bayar', total_qty_baja = '$total_qty_baja_baru', total_piutang = '$total_piutang_baru', status_piutang = '$status_piutang' WHERE no_piutang = '$no_piutang' ");
	
		echo "<script> window.location='../view/VRiwayatBonPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
}
