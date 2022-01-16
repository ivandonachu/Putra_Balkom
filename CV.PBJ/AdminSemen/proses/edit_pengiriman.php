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

$no_pengiriman = $_POST['no_pengiriman'];
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$tanggal_antar = $_POST['tanggal_antar'];
$driver = $_POST['driver'];
$no_polisi = $_POST['no_polisi'];
$no_do = $_POST['no_do'];
$toko_do = $_POST['toko_do'];
$uj = $_POST['uj'];
$ug = $_POST['ug'];
$om = $_POST['om'];
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

		move_uploaded_file($tmp_name, '../file_semen/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}

	$result = mysqli_query($koneksi, "SELECT * FROM pengiriman_sl WHERE no_pengiriman = '$no_pengiriman' ");
	$data_perta = mysqli_fetch_array($result);
	$no_penjualan = $data_perta['no_penjualan'];



	if ($file == '') {
			$query3 = mysqli_query($koneksi,"UPDATE pengiriman_sl SET tanggal_antar = '$tanggal_antar', no_do = '$no_do', driver = '$driver', no_polisi = '$no_polisi', 
			toko_do = '$toko_do', uj = '$uj', ug = '$ug', om = '$om', tanggal_gaji = '$tanggal_gaji', tanggal_nota = '$tanggal_nota', keterangan = '$keterangan' WHERE no_pengiriman = '$no_pengiriman'");

			$query4 = mysqli_query($koneksi,"UPDATE penjualan_sl SET  no_do = '$no_do' , driver = '$driver' ,no_polisi = '$no_polisi' , 
			toko_do = '$toko_do' WHERE no_penjualan = '$no_penjualan'");

	}
	else{
			$query3 = mysqli_query($koneksi,"UPDATE pengiriman_sl SET tanggal_antar = '$tanggal_antar', no_do = '$no_do', driver = '$driver', no_polisi = '$no_polisi',
			toko_do = '$toko_do', uj = '$uj', ug = '$ug', om = '$om', tanggal_gaji = '$tanggal_gaji', tanggal_nota = '$tanggal_nota', keterangan = '$keterangan', file_bukti = '$file'  WHERE no_pengiriman = '$no_pengiriman'");

			$query4 = mysqli_query($koneksi,"UPDATE penjualan_sl SET no_do = '$no_do' , driver = '$driver' ,no_polisi = '$no_polisi' , 
			toko_do = '$toko_do' WHERE no_penjualan = '$no_penjualan'");
	}


	echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VPengiriman?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

?>