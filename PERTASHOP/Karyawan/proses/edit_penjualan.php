<?php
session_start();
include'koneksi.php';
if(!isset($_SESSION["login"])){
  header("Location: logout.php");
  exit;
}
$id=$_COOKIE['id_cookie'];
$result = mysqli_query($koneksi, "SELECT * FROM akun_perta a INNER JOIN pertashop b on b.kode_perta = b.kode_perta WHERE id_kar_perta = '$id'");
$data = mysqli_fetch_array($result);
$nama = $data['nama'];
$lokasi = $data['lokasi'];

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_penjualan = $_POST['no_penjualan'];
$nama_barang = $_POST['nama_barang'];
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

		move_uploaded_file($tmp_name, '../file_karyawan/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}

$result = mysqli_query($koneksi, "SELECT * FROM pertashop WHERE lokasi = '$lokasi' ");
$data_perta = mysqli_fetch_array($result);
$kode_perta = $data_perta['kode_perta'];

			
			
        if( $nama_barang == 'Pertamax'){


		
				$query3 = mysqli_query($koneksi,"UPDATE penjualan SET  file_bukti = '$file' WHERE no_penjualan = 
				'$no_penjualan'");
			
			
		
         
			echo "<script> window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			
        }
		else{

	
				$query3 = mysqli_query($koneksi,"UPDATE penjualan SET  file_bukti = '$file' WHERE no_penjualan = 
				'$no_penjualan'");
			
			
		
         
			echo "<script> window.location='../view/VPenjualanDex?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			
		}
       