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

$tanggal = date('Y-m-d');
$nm_asset = $_POST['nm_asset'];
$pengguna = $_POST['pengguna'];
$referensi = $_POST['referensi'];
$jumlah = $_POST['jumlah'];
$keterangan = $_POST['keterangan'];


	$query = mysqli_query($koneksi,"INSERT INTO aset VALUES ('','$tanggal','$nm_asset','$jumlah','$referensi','$pengguna','$keterangan')");


			if ($query != "") {
				echo "<script> window.location='../view/VAset';</script>";exit;
			}
