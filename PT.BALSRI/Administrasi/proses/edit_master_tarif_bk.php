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


$delivery_point = $_POST['delivery_point'];
$pemilik = $_POST['pemilik'];
$jt = $_POST['jt'];
$kl1 = $_POST['kl1'];
$kl2 = $_POST['kl2'];
$kl3 = $_POST['kl3'];
$kl4 = $_POST['kl4'];
$kl5 = $_POST['kl5'];





	

		$query = mysqli_query($koneksi,"UPDATE master_tarif_bk SET pemilik = '$pemilik' , jt = '$jt', kl1 = '$kl1' , kl2 = '$kl2' , kl3 = '$kl3' , kl4 = '$kl4', kl5 = '$kl5'  WHERE delivery_point = '$delivery_point'");
	
	
			echo "<script>alert('Update Data Berhasil :)'); window.location='../view/VMasterTarifBk';</script>";exit;



  ?>