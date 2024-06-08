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
$jt = $_POST['jt'];
$hrg_bbm = $_POST['hrg_bbm'];
$kl5 = $_POST['kl5'];




	

		$query = mysqli_query($koneksi,"UPDATE master_tarif_spbu SET supply_point = '$supply_point' , jt = '$jt' , hrg_bbm = '$hrg_bbm' , kl5 = '$kl5'  WHERE delivery_point = '$delivery_point'");
	
	
			echo "<script>alert('Update Data Berhasil :)'); window.location='../view/VMasterTarifL8';</script>";exit;



  ?>