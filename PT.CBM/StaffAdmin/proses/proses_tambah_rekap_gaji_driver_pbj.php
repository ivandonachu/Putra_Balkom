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
    $rit_semen = $_POST['rit_semen'];
    $upah_semen = $_POST['upah_semen'];
    $rit_batu = $_POST['rit_batu'];
    $upah_batu = $_POST['upah_batu'];
    $bon = $_POST['bon'];
    $bpjs_ketenagakerjaan = $_POST['bpjs_ketenagakerjaan'];
    $bpjs_kesehatan = $_POST['bpjs_kesehatan'];

    $total_gaji = $upah_semen + $upah_batu;
    if($nama_driver == 'WAYAN ARDANA'){
        $total_gaji_diterima =  $upah_semen + $upah_batu - $bon - $bpjs_ketenagakerjaan - $bpjs_kesehatan;
    }
    else{
        $total_gaji_diterima =  $upah_semen + $upah_batu - $bon - $bpjs_ketenagakerjaan - $bpjs_kesehatan;
    }

    $keterangan = $_POST['keterangan'];

    $query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_driver_pbj VALUES('','$tanggal','$nama_driver','$rit_semen','$upah_semen','$rit_batu','$upah_batu','$bon','$bpjs_ketenagakerjaan','$bpjs_kesehatan','$total_gaji',
    '$total_gaji_diterima','Transfer')");




if ($query != "") {
	echo "<script>alert('Proses Rekap Gaji Berhasil :)'); window.location='../view/VRekapGajiDriverPBJ?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>