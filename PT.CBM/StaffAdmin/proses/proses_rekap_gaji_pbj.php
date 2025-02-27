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


$table = mysqli_query($koneksi, "SELECT * FROM list_gaji_pbj");
$tanggal =$_POST['tanggal'];

while($data2 = mysqli_fetch_array($table)){
    $nama_karyawan =$data2['nama_karyawan'];
    $jabatan = $data2['jabatan'];
    $gaji_pokok = $data2['gaji_pokok'];
    $tunjangan_jabatan = $data2['tunjangan_jabatan'];
    $tunjangan_akomodasi = $data2['tunjangan_akomodasi'];
    $tunjangan_oprasional = $data2['tunjangan_oprasional'];
    $uang_makan = $data2['uang_makan'];
    $bpjs_ketenagakerjaan = $data2['bpjs_ketenagakerjaan'];
    $bpjs_kesehatan = $data2['bpjs_kesehatan'];
    $lembur = $data2['lembur'];
    $premi_kehadiran = $data2['premi_kehadiran'];
    $bonus_1 = $data2['bonus_1'];
    $bonus_2 = $data2['bonus_2'];
    $bonus_3 = $data2['bonus_3'];
    $potongan_absen = $data2['potongan_absen'];
    $angsuran_pinjaman = $data2['angsuran_pinjaman'];
    $absen_terlambat = $data2['absen_terlambat'];
    $insentif = $data2['insentif'];
    $hutang_pribadi = $data2['hutang_pribadi'];
    $potongan_bon = $data2['potongan_bon'];
    $total_gaji = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 + $insentif + $tunjangan_oprasional;

    if($$nama_karyawan == 'Made Dani Asmara' || $nama_karyawan == 'Etty Suswantari' || $nama_karyawan == 'Wayan Jiwan Mukti' ){
        $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 + $insentif + $tunjangan_oprasional - ($potongan_absen + $potongan_bon + $bpjs_ketenagakerjaan + $bpjs_kesehatan + $absen_terlambat);
    }
    else{
        $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 + $insentif + $tunjangan_oprasional - ($potongan_absen + $potongan_bon + $bpjs_ketenagakerjaan + $absen_terlambat);

    }
       
    
    $keterangan = $data2['keterangan'];

    $query = mysqli_query($koneksi,"INSERT INTO rekap_gaji_pbj VALUES('','$tanggal','$nama_karyawan','$jabatan','$gaji_pokok','$tunjangan_jabatan','$tunjangan_akomodasi','$tunjangan_oprasional','$uang_makan','$bpjs_ketenagakerjaan','$bpjs_kesehatan','$lembur','$premi_kehadiran'
                                                                        ,'$bonus_1','$bonus_2','$bonus_3','$absen_terlambat','$insentif','$hutang_pribadi','$potongan_absen','$angsuran_pinjaman','$potongan_bon','$total_gaji','$total_gaji_diterima','$keterangan')");

}

if ($query != "") {
	echo "<script>alert('Proses Rekap Gaji Berhasil :)'); window.location='../view/VRekapGajiPBJ';</script>";exit;

}

?>