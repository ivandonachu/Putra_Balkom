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
$koe_factor = $_POST['koe_factor'];
$no = $_POST['no'];
$sk_pola = $_POST['sk_pola'];
$tarif_pertashop = $_POST['tarif_pertashop'];
$jt = $_POST['jt'];
$hrg_bbm = $_POST['hrg_bbm'];
$kl1 = $_POST['kl1'];
$kl2 = $_POST['kl2'];
$kl3 = $_POST['kl3'];
$kl4 = $_POST['kl4'];




	

		$query = mysqli_query($koneksi,"UPDATE master_tarif_p SET delivery_point = '$delivery_point', pemilik = '$pemilik' , koe_factor = '$koe_factor', tarif_pertashop = '$tarif_pertashop' , jt = '$jt' , hrg_bbm = '$hrg_bbm' , kl1 = '$kl1' , kl2 = '$kl2' , kl3 = '$kl3' , kl4 = '$kl4'  WHERE no = '$no'");
	
	
			echo "<script>alert('Update Data Berhasil :)'); window.location='../view/VMasterTarifP';</script>";exit;



  ?>