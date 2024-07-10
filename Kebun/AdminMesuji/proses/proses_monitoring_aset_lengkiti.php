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
$nama_aset = $_POST['nama_aset'];
$status = $_POST['status'];
$jumlah = $_POST['jumlah'];
$keterangan = $_POST['keterangan'];

$table = mysqli_query($koneksi, "SELECT * FROM list_aset_mesuji WHERE nama_aset = '$nama_aset' ");
$data2 = mysqli_fetch_array($table);

$jumlah_stok = $data2['stok_aset'];
$jumlah_stok_baru =0;
if($status == 'Masuk'){
    $jumlah_stok_baru = $jumlah_stok + $jumlah;
}else{
    $jumlah_stok_baru = $jumlah_stok - $jumlah;
}





	$query = mysqli_query($koneksi,"INSERT INTO monitoring_aset_mesuji VALUES('','$tanggal','$nama_aset','$status','$jumlah','$keterangan')");
    $query3 = mysqli_query($koneksi,"UPDATE list_aset_mesuji SET stok_aset = '$jumlah_stok_baru' WHERE nama_aset = '$nama_aset'");


			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VListAsetMesuji?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

  ?>