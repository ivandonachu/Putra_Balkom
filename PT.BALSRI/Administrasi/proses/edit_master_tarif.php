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
$cluster = $_POST['cluster'];
$alamat = $_POST['alamat'];
$jt = $_POST['jt'];
$hrg_bbm = $_POST['hrg_bbm'];
$kl1 = $_POST['kl1'];
$kl2 = $_POST['kl2'];
$kl3 = $_POST['kl3'];
$kl4 = $_POST['kl4'];
$kl5 = $_POST['kl5'];




	

		$query = mysqli_query($koneksi,"UPDATE master_tarif SET supply_point = '$supply_point' , cluster = '$cluster' , alamat = '$alamat' , jt = '$jt' , hrg_bbm = '$hrg_bbm' , kl1 = '$kl1' , kl2 = '$kl2' , kl3 = '$kl3' , kl4 = '$kl4' , kl5 = '$kl5'  WHERE delivery_point = '$delivery_point'");
	
	
			echo "<script>alert('Update Data Berhasil :)'); window.location='../view/VMasterTarif';</script>";exit;



  ?>