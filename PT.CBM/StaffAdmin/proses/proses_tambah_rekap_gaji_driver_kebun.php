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

$tanggal =$_POST['tanggal'];


    $tanggal_awal = $_GET['tanggal1'];
    $tanggal_akhir = $_GET['tanggal2'];
    $nama_driver =$_POST['nama_driver'];
    $jabatan = $_POST['jabatan'];
    $rit_muat_sawit_dabuk = $_POST['rit_muat_sawit_dabuk'];
    $upah_muat_sawit_dabuk = $rit_muat_sawit_dabuk * 200000;
    $rit_muat_getah_palembang = $_POST['rit_muat_getah_palembang'];
    $upah_muat_getah_palembang = $rit_muat_getah_palembang * 150000;
    $rit_muat_pupuk_ke_gudang = $_POST['rit_muat_pupuk_ke_gudang'];
    $upah_muat_pupuk_ke_gudang = $rit_muat_pupuk_ke_gudang * 100000;
    $rit_muat_nipah = $_POST['rit_muat_nipah'];
    $upah_muat_nipah = $rit_muat_nipah * 250000;
    $rit_kampas_pupuk_kebun_lengkiti = $_POST['rit_kampas_pupuk_kebun_lengkiti'];
    $upah_kampas_pupuk_kebun_lengkiti = $rit_kampas_pupuk_kebun_lengkiti * 100000;
    $rit_muat_batu = $_POST['rit_muat_batu'];
    $upah_muat_batu = $upah_muat_batu * 100000;
    $total_gaji = $upah_muat_sawit_dabuk + $upah_muat_getah_palembang + $upah_muat_pupuk_ke_gudang + $upah_muat_nipah + $upah_kampas_pupuk_kebun_lengkiti + $upah_muat_batu;
    $total_gaji_diterima = $upah_muat_sawit_dabuk + $upah_muat_getah_palembang + $upah_muat_pupuk_ke_gudang + $upah_muat_nipah + $upah_kampas_pupuk_kebun_lengkiti + $upah_muat_batu;
    $keterangan = $_POST['keterangan'];
    $hutang_pribadi = $_POST['hutang_pribadi'];
$query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_driver_kebun VALUES('','$tanggal','$nama_driver','$jabatan','$rit_muat_sawit_dabuk','$upah_muat_sawit_dabuk','$rit_muat_getah_palembang','$upah_muat_getah_palembang','$rit_muat_pupuk_ke_gudang','$upah_muat_pupuk_ke_gudang',
                                                                        '$rit_muat_nipah','$upah_muat_nipah','$rit_kampas_pupuk_kebun_lengkiti','$upah_kampas_pupuk_kebun_lengkiti','$rit_muat_batu','$upah_muat_batu','$hutang_pribadi','$total_gaji','$total_gaji_diterima','$keterangan')");



if ($query != "") {
	echo "<script>alert('Proses Rekap Gaji Berhasil :)'); window.location='../view/VRekapGajiDriverKebun?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
    
	

}

?>