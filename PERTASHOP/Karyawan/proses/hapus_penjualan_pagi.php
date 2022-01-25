<?php
session_start();
include'koneksi.php';
if(!isset($_SESSION["login"])){
	header("Location: logout.php");
	exit;
}
$id=$_COOKIE['id_cookie'];
$result = mysqli_query($koneksi, "SELECT * FROM akun_perta a INNER JOIN pertashop b on b.kode_perta = b.kode_perta WHERE id_kar_perta = '$id'");
$data = mysqli_fetch_array($result);
$nama = $data['nama'];
$lokasi = $data['lokasi'];

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_penjualan = $_POST['no_penjualan'];



	
		

		//Hapusriwayat keberangkatan
		$query = mysqli_query($koneksi,"DELETE FROM penjualan_pagi WHERE no_penjualan = '$no_penjualan'");



	
				echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VPenjualanPagi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	