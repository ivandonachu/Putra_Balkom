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
$kode_pesanan = 'kl5';


$result = mysqli_query($koneksi, "SELECT * FROM master_tarif_spbu WHERE delivery_point = '$delivery_point' ");
$data_tarif = mysqli_fetch_array($result);
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



	if ($file == '') {
			$query3 = mysqli_query($koneksi,"UPDATE tagihan_spbu SET delivery_point = '$delivery_point' , so = '$so', lo = '$lo' , amt = '$amt' , mt = '$mt' , jumlah_pesanan = '$kode_pesanan' , total = '$total', kode_input = '$id1'   WHERE no_tagihan = '$no_tagihan'");
	}
	else{
			$query3 = mysqli_query($koneksi,"UPDATE tagihan_spbu SET delivery_point = '$delivery_point' , so = '$so', lo = '$lo' , amt = '$amt' , mt = '$mt' , jumlah_pesanan = '$kode_pesanan' , total = '$total' , file_bukti = '$file' , kode_input = '$id1'  WHERE no_tagihan = '$no_tagihan'");
	}


	echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VTagihanL8?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

?>