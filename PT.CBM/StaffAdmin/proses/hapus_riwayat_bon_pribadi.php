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
if ($jabatan_valid == 'Staff Admin') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_bon = $_POST['no_bon'];
$no_riwayat = $_POST['no_riwayat'];
$total_bayar = $_POST['total_bayar'];
$jumlah_bon = $_POST['jumlah_bon'];
$jumlah_bayar = $_POST['jumlah_bayar'];
$jumlah_angsuran = $_POST['jumlah_angsuran'];
$jumlah_angsuran = $jumlah_angsuran - 1;
$total_bayar = $total_bayar - $jumlah_bayar;




if ( $total_bayar > $jumlah_bon) {
	echo "<script> alert('Kembalinya Kebanyakan Gaes!'); window.location='../view/VBonPribadi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}
else if ( $total_bayar < $jumlah_bon) {
	$status_bayar = 'Belum Lunas';

		$query3 = mysqli_query($koneksi,"UPDATE bon_pribadi SET  total_bayar = '$total_bayar', jumlah_angsuran = '$jumlah_angsuran' , status_bayar = '$status_bayar'  WHERE no_bon = 
		'$no_bon'");
       mysqli_query($koneksi,"DELETE FROM riwayat_bon_pribadi WHERE no_riwayat = '$no_riwayat'");

	echo "<script> alert('Hapus Pembayaran Berhasil!'); window.location='../view/VBonPribadi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
}

else if ($total_bayar == $jumlah_bon) {
	$status_bayar = 'Lunas';

		$query3 = mysqli_query($koneksi,"UPDATE bon_pribadi SET total_bayar = '$total_bayar', jumlah_angsuran = '$jumlah_angsuran' , status_bayar = '$status_bayar'  WHERE no_bon = 
		'$no_bon'");
       mysqli_query($koneksi,"DELETE FROM riwayat_bon_pribadi WHERE no_riwayat = '$no_riwayat'");


	echo "<script> alert('Hapus Pembayaran Berhasil!'); window.location='../view/VBonPribadi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
}
	
