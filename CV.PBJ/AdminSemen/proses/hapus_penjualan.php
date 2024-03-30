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
if ($jabatan_valid == 'Admin Semen') {

}

else{  header("Location: logout.php");
exit;
}


$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_penjualan = $_POST['no_penjualan'];

$result3 = mysqli_query($koneksi, "SELECT * FROM pengiriman_sl WHERE no_penjualan = '$no_penjualan' ");
$data_perta = mysqli_fetch_array($result3);
if (isset($data_perta['no_pengiriman'])) {
	$no_pengiriman = $data_perta['no_pengiriman'];
} else {
	$no_pengiriman = "";
}



	
if ($no_pengiriman != "") {
	$query2 = mysqli_query($koneksi,"DELETE FROM pengiriman_sl WHERE no_pengiriman = '$no_pengiriman'");
}

		//Hapusriwayat keberangkatan
		$query = mysqli_query($koneksi,"DELETE FROM penjualan_sl WHERE no_penjualan = '$no_penjualan'");



	
				echo "<script> window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	