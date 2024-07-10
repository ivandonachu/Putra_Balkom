<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
    exit;
}
$id = $_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account WHERE id_karyawan = '$id'");
$data1 = mysqli_fetch_array($result1);
$id1 = $data1['id_karyawan'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Admin Mesuji') {
} else {
    header("Location: logout.php");
    exit;
}


$no_laporan = $_POST['no_laporan'];
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];


$table2 = mysqli_query($koneksi, "SELECT * FROM monitoring_aset_mesuji WHERE no_laporan = '$no_laporan' ");
$data2 = mysqli_fetch_array($table2);
$jumlah_stok_sebelumnya = $data2['jumlah'];
$status_sebelumnya = $data2['status'];
$nama_aset = $data2['nama_aset'];
$status = $data2['status'];

$table = mysqli_query($koneksi, "SELECT * FROM list_aset_mesuji WHERE nama_aset = '$nama_aset' ");
$data = mysqli_fetch_array($table);

$jumlah_stok = $data['stok_aset'];
$jumlah_stok_baru = 0;

if($status == 'Masuk'){
    $jumlah_stok_baru = $jumlah_stok - $jumlah_stok_sebelumnya;
}else{
    $jumlah_stok_baru = $jumlah_stok + $jumlah_stok_sebelumnya;
}



//Hapusriwayat keberangkatan
$query = mysqli_query($koneksi, "DELETE FROM monitoring_aset_mesuji WHERE no_laporan = '$no_laporan'");

$query3 = mysqli_query($koneksi, "UPDATE list_aset_mesuji SET stok_aset = '$jumlah_stok_baru' WHERE nama_aset = '$nama_aset'");





echo "<script> window.location='../view/VListAsetMesuji?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";
exit;
