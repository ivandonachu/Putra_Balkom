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



$table = mysqli_query($koneksi, "SELECT * FROM list_gaji_penyadap_seberuk");
$tanggal =$_POST['tanggal'];

while($data2 = mysqli_fetch_array($table)){

    $nama_penyadap =$data2['nama_penyadap'];
    $berat = $data2['berat'];
    $harga_gaji = $data2['harga_gaji'];
    $total_gaji = $berat * $harga_gaji;
   

$query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_penyadap_seberuk VALUES('','$tanggal','$nama_penyadap','$berat','$harga_gaji','$total_gaji')");

}

if ($query != "") {
	echo "<script>alert('Proses Rekap Gaji Berhasil :)'); window.location='../view/VRekapGajiPenyadap';</script>";exit;

}

?>