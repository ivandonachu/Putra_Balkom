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
$so = $_POST['so'];
$lo = $_POST['lo'];
$jumlah_pesanan = $_POST['jumlah_pesanan'];
$amt = $_POST['amt'];
$mt = $_POST['mt'];



$result2 = mysqli_query($koneksi, "SELECT * FROM tagihan_pl WHERE lo = '$lo' AND tanggal = '$tanggal' ");
 if(mysqli_num_rows($result2) == 1 ){
  	echo "<script>alert('LO sudah tercatat :)'); window.location='../view/VTagihanPL?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>"; exit;
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


$result3 = mysqli_query($koneksi, "SELECT * FROM master_tarif_pl WHERE delivery_point = '$delivery_point' ");
$data_tarif = mysqli_fetch_array($result3);
$total = $data_tarif[$kode_pesanan];



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





$query = mysqli_query($koneksi,"INSERT INTO tagihan_pl VALUES('','$tanggal','$delivery_point','$so','$lo','$amt','$mt','$kode_pesanan','$total',1,'$file','$id1')");

if ($query != "") {
echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VTagihanPL?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}



?>