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
if ($jabatan_valid == 'Admin Mesuji') {

}

else{  header("Location: logout.php");
exit;
}


$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];

$tanggal = $_POST['tanggal'];

$no_blok_1 = $_POST['no_blok_1'];
$nama_penyadap_1 = $_POST['nama_penyadap_1'];
$jumlah_batang_1 = $_POST['jumlah_batang_1'];
$jumlah_batang_mati_1 = $_POST['jumlah_batang_mati_1'];

$no_blok_2 = $_POST['no_blok_2'];
$nama_penyadap_2 = $_POST['nama_penyadap_2'];
$jumlah_batang_2 = $_POST['jumlah_batang_2'];
$jumlah_batang_mati_2 = $_POST['jumlah_batang_mati_2'];

$no_blok_3 = $_POST['no_blok_3'];
$nama_penyadap_3 = $_POST['nama_penyadap_3'];
$jumlah_batang_3 = $_POST['jumlah_batang_3'];
$jumlah_batang_mati_3 = $_POST['jumlah_batang_mati_3'];

$no_blok_4 = $_POST['no_blok_4'];
$nama_penyadap_4 = $_POST['nama_penyadap_4'];
$jumlah_batang_4 = $_POST['jumlah_batang_4'];
$jumlah_batang_mati_4 = $_POST['jumlah_batang_mati_4'];

$no_blok_5 = $_POST['no_blok_5'];
$nama_penyadap_5 = $_POST['nama_penyadap_5'];
$jumlah_batang_5 = $_POST['jumlah_batang_5'];
$jumlah_batang_mati_5 = $_POST['jumlah_batang_mati_5'];

$no_blok_6 = $_POST['no_blok_6'];
$nama_penyadap_6 = $_POST['nama_penyadap_6'];
$jumlah_batang_6= $_POST['jumlah_batang_6'];
$jumlah_batang_mati_6 = $_POST['jumlah_batang_mati_6'];

$no_blok_7 = $_POST['no_blok_7'];
$nama_penyadap_7 = $_POST['nama_penyadap_7'];
$jumlah_batang_7 = $_POST['jumlah_batang_7'];
$jumlah_batang_mati_7 = $_POST['jumlah_batang_mati_7'];

$no_blok_8 = $_POST['no_blok_8'];
$nama_penyadap_8 = $_POST['nama_penyadap_8'];
$jumlah_batang_8 = $_POST['jumlah_batang_8'];
$jumlah_batang_mati_8 = $_POST['jumlah_batang_mati_8'];

$no_blok_9 = $_POST['no_blok_9'];
$nama_penyadap_9 = $_POST['nama_penyadap_9'];
$jumlah_batang_9 = $_POST['jumlah_batang_9'];
$jumlah_batang_mati_9 = $_POST['jumlah_batang_mati_9'];

$no_blok_10 = $_POST['no_blok_10'];
$nama_penyadap_10 = $_POST['nama_penyadap_10'];
$jumlah_batang_10 = $_POST['jumlah_batang_10'];
$jumlah_batang_mati_10 = $_POST['jumlah_batang_mati_10'];

if($no_blok_1 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$no_blok_1','$nama_penyadap_1','$jumlah_batang_1','$jumlah_batang_mati_1')");
}

if($no_blok_2 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$no_blok_2','$nama_penyadap_2','$jumlah_batang_2','$jumlah_batang_mati_2')");
}

if($no_blok_3 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$no_blok_3','$nama_penyadap_3','$jumlah_batang_3','$jumlah_batang_mati_3')");
}

if($no_blok_4 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$no_blok_4','$nama_penyadap_4','$jumlah_batang_4','$jumlah_batang_mati_4')");
}

if($no_blok_5 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$no_blok_5','$nama_penyadap_5','$jumlah_batang_5','$jumlah_batang_mati_5')");
}

if($no_blok_6 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$no_blok_6','$nama_penyadap_6','$jumlah_batang_6','$jumlah_batang_mati_6')");
}

if($no_blok_7 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$no_blok_7','$nama_penyadap_7','$jumlah_batang_7','$jumlah_batang_mati_7')");
}

if($no_blok_8 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$no_blok_8','$nama_penyadap_8','$jumlah_batang_8','$jumlah_batang_mati_8')");
}

if($no_blok_9 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$no_blok_9','$nama_penyadap_9','$jumlah_batang_9','$jumlah_batang_mati_9')");
}

if($no_blok_10 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$no_blok_10','$nama_penyadap_10','$jumlah_batang_10','$jumlah_batang_mati_1')");
}

			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VLBatang?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

  ?>