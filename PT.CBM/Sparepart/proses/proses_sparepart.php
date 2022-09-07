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
if ($jabatan_valid == 'Admin Sparepart') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal = $_POST['tanggal'];
$aksi = $_POST['aksi'];
$jumlah = $_POST['jumlah'];
$harga = $_POST['harga'];
if($harga = ''){
	$harga = 0;
}
$stok_asli = $_POST['stok_asli'];
$no_sparepart = $_POST['no_sparepart'];
$no_polisi = $_POST['no_polisi'];
$nama_driver = $_POST['nama_driver'];


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

		move_uploaded_file($tmp_name, '../file_sparepart/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}
	$query3 = mysqli_query($koneksi,"INSERT INTO penggunaan_sparepart VALUES('','$no_sparepart','$tanggal','$no_polisi','$nama_driver','$aksi','$jumlah','$harga','$file')");

	if ($aksi == 'Pembelian' || $aksi == 'Penambahan') {
		$stok_asli_upt = $stok_asli + $jumlah;

		$query3 = mysqli_query($koneksi,"UPDATE list_sparepart SET stok = '$stok_asli_upt'  WHERE no_sparepart = '$no_sparepart'");

	}
	else{

		$stok_asli_upt = $stok_asli - $jumlah;

		$query3 = mysqli_query($koneksi,"UPDATE list_sparepart SET stok = '$stok_asli_upt'  WHERE no_sparepart = '$no_sparepart'");

	}
	var_dump($stok_asli);
	var_dump($jumlah);
	var_dump($stok_asli_upt);

		if ($query3!= "") {
		//	echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VRiwayatSparepart.php';</script>";exit;
}


  ?>