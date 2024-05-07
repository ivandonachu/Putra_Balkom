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

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal_antar = $_POST['tanggal_antar'];
$no_penjualan = $_POST['no_penjualan'];
$driver = $_POST['driver'];
$no_polisi = $_POST['no_polisi'];
$no_do = $_POST['no_do'];
$no_so = $_POST['no_so'];
$tipe_semen = $_POST['tipe_semen'];
if($no_do == ""){
    
}

else{
$result = mysqli_query($koneksi, "SELECT * FROM pengiriman_sl WHERE no_penjualan = '$no_penjualan' ");
 if(mysqli_num_rows($result) == 1 ){
  	echo "<script>alert('Pengiriman sudah tercatat :)'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>"; exit;
      }}

$toko_do = $_POST['toko_do'];
$uj = $_POST['uj'];
$ug = $_POST['ug'];
$om = $_POST['om'];
$bs = $_POST['bs'];
$tanggal_gaji = $_POST['tanggal_gaji'];
$tanggal_nota = $_POST['tanggal_nota'];
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

		move_uploaded_file($tmp_name, '../file_admin_semen/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}


	$query = mysqli_query($koneksi,"INSERT INTO pengiriman_sl VALUES('','$no_penjualan','$tanggal_antar','$no_do','$no_so','$driver','$no_polisi','$toko_do','$tipe_semen','$uj','$ug','$om','$bs','$tanggal_gaji','$tanggal_nota','$keterangan','$file')");

			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VPengiriman?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

  ?>