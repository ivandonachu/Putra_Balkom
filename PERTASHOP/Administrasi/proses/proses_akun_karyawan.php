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

$username = strtolower(stripcslashes($_POST['username']));
$password = ($_POST['password']);
$password2 = ($_POST['password2']);
$nama_karyawan = $_POST['nama_karyawan'];
$lokasi = $_POST['lokasi'];
$kode_perta = $_POST['kode_perta'];




	$result = mysqli_query($koneksi,"SELECT username FROM akun_perta WHERE username='$username'");

if(mysqli_fetch_assoc($result)){
	echo "<script>
		alert('username sudah di terdaftar !'); window.location='../view/VAkunKaryawan'; </script>";
			return false;
}

if ($password !== $password2) {
echo "<script>
		alert('password anda tidak sama !'); window.location='../view/VAkunKaryawan';</script>";
return false;
}

$password = password_hash($password, PASSWORD_DEFAULT);
$query = mysqli_query ($koneksi,"INSERT INTO akun_perta VALUES('','$lokasi','$nama_karyawan','$username','$password','$kode_perta')");

if ($query!= "") {
echo "<script>
		alert('ANDA TELAH MEMBUAT AKUN KARYAWAN PERTASHOP !'); window.location='../view/VAkunKaryawan';</script>";
}
		


  ?>