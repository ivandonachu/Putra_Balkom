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


$table = mysqli_query($koneksi, "SELECT * FROM list_gaji_driver_cbm");
$tanggal =$_POST['tanggal'];

while($data2 = mysqli_fetch_array($table)){

    $nama_driver =$data2['nama_driver'];
    $jabatan = $data2['jabatan'];
    $rit_nje = $data2['rit_nje'];
    $upah_nje = 100000 * $rit_nje;
    $rit_gas_palembang = $data2['rit_gas_palembang'];
    $upah_gas_palembang = 150000 * $rit_gas_palembang;
    $bpjs_kesehatan = $data2['bpjs_kesehatan'];
    $bpjs_ketenagakerjaan = $data2['bpjs_ketenagakerjaan'];
    $angsuran_bon_bulanan = $data2['angsuran_bon_bulanan'];
    $total_gaji = $upah_nje + $upah_gas_palembang + $bpjs_kesehatan + $bpjs_ketenagakerjaan;
    $total_gaji_diterima =  $upah_nje + $upah_gas_palembang ;
    $keterangan = $data2['keterangan'];

$query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_driver_cbm VALUES('','$tanggal','$nama_driver','$jabatan','$rit_nje','$upah_nje','$rit_gas_palembang','$upah_gas_palembang','$bpjs_kesehatan','$bpjs_ketenagakerjaan','$angsuran_bon_bulanan','$total_gaji',
                                                                        '$total_gaji_diterima','$keterangan')");

}

if ($query != "") {
	echo "<script>alert('Proses Rekap Gaji Berhasil :)'); window.location='../view/VRekapGajiDriverCBM';</script>";exit;

}

?>