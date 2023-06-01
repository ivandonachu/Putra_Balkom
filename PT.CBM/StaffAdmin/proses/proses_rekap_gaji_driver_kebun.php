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


$table = mysqli_query($koneksi, "SELECT * FROM list_gaji_driver_kebun");
$tanggal =$_POST['tanggal'];

while($data2 = mysqli_fetch_array($table)){

    $nama_driver =$data2['nama_driver'];
    $jabatan = $data2['jabatan'];
    $rit_muat_sawit_dabuk = $data2['rit_muat_sawit_dabuk'];
    $upah_muat_sawit_dabuk = $rit_muat_sawit_dabuk * 200000;
    $rit_muat_getah_palembang = $data2['rit_muat_getah_palembang'];
    $upah_muat_getah_palembang = $rit_muat_getah_palembang * 150000;
    $rit_muat_pupuk_ke_gudang = $data2['rit_muat_pupuk_ke_gudang'];
    $upah_muat_pupuk_ke_gudang = $rit_muat_pupuk_ke_gudang * 100000;
    $rit_muat_nipah = $data2['rit_muat_nipah'];
    $upah_muat_nipah = $rit_muat_nipah * 250000;
    $rit_kampas_pupuk_kebun_lengkiti = $data2['rit_kampas_pupuk_kebun_lengkiti'];
    $upah_kampas_pupuk_kebun_lengkiti = $rit_kampas_pupuk_kebun_lengkiti * 100000;
    $total_gaji = $upah_muat_sawit_dabuk + $upah_muat_getah_palembang + $upah_muat_pupuk_ke_gudang + $upah_muat_nipah + $upah_kampas_pupuk_kebun_lengkiti;
    $total_gaji_diterima = $upah_muat_sawit_dabuk + $upah_muat_getah_palembang + $upah_muat_pupuk_ke_gudang + $upah_muat_nipah + $upah_kampas_pupuk_kebun_lengkiti;
    $keterangan = $data2['keterangan'];

$query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_driver_kebun VALUES('','$tanggal','$nama_driver','$jabatan','$rit_muat_sawit_dabuk','$upah_muat_sawit_dabuk','$rit_muat_getah_palembang','$upah_muat_getah_palembang','$rit_muat_pupuk_ke_gudang','$upah_muat_pupuk_ke_gudang',
                                                                        '$rit_muat_nipah','$upah_muat_nipah','$rit_kampas_pupuk_kebun_lengkiti','$upah_kampas_pupuk_kebun_lengkiti','$total_gaji','$total_gaji_diterima','$keterangan')");

}

if ($query != "") {
	echo "<script>alert('Proses Rekap Gaji Berhasil :)'); window.location='../view/VRekapGajiDriverKebun';</script>";exit;

}

?>