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

$no_karyawan = $_POST['no_karyawan'];
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
$insentif = $_POST['insentif'];
$hutang_pribadi = $_POST['hutang_pribadi'];
if($nama_karyawan == 'Septian Andriansyah' || $nama_karyawan == 'Okta Mayasari' || $nama_karyawan == 'Dendi Wibowo'|| $nama_karyawan == 'Dioni Saputra'|| $nama_karyawan == 'Devi Ratnasari' || $nama_karyawan == 'Nyoman Sherli' || $nama_karyawan == 'Made Sherla' ){
	$total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi  + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus + $insentif - $bpjs_kesehatan - $bpjs_ketenagakerjaan ;
	$total_gaji = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi  + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus + $insentif  ;
}
 else if( $nama_karyawan == 'Komang Riski' ){
        $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus + $insentif - $bpjs_ketenagakerjaan;
        $total_gaji = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus + $insentif ;
    }
else{
	$total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi  + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus + $insentif - $bpjs_ketenagakerjaan ;
	$total_gaji = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi  + $tunjangan_operasional + $uang_makan_bulan + $fee_kehadiran + $lembur + $bonus + $insentif ;
} 
$keterangan = $_POST['keterangan'];




	$query = mysqli_query($koneksi,"UPDATE list_gaji_cbm SET nama_karyawan = '$nama_karyawan', jabatan = '$jabatan' , gaji_pokok = '$gaji_pokok' , tunjangan_jabatan = '$tunjangan_jabatan' , tunjangan_akomodasi = '$tunjangan_akomodasi' , tunjangan_operasional = '$tunjangan_operasional' , 
                                                             bpjs_kesehatan = '$bpjs_kesehatan', bpjs_ketenagakerjaan = '$bpjs_ketenagakerjaan', uang_makan_bulan = '$uang_makan_bulan', fee_kehadiran = '$fee_kehadiran', lembur = '$lembur' , absen_terlambat = '$absen_terlambat' , denda_absen = '$denda_absen' 
                                                             , angsuran_bon_bulanan = '$angsuran_bon_bulanan' , bonus = '$bonus' , insentif = '$insentif', hutang_pribadi = '$hutang_pribadi' , total_gaji = '$total_gaji' , total_gaji_diterima = '$total_gaji_diterima' , keterangan = '$keterangan'   WHERE no_karyawan = '$no_karyawan'");


if ($query != "") {
	echo "<script>alert('Data Berhasil di Ubah :)'); window.location='../view/VListGajiCBM';</script>";exit;

}

?>