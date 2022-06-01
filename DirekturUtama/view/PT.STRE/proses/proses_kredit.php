<?php
session_start();
include'koneksi.php';
if(!isset($_SESSION["login"])){
  header("Location: logout.php");
  exit;
}
$id=$_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksicbm, "SELECT * FROM super_account WHERE username = '$id'");
$data1 = mysqli_fetch_array($result1);
$nama = $data1['nama_pemilik'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Direktur Utama') {

}

else{ header("Location: logout.php");
exit;
}
$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$no_polisi = $_POST['no_polisi'];
$tanggal = $_POST['tanggal'];
$jumlah = $_POST['jumlah'];


	$query = mysqli_query($koneksistre,"INSERT INTO kredit_kendaraan VALUES('','$no_polisi','$tanggal','$jumlah')");

			if ($query != "") {
        echo "<script> window.location='../view/VBayarKredit?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

  ?>