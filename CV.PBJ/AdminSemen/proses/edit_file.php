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
if ($jabatan_valid == 'Admin Semen') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_file = $_POST['no_file'];
$tanggal = $_POST['tanggal'];

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




		move_uploaded_file($tmp_name, '../../Manager/file_manager/' . $nama_file   );

		return $nama_file; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}
	if ($file == '') {
		$query3 = mysqli_query($koneksi,"UPDATE file_pbj SET tanggal = '$tanggal' ,keterangan = '$keterangan', kode_input = '$id1'   WHERE no_file = 
		'$no_file'");
	}
	else{
		$query3 = mysqli_query($koneksi,"UPDATE file_pbj SET tanggal = '$tanggal',  file_bukti = '$file' , keterangan = '$keterangan' , kode_input = '$id1' WHERE no_file = 
		'$no_file'");
	}
	


		echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VFilePBJ?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;



  ?>