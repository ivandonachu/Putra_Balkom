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

$pemilik = $_POST['pemilik'];
$delivery_point = $_POST['delivery_point'];
$koe_factor = $_POST['koe_factor'];
$sk_pola = $_POST['sk_pola'];
$tarif_pertashop = $_POST['tarif_pertashop'];
$jt = $_POST['jt'];
$hrg_bbm = $_POST['hrg_bbm'];
$kl1 = $_POST['kl1'];
$kl2 = $_POST['kl2'];
$kl3 = $_POST['kl3'];
$kl4 = $_POST['kl4'];


$result = mysqli_query($koneksi, "SELECT * FROM master_tarif_p WHERE delivery_point = '$delivery_point'");
if(mysqli_num_rows($result) == 1 ){
	 echo "<script>alert('Master Tasrif sudah tercatat :)'); window.location='../view/VMasterTarifP';</script>"; exit;
	 }
	

	$query = mysqli_query($koneksi,"INSERT INTO master_tarif_p VALUES('','$delivery_point','$pemilik','$jt','$hrg_bbm','$sk_pola','$koe_factor','$tarif_pertashop','$kl1','$kl2','$kl3','$kl4')");

			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VMasterTarifP';</script>";exit;

}

  ?>