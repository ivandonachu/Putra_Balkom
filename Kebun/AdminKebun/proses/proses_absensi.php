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
if ($jabatan_valid == 'Admin Kebun') {

}

else{  header("Location: logout.php");
exit;
}


$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = $_POST['tanggal'];
$nama_karyawan = $_POST['nama_karyawan'];
$potongan_bons = $_POST['potongan_bon'];

$result = mysqli_query($koneksi, "SELECT * FROM karyawan_lengkiti WHERE nama_karyawan = '$nama_karyawan' ");
$data_perta = mysqli_fetch_array($result);
$upah_kerja = $data_perta['upah_kerja'];
	
        
    
            
            	$query = mysqli_query($koneksi,"INSERT INTO absensi_lengkiti VALUES ('','$tanggal','$nama_karyawan',1,'$upah_kerja','$potongan_bons')");
              
                	if ($query != "") {
				echo "<script> window.location='../view/VLAbsensiL?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		       	}
     
		
