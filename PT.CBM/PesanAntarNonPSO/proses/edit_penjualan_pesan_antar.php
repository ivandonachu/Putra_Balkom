<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
  header("Location: logout.php");
  exit;
}
$id = $_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account WHERE id_karyawan = '$id'");
$data1 = mysqli_fetch_array($result1);
$id1 = $data1['id_karyawan'];
$foto_profile = $data1['foto_profile'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'CS Pesan Antar Non PSO') {
} else {
  header("Location: logout.php");
  exit;
}

$no_transaksi = $_POST['no_transaksi'];
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$tanggal = $_POST['tanggal'];
$area = $_POST['area'];
$nama_pembeli = $_POST['nama_pembeli'];
$alamat_pembeli = $_POST['alamat_pembeli'];
$qty_12kg = $_POST['qty_12kg'];
$harga_12kg = $_POST['harga_12kg'];
$jumlah_12kg = $qty_12kg * $harga_12kg;
$qty_55kg = $_POST['qty_55kg'];
$harga_55kg = $_POST['harga_55kg'];
$jumlah_55kg = $qty_55kg * $harga_55kg;
$tipe_pembayaran = $_POST['tipe_pembayaran'];
$keterangan = $_POST['keterangan'];
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

		move_uploaded_file($tmp_name, '../file_pesan_antar/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}



	if ($file == '') {
			$query3 = mysqli_query($koneksi,"UPDATE penjualan_pesan_antar_non_pso SET id_karyawan = '$id1' , tanggal = '$tanggal', area = '$area' , nama_pembeli = '$nama_pembeli' ,alamat_pembeli = '$alamat_pembeli' , 
		     qty_12kg = '$qty_12kg' , harga_12kg = '$harga_12kg' , jumlah_12kg = '$jumlah_12kg' , qty_55kg = '$qty_55kg' , harga_55kg = '$harga_55kg' , jumlah_55kg = '$jumlah_55kg', tipe_pembayaran = '$tipe_pembayaran' , keterangan = '$keterangan' WHERE no_transaksi = '$no_transaksi'");

	}
	else{
			$query3 = mysqli_query($koneksi,"UPDATE penjualan_pesan_antar_non_pso SET id_karyawan = '$id1' , tanggal = '$tanggal', area = '$area' , nama_pembeli = '$nama_pembeli' ,alamat_pembeli = '$alamat_pembeli' , 
			qty_12kg = '$qty_12kg' , harga_12kg = '$harga_12kg' , jumlah_12kg = '$jumlah_12kg' , qty_55kg = '$qty_55kg' , harga_55kg = '$harga_55kg' , jumlah_55kg = '$jumlah_55kg', tipe_pembayaran = '$tipe_pembayaran' , keterangan = '$keterangan' , file_bukti = '$file'  WHERE no_transaksi = '$no_transaksi'");

			
	}


	echo "<script>alert('Data Penjualan Berhasil Di Edit :)'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

?>