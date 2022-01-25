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
$nama_barang = $_POST['nama_barang'];
$tanggal = $_POST['tanggal'];
$lokasi = $_POST['lokasi'];
$qty = $_POST['qty'];
$harga = $_POST['harga'];
$nama_karyawan = $_POST['nama_karyawan'];

$result = mysqli_query($koneksi, "SELECT * FROM pertashop WHERE lokasi = '$lokasi' ");
$data_perta = mysqli_fetch_array($result);
$kode_perta = $data_perta['kode_perta'];
	

    
            	$query = mysqli_query($koneksi,"INSERT INTO penjualan_pagi VALUES ('','$tanggal','$kode_perta','$nama_karyawan','$nama_barang','$qty','$harga')");
        
                	if ($query != "") {
				echo "<script> window.location='../view/VPenjualanPagi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
    