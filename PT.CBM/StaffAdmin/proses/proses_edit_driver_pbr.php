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
$id_driver = $_POST['id_driver'];
$bpjs_kesehatan = $_POST['bpjs_kesehatan'];
$bpjs_ketenagakerjaan = $_POST['bpjs_ketenagakerjaan'];

	
			$query = mysqli_query($koneksipbr,"UPDATE driver SET  bpjs_kesehatan = '$bpjs_kesehatan', bpjs_ketenagakerjaan = '$bpjs_ketenagakerjaan' WHERE id_driver = '$id_driver'");


if ($query != "") {
	echo "<script>alert('Edit Berhasil :)'); window.location='../view/VBPJSDriver';</script>";exit;

}

?>