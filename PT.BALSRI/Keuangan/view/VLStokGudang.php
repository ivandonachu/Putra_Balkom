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
if ($jabatan_valid == 'Keuangan') {

}

else{  header("Location: logout.php");
exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];



if (isset($_GET['tanggal1'])) {
    $tanggal_awal = $_GET['tanggal1'];
    $tanggal_akhir = $_GET['tanggal2'];
    $kode_gudang = $_GET['kode_gudang'];
} elseif (isset($_POST['tanggal1'])) {
    $tanggal_awal = $_POST['tanggal1'];
    $tanggal_akhir = $_POST['tanggal2'];
    $kode_gudang = $_POST['kode_gudang'];
} else {
    $tanggal_awal = date('Y-m-1');
    $tanggal_akhir = date('Y-m-31');
    $kode_gudang = 'KG Mesuji';
}

if ($tanggal_awal == $tanggal_akhir) {
    $table = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = '$kode_gudang' ");

    // Gudang Mesuji SMBR
    $table_mesuji_smbr = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Mesuji' AND jenis_semen = 'SMBR'  ORDER BY no_laporan DESC LIMIT 1 ");
    $data_mesuji_smbr = mysqli_fetch_array($table_mesuji_smbr);
    $stok_masuk_mesuji_smbr = $data_mesuji_smbr['stok_masuk'];
    $stok_keluar_mesuji_smbr = $data_mesuji_smbr['stok_keluar'];
    $total_stok_mesuji_smbr = $data_mesuji_smbr['total_stok'];
    $tanggal_mesuji_smbr = $data_mesuji_smbr['tanggal'];

    // Gudang Mesuji MDK
    $table_mesuji_mdk = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Mesuji' AND jenis_semen = 'Merdeka'  ORDER BY no_laporan DESC LIMIT 1 ");
    $data_mesuji_mdk = mysqli_fetch_array($table_mesuji_mdk);
    $stok_masuk_mesuji_mdk = $data_mesuji_mdk['stok_masuk'];
    $stok_keluar_mesuji_mdk = $data_mesuji_mdk['stok_keluar'];
    $total_stok_mesuji_mdk = $data_mesuji_mdk['total_stok'];
    $tanggal_mesuji_mdk = $data_mesuji_mdk['tanggal'];

    // Gudang Unit 1 SMBR 
    $table_unit_1_smbr = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Unit 1' AND jenis_semen = 'SMBR' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_unit1_smbr = mysqli_fetch_array($table_unit_1_smbr);
    $stok_masuk_unit1_smbr = $data_unit1_smbr['stok_masuk'];
    $stok_keluar_unit1_smbr = $data_unit1_smbr['stok_keluar'];
    $total_stok_unit1_smbr = $data_unit1_smbr['total_stok'];
    $tanggal_unit1_smbr = $data_unit1_smbr['tanggal'];

    // Gudang Unit 1 MDK 
    $table_unit_1_mdk = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Unit 1' AND jenis_semen = 'Merdeka' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_unit1_mdk = mysqli_fetch_array($table_unit_1_mdk);
    $stok_masuk_unit1_mdk = $data_unit1_mdk['stok_masuk'];
    $stok_keluar_unit1_mdk = $data_unit1_mdk['stok_keluar'];
    $total_stok_unit1_mdk = $data_unit1_mdk['total_stok'];
    $tanggal_unit1_mdk  = $data_unit1_mdk['tanggal'];

    // Gudang Bu Jipa SMBR 
    $table_bu_jipa_smbr = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Bu Jipa' AND jenis_semen = 'SMBR' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_jipa_smbr = mysqli_fetch_array($table_bu_jipa_smbr);
    $stok_masuk_jipa_smbr = $data_jipa_smbr['stok_masuk'];
    $stok_keluar_jipa_smbr = $data_jipa_smbr['stok_keluar'];
    $total_stok_jipa_smbr = $data_jipa_smbr['total_stok'];
    $tanggal_jipa_smbr = $data_jipa_smbr['tanggal'];

    // Gudang Bu Jipa MDK 
    $table_bu_jipa_mdk = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Bu Jipa' AND jenis_semen = 'Merdeka' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_jipa_mdk = mysqli_fetch_array($table_bu_jipa_mdk);
    $stok_masuk_jipa_mdk = $data_jipa_mdk['stok_masuk'];
    $stok_keluar_jipa_mdk = $data_jipa_mdk['stok_keluar'];
    $total_stok_jipa_mdk = $data_jipa_mdk['total_stok'];
    $tanggal_jipa_mdk = $data_jipa_mdk['tanggal'];

    // Gudang Rawajitu SMBR 
    $table_rawajitu_smbr = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Rawajitu' AND jenis_semen = 'SMBR' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_rawajitu_smbr = mysqli_fetch_array($table_rawajitu_smbr);
    $stok_masuk_rawajitu_smbr = $data_rawajitu_smbr['stok_masuk'];
    $stok_keluar_rawajitu_smbr = $data_rawajitu_smbr['stok_keluar'];
    $total_stok_rawajitu_smbr = $data_rawajitu_smbr['total_stok'];
    $tanggal_rawajitu_smbr = $data_rawajitu_smbr['tanggal'];

    // Gudang Rawajitu MDK 
    $table_rawajitu_mdk = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Rawajitu' AND jenis_semen = 'Merdeka' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_rawajitu_mdk = mysqli_fetch_array($table_rawajitu_mdk);
    $stok_masuk_rawajitu_mdk = $data_rawajitu_mdk['stok_masuk'];
    $stok_keluar_rawajitu_mdk = $data_rawajitu_mdk['stok_keluar'];
    $total_stok_rawajitu_mdk = $data_rawajitu_mdk['total_stok'];
    $tanggal_rawajitu_mdk = $data_rawajitu_mdk['tanggal'];

    // Gudang Way Kanan SMBR 
    $table_waykanan_smbr = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Way Kanan' AND jenis_semen = 'SMBR' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_waykanan_smbr = mysqli_fetch_array($table_waykanan_smbr);
    $stok_masuk_waykanan_smbr = $data_waykanan_smbr['stok_masuk'];
    $stok_keluar_waykanan_smbr = $data_waykanan_smbr['stok_keluar'];
    $total_stok_waykanan_smbr = $data_waykanan_smbr['total_stok'];
    $tanggal_waykanan_smbr = $data_waykanan_smbr['tanggal'];

    // Gudang Way Kanan MDK 
    $table_waykanan_mdk = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Way Kanan' AND jenis_semen = 'Merdeka' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_waykanan_mdk = mysqli_fetch_array($table_waykanan_mdk);
    $stok_masuk_waykanan_mdk = $data_waykanan_mdk['stok_masuk'];
    $stok_keluar_waykanan_mdk = $data_waykanan_mdk['stok_keluar'];
    $total_stok_waykanan_mdk = $data_waykanan_mdk['total_stok'];
    $tanggal_waykanan_mdk = $data_waykanan_mdk['tanggal'];

    // Gudang MES
    $table_mes = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG MES' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_mes = mysqli_fetch_array($table_mes);
    $stok_masuk_mes = $data_mes['stok_masuk'];
    $stok_keluar_mes = $data_mes['stok_keluar'];
    $total_stok_mes = $data_mes['total_stok'];
    $tanggal_mes = $data_mes['tanggal'];

    // Gudang Rantau Panjang
    $table_rantau_panjang = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Rantau Panjang' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_rantau_panjang = mysqli_fetch_array($table_rantau_panjang);
    $stok_masuk_rantau_panjang = $data_rantau_panjang['stok_masuk'];
    $stok_keluar_rantau_panjang = $data_rantau_panjang['stok_keluar'];
    $total_stok_rantau_panjang = $data_rantau_panjang['total_stok'];
    $tanggal_rantau_panjang = $data_rantau_panjang['tanggal'];

    // Gudang Simpang Sender
    $table_simpang_sender = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Simpang Sender' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_simpang_sender = mysqli_fetch_array($table_simpang_sender);
    $stok_masuk_simpang_sender = $data_simpang_sender['stok_masuk'];
    $stok_keluar_simpang_sender = $data_simpang_sender['stok_keluar'];
    $total_stok_simpang_sender = $data_simpang_sender['total_stok'];
    $tanggal_simpang_sender = $data_simpang_sender['tanggal'];

    // Gudang Ruko M2
    $table_ruko_m2 = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Ruko M2' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_ruko_m2 = mysqli_fetch_array($table_ruko_m2);
    $stok_masuk_ruko_m2 = $data_ruko_m2['stok_masuk'];
    $stok_keluar_ruko_m2 = $data_ruko_m2['stok_keluar'];
    $total_stok_ruko_m2 = $data_ruko_m2['total_stok'];
    $tanggal_ruko_m2 = $data_ruko_m2['tanggal'];

    // Gudang Kuto Sari
    $table_kuto_sari = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Kuto Sari' ORDER BY no_laporan DESC LIMIT 1  ");
    $data_kuto_sari = mysqli_fetch_array($table_kuto_sari);
    $stok_masuk_kuto_sari = $data_kuto_sari['stok_masuk'];
    $stok_keluar_kuto_sari = $data_kuto_sari['stok_keluar'];
    $total_stok_kuto_sari = $data_kuto_sari['total_stok'];
    $tanggal_kuto_sari = $data_kuto_sari['tanggal'];

    // Gudang BK 11
    $table_bk_11 = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG BK 11' ORDER BY no_laporan DESC LIMIT 1  ");
    $data_bk_11 = mysqli_fetch_array($table_bk_11);
    $stok_masuk_bk_11 = $data_bk_11['stok_masuk'];
    $stok_keluar_bk_11 = $data_bk_11['stok_keluar'];
    $total_stok_bk_11 = $data_bk_11['total_stok'];
    $tanggal_bk_11 = $data_bk_11['tanggal'];
} else {
    $table = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = '$kode_gudang'  ");

    // Gudang Mesuji SMBR
    $table_mesuji_smbr = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG Mesuji' AND jenis_semen = 'SMBR'  ORDER BY no_laporan DESC LIMIT 1 ");
    $data_mesuji_smbr = mysqli_fetch_array($table_mesuji_smbr);
    $stok_masuk_mesuji_smbr = $data_mesuji_smbr['stok_masuk'];
    $stok_keluar_mesuji_smbr = $data_mesuji_smbr['stok_keluar'];
    $total_stok_mesuji_smbr = $data_mesuji_smbr['total_stok'];
    $tanggal_mesuji_smbr = $data_mesuji_smbr['tanggal'];

    // Gudang Mesuji MDK
    $table_mesuji_mdk = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG Mesuji' AND jenis_semen = 'Merdeka'  ORDER BY no_laporan DESC LIMIT 1 ");
    $data_mesuji_mdk = mysqli_fetch_array($table_mesuji_mdk);
    $stok_masuk_mesuji_mdk = $data_mesuji_mdk['stok_masuk'];
    $stok_keluar_mesuji_mdk = $data_mesuji_mdk['stok_keluar'];
    $total_stok_mesuji_mdk = $data_mesuji_mdk['total_stok'];
    $tanggal_mesuji_mdk = $data_mesuji_mdk['tanggal'];

    // Gudang Unit 1 SMBR 
    $table_unit_1_smbr = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG Unit 1' AND jenis_semen = 'SMBR' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_unit1_smbr = mysqli_fetch_array($table_unit_1_smbr);
    $stok_masuk_unit1_smbr = $data_unit1_smbr['stok_masuk'];
    $stok_keluar_unit1_smbr = $data_unit1_smbr['stok_keluar'];
    $total_stok_unit1_smbr = $data_unit1_smbr['total_stok'];
    $tanggal_unit1_smbr = $data_unit1_smbr['tanggal'];

    // Gudang Unit 1 MDK 
    $table_unit_1_mdk = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG Unit 1' AND jenis_semen = 'Merdeka' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_unit1_mdk = mysqli_fetch_array($table_unit_1_mdk);
    $stok_masuk_unit1_mdk = $data_unit1_mdk['stok_masuk'];
    $stok_keluar_unit1_mdk = $data_unit1_mdk['stok_keluar'];
    $total_stok_unit1_mdk = $data_unit1_mdk['total_stok'];
    $tanggal_unit1_mdk  = $data_unit1_mdk['tanggal'];

    // Gudang Bu Jipa SMBR 
    $table_bu_jipa_smbr = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG Bu Jipa' AND jenis_semen = 'SMBR' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_jipa_smbr = mysqli_fetch_array($table_bu_jipa_smbr);
    $stok_masuk_jipa_smbr = $data_jipa_smbr['stok_masuk'];
    $stok_keluar_jipa_smbr = $data_jipa_smbr['stok_keluar'];
    $total_stok_jipa_smbr = $data_jipa_smbr['total_stok'];
    $tanggal_jipa_smbr = $data_jipa_smbr['tanggal'];

    // Gudang Bu Jipa MDK 
    $table_bu_jipa_mdk = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG Bu Jipa' AND jenis_semen = 'Merdeka' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_jipa_mdk = mysqli_fetch_array($table_bu_jipa_mdk);
    $stok_masuk_jipa_mdk = $data_jipa_mdk['stok_masuk'];
    $stok_keluar_jipa_mdk = $data_jipa_mdk['stok_keluar'];
    $total_stok_jipa_mdk = $data_jipa_mdk['total_stok'];
    $tanggal_jipa_mdk = $data_jipa_mdk['tanggal'];

    // Gudang Rawajitu SMBR 
    $table_rawajitu_smbr = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG Rawajitu' AND jenis_semen = 'SMBR' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_rawajitu_smbr = mysqli_fetch_array($table_rawajitu_smbr);
    $stok_masuk_rawajitu_smbr = $data_rawajitu_smbr['stok_masuk'];
    $stok_keluar_rawajitu_smbr = $data_rawajitu_smbr['stok_keluar'];
    $total_stok_rawajitu_smbr = $data_rawajitu_smbr['total_stok'];
    $tanggal_rawajitu_smbr = $data_rawajitu_smbr['tanggal'];

    // Gudang Rawajitu MDK 
    $table_rawajitu_mdk = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG Rawajitu' AND jenis_semen = 'Merdeka' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_rawajitu_mdk = mysqli_fetch_array($table_rawajitu_mdk);
    $stok_masuk_rawajitu_mdk = $data_rawajitu_mdk['stok_masuk'];
    $stok_keluar_rawajitu_mdk = $data_rawajitu_mdk['stok_keluar'];
    $total_stok_rawajitu_mdk = $data_rawajitu_mdk['total_stok'];
    $tanggal_rawajitu_mdk = $data_rawajitu_mdk['tanggal'];

    // Gudang Way Kanan SMBR 
    $table_waykanan_smbr = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG Way Kanan' AND jenis_semen = 'SMBR' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_waykanan_smbr = mysqli_fetch_array($table_waykanan_smbr);
    $stok_masuk_waykanan_smbr = $data_waykanan_smbr['stok_masuk'];
    $stok_keluar_waykanan_smbr = $data_waykanan_smbr['stok_keluar'];
    $total_stok_waykanan_smbr = $data_waykanan_smbr['total_stok'];
    $tanggal_waykanan_smbr = $data_waykanan_smbr['tanggal'];

    // Gudang Way Kanan MDK 
    $table_waykanan_mdk = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG Way Kanan' AND jenis_semen = 'Merdeka' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_waykanan_mdk = mysqli_fetch_array($table_waykanan_mdk);
    $stok_masuk_waykanan_mdk = $data_waykanan_mdk['stok_masuk'];
    $stok_keluar_waykanan_mdk = $data_waykanan_mdk['stok_keluar'];
    $total_stok_waykanan_mdk = $data_waykanan_mdk['total_stok'];
    $tanggal_waykanan_mdk = $data_waykanan_mdk['tanggal'];

    // Gudang MES
    $table_mes = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG MES' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_mes = mysqli_fetch_array($table_mes);
    $stok_masuk_mes = $data_mes['stok_masuk'];
    $stok_keluar_mes = $data_mes['stok_keluar'];
    $total_stok_mes = $data_mes['total_stok'];
    $tanggal_mes = $data_mes['tanggal'];

    // Gudang Rantau Panjang
    $table_rantau_panjang = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG Rantau Panjang' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_rantau_panjang = mysqli_fetch_array($table_rantau_panjang);
    $stok_masuk_rantau_panjang = $data_rantau_panjang['stok_masuk'];
    $stok_keluar_rantau_panjang = $data_rantau_panjang['stok_keluar'];
    $total_stok_rantau_panjang = $data_rantau_panjang['total_stok'];
    $tanggal_rantau_panjang = $data_rantau_panjang['tanggal'];

    // Gudang Simpang Sender
    $table_simpang_sender = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG Simpang Sender' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_simpang_sender = mysqli_fetch_array($table_simpang_sender);
    $stok_masuk_simpang_sender = $data_simpang_sender['stok_masuk'];
    $stok_keluar_simpang_sender = $data_simpang_sender['stok_keluar'];
    $total_stok_simpang_sender = $data_simpang_sender['total_stok'];
    $tanggal_simpang_sender = $data_simpang_sender['tanggal'];

    // Gudang Ruko M2
    $table_ruko_m2 = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG Ruko M2' ORDER BY no_laporan DESC LIMIT 1 ");
    $data_ruko_m2 = mysqli_fetch_array($table_ruko_m2);
    $stok_masuk_ruko_m2 = $data_ruko_m2['stok_masuk'];
    $stok_keluar_ruko_m2 = $data_ruko_m2['stok_keluar'];
    $total_stok_ruko_m2 = $data_ruko_m2['total_stok'];
    $tanggal_ruko_m2 = $data_ruko_m2['tanggal'];

    // Gudang Kuto Sari
    $table_kuto_sari = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG Kuto Sari' ORDER BY no_laporan DESC LIMIT 1  ");
    $data_kuto_sari = mysqli_fetch_array($table_kuto_sari);
    $stok_masuk_kuto_sari = $data_kuto_sari['stok_masuk'];
    $stok_keluar_kuto_sari = $data_kuto_sari['stok_keluar'];
    $total_stok_kuto_sari = $data_kuto_sari['total_stok'];
    $tanggal_kuto_sari = $data_kuto_sari['tanggal'];

    // Gudang BK 11
    $table_bk_11 = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG BK 11' ORDER BY no_laporan DESC LIMIT 1  ");
    $data_bk_11 = mysqli_fetch_array($table_bk_11);
    $stok_masuk_bk_11 = $data_bk_11['stok_masuk'];
    $stok_keluar_bk_11 = $data_bk_11['stok_keluar'];
    $total_stok_bk_11 = $data_bk_11['total_stok'];
    $tanggal_bk_11 = $data_bk_11['tanggal'];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan Harian Stok Gudang</title>

    <!-- Custom fonts for this template-->
    <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/sbadmin/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Custom styles for this template-->
    <link href="/sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Link Tabel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Link datepicker -->

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

       <!-- Sidebar -->
 <ul class="navbar-nav  sidebar sidebar-dark accordion" style=" background-color: #004445" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsAdministrasi">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="height: 65px; width: 220px;" src="../gambar/Logo CBM.jpg" ></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active" >
    <a class="nav-link" href="DsAdministrasi">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu Administrasi
    </div>
     <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
      15  aria-expanded="true" aria-controls="collapseOne">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >LR Kendaraan</span>
    </a>
    <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">LR Kendaraan</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugi2">LR Kendaraan Lampung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiP2">LR Kendaraan Sumsel</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBr">LR Kendaraan Baturaja</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBl">LR Kendaraan Belitung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBk">LR Kendaraan Bangka</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugi">LR Kendaraan Bengkulu</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiPA">LR Kendaraan Padlarang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiPL">LR Kendaraan Plumpang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiTG">LR Kendaraan Tj Gerem</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiUB">LR Kendaraan Uj Berung</a>
        </div>
    </div>
</li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse2"
                  15  aria-expanded="true" aria-controls="collapse2">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Data PBJ</span>
                </a>
                <div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Data PBJ</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenebusan">Penebusan PBJ</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Penjualan Ety</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenjualanL">Penjualan Agus</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VKeuangan">Keuangan Ety</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VKeuanganL">Keuangan Agus</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Pengiriman Ety</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengirimanL">Pengiriman Agus</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLStokGudang">Laporan Stok Gudang</a>
                    </div>
                </div>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">




            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light  topbar mb-4 static-top shadow" style="background-color:#2C7873;">
                    <?php echo "<a href=''><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Laporan Harian Stok Gudang $kode_gudang </h5></a>"; ?>

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>




                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php $foto_profile = $data1['foto_profile']; ?>
                                <span class="mr-2 d-none d-lg-inline  small" style="color:white;"><?php echo "$nama"; ?></span>
                                <img class="img-profile rounded-circle" src="/assets/img/foto_profile/<?= $foto_profile; ?>"><!-- link foto profile -->
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="VProfile">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Top content -->
                <div>


                    <div style="margin-right: 100px; margin-left: 100px;">

                        <?php echo "<form  method='POST' action='VLStokGudang'>" ?>
                        <div>
                            <div align="left" style="margin-left: 20px;">
                                <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1">
                                <span>-</span>
                                <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
                                <select id="kode_gudang" name="kode_gudang">
                                    <option>KG Mesuji</option>
                                    <option>KG MES</option>
                                    <option>KG Way Kanan</option>
                                    <option>KG Unit 1</option>
                                    <option>KG Bu Jipa</option>
                                    <option>KG Rawajitu</option>
                                    <option>KG Rantau Panjang</option>
                                    <option>KG Simpang Sender</option>
                                    <option>KG Ruko M2</option>
                                    <option>KG Kuto Sari</option>
                                    <option>KG BK 11</option>
                                </select>
                                <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm">Lihat</button>
                            </div>
                        </div>
                        </form>

                        <div class="col-md-8">
                            <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
                        </div>
                        <br>




                        <h4 align='center'> Laporan Harian Gudang <?= $kode_gudang; ?></h4>
                        <!-- Tabel -->
                        <div style="overflow-x: auto" align='center'>
                            <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jenis Semen</th>
                                        <th>Stok Awal/zak</th>
                                        <th>Stok Masuk/zak</th>
                                        <th>Stok Keluar/zak</th>
                                        <th>Total Akhir/zak</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $urut = 0;
                                    function formatuang($angka)
                                    {
                                        $uang = "Rp " . number_format($angka, 2, ',', '.');
                                        return $uang;
                                    }

                                    ?>
                                    <?php while ($data = mysqli_fetch_array($table)) {
                                        $no_laporan = $data['no_laporan'];
                                        $tanggal = $data['tanggal'];
                                        $kode_gudang = $data['kode_gudang'];
                                        $jenis_semen = $data['jenis_semen'];
                                        $stok_masuk = $data['stok_masuk'];
                                        $stok_keluar = $data['stok_keluar'];
                                        $total_stok = $data['total_stok'];
                                        $stok_awal = $total_stok + $stok_keluar + $stok_masuk;
                                        $urut = $urut + 1;

                                        echo "<tr>
                                            <td style='font-size: 14px' align = 'center'>$urut</td>
                                            <td style='font-size: 14px' align = 'center'>$tanggal</td>
                                            <td style='font-size: 14px' align = 'center'>$jenis_semen</td>
                                            <td style='font-size: 14px' align = 'center'>$stok_awal</td>
                                            <td style='font-size: 14px' align = 'center'>$stok_masuk</td>
                                            <td style='font-size: 14px' align = 'center'>$stok_keluar</td>
                                            <td style='font-size: 14px' align = 'center'>$total_stok</td>
                                        </tr>";
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                        <br>
                        <br>

                        <h4 align='center'> Stok Gudang All</h4>
                        <!-- Tabel -->
                        <div style="overflow-x: auto" align='center'>
                            <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Gudang</th>
                                        <th>Jenis Semen</th>
                                        <th>Total Stok/zak</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style='font-size: 14px' align='center'>1</td>
                                        <td style='font-size: 14px' align='center'><?= $tanggal_mesuji_smbr ?> </td>
                                        <td style='font-size: 14px' align='center'>Mesuji</td>
                                        <td style='font-size: 14px' align='center'>SMBR</td>
                                        <td style='font-size: 14px' align='center'><?= $total_stok_mesuji_smbr ?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: 14px' align='center'>2</td>
                                        <td style='font-size: 14px' align='center'><?= $tanggal_mesuji_mdk ?> </td>
                                        <td style='font-size: 14px' align='center'>Mesuji</td>
                                        <td style='font-size: 14px' align='center'>MDK</td>
                                        <td style='font-size: 14px' align='center'><?= $total_stok_mesuji_mdk ?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: 14px' align='center'>3</td>
                                        <td style='font-size: 14px' align='center'><?= $tanggal_unit1_smbr ?> </td>
                                        <td style='font-size: 14px' align='center'>Unit 1</td>
                                        <td style='font-size: 14px' align='center'>SMBR</td>
                                        <td style='font-size: 14px' align='center'><?= $total_stok_unit1_smbr?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: 14px' align='center'>4</td>
                                        <td style='font-size: 14px' align='center'><?= $tanggal_unit1_mdk ?> </td>
                                        <td style='font-size: 14px' align='center'>Unit 1</td>
                                        <td style='font-size: 14px' align='center'>MDK</td>
                                        <td style='font-size: 14px' align='center'><?= $total_stok_unit1_mdk ?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: 14px' align='center'>5</td>
                                        <td style='font-size: 14px' align='center'><?= $tanggal_jipa_smbr ?> </td>
                                        <td style='font-size: 14px' align='center'>Bu Jipa</td>
                                        <td style='font-size: 14px' align='center'>SMBR</td>
                                        <td style='font-size: 14px' align='center'><?= $total_stok_jipa_smbr?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: 14px' align='center'>6</td>
                                        <td style='font-size: 14px' align='center'><?= $tanggal_jipa_mdk ?> </td>
                                        <td style='font-size: 14px' align='center'>Bu Jipa</td>
                                        <td style='font-size: 14px' align='center'>MDK</td>
                                        <td style='font-size: 14px' align='center'><?= $total_stok_jipa_mdk ?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: 14px' align='center'>7</td>
                                        <td style='font-size: 14px' align='center'><?= $tanggal_rawajitu_smbr?> </td>
                                        <td style='font-size: 14px' align='center'>Rawajitu</td>
                                        <td style='font-size: 14px' align='center'>SMBR</td>
                                        <td style='font-size: 14px' align='center'><?= $total_stok_rawajitu_smbr?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: 14px' align='center'>8</td>
                                        <td style='font-size: 14px' align='center'><?= $tanggal_rawajitu_mdk ?> </td>
                                        <td style='font-size: 14px' align='center'>Rawajitu</td>
                                        <td style='font-size: 14px' align='center'>MDK</td>
                                        <td style='font-size: 14px' align='center'><?= $total_stok_rawajitu_mdk ?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: 14px' align='center'>9</td>
                                        <td style='font-size: 14px' align='center'><?= $tanggal_waykanan_smbr?> </td>
                                        <td style='font-size: 14px' align='center'>Way Kanan</td>
                                        <td style='font-size: 14px' align='center'>SMBR</td>
                                        <td style='font-size: 14px' align='center'><?= $total_stok_waykanan_smbr?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: 14px' align='center'>10</td>
                                        <td style='font-size: 14px' align='center'><?= $tanggal_waykanan_mdk ?> </td>
                                        <td style='font-size: 14px' align='center'>Way Kanan</td>
                                        <td style='font-size: 14px' align='center'>MDK</td>
                                        <td style='font-size: 14px' align='center'><?= $total_stok_waykanan_mdk ?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: 14px' align='center'>11</td>
                                        <td style='font-size: 14px' align='center'><?= $tanggal_mes?> </td>
                                        <td style='font-size: 14px' align='center'>MES</td>
                                        <td style='font-size: 14px' align='center'>SMBR</td>
                                        <td style='font-size: 14px' align='center'><?= $total_stok_mes?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: 14px' align='center'>12</td>
                                        <td style='font-size: 14px' align='center'><?= $tanggal_rantau_panjang ?> </td>
                                        <td style='font-size: 14px' align='center'>Rantau Panjang</td>
                                        <td style='font-size: 14px' align='center'>SMBR</td>
                                        <td style='font-size: 14px' align='center'><?= $total_stok_rantau_panjang ?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: 14px' align='center'>13</td>
                                        <td style='font-size: 14px' align='center'><?= $tanggal_simpang_sender?> </td>
                                        <td style='font-size: 14px' align='center'>Simpang Sender</td>
                                        <td style='font-size: 14px' align='center'>SMBR</td>
                                        <td style='font-size: 14px' align='center'><?= $total_stok_simpang_sender?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: 14px' align='center'>14</td>
                                        <td style='font-size: 14px' align='center'><?= $tanggal_ruko_m2 ?> </td>
                                        <td style='font-size: 14px' align='center'>Ruko M2</td>
                                        <td style='font-size: 14px' align='center'>SMBR</td>
                                        <td style='font-size: 14px' align='center'><?= $total_stok_ruko_m2 ?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: 14px' align='center'>15</td>
                                        <td style='font-size: 14px' align='center'><?= $tanggal_kuto_sari ?> </td>
                                        <td style='font-size: 14px' align='center'>Kuto Sari</td>
                                        <td style='font-size: 14px' align='center'>SMBR</td>
                                        <td style='font-size: 14px' align='center'><?= $total_stok_kuto_sari ?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: 14px' align='center'>16</td>
                                        <td style='font-size: 14px' align='center'><?= $tanggal_bk_11 ?> </td>
                                        <td style='font-size: 14px' align='center'>BK 11</td>
                                        <td style='font-size: 14px' align='center'>SMBR</td>
                                        <td style='font-size: 14px' align='center'><?= $total_stok_bk_11 ?> </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="footer" style="background-color:#2C7873; height: 55px; padding-top: 15px; ">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span style="color:white; font-size: 12px;">Copyright &copy; PutraBalkomCorp 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/sbadmin/vendor/jquery/jquery.min.js"></script>
    <script src="/sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/sbadmin/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/sbadmin/js/sb-admin-2.min.js"></script>

    <!-- Tabel -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>


    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                lengthChange: false,
                buttons: ['excel']
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
        });
    </script>


</body>

</html>