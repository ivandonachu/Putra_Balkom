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

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = $_POST['tanggal'];
$delivery_point = $_POST['delivery_point'];
$lo = $_POST['lo'];
$jumlah_pesanan = $_POST['jumlah_pesanan'];
$amt = $_POST['amt'];
$mt = $_POST['mt'];


$result2 = mysqli_query($koneksi, "SELECT * FROM tagihan_bk WHERE lo = '$lo' AND tanggal = '$tanggal' ");
 if(mysqli_num_rows($result2) == 1 ){
  	echo "<script>alert('LO sudah tercatat :)'); window.location='../view/VTagihanBk?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>"; exit;
      }

if ($jumlah_pesanan == '1000 L') {
	$kode_pesanan = 'kl1';
}
else if ($jumlah_pesanan == '2000 L') {
	$kode_pesanan = 'kl2';
}
else if ($jumlah_pesanan == '3000 L') {
	$kode_pesanan = 'kl3';
}
else if ($jumlah_pesanan == '4000 L') {
	$kode_pesanan = 'kl4';
}
else if ($jumlah_pesanan == '5000 L') {
	$kode_pesanan = 'kl5';
}

$result3 = mysqli_query($koneksi, "SELECT * FROM master_tarif_bk WHERE delivery_point = '$delivery_point' ");
$data_tarif = mysqli_fetch_array($result3);
$harga = $data_tarif[$kode_pesanan];


if ($jumlah_pesanan == '1000 L') {
	$total = 1000 * $harga;
}
else if ($jumlah_pesanan == '2000 L') {
	$total = 2000 * $harga;
}
else if ($jumlah_pesanan == '3000 L') {
	$total = 3000 * $harga;
}
else if ($jumlah_pesanan == '4000 L') {
	$total = 4000 * $harga;
}
else if ($jumlah_pesanan == '5000 L') {
	$total = 5000 * $harga;
}



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

		move_uploaded_file($tmp_name, '../file_administrasi/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}





$query = mysqli_query($koneksi,"INSERT INTO tagihan_bk VALUES('','$tanggal','$delivery_point','$lo','$amt','$mt','$kode_pesanan','$total',1,'$file')");

if ($query != "") {
echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VTagihanBk?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}



?>