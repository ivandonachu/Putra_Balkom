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
    $tunjangan_oprasional = $data2['tunjangan_oprasional'];
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
    $total_gaji = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 + $insentif + $tunjangan_oprasional;
    if($nama_karyawan == 'Made Dani Asmara' || $nama_karyawan == 'Wayan Jiwan Mukti' || $nama_karyawan == 'Edi Sasmita' ){
        $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 + $insentif + $tunjangan_oprasional - ($potongan_absen + $potongan_bon + $bpjs_ketenagakerjaan + $bpjs_kesehatan + $absen_terlambat);
    }else if ($nama_karyawan == 'Ivanof Fernando Donachu') {
        $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 + $insentif + $tunjangan_oprasional - ($potongan_absen + $potongan_bon + $bpjs_kesehatan + $absen_terlambat);
    }
    else{
        $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 + $insentif + $tunjangan_oprasional - ($potongan_absen + $potongan_bon + $bpjs_ketenagakerjaan + $absen_terlambat);

    }
    $keterangan = $_POST['keterangan'];
    $hutang_pribadi = $_POST['hutang_pribadi'];
    $query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_pbj VALUES('','$tanggal','$nama_karyawan','$jabatan','$gaji_pokok','$tunjangan_jabatan','$tunjangan_akomodasi','$tunjangan_oprasional','$uang_makan','$bpjs_ketenagakerjaan','$bpjs_kesehatan','$lembur','$premi_kehadiran'
                                                                        ,'$bonus_1','$bonus_2','$bonus_3','$absen_terlambat','$insentif','$potongan_absen','$angsuran_pinjaman','$potongan_bon','$hutang_pribadi','$total_gaji','$total_gaji_diterima','$keterangan')");


if ($query != "") {

    echo "<script>alert('Proses Tambah Rekap Data Berhasil :)'); window.location='../view/VRekapGajiPBJ?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>