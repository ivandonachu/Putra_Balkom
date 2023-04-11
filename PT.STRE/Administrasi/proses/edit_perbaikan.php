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
if ($jabatan_valid == 'Administrasi') {

}

else{  header("Location: logout.php");
exit;
}
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_laporan = $_POST['no_laporan'];
$tanggal = $_POST['tanggal'];
$akun = $_POST['akun'];
$amt = $_POST['amt'];
$mt = $_POST['mt'];
$jml_pengeluaran = $_POST['jml_pengeluaran'];
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

		move_uploaded_file($tmp_name, '../file_administrasi/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}


	if ($file == '') {
			$query = mysqli_query($koneksi,"UPDATE riwayat_perbaikan SET  tanggal = '$tanggal', akun = '$akun' ,nama_driver = '$amt' , no_polisi = '$mt' , jml_pengeluaran = '$jml_pengeluaran' , keterangan = '$keterangan'  , kode_input = '$id1' WHERE no_laporan = '$no_laporan'");
	}
	else{
			$query = mysqli_query($koneksi,"UPDATE riwayat_perbaikan SET  tanggal = '$tanggal', akun = '$akun' ,nama_driver = '$amt' , no_polisi = '$mt' , jml_pengeluaran = '$jml_pengeluaran' , keterangan = '$keterangan' , file_bukti = '$file'  , kode_input = '$id1' WHERE no_laporan = '$no_laporan'");
	}

if ($query != "") {
	echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VCatatPerbaikan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>