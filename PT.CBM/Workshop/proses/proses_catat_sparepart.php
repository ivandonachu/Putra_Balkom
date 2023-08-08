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
if ($jabatan_valid == 'Admin Workshop') {

}

else{  header("Location: logout.php");
exit;
}

$nama_sparepart = $_POST['nama_sparepart'];
$referensi = $_POST['referensi'];
$stok = $_POST['stok'];
$harga = $_POST['harga'];
$satuan = $_POST['satuan'];
$keterangan = $_POST['keterangan'];

	$query3 = mysqli_query($koneksi,"INSERT INTO list_sparepart VALUES('','$referensi','$nama_sparepart','$harga','$satuan','$stok','$keterangan')");

		if ($query3!= "") {
		echo "<script>alert('Tambah Data Berhasil :)'); window.location='../view/VInventorySparepart.php';</script>";exit;
}


  ?>