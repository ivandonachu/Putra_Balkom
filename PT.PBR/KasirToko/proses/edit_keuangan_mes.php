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
$foto_profile = $data1['foto_profile'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Kasir') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_pengeluaran = $_POST['no_pengeluaran'];
$tanggal = $_POST['tanggal'];
$referensi = $_POST['referensi'];
$rekening = $_POST['rekening'];
$nama_akun = $_POST['nama_akun'];
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
	if ($file == '') {
		$query3 = mysqli_query($koneksi,"UPDATE keuangan_mes SET tanggal = '$tanggal' , referensi = '$referensi', rekening = '$rekening' , nama_akun = '$nama_akun' , keterangan = '$keterangan' , jumlah = '$jumlah'   WHERE no_pengeluaran = 
		'$no_pengeluaran'");
	}
	else{
		$query3 = mysqli_query($koneksi,"UPDATE keuangan_mes SET tanggal = '$tanggal' , referensi = '$referensi', rekening = '$rekening' , nama_akun = '$nama_akun' , keterangan = '$keterangan' , jumlah = '$jumlah' ,  file_bukti = '$file' WHERE no_pengeluaran = 
		'$no_pengeluaran'");
	}
	


			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VKeuanganMES?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;



  ?>