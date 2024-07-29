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

$blok_a1 = $_POST['blok_a1'];
$jumlah_batang_a1 = $_POST['jumlah_batang_a1'];
$jumlah_batang_mati_a1 = $_POST['jumlah_batang_mati_a1'];
$hasil_a1 = $_POST['hasil_a1'];

$blok_a2 = $_POST['blok_a2'];
$jumlah_batang_a2 = $_POST['jumlah_batang_a2'];
$jumlah_batang_mati_a2 = $_POST['jumlah_batang_mati_a2'];
$hasil_a2 = $_POST['hasil_a2'];

$blok_a3 = $_POST['blok_a3'];
$jumlah_batang_a3 = $_POST['jumlah_batang_a3'];
$jumlah_batang_mati_a3 = $_POST['jumlah_batang_mati_a3'];
$hasil_a3 = $_POST['hasil_a3'];

$blok_a4 = $_POST['blok_a4'];
$jumlah_batang_a4 = $_POST['jumlah_batang_a4'];
$jumlah_batang_mati_a4 = $_POST['jumlah_batang_mati_a4'];
$hasil_a4 = $_POST['hasil_a4'];

$blok_a5 = $_POST['blok_a5'];
$jumlah_batang_a5 = $_POST['jumlah_batang_a5'];
$jumlah_batang_mati_a5 = $_POST['jumlah_batang_mati_a5'];
$hasil_a5 = $_POST['hasil_a5'];

$blok_a6 = $_POST['blok_a6'];
$jumlah_batang_a6 = $_POST['jumlah_batang_a6'];
$jumlah_batang_mati_a6 = $_POST['jumlah_batang_mati_a6'];
$hasil_a6 = $_POST['hasil_a6'];

$blok_a7 = $_POST['blok_a7'];
$jumlah_batang_a7 = $_POST['jumlah_batang_a7'];
$jumlah_batang_mati_a7 = $_POST['jumlah_batang_mati_a7'];
$hasil_a7 = $_POST['hasil_a7'];

if($blok_a1 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$blok_a1','$jumlah_batang_a1','$jumlah_batang_mati_a1','$hasil_a1')");
}

if($blok_a2 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$blok_a2','$jumlah_batang_a2','$jumlah_batang_mati_a2','$hasil_a2')");
}

if($blok_a3 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$blok_a3','$jumlah_batang_a3','$jumlah_batang_mati_a3','$hasil_a3')");
}

if($blok_a4 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$blok_a4','$jumlah_batang_a4','$jumlah_batang_mati_a4','$hasil_a4')");
}

if($blok_a5 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$blok_a5','$jumlah_batang_a5','$jumlah_batang_mati_a5','$hasil_a5')");
}

if($blok_a6 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$blok_a6','$jumlah_batang_a6','$jumlah_batang_mati_a6','$hasil_a6')");
}

if($blok_a7 != ''){
    $query = mysqli_query($koneksi,"INSERT INTO laporan_batang_msj  VALUES('','$tanggal','$blok_a7','$jumlah_batang_a7','$jumlah_batang_mati_a7','$hasil_a7')");
}
			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VLBatang?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

  ?>