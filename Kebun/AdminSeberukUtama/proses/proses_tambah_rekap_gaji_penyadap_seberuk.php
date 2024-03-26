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
if ($jabatan_valid == 'Admin Seberuk Utama') {

}

else{  header("Location: logout.php");
exit;
}
    $tanggal_awal = $_GET['tanggal1'];
    $tanggal_akhir = $_GET['tanggal2'];
    $tanggal = $_POST['tanggal'];
    $nama_penyadap =$_POST['nama_penyadap'];
    $berat = $_POST['berat'];
    $harga_gaji = $_POST['harga_gaji'];
    $total_gaji = $berat * $harga_gaji;

$query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_penyadap_seberuk VALUES('','$tanggal','$nama_penyadap','$berat','$harga_gaji','$total_gaji')");


if ($query != "") {

    echo "<script>alert('Proses Tambah Rekap Data Berhasil :)'); window.location='../view/VRekapGajiPenyadap?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>