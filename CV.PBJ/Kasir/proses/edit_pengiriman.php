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
$no_pengiriman = $_POST['no_pengiriman'];
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$tanggal = $_POST['tanggal'];
$tanggal_keluar = $_POST['tanggal_keluar'];
$no_sjb = $_POST['no_sjb'];
$muatan = $_POST['muatan'];
$nm_perusahaan = $_POST['nm_perusahaan'];
$nm_lokasi =$_POST['nm_lokasi'];
$driver = $_POST['driver'];
$kendaraan = $_POST['kendaraan'];
$keterangan = $_POST['keterangan'];
$uj_tagihan = $_POST['uj_tagihan'];
$gaji_tagihan = $_POST['gaji_tagihan'];
$harga_tagihan = $_POST['harga_tagihan'];
$nama_file = $_FILES['file']['name'];
if ($nama_file == "") {
	$file = "";
}

else if ( $nama_file != "" ) {

	function upload(){
		$nama_file = $_FILES['file']['name'];
		$ukuran_file = $_FILES['file']['size'];
		$error = $_FILES['file']['error'];
		$tmp_name = $_FILES['file']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
		$ekstensi_file = explode(".", $nama_file);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

		move_uploaded_file($tmp_name, '../file_kasir_pbj/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}		

$result1 = mysqli_query($koneksi, "SELECT no_lokasi FROM lokasi_kirim WHERE nm_perusahaan = '$nm_perusahaan' AND nm_lokasi = '$nm_lokasi' ");
$data_lokasi = mysqli_fetch_array($result1);
$no_lokasi = $data_lokasi['no_lokasi'];
if ($no_lokasi == "") {
	echo "<script>alert('Nama Perusahaan dan Lokasi tidak Pas :)'); window.location='../view/VCatatPengiriman2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

$result2 = mysqli_query($koneksi, "SELECT no_driver FROM driver WHERE nama_driver = '$driver' ");
$data_driver = mysqli_fetch_array($result2);
$no_driver = $data_driver['no_driver'];

$result3 = mysqli_query($koneksi, "SELECT no_kendaraan FROM kendaraan WHERE no_polisi = '$kendaraan' ");
$data_ken = mysqli_fetch_array($result3);
$no_kendaraan = $data_ken['no_kendaraan'];






	if ($file == '') {
			$query3 = mysqli_query($koneksi,"UPDATE riwayat_pengiriman SET tanggal_keluar = '$tanggal_keluar' , muatan = '$muatan', no_lokasi = '$no_lokasi' , no_driver = '$no_driver' , no_kendaraan = '$no_kendaraan' , harga_tagihan = '$harga_tagihan', uj_tagihan = '$uj_tagihan', gaji_tagihan = '$gaji_tagihan' , keterangan = '$keterangan'  WHERE no_pengiriman = '$no_pengiriman'");
	}
	else{
			$query3 = mysqli_query($koneksi,"UPDATE riwayat_pengiriman SET tanggal_keluar = '$tanggal_keluar' , muatan = '$muatan', no_lokasi = '$no_lokasi' , no_driver = '$no_driver' , no_kendaraan = '$no_kendaraan' , keterangan = '$keterangan' , file_bukti = '$file'  WHERE no_pengiriman = '$no_pengiriman'");
	}


	echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VCatatPengiriman2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
