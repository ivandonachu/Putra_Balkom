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

if ($jabatan_valid == 'KG Mesuji') {
    $kode_gudang = 'KG Mesuji';
} else if ($jabatan_valid == 'KG Way Kanan') {
    $kode_gudang = 'KG Way Kanan';
} else if ($jabatan_valid == 'KG Rantau Panjang') {
    $kode_gudang = 'KG Rantau Panjang';
} else if ($jabatan_valid == 'KG Unit 1') {
    $kode_gudang = 'KG Unit 1';
} else if ($jabatan_valid == 'KG MES') {
    $kode_gudang = 'KG MES';
} else if ($jabatan_valid == 'KG Simpang Sender') {
    $kode_gudang = 'KG Simpang Sender';
} else if ($jabatan_valid == 'KG Ruko M2') {
    $kode_gudang = 'KG Ruko M2';
} else if ($jabatan_valid == 'KG Kuto Sari') {
    $kode_gudang = 'KG Kuto Sari';
} else {
    header("Location: logout.php");
    exit;
}

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_laporan = $_POST['no_laporan'];
$tanggal = $_POST['tanggal'];
$nama_akun = $_POST['nama_akun'];
if($nama_akun == 'Uang Penjualan' || $nama_akun == 'Pemasukan Lainnya' || $nama_akun == 'Saldo Awal Bulan'){
	$status_saldo = 'Masuk';
}
else{
	$status_saldo = 'Keluar';
}
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

		move_uploaded_file($tmp_name, '../file_semen/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}
	if ($file == '') {
		$query3 = mysqli_query($koneksi,"UPDATE laporan_keuangan_gudang SET tanggal = '$tanggal' , kode_gudang = '$kode_gudang' , nama_akun = '$nama_akun' ,keterangan = '$keterangan' , status_saldo = '$status_saldo'  ,jumlah = '$jumlah'  WHERE no_laporan = 
		'$no_laporan'");
	}
	else{
		$query3 = mysqli_query($koneksi,"UPDATE laporan_keuangan_gudang SET tanggal = '$tanggal' , kode_gudang = '$kode_gudang' , nama_akun = '$nama_akun' , keterangan = '$keterangan' , status_saldo = '$status_saldo'  ,jumlah = '$jumlah' ,  file_bukti = '$file' WHERE no_laporan = 
		'$no_laporan'");
	}
	


		echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VLKeuangan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;



  ?>