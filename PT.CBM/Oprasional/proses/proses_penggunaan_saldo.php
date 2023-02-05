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
if ($jabatan_valid == 'Kepala Oprasional') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = $_POST['tanggal'];
$referensi = $_POST['referensi'];
$akun = $_POST['akun'];
$jumlah = $_POST['jumlah'];
$rekening = $_POST['rekening'];
$keterangan = $_POST['keterangan'];
$nama_file = $_FILES['file']['name'];

if($rekening == $referensi  ){

}
else if($rekening == 'BALSRI' && $referensi == 'STE' ){

}
else if($rekening == 'CBM' && $referensi == 'Kebun Lengkiti' ){

}
else if($rekening == 'PRIBADI' && $referensi == 'Kebun Mbah' ){

}
else if($rekening == 'CBM' && $referensi == 'Kebun Mbah' ){

}
else if($rekening == 'PRIBADI' && $referensi == 'CBM' ){

}
else if($rekening == 'PRIBADI' && $referensi == 'MES' ){

}
else if($rekening == 'PRIBADI' && $referensi == 'PBR' ){

}
else if($rekening == 'CBM' && $referensi == 'Melodi Tani' ){

}
else if($rekening == 'PBJ' && $referensi == 'Kebun Mbah' ){

}
else if($rekening == 'PBR' && $referensi == 'Kebun Ranau' ){

}
else if($rekening == 'CBM' && $referensi == 'Exxa' ){

}
else{
	echo "<script>alert('Saldo dan referensi tidak sama :)');  window.location='../view/VSaldoBaru?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

if ($akun == 'Dana Masuk') {
	$status_saldo = 'Masuk';
}
else{
	$status_saldo = 'Keluar';
}


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

		move_uploaded_file($tmp_name, '../file_oprasional/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}

$query = mysqli_query($koneksi,"INSERT INTO riwayat_saldo_armada VALUES ('','$tanggal','$referensi','$akun','$rekening','$status_saldo','$jumlah','$keterangan','$file')");



			if ($query != "") {
				echo "<script> window.location='../view/VSaldoBaru?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
