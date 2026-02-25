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
if ($jabatan_valid == 'Administrasi') {

}

else{  header("Location: logout.php");
exit;
}

$nama_barang = $_POST['nama_barang'];
$tanggal = $_POST['tanggal'];
$lokasi = $_POST['lokasi'];
$qty = $_POST['qty'];
$harga = $_POST['harga'];
$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];

$result = mysqli_query($koneksi, "SELECT * FROM pertashop WHERE lokasi = '$lokasi' ");
$data_perta = mysqli_fetch_array($result);
$kode_perta = $data_perta['kode_perta'];
	

    
            	$query = mysqli_query($koneksi,"INSERT INTO penjualan_pagi VALUES ('','$tanggal','$kode_perta','$nama_barang','$qty','$harga')");
        
                	if ($query != "") {
				echo "<script> window.location='../view/VPenjualanPagi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
    