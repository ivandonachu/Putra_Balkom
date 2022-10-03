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
$no_laporan = $_POST['no_laporan'];
$amt = $_POST['amt'];
$mt = $_POST['mt'];
$rit = 1;
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
$u_dex = $dexlite*18100;
$uang_makan = 625*$jt_gps;
$uang_jalan = $u_dex + $uang_makan;
if ($jns_trans == 'Lost') {
	if ($muatan == '1000 L') {
		$jml_lost = (1000 * 0.15) / 100;
		$total_lost = $jml_trans - $jml_lost;
		$uang_gaji = ((625 * $jt_gps) - ($total_lost  * 8350));
	}
	else if ($muatan == '2000 L') {
		$jml_lost = (2000 * 0.15) / 100;
		$total_lost = $jml_trans - $jml_lost;
		$uang_gaji = ((625 * $jt_gps) - ($total_lost  * 8350));
	}
	else if ($muatan == '3000 L') {
		$jml_lost = (3000 * 0.15) / 100;
		$total_lost = $jml_trans - $jml_lost;
		$uang_gaji = ((625 * $jt_gps) - ($total_lost  * 8350));
	}
	else if ($muatan == '4000 L') {
		$jml_lost = (4000 * 0.15) / 100;
		$total_lost = $jml_trans - $jml_lost;
		$uang_gaji = ((625 * $jt_gps) - ($total_lost  * 8350));
	}
	else if ($muatan == '5000 L') {
		$jml_lost = (5000 * 0.15) / 100;
		$total_lost = $jml_trans - $jml_lost;
		$uang_gaji = ((625 * $jt_gps) - ($total_lost  * 8350));
	}
	else if ($muatan == '6000 L') {
		$jml_lost = (6000 * 0.15) / 100;
		$total_lost = $jml_trans - $jml_lost;
		$uang_gaji = ((625 * $jt_gps) - ($total_lost  * 8350));
	}
	else if ($muatan == '7000 L') {
		$jml_lost = (7000 * 0.15) / 100;
		$total_lost = $jml_trans - $jml_lost;
		$uang_gaji = ((625 * $jt_gps) - ($total_lost  * 8350));
	}
	else if ($muatan == '8000 L') {
		$jml_lost = (8000 * 0.15) / 100;
		$total_lost = $jml_trans - $jml_lost;
		$uang_gaji = ((625 * $jt_gps) - ($total_lost  * 8350));
}
	}
	

else{

	$uang_gaji = 625 * $jt_gps;
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

$result2 = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE no_polisi = '$mt' ");
$data_kendaraan = mysqli_fetch_array($result2);
$no = $data_kendaraan['no'];
	

if ($jns_trans == 'Lost') {
	if ($file == '') {
	$query = mysqli_query($koneksi,"UPDATE pengiriman_p SET no_driver = '$no_driver' ,no = '$no', muatan = '$muatan', jt_gps = '$jt_gps' , jt_odo = '$jt_odo' , dexlite = '$dexlite', u_dex = '$u_dex', um = '$uang_makan', ug = '$uang_gaji', uj = '$uang_jalan', jns_trans = '$jns_trans', jml_trans = '$total_lost', keterangan = '$keterangan'  WHERE no_laporan = '$no_laporan'");
}
	else{
	$query = mysqli_query($koneksi,"UPDATE pengiriman_p SET no_driver = '$no_driver' , no = '$no', muatan = '$muatan' , jt_gps = '$jt_gps' , jt_odo = '$jt_odo' , dexlite = '$dexlite', u_dex = '$u_dex', um = '$uang_makan', ug = '$uang_gaji', uj = '$uang_jalan', jns_trans = '$jns_trans', jml_trans = '$total_lost', keterangan = '$keterangan' , file_bukti = '$file'  WHERE no_laporan = '$no_laporan'");
}


		echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VPengiriman2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
}
else{
	if ($file == '') {
	$query = mysqli_query($koneksi,"UPDATE pengiriman_p SET no_driver = '$no_driver' , no = '$no', muatan = '$muatan', jt_gps = '$jt_gps' , jt_odo = '$jt_odo' , dexlite = '$dexlite', u_dex = '$u_dex', um = '$uang_makan', ug = '$uang_gaji', uj = '$uang_jalan', jns_trans = '$jns_trans', jml_trans = '$jml_trans', keterangan = '$keterangan'  WHERE no_laporan = '$no_laporan'");
}
	else{
	$query = mysqli_query($koneksi,"UPDATE pengiriman_p SET no_driver = '$no_driver' , no = '$no' , muatan = '$muatan', jt_gps = '$jt_gps' , jt_odo = '$jt_odo' , dexlite = '$dexlite', u_dex = '$u_dex', um = '$uang_makan', ug = '$uang_gaji', uj = '$uang_jalan', jns_trans = '$jns_trans', jml_trans = '$jml_trans', keterangan = '$keterangan' , file_bukti = '$file'  WHERE no_laporan = '$no_laporan'");
}

	
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VPengirimanP2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	}
	



  ?>