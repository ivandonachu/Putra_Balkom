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

$tanggal = $_POST['tanggal'];
$saldo_dipindah = $_POST['saldo_dipindah'];
$saldo_tujuan = $_POST['saldo_tujuan'];
$jumlah = $_POST['jumlah'];
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

		move_uploaded_file($tmp_name, '../file_toko/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}

		$result = mysqli_query($koneksi, "SELECT * FROM rekening WHERE nama_rekening = '$saldo_dipindah' ");
		$data_rekening = mysqli_fetch_array($result);
		$no_rekening1 = $data_rekening['no_rekening'];

		$result2 = mysqli_query($koneksi, "SELECT * FROM rekening WHERE nama_rekening = '$saldo_tujuan' ");
		$data_rekening2 = mysqli_fetch_array($result2);
		$no_rekening2 = $data_rekening2['no_rekening'];

		//pencatatan perpidahan saldo
		
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_saldo VALUES ('','$tanggal','$id1','$no_rekening1','$no_rekening2','$jumlah','$keterangan','$file')");

		//rekening dipidahkan
			$akses_saldo1 = mysqli_query($koneksi, "SELECT * FROM rekening WHERE no_rekening = '$no_rekening1'");
			$data_saldo1 = mysqli_fetch_array($akses_saldo1);
			$jumlah_rekening1 = $data_saldo1['jumlah'];
			$jumlah_rekening1_new = $jumlah_rekening1 - $jumlah;

			$query1= mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_rekening1_new' WHERE no_rekening = '$no_rekening1' ");

			//rekening tujuan
			$akses_saldo2 = mysqli_query($koneksi, "SELECT * FROM rekening WHERE no_rekening = '$no_rekening2'");
			$data_saldo2 = mysqli_fetch_array($akses_saldo2);
			$jumlah_rekening2 = $data_saldo2['jumlah'];
			$jumlah_rekening2_new = $jumlah_rekening2 + $jumlah;

			$query2 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_rekening2_new' WHERE no_rekening = '$no_rekening2' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanSaldo';</script>";exit;
			}

