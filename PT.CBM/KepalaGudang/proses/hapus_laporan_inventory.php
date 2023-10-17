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

$no_laporan = $_POST['no_laporan'];

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];

$query = mysqli_query($koneksi,"DELETE FROM laporan_inventory WHERE no_laporan = '$no_laporan' ");

	$table = mysqli_query($koneksi, "SELECT * FROM laporan_inventory ORDER BY no_laporan DESC LIMIT 1 ");

	$data = mysqli_fetch_array($table);
	$referensi = $data['referensi'];
	$L03K11 = $data['L03K11'];
	$L03K10 = $data['L03K10'];
	$L03K00 = $data['L03K00'];
	$L12K11 = $data['L12K11'];
	$L12K10 = $data['L12K10'];
	$L12K00 = $data['L12K00'];
	$B05K11 = $data['B05K11'];
	$B05K10 = $data['B05K10'];
	$B05K00 = $data['B05K00'];
	$B12K11 = $data['B12K11'];
	$B12K10 = $data['B12K10'];
	$B12K00 = $data['B12K00'];

	if ($referensi == 'TK') {
		//3KG
		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$L03K11' WHERE kode_baja = 'L03K11'");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$L03K11' WHERE kode_baja = 'L03K01'");
		$query3 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$L03K10' WHERE kode_baja = 'L03K10'");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$L03K00' WHERE kode_baja = 'L03K00'");

		//12KG
		$query5 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$L12K11' WHERE kode_baja = 'L12K11'");
		$query6 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$L12K11' WHERE kode_baja = 'L12K01'");
		$query7 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$L12K10' WHERE kode_baja = 'L12K10'");
		$query8 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$L12K00' WHERE kode_baja = 'L12K00'");

		//5,5KG
		$query8 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$B05K11' WHERE kode_baja = 'B05K11'");
		$query9 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$B05K11' WHERE kode_baja = 'B05K01'");
		$query10 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$B05K10' WHERE kode_baja = 'B05K10'");
		$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$B05K00' WHERE kode_baja = 'B05K00'");

		//12BKG
		$querY12 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$B12K11' WHERE kode_baja = 'B12K11'");
		$query13 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$B12K11' WHERE kode_baja = 'B12K01'");
		$query14 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$B12K10' WHERE kode_baja = 'B12K10'");
		$query15 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$B12K00' WHERE kode_baja = 'B12K00'");

	}
	elseif ($referensi == 'GD') {
		//3KG
		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$L03K11' WHERE kode_baja = 'L03K11'");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$L03K11' WHERE kode_baja = 'L03K01'");
		$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$L03K10' WHERE kode_baja = 'L03K10'");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$L03K00' WHERE kode_baja = 'L03K00'");

		//12KG
		$query5 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$L12K11' WHERE kode_baja = 'L12K11'");
		$query6 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$L12K11' WHERE kode_baja = 'L12K01'");
		$query7 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$L12K10' WHERE kode_baja = 'L12K10'");
		$query8 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$L12K00' WHERE kode_baja = 'L12K00'");

		//5,5KG
		$query8 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$B05K11' WHERE kode_baja = 'B05K11'");
		$query9 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$B05K11' WHERE kode_baja = 'B05K01'");
		$query10 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$B05K10' WHERE kode_baja = 'B05K10'");
		$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$B05K00' WHERE kode_baja = 'B05K00'");

		//12BKG
		$querY12 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$B12K11' WHERE kode_baja = 'B12K11'");
		$query13 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$B12K11' WHERE kode_baja = 'B12K01'");
		$query14 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$B12K10' WHERE kode_baja = 'B12K10'");
		$query15 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$B12K00' WHERE kode_baja = 'B12K00'");

	}

	elseif ($referensi == 'Di Pinjam') {
		//3KG
		$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$L03K11' WHERE kode_baja = 'L03K11'");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$L03K11' WHERE kode_baja = 'L03K01'");
		$query3 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$L03K10' WHERE kode_baja = 'L03K10'");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$L03K00' WHERE kode_baja = 'L03K00'");

		//12KG
		$query5 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$L12K11' WHERE kode_baja = 'L12K11'");
		$query6 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$L12K11' WHERE kode_baja = 'L12K01'");
		$query7 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$L12K10' WHERE kode_baja = 'L12K10'");
		$query8 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$L12K00' WHERE kode_baja = 'L12K00'");

		//5,5KG
		$query8 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$B05K11' WHERE kode_baja = 'B05K11'");
		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$B05K11' WHERE kode_baja = 'B05K01'");
		$query10 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$B05K10' WHERE kode_baja = 'B05K10'");
		$query11 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$B05K00' WHERE kode_baja = 'B05K00'");

		//12BKG
		$querY12 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$B12K11' WHERE kode_baja = 'B12K11'");
		$query13 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$B12K11' WHERE kode_baja = 'B12K01'");
		$query14 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$B12K10' WHERE kode_baja = 'B12K10'");
		$query15 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$B12K00' WHERE kode_baja = 'B12K00'");

	}
	elseif ($referensi == 'Passive') {
		//3KG
		$query1 = mysqli_query($koneksi,"UPDATE inventory SET passive = '$L03K11' WHERE kode_baja = 'L03K11'");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET passive = '$L03K11' WHERE kode_baja = 'L03K01'");
		$query3 = mysqli_query($koneksi,"UPDATE inventory SET passive = '$L03K10' WHERE kode_baja = 'L03K10'");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET passive = '$L03K00' WHERE kode_baja = 'L03K00'");

		//12KG
		$query5 = mysqli_query($koneksi,"UPDATE inventory SET passive = '$L12K11' WHERE kode_baja = 'L12K11'");
		$query6 = mysqli_query($koneksi,"UPDATE inventory SET passive = '$L12K11' WHERE kode_baja = 'L12K01'");
		$query7 = mysqli_query($koneksi,"UPDATE inventory SET passive = '$L12K10' WHERE kode_baja = 'L12K10'");
		$query8 = mysqli_query($koneksi,"UPDATE inventory SET passive = '$L12K00' WHERE kode_baja = 'L12K00'");

		//5,5KG
		$query8 = mysqli_query($koneksi,"UPDATE inventory SET passive = '$B05K11' WHERE kode_baja = 'B05K11'");
		$query9 = mysqli_query($koneksi,"UPDATE inventory SET passive = '$B05K11' WHERE kode_baja = 'B05K01'");
		$query10 = mysqli_query($koneksi,"UPDATE inventory SET passive = '$B05K10' WHERE kode_baja = 'B05K10'");
		$query11 = mysqli_query($koneksi,"UPDATE inventory SET passive = '$B05K00' WHERE kode_baja = 'B05K00'");

		//12BKG
		$querY12 = mysqli_query($koneksi,"UPDATE inventory SET passive = '$B12K11' WHERE kode_baja = 'B12K11'");
		$query13 = mysqli_query($koneksi,"UPDATE inventory SET passive = '$B12K11' WHERE kode_baja = 'B12K01'");
		$query14 = mysqli_query($koneksi,"UPDATE inventory SET passive = '$B12K10' WHERE kode_baja = 'B12K10'");
		$query15 = mysqli_query($koneksi,"UPDATE inventory SET passive = '$B12K00' WHERE kode_baja = 'B12K00'");

	}
	


			echo "<script> window.location='../view/VLaporanInventory?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	
