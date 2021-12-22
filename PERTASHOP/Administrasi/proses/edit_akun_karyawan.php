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
if ($jabatan_valid == 'Administrasi') {

}

else{  header("Location: logout.php");
exit;
}


$id_kar_perta= $_POST['id_kar_perta'];


$password = ($_POST['password']);
$password2 = ($_POST['password2']);
$lokasi = $_POST['lokasi'];
$nama_karyawan = $_POST['nama_karyawan'];
$kode_perta = $_POST['kode_perta'];

if ($password !== $password2) {
echo "<script>
		alert('password anda tidak sama !'); window.location='../view/VAkunKaryawan';</script>";
return false;
}




	$password = password_hash($password, PASSWORD_DEFAULT);
	$query3 = mysqli_query($koneksi,"UPDATE akun_perta SET password = '$password' , nama = '$lokasi', nama_karyawan = '$nama_karyawan', kode_perta = '$kode_perta' WHERE id_kar_perta = '$id_kar_perta'");

		if ($query3!= "") {
			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VAkunKaryawan';</script>";exit;
}


  ?>