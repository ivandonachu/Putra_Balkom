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
if ($jabatan_valid == 'Staff HRD') {

}

else{  header("Location: logout.php");
exit;
}


          $nik_pk =$_POST['nik_pk'];
          $nama_karyawan =$_POST['nama_karyawan'];
          $perusahaan =$_POST['perusahaan'];
          $jabatan = $_POST['jabatan'];
          $tempat_lahir =$_POST['tempat_lahir'];
          $tanggal_lahir =$_POST['tanggal_lahir'];
          $nik =$_POST['nik'];
          $alamat =$_POST['alamat'];
          $no_hp =$_POST['no_hp'];          
          $status_karyawan =$_POST['status_karyawan'];






	$query3 = mysqli_query($koneksi,"UPDATE seluruh_karyawan SET nama_karyawan = '$nama_karyawan' ,perusahaan = '$perusahaan', jabatan = '$jabatan', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', 
                                                                 nik = '$nik', alamat = '$alamat', no_hp = '$no_hp', status_karyawan = '$status_karyawan' WHERE nik = '$nik_pk'");

		if ($query3!= "") {
			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VSeluruhKaryawan.php';</script>";exit;
}

  ?>