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


$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$referensi = $_POST['referensi'];
$tanggal = $_POST['tanggal'];
$qty = $_POST['qty'];
$harga = $_POST['harga'];
$jumlah = $_POST['jumlah'];
$keterangan = $_POST['keterangan'];
$nama_baja = $_POST['nama_baja'];
$pembayaran = $_POST['pembayaran'];
$nama_file = $_FILES['file']['name'];
$qty_keluar = 0;
if ($nama_file == "") {
	$file = "";
}

else if ( $nama_file != "" ) {

	function upload(){
		$nama_file = $_FILES['file']['name'];
		$ukuran_file = $_FILES['file']['size'];
		$error = $_FILES['file']['error'];
		$tmp_name = $_FILES['file']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
		$ekstensi_file = explode(".", $nama_file);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

		move_uploaded_file($tmp_name, '../file_manager/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}

$result = mysqli_query($koneksi, "SELECT * FROM baja WHERE nama_baja = '$nama_baja' ");
$data_baja = mysqli_fetch_array($result);
$kode_baja = $data_baja['kode_baja'];

if ($referensi == 'CBM') {
	if($pembayaran == 'Bank BRI Toko') {

	if ($kode_baja == 'L03K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
	

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");


			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

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
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");


			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

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
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");


			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-117' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-117'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

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
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$harga','$qty_keluar','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");


			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

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
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");


			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}

}

}

//pbr mes

elseif($referensi == 'MES'){

	if($pembayaran == 'Bank BRI MES' || $pembayaran = 'Bank Mandiri') {

	if ($kode_baja == 'L03K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
	

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");


			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}



}


}


elseif($referensi == 'PBR'){

	if($pembayaran == 'Bank BRI PBR'  || $pembayaran = 'Bank Mandiri') {

	if ($kode_baja == 'L03K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L03K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
	

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");


			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'L12K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B05K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K01') {
		//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-110','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
		

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K11') {
			//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-120','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja isi
		$akses_inventory_b = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	elseif ($kode_baja == 'B12K10') {
			//pencatatan pembelian
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pembelian VALUES ('','$tanggal','$referensi','5-130','$kode_baja','$pembayaran','$qty','$qty_keluar','$harga','$jumlah','$keterangan','$file')");
			//aktivitas inventory
			//baja dibeli 
		$akses_inventory_isi = mysqli_query($koneksipbr, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


		$query1 = mysqli_query($koneksipbr,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query6 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}



}


}

    	echo "<script>alert('referensi dan pembayaran harus sesuai !');window.location='../view/VPembelian2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;



