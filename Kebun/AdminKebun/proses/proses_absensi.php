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


if (isset($_POST['nama_karyawan'])) {
    $nama_karyawan = $_POST['nama_karyawan']; 
	$potongan_bon = $_POST['potongan_bon'];
	$tanggal = $_POST['tanggal'];

	
$result2 = mysqli_query($koneksi, "SELECT * FROM absensi_lengkiti WHERE nama_karyawan = '$nama_karyawan' AND tanggal = '$tanggal' ");
if(mysqli_num_rows($result2) == 1 ){
	 echo "<script>alert('Nama sudah tercatat :)'); window.location='../view/VLAbsensiL?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>"; exit;
	 }


	$result = mysqli_query($koneksi, "SELECT * FROM karyawan_lengkiti WHERE nama_karyawan = '$nama_karyawan' ");
	$data_perta = mysqli_fetch_array($result);
	$upah_kerja = $data_perta['upah_kerja'];

	$query = mysqli_query($koneksi,"INSERT INTO absensi_lengkiti VALUES ('','$tanggal','$nama_karyawan',1,'$upah_kerja','$potongan_bon')");

	
	if ($query != "") {
	echo "<script> window.location='../view/VLAbsensiL?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		   }

} 

else {
    $tanggal = $_POST['tanggal'];

	

$result = mysqli_query($koneksi, "SELECT * FROM karyawan_lengkiti ORDER BY no_karyawan ASC ");

while($data = mysqli_fetch_array($result)){
	$nama_karyawan = $data['nama_karyawan'];
	$result2 = mysqli_query($koneksi, "SELECT * FROM absensi_lengkiti WHERE nama_karyawan = '$nama_karyawan' AND tanggal = '$tanggal' ");
	if(mysqli_num_rows($result2) == 1 ){
		 echo "<script>alert('Nama sudah tercatat :)'); window.location='../view/VLAbsensiL?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>"; exit;
		 }

}

$result3 = mysqli_query($koneksi, "SELECT * FROM karyawan_lengkiti ORDER BY no_karyawan ASC ");
while($data = mysqli_fetch_array($result3)){

	$upah_kerja = $data['upah_kerja'];
	$nama_karyawan = $data['nama_karyawan'];
	

	$query = mysqli_query($koneksi,"INSERT INTO absensi_lengkiti VALUES ('','$tanggal','$nama_karyawan',1,'$upah_kerja','0')");

}

	
		
	  
			
		echo "<script> window.location='../view/VLAbsensiL?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		   
} 


     
		
