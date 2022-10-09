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
if ($jabatan_valid == 'Staff HRD') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal = date('Y-m-d');
$nm_asset = $_POST['nm_asset'];
$pengguna = $_POST['pengguna'];
$referensi = $_POST['referensi'];
$jumlah = $_POST['jumlah'];
$keterangan = $_POST['keterangan'];
$no_aset = $_POST['no_aset'];
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

		move_uploaded_file($tmp_name, '../../StaffAdmin/file_staff_admin/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}
if ($file == '') {
	$query3 = mysqli_query($koneksi,"UPDATE aset SET tanggal = '$tanggal' , nama_asset = '$nm_asset' , jumlah = '$jumlah' , pengguna = '$pengguna' , referensi = '$referensi' , keterangan = '$keterangan' WHERE no_aset = '$no_aset'");
}
else{
	$query3 = mysqli_query($koneksi,"UPDATE aset SET tanggal = '$tanggal' , nama_asset = '$nm_asset' , jumlah = '$jumlah' , pengguna = '$pengguna' , referensi = '$referensi' , keterangan = '$keterangan' , file_bukti = '$file' WHERE no_aset = '$no_aset'");
}

	


			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VAset';</script>";exit;



  ?>