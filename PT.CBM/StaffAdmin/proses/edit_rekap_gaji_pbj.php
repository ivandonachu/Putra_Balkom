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
$no_riwayat = $_POST['no_riwayat'];
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
$absen_terlambat = $_POST['absen_terlambat'];
$insentif = $_POST['insentif'];
$potongan_bon = $_POST['potongan_bon'];

$total_gaji = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 + $insentif;
if($nama_karyawan == 'Made Dani Asmara'  ){
    $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 + $insentif - ($potongan_absen + $potongan_bon + $bpjs_ketenagakerjaan + $absen_terlambat);

}
else if($total_gaji >= 3400000){
    $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 + $insentif - ($potongan_absen + $potongan_bon + $bpjs_ketenagakerjaan + $bpjs_kesehatan + $absen_terlambat);
}
else if($total_gaji < 3400000 ){
    $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 + $insentif - ($potongan_absen + $potongan_bon + $bpjs_ketenagakerjaan + $absen_terlambat);

}

$keterangan = $_POST['keterangan'];



$query = mysqli_query($koneksi,"UPDATE rekap_gaji_pbj SET    tanggal = '$tanggal' ,nama_karyawan = '$nama_karyawan', jabatan = '$jabatan' , gaji_pokok = '$gaji_pokok' , tunjangan_jabatan = '$tunjangan_jabatan' , tunjangan_akomodasi = '$tunjangan_akomodasi' , 
                                                             uang_makan = '$uang_makan', bpjs_ketenagakerjaan = '$bpjs_ketenagakerjaan', bpjs_kesehatan = '$bpjs_kesehatan', lembur = '$lembur', premi_kehadiran = '$premi_kehadiran' , bonus_1 = '$bonus_1' , bonus_2 = '$bonus_2' 
                                                             , bonus_3 = '$bonus_3', absen_terlambat = '$absen_terlambat', insentif = '$insentif', potongan_absen = '$potongan_absen', angsuran_pinjaman = '$angsuran_pinjaman', potongan_bon = '$potongan_bon' , total_gaji = '$total_gaji' , total_gaji_diterima = '$total_gaji_diterima'
                                                             , keterangan = '$keterangan' WHERE no_riwayat = '$no_riwayat'");


if ($query != "") {

    echo "<script>alert('Data Berhasil di Ubah :)'); window.location='../view/VRekapGajiPBJ?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>