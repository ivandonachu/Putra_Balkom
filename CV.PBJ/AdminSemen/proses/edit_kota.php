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
if ($jabatan_valid == 'Admin Semen') {

}

else{  header("Location: logout.php");
exit;
}
$no = $_POST['no'];
$nama_kota = $_POST['nama_kota'];
$tarif_pranko = $_POST['tarif_pranko'];





	

		$query = mysqli_query($koneksi,"UPDATE list_kota_l SET  nama_kota = '$nama_kota', tarif_pranko = '$tarif_pranko'   WHERE no_kota = '$no' ");
	
	
			echo "<script>alert('Update Data Berhasil :)'); window.location='../view/VListKota';</script>";exit;



  ?>