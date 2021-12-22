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

$tanggal = date('Y-m-d');
$nama_sparepart = $_POST['nama_sparepart'];
$no_sparepart = $_POST['no_sparepart'];
$referensi = $_POST['referensi'];
$harga = $_POST['harga'];
$jml_stok = $_POST['jml_stok'];
$satuan = $_POST['satuan'];
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

		move_uploaded_file($tmp_name, '../gambar/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}	

	if ($file == '') {
		$query3 = mysqli_query($koneksi,"UPDATE list_sparepart SET referensi = '$referensi' , nama_sparepart = '$nama_sparepart' , harga = '$harga' , jml_stok = '$jml_stok' , satuan = '$satuan', tanggal = '$tanggal'  WHERE no_sparepart = '$no_sparepart'");
	}
	else{
		$query3 = mysqli_query($koneksi,"UPDATE list_sparepart SET referensi = '$referensi' , nama_sparepart = '$nama_sparepart' , harga = '$harga' , jml_stok = '$jml_stok' , satuan = '$satuan', file_gambar = '$file' , tanggal = '$tanggal'  WHERE no_sparepart = '$no_sparepart'");
	}
	


		echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VInventorySparepart';</script>";exit;



  ?>