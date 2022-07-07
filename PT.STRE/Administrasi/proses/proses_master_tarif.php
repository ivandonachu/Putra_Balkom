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

$supply_point = $_POST['supply_point'];
$delivery_point = $_POST['delivery_point'];
$kf = $_POST['kf'];
$sk_pola = $_POST['sk_pola'];
$jt = $_POST['jt'];
$hrg_bbm = $_POST['hrg_bbm'];
$kl1 = $_POST['kl1'];
$kl2 = $_POST['kl2'];
$kl3 = $_POST['kl3'];


	
$result = mysqli_query($koneksi, "SELECT * FROM master_tarif WHERE delivery_point = '$delivery_point'");
if(mysqli_num_rows($result) == 1 ){
	 echo "<script>alert('Master Tasrif sudah tercatat :)'); window.location='../view/VMasterTarif';</script>"; exit;
	 }
	

	$query = mysqli_query($koneksi,"INSERT INTO master_tarif VALUES('$supply_point','$delivery_point','$jt','$kf','$hrg_bbm','$sk_pola','$kl1','$kl2','$kl3')");

			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VMasterTarif';</script>";exit;

}

  ?>