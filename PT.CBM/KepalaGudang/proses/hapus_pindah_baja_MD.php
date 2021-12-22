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
if ($jabatan_valid == 'Kepala Gudang') {

}

else{  header("Location: logout.php");
exit;
}

$no_pindah = $_POST['no_pindah'];
$qty = $_POST['qty'];
$status_barang = $_POST['status_barang'];
$referensi = $_POST['referensi'];
$nama_baja = $_POST['nama_baja'];

$result = mysqli_query($koneksi, "SELECT * FROM baja WHERE nama_baja = '$nama_baja' ");
$data_baja = mysqli_fetch_array($result);
$kode_baja = $data_baja['kode_baja'];


if ($status_barang == 'Masuk') {
	if ($referensi == 'TK') {
		if ($kode_baja == 'L03K11') {
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['toko'];
			$jumlah_baja_toko2 = $jumlah_baja_b - $qty;	

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko2' WHERE kode_baja = 'L03K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
			
		}
		elseif($kode_baja == 'L03K10'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'L12K11'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['toko'];
			$jumlah_baja_toko2 = $jumlah_baja_b - $qty;	

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko2' WHERE kode_baja = 'L12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'L12K10'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'B05K11'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['toko'];
			$jumlah_baja_toko2 = $jumlah_baja_b - $qty;	

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko2' WHERE kode_baja = 'B05K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'B05K10'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'B12K11'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['toko'];
			$jumlah_baja_toko2 = $jumlah_baja_b - $qty;	

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko2' WHERE kode_baja = 'B12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'B12K10'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
	}

	elseif ($referensi == 'GD') {
		if ($kode_baja == 'L03K11') {
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['gudang'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_toko2 = $jumlah_baja_b - $qty;	

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko2' WHERE kode_baja = 'L03K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'L03K10'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['gudang'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'L12K11'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['gudang'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_toko2 = $jumlah_baja_b - $qty;	

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko2' WHERE kode_baja = 'L12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'L12K10'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['gudang'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'B05K11'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['gudang'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_toko2 = $jumlah_baja_b - $qty;	

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko2' WHERE kode_baja = 'B05K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'B05K10'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['gudang'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'B12K11'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['gudang'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_toko2 = $jumlah_baja_b - $qty;	

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko2' WHERE kode_baja = 'B12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'B12K10'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['gudang'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
	}

}


if ($status_barang == 'Keluar') {
	if ($referensi == 'TK') {
		if ($kode_baja == 'L03K11') {
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['toko'];
			$jumlah_baja_toko2 = $jumlah_baja_b + $qty;	

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko2' WHERE kode_baja = 'L03K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'L03K10'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'L12K11'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['toko'];
			$jumlah_baja_toko2 = $jumlah_baja_b + $qty;	

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko2' WHERE kode_baja = 'L12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'L12K10'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'B05K11'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['toko'];
			$jumlah_baja_toko2 = $jumlah_baja_b + $qty;	

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko2' WHERE kode_baja = 'B05K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'B05K10'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'B12K11'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['toko'];
			$jumlah_baja_toko2 = $jumlah_baja_b + $qty;	

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko2' WHERE kode_baja = 'B12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'B12K10'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
	}

	elseif ($referensi == 'GD') {
		if ($kode_baja == 'L03K11') {
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['gudang'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_toko2 = $jumlah_baja_b + $qty;	

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko2' WHERE kode_baja = 'L03K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'L03K10'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['gudang'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'L12K11'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['gudang'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_toko2 = $jumlah_baja_b + $qty;	

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko2' WHERE kode_baja = 'L12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'L12K10'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['gudang'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'B05K11'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['gudang'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_toko2 = $jumlah_baja_b + $qty;	

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko2' WHERE kode_baja = 'B05K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'B05K10'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['gudang'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'B12K11'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['gudang'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_toko2 = $jumlah_baja_b + $qty;	

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko2' WHERE kode_baja = 'B12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
		elseif($kode_baja == 'B12K10'){
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['gudang'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_baja_md WHERE no_perpindahan = '$no_pindah'");
			
				echo "<script> window.location='../view/VPindahBajaMD';</script>";exit;
		}
	}

}

