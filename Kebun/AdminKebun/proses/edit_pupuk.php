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
if ($jabatan_valid == 'Admin Kebun') {

}

else{  header("Location: logout.php");
exit;
}

$no_laporan = $_POST['no_laporan'];
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$tanggal = $_POST['tanggal'];
$akun = $_POST['akun'];
$nama_pupuk = $_POST['nama_pupuk'];
$jumlah = $_POST['jumlah'];
$keterangan = $_POST['keterangan'];

if($akun == 'Stok Masuk'){
    $jumlah_masuk = $jumlah;
    $jumlah_keluar = 0;
}
else{
    $jumlah_masuk = 0;
    $jumlah_keluar = $jumlah;
}




	
			$query3 = mysqli_query($koneksi,"UPDATE stok_pupuk SET tanggal = '$tanggal' , nama_pupuk = '$nama_pupuk' , nama_akun = '$akun' , jumlah_masuk = '$jumlah_masuk' , 
                                            jumlah_keluar = '$jumlah_keluar', keterangan = '$keterangan'  WHERE no_laporan = '$no_laporan'");


	

echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VLPupuk?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

?>