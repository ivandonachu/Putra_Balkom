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
if ($jabatan_valid == 'Manager') {

}

else{  header("Location: logout.php");
exit;
}


$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_pembelian = $_POST['no_pembelian'];
$nama_baja = $_POST['nama_baja'];
$pembayaran = $_POST['pembayaran'];
$qty = $_POST['qty'];
$jumlah = $_POST['jumlah'];
$referensi = $_POST['referensi'];

$result = mysqli_query($koneksi, "SELECT * FROM baja WHERE nama_baja = '$nama_baja' ");
$data_baja = mysqli_fetch_array($result);
$kode_baja = $data_baja['kode_baja'];


if ($referensi == 'CBM') {
	
if($pembayaran == 'Bank BRI Toko') {

	if ($kode_baja == 'L03K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
	
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}

	}
	elseif ($kode_baja == 'B05K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}

}

//pembayaran BRI CBM
elseif ($pembayaran == 'Bank BRI CBM') {
		if ($kode_baja == 'L03K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}

	}
	elseif ($kode_baja == 'B05K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
	

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}

}

//pembayaran Mandiri
elseif ($pembayaran == 'Bank Mandiri') {
		if ($kode_baja == 'L03K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}

	}
	elseif ($kode_baja == 'B05K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}

}

//pembayaran kas armada
elseif ($pembayaran == 'Kas Armada') {
	
		if ($kode_baja == 'L03K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}

	}
	elseif ($kode_baja == 'B05K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}

}

//pembayaran kas ditangan
elseif ($pembayaran == 'Kas di Tangan') {
		if ($kode_baja == 'L03K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
	

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}

	}
	elseif ($kode_baja == 'B05K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}

}

}

//pbr messssws
else{

if($pembayaran == 'Bank BRI MES') {

	if ($kode_baja == 'L03K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
	
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}

	}
	elseif ($kode_baja == 'B05K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}

}

//pembayaran BRI CBM
elseif ($pembayaran == 'Bank BRI PBR') {
		if ($kode_baja == 'L03K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
			$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}

	}
	elseif ($kode_baja == 'B05K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
	

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}

}

//pembayaran Mandiri
elseif ($pembayaran == 'Bank Mandiri') {
		if ($kode_baja == 'L03K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}

	}
	elseif ($kode_baja == 'B05K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}

}

//pembayaran kas armada
elseif ($pembayaran == 'Kas Armada') {
	
		if ($kode_baja == 'L03K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}

	}
	elseif ($kode_baja == 'B05K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}

}

//pembayaran kas ditangan
elseif ($pembayaran == 'Kas di Tangan') {
		if ($kode_baja == 'L03K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
	

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}

	}
	elseif ($kode_baja == 'B05K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"DELETE FROM riwayat_pembelian WHERE no_pembelian = '$no_pembelian' ");
		//aktivitas inventory
		//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}

}

}

