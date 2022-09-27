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

$jen_ken = $_POST['jen_ken'];

$jt_gps = $_POST['jt_gps'];
$jt_odo = $_POST['jt_odo'];
$keterangan = $_POST['keterangan'];




if($jen_ken == '8000 L'){
	$dexlite = $jt_gps/5;
}
else{
	$dexlite = $jt_gps/6;
}

$u_dex = ($dexlite*10000)/2;
$uang_makan = (625*$jt_gps)/2;
$uang_gaji = (625 * $jt_gps)/2;
$ug_dimuka = ($dexlite * 1850)/2;
$uang_jalan = $u_dex + $uang_makan;
$mel = 50000/2;
$jt_gps_x = $jt_gps/2;
$jt_odo_x = $jt_odo/2;


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
    $query = mysqli_query($koneksi,"UPDATE pengiriman SET jt_gps = '$jt_gps_x' , jt_odo = '$jt_odo_x' , dexlite = '$dexlite', uang_dexlite = '$u_dex' , um = '$uang_makan', ug = '$uang_gaji', ug_dimuka = '$ug_dimuka', uj = '$uang_jalan', mel = '$mel', keterangan = '$keterangan'  WHERE no_tagihan = '$no_tagihan'");
}
    else{
    $query = mysqli_query($koneksi,"UPDATE pengiriman SET jt_gps = '$jt_gps_x' , jt_odo = '$jt_odo_x' , dexlite = '$dexlite', uang_dexlite = '$u_dex', um = '$uang_makan', ug = '$uang_gaji', ug_dimuka = '$ug_dimuka', uj = '$uang_jalan', mel = '$mel', keterangan = '$keterangan' , file_bukti_x = '$file'  WHERE no_tagihan = '$no_tagihan'");
}



	echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VPengiriman.php?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;



?>