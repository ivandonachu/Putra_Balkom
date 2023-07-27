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
if ($jabatan_valid == 'Kasir') {

}

else{  header("Location: logout.php");
exit;
}
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_laporan = $_POST['no_laporan'];
$tanggal = $_POST['tanggal'];
$nama_driver = $_POST['nama_driver'];
$nama_rute = $_POST['nama_rute'];
if($nama_rute == 'NJE'){
    $uang_gaji = 100000;
}
else if($nama_rute == 'PEP'){
    $uang_gaji = 200000;
}


	
			$query = mysqli_query($koneksi,"UPDATE laporan_rit_pbr SET  tanggal = '$tanggal', nama_driver = '$nama_driver' ,nama_rute = '$nama_rute' , uang_gaji = '$uang_gaji'   WHERE no_laporan = '$no_laporan'");


if ($query != "") {
	echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VRitDriverPBR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>