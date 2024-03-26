
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

    $nama_buruh_harian =$_POST['nama_buruh_harian'];
    $hk = $_POST['hk'];
    $upah = $_POST['upah'];


$query = mysqli_query($koneksi,"INSERT INTO list_gaji_burhar_seberuk VALUES('','$nama_buruh_harian','$hk','$upah')");


if ($query != "") {
	echo "<script>alert('Proses Tambah Data Berhasil :)'); window.location='../view/VListGajiBuhar';</script>";exit;

}

?>