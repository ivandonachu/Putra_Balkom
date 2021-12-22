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

$tanggal = $_POST['tanggal'];
$lokasi_awal = $_POST['lokasi_awal'];
$lokasi_tujuan = $_POST['lokasi_tujuan'];
$keterangan = $_POST['keterangan'];
$L03K11 = $_POST['L03K11'];
$L03K10 = $_POST['L03K10'];
$L03K00 = $_POST['L03K00'];
$L12K11 = $_POST['L12K11'];
$L12K10 = $_POST['L12K10'];
$L12K00 = $_POST['L12K00'];
$B05K11 = $_POST['B05K11'];
$B05K10 = $_POST['B05K10'];
$B05K00 = $_POST['B05K00'];
$B12K11 = $_POST['B12K11'];
$B12K10 = $_POST['B12K10'];
$B12K00 = $_POST['B12K00'];
		
if ($lokasi_awal == $lokasi_tujuan) {
	echo "<script> alert('Lokasi Awal dan Lokasi Tujuan tidak bisa sama'); window.location='../view/VPerpindahanBaja1';</script>";exit;
}
elseif ($lokasi_tujuan == $lokasi_awal) {
	echo "<script> alert('Lokasi Awal dan Lokasi Tujuan tidak bisa sama'); window.location='../view/VPerpindahanBaja1';</script>";exit;
}
if ($lokasi_awal == 'Gudang') {
	if ($lokasi_tujuan =='Mobil') {
		//riwayat pengeluran
		
			if ($L03K11 > 0) {
				
			$akses_gudang_L03K11 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
			$data_gudang_L03K11 = mysqli_fetch_array($akses_gudang_L03K11);
			$jumlah_gudang_L03K11 = $data_gudang_L03K11['gudang'];
			$jumlah_gudang_L03K11_new = $jumlah_gudang_L03K11 - $L03K11;

			
			$akses_ken_L03K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
			$data_ken_L03K10 = mysqli_fetch_array($akses_ken_L03K10);
			$jumlah_ken_L03K10 = $data_ken_L03K10['kendaraan'];
			$jumlah_ken_L03K10_new = $jumlah_ken_L03K10 + $L03K11;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_L03K11_new' WHERE kode_baja = 'L03K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_L03K11_new' WHERE kode_baja = 'L03K01' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_L03K10_new' WHERE kode_baja = 'L03K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','L03K11','$L03K11','$lokasi_awal','$lokasi_tujuan','$keterangan')");

			}
			
			if ($L03K10 > 0) {
				
			$akses_gudang_L03K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
			$data_gudang_L03K10 = mysqli_fetch_array($akses_gudang_L03K10);
			$jumlah_gudang_L03K10 = $data_gudang_L03K10['gudang'];
			$jumlah_gudang_L03K10_new = $jumlah_gudang_L03K10 - $L03K10;

			
			$akses_ken_L03K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
			$data_ken_L03K10 = mysqli_fetch_array($akses_ken_L03K10);
			$jumlah_ken_L03K10 = $data_ken_L03K10['kendaraan'];
			$jumlah_ken_L03K10_new = $jumlah_ken_L03K10 + $L03K10;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_L03K10_new' WHERE kode_baja = 'L03K10' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_L03K10_new' WHERE kode_baja = 'L03K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','L03K10','$L03K10','$lokasi_awal','$lokasi_tujuan','$keterangan')");
			}

			if ($L03K00 > 0) {
			
			$akses_gudang_L03K00 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K00'");
			$data_gudang_L03K00 = mysqli_fetch_array($akses_gudang_L03K00);
			$jumlah_gudang_L03K00 = $data_gudang_L03K00['gudang'];
			$jumlah_gudang_L03K00_new = $jumlah_gudang_L03K00 - $L03K00;

			
			$akses_ken_L03K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
			$data_ken_L03K10 = mysqli_fetch_array($akses_ken_L03K10);
			$jumlah_ken_L03K10 = $data_ken_L03K10['kendaraan'];
			$jumlah_ken_L03K10_new = $jumlah_ken_L03K10 + $L03K00;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_L03K00_new' WHERE kode_baja = 'L03K00' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_L03K10_new' WHERE kode_baja = 'L03K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','L03K00','$L03K00','$lokasi_awal','$lokasi_tujuan','$keterangan')");
			}
			
			

			//GAS LPG 12
			if ($L12K11 > 0) {
				
			$akses_gudang_L12K11 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
			$data_gudang_L12K11 = mysqli_fetch_array($akses_gudang_L12K11);
			$jumlah_gudang_L12K11 = $data_gudang_L12K11['gudang'];
			$jumlah_gudang_L12K11_new = $jumlah_gudang_L12K11 - $L12K11;

			
			$akses_ken_L12K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
			$data_ken_L12K10 = mysqli_fetch_array($akses_ken_L12K10);
			$jumlah_ken_L12K10 = $data_ken_L12K10['kendaraan'];
			$jumlah_ken_L12K10_new = $jumlah_ken_L12K10 + $L12K11;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_L12K11_new' WHERE kode_baja = 'L12K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_L12K11_new' WHERE kode_baja = 'L12K01' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_L12K10_new' WHERE kode_baja = 'L12K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','L12K11','$L12K11','$lokasi_awal','$lokasi_tujuan','$keterangan')");

			}
			
			if ($L12K10 > 0) {
				
			$akses_gudang_L12K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
			$data_gudang_L12K10 = mysqli_fetch_array($akses_gudang_L12K10);
			$jumlah_gudang_L12K10 = $data_gudang_L12K10['gudang'];
			$jumlah_gudang_L12K10_new = $jumlah_gudang_L12K10 - $L12K10;

			
			$akses_ken_L12K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
			$data_ken_L12K10 = mysqli_fetch_array($akses_ken_L12K10);
			$jumlah_ken_L12K10 = $data_ken_L12K10['kendaraan'];
			$jumlah_ken_L12K10_new = $jumlah_ken_L12K10 + $L12K10;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_L12K10_new' WHERE kode_baja = 'L12K10' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_L12K10_new' WHERE kode_baja = 'L12K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','L12K10','$L12K10','$lokasi_awal','$lokasi_tujuan','$keterangan')");
			}

			if ($L12K00 > 0) {
			
			$akses_gudang_L12K00 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K00'");
			$data_gudang_L12K00 = mysqli_fetch_array($akses_gudang_L12K00);
			$jumlah_gudang_L12K00 = $data_gudang_L12K00['gudang'];
			$jumlah_gudang_L12K00_new = $jumlah_gudang_L12K00 - $L12K00;

			
			$akses_ken_L12K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
			$data_ken_L12K10 = mysqli_fetch_array($akses_ken_L12K10);
			$jumlah_ken_L12K10 = $data_ken_L12K10['kendaraan'];
			$jumlah_ken_L12K10_new = $jumlah_ken_L12K10 + $L12K00;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_L12K00_new' WHERE kode_baja = 'L12K00' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_L12K10_new' WHERE kode_baja = 'L12K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','L12K00','$L12K00','$lokasi_awal','$lokasi_tujuan','$keterangan')");
			}

			//GAS Bright Gas 5,5
			if ($B05K11 > 0) {
				
			$akses_gudang_B05K11 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
			$data_gudang_B05K11 = mysqli_fetch_array($akses_gudang_B05K11);
			$jumlah_gudang_B05K11 = $data_gudang_B05K11['gudang'];
			$jumlah_gudang_B05K11_new = $jumlah_gudang_B05K11 - $B05K11;

			
			$akses_ken_B05K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
			$data_ken_B05K10 = mysqli_fetch_array($akses_ken_B05K10);
			$jumlah_ken_B05K10 = $data_ken_B05K10['kendaraan'];
			$jumlah_ken_B05K10_new = $jumlah_ken_B05K10 + $B05K11;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_B05K11_new' WHERE kode_baja = 'B05K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_B05K11_new' WHERE kode_baja = 'B05K01' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_B05K10_new' WHERE kode_baja = 'B05K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','B05K11','$B05K11','$lokasi_awal','$lokasi_tujuan','$keterangan')");

			}
			
			if ($B05K10 > 0) {
				
			$akses_gudang_B05K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
			$data_gudang_B05K10 = mysqli_fetch_array($akses_gudang_B05K10);
			$jumlah_gudang_B05K10 = $data_gudang_B05K10['gudang'];
			$jumlah_gudang_B05K10_new = $jumlah_gudang_B05K10 - $B05K10;

			
			$akses_ken_B05K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
			$data_ken_B05K10 = mysqli_fetch_array($akses_ken_B05K10);
			$jumlah_ken_B05K10 = $data_ken_B05K10['kendaraan'];
			$jumlah_ken_B05K10_new = $jumlah_ken_B05K10 + $B05K10;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_B05K10_new' WHERE kode_baja = 'B05K10' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_B05K10_new' WHERE kode_baja = 'B05K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','B05K10','$B05K10','$lokasi_awal','$lokasi_tujuan','$keterangan')");
			}

			if ($B05K00 > 0) {
			
			$akses_gudang_B05K00 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K00'");
			$data_gudang_B05K00 = mysqli_fetch_array($akses_gudang_B05K00);
			$jumlah_gudang_B05K00 = $data_gudang_B05K00['gudang'];
			$jumlah_gudang_B05K00_new = $jumlah_gudang_B05K00 - $B05K00;

			
			$akses_ken_B05K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
			$data_ken_B05K10 = mysqli_fetch_array($akses_ken_B05K10);
			$jumlah_ken_B05K10 = $data_ken_B05K10['kendaraan'];
			$jumlah_ken_B05K10_new = $jumlah_ken_B05K10 + $B05K00;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_B05K00_new' WHERE kode_baja = 'B05K00' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_B05K10_new' WHERE kode_baja = 'B05K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','B05K00','$B05K00','$lokasi_awal','$lokasi_tujuan','$keterangan')");
			}

			//GAS Bright Gas 12
			if ($B12K11 > 0) {
				
			$akses_gudang_B12K11 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
			$data_gudang_B12K11 = mysqli_fetch_array($akses_gudang_B12K11);
			$jumlah_gudang_B12K11 = $data_gudang_B12K11['gudang'];
			$jumlah_gudang_B12K11_new = $jumlah_gudang_B12K11 - $B12K11;

			
			$akses_ken_B12K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
			$data_ken_B12K10 = mysqli_fetch_array($akses_ken_B12K10);
			$jumlah_ken_B12K10 = $data_ken_B12K10['kendaraan'];
			$jumlah_ken_B12K10_new = $jumlah_ken_B12K10 + $B12K11;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_B12K11_new' WHERE kode_baja = 'B12K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_B12K11_new' WHERE kode_baja = 'B12K01' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_B12K10_new' WHERE kode_baja = 'B12K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','B12K11','$B12K11','$lokasi_awal','$lokasi_tujuan','$keterangan')");

			}
			
			if ($B12K10 > 0) {
				
			$akses_gudang_B12K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
			$data_gudang_B12K10 = mysqli_fetch_array($akses_gudang_B12K10);
			$jumlah_gudang_B12K10 = $data_gudang_B12K10['gudang'];
			$jumlah_gudang_B12K10_new = $jumlah_gudang_B12K10 - $B12K10;

			
			$akses_ken_B12K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
			$data_ken_B12K10 = mysqli_fetch_array($akses_ken_B12K10);
			$jumlah_ken_B12K10 = $data_ken_B12K10['kendaraan'];
			$jumlah_ken_B12K10_new = $jumlah_ken_B12K10 + $B12K10;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_B12K10_new' WHERE kode_baja = 'B12K10' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_B12K10_new' WHERE kode_baja = 'B12K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','B12K10','$B12K10','$lokasi_awal','$lokasi_tujuan','$keterangan')");
			}

			if ($B12K00 > 0) {
			
			$akses_gudang_B12K00 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K00'");
			$data_gudang_B12K00 = mysqli_fetch_array($akses_gudang_B12K00);
			$jumlah_gudang_B12K00 = $data_gudang_B12K00['gudang'];
			$jumlah_gudang_B12K00_new = $jumlah_gudang_B12K00 - $B12K00;

			
			$akses_ken_B12K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
			$data_ken_B12K10 = mysqli_fetch_array($akses_ken_B12K10);
			$jumlah_ken_B12K10 = $data_ken_B12K10['kendaraan'];
			$jumlah_ken_B12K10_new = $jumlah_ken_B12K10 + $B12K00;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_B12K00_new' WHERE kode_baja = 'B12K00' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_B12K10_new' WHERE kode_baja = 'B12K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','B12K00','$B12K00','$lokasi_awal','$lokasi_tujuan','$keterangan')");
			}

			echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
}
}
if ($lokasi_awal == 'Mobil') {
	if ($lokasi_tujuan =='Gudang') {
		if ($L03K11 > 0) {
				
			$akses_gudang_L03K11 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
			$data_gudang_L03K11 = mysqli_fetch_array($akses_gudang_L03K11);
			$jumlah_gudang_L03K11 = $data_gudang_L03K11['gudang'];
			$jumlah_gudang_L03K11_new = $jumlah_gudang_L03K11 + $L03K11;

			
			$akses_ken_L03K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
			$data_ken_L03K10 = mysqli_fetch_array($akses_ken_L03K10);
			$jumlah_ken_L03K10 = $data_ken_L03K10['kendaraan'];
			$jumlah_ken_L03K10_new = $jumlah_ken_L03K10 - $L03K11;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_L03K11_new' WHERE kode_baja = 'L03K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_L03K11_new' WHERE kode_baja = 'L03K01' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_L03K10_new' WHERE kode_baja = 'L03K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','L03K11','$L03K11','$lokasi_awal','$lokasi_tujuan','$keterangan')");

			}
			
			if ($L03K10 > 0) {
				
			$akses_gudang_L03K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
			$data_gudang_L03K10 = mysqli_fetch_array($akses_gudang_L03K10);
			$jumlah_gudang_L03K10 = $data_gudang_L03K10['gudang'];
			$jumlah_gudang_L03K10_new = $jumlah_gudang_L03K10 + $L03K10;

			
			$akses_ken_L03K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
			$data_ken_L03K10 = mysqli_fetch_array($akses_ken_L03K10);
			$jumlah_ken_L03K10 = $data_ken_L03K10['kendaraan'];
			$jumlah_ken_L03K10_new = $jumlah_ken_L03K10 - $L03K10;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_L03K10_new' WHERE kode_baja = 'L03K10' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_L03K10_new' WHERE kode_baja = 'L03K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','L03K10','$L03K10','$lokasi_awal','$lokasi_tujuan','$keterangan')");
			}

			if ($L03K00 > 0) {
			
			$akses_gudang_L03K00 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K00'");
			$data_gudang_L03K00 = mysqli_fetch_array($akses_gudang_L03K00);
			$jumlah_gudang_L03K00 = $data_gudang_L03K00['gudang'];
			$jumlah_gudang_L03K00_new = $jumlah_gudang_L03K00 + $L03K00;

			
			$akses_ken_L03K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
			$data_ken_L03K10 = mysqli_fetch_array($akses_ken_L03K10);
			$jumlah_ken_L03K10 = $data_ken_L03K10['kendaraan'];
			$jumlah_ken_L03K10_new = $jumlah_ken_L03K10 - $L03K00;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_L03K00_new' WHERE kode_baja = 'L03K00' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_L03K10_new' WHERE kode_baja = 'L03K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','L03K00','$L03K00','$lokasi_awal','$lokasi_tujuan','$keterangan')");
			}
			
			

			//GAS LPG 12
			if ($L12K11 > 0) {
				
			$akses_gudang_L12K11 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
			$data_gudang_L12K11 = mysqli_fetch_array($akses_gudang_L12K11);
			$jumlah_gudang_L12K11 = $data_gudang_L12K11['gudang'];
			$jumlah_gudang_L12K11_new = $jumlah_gudang_L12K11 + $L12K11;

			
			$akses_ken_L12K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
			$data_ken_L12K10 = mysqli_fetch_array($akses_ken_L12K10);
			$jumlah_ken_L12K10 = $data_ken_L12K10['kendaraan'];
			$jumlah_ken_L12K10_new = $jumlah_ken_L12K10 - $L12K11;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_L12K11_new' WHERE kode_baja = 'L12K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_L12K11_new' WHERE kode_baja = 'L12K01' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_L12K10_new' WHERE kode_baja = 'L12K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','L12K11','$L12K11','$lokasi_awal','$lokasi_tujuan','$keterangan')");

			}
			
			if ($L12K10 > 0) {
				
			$akses_gudang_L12K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
			$data_gudang_L12K10 = mysqli_fetch_array($akses_gudang_L12K10);
			$jumlah_gudang_L12K10 = $data_gudang_L12K10['gudang'];
			$jumlah_gudang_L12K10_new = $jumlah_gudang_L12K10 + $L12K10;

			
			$akses_ken_L12K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
			$data_ken_L12K10 = mysqli_fetch_array($akses_ken_L12K10);
			$jumlah_ken_L12K10 = $data_ken_L12K10['kendaraan'];
			$jumlah_ken_L12K10_new = $jumlah_ken_L12K10 - $L12K10;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_L12K10_new' WHERE kode_baja = 'L12K10' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_L12K10_new' WHERE kode_baja = 'L12K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','L12K10','$L12K10','$lokasi_awal','$lokasi_tujuan','$keterangan')");
			}

			if ($L12K00 > 0) {
			
			$akses_gudang_L12K00 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K00'");
			$data_gudang_L12K00 = mysqli_fetch_array($akses_gudang_L12K00);
			$jumlah_gudang_L12K00 = $data_gudang_L12K00['gudang'];
			$jumlah_gudang_L12K00_new = $jumlah_gudang_L12K00 + $L12K00;

			
			$akses_ken_L12K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
			$data_ken_L12K10 = mysqli_fetch_array($akses_ken_L12K10);
			$jumlah_ken_L12K10 = $data_ken_L12K10['kendaraan'];
			$jumlah_ken_L12K10_new = $jumlah_ken_L12K10 - $L12K00;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_L12K00_new' WHERE kode_baja = 'L12K00' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_L12K10_new' WHERE kode_baja = 'L12K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','L12K00','$L12K00','$lokasi_awal','$lokasi_tujuan','$keterangan')");
			}

			//GAS Bright Gas 5,5
			if ($B05K11 > 0) {
				
			$akses_gudang_B05K11 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
			$data_gudang_B05K11 = mysqli_fetch_array($akses_gudang_B05K11);
			$jumlah_gudang_B05K11 = $data_gudang_B05K11['gudang'];
			$jumlah_gudang_B05K11_new = $jumlah_gudang_B05K11 + $B05K11;

			
			$akses_ken_B05K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
			$data_ken_B05K10 = mysqli_fetch_array($akses_ken_B05K10);
			$jumlah_ken_B05K10 = $data_ken_B05K10['kendaraan'];
			$jumlah_ken_B05K10_new = $jumlah_ken_B05K10 - $B05K11;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_B05K11_new' WHERE kode_baja = 'B05K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_B05K11_new' WHERE kode_baja = 'B05K01' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_B05K10_new' WHERE kode_baja = 'B05K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','B05K11','$B05K11','$lokasi_awal','$lokasi_tujuan','$keterangan')");

			}
			
			if ($B05K10 > 0) {
				
			$akses_gudang_B05K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
			$data_gudang_B05K10 = mysqli_fetch_array($akses_gudang_B05K10);
			$jumlah_gudang_B05K10 = $data_gudang_B05K10['gudang'];
			$jumlah_gudang_B05K10_new = $jumlah_gudang_B05K10 + $B05K10;

			
			$akses_ken_B05K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
			$data_ken_B05K10 = mysqli_fetch_array($akses_ken_B05K10);
			$jumlah_ken_B05K10 = $data_ken_B05K10['kendaraan'];
			$jumlah_ken_B05K10_new = $jumlah_ken_B05K10 - $B05K10;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_B05K10_new' WHERE kode_baja = 'B05K10' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_B05K10_new' WHERE kode_baja = 'B05K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','B05K10','$B05K10','$lokasi_awal','$lokasi_tujuan','$keterangan')");
			}

			if ($B05K00 > 0) {
			
			$akses_gudang_B05K00 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K00'");
			$data_gudang_B05K00 = mysqli_fetch_array($akses_gudang_B05K00);
			$jumlah_gudang_B05K00 = $data_gudang_B05K00['gudang'];
			$jumlah_gudang_B05K00_new = $jumlah_gudang_B05K00 + $B05K00;

			
			$akses_ken_B05K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
			$data_ken_B05K10 = mysqli_fetch_array($akses_ken_B05K10);
			$jumlah_ken_B05K10 = $data_ken_B05K10['kendaraan'];
			$jumlah_ken_B05K10_new = $jumlah_ken_B05K10 - $B05K00;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_B05K00_new' WHERE kode_baja = 'B05K00' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_B05K10_new' WHERE kode_baja = 'B05K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','B05K00','$B05K00','$lokasi_awal','$lokasi_tujuan','$keterangan')");
			}

			//GAS Bright Gas 12
			if ($B12K11 > 0) {
				
			$akses_gudang_B12K11 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
			$data_gudang_B12K11 = mysqli_fetch_array($akses_gudang_B12K11);
			$jumlah_gudang_B12K11 = $data_gudang_B12K11['gudang'];
			$jumlah_gudang_B12K11_new = $jumlah_gudang_B12K11 + $B12K11;

			
			$akses_ken_B12K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
			$data_ken_B12K10 = mysqli_fetch_array($akses_ken_B12K10);
			$jumlah_ken_B12K10 = $data_ken_B12K10['kendaraan'];
			$jumlah_ken_B12K10_new = $jumlah_ken_B12K10 - $B12K11;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_B12K11_new' WHERE kode_baja = 'B12K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_B12K11_new' WHERE kode_baja = 'B12K01' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_B12K10_new' WHERE kode_baja = 'B12K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','B12K11','$B12K11','$lokasi_awal','$lokasi_tujuan','$keterangan')");

			}
			
			if ($B12K10 > 0) {
				
			$akses_gudang_B12K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
			$data_gudang_B12K10 = mysqli_fetch_array($akses_gudang_B12K10);
			$jumlah_gudang_B12K10 = $data_gudang_B12K10['gudang'];
			$jumlah_gudang_B12K10_new = $jumlah_gudang_B12K10 + $B12K10;

			
			$akses_ken_B12K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
			$data_ken_B12K10 = mysqli_fetch_array($akses_ken_B12K10);
			$jumlah_ken_B12K10 = $data_ken_B12K10['kendaraan'];
			$jumlah_ken_B12K10_new = $jumlah_ken_B12K10 - $B12K10;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_B12K10_new' WHERE kode_baja = 'B12K10' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_B12K10_new' WHERE kode_baja = 'B12K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','B12K10','$B12K10','$lokasi_awal','$lokasi_tujuan','$keterangan')");
			}

			if ($B12K00 > 0) {
			
			$akses_gudang_B12K00 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K00'");
			$data_gudang_B12K00 = mysqli_fetch_array($akses_gudang_B12K00);
			$jumlah_gudang_B12K00 = $data_gudang_B12K00['gudang'];
			$jumlah_gudang_B12K00_new = $jumlah_gudang_B12K00 + $B12K00;

			
			$akses_ken_B12K10 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
			$data_ken_B12K10 = mysqli_fetch_array($akses_ken_B12K10);
			$jumlah_ken_B12K10 = $data_ken_B12K10['kendaraan'];
			$jumlah_ken_B12K10_new = $jumlah_ken_B12K10 - $B12K00;

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_gudang_B12K00_new' WHERE kode_baja = 'B12K00' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET kendaraan = '$jumlah_ken_B12K10_new' WHERE kode_baja = 'B12K10' ");

			$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','GD','B12K00','$B12K00','$lokasi_awal','$lokasi_tujuan','$keterangan')");
			}

			echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
	}
}

