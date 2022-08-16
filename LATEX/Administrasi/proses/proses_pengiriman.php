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
$tanggal = $_POST['tanggal'];
$no_tagihan = $_POST['no_tagihan'];
$no_driver_1 = $_POST['no_driver_1'];
$no_driver_2 = $_POST['no_driver_2'];
$no_kendaraan = $_POST['no_kendaraan'];
$jen_ken = $_POST['jen_ken'];
$rit = 1;
$jt_gps = $_POST['jt_gps'];
$jt_odo = $_POST['jt_odo'];
$keterangan = $_POST['keterangan'];




if($jen_ken == '8000 L'){
	$dexlite = $jt_gps/5;
}
else{
	$dexlite = $jt_gps/6;
}

$u_dex = ($dexlite*7500)/2;
$uang_makan = (625*$jt_gps)/2;
$uang_gaji = (625 * $jt_gps)/2;
$uang_jalan = $u_dex + $uang_makan;
$mel = 50000;


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


$result = mysqli_query($koneksi, "SELECT * FROM pengiriman WHERE no_tagihan = '$no_tagihan' AND tanggal = '$tanggal' ");
 if(mysqli_num_rows($result) > 1 ){
  	echo "<script>alert('Pengiriman sudah tercatat :)'); window.location='../view/VTagihan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>"; exit;
      }

	$query = mysqli_query($koneksi,"INSERT INTO pengiriman VALUES('','$tanggal','$no_tagihan','$no_driver_1','AMT 1','$no_kendaraan','$rit','$jt_gps','$jt_odo','$dexlite','$u_dex','$uang_makan','$uang_gaji','$uang_jalan','$mel','$keterangan','$file')");
	$query2 = mysqli_query($koneksi,"INSERT INTO pengiriman VALUES('','$tanggal','$no_tagihan','$no_driver_2','AMT 2','$no_kendaraan','$rit','$jt_gps','$jt_odo','$dexlite','$u_dex','$uang_makan','$uang_gaji','$uang_jalan','$mel','$keterangan','$file')");


if ($query != "") {
	echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VTagihan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>