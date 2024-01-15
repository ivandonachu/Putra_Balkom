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
if ($jabatan_valid == 'Staff Admin') {

}

else{  header("Location: logout.php");
exit;
}
$no_driver = $_POST['no_driver'];
$bpjs_kesehatan = $_POST['bpjs_kesehatan'];
$bpjs_ketenagakerjaan = $_POST['bpjs_ketenagakerjaan'];

	
			$query = mysqli_query($koneksipbj,"UPDATE driver_semen SET  bpjs_kesehatan = '$bpjs_kesehatan', bpjs_ketenagakerjaan = '$bpjs_ketenagakerjaan' WHERE no_driver = '$no_driver'");


if ($query != "") {
	echo "<script>alert('Edit Berhasil :)'); window.location='../view/VBPJSDriver';</script>";exit;

}

?>