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
if ($jabatan_valid == 'Admin Mesuji') {

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
if($nama_rute == 'Muat Sawit Dabuk'){
    $uang_gaji = 200000;
}
else if($nama_rute == 'Muat Pupuk Ke Gudang'){
    $uang_gaji = 100000;
}
else if($nama_rute == 'Muat Getah Palembang'){
    $uang_gaji = 150000;
}
else if($nama_rute == 'Muat Nipah'){
    $uang_gaji = 250000;
}
else if($nama_rute == 'Muat Pupuk Kebun Lengkiti'){
    $uang_gaji = 100000;
}
else if($nama_rute == 'Muat Batu'){
    $uang_gaji = 100000;
}



	
			$query = mysqli_query($koneksi,"UPDATE laporan_rit_msj SET  tanggal = '$tanggal', nama_driver = '$nama_driver' ,nama_rute = '$nama_rute' , uang_gaji = '$uang_gaji'   WHERE no_laporan = '$no_laporan'");


if ($query != "") {
	echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VRitDriver?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>