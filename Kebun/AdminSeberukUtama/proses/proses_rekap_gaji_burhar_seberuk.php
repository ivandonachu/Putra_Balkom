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



$table = mysqli_query($koneksi, "SELECT * FROM list_gaji_burhar_seberuk");
$tanggal =$_POST['tanggal'];

while($data2 = mysqli_fetch_array($table)){

    $nama_buruh_harian =$data2['nama_buruh_harian'];
    $hk = $data2['hk'];
    $upah = $data2['upah'];
    $total_gaji = $upah * $hk;
   

$query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_burhar_seberuk VALUES('','$tanggal','$nama_buruh_harian','$hk','$upah','$total_gaji')");

}

if ($query != "") {
	echo "<script>alert('Proses Rekap Gaji Berhasil :)'); window.location='../view/VRekapGajiBuhar';</script>";exit;

}

?>