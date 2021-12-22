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
if ($jabatan_valid == 'Manager') {

}

else{  header("Location: logout.php");
exit;
}


$tanggal = $_POST['tanggal'];
			
			$result = mysqli_query($koneksi, "SELECT manager FROM konfirmasi_laporan WHERE tanggal = '$tanggal'");
			$data_konfirmai1 = mysqli_fetch_array($result);
			$kasir = $data_konfirmai1['manager'];
			if ($kasir == 1) {
				echo "<script> alert('Konfirmasi pada hari ini sudah di lakukan !'); window.location='../view/DsManager';</script>";exit;
			}
			else{
				$result2 = mysqli_query($koneksi, "SELECT * FROM konfirmasi_laporan WHERE tanggal = '$tanggal'");
				if (mysqli_num_rows($result) === 1) {
					//update
					$data_konfirmai = mysqli_fetch_array($result2);
					$no_konfirmasi = $data_konfirmai['no_konfirmasi'];

					$query3 = mysqli_query($koneksi,"UPDATE konfirmasi_laporan SET manager = 1  WHERE no_konfirmasi = '$no_konfirmasi'");
					echo "<script> alert('Konfirmasi laporan berhasil !'); window.location='../view/DsManager';</script>";exit;
				}
				else{
					//input
					$query1 = mysqli_query($koneksi,"INSERT INTO konfirmasi_laporan VALUES ('','$tanggal',1,0,0)");



					if ($query1!= "") {
						echo "<script> alert('Konfirmasi laporan berhasil !'); window.location='../view/DsManager';</script>";exit;
				}
			}
				
				}
			

			