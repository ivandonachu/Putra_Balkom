
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


$upah = $_POST['upah'];





	$query = mysqli_query($koneksi,"UPDATE list_gaji_burhar_seberuk SET upah = '$upah'");


if ($query != "") {
	echo "<script>alert('Data Berhasil di Ubah :)'); window.location='../view/VListGajiBuhar';</script>";exit;

}

?>