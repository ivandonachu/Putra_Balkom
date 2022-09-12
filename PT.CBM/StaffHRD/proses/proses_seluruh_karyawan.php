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


          $nama_karyawan =$_POST['nama_karyawan'];
          $perusahaan =$_POST['perusahaan'];
          $jabatan = $_POST['jabatan'];
          $tempat_lahir =$_POST['tempat_lahir'];
          $tanggal_lahir =$_POST['tanggal_lahir'];
          $nik =$_POST['nik'];
          $alamat =$_POST['alamat'];
          $no_hp =$_POST['no_hp'];          
          $status_karyawan = "Bekerja";



	$query3 = mysqli_query($koneksi,"INSERT INTO seluruh_karyawan VALUES('$nama_karyawan','$perusahaan','$jabatan','$tempat_lahir','$tanggal_lahir','$nik','$alamat','$no_hp','$status_karyawan')");

		if ($query3!= "") {
			echo "<script>alert('Tambah Data Karyawan Berhasil :)'); window.location='../view/VSeluruhKaryawan';</script>";exit;
}




  ?>