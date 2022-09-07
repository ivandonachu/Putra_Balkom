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
if ($jabatan_valid == 'Admin Sparepart') {

}

else{  header("Location: logout.php");
exit;
}


$nama_sparepart = $_POST['nama_sparepart'];
$no_sparepart = $_POST['no_sparepart'];
$referensi = $_POST['referensi'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];
$satuan = $_POST['satuan'];
$keterangan = $_POST['keterangan'];



		$query3 = mysqli_query($koneksi,"UPDATE list_sparepart SET referensi = '$referensi' , nama_sparepart = '$nama_sparepart' , harga = '$harga' , stok = '$stok' , satuan = '$satuan' ,keterangan = '$keterangan' WHERE no_sparepart = '$no_sparepart'");


	
		echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VInventorySparepart';</script>";exit;



  ?>