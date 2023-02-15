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
$alamat = $_POST['alamat'];
$delivery_point = $_POST['delivery_point'];
$jt = $_POST['jt'];
$hrg_bbm = $_POST['hrg_bbm'];
$kl1 = $_POST['kl1'];
$kl2 = $_POST['kl2'];
$kl3 = $_POST['kl3'];
$kl4 = $_POST['kl4'];
$kl5 = $_POST['kl5'];


	
$result = mysqli_query($koneksi, "SELECT * FROM master_tarif_ub WHERE delivery_point = '$delivery_point'");
if(mysqli_num_rows($result) == 1 ){
	 echo "<script>alert('Master Tasrif sudah tercatat :)'); window.location='../view/VMasterTarifUB';</script>"; exit;
	 }
	

	$query = mysqli_query($koneksi,"INSERT INTO master_tarif_ub VALUES('$supply_point','$delivery_point','$alamat','$jt','$hrg_bbm','$kl1','$kl2','$kl3','$kl4','$kl5')");

			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VMasterTarifUB';</script>";exit;

}

  ?>