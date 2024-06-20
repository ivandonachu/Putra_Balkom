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
    $insentif = $_POST['insentif'];
    $potongan_bon = $_POST['potongan_bon'];
    $total_gaji = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 + $insentif ;
    if($mama_karyawan == 'Made Dani Asmara'  ){
        $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 + $insentif  - ($potongan_absen + $potongan_bon + $bpjs_ketenagakerjaan);

    }
    else if($total_gaji >= 3400000){
        $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 + $insentif  - ($potongan_absen + $potongan_bon + $bpjs_ketenagakerjaan + $bpjs_kesehatan);
    }
    else if($total_gaji < 3400000 ){
        $total_gaji_diterima = $gaji_pokok + $tunjangan_jabatan + $tunjangan_akomodasi + $uang_makan + $premi_kehadiran + $lembur + $bonus_1 + $bonus_2 + $bonus_3 + $insentif  - ($potongan_absen + $potongan_bon + $bpjs_ketenagakerjaan);

    }
    
    $keterangan = $_POST['keterangan'];

$query = mysqli_query($koneksi,"INSERT INTO list_gaji_pbj VALUES('','$nama_karyawan','$jabatan','$gaji_pokok','$tunjangan_jabatan','$tunjangan_akomodasi','$uang_makan','$bpjs_ketenagakerjaan','$bpjs_kesehatan','$lembur','$premi_kehadiran'
                                                                    ,'$bonus_1','$bonus_2','$bonus_3','$insentif','$potongan_absen','$angsuran_pinjaman','$potongan_bon','$total_gaji','$total_gaji_diterima','$keterangan')");


if ($query != "") {
	echo "<script>alert('Proses Tambah Data Berhasil :)'); window.location='../view/VListGajiPBJ';</script>";exit;

}

?>