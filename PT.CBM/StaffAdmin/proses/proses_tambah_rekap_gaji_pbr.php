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
    $tunjangan_operasional = $_POST['tunjangan_operasional'];
    $bpjs_kesehatan = $_POST['bpjs_kesehatan'];
    $bpjs_ketenagakerjaan = $_POST['bpjs_ketenagakerjaan'];
    $uang_makan_bulan = $_POST['uang_makan_bulan'];
    $fee_kehadiran = $_POST['fee_kehadiran'];
    $lembur = $_POST['lembur'];
    $absen_terlambat = $_POST['absen_terlambat'];
    $denda_absen = $_POST['denda_absen'];
    $angsuran_bon_bulanan = $_POST['angsuran_bon_bulanan'];
    $bonus = $_POST['bonus'];
    if($nama_karyawan == 'Septian Andriansyah' || $nama_karyawan == 'Okta Mayasari' ){
        $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus - $bpjs_kesehatan - $bpjs_ketenagakerjaan;
        $total_gaji = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus  ;
    }
    else{
        $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus - $bpjs_ketenagakerjaan;
        $total_gaji = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus;
    }
    $keterangan = $_POST['keterangan'];

$query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_pbr VALUES('','$tanggal','$nama_karyawan','$jabatan','$gaji_pokok','$tunjangan_jabatan','$tunjangan_akomodasi','$tunjangan_operasional','$bpjs_kesehatan','$bpjs_ketenagakerjaan','$uang_makan_bulan','$fee_kehadiran','$lembur'
                                                                    ,'$absen_terlambat','$denda_absen','$angsuran_bon_bulanan','$bonus','$total_gaji','$total_gaji_diterima','$keterangan')");


if ($query != "") {

    echo "<script>alert('Proses Tambah Rekap Data Berhasil :)'); window.location='../view/VRekapGajiPBR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>