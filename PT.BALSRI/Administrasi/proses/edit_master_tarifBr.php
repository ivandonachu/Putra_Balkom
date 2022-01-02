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
$alamat = $_POST['alamat'];
$shipto = $_POST['shipto'];
$kordinat = $_POST['kordinat'];
$jt = $_POST['jt'];
$kl1 = $_POST['kl1'];
$kl2 = $_POST['kl2'];
$kl3 = $_POST['kl3'];
$kl4 = $_POST['kl4'];
$kl5 = $_POST['kl5'];
$no = $_POST['no'];



	

		$query = mysqli_query($koneksi,"UPDATE master_tarif_br SET delivery_point = '$delivery_point', pemilik = '$pemilik' , shipto = '$shipto', kordinat = '$kordinat' , jt = '$jt' , alamat = '$alamat' , kl1 = '$kl1' , kl2 = '$kl2' , kl3 = '$kl3' , kl4 = '$kl4', kl5 = '$kl5'  WHERE no = '$no'");
	
	
			echo "<script>alert('Update Data Berhasil :)'); window.location='../view/VMasterTarifBr';</script>";exit;



  ?>