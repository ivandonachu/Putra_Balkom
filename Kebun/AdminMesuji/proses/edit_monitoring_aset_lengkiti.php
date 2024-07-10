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
$tanggal = $_POST['tanggal'];
$nama_aset = $_POST['nama_aset'];
$status = $_POST['status'];
$jumlah = $_POST['jumlah'];
$keterangan = $_POST['keterangan'];

$table2 = mysqli_query($koneksi, "SELECT * FROM monitoring_aset_mesuji WHERE no_laporan = '$no_laporan' ");
$data2 = mysqli_fetch_array($table2);
$jumlah_stok_sebelumnya = $data2['jumlah'];
$status_sebelumnya = $data2['status'];

$table = mysqli_query($koneksi, "SELECT * FROM list_aset_mesuji WHERE nama_aset = '$nama_aset' ");
$data = mysqli_fetch_array($table);

$jumlah_stok = $data['stok_aset'];
$jumlah_stok_baru = 0;


if ($status_sebelumnya == 'Masuk' && $status == 'Masuk') {
    $jumlah_stok_baru = ($jumlah_stok - $jumlah_stok_sebelumnya) + $jumlah;
} else if ($status_sebelumnya == 'Masuk' && $status == 'Keluar') {
    $jumlah_stok_baru = ($jumlah_stok - $jumlah_stok_sebelumnya) - $jumlah;
}
else if ($status_sebelumnya == 'Keluar' && $status == 'Masuk') {
    $jumlah_stok_baru = ($jumlah_stok + $jumlah_stok_sebelumnya) + $jumlah;
}
else if ($status_sebelumnya == 'Keluar' && $status == 'Keluar') {
    $jumlah_stok_baru = ($jumlah_stok + $jumlah_stok_sebelumnya) - $jumlah;
}



$query = mysqli_query($koneksi, "UPDATE monitoring_aset_mesuji SET tanggal = '$tanggal', nama_aset = '$nama_aset', status = '$status', jumlah = '$jumlah', keterangan = '$keterangan' WHERE no_laporan = '$no_laporan'");


$query3 = mysqli_query($koneksi, "UPDATE list_aset_mesuji SET stok_aset = '$jumlah_stok_baru' WHERE nama_aset = '$nama_aset'");


if ($query != "") {
    echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VListAsetMesuji?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";
    exit;
}
