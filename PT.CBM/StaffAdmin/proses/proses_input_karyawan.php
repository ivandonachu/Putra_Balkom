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


$id= $_POST['id'];
$nama_karyawan= $_POST['nama_karyawan'];
$jabatan= $_POST['jabatan'];



	$query3 = mysqli_query($koneksi,"INSERT INTO karyawan VALUES('$id','$nama_karyawan','$jabatan')");

		if ($query3!= "") {
			echo "<script>alert('Tambah Data Berhasil :)'); window.location='../view/VKaryawan.php';</script>";exit;
}




  ?>