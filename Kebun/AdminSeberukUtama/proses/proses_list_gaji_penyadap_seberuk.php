
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

    $nama_penyadap =$_POST['nama_penyadap'];
    $hasil_kotor = $_POST['hasil_kotor'];
    $pembagi = $_POST['pembagi'];
    $harga_gaji = $_POST['harga_gaji'];


$query = mysqli_query($koneksi,"INSERT INTO list_gaji_penyadap_seberuk VALUES('','$nama_penyadap','$hasil_kotor','$pembagi','$harga_gaji')");


if ($query != "") {
	echo "<script>alert('Proses Tambah Data Berhasil :)'); window.location='../view/VListGajiPenyadap';</script>";exit;

}

?>