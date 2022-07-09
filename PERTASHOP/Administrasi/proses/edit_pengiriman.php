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
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_pengiriman = $_POST['no_pengiriman'];
$tanggal_kirim = $_POST['tanggal_kirim'];
$lokasi = $_POST['lokasi'];
$nama_barang = $_POST['nama_barang'];
$no_so = $_POST['no_so'];
$lokasi_kirim = $_POST['lokasi_kirim'];
$qty = $_POST['qty'];
$keterangan = $_POST['keterangan'];


$result = mysqli_query($koneksi, "SELECT * FROM pertashop WHERE lokasi = '$lokasi' ");
$data_perta = mysqli_fetch_array($result);
$kode_perta = $data_perta['kode_perta'];

if($kode_perta == 'nusabakti' && $nama_barang == 'Dexlite' && $lokasi_kirim = 'BK 3'){
            
	
	
    //PERTASHOP
	$result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '7' ");
    $data_stok = mysqli_fetch_array($result2);
    $stok_awal = $data_stok['stok'];

	$result21 = mysqli_query($koneksi, "SELECT qty FROM pengiriman WHERE no_pengiriman = '$no_pengiriman' ");
	$data_pengiriman = mysqli_fetch_array($result21);
	$qty_pengiriman = $data_pengiriman['qty'];
	
	$stok_baru = (($stok_awal + $qty_pengiriman) - $qty);
	
	mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '7'");

    //Tujuan
	$result3 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '12' ");
    $data_stok3 = mysqli_fetch_array($result3);
    $stok_awal = $data_stok3['stok'];

	$result31 = mysqli_query($koneksi, "SELECT qty FROM pengiriman WHERE no_pengiriman = '$no_pengiriman' ");
	$data_pengiriman = mysqli_fetch_array($result31);
	$qty_pengiriman = $data_pengiriman['qty'];
	
	$stok_baru = (($stok_awal - $qty_pengiriman) + $qty);
	
    mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '12'");

}
else if($kode_perta == 'nusabakti' && $nama_barang == 'Dexlite' && $lokasi_kirim = 'Pul Baturaja'){
	//PERTASHOP
	$result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '7' ");
    $data_stok = mysqli_fetch_array($result2);
    $stok_awal = $data_stok['stok'];

	$result21 = mysqli_query($koneksi, "SELECT qty FROM pengiriman WHERE no_pengiriman = '$no_pengiriman' ");
	$data_pengiriman = mysqli_fetch_array($result21);
	$qty_pengiriman = $data_pengiriman['qty'];
	
	$stok_baru = (($stok_awal + $qty_pengiriman) - $qty);
	
	mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '7'");

    //Tujuan
	$result3 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '14' ");
    $data_stok3 = mysqli_fetch_array($result3);
    $stok_awal = $data_stok3['stok'];

	$result31 = mysqli_query($koneksi, "SELECT qty FROM pengiriman WHERE no_pengiriman = '$no_pengiriman' ");
	$data_pengiriman = mysqli_fetch_array($result31);
	$qty_pengiriman = $data_pengiriman['qty'];
	
	$stok_baru = (($stok_awal - $qty_pengiriman) + $qty);
	
    mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '14'");

}


 mysqli_query($koneksi,"UPDATE pengiriman SET no_so = '$no_so', tanggal_kirim = '$tanggal_kirim' , kode_perta = '$kode_perta' , nama_barang = '$nama_barang', qty = '$qty' , lokasi_kirim = '$lokasi_kirim' ,keterangan = '$keterangan'  WHERE no_pengiriman = '$no_pengiriman'");
	



		echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VPengiriman?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi';</script>";exit;
