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
if ($jabatan_valid == 'Staff Admin') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = $_POST['tanggal'];
$nama_driver = $_POST['nama_driver'];
$nama_rute = $_POST['nama_rute'];
if($nama_rute == 'NJE'){
    $uang_gaji = 100000;
}
else if($nama_rute == 'Gas Palembang'){
    $uang_gaji = 150000;
}else{
	$uang_gaji = 100000;
}


$query = mysqli_query($koneksi,"INSERT INTO laporan_rit VALUES('','$tanggal','$nama_driver','$nama_rute','$uang_gaji',1)");

if ($query != "") {
	echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VRitDriver?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>