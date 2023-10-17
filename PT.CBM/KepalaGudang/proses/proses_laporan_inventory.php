z<?php
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
$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = $_POST['tanggal'];
$referensi = $_POST['referensi'];
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

$nama_file = $_FILES['file']['name'];

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

		move_uploaded_file($tmp_name, '../file_gudang/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}

	$query = mysqli_query($koneksi,"INSERT INTO laporan_inventory VALUES ('','$tanggal','$referensi','$L03K11','$L03K10','$L03K00','$L12K11','$L12K10','$L12K00','$B05K11','$B05K10','$B05K00','$B12K11','$B12K10','$B12K00','$file')");
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
	
	if ($query != "") {
			echo "<script> window.location='../view/VLaporanInventory?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
