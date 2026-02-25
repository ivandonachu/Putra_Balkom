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
$no_penjualan = $_POST['no_penjualan'];
$lokasi = $_POST['lokasi'];
$qty = $_POST['qty'];
$harga = $_POST['harga'];
$nama_barang = $_POST['nama_barang'];
$stok_awal = $_POST['stok_awal'];
$stok_akhir = $_POST['stok_akhir'];
$sonding_awal = $_POST['sonding_awal'];
$sonding_akhir = $_POST['sonding_akhir'];
$sirkulasi = $_POST['sirkulasi'];
$uang_diskon = $_POST['uang_diskon'];
$bongkaran = $_POST['bongkaran'];
$losis_penyimpanan = $_POST['losis_penyimpanan'];
$losis_penjualan = $_POST['losis_penjualan'];
$keterangan = $_POST['keterangan'];


$result = mysqli_query($koneksi, "SELECT * FROM pertashop WHERE lokasi = '$lokasi' ");
$data_perta = mysqli_fetch_array($result);
$kode_perta = $data_perta['kode_perta'];

			
			
        if( $nama_barang == 'Pertamax'){

			
				$query3 = mysqli_query($koneksi,"UPDATE penjualan SET qty = '$qty', harga = '$harga', uang_diskon = '$uang_diskon' , stok_awal = '$stok_awal' , stok_akhir = '$stok_akhir' , bongkaran = '$bongkaran' , sonding_awal = '$sonding_awal'
																		, sonding_akhir = '$sonding_akhir' , sirkulasi = '$sirkulasi', losis_penyimpanan = '$losis_penyimpanan', losis_penjualan = '$losis_penjualan' ,keterangan = '$keterangan'  WHERE no_penjualan = 
				'$no_penjualan'");

		
         
			echo "<script> window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi';</script>";exit;
			
        }
		else{
	
				$query3 = mysqli_query($koneksi,"UPDATE penjualan SET qty = '$qty', harga = '$harga', uang_diskon = '$uang_diskon' , stok_awal = '$stok_awal' , stok_akhir = '$stok_akhir' , bongkaran = '$bongkaran' , sonding_awal = '$sonding_awal'
																		, sonding_akhir = '$sonding_akhir' , sirkulasi = '$sirkulasi', losis_penyimpanan = '$losis_penyimpanan', losis_penjualan = '$losis_penjualan' ,keterangan = '$keterangan'  WHERE no_penjualan = 
				'$no_penjualan'");

			
		
         
			echo "<script> window.location='../view/VPenjualanDex?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi';</script>";exit;
			
		}
       