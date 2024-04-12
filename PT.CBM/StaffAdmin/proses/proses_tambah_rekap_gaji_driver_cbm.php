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


    $tanggal_awal = $_GET['tanggal1'];
    $tanggal_akhir = $_GET['tanggal2'];
    $tanggal = $_POST['tanggal'];
    $nama_driver =$_POST['nama_driver'];
    $jabatan = $_POST['jabatan'];
    $rit_nje = $_POST['rit_nje'];
    $upah_nje = 100000 * $rit_nje;
    $rit_gas_palembang = $_POST['rit_gas_palembang'];
    $upah_gas_palembang = 150000 * $rit_gas_palembang;
    $rit_nikan = $_POST['rit_nikan'];
    $upah_nikan = 100000 * $rit_nikan;
    $rit_kota_baru = $_POST['rit_kota_baru'];
    $upah_kota_baru = 100000 * $rit_kota_baru;
    $rit_batu_marta = $_POST['rit_batu_marta'];
    $upah_batu_marta = 100000 * $rit_batu_marta;
    $rit_batu_marta = $_POST['rit_batu_marta'];
    $upah_batu_marta = 100000 * $rit_batu_marta;
    $rit_bantu_tabung_pertamina = $_POST['rit_bantu_tabung_pertamina'];
    $upah_bantu_tabung_pertamina = 100000 * $rit_bantu_tabung_pertamina;
    $rit_melati = $_POST['rit_melati'];
    $upah_melati = 100000 * $rit_melati;
    $uang_makan = $_POST['uang_makan'];
    $bpjs_kesehatan = $_POST['bpjs_kesehatan'];
    $bpjs_ketenagakerjaan = $_POST['bpjs_ketenagakerjaan'];
    $angsuran_bon_bulanan = $_POST['angsuran_bon_bulanan'];
    $total_gaji = $upah_nje + $upah_gas_palembang + $upah_nikan + $upah_kota_baru + $upah_batu_marta + $upah_bantu_tabung_pertamina  + $uang_makan + $upah_melati;
    $total_gaji_diterima =  $upah_nje + $upah_gas_palembang + $upah_nikan + $upah_kota_baru + $upah_batu_marta + $upah_melati + $uang_makan  + $upah_bantu_tabung_pertamina  - $bpjs_ketenagakerjaan;
    $keterangan = $_POST['keterangan'];

$query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_driver_cbm VALUES('','$tanggal','$nama_driver','$jabatan','$rit_nje','$upah_nje','$rit_gas_palembang','$upah_gas_palembang'
                                                                         ,'$rit_nikan','$upah_nikan','$rit_kota_baru','$upah_kota_baru','$rit_batu_marta','$upah_batu_marta', '$rit_bantu_tabung_pertamina', '$upah_bantu_tabung_pertamina'
                                                                         , '$rit_melati', '$upah_melati' ,'$uang_makan','$bpjs_kesehatan','$bpjs_ketenagakerjaan','$angsuran_bon_bulanan','$total_gaji'
                                                                         ,'$total_gaji_diterima','$keterangan')");



if ($query != "") {
	echo "<script>alert('Proses Rekap Gaji Berhasil :)'); window.location='../view/VRekapGajiDriverCBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>