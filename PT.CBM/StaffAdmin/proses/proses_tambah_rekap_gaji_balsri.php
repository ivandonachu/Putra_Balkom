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
    $nama_karyawan =$_POST['nama_karyawan'];
    $jabatan = $_POST['jabatan'];
    $gaji_pokok = $_POST['gaji_pokok'];
    $tunjangan_jabatan = $_POST['tunjangan_jabatan'];
    $tunjangan_akomodasi = $_POST['tunjangan_akomodasi'];
    $uang_makan = $_POST['uang_makan'];
    $bpjs_ketenagakerjaan = $_POST['bpjs_ketenagakerjaan'];
    $bpjs_kesehatan = $_POST['bpjs_kesehatan'];
    $lembur = $_POST['lembur'];
    $premi_kehadiran = $_POST['premi_kehadiran'];
    $bonus_1 = $_POST['bonus_1'];
    $bonus_2 = $_POST['bonus_2'];
    $bonus_3 = $_POST['bonus_3'];
    $potongan_absen = $_POST['potongan_absen'];
    $angsuran_pinjaman = $_POST['angsuran_pinjaman'];
    $potongan_bon = $_POST['potongan_bon'];
    $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 - ($potongan_absen + $potongan_bon);
    $total_gaji = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 + $bpjs_kesehatan + $bpjs_ketenagakerjaan;
    $keterangan = $_POST['keterangan'];

$query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_balsri VALUES('','$tanggal','$nama_karyawan','$jabatan','$gaji_pokok','$tunjangan_jabatan','$tunjangan_akomodasi','$uang_makan','$bpjs_ketenagakerjaan','$bpjs_kesehatan','$lembur','$premi_kehadiran'
                                                                    ,'$bonus_1','$bonus_2','$bonus_3','$potongan_absen','$angsuran_pinjaman','$potongan_bon','$total_gaji','$total_gaji_diterima','$keterangan')");

if ($query != "") {

    echo "<script>alert('Proses Tambah Rekap Data Berhasil :)'); window.location='../view/VRekapGajiBalsri?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>