
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

$no_penyadap = $_POST['no_penyadap'];
$nama_penyadap =$_POST['nama_penyadap'];
$berat = $_POST['berat'];
$harga_gaji = $_POST['harga_gaji'];





	$query = mysqli_query($koneksi,"UPDATE list_gaji_penyadap_seberuk SET nama_penyadap = '$nama_penyadap', berat = '$berat' , harga_gaji = '$harga_gaji' WHERE no_penyadap = '$no_penyadap'");


if ($query != "") {
	echo "<script>alert('Data Berhasil di Ubah :)'); window.location='../view/VListGajiPenyadap';</script>";exit;

}

?>