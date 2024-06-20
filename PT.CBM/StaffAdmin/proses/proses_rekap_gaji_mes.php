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

$table = mysqli_query($koneksi, "SELECT * FROM list_gaji_mes");
$tanggal =$_POST['tanggal'];

while($data2 = mysqli_fetch_array($table)){

    $nama_karyawan =$data2['nama_karyawan'];
    $jabatan = $data2['jabatan'];
    $gaji_pokok = $data2['gaji_pokok'];
    $tunjangan_jabatan = $data2['tunjangan_jabatan'];
    $tunjangan_operasional = $data2['tunjangan_operasional'];
    $bpjs_kesehatan = $data2['bpjs_kesehatan'];
    $bpjs_ketenagakerjaan = $data2['bpjs_ketenagakerjaan'];
    $uang_makan_bulan = $data2['uang_makan_bulan'];
    $fee_kehadiran = $data2['fee_kehadiran'];
    $lembur = $data2['lembur'];
    $absen_terlambat = $data2['absen_terlambat'];
    $denda_absen = $data2['denda_absen'];
    $table5 = mysqli_query($koneksipbr, "SELECT SUM(jumlah_bon) AS total_bon FROM bon_karyawan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'MES' AND nama_karyawan = '$nama_karyawan' ");
    $data5 = mysqli_fetch_array($table5);
    if (!isset($data5['total_bon'])) {
        $angsuran_bon_bulanan = 0;
      }
      else{
        $angsuran_bon_bulanan = $data5['total_bon'];
      }
    $bonus = $data2['bonus'];
    $insentif = $data2['insentif'];
    if($nama_karyawan == 'Septian Andriansyah' ){
        $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus - $bpjs_kesehatan - $bpjs_ketenagakerjaan;
        $total_gaji = $gaji_pokok + $tunjangan_jabatan + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus +$insentif ;
    }
    else{
        $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus - $bpjs_ketenagakerjaan;
        $total_gaji = $gaji_pokok + $tunjangan_jabatan + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus + $insentif;
    }
    $keterangan = $data2['keterangan'];

$query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_mes VALUES('','$tanggal','$nama_karyawan','$jabatan','$gaji_pokok','$tunjangan_jabatan','$tunjangan_operasional','$bpjs_kesehatan','$bpjs_ketenagakerjaan','$uang_makan_bulan','$fee_kehadiran','$lembur'
                                                                    ,'$absen_terlambat','$denda_absen','$angsuran_bon_bulanan','$bonus','$insentif','$total_gaji','$total_gaji_diterima','$keterangan')");

}

if ($query != "") {
	echo "<script>alert('Proses Rekap Gaji Berhasil :)'); window.location='../view/VRekapGajiMES';</script>";exit;

}

?>