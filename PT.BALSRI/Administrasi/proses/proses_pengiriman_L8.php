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
$amt = $_POST['amt'];
$mt = $_POST['mt'];
$rit = 1;
$muatan = $_POST['muatan'];
$jt_gps = $_POST['jt_gps'];
$jt_odo = $_POST['jt_odo'];
$jns_trans = $_POST['jns_trans'];
$jml_trans = $_POST['jml_trans'];
$muatan = $_POST['muatan'];
$keterangan = $_POST['keterangan'];

$result2 = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE no_polisi = '$mt' ");
$data_kendaraan = mysqli_fetch_array($result2);
$no = $data_kendaraan['no'];
$jen_ken = $data_kendaraan['jenis_kendaraan'];



if($jen_ken == '8000 L'){
	$dexlite = $jt_gps/5;
}
else{
	$dexlite = $jt_gps/6;
}

$u_dex = $dexlite*13000;
$uang_makan = 625*$jt_gps;
$uang_jalan = $u_dex + $uang_makan;
if ($jns_trans == 'Lost') {

	if ($muatan == '8000 L') {
		$jml_lost = (8000 * 0.15) / 100;
		$total_lost = $jml_trans - $jml_lost;
		$uang_gaji = ((625 * $jt_gps) - ($total_lost  * 8350));
}
	}
	

else{

	$uang_gaji = (625 * $jt_gps);
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

$result = mysqli_query($koneksi, "SELECT * FROM driver WHERE nama_driver = '$amt' ");
$data_driver = mysqli_fetch_array($result);
$no_driver = $data_driver['no_driver'];


if ($jns_trans == 'Lost') {
	$query = mysqli_query($koneksi,"INSERT INTO pengiriman_spbu VALUES('','$tanggal','$no','$no_driver','$muatan','$rit','$jt_gps','$jt_odo','$dexlite','$u_dex','$uang_makan','$uang_gaji','$uang_jalan','$jns_trans','$total_lost','$keterangan','$file','$id1')");

}
else {
	$query = mysqli_query($koneksi,"INSERT INTO pengiriman_spbu VALUES('','$tanggal','$no','$no_driver','$muatan','$rit','$jt_gps','$jt_odo','$dexlite','$u_dex','$uang_makan','$uang_gaji','$uang_jalan','$jns_trans','$jml_trans','$keterangan','$file','$id1')");

}

if ($query != "") {
	echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VPengirimanL8?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>