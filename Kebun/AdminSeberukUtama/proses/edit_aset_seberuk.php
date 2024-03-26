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

$no_aset = $_POST['no_aset'];
$nama_aset = $_POST['nama_aset'];
$jumlah_aset = $_POST['jumlah_aset'];
$keterangan = $_POST['keterangan'];





	

		$query = mysqli_query($koneksi,"UPDATE list_aset_seberuk SET nama_aset = '$nama_aset',jumlah_aset = '$jumlah_aset',keterangan = '$keterangan' WHERE no_aset = '$no_aset'");
	
	
			echo "<script>alert('Data Berhasil Diedit'); window.location='../view/VListAsetSeberuk';</script>";exit;



  ?>