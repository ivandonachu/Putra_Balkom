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
if ($jabatan_valid == 'Admin Seberuk Utama') {

}

else{  header("Location: logout.php");
exit;
}



$table = mysqli_query($koneksi, "SELECT * FROM list_gaji_seberuk");
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
    $angsuran_bon_bulanan = $data2['angsuran_bon_bulanan'];
    $bonus = $data2['bonus'];
    if($nama_karyawan == 'Septian Andriansyah' ){
        $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus - $bpjs_kesehatan - $bpjs_ketenagakerjaan;
        $total_gaji = $gaji_pokok + $tunjangan_jabatan + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus  ;
    }
    else{
        $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus - $bpjs_ketenagakerjaan;
        $total_gaji = $gaji_pokok + $tunjangan_jabatan + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus;
    }
    $keterangan = $data2['keterangan'];

$query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_seberuk VALUES('','$tanggal','$nama_karyawan','$jabatan','$gaji_pokok','$tunjangan_jabatan','$tunjangan_operasional','$bpjs_kesehatan','$bpjs_ketenagakerjaan','$uang_makan_bulan','$fee_kehadiran','$lembur'
                                                                    ,'$absen_terlambat','$denda_absen','$angsuran_bon_bulanan','$bonus','$total_gaji','$total_gaji_diterima','$keterangan')");

}

if ($query != "") {
	echo "<script>alert('Proses Rekap Gaji Berhasil :)'); window.location='../view/VRekapGaji';</script>";exit;

}

?>