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

$no_tagihan = $_POST['no_tagihan'];
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$tanggal = $_POST['tanggal'];
$delivery_point = $_POST['delivery_point'];
$so = $_POST['so'];
$lo = $_POST['lo'];
$jumlah_pesanan = $_POST['jumlah_pesanan'];
$amt = $_POST['amt'];
$mt = $_POST['mt'];


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

$result = mysqli_query($koneksi, "SELECT * FROM master_tarif WHERE delivery_point = '$delivery_point' ");
$data_tarif = mysqli_fetch_array($result);
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





	if ($file == '') {
			$query3 = mysqli_query($koneksi,"UPDATE tagihan SET delivery_point = '$delivery_point' , so = '$so', lo = '$lo' , amt = '$amt' , mt = '$mt' , jumlah_pesanan = '$kode_pesanan' , total = '$total'  WHERE no_tagihan = '$no_tagihan'");
	}
	else{
			$query3 = mysqli_query($koneksi,"UPDATE tagihan SET delivery_point = '$delivery_point' , so = '$so', lo = '$lo' , amt = '$amt' , mt = '$mt' , jumlah_pesanan = '$kode_pesanan' , total = '$total' , file_bukti = '$file'  WHERE no_tagihan = '$no_tagihan'");
	}


	echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VTagihan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

?>