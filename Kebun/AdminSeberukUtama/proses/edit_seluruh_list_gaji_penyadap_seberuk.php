
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
if ($jabatan_valid == 'Admin Seberuk Utama') {

}

else{  header("Location: logout.php");
exit;
}

$pembagi = $_POST['pembagi'];
$harga_gaji = $_POST['harga_gaji'];





	$query = mysqli_query($koneksi,"UPDATE list_gaji_penyadap_seberuk SET pembagi = '$pembagi' , harga_gaji = '$harga_gaji'");


if ($query != "") {
	echo "<script>alert('Data Berhasil di Ubah :)'); window.location='../view/VListGajiPenyadap';</script>";exit;

}

?>