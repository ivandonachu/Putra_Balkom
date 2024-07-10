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
$akun = $_POST['akun'];
$nama_pupuk = $_POST['nama_pupuk'];
$jumlah = $_POST['jumlah'];
$keterangan = $_POST['keterangan'];
if($akun == 'Stok Masuk'){
    $jumlah_masuk = $jumlah;
    $jumlah_keluar = 0;
}
else{
    $jumlah_masuk = 0;
    $jumlah_keluar = $jumlah;
}



	$query = mysqli_query($koneksi,"INSERT INTO stok_pupuk_msj VALUES('','$tanggal','$nama_pupuk','$akun','$jumlah_masuk','$jumlah_keluar','$keterangan')");

			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VLPupuk?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

  ?>