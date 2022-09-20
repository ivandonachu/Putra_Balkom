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
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_tagihan = $_POST['no_tagihan'];
$tonase = $_POST['tonase'];

$tanggal = $_POST['tanggal'];


$amt_1 = $_POST['amt_1'];
$sql_driver_1 = mysqli_query($koneksi, "SELECT no_driver_1 FROM driver_1 WHERE nama_driver_1 = '$amt_1' ");
$data_driver_1 = mysqli_fetch_assoc($sql_driver_1);
$no_driver_1 = $data_driver_1['no_driver_1'];

$amt_2 = $_POST['amt_2'];
$sql_driver_2 = mysqli_query($koneksi, "SELECT no_driver_2 FROM driver_2  WHERE nama_driver_2  = '$amt_2' ");
$data_driver_2 = mysqli_fetch_assoc($sql_driver_2);
$no_driver_2 = $data_driver_2['no_driver_2'];

$mt = $_POST['mt'];
$sql_kendaraan = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE no_polisi = '$mt' ");
$data_kendaraan = mysqli_fetch_assoc($sql_kendaraan);
$no_kendaraan = $data_kendaraan['no'];

$total = 10000000;



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
		$query = mysqli_query($koneksi,"UPDATE tagihan SET tanggal = '$tanggal',tonase = '$tonase', no_driver_1 = '$no_driver_1', no_driver_2 = '$no_driver_2' , no_kendaraan = '$no_kendaraan' , total = '$total'  WHERE no_tagihan = '$no_tagihan'");
	}
		else{
		$query = mysqli_query($koneksi,"UPDATE tagihan SET tanggal = '$tanggal',tonase = '$tonase', no_driver_1 = '$no_driver_1', no_driver_2 = '$no_driver_2' , no_kendaraan = '$no_kendaraan' , total = '$total' , file_bukti = '$file'  WHERE no_tagihan = '$no_tagihan'");
	}

	

	
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VTagihan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	
	



  ?>