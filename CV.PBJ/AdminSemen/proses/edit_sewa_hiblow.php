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
$foto_profile = $data1['foto_profile'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Admin Semen') {

}

else{  header("Location: logout.php");
exit;
}


$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_laporan = $_POST['no_laporan'];
$tanggal_do = $_POST['tanggal_do'];
$no_do = $_POST['no_do'];
$no_kendaraan = $_POST['no_kendaraan'];
$uang_jalan = $_POST['uang_jalan'];
$tonase = $_POST['tonase'];
$harga = $_POST['harga'];
$jumlah = $tonase * $harga;



	
			$query = mysqli_query($koneksi,"UPDATE sewa_hiblow SET  tanggal_do = '$tanggal_do', no_do = '$no_do' , no_kendaraan = '$no_kendaraan' , uang_jalan = '$uang_jalan' , tonase = '$tonase', harga = '$harga', jumlah = '$jumlah'   WHERE no_laporan = '$no_laporan'");


if ($query != "") {
	echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VSewaHiBlow?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>