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
if ($jabatan_valid == 'Kasir') {

}

else{  header("Location: logout.php");
exit;
}
$no = $_POST['no'];
$nm_perusahaan = $_POST['nm_perusahaan'];
$nm_lokasi = $_POST['nm_lokasi'];
$jarak = $_POST['jarak'];
$harga = $_POST['harga'];
$uj = $_POST['uj'];
$gaji = $_POST['gaji'];






	

		$query = mysqli_query($koneksi,"UPDATE lokasi_kirim SET nm_perusahaan = '$nm_perusahaan' , nm_lokasi = '$nm_lokasi' , jarak = '$jarak' , harga = '$harga' , uj = '$uj' , gaji = '$gaji'  WHERE no_lokasi = '$no'");
	
	
			echo "<script>alert('Update Data Berhasil :)'); window.location='../view/VLokasiKirim';</script>";exit;



  ?>