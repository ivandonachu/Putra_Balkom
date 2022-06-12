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
if ($jabatan_valid == 'Administrasi') {

}

else{  header("Location: logout.php");
exit;
}

$no_polisi = $_POST['no_polisi'];
$nm_pt = $_POST['nm_pt'];

$result = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE no_polisi = '$no_polisi'  ");
 if(mysqli_num_rows($result) == 1 ){
  	echo "<script>alert('Kendaraan Sudah Tercatat :)'); window.location='../view/VKendaraan';</script>"; exit;
      }



	$query = mysqli_query($koneksi,"INSERT INTO kendaraan VALUES('','$no_polisi','$nm_pt')");

			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VKendaraan';</script>";exit;

}

  ?>