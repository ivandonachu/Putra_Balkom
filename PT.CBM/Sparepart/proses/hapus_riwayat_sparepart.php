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
if ($jabatan_valid == 'Admin Sparepart') {

}

else{  header("Location: logout.php");
exit;
}


$no_laporan = $_POST['no_laporan'];
$jumlah = $_POST['jumlah'];
$stok = $_POST['stok'];
$no_sparepart = $_POST['no_sparepart'];
$aksi = $_POST['aksi'];
$tanggal = $_POST['tanggal'];

	if ($aksi == 'Pembelian' || $aksi == 'Penambahan') {
		$stok_asli_upt = $stok - $jumlah;

		$query3 = mysqli_query($koneksi,"UPDATE list_sparepart SET stok = '$stok_asli_upt' WHERE no_sparepart = '$no_sparepart'");

	}
	else{

		$stok_asli_upt = $stok + $jumlah;

		$query3 = mysqli_query($koneksi,"UPDATE list_sparepart SET stok = '$stok_asli_upt' WHERE no_sparepart = '$no_sparepart'");

	}


	$query = mysqli_query($koneksi,"DELETE FROM penggunaan_sparepart WHERE no_laporan = '$no_laporan'");

			echo "<script> window.location='../view/VRiwayatSparepart';</script>";exit;
	