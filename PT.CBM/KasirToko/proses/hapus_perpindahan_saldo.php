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

$no_pindah = $_POST['no_pindah'];
$nama_rekening1 = $_POST['nama_rekening1'];
$nama_rekening2 = $_POST['nama_rekening2'];
$jumlah_pindah = $_POST['jumlah_pindah'];
		$result = mysqli_query($koneksi, "SELECT * FROM rekening WHERE nama_rekening = '$nama_rekening1' ");
		$data_rekening = mysqli_fetch_array($result);
		$no_rekening1 = $data_rekening['no_rekening'];

		$result2 = mysqli_query($koneksi, "SELECT * FROM rekening WHERE nama_rekening = '$nama_rekening2' ");
		$data_rekening2 = mysqli_fetch_array($result2);
		$no_rekening2 = $data_rekening2['no_rekening'];


		//Hapus pencatatan perpidahan saldo
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_perpindahan_saldo WHERE no_pindah = '$no_pindah'");

		//rekening dipidahkan
			$akses_saldo1 = mysqli_query($koneksi, "SELECT * FROM rekening WHERE no_rekening = '$no_rekening1'");
			$data_saldo1 = mysqli_fetch_array($akses_saldo1);
			$jumlah_rekening1 = $data_saldo1['jumlah'];
			$jumlah_rekening1_new = $jumlah_rekening1 + $jumlah_pindah;

			$query1= mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_rekening1_new' WHERE no_rekening = '$no_rekening1' ");

			//rekening tujuan
			$akses_saldo2 = mysqli_query($koneksi, "SELECT * FROM rekening WHERE no_rekening = '$no_rekening2'");
			$data_saldo2 = mysqli_fetch_array($akses_saldo2);
			$jumlah_rekening2 = $data_saldo2['jumlah'];
			$jumlah_rekening2_new = $jumlah_rekening2 - $jumlah_pindah;

			$query2 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_rekening2_new' WHERE no_rekening = '$no_rekening2' ");

			echo "<script> window.location='../view/VPerpindahanSaldo';</script>";exit;
		