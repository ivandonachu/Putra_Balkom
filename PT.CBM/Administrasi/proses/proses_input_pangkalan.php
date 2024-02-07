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



$no_reg = $_POST['no_reg'];
$sub_penyalur = $_POST['sub_penyalur'];
$type = $_POST['type'];
$pemilik = $_POST['pemilik'];
$no_hp_pemilik = $_POST['no_hp_pemilik'];
$no_ktp = $_POST['no_ktp'];
$alamat = $_POST['alamat'];
$no_kantor = $_POST['no_kantor'];
$sp_agen = $_POST['sp_agen'];
$se_lpg = $_POST['se_lpg'];
$qty_kontrak = $_POST['qty_kontrak'];
$kode_pos = $_POST['kode_pos'];
$latitude = $_POST['latitude'];
$longtitude = $_POST['longtitude'];
$status = $_POST['status'];
$tipe_pembayaran = $_POST['tipe_pembayaran'];



	$query3 = mysqli_query($koneksi,"INSERT INTO pangkalan VALUES('$no_reg','$sub_penyalur','$type','$pemilik','$no_hp_pemilik','$no_ktp','$alamat','$no_kantor','$sp_agen','$se_lpg','$qty_kontrak','$kode_pos','$latitude','$longtitude','$status','$tipe_pembayaran')");

		if ($query3!= "") {
			echo "<script>alert('Data Berhasil Di Tambah :)'); window.location='../view/VPangkalan.php';</script>";exit;
}

  ?>