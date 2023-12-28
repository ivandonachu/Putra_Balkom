<?php
session_start();
include'koneksi.php';
if(!isset($_SESSION["login"])){
  header("Location: logout.php");
  exit;
}
$id=$_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksicbm, "SELECT * FROM super_account WHERE username = '$id'");
$data1 = mysqli_fetch_array($result1);
$nama = $data1['nama_pemilik'];
$foto_profile = $data1['foto_profile'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Direktur Utama') {

}

else{ header("Location: logout.php");
exit;
}

if (isset($_GET['tanggal1'])) {
    $tanggal_awal = $_GET['tanggal1'];
    $tanggal_akhir = $_GET['tanggal2'];
    $tahun = date('Y', strtotime($tanggal_awal)); 
    $bulanx = date('m', strtotime($tanggal_awal)); 
    $bulan = ltrim($bulanx, '0');
 } 
 
 elseif (isset($_POST['tanggal1'])) {
    $tanggal_awal = $_POST['tanggal1'];
    $tanggal_akhir = $_POST['tanggal2'];
    $tahun = date('Y', strtotime($tanggal_awal)); 
 
    $bulanx = date('m', strtotime($tanggal_awal)); 
    $bulan = ltrim($bulanx, '0');
  
 }  
 
 else{
     $tanggal_awal = date('Y-m-1');
   $tanggal_akhir = date('Y-m-31');
   $tahun = date('Y', strtotime($tanggal_awal)); 
   $bulanx = date('m', strtotime($tanggal_awal)); 
   $bulan = ltrim($bulanx, '0');
   }
   
function formatuang($angka){
  $uang = "Rp " . number_format($angka,2,',','.');
  return $uang;
}

if ($tanggal_awal == $tanggal_akhir) {


}
else{
    //TAGIHAN
    // Tagihan baturaja
  $table_br = mysqli_query($koneksibalsri, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_br a INNER JOIN master_tarif_br b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data_br = mysqli_fetch_array($table_br);
  $total_tagihan_br = $data_br['total_tagihan'];

  // Tagihan lampung
  $table_lmg = mysqli_query($koneksibalsri, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan a INNER JOIN master_tarif b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data_lmg = mysqli_fetch_array($table_lmg);
  $total_tagihan_lmg = $data_lmg['total_tagihan'];

   // Tagihan spbu
   $table_spbu = mysqli_query($koneksibalsri, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_spbu a INNER JOIN master_tarif_spbu b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $data_spbu = mysqli_fetch_array($table_spbu);
   $total_tagihan_spbu = $data_spbu['total_tagihan'];

  // Tagihan palembang
  $table_plg = mysqli_query($koneksibalsri, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_p a INNER JOIN master_tarif_p b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data_plg = mysqli_fetch_array($table_plg);
  $total_tagihan_plg = $data_plg['total_tagihan'];

  // Tagihan Belitung
  $table_bb = mysqli_query($koneksibalsri, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_bl a INNER JOIN master_tarif_bl b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data_bb = mysqli_fetch_array($table_bb);
  $total_tagihan_bb = $data_bb['total_tagihan'];

    // Tagihan bangka
    $table_bk = mysqli_query($koneksibalsri, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_bk a INNER JOIN master_tarif_bk b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data_bk = mysqli_fetch_array($table_bk);
    $total_tagihan_bk = $data_bk['total_tagihan'];

    // Tagihan bengkulu
  $table_bkl = mysqli_query($koneksistre, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan a INNER JOIN master_tarif b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data_bkl = mysqli_fetch_array($table_bkl);
  $total_tagihan_bkl = $data_bkl['total_tagihan'];
  

  $total_tagihan_global = $total_tagihan_br + $total_tagihan_lmg + $total_tagihan_plg + $total_tagihan_bb + $total_tagihan_spbu + $total_tagihan_bk + $total_tagihan_bkl ;

  // Potongan global 10%
  $jumlah_potongan_global = (($total_tagihan_global * 10) / 100);

  //PENGIRIMAN
  //pengiriman baturaja
   $table2_br = mysqli_query($koneksibalsri, "SELECT SUM(um) AS uang_makan , SUM(jt_gps) as total_jt_gps , SUM(uj) AS total_uj FROM pengiriman_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $total_dexlite_br =0;
   $data2_br = mysqli_fetch_array($table2_br);
   $total_uj_br = $data2_br['total_uj'];
   $total_jt_gps_br = $data2_br['total_jt_gps'];
   $total_um_br= $data2_br['uang_makan'];
   $total_dexlite_br = $total_uj_br - ($total_jt_gps_br*625);
   $total_bbm_br = 0;
   $table222_br = mysqli_query($koneksibalsri, "SELECT jt_gps, uj , dexlite FROM pengiriman_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    while($data = mysqli_fetch_array($table222_br)){
 
        $dexlite_br = $data['dexlite'];
        $total_bbm_br = $total_bbm_br + $dexlite_br;
        
    }
        $uang_bbm_br = $total_bbm_br * 10150;
   

  //pengiriman lampung
   $table2_lmg = mysqli_query($koneksibalsri, "SELECT SUM(um) AS uang_makan , SUM(jt_gps) as total_jt_gps , SUM(uj) AS total_uj  FROM pengiriman WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $total_dexlite_lmg =0;
   $data2_lmg = mysqli_fetch_array($table2_lmg);
   $total_uj_lmg = $data2_lmg['total_uj'];
   $total_jt_gps_lmg = $data2_lmg['total_jt_gps'];
   $total_um_lmg = $data2_lmg['uang_makan'];
   $total_dexlite_lmg = $total_uj_lmg - ($total_jt_gps_lmg*625);
   $total_bbm_lpg = 0;
   $table222_lpg = mysqli_query($koneksibalsri, "SELECT dexlite FROM pengiriman WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    while($data = mysqli_fetch_array($table222_lpg)){

        $dexlite_lpg = $data['dexlite'];
        $total_bbm_lpg = $total_bbm_lpg + $dexlite_lpg;
        
    }
        $uang_bbm_lpg = $total_bbm_lpg * 10000;

   //pengiriman spbu
   $table2_spbu = mysqli_query($koneksibalsri, "SELECT SUM(um) AS uang_makan , SUM(jt_gps) as total_jt_gps , SUM(uj) AS total_uj  FROM pengiriman_spbu WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $total_dexlite_spbu =0;
   $data2_spbu = mysqli_fetch_array($table2_spbu);
   $total_uj_spbu = $data2_spbu['total_uj'];
   $total_jt_gps_spbu = $data2_spbu['total_jt_gps'];
   $total_um_spbu= $data2_spbu['uang_makan'];
   $total_dexlite_spbu = $total_uj_spbu - ($total_jt_gps_spbu*625);
   $total_bbm_spbu = 0;
   $table222_spbu = mysqli_query($koneksibalsri, "SELECT dexlite FROM pengiriman_spbu WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    while($data = mysqli_fetch_array($table222_spbu)){

        $dexlite_spbu = $data['dexlite'];
        $total_bbm_spbu = $total_bbm_spbu + $dexlite_spbu;
        
    }
    $uang_bbm_spbu = $total_bbm_spbu * 10000;

   //pengiriman palembang
   $table2_plg = mysqli_query($koneksibalsri, "SELECT SUM(um) AS uang_makan , SUM(jt_gps) as total_jt_gps , SUM(uj) AS total_uj  FROM pengiriman_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $total_dexlite_plg =0;
    $data2_plg = mysqli_fetch_array($table2_plg);
   $total_uj_plg = $data2_plg['total_uj'];
   $total_jt_gps_plg = $data2_plg['total_jt_gps'];
   $total_um_plg= $data2_plg['uang_makan'];
   $total_dexlite_plg = $total_uj_plg - ($total_jt_gps_plg*625);
   $total_bbm_plg =0;
   $table222_plg = mysqli_query($koneksibalsri, "SELECT jt_gps, uj , dexlite FROM pengiriman_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    while($data = mysqli_fetch_array($table222_plg)){

        $dexlite_plg = $data['dexlite'];
        $total_bbm_plg = $total_bbm_plg + $dexlite_plg;
        
    }
        $uang_bbm_plg = $total_bbm_plg * 10000;

   //pengiriman belitung
   $table2_bb = mysqli_query($koneksibalsri, "SELECT SUM(um) AS uang_makan , SUM(jt_gps) as total_jt_gps , SUM(uj) AS total_uj  FROM pengiriman_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $total_dexlite_bb =0;
   $data2_bb = mysqli_fetch_array($table2_bb);
   $total_uj_bb = $data2_bb['total_uj'];
   $total_jt_gps_bb = $data2_bb['total_jt_gps'];
   $total_um_bb= $data2_bb['uang_makan'];
   $total_dexlite_bb = $total_uj_bb - ($total_jt_gps_bb*625);

   //pengiriman bangka
   $table2_bk = mysqli_query($koneksibalsri, "SELECT SUM(um) AS uang_makan , SUM(jt_gps) as total_jt_gps , SUM(uj) AS total_uj  FROM pengiriman_bk WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $total_dexlite_bk =0;
   $data2_bk = mysqli_fetch_array($table2_bk);
   $total_uj_bk = $data2_bk['total_uj'];
   $total_jt_gps_bk = $data2_bk['total_jt_gps'];
   $total_um_bk= $data2_bk['uang_makan'];
   $total_dexlite_bk = $total_uj_bk - ($total_jt_gps_bk*625);

   //pengiriman bengkulu
   $table2_bkl = mysqli_query($koneksistre, "SELECT SUM(um) AS uang_makan , SUM(jt_gps) as total_jt_gps , SUM(uj) AS total_uj  FROM pengiriman WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $total_dexlite_bkl =0;
   $data2_bkl = mysqli_fetch_array($table2_bkl);
   $total_uj_bkl = $data2_bkl['total_uj'];
   $total_jt_gps_bkl = $data2_bkl['total_jt_gps'];
   $total_um_bkl = $data2_bkl['uang_makan'];
   $total_dexlite_bkl = $total_uj_bkl - ($total_jt_gps_bkl*625);
   $total_bbm_bku = 0;
   $table222_bku = mysqli_query($koneksistre, "SELECT jt_gps, uj , dexlite FROM pengiriman WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    while($data = mysqli_fetch_array($table222_bku)){

        $dexlite_bku = $data['dexlite'];
        $total_bbm_bku = $total_bbm_bku + $dexlite_bku;
        
    }
        $uang_bbm_bku = $total_bbm_bku * 11000;

    
    $total_dexlite_global = $total_dexlite_br + $total_dexlite_plg  + $total_dexlite_bb + $total_dexlite_spbu + $total_dexlite_lmg + $total_dexlite_bk + $total_dexlite_bkl;
    $total_dexlite_global_bbm = $total_dexlite_bb + $total_dexlite_bk;
    $total_um_global = $total_um_br + $total_um_lmg + $total_um_plg + $total_um_bb + $total_um_spbu +  $total_um_bk + $total_um_bkl;
    $total_bbm_global = $uang_bbm_br + $uang_bbm_lpg + $uang_bbm_spbu + $uang_bbm_bku + $uang_bbm_plg;

    //BIAYA KANTOR
  //pengeluran Pul Biaya Kantor baturaja
   $table3_br = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
   $data3_br = mysqli_fetch_array($table3_br);
   $jml_biaya_kantor_br = $data3_br['jumlah_biaya_kantor'];
    if (!isset($data3_br['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor_br = 0;
    }
    //pengeluran Pul Biaya Kantor lampung
   $table3_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
   $data3_lmg = mysqli_fetch_array($table3_lmg);
   $jml_biaya_kantor_lmg = $data3_lmg['jumlah_biaya_kantor'];
    if (!isset($data3_lmg['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor_lmg = 0;
    }
    //pengeluran Pul Biaya Kantor palembang
    $table3_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
    $data3_plg = mysqli_fetch_array($table3_plg);
    $jml_biaya_kantor_plg = $data3_plg['jumlah_biaya_kantor'];
     if (!isset($data3_plg['jumlah_biaya_kantor'])) {
     $jml_biaya_kantor_plg = 0;
     }
     //pengeluran Pul Biaya Kantor belitung
    $table3_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
    $data3_bb = mysqli_fetch_array($table3_bb);
    $jml_biaya_kantor_bb = $data3_bb['jumlah_biaya_kantor'];
     if (!isset($data3_bb['jumlah_biaya_kantor'])) {
     $jml_biaya_kantor_bb = 0;
     }
     //pengeluran Pul Biaya Kantor bangka
    $table3_bk = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_bk WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
    $data3_bk = mysqli_fetch_array($table3_bk);
    $jml_biaya_kantor_bk = $data3_bk['jumlah_biaya_kantor'];
     if (!isset($data3_bk['jumlah_biaya_kantor'])) {
     $jml_biaya_kantor_bk = 0;
     }
     //pengeluran Pul Biaya Kantor bengkulu
   $table3_bkl = mysqli_query($koneksistre, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
   $data3_bkl = mysqli_fetch_array($table3_bkl);
   $jml_biaya_kantor_bkl = $data3_bkl['jumlah_biaya_kantor'];
    if (!isset($data3_bkl['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor_bkl = 0;
    }

     $biaya_kantor_global = $jml_biaya_kantor_br + $jml_biaya_kantor_lmg + $jml_biaya_kantor_plg + $jml_biaya_kantor_bb + $jml_biaya_kantor_bk + $jml_biaya_kantor_bkl;

    // LISTRIK & TELEPON
   //pengeluran Pul Listrik & Telepon baturaja
   $table4_br = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
   $data4_br = mysqli_fetch_array($table4_br);
   $jml_listrik_br = $data4_br['jumlah_listrik'];
    if (!isset($data4_br['jumlah_listrik'])) {
    $jml_listrik_br = 0;
    }
    //pengeluran Pul Listrik & Telepon lampung
   $table4_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
   $data4_lmg = mysqli_fetch_array($table4_lmg);
   $jml_listrik_lmg = $data4_lmg['jumlah_listrik'];
    if (!isset($data4_lmg['jumlah_listrik'])) {
    $jml_listrik_lmg = 0;
    }
    //pengeluran Pul Listrik & Telepon paelmbang
    $table4_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
    $data4_plg = mysqli_fetch_array($table4_plg);
    $jml_listrik_plg = $data4_plg['jumlah_listrik'];
     if (!isset($data4_plg['jumlah_listrik'])) {
     $jml_listrik_plg = 0;
     }

     //pengeluran Pul Listrik & Telepon belitung
    $table4_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
    $data4_bb = mysqli_fetch_array($table4_bb);
    $jml_listrik_bb = $data4_bb['jumlah_listrik'];
     if (!isset($data4_bb['jumlah_listrik'])) {
     $jml_listrik_bb = 0;
     }
     //pengeluran Pul Listrik & Telepon bangka
    $table4_bk = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_bk WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
    $data4_bk = mysqli_fetch_array($table4_bk);
    $jml_listrik_bk = $data4_bk['jumlah_listrik'];
     if (!isset($data4_bk['jumlah_listrik'])) {
     $jml_listrik_bk = 0;
     }
     //pengeluran Pul Listrik & Telepon bengkulu
   $table4_bkl = mysqli_query($koneksistre, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
   $data4_bkl = mysqli_fetch_array($table4_bkl);
   $jml_listrik_bkl = $data4_bkl['jumlah_listrik'];
    if (!isset($data4_bkl['jumlah_listrik'])) {
    $jml_listrik_bkl = 0;
    }

     $listrik_global = $jml_listrik_br + $jml_listrik_lmg + $jml_listrik_plg + $jml_listrik_bb + $jml_listrik_bk + $jml_listrik_bkl;

    // BIAYA SEWA
   //pengeluran Biaya Sewa baturaja
   $table5_br = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
   $data5_br = mysqli_fetch_array($table5_br);
   $jml_sewa_br = $data5_br['jumlah_sewa'];
    if (!isset($data5_br['jumlah_sewa'])) {
    $jml_sewa_br = 0;
    }
    //pengeluran Biaya Sewa lampung
   $table5_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
   $data5_lmg = mysqli_fetch_array($table5_lmg);
   $jml_sewa_lmg = $data5_lmg['jumlah_sewa'];
    if (!isset($data5_lmg['jumlah_sewa'])) {
    $jml_sewa_lmg = 0;
    }
    //pengeluran Biaya Sewa Palembang
    $table5_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
    $data5_plg = mysqli_fetch_array($table5_plg);
    $jml_sewa_plg = $data5_plg['jumlah_sewa'];
     if (!isset($data5_plg['jumlah_sewa'])) {
     $jml_sewa_plg = 0;
     }
     //pengeluran Biaya Sewa Belitung
    $table5_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
    $data5_bb = mysqli_fetch_array($table5_bb);
    $jml_sewa_bb = $data5_bb['jumlah_sewa'];
     if (!isset($data5_bb['jumlah_sewa'])) {
     $jml_sewa_bb = 0;
     }

     //pengeluran Biaya Sewa Belitung
    $table5_bk = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_bk WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
    $data5_bk = mysqli_fetch_array($table5_bk);
    $jml_sewa_bk = $data5_bk['jumlah_sewa'];
     if (!isset($data5_bk['jumlah_sewa'])) {
     $jml_sewa_bk = 0;
     }
     //pengeluran Biaya Sewa bengkulu
   $table5_bkl = mysqli_query($koneksistre, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
   $data5_bkl = mysqli_fetch_array($table5_bkl);
   $jml_sewa_bkl = $data5_bkl['jumlah_sewa'];
    if (!isset($data5_bkl['jumlah_sewa'])) {
    $jml_sewa_bkl = 0;
    }

     $biaya_sewa_global = $jml_sewa_br + $jml_sewa_lmg + $jml_sewa_plg + $jml_sewa_bb + $jml_sewa_bk + $jml_sewa_bkl;

    // ATK
   //pengeluran Alat Tulis Kantor baturaja
   $table6_br = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_br = mysqli_fetch_array($table6_br);
   $jml_atk_br = $data6_br['jumlah_atk'];
    if (!isset($data6_br['jumlah_atk'])) {
    $jml_atk_br = 0;
    }
    //pengeluran Alat Tulis Kantor lampung
   $table6_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_lmg = mysqli_fetch_array($table6_lmg);
   $jml_atk_lmg = $data6_lmg['jumlah_atk'];
    if (!isset($data6_lmg['jumlah_atk'])) {
    $jml_atk_lmg = 0;
    }
    //pengeluran Alat Tulis Kantor palembang
   $table6_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_plg = mysqli_fetch_array($table6_plg);
   $jml_atk_plg = $data6_plg['jumlah_atk'];
    if (!isset($data6_plg['jumlah_atk'])) {
    $jml_atk_plg = 0;
    }
    //pengeluran Alat Tulis Kantor belitung
   $table6_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_bb = mysqli_fetch_array($table6_bb);
   $jml_atk_bb = $data6_bb['jumlah_atk'];
    if (!isset($data6_bb['jumlah_atk'])) {
    $jml_atk_bb = 0;
    }
    //pengeluran Alat Tulis Kantor belitung
   $table6_bk = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_bk WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_bk = mysqli_fetch_array($table6_bk);
   $jml_atk_bk = $data6_bk['jumlah_atk'];
    if (!isset($data6_bk['jumlah_atk'])) {
    $jml_atk_bk = 0;
    }
    //pengeluran Alat Tulis Kantor bengkulu
   $table6_bkl = mysqli_query($koneksistre, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_bkl = mysqli_fetch_array($table6_bkl);
   $jml_atk_bkl = $data6_bkl['jumlah_atk'];
    if (!isset($data6_bkl['jumlah_atk'])) {
    $jml_atk_bkl = 0;
    }

    $atk_global = $jml_atk_br + $jml_atk_lmg + $jml_atk_plg + $jml_atk_bb + $jml_atk_bk + $jml_atk_bkl;

    //TRANSPORT DAN PERJALANAN DINAS
    //pengeluran Transnport / Perjalanan Dinas baturaja
   $table61_br = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_br = mysqli_fetch_array($table61_br);
   $jml_transport_br = $data61_br['jumlah_transport'];
    if (!isset($data61_br['jumlah_transport'])) {
    $jml_transport_br = 0;
    }
    //pengeluran Transnport / Perjalanan Dinas lampung
   $table61_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_lmg = mysqli_fetch_array($table61_lmg);
   $jml_transport_lmg = $data61_lmg['jumlah_transport'];
    if (!isset($data61_lmg['jumlah_transport'])) {
    $jml_transport_lmg = 0;
    }
    //pengeluran Transnport / Perjalanan Dinas palembang
   $table61_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_plg = mysqli_fetch_array($table61_plg);
   $jml_transport_plg = $data61_plg['jumlah_transport'];
    if (!isset($data61_plg['jumlah_transport'])) {
    $jml_transport_plg = 0;
    }
     //pengeluran Transnport / Perjalanan Dinas belitung
   $table61_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_bb = mysqli_fetch_array($table61_bb);
   $jml_transport_bb = $data61_bb['jumlah_transport'];
    if (!isset($data61_bb['jumlah_transport'])) {
    $jml_transport_bb = 0;
    }

    //pengeluran Transnport / Perjalanan Dinas bangka
   $table61_bk = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul_bk WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_bk = mysqli_fetch_array($table61_bk);
   $jml_transport_bk = $data61_bk['jumlah_transport'];
    if (!isset($data61_bk['jumlah_transport'])) {
    $jml_transport_bk = 0;
    }
    //pengeluran Transnport / Perjalanan Dinas lampung
   $table61_bkl = mysqli_query($koneksistre, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_bkl = mysqli_fetch_array($table61_bkl);
   $jml_transport_bkl = $data61_bkl['jumlah_transport'];
    if (!isset($data61_bkl['jumlah_transport'])) {
    $jml_transport_bkl = 0;
    }


    $transport_global = $jml_transport_br + $jml_transport_lmg + $jml_transport_plg + $jml_transport_bb + $jml_transport_bk + $jml_transport_bkl;
    
    // BIAYA KONSUMSI
    //pengeluran Biaya Konsumsi baturaja
   $table62_br = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_br = mysqli_fetch_array($table62_br);
   $jml_konsumsi_br= $data62_br['jumlah_konsumsi'];
    if (!isset($data62_br['jumlah_konsumsi'])) {
    $jml_konsumsi_br = 0;
    }
    //pengeluran Biaya Konsumsi lampung
   $table62_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_lmg = mysqli_fetch_array($table62_lmg);
   $jml_konsumsi_lmg = $data62_lmg['jumlah_konsumsi'];
    if (!isset($data62_lmg['jumlah_konsumsi'])) {
    $jml_konsumsi_lmg = 0;
    }
    //pengeluran Biaya Konsumsi palembang
   $table62_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_plg = mysqli_fetch_array($table62_plg);
   $jml_konsumsi_plg = $data62_plg['jumlah_konsumsi'];
    if (!isset($data62_plg['jumlah_konsumsi'])) {
    $jml_konsumsi_plg = 0;
    }
    //pengeluran Biaya Konsumsi belitung
   $table62_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_bb = mysqli_fetch_array($table62_bb);
   $jml_konsumsi_bb = $data62_bb['jumlah_konsumsi'];
    if (!isset($data62_bb['jumlah_konsumsi'])) {
    $jml_konsumsi_bb = 0;
    }

        //pengeluran Biaya Konsumsi bangka
   $table62_bk = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul_bk WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_bk = mysqli_fetch_array($table62_bk);
   $jml_konsumsi_bk = $data62_bk['jumlah_konsumsi'];
    if (!isset($data62_bk['jumlah_konsumsi'])) {
    $jml_konsumsi_bk = 0;
    }
    //pengeluran Biaya Konsumsi bengkulu
   $table62_bkl = mysqli_query($koneksistre, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_bkl = mysqli_fetch_array($table62_bkl);
   $jml_konsumsi_bkl = $data62_bkl['jumlah_konsumsi'];
    if (!isset($data62_bkl['jumlah_konsumsi'])) {
    $jml_konsumsi_bkl = 0;
    }

     $konsumsi_global = $jml_konsumsi_br + $jml_konsumsi_lmg + $jml_konsumsi_plg + $jml_konsumsi_bb + $jml_konsumsi_bk + $jml_konsumsi_bkl;

    //PERBAIKAN
    //pengeluran perbaikan baturaja
   $table7_br = mysqli_query($koneksibalsri, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_br = mysqli_fetch_array($table7_br);
   $jml_perbaikan_br = $data7_br['jumlah_perbaikan'];
    if (!isset($data7_br['jumlah_perbaikan'])) {
    $jml_perbaikan_br = 0;
    }
    //pengeluran perbaikan lampung
   $table7_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_lmg = mysqli_fetch_array($table7_lmg);
   $jml_perbaikan_lmg = $data7_lmg['jumlah_perbaikan'];
    if (!isset($data7_lmg['jumlah_perbaikan'])) {
    $jml_perbaikan_lmg= 0;
    }
    //pengeluran perbaikan palembang
   $table7_plg = mysqli_query($koneksibalsri, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_plg = mysqli_fetch_array($table7_plg);
   $jml_perbaikan_plg = $data7_plg['jumlah_perbaikan'];
    if (!isset($data7_plg['jumlah_perbaikan'])) {
    $jml_perbaikan_plg = 0;
    }
    //pengeluran perbaikan belitung
   $table7_bb = mysqli_query($koneksibalsri, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_bb = mysqli_fetch_array($table7_bb);
   $jml_perbaikan_bb = $data7_bb['jumlah_perbaikan'];
    if (!isset($data7_bb['jumlah_perbaikan'])) {
    $jml_perbaikan_bb = 0;
    }
    
        //pengeluran perbaikan bangka
   $table7_bk = mysqli_query($koneksibalsri, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_bk WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_bk = mysqli_fetch_array($table7_bk);
   $jml_perbaikan_bk = $data7_bk['jumlah_perbaikan'];
    if (!isset($data7_bk['jumlah_perbaikan'])) {
    $jml_perbaikan_bk = 0;
    }

    //pengeluran perbaikan bengkulu
   $table7_bkl = mysqli_query($koneksistre, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_bkl = mysqli_fetch_array($table7_bkl);
   $jml_perbaikan_bkl = $data7_bkl['jumlah_perbaikan'];
    if (!isset($data7_bkl['jumlah_perbaikan'])) {
    $jml_perbaikan_bkl= 0;
    }
    
    $perbaikan_global = $jml_perbaikan_br + $jml_perbaikan_lmg + $jml_perbaikan_plg + $jml_perbaikan_bb + $jml_perbaikan_bk + $jml_perbaikan_bkl;
    
    // GAJI KARYAWAN
     //Gaji karyawan baturaja
   $table8_br = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI BTA' ");
   $data8_br = mysqli_fetch_array($table8_br);
   $gaji_karyawan_br = $data8_br['jumlah_gaji'];
    if (!isset($data8_br['jumlah_gaji'])) {
    $gaji_karyawan_br = 0;
    }
    //Gaji karyawan llampung
   $table8_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI LMG' ");
   $data8_lmg = mysqli_fetch_array($table8_lmg);
   $gaji_karyawan_lmg = $data8_lmg['jumlah_gaji'];
    if (!isset($data8_lmg['jumlah_gaji'])) {
    $gaji_karyawan_lmg= 0;
    }
    //Gaji karyawan palebang
   $table8_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI PLG' ");
   $data8_plg = mysqli_fetch_array($table8_plg);
   $gaji_karyawan_plg = $data8_plg['jumlah_gaji'];
    if (!isset($data8_plg['jumlah_gaji'])) {
    $gaji_karyawan_plg = 0;
    }
     //Gaji karyawan belitung
   $table8_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI BL' ");
   $data8_bb = mysqli_fetch_array($table8_bb);
   $gaji_karyawan_bb = $data8_bb['jumlah_gaji'];
    if (!isset($data8_bb['jumlah_gaji'])) {
    $gaji_karyawan_bb = 0;
    }

    //Gaji karyawan bangka
   $table8_bk = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI BK' ");
   $data8_bk = mysqli_fetch_array($table8_bk);
   $gaji_karyawan_bk = $data8_bk['jumlah_gaji'];
    if (!isset($data8_bk['jumlah_gaji'])) {
    $gaji_karyawan_bk = 0;
    }

    $gaji_karyawan_global = $gaji_karyawan_br + $gaji_karyawan_lmg + $gaji_karyawan_plg + $gaji_karyawan_bb + $gaji_karyawan_bk;

    // GAJI DRIVER
    //Gaji dRIVER baturaja
   $table9_br = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Driver BTA' ");
   $data9_br = mysqli_fetch_array($table9_br);
   $gaji_driver_br = $data9_br['jumlah_gaji'];
    if (!isset($data9_br['jumlah_gaji'])) {
    $gaji_driver_br = 0;
    }
    //Gaji dRIVER lampung
   $table9_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Driver LMG' ");
   $data9_lmg = mysqli_fetch_array($table9_lmg);
   $gaji_driver_lmg = $data9_lmg['jumlah_gaji'];
    if (!isset($data9_lmg['jumlah_gaji'])) {
    $gaji_driver_lmg = 0;
    }
    //Gaji dRIVER palembang
   $table9_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Driver PLG' ");
   $data9_plg = mysqli_fetch_array($table9_plg);
   $gaji_driver_plg = $data9_plg['jumlah_gaji'];
    if (!isset($data9_plg['jumlah_gaji'])) {
    $gaji_driver_plg = 0;
    }
     //Gaji dRIVER belitung
   $table9_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Driver BL' ");
   $data9_bb = mysqli_fetch_array($table9_bb);
   $gaji_driver_bb = $data9_bb['jumlah_gaji'];
    if (!isset($data9_bb['jumlah_gaji'])) {
    $gaji_driver_bb = 0;
    }

         //Gaji dRIVER belitung
   $table9_bk = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Driver BK' ");
   $data9_bk = mysqli_fetch_array($table9_bk);
   $gaji_driver_bk = $data9_bk['jumlah_gaji'];
    if (!isset($data9_bk['jumlah_gaji'])) {
    $gaji_driver_bk = 0;
    }
    //Gaji dRIVER bengkulu
   $table9_bkl = mysqli_query($koneksistre, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI BKU' ");
   $data9_bkl = mysqli_fetch_array($table9_bkl);
   $gaji_driver_bkl = $data9_bkl['jumlah_gaji'];
    if (!isset($data9_bkl['jumlah_gaji'])) {
    $gaji_driver_bkl = 0;
    }
    
    $gaji_driver_global = $gaji_driver_br + $gaji_driver_lmg + $gaji_driver_plg + $gaji_driver_bb + $gaji_driver_bk + $gaji_driver_bkl;
    
    $total_gaji_karaywan_global = $gaji_karyawan_global + $gaji_driver_global + $gaji_driver_bb;


    //totalkreditGLOBAL
    $tablee_bku = mysqli_query($koneksistre, "SELECT SUM(jumlah) AS total_kredit FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $dataa_bku = mysqli_fetch_array($tablee_bku);
    $total_kredit_bku = $dataa_bku['total_kredit'];

        $tablee = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
        $dataa = mysqli_fetch_array($tablee);
        $total_kredit= $dataa['total_kredit'];

        $total_kredit = $total_kredit + $total_kredit_bku;



// Denda Kredit
    // Denda Kredit baturaja
    $table62_br_x = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_denda_kredit FROM pengeluaran_pul_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Denda Kredit' ");
    $data62_br_x = mysqli_fetch_array($table62_br_x);
    $total_denda_kredit_br = $data62_br_x['jumlah_denda_kredit'];
     if (!isset($data62_br_x['jumlah_denda_kredit'])) {
     $total_denda_kredit_br = 0;
     }
     // Denda Kredit lampung
    $table62_lmgx = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_denda_kredit FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Denda Kredit' ");
    $data62_lmgx = mysqli_fetch_array($table62_lmgx);
    $total_denda_kredit_lmg = $data62_lmgx['jumlah_denda_kredit'];
     if (!isset($data62_lmgx['jumlah_denda_kredit'])) {
     $total_denda_kredit_lmg = 0;
     }
     // Denda Kredit palembang
    $table62_plgx = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_denda_kredit FROM pengeluaran_pul_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Denda Kredit' ");
    $data62_plgx = mysqli_fetch_array($table62_plgx);
    $total_denda_kredit_plg = $data62_plgx['jumlah_denda_kredit'];
     if (!isset($data62_plgx['jumlah_denda_kredit'])) {
     $total_denda_kredit_plg = 0;
     }
     // Denda Kredit belitung
    $table62_bbx = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_denda_kredit FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Denda Kredit' ");
    $data62_bbx = mysqli_fetch_array($table62_bbx);
    $total_denda_kredit_bb = $data62_bbx['jumlah_denda_kredit'];
     if (!isset($data62_bbx['jumlah_denda_kredit'])) {
     $total_denda_kredit_bb = 0;
     }
 
    // Denda Kredit bangka
    $table62_bkx = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_denda_kredit FROM pengeluaran_pul_bk WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Denda Kredit' ");
    $data62_bkx = mysqli_fetch_array($table62_bkx);
    $total_denda_kredit_bk = $data62_bkx['jumlah_denda_kredit'];
     if (!isset($data62_bkx['jumlah_denda_kredit'])) {
     $total_denda_kredit_bk = 0;
     }
     // Denda Kredit bengkulu
    $table62_bklx = mysqli_query($koneksistre, "SELECT SUM(jumlah) AS jumlah_denda_kredit FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Denda Kredit' ");
    $data62_bklx = mysqli_fetch_array($table62_bklx);
    $total_denda_kredit_bkl = $data62_bklx['jumlah_denda_kredit'];
     if (!isset($data62_bklx['jumlah_denda_kredit'])) {
     $total_denda_kredit_bkl = 0;
     }
 
      $denda_kredit_global = $total_denda_kredit_br + $total_denda_kredit_lmg + $total_denda_kredit_plg + $total_denda_kredit_bb + $total_denda_kredit_bk + $total_denda_kredit_bkl;







        


          //TAGIHAN JBB
    // Tagihan balongan
    $table_ba = mysqli_query($koneksibalsri_jbb, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_ba a INNER JOIN master_tarif_ba b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data_ba = mysqli_fetch_array($table_ba);
    $total_tagihan_ba = $data_ba['total_tagihan'];

    // Tagihan padalarang
    $table_pa = mysqli_query($koneksibalsri_jbb, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_pa a INNER JOIN master_tarif_pa b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data_pa = mysqli_fetch_array($table_pa);
    $total_tagihan_pa = $data_pa['total_tagihan'];

    // Tagihan plumpang 
    $table_pl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_pl a INNER JOIN master_tarif_pl b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data_pl = mysqli_fetch_array($table_pl);
    $total_tagihan_pl = $data_pl['total_tagihan'];

    // Tagihan tanjung gerem
    $table_tg = mysqli_query($koneksibalsri_jbb, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_tg a INNER JOIN master_tarif_tg b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data_tg = mysqli_fetch_array($table_tg);
    $total_tagihan_tg = $data_tg['total_tagihan'];



    // Tagihan ujung berung
    $table_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_ub a INNER JOIN master_tarif_ub b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data_ub = mysqli_fetch_array($table_ub);
    $total_tagihan_ub = $data_ub['total_tagihan'];



  $total_tagihan_global_jbb = $total_tagihan_ba + $total_tagihan_pa + $total_tagihan_pl + $total_tagihan_tg  + $total_tagihan_ub ;

  // Potongan global 10%
  $jumlah_potongan_global_jbb = (($total_tagihan_global_jbb * 10) / 100);

  //PENGIRIMAN
  //pengiriman balongan
   $table2_ba = mysqli_query($koneksibalsri_jbb, "SELECT SUM(um) AS uang_makan , SUM(jt_gps) as total_jt_gps , SUM(uj) AS total_uj FROM pengiriman_ba WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $total_dexlite_ba =0;
   $data2_ba = mysqli_fetch_array($table2_ba);
   $total_uj_ba = $data2_ba['total_uj'];
   $total_jt_gps_ba = $data2_ba['total_jt_gps'];
   $total_um_ba = $data2_ba['uang_makan'];
   $total_dexlite_ba = $total_uj_ba - ($total_jt_gps_ba*625);

  //pengiriman padalarang
   $table2_pa = mysqli_query($koneksibalsri_jbb, "SELECT SUM(um) AS uang_makan , SUM(jt_gps) as total_jt_gps , SUM(uj) AS total_uj  FROM pengiriman_pa WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $total_dexlite_pa =0;
   $data2_pa = mysqli_fetch_array($table2_pa);
   $total_uj_pa = $data2_pa['total_uj'];
   $total_jt_gps_pa = $data2_pa['total_jt_gps'];
   $total_um_pa = $data2_pa['uang_makan'];
   $total_dexlite_pa = $total_uj_pa - ($total_jt_gps_pa*625);

    //pengiriman plumpang
    $table2_pl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(um) AS uang_makan , SUM(jt_gps) as total_jt_gps , SUM(uj) AS total_uj  FROM pengiriman_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $total_dexlite_pl =0;
    $data2_pl = mysqli_fetch_array($table2_pl);
    $total_uj_pl = $data2_pl['total_uj'];
    $total_jt_gps_pl = $data2_pl['total_jt_gps'];
    $total_um_pl = $data2_pl['uang_makan'];
    $total_dexlite_pl = $total_uj_pl - ($total_jt_gps_pl*625);


   //pengiriman tanjung gerem
   $table2_tg = mysqli_query($koneksibalsri_jbb, "SELECT SUM(um) AS uang_makan , SUM(jt_gps) as total_jt_gps , SUM(uj) AS total_uj  FROM pengiriman_tg WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $total_dexlite_tg =0;
   $data2_tg = mysqli_fetch_array($table2_tg);
   $total_uj_tg = $data2_tg['total_uj'];
   $total_jt_gps_tg = $data2_tg['total_jt_gps'];
   $total_um_tg = $data2_tg['uang_makan'];
   $total_dexlite_tg = $total_uj_tg - ($total_jt_gps_tg*625);


   //pengiriman ujung berung
   $table2_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(um) AS uang_makan , SUM(jt_gps) as total_jt_gps , SUM(uj) AS total_uj  FROM pengiriman_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $total_dexlite_ub =0;
   $data2_ub = mysqli_fetch_array($table2_ub);
   $total_uj_ub = $data2_ub['total_uj'];
   $total_jt_gps_ub = $data2_ub['total_jt_gps'];
   $total_um_ub = $data2_ub['uang_makan'];
   $total_dexlite_ub = $total_uj_ub - ($total_jt_gps_ub*625);

  
    
   $total_dexlite_global_jbb = $total_dexlite_ba + $total_dexlite_pa  + $total_dexlite_pl + $total_dexlite_tg  + $total_dexlite_ub;
    $total_um_global_jbb = $total_um_ba + $total_um_pa + $total_um_pl + $total_um_tg  +  $total_um_ub;
    $total_bbm_global_jbb = 0;

    //BIAYA KANTOR
  //pengeluran Pul Biaya Kantor balongan
   $table3_ba = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_ba WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
   $data3_ba = mysqli_fetch_array($table3_ba);
   $jml_biaya_kantor_ba = $data3_ba['jumlah_biaya_kantor'];
    if (!isset($data3_ba['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor_ba = 0;
    }
    //pengeluran Pul Biaya Kantor padalarang
   $table3_pa = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_pa WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
   $data3_pa = mysqli_fetch_array($table3_pa);
   $jml_biaya_kantor_pa = $data3_pa['jumlah_biaya_kantor'];
    if (!isset($data3_pa['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor_pa = 0;
    }
    //pengeluran Pul Biaya Kantor plumpang
    $table3_pl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
    $data3_pl = mysqli_fetch_array($table3_pl);
    $jml_biaya_kantor_pl = $data3_pl['jumlah_biaya_kantor'];
     if (!isset($data3_pl['jumlah_biaya_kantor'])) {
     $jml_biaya_kantor_pl = 0;
     }
     //pengeluran Pul Biaya Kantor tanjung gerem
    $table3_tg = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_tg WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
    $data3_tg = mysqli_fetch_array($table3_tg);
    $jml_biaya_kantor_tg = $data3_tg['jumlah_biaya_kantor'];
     if (!isset($data3_tg['jumlah_biaya_kantor'])) {
     $jml_biaya_kantor_tg = 0;
     }

     //pengeluran Pul Biaya Kantor ujung berung
   $table3_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
   $data3_ub = mysqli_fetch_array($table3_ub);
   $jml_biaya_kantor_ub = $data3_ub['jumlah_biaya_kantor'];
    if (!isset($data3_ub['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor_ub = 0;
    }

     $biaya_kantor_global_jbb = $jml_biaya_kantor_ba + $jml_biaya_kantor_pa + $jml_biaya_kantor_pl + $jml_biaya_kantor_tg  + $jml_biaya_kantor_ub;

    // LISTRIK & TELEPON
   //pengeluran Pul Listrik & Telepon balongan
   $table4_ba = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_ba WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
   $data4_ba = mysqli_fetch_array($table4_ba);
   $jml_listrik_ba = $data4_ba['jumlah_listrik'];
    if (!isset($data4_ba['jumlah_listrik'])) {
    $jml_listrik_ba = 0;
    }
    //pengeluran Pul Listrik & Telepon padalarang
   $table4_pa = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_pa WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
   $data4_pa = mysqli_fetch_array($table4_pa);
   $jml_listrik_pa = $data4_pa['jumlah_listrik'];
    if (!isset($data4_pa['jumlah_listrik'])) {
    $jml_listrik_pa = 0;
    }
    //pengeluran Pul Listrik & Telepon plumpang
    $table4_pl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
    $data4_pl = mysqli_fetch_array($table4_pl);
    $jml_listrik_pl = $data4_pl['jumlah_listrik'];
     if (!isset($data4_pl['jumlah_listrik'])) {
     $jml_listrik_pl = 0;
     }

     //pengeluran Pul Listrik & Telepon tanjung gerem
    $table4_tg = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_tg WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
    $data4_tg = mysqli_fetch_array($table4_tg);
    $jml_listrik_tg = $data4_tg['jumlah_listrik'];
     if (!isset($data4_tg['jumlah_listrik'])) {
     $jml_listrik_tg = 0;
     }

     //pengeluran Pul Listrik & Telepon ujung berung
   $table4_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
   $data4_ub = mysqli_fetch_array($table4_ub);
   $jml_listrik_ub = $data4_ub['jumlah_listrik'];
    if (!isset($data4_ub['jumlah_listrik'])) {
    $jml_listrik_ub = 0;
    }

     $listrik_global_jbb = $jml_listrik_ba + $jml_listrik_pa + $jml_listrik_pl + $jml_listrik_tg  + $jml_listrik_ub;

    // BIAYA SEWA
   //pengeluran Biaya Sewa balongan
   $table5_ba = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_ba WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
   $data5_ba = mysqli_fetch_array($table5_ba);
   $jml_sewa_ba = $data5_ba['jumlah_sewa'];
    if (!isset($data5_ba['jumlah_sewa'])) {
    $jml_sewa_ba = 0;
    }
    //pengeluran Biaya Sewa padalarang
   $table5_pa = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_pa WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
   $data5_pa = mysqli_fetch_array($table5_pa);
   $jml_sewa_pa = $data5_pa['jumlah_sewa'];
    if (!isset($data5_pa['jumlah_sewa'])) {
    $jml_sewa_pa = 0;
    }
    //pengeluran Biaya Sewa plumpang
    $table5_pl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
    $data5_pl = mysqli_fetch_array($table5_pl);
    $jml_sewa_pl = $data5_pl['jumlah_sewa'];
     if (!isset($data5_pl['jumlah_sewa'])) {
     $jml_sewa_pl = 0;
     }
     //pengeluran Biaya Sewa tanjung gerem
    $table5_tg = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_tg WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
    $data5_tg = mysqli_fetch_array($table5_tg);
    $jml_sewa_tg = $data5_tg['jumlah_sewa'];
     if (!isset($data5_tg['jumlah_sewa'])) {
     $jml_sewa_tg = 0;
     }


     //pengeluran Biaya Sewa ujung berung
   $table5_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
   $data5_ub = mysqli_fetch_array($table5_ub);
   $jml_sewa_ub = $data5_ub['jumlah_sewa'];
    if (!isset($data5_ub['jumlah_sewa'])) {
    $jml_sewa_ub = 0;
    }

     $biaya_sewa_global_jbb = $jml_sewa_ba + $jml_sewa_pa + $jml_sewa_pl + $jml_sewa_tg  + $jml_sewa_ub;

    // ATK
   //pengeluran Alat Tulis Kantor balongan
   $table6_ba = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_ba WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_ba = mysqli_fetch_array($table6_ba);
   $jml_atk_ba = $data6_ba['jumlah_atk'];
    if (!isset($data6_ba['jumlah_atk'])) {
    $jml_atk_ba = 0;
    }
    //pengeluran Alat Tulis Kantor padalarang
   $table6_pa = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_pa WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_pa = mysqli_fetch_array($table6_pa);
   $jml_atk_pa = $data6_pa['jumlah_atk'];
    if (!isset($data6_pa['jumlah_atk'])) {
    $jml_atk_pa = 0;
    }
    //pengeluran Alat Tulis Kantor plumpang
   $table6_pl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_pl = mysqli_fetch_array($table6_pl);
   $jml_atk_pl = $data6_pl['jumlah_atk'];
    if (!isset($data6_pl['jumlah_atk'])) {
    $jml_atk_pl = 0;
    }
    //pengeluran Alat Tulis Kantor tanjung gerem
   $table6_tg = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_tg WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_tg = mysqli_fetch_array($table6_tg);
   $jml_atk_tg = $data6_tg['jumlah_atk'];
    if (!isset($data6_tg['jumlah_atk'])) {
    $jml_atk_tg = 0;
    }

    //pengeluran Alat Tulis Kantor ujung berung
   $table6_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_ub = mysqli_fetch_array($table6_ub);
   $jml_atk_ub = $data6_ub['jumlah_atk'];
    if (!isset($data6_ub['jumlah_atk'])) {
    $jml_atk_ub = 0;
    }

    $atk_global_jbb = $jml_atk_ba + $jml_atk_pa + $jml_atk_pl + $jml_atk_tg  + $jml_atk_ub;

    //TRANSPORT DAN PERJALANAN DINAS
    //pengeluran Transnport / Perjalanan Dinas balongan
   $table61_ba = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul_ba WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_ba = mysqli_fetch_array($table61_ba);
   $jml_transport_ba = $data61_ba['jumlah_transport'];
    if (!isset($data61_ba['jumlah_transport'])) {
    $jml_transport_ba = 0;
    }
    //pengeluran Transnport / Perjalanan Dinas padalarang
   $table61_pa = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul_pa WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_pa = mysqli_fetch_array($table61_pa);
   $jml_transport_pa = $data61_pa['jumlah_transport'];
    if (!isset($data61_pa['jumlah_transport'])) {
    $jml_transport_pa = 0;
    }
    //pengeluran Transnport / Perjalanan Dinas plumpang
   $table61_pl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_pl = mysqli_fetch_array($table61_pl);
   $jml_transport_pl = $data61_pl['jumlah_transport'];
    if (!isset($data61_pl['jumlah_transport'])) {
    $jml_transport_pl = 0;
    }
     //pengeluran Transnport / Perjalanan Dinas tanjung gerem
   $table61_tg = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul_tg WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_tg = mysqli_fetch_array($table61_tg);
   $jml_transport_tg = $data61_tg['jumlah_transport'];
    if (!isset($data61_tg['jumlah_transport'])) {
    $jml_transport_tg = 0;
    }


    //pengeluran Transnport / Perjalanan Dinas ujung berung
   $table61_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_ub = mysqli_fetch_array($table61_ub);
   $jml_transport_ub = $data61_ub['jumlah_transport'];
    if (!isset($data61_ub['jumlah_transport'])) {
    $jml_transport_ub = 0;
    }


    $transport_global_jbb = $jml_transport_ba + $jml_transport_pa + $jml_transport_pl + $jml_transport_tg  + $jml_transport_ub;
    
    // BIAYA KONSUMSI
    //pengeluran Biaya Konsumsi balongan
   $table62_ba = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul_ba WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_ba = mysqli_fetch_array($table62_ba);
   $jml_konsumsi_ba = $data62_ba['jumlah_konsumsi'];
    if (!isset($data62_ba['jumlah_konsumsi'])) {
    $jml_konsumsi_ba = 0;
    }
    //pengeluran Biaya Konsumsi padalarang
   $table62_pa = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul_pa WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_pa = mysqli_fetch_array($table62_pa);
   $jml_konsumsi_pa = $data62_pa['jumlah_konsumsi'];
    if (!isset($data62_pa['jumlah_konsumsi'])) {
    $jml_konsumsi_pa = 0;
    }
    //pengeluran Biaya Konsumsi plumpang
   $table62_pl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_pl = mysqli_fetch_array($table62_pl);
   $jml_konsumsi_pl = $data62_pl['jumlah_konsumsi'];
    if (!isset($data62_pl['jumlah_konsumsi'])) {
    $jml_konsumsi_pl = 0;
    }
    //pengeluran Biaya Konsumsi tanjung gerem
   $table62_tg = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul_tg WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_tg = mysqli_fetch_array($table62_tg);
   $jml_konsumsi_tg = $data62_tg['jumlah_konsumsi'];
    if (!isset($data62_tg['jumlah_konsumsi'])) {
    $jml_konsumsi_tg = 0;
    }


    //pengeluran Biaya Konsumsi ujung berung
   $table62_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_ub = mysqli_fetch_array($table62_ub);
   $jml_konsumsi_ub = $data62_ub['jumlah_konsumsi'];
    if (!isset($data62_ub['jumlah_konsumsi'])) {
    $jml_konsumsi_ub = 0;
    }

     $konsumsi_global_jbb = $jml_konsumsi_ba + $jml_konsumsi_pa + $jml_konsumsi_pl + $jml_konsumsi_tg  + $jml_konsumsi_ub;

    //PERBAIKAN
    //pengeluran perbaikan balongan
   $table7_ba = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_ba WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_ba = mysqli_fetch_array($table7_ba);
   $jml_perbaikan_ba = $data7_ba['jumlah_perbaikan'];
    if (!isset($data7_ba['jumlah_perbaikan'])) {
    $jml_perbaikan_ba = 0;
    }
    //pengeluran perbaikan padalarang
   $table7_pa = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_pa WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_pa = mysqli_fetch_array($table7_pa);
   $jml_perbaikan_pa = $data7_pa['jumlah_perbaikan'];
    if (!isset($data7_pa['jumlah_perbaikan'])) {
    $jml_perbaikan_pa = 0;
    }
    //pengeluran perbaikan plumpang
   $table7_pl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_pl = mysqli_fetch_array($table7_pl);
   $jml_perbaikan_pl = $data7_pl['jumlah_perbaikan'];
    if (!isset($data7_pl['jumlah_perbaikan'])) {
    $jml_perbaikan_pl = 0;
    }
    //pengeluran perbaikan tanjung gerem
   $table7_tg = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_tg WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_tg = mysqli_fetch_array($table7_tg);
   $jml_perbaikan_tg = $data7_tg['jumlah_perbaikan'];
    if (!isset($data7_tg['jumlah_perbaikan'])) {
    $jml_perbaikan_tg = 0;
    }
    

    //pengeluran perbaikan ujung berung
   $table7_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_ub = mysqli_fetch_array($table7_ub);
   $jml_perbaikan_ub = $data7_ub['jumlah_perbaikan'];
    if (!isset($data7_ub['jumlah_perbaikan'])) {
    $jml_perbaikan_ub= 0;
    }
    
    $perbaikan_global_jbb = $jml_perbaikan_ba + $jml_perbaikan_pa + $jml_perbaikan_pl + $jml_perbaikan_tg  + $jml_perbaikan_ub;
    
    // GAJI KARYAWAN
     //Gaji karyawan balongan
   $table8_ba = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI BA' ");
   $data8_ba = mysqli_fetch_array($table8_ba);
   $gaji_karyawan_ba = $data8_ba['jumlah_gaji'];
    if (!isset($data8_ba['jumlah_gaji'])) {
    $gaji_karyawan_ba = 0;
    }
    //Gaji karyawan Padalarang
   $table8_pa = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI PA' ");
   $data8_pa = mysqli_fetch_array($table8_pa);
   $gaji_karyawan_pa = $data8_pa['jumlah_gaji'];
    if (!isset($data8_pa['jumlah_gaji'])) {
    $gaji_karyawan_pa = 0;
    }
    //Gaji karyawan plumpang
   $table8_pl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI PL' ");
   $data8_pl = mysqli_fetch_array($table8_pl);
   $gaji_karyawan_pl = $data8_pl['jumlah_gaji'];
    if (!isset($data8_pl['jumlah_gaji'])) {
    $gaji_karyawan_pl = 0;
    }
     //Gaji karyawan tanjung gerem
   $table8_tg = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI TG' ");
   $data8_tg = mysqli_fetch_array($table8_tg);
   $gaji_karyawan_tg = $data8_tg['jumlah_gaji'];
    if (!isset($data8_tg['jumlah_gaji'])) {
    $gaji_karyawan_tg = 0;
    }


    //Gaji karyawan Ujung berung
   $table8_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI UB' ");
   $data8_ub = mysqli_fetch_array($table8_ub);
   $gaji_karyawan_ub = $data8_ub['jumlah_gaji'];
    if (!isset($data8_ub['jumlah_gaji'])) {
    $gaji_karyawan_ub = 0;
    }

    $gaji_karyawan_global_jbb = $gaji_karyawan_ba + $gaji_karyawan_pa + $gaji_karyawan_pl + $gaji_karyawan_tg  + $gaji_karyawan_ub;

    // GAJI DRIVER
    //Gaji dRIVER balongan
   $table9_ba = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Driver BA' ");
   $data9_ba = mysqli_fetch_array($table9_ba);
   $gaji_driver_ba = $data9_ba['jumlah_gaji'];
    if (!isset($data9_ba['jumlah_gaji'])) {
    $gaji_driver_ba = 0;
    }
    //Gaji dRIVER padalarang
   $table9_pa = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Driver PA' ");
   $data9_pa = mysqli_fetch_array($table9_pa);
   $gaji_driver_pa = $data9_pa['jumlah_gaji'];
    if (!isset($data9_pa['jumlah_gaji'])) {
    $gaji_driver_pa = 0;
    }
    //Gaji dRIVER plumpang
   $table9_pl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Driver PL' ");
   $data9_pl = mysqli_fetch_array($table9_pl);
   $gaji_driver_pl = $data9_pl['jumlah_gaji'];
    if (!isset($data9_pl['jumlah_gaji'])) {
    $gaji_driver_pl = 0;
    }
     //Gaji dRIVER tanjung gerem
   $table9_tg = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Driver TG' ");
   $data9_tg = mysqli_fetch_array($table9_tg);
   $gaji_driver_tg = $data9_tg['jumlah_gaji'];
    if (!isset($data9_tg['jumlah_gaji'])) {
    $gaji_driver_tg = 0;
    }


    //Gaji dRIVER ujung berung
   $table9_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI UB' ");
   $data9_ub = mysqli_fetch_array($table9_ub);
   $gaji_driver_ub = $data9_ub['jumlah_gaji'];
    if (!isset($data9_ub['jumlah_gaji'])) {
    $gaji_driver_ub = 0;
    }
    
    $gaji_driver_global_jbb = $gaji_driver_ba + $gaji_driver_pa + $gaji_driver_pl + $gaji_driver_tg  + $gaji_driver_ub;
    
    $total_gaji_karaywan_global_jbb = $gaji_karyawan_global + $gaji_driver_global ;


    //totalkreditGLOBAL
        $tablee_jbb = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS total_kredit FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
        $dataae = mysqli_fetch_array($tablee_jbb);
        $total_kredit_jbb= $dataae['total_kredit'];

        $total_kredit_jbb = $total_kredit_jbb;
        
        
 //Kredit Kendaraan Pribadi
$table180x = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit FROM kredit WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
$data_kredit = mysqli_fetch_array($table180x);
$total_kredit_kendaraan_pribadi = $data_kredit['total_kredit'];
if (!isset($data_kredit['total_kredit'])) {
    $total_kredit_kendaraan_pribadi = 0;
}

// Denda Kredit JBB
    // Denda Kredit balongan
    $table62_bax = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_denda_kredit FROM pengeluaran_pul_ba WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Denda Kredit' ");
    $data62_bax = mysqli_fetch_array($table62_bax);
    $denda_kredit_ba = $data62_bax['jumlah_denda_kredit'];
     if (!isset($data62_bax['jumlah_denda_kredit'])) {
     $denda_kredit_ba = 0;
     }
     //Denda Kredit padalarang
    $table62_pax = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_denda_kredit FROM pengeluaran_pul_pa WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Denda Kredit' ");
    $data62_pax = mysqli_fetch_array($table62_pax);
    $denda_kredit_pa = $data62_pax['jumlah_denda_kredit'];
     if (!isset($data62_pax['jumlah_denda_kredit'])) {
     $denda_kredit_pa = 0;
     }
     //Denda Kredit plumpang
    $table62_plx = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_denda_kredit FROM pengeluaran_pul_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Denda Kredit' ");
    $data62_plx = mysqli_fetch_array($table62_plx);
    $denda_kredit_pl = $data62_plx['jumlah_denda_kredit'];
     if (!isset($data62_plx['jumlah_denda_kredit'])) {
     $denda_kredit_pl = 0;
     }
     //Denda Kredit tanjung gerem
    $table62_tgx = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_denda_kredit FROM pengeluaran_pul_tg WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Denda Kredit' ");
    $data62_tgx = mysqli_fetch_array($table62_tgx);
    $denda_kredit_tg = $data62_tgx['jumlah_denda_kredit'];
     if (!isset($data62_tgx['jumlah_denda_kredit'])) {
     $denda_kredit_tg = 0;
     }
     //Denda Kredit ujung berung
    $table62_ubx = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_denda_kredit FROM pengeluaran_pul_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Denda Kredit' ");
    $data62_ubx = mysqli_fetch_array($table62_ubx);
    $denda_kredit_ub = $data62_ubx['jumlah_denda_kredit'];
     if (!isset($data62_ubx['jumlah_denda_kredit'])) {
     $denda_kredit_ub = 0;
     }
 
      $denda_kredit_global_jbb = $denda_kredit_ba + $denda_kredit_pa + $denda_kredit_pl + $denda_kredit_tg  + $denda_kredit_ub;



}

$kredit_8401 = 21220500;
$kredit_8403 = 21220500;
    
if($tahun == 2023){
    if($bulan == 1 || $bulan == 2 || $bulan == 3){
        $total_laba_kotor = ($total_tagihan_global + $total_tagihan_global_jbb) - ($jumlah_potongan_global + $jumlah_potongan_global_jbb);  
    }
    else if($bulan == 4 || $bulan == 5 || $bulan == 6 || $bulan == 7 || $bulan == 8 || $bulan == 9 || $bulan ==  10 || $bulan == 11 || $bulan == 12 ) {
        
        $total_laba_kotor = ($total_tagihan_global + $total_tagihan_global_jbb + $kredit_8401 + $kredit_8403) - ($jumlah_potongan_global + $jumlah_potongan_global_jbb);  
        
    }
}
else if ($tahun >2023){

    $total_laba_kotor = ($total_tagihan_global + $total_tagihan_global_jbb + $kredit_8401 + $kredit_8403) - ($jumlah_potongan_global + $jumlah_potongan_global_jbb);  

}
else{
    $total_laba_kotor = ($total_tagihan_global + $total_tagihan_global_jbb) - ($jumlah_potongan_global + $jumlah_potongan_global_jbb);  
}

 

    $total_biaya_usaha_final = $total_dexlite_global + $biaya_kantor_global + $listrik_global + $biaya_sewa_global + $atk_global + $perbaikan_global + $total_um_global + $total_gaji_karaywan_global + $transport_global +  $konsumsi_global + $total_kredit +  $total_kredit_kendaraan_pribadi +
                                $total_dexlite_global_jbb + $biaya_kantor_global_jbb + $listrik_global_jbb + $biaya_sewa_global_jbb + $atk_global_jbb + $perbaikan_global_jbb + $total_um_global_jbb + $total_gaji_karaywan_global_jbb + $transport_global_jbb +  $konsumsi_global_jbb + $total_kredit_jbb + $denda_kredit_global + $denda_kredit_global_jbb ;

    $total_biaya_usaha_final_bbm = $total_bbm_global + $total_dexlite_global_bbm + $biaya_kantor_global + $listrik_global + $biaya_sewa_global + $atk_global + $perbaikan_global + $total_um_global + $total_gaji_karaywan_global + $transport_global +  $konsumsi_global + $total_kredit +  $total_kredit_kendaraan_pribadi +
                                    $total_bbm_global_jbb + $total_dexlite_global_jbb + $biaya_kantor_global_jbb + $listrik_global_jbb + $biaya_sewa_global_jbb + $atk_global_jbb + $perbaikan_global_jbb + $total_um_global_jbb + $total_gaji_karaywan_global_jbb + $transport_global_jbb +  $konsumsi_global_jbb + $total_kredit_jbb + $denda_kredit_global + $denda_kredit_global_jbb ;
           
    $laba_bersih_sebelum_pajak = ($total_tagihan_global + $total_tagihan_global_jbb) - $total_biaya_usaha_final;
    $laba_bersih_sebelum_pajak_bbm = ($total_tagihan_global + $total_tagihan_global_jbb) - $total_biaya_usaha_final_bbm;


    // LR Lampung
    $table101_lmg =  mysqli_query($koneksibalsri, "SELECT mt FROM tagihan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
    //totalkredit
    $total_kredit_lmg = 0;
    while($data = mysqli_fetch_array($table101_lmg)){
        $mt = $data['mt'];
        $tablee_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit_lmg FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataa_lmg = mysqli_fetch_array($tablee_lmg);
        $jml_kredit_lmg = $dataa_lmg['total_kredit_lmg'];
        if(isset($total_kredit_lmg)){
            $total_kredit_lmg += $jml_kredit_lmg ;
        }
        
    }

    $total_laba_kotor_lmg = $total_tagihan_lmg;
    $total_seluruh_bbm_lmg =  $uang_bbm_lpg;
    $total_seluruh_dexlite_lmg = $total_dexlite_lmg;
    $selisih_bbm_lmg  =  $total_seluruh_dexlite_lmg - $total_seluruh_bbm_lmg;
    $jumlah_potongan_lmg = (($total_tagihan_lmg * 10) / 100);
    $sisa_oprasional_lmg = $jumlah_potongan_lmg - ($jml_atk_lmg + $gaji_karyawan_lmg + $jml_sewa_lmg + $jml_transport_lmg );

    $total_biaya_usaha_final_bbm_lmg  = $uang_bbm_lpg + $jml_biaya_kantor_lmg + $jml_listrik_lmg + $jml_sewa_lmg +  $jml_perbaikan_lmg + $total_um_lmg + $gaji_driver_lmg  +  $jml_konsumsi_lmg + $total_kredit_lmg + $jml_atk_lmg + $gaji_karyawan_lmg + $jml_sewa_lmg + $jml_transport_lmg + $total_denda_kredit_lmg;
    $total_biaya_usaha_final_lmg = $total_dexlite_lmg + $jml_biaya_kantor_lmg + $jml_listrik_lmg + $jml_sewa_lmg +  $jml_perbaikan_lmg + $total_um_lmg + $gaji_driver_lmg  +  $jml_konsumsi_lmg + $total_kredit_lmg + $jml_atk_lmg + $gaji_karyawan_lmg + $jml_sewa_lmg + $jml_transport_lmg + $total_denda_kredit_lmg;

    $laba_bersih_sebelum_pajak_lmg = $total_laba_kotor_lmg - $total_biaya_usaha_final_lmg;
    $laba_bersih_bbm_lmg = $total_laba_kotor_lmg - $total_biaya_usaha_final_bbm_lmg;



    //LR Palembang

             //totalkredit
             $table101_plg =  mysqli_query($koneksibalsri, "SELECT mt FROM tagihan_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
             $total_kredit_plg = 0;
             while($data = mysqli_fetch_array($table101_plg)){
                 $mt = $data['mt'];
                 $tablee_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit_plg FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
                 $dataa_plg = mysqli_fetch_array($tablee_plg);
                 $jml_kredit_plg= $dataa_plg['total_kredit_plg'];
                 if(isset($total_kredit_plg)){
                     $total_kredit_plg += $jml_kredit_plg;
                 }
                 
             }

    $total_laba_kotor_plg = $total_tagihan_plg;

    $jumlah_potongan_plg = (($total_tagihan_plg * 10) / 100);
    $sisa_oprasional_plg = $jumlah_potongan_plg - ($jml_atk_plg + $gaji_karyawan_plg + $jml_sewa_plg + $jml_transport_plg );
    $selisih_bbm_plg  =  $total_dexlite_plg - $uang_bbm_plg;
    $total_biaya_usaha_final_plg = $total_dexlite_plg + $jml_biaya_kantor_plg + $jml_listrik_plg + $jml_sewa_plg +  $jml_perbaikan_plg + $total_um_plg + $gaji_driver_plg  +  $jml_konsumsi_plg + $total_kredit_plg + $jml_atk_plg + $gaji_karyawan_plg + $jml_transport_plg + $total_denda_kredit_plg;
    $laba_bersih_sebelum_pajak_plg = $total_laba_kotor_plg  - $total_biaya_usaha_final_plg;

    $total_biaya_usaha_final_bbm_plg = $uang_bbm_plg + $jml_biaya_kantor_plg + $jml_listrik_plg + $jml_sewa_plg +  $jml_perbaikan_plg + $total_um_plg + $gaji_driver_plg  +  $jml_konsumsi_plg + $total_kredit_plg + $jml_atk_plg + $gaji_karyawan_plg  + $jml_transport_plg + $total_denda_kredit_plg;
    $laba_bersih_bbm_plg = $total_laba_kotor_plg  - $total_biaya_usaha_final_bbm_plg;


    //LR Baturaja
         //totalkredit
         $table101_br =  mysqli_query($koneksibalsri, "SELECT mt FROM tagihan_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
            $total_kredit_br = 0;
            while($data = mysqli_fetch_array($table101_br)){
                $mt = $data['mt'];
                $tablee_br = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit_br FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
                $dataa_br = mysqli_fetch_array($tablee_br);
                $jml_kredit_br = $dataa_br['total_kredit_br'];
                if(isset($total_kredit_br)){
                    $total_kredit_br += $jml_kredit_br;
                }
                
            }
    $total_laba_kotor_br = $total_tagihan_br;

    $jumlah_potongan_br = (($total_tagihan_br * 10) / 100);
    $sisa_oprasional_br = $jumlah_potongan_br - ($jml_atk_br + $gaji_karyawan_br + $jml_sewa_br + $jml_transport_br );
    $selisih_bbm_br  =  $total_dexlite_br - $uang_bbm_br;
    $total_biaya_usaha_final_br = $total_dexlite_br + $jml_biaya_kantor_br + $jml_listrik_br + $jml_sewa_br +  $jml_perbaikan_br + $total_um_br + $gaji_driver_br  +  $jml_konsumsi_br + $total_kredit_br + $jml_atk_br + $gaji_karyawan_br + $jml_transport_br  + $total_denda_kredit_br;
    $laba_bersih_sebelum_pajak_br  = $total_laba_kotor_br - $total_biaya_usaha_final_br;

    $total_biaya_usaha_final_bbm_br = $uang_bbm_br + $jml_biaya_kantor_br + $jml_listrik_br + $jml_sewa_br +  $jml_perbaikan_br + $total_um_br + $gaji_driver_br  +  $jml_konsumsi_br + $total_kredit_br + $jml_atk_br + $gaji_karyawan_br + $jml_transport_br + $total_denda_kredit_br;
    $laba_bersih_bbm_br = $total_laba_kotor_br  - $total_biaya_usaha_final_bbm_br;


    //LR BELITUNG

    //totalkredit
    $table101_bb =  mysqli_query($koneksibalsri, "SELECT mt FROM tagihan_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
    $total_kredit_bb = 0;
    while($data = mysqli_fetch_array($table101_bb)){
        $mt = $data['mt'];
        $tablee_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit_bb FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataa_bb = mysqli_fetch_array($tablee_bb);
        $jml_kredit_bb = $dataa_bb['total_kredit_bb'];
        if(isset($total_kredit_bb)){
            $total_kredit_bb += $jml_kredit_bb;
        }
        
    }
    $total_laba_kotor_bb = $total_tagihan_bb ;
    $jumlah_potongan_bb = (($total_tagihan_bb * 10) / 100);
    $sisa_oprasional_bb = $jumlah_potongan_bb - ($jml_atk_bb + $gaji_karyawan_bb + $jml_sewa_bb + $jml_transport_bb );
    $total_biaya_usaha_final_bb = $total_dexlite_bb + $jml_biaya_kantor_bb + $jml_listrik_bb + $jml_sewa_bb +  $jml_perbaikan_bb + $total_um_bb + $gaji_driver_bb  +  $jml_konsumsi_bb + $total_kredit_bb + $jml_atk_bb + $gaji_karyawan_bb + $jml_transport_bb + $total_denda_kredit_bb;
    $laba_bersih_sebelum_pajak_bb = $total_laba_kotor_bb - $total_biaya_usaha_final_bb;
    


    //LR Bangka
    $table101_bk =  mysqli_query($koneksibalsri, "SELECT mt FROM tagihan_bk WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
    //totalkredit
    $total_kredit_bk = 0;
    while($data = mysqli_fetch_array($table101_bk)){
        $mt = $data['mt'];
        $tablee_bk = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit_bk FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataa_bk = mysqli_fetch_array($tablee_bk);
        $jml_kredit_bk = $dataa_bk['total_kredit_bk'];
        if(isset($total_kredit_bk)){
            $total_kredit_bk += $jml_kredit_bk;
        }
        
    }

    $total_laba_kotor_bk = $total_tagihan_bk;
    $jumlah_potongan_bk = (($total_tagihan_bk * 10) / 100);
    $sisa_oprasional_bk = $jumlah_potongan_bk - ($jml_atk_bk + $gaji_karyawan_bk + $jml_sewa_bk + $jml_transport_bk );
    $total_biaya_usaha_final_bk = $total_dexlite_bk + $jml_biaya_kantor_bk + $jml_listrik_bk + $jml_sewa_bk +  $jml_perbaikan_bk + $total_um_bk + $gaji_driver_bk  +  $jml_konsumsi_bk + $total_kredit_bk + $jml_atk_bk + $gaji_karyawan_bk + $jml_transport_bk + $total_denda_kredit_bk;
    $laba_bersih_sebelum_pajak_bk = $total_laba_kotor_bk - $total_biaya_usaha_final_bk;


    //LR Bengkulu

    $table101_bkl =  mysqli_query($koneksistre, "SELECT mt FROM tagihan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
    //totalkredit
    $total_kredit_bkl = 0;
    while($data = mysqli_fetch_array($table101_bkl)){
        $mt = $data['mt'];
        $tablee_bkl = mysqli_query($koneksistre, "SELECT SUM(jumlah) AS total_kredit_bkl FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataa_bkl = mysqli_fetch_array($tablee_bkl);
        $jml_kredit_bkl = $dataa_bkl['total_kredit_bkl'];
        if(isset($total_kredit_bkl)){
            $total_kredit_bkl += $jml_kredit_bkl;
        }
        
    }

    $total_laba_kotor_bkl = $total_tagihan_bkl;

    $jumlah_potongan_bkl = (($total_tagihan_bkl * 10) / 100);
    $sisa_oprasional_bkl = $jumlah_potongan_bkl - ($jml_atk_bkl + $gaji_karyawan_bk + $jml_sewa_bkl + $jml_transport_bkl );

    $selisih_bbm_bkl  =  $total_dexlite_bkl - $uang_bbm_bku;

    $total_biaya_usaha_final_bkl = $total_dexlite_bkl + $jml_biaya_kantor_bkl + $jml_listrik_bkl + $jml_sewa_bkl +  $jml_perbaikan_bkl + $total_um_bkl + $gaji_driver_bkl  +  $jml_konsumsi_bkl + $total_kredit_bkl + $jml_atk_bkl + $gaji_karyawan_bk + $jml_transport_bkl + $total_denda_kredit_bkl;
    $laba_bersih_sebelum_pajak_bkl = $total_laba_kotor_bkl  - $total_biaya_usaha_final_bkl;

    $total_biaya_usaha_final_bbm_bkl = $uang_bbm_bku + $jml_biaya_kantor_bkl + $jml_listrik_bkl + $jml_sewa_bkl +  $jml_perbaikan_bkl + $total_um_bkl + $gaji_driver_bkl  +  $jml_konsumsi_bkl + $total_kredit_bkl + $jml_atk_bkl + $gaji_karyawan_bk + $jml_transport_bkl + $total_denda_kredit_bkl;
    $laba_bersih_bbm_bkl = $total_laba_kotor_bkl  - $total_biaya_usaha_final_bbm_bkl;


    // LR Tanjung Gerem 

    //akses kredit
    $table101_tg =  mysqli_query($koneksibalsri_jbb, "SELECT mt FROM tagihan_tg WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
    //totalkredit
    $total_kredit_tg = 0;
    while($data = mysqli_fetch_array($table101_tg)){
        $mt = $data['mt'];

        $tablee_tg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataa_tg = mysqli_fetch_array($tablee_tg);
        $jml_kredit_tg = $dataa_tg['total_kredit'];

        $tableex_tg = mysqli_query($koneksistre, "SELECT SUM(jumlah) AS total_kreditx FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataax_tg = mysqli_fetch_array($tableex_tg);
        $jml_kreditx_tg = $dataax_tg ['total_kreditx'];

        if(isset($jml_kredit_tg)){
            $total_kredit_tg += $jml_kredit_tg;
        }
        else if(isset($jml_kreditx_tg)){
            $total_kredit_tg += $jml_kreditx_tg;
        }
        
    }
    $total_laba_kotor_tg = $total_tagihan_tg;
    $jumlah_potongan_tg = (($total_tagihan_tg * 10) / 100);
    $sisa_oprasional_tg = $jumlah_potongan_tg - ($jml_atk_tg + $gaji_karyawan_tg + $jml_sewa_tg + $jml_transport_tg );
    $total_biaya_usaha_final_tg = $total_dexlite_tg + $jml_biaya_kantor_tg + $jml_listrik_tg  +  $jml_perbaikan_tg + $total_um_tg + $gaji_driver_tg  +  $jml_konsumsi_tg + $total_kredit_tg + $jml_atk_tg + $gaji_karyawan_tg + $jml_sewa_tg + $jml_transport_tg + $denda_kredit_tg;
    $laba_bersih_sebelum_pajak_tg = $total_laba_kotor_tg  - $total_biaya_usaha_final_tg;

    // LR Padalarang
    //akses kredit
    $table101_pa =  mysqli_query($koneksibalsri_jbb, "SELECT mt FROM tagihan_pa WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
    //totalkredit
    $total_kredit_pa = 0;
    while($data = mysqli_fetch_array($table101_pa)){
        $mt = $data['mt'];

        $tablee_pa = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataa_pa = mysqli_fetch_array($tablee_pa);
        $jml_kredit_pa = $dataa_pa['total_kredit'];

        $tableex_pa = mysqli_query($koneksistre, "SELECT SUM(jumlah) AS total_kreditx FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataax_pa = mysqli_fetch_array($tableex_pa);
        $jml_kreditx_pa = $dataax_pa['total_kreditx'];

        if(isset($jml_kredit_pa)){
            $total_kredit_pa += $jml_kredit_pa;
        }
        else if(isset($jml_kreditx_pa)){
            $total_kredit_pa += $jml_kreditx_pa;
        }
        
    }
    $total_laba_kotor_pa = $total_tagihan_pa ;
    $jumlah_potongan_pa = (($total_tagihan_pa * 10) / 100);
    $sisa_oprasional_pa = $jumlah_potongan_pa - ($jml_atk_pa + $gaji_karyawan_pa + $jml_sewa_pa + $jml_transport_pa );
    $total_biaya_usaha_final_pa = $total_dexlite_pa + $jml_biaya_kantor_pa + $jml_listrik_pa  +  $jml_perbaikan_pa + $total_um_pa + $gaji_driver_pa + $jml_konsumsi_pa + $total_kredit_pa + $jml_atk_pa + $gaji_karyawan_pa + $jml_sewa_pa + $jml_transport_pa + $denda_kredit_pa; 
    $laba_bersih_sebelum_pajak_pa = $total_laba_kotor_pa  - $total_biaya_usaha_final_pa;


    //LR PLUMPNAG
    //akses kredit
    $table101_pl =  mysqli_query($koneksibalsri_jbb, "SELECT mt FROM tagihan_pl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
    //totalkredit
    $total_kredit_pl = 0;
    while($data = mysqli_fetch_array($table101_pl)){
        $mt = $data['mt'];

        $tablee_pl = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataa_pl = mysqli_fetch_array($tablee_pl);
        $jml_kredit_pl = $dataa_pl['total_kredit'];

        $tableex_pl = mysqli_query($koneksistre, "SELECT SUM(jumlah) AS total_kreditx FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataax_pl = mysqli_fetch_array($tableex_pl);
        $jml_kreditx_pl = $dataax_pl['total_kreditx'];

        if(isset($jml_kredit_pl)){
            $total_kredit_pl += $jml_kredit_pl;
        }
        else if(isset($jml_kreditx_pl)){
            $total_kredit_pl += $jml_kreditx_pl;
        }
        
    }

    $total_laba_kotor_pl = $total_tagihan_pl ;
    $jumlah_potongan_pl = (($total_tagihan_pl * 10) / 100);
    $sisa_oprasional_pl = $jumlah_potongan_pl - ($jml_atk_pl + $gaji_karyawan_pl + $jml_sewa_pl + $jml_transport_pl );
    $total_biaya_usaha_final_pl = $total_dexlite_pl + $jml_biaya_kantor_pl + $jml_listrik_pl  +  $jml_perbaikan_pl + $total_um_pl + $gaji_driver_pl  +  $jml_konsumsi_pl + $total_kredit_pl + $jml_atk_pl + $gaji_karyawan_pl + $jml_sewa_pl + $jml_transport_pl + $denda_kredit_pl;
    $laba_bersih_sebelum_pajak_pl = $total_laba_kotor_pl  - $total_biaya_usaha_final_pl;


    //LR UJUNG BERUNG
    //akses kredit
    $table101_ub =  mysqli_query($koneksibalsri_jbb, "SELECT mt FROM tagihan_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
    //totalkredit
    $total_kredit_ub = 0;
    while($data = mysqli_fetch_array($table101_ub)){
        $mt = $data['mt'];

        $tablee_ub = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataa_ub = mysqli_fetch_array($tablee_ub);
        $jml_kredit_ub = $dataa_ub['total_kredit'];

        $tableex_ub = mysqli_query($koneksistre, "SELECT SUM(jumlah) AS total_kreditx FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataax_ub = mysqli_fetch_array($tableex_ub);
        $jml_kreditx_ub = $dataax_ub['total_kreditx'];

        if(isset($jml_kredit_ub)){
            $total_kredit_ub += $jml_kredit_ub;
        }
        else if(isset($jml_kreditx_ub)){
            $total_kredit_ub += $jml_kreditx_ub;
        }
        
    }
    $total_laba_kotor_ub = $total_tagihan_ub;
    $jumlah_potongan_ub = (($total_tagihan_ub * 10) / 100);
    $sisa_oprasional_ub = $jumlah_potongan_ub - ($jml_atk_ub + $gaji_karyawan_ub + $jml_sewa_ub + $jml_transport_ub );
    $total_biaya_usaha_final_ub = $total_dexlite_ub + $jml_biaya_kantor_ub + $jml_listrik_ub  +  $jml_perbaikan_ub + $total_um_ub + $gaji_driver_ub  +  $jml_konsumsi_ub + $total_kredit_ub + $jml_atk_ub + $gaji_karyawan_ub + $jml_sewa_ub + $jml_transport_ub + $denda_kredit_ub;
    $laba_bersih_sebelum_pajak_ub = $total_laba_kotor_ub - $total_biaya_usaha_final_ub;


    //LR BALONGAN
    //akses kredit
    $table101_ba =  mysqli_query($koneksibalsri_jbb, "SELECT mt FROM tagihan_ba WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
    //totalkredit
    $total_kredit_ba = 0;
    while($data = mysqli_fetch_array($table101_ba)){
        $mt = $data['mt'];

        $tablee_ba = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataa_ba = mysqli_fetch_array($tablee_ba);
        $jml_kredit_ba = $dataa_ba['total_kredit'];

        $tableex_ba = mysqli_query($koneksistre, "SELECT SUM(jumlah) AS total_kreditx FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataax_ba = mysqli_fetch_array($tableex_ba);
        $jml_kreditx_ba = $dataax_ba['total_kreditx'];

        if(isset($jml_kredit_ba)){
            $total_kredit_ba += $jml_kredit_ba;
        }
        else if(isset($jml_kreditx_ba)){
            $total_kredit_ba += $jml_kreditx_ba;
        }
        
    }
    $total_laba_kotor_ba = $total_tagihan_ba ;
    $jumlah_potongan_ba = (($total_tagihan_ba * 10) / 100);
    $sisa_oprasional_ba = $jumlah_potongan_ba - ($jml_atk_ba + $gaji_karyawan_ba + $jml_sewa_ba + $jml_transport_ba );
    $total_biaya_usaha_final_ba = $total_dexlite_ba + $jml_biaya_kantor_ba + $jml_listrik_ba  +  $jml_perbaikan_ba + $total_um_ba + $gaji_driver_ba  +  $jml_konsumsi_ba + $total_kredit_ba + $jml_atk_ba + $gaji_karyawan_ba + $jml_sewa_ba + $jml_transport_ba + $denda_kredit_ba;
    $laba_bersih_sebelum_pajak_ba = $total_laba_kotor_ba  - $total_biaya_usaha_final_ba;
?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan Laba Rugi GLOBAL ALL</title>

    <!-- Custom fonts for this template-->
    <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Custom styles for this template-->
    <link href="/sbadmin/css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav  sidebar sidebar-dark accordion" style=" background-color: #004445" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsPTBALSRI">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">


  <!-- Nav Item - Dashboard -->
<li class="nav-item active" >
    <a class="nav-link" href="DsPTBALSRI">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

<!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu PT BALSRI
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fa fa-building" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >List Company</span>
    </a>
    <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Company</h6>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.CBM/view/DsPTCBM">PT.CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/CV.PBJ/view/DsCVPBJ">CV.PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BatuBara/view/DsCVPBJ">Transport BL</a>
            <a class="collapse-item" style="font-size: 15px;" href="DsPTBALSRI">PT.BALSRI</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.MESPBR/view/DsPTPBRMES">PT. MES & PBR</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/Kebun/view/DsKebun">Kebun</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PERTASHOP/view/DsPertashop">Pertashop</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.STRE/view/DsPTSTRE">PT.Sri Trans Energi</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BALSRI_JBB/view/DsBALSRIJBB">BALSRI JBB</a>
        </div>
    </div>
</li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
      15  aria-expanded="true" aria-controls="collapseThree">
        <i class="fas fa-chart-line" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Laba Rugi</span>
    </a>
    <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Laba Rugi</h6>
            
            <?php if($nama == 'Nyoman Edy Susanto'){
              echo"<a class='collapse-item' style='font-size: 15px;' href='VLuangOPJBB'>Operasional Balsri ALL</a>";
              echo"<a class='collapse-item' style='font-size: 15px;' href='VLuangOP'>Operasional Balsri</a>";
             
            } ?>
            <?php if($nama == 'Nyoman Edy Susanto'){
              echo" <a class='collapse-item' style='font-size: 15px;' href='VLrBalsriJBB'>LR Global Balsri ALL</a>
                    <a class='collapse-item' style='font-size: 15px;' href='VLrGlobal'>LR Global Balsri</a>
                    <a class='collapse-item' style='font-size: 15px;' href='VLabaRugi'>Laba Rugi Lampung</a>
                    <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiP'>Laba Rugi Palembang</a>
                    <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiBr'>Laba Rugi Baturaja</a>
                    <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiBl'>Laba Rugi Belitung</a>
                    <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiBk'>Laba Rugi Bangka</a>";
            } ?>
        </div>
    </div>
</li>

 <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
      15  aria-expanded="true" aria-controls="collapseOne">
        <i class="fas fa-file-invoice-dollar" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Tagihan</span>
    </a>
    <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Tagihan</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihan">Tagihan Lampung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanL8">Tagihan Lampung 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanP">Tagihan Pelembang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanBr">Tagihan Baturaja</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanBl">Tagihan Belitung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanBk">Tagihan Bangka</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarif">Master Tarif LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifL8">Master Tarif LMG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifP">Master Tarif PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBr">Master Tarif BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBl">Master Tarif BL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBk">Master Tarif BK</a>
        </div>
    </div>
</li>

 <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOnex1"
      15  aria-expanded="true" aria-controls="collapseOnex1">
        <i class="fas fa-trailer" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Laporan Latex</span>
    </a>
    <div id="collapseOnex1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Latex</h6>
            <?php if($nama == 'Nyoman Edy Susanto'){
              echo"<a class='collapse-item' style='font-size: 15px;' href='VLRLatex'>Laba Rugi Latex</a>";
            } ?>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanLatex">Tagihan Latex</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanLx">Pengiriman Latex</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseLx">Ritase Latex</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhLx">Jarak Tempuh Latex</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiLx">Gaji Driver Latex</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawanLx">Gaji Karyawan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanLx">Catat Perbaikan Latex</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranLx">Catat Pengluaran Latex</a>
            <a class="collapse-item" style="font-size: 15px;" href="VBayarKreditLx">Kredit Kendaraan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VAMTLx">AMT</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMTLx">MT</a>
        </div>
    </div>
</li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwox"
      15  aria-expanded="true" aria-controls="collapseTwox">
        <i class="fas fa-truck-loading" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Pengiriman</span>
    </a>
    <div id="collapseTwox" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Pengiriman</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Pengiriman LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanL8">Pengiriman LMG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaP">Pengiriman PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaBr">Pengiriman BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaBl">Pengiriman BL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaBk">Pengiriman BK</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitase">Ritase LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseL8">Ritase LMG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseP">Ritase PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseBr">Ritase BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseBl">Ritase BL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseBk">Ritase BK</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuh">Jarak Tempuh LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhL8">Jarak Tempuh LMG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhP">Jarak Tempuh PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBr">Jarak Tempuh BTA</a> 
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBl">Jarak Tempuh BL</a> 
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBk">Jarak Tempuh BK</a> 
            
        </div>
    </div>
</li>
 <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo22"
      15  aria-expanded="true" aria-controls="collapseTwo22">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Pengeluaran</span>
    </a>
    <div id="collapseTwo22" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Pengeluaran</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikan">Catat Perbaikan LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanP">Catat Perbaikan PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanBr">Catat Perbaikan BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanBl">Catat Perbaikan BL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanBk">Catat Perbaikan BK</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPul">Pengeluaran Pul LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulP">Pengeluaran Pul PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBr">Pengeluaran Pul BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBl">Pengeluaran Pul BL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBk">Pengeluaran Pul BK</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGaji">Gaji LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiL8">Gaji LMG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiP">Gaji PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiBr">Gaji BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiBl">Gaji BL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiBk">Gaji BK</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Gaji Karyawan</a>
        </div>
    </div>
</li>
 <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo13"
      15  aria-expanded="true" aria-controls="collapseTwo1">
        <i class="fa fa-id-card" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >SDM</span>
    </a>
    <div id="collapseTwo13" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VAMT">AMT</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMT">MT</a>
            <a class="collapse-item" style="font-size: 15px;" href="VBayarKredit">Kredit Kendaraan</a>
        </div>
    </div>
</li>
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOnex"
      15  aria-expanded="true" aria-controls="collapseOne">
        <i class="fas fa-folder-open" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Data Backup</span>
    </a>
    <div id="collapseOnex" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Data Backup</h6>
            <?php if($nama == 'Nyoman Edy Susanto'){
              echo"<a class='collapse-item' style='font-size: 15px;' href='VLuangOPx'>Lap uang Oprasional</a>";
            } ?>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanx">Tagihan Lampung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanPx">Tagihan Pelembang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanBrx">Tagihan Baturaja</a>
            <?php if($nama == 'Nyoman Edy Susanto'){
              echo" <a class='collapse-item' style='font-size: 15px;' href='VLrGlobalx'>Laba Rugi Global</a>
                    <a class='collapse-item' style='font-size: 15px;' href='VLabaRugix'>Laba Rugi Lampung</a>
                    <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiPx'>Laba Rugi Palembang</a>
                    <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiBrx'>Laba Rugi Baturaja</a>";
            } ?>

            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifx">Master Tarif LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifPx">Master Tarif PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBrx">Master Tarif BTA</a>
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

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>


            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small"
                        placeholder="Search for..." aria-label="Search"
                        aria-describedby="basic-addon2">
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
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline  small"  style="color:white;"><?php echo "$nama"; ?></span>
                    <img class="img-profile rounded-circle" src="/assets/img/foto_profile/<?= $foto_profile; ?>"><!-- link foto profile --> 
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
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
<div class="container" style="color : black;">
   <?php  echo "<form  method='POST' action='VLrBalsriJBB' style='margin-bottom: 15px;'>" ?>
   <div>
      <div align="left" style="margin-left: 20px;"> 
        <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1"> 
        <span>-</span>
        <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
        <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm" >Lihat</button>
    </div>
</div>
</form>

<br>
<br>
<?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
<br>
<br>
<br>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laba Rugi Balsri Global Semua Region</strong></h3>
        </div>

        <div>

        </div>



        <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-condensed"  style="color : black;">
                  <thead>
                    <tr>
                     <td><strong>Akun</strong></td>
                     <td class="text-left"><strong>Nama Akun</strong></td>
                     <td class="text-left"><strong>Debit</strong></td>
                     <td class="text-left"><strong>Kredit</strong></td>
                 </tr>
             </thead>
             <tbody>
                 <!-- foreach ($order->lineItems as $line) or some such thing here -->
                 <tr>
                    <td><strong>4-000</strong></td>
                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                </tr>
                <tr>
                 <td>4-100</td>
                 <td class="text-left">Tagihan Global</td>
                 <td class="text-left"><?= formatuang($total_tagihan_global + $total_tagihan_global_jbb); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <?php

if($tahun == 2023){
    if($bulan == 1 || $bulan == 2 || $bulan == 3  ){ ?> 
  
     
    <?php }
    else if($bulan == 4 || $bulan == 5 || $bulan == 6 || $bulan == 7 || $bulan == 8 || $bulan == 9 || $bulan ==  10 || $bulan == 11 || $bulan == 12 ) {
        ?>
         <tr>
           <td>4-110</td>
           <td class="text-left">Sewa MT BG 8401 NM</td>
           <td class="text-left"><?= formatuang($kredit_8401); ?></td>
           <td class="text-left"><?= formatuang(0); ?></td>
       </tr>
       <tr>
           <td>4-120</td>
           <td class="text-left">Sewa MT BG 8403 NM</td>
           <td class="text-left"><?= formatuang($kredit_8403); ?></td>
           <td class="text-left"><?= formatuang(0); ?></td>
       </tr>
       <?php }
     }

     else if ($tahun >2023){ ?> 
        <tr>
           <td>4-110</td>
           <td class="text-left">Sewa MT BG 8401 NM</td>
           <td class="text-left"><?= formatuang($kredit_8401); ?></td>
           <td class="text-left"><?= formatuang(0); ?></td>
       </tr>
       <tr>
           <td>4-120</td>
           <td class="text-left">Sewa MT BG 8403 NM</td>
           <td class="text-left"><?= formatuang($kredit_8403); ?></td>
           <td class="text-left"><?= formatuang(0); ?></td>
       </tr>

<?php }
     else{
    
}
?>
             <tr>
                 <td>4-101</td>
                 <td class="text-left">Potongan Biaya Oprasional 10%</td>
                 <td class="text-left"><?= formatuang($jumlah_potongan_global + $jumlah_potongan_global_jbb); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>LABA KOTOR</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($total_laba_kotor); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>5-500</strong></td>
                <td class="text-left"><strong>BIAYA USAHA</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            <tr>
                <td>5-510</td>
                <td class="text-left">GAJI</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_gaji_karaywan_global + $total_gaji_karaywan_global_jbb); ?></td>
            </tr>
            <tr>
                <td>5-520</td>
                <td class="text-left">Alat Tulis Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($atk_global + $atk_global_jbb); ?></td>
            </tr>
            <tr>
                <td>5-530</td>
                <td class="text-left">Transport & Perjalanan Dinas</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($transport_global + $transport_global_jbb); ?></td>
            </tr>
            <tr>
                <td>5-540</td>
                <td class="text-left">Biaya Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($biaya_kantor_global + $biaya_kantor_global_jbb); ?></td>
            </tr>
            <tr>
                <td>5-550</td>
                <td class="text-left">Listrik & Telepon</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($listrik_global + $listrik_global_jbb); ?></td>
            </tr>
            <tr>
                <td>5-560</td>
                <td class="text-left">Biaya Konsumsi</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($konsumsi_global + $konsumsi_global_jbb); ?></td>
            </tr>
            <tr>
                <td>5-570</td>
                <td class="text-left">Biaya Sewa</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($biaya_sewa_global + $biaya_sewa_global_jbb); ?></td>
            </tr>
            
            <tr>
                <td>5-595</td>
                <td class="text-left">Biaya Perbaikan Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($perbaikan_global + $perbaikan_global_jbb); ?></td>
            </tr>
            <tr>
                <td>5-596</td>
                <td class="text-left">Uang Makan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_um_global + $total_um_global_jbb); ?></td>
            </tr>
            <tr>
                <td>5-597</td>
                <td class="text-left">Uang Dexlite</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_dexlite_global + $total_dexlite_global_jbb); ?></td>
            </tr>
            <tr>
                <td>5-5971</td>
                <td class="text-left">Uang BBM</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_bbm_global + $total_bbm_global_jbb); ?></td>
            </tr>
            <tr>
                <td>5-598</td>
                <td class="text-left">Bayar Kredit Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_kredit + $total_kredit_kendaraan_pribadi); ?></td>
            </tr>
            <tr>
                <td>5-599</td>
                <td class="text-left">Denda Kredit Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($denda_kredit_global + $denda_kredit_global_jbb); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Total Biaya Usaha</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_biaya_usaha_final); ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH SEBELUM PAJAK (DEX)</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_sebelum_pajak > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_sebelum_pajak < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak); ?></td>

                <?php }
                else if ($total_tagihan_global == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
            </tr> <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH SEBELUM PAJAK (BBM)</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_sebelum_pajak_bbm > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_bbm); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_sebelum_pajak_bbm < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_bbm); ?></td>

                <?php }
                else if ($total_tagihan_global == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
            </tr>
        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
<br>
<hr>
<br>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laba Rugi Balsri Lampung</strong></h3>
        </div>

        <div>

        </div>



        <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-condensed"  style="color : black;">
                  <thead>
                    <tr>
                     <td><strong>Akun</strong></td>
                     <td class="text-left"><strong>Nama Akun</strong></td>
                     <td class="text-left"><strong>Debit</strong></td>
                     <td class="text-left"><strong>Kredit</strong></td>
                 </tr>
             </thead>
             <tbody>
                 <!-- foreach ($order->lineItems as $line) or some such thing here -->
                 <tr>
                    <td><strong>4-000</strong></td>
                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                </tr>
                <tr>
                 <td>4-100</td>
                 <td class="text-left">Tagihan Patra</td>
                 <td class="text-left"><?= formatuang($total_tagihan_lmg); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>LABA KOTOR</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($total_laba_kotor_lmg); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>4-101</strong></td>
                <td class="text-left"><strong>PEMOTONGAN BIAYA OPRASIONAL</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Karyawan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_karyawan_lmg); ?></td>
            </tr>
            <tr>
                <td>5-520</td>
                <td class="text-left">Alat Tulis Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_atk_lmg); ?></td>
            </tr>
            <tr>
                <td>5-570</td>
                <td class="text-left">Biaya Sewa</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_sewa_lmg); ?></td>
            </tr>
            <tr>
                <td>5-530</td>
                <td class="text-left">Transport & Perjalanan Dinas</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_transport_lmg); ?></td>
            </tr>
            <tr>
                 <td>4-101</td>
                 <td class="text-left">Biaya Oprasional 10%</td>
                 <td class="text-left"><?= formatuang($jumlah_potongan_lmg); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>Sisa Biaya Oprasional</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($sisa_oprasional_lmg); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>5-500</strong></td>
                <td class="text-left"><strong>BIAYA USAHA</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Driver</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_driver_lmg); ?></td>
            </tr>
            <tr>
                <td>5-540</td>
                <td class="text-left">Biaya Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_biaya_kantor_lmg); ?></td>
            </tr>
            <tr>
                <td>5-550</td>
                <td class="text-left">Listrik & Telepon</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_listrik_lmg); ?></td>
            </tr>
            <tr>
                <td>5-560</td>
                <td class="text-left">Biaya Konsumsi</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_konsumsi_lmg); ?></td>
            </tr>            
            <tr>
                <td>5-595</td>
                <td class="text-left">Biaya Perbaikan Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_perbaikan_lmg); ?></td>
            </tr>
            <tr>
                <td>5-596</td>
                <td class="text-left">Uang Makan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_um_lmg); ?></td>
            </tr>
            <tr>
                <td>5-597</td>
                <td class="text-left">Uang Dexlite</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_dexlite_lmg); ?></td>
            </tr>
            <tr>
                <td>5-5971</td>
                <td class="text-left">Uang BBM</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($uang_bbm_lpg); ?></td>
            </tr>
            <tr>
                <td>5-598</td>
                <td class="text-left">Bayar Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_kredit_lmg); ?></td>
            </tr>
            <tr>
                <td>5-599</td>
                <td class="text-left">Denda Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_denda_kredit_lmg); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Total Seluruh Dexlite</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_seluruh_dexlite_lmg); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Total Seluruh BBM</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_seluruh_bbm_lmg); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Selisih BBM</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($selisih_bbm_lmg); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Total Biaya Usaha</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_biaya_usaha_final_lmg); ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_sebelum_pajak_lmg > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_lmg); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_sebelum_pajak_lmg < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_lmg); ?></td>

                <?php }
                else if ($laba_bersih_sebelum_pajak_lmg == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
            </tr>   
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH BBM</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_bbm_lmg > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_bbm_lmg); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_bbm_lmg < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_bbm_lmg); ?></td>

                <?php }
                else if ($laba_bersih_bbm_lmg == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
            </tr>
            
        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
<br>
<hr>
<br>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laba Rugi Balsri Palembang</strong></h3>
        </div>

        <div>

        </div>



        <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-condensed"  style="color : black;">
                  <thead>
                    <tr>
                     <td><strong>Akun</strong></td>
                     <td class="text-left"><strong>Nama Akun</strong></td>
                     <td class="text-left"><strong>Debit</strong></td>
                     <td class="text-left"><strong>Kredit</strong></td>
                 </tr>
             </thead>
             <tbody>
                 <!-- foreach ($order->lineItems as $line) or some such thing here -->
                 <tr>
                    <td><strong>4-000</strong></td>
                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                </tr>
                <tr>
                 <td>4-100</td>
                 <td class="text-left">Tagihan Patra</td>
                 <td class="text-left"><?= formatuang($total_tagihan_plg); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>LABA KOTOR</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($total_laba_kotor_plg); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>4-101</strong></td>
                <td class="text-left"><strong>PEMOTONGAN BIAYA OPRASIONAL</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Karyawan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_karyawan_plg); ?></td>
            </tr>
            <tr>
                <td>5-520</td>
                <td class="text-left">Alat Tulis Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_atk_plg); ?></td>
            </tr>
            <tr>
                <td>5-570</td>
                <td class="text-left">Biaya Sewa</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_sewa_plg); ?></td>
            </tr>
            <tr>
                <td>5-530</td>
                <td class="text-left">Transport & Perjalanan Dinas</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_transport_plg); ?></td>
            </tr>
            <tr>
                 <td>4-101</td>
                 <td class="text-left">Biaya Oprasional 10%</td>
                 <td class="text-left"><?= formatuang($jumlah_potongan_plg); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>Sisa Biaya Oprasional</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($sisa_oprasional_plg); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>5-500</strong></td>
                <td class="text-left"><strong>BIAYA USAHA</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Driver</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_driver_plg); ?></td>
            </tr>
            <tr>
                <td>5-540</td>
                <td class="text-left">Biaya Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_biaya_kantor_plg); ?></td>
            </tr>
            <tr>
                <td>5-550</td>
                <td class="text-left">Listrik & Telepon</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_listrik_plg); ?></td>
            </tr>
            <tr>
                <td>5-560</td>
                <td class="text-left">Biaya Konsumsi</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_konsumsi_plg); ?></td>
            </tr>
            <tr>
                <td>5-595</td>
                <td class="text-left">Biaya Perbaikan Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_perbaikan_plg); ?></td>
            </tr>
            <tr>
                <td>5-596</td>
                <td class="text-left">Uang Makan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_um_plg); ?></td>
            </tr>
            <tr>
                <td>5-597</td>
                <td class="text-left">Uang Dexlite</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_dexlite_plg); ?></td>
            </tr>
            <tr>
                <td>5-5971</td>
                <td class="text-left">Uang BBM</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($uang_bbm_plg); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Selisih BBM</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($selisih_bbm_plg); ?></td>
            </tr>
            <tr>
                <td>5-598</td>
                <td class="text-left">Bayar Kredit</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_kredit_plg); ?></td>
            </tr>
            <tr>
                <td>5-599</td>
                <td class="text-left">Denda Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_denda_kredit_plg); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Total Biaya Usaha</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_biaya_usaha_final_plg); ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_sebelum_pajak_plg > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_plg); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_sebelum_pajak_plg < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_plg); ?></td>

                <?php }
                else if ($laba_bersih_sebelum_pajak_plg == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
            </tr>
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH BBM</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_bbm_plg > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_bbm_plg); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_bbm_plg < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_bbm_plg); ?></td>

                <?php }
                else if ($laba_bersih_bbm_plg == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
              </tr>
           </tbody>
    </table>
</div>
</div>
</div>
</div>

</div>
<br>
<hr>
<br>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laba Rugi Balsri Baturaja</strong></h3>
        </div>

        <div>

        </div>



        <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-condensed"  style="color : black;">
                  <thead>
                    <tr>
                     <td><strong>Akun</strong></td>
                     <td class="text-left"><strong>Nama Akun</strong></td>
                     <td class="text-left"><strong>Debit</strong></td>
                     <td class="text-left"><strong>Kredit</strong></td>
                 </tr>
             </thead>
             <tbody>
                 <!-- foreach ($order->lineItems as $line) or some such thing here -->
                 <tr>
                    <td><strong>4-000</strong></td>
                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                </tr>
                <tr>
                 <td>4-100</td>
                 <td class="text-left">Tagihan Patra</td>
                 <td class="text-left"><?= formatuang($total_tagihan_br); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>LABA KOTOR</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($total_laba_kotor_br); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>4-101</strong></td>
                <td class="text-left"><strong>PEMOTONGAN BIAYA OPRASIONAL</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Karyawan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_karyawan_br); ?></td>
            </tr>
            <tr>
                <td>5-520</td>
                <td class="text-left">Alat Tulis Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_atk_br); ?></td>
            </tr>
            <tr>
                <td>5-570</td>
                <td class="text-left">Biaya Sewa</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_sewa_br); ?></td>
            </tr>
            <tr>
                <td>5-530</td>
                <td class="text-left">Transport & Perjalanan Dinas</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_transport_br); ?></td>
            </tr>
            <tr>
                 <td>4-101</td>
                 <td class="text-left">Biaya Oprasional 10%</td>
                 <td class="text-left"><?= formatuang($jumlah_potongan_br); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>Sisa Biaya Oprasional</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($sisa_oprasional_br); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>5-500</strong></td>
                <td class="text-left"><strong>BIAYA USAHA</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Driver</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_driver_br); ?></td>
            </tr>
            <tr>
                <td>5-540</td>
                <td class="text-left">Biaya Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_biaya_kantor_br); ?></td>
            </tr>
            <tr>
                <td>5-550</td>
                <td class="text-left">Listrik & Telepon</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_listrik_br); ?></td>
            </tr>
            <tr>
                <td>5-560</td>
                <td class="text-left">Biaya Konsumsi</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_konsumsi_br); ?></td>
            </tr>
            <tr>
                <td>5-595</td>
                <td class="text-left">Biaya Perbaikan Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_perbaikan_br); ?></td>
            </tr>
            <tr>
                <td>5-596</td>
                <td class="text-left">Uang Makan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_um_br); ?></td>
            </tr>
            <tr>
                <td>5-597</td>
                <td class="text-left">Uang Dexlite</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_dexlite_br); ?></td>
            </tr>
            <tr>
                <td>5-5971</td>
                <td class="text-left">Uang BBM</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($uang_bbm_br); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Selisih BBM</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($selisih_bbm_br); ?></td>
            </tr>
            <tr>
                <td>5-598</td>
                <td class="text-left">Bayar Kredit</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_kredit_br); ?></td>
            </tr>
            <tr>
                <td>5-599</td>
                <td class="text-left">Denda Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_denda_kredit_br); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Total Biaya Usaha</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_biaya_usaha_final_br); ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_sebelum_pajak_br > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_br); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_sebelum_pajak_br < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_br); ?></td>

                <?php }
                else if ($laba_bersih_sebelum_pajak_br == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
            </tr>
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH BBM</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_bbm_br > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_bbm_br); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_bbm_br < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_bbm_br); ?></td>

                <?php }
                else if ($laba_bersih_bbm_br == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
            </tr>
        </tbody>
    </table>
</div>
</div>
</div>
</div>

</div>
<br>
<hr>
<br>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laba Rugi Balsri Belitung</strong></h3>
        </div>

        <div>

        </div>



        <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-condensed"  style="color : black;">
                  <thead>
                    <tr>
                     <td><strong>Akun</strong></td>
                     <td class="text-left"><strong>Nama Akun</strong></td>
                     <td class="text-left"><strong>Debit</strong></td>
                     <td class="text-left"><strong>Kredit</strong></td>
                 </tr>
             </thead>
             <tbody>
                 <!-- foreach ($order->lineItems as $line) or some such thing here -->
                 <tr>
                    <td><strong>4-000</strong></td>
                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                </tr>
                <tr>
                 <td>4-100</td>
                 <td class="text-left">Tagihan Patra</td>
                 <td class="text-left"><?= formatuang($total_tagihan_bb); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>LABA KOTOR</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($total_laba_kotor_bb); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>4-101</strong></td>
                <td class="text-left"><strong>PEMOTONGAN BIAYA OPRASIONAL</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Karyawan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_karyawan_bb); ?></td>
            </tr>
            <tr>
                <td>5-520</td>
                <td class="text-left">Alat Tulis Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_atk_bb); ?></td>
            </tr>
            <tr>
                <td>5-570</td>
                <td class="text-left">Biaya Sewa</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_sewa_bb); ?></td>
            </tr>
            <tr>
                <td>5-530</td>
                <td class="text-left">Transport & Perjalanan Dinas</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_transport_bb); ?></td>
            </tr>
            <tr>
                 <td>4-101</td>
                 <td class="text-left">Biaya Oprasional 10%</td>
                 <td class="text-left"><?= formatuang($jumlah_potongan_bb); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>Sisa Biaya Oprasional</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($sisa_oprasional_bb); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>5-500</strong></td>
                <td class="text-left"><strong>BIAYA USAHA</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Driver</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_driver_bb); ?></td>
            </tr>
            <tr>
                <td>5-540</td>
                <td class="text-left">Biaya Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_biaya_kantor_bb); ?></td>
            </tr>
            <tr>
                <td>5-550</td>
                <td class="text-left">Listrik & Telepon</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_listrik_bb); ?></td>
            </tr>
            <tr>
                <td>5-560</td>
                <td class="text-left">Biaya Konsumsi</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_konsumsi_bb); ?></td>
            </tr>
            <tr>
                <td>5-595</td>
                <td class="text-left">Biaya Perbaikan Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_perbaikan_bb); ?></td>
            </tr>
            <tr>
                <td>5-596</td>
                <td class="text-left">Uang Makan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_um_bb); ?></td>
            </tr>
            <tr>
                <td>5-597</td>
                <td class="text-left">Uang Dexlite</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_dexlite_bb); ?></td>
            </tr>
            <tr>
                <td>5-598</td>
                <td class="text-left">Bayar Kredit</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_kredit_bb); ?></td>
            </tr>
            <tr>
                <td>5-599</td>
                <td class="text-left">Denda Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_denda_kredit_bb); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Total Biaya Usaha</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_biaya_usaha_final_bb); ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_sebelum_pajak_bb > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_bb); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_sebelum_pajak_bb < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_bb); ?></td>

                <?php }
                else if ($laba_bersih_sebelum_pajak_bb == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
            </tr>
        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
<br>
<hr>
<br>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laba Rugi Bangka</strong></h3>
        </div>

        <div>

        </div>



        <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-condensed"  style="color : black;">
                  <thead>
                    <tr>
                     <td><strong>Akun</strong></td>
                     <td class="text-left"><strong>Nama Akun</strong></td>
                     <td class="text-left"><strong>Debit</strong></td>
                     <td class="text-left"><strong>Kredit</strong></td>
                 </tr>
             </thead>
             <tbody>
                 <!-- foreach ($order->lineItems as $line) or some such thing here -->
                 <tr>
                    <td><strong>4-000</strong></td>
                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                </tr>
                <tr>
                 <td>4-100</td>
                 <td class="text-left">Tagihan Patra</td>
                 <td class="text-left"><?= formatuang($total_tagihan_bk); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>LABA KOTOR</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($total_laba_kotor_bk); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>4-101</strong></td>
                <td class="text-left"><strong>PEMOTONGAN BIAYA OPRASIONAL</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Karyawan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_karyawan_bk); ?></td>
            </tr>
            <tr>
                <td>5-520</td>
                <td class="text-left">Alat Tulis Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_atk_bk); ?></td>
            </tr>
            <tr>
                <td>5-570</td>
                <td class="text-left">Biaya Sewa</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_sewa_bk); ?></td>
            </tr>
            <tr>
                <td>5-530</td>
                <td class="text-left">Transport & Perjalanan Dinas</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_transport_bk); ?></td>
            </tr>
            <tr>
                 <td>4-101</td>
                 <td class="text-left">Biaya Oprasional 10%</td>
                 <td class="text-left"><?= formatuang($jumlah_potongan_bk); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>Sisa Biaya Oprasional</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($sisa_oprasional_bk); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>5-500</strong></td>
                <td class="text-left"><strong>BIAYA USAHA</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Driver</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_driver_bk); ?></td>
            </tr>
            <tr>
                <td>5-540</td>
                <td class="text-left">Biaya Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_biaya_kantor_bk); ?></td>
            </tr>
            <tr>
                <td>5-550</td>
                <td class="text-left">Listrik & Telepon</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_listrik_bk); ?></td>
            </tr>
            <tr>
                <td>5-560</td>
                <td class="text-left">Biaya Konsumsi</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_konsumsi_bk); ?></td>
            </tr>
            <tr>
                <td>5-595</td>
                <td class="text-left">Biaya Perbaikan Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_perbaikan_bk); ?></td>
            </tr>
            <tr>
                <td>5-596</td>
                <td class="text-left">Uang Makan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_um_bk); ?></td>
            </tr>
            <tr>
                <td>5-597</td>
                <td class="text-left">Uang Dexlite</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_dexlite_bk); ?></td>
            </tr>
            <tr>
                <td>5-598</td>
                <td class="text-left">Bayar Kredit</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_kredit_bk); ?></td>
            </tr>
            <tr>
                <td>5-599</td>
                <td class="text-left">Denda Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_denda_kredit_bk); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Total Biaya Usaha</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_biaya_usaha_final_bk); ?></td>

            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_sebelum_pajak_bk > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_bk); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_sebelum_pajak_bk < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_bk); ?></td>

                <?php }
                else if ($laba_bersih_sebelum_pajak_bk == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
            </tr>
        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
<br>
<hr>
<br>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laba Rugi Bengkulu</strong></h3>
        </div>

        <div>

        </div>



        <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-condensed"  style="color : black;">
                  <thead>
                    <tr>
                     <td><strong>Akun</strong></td>
                     <td class="text-left"><strong>Nama Akun</strong></td>
                     <td class="text-left"><strong>Debit</strong></td>
                     <td class="text-left"><strong>Kredit</strong></td>
                 </tr>
             </thead>
             <tbody>
                 <!-- foreach ($order->lineItems as $line) or some such thing here -->
                 <tr>
                    <td><strong>4-000</strong></td>
                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                </tr>
                <tr>
                 <td>4-100</td>
                 <td class="text-left">Tagihan Patra</td>
                 <td class="text-left"><?= formatuang($total_tagihan_bkl); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
           
             <tr style="background-color: navy;  color:white;">
                <td><strong>LABA KOTOR</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($total_laba_kotor_bkl); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>4-101</strong></td>
                <td class="text-left"><strong>PEMOTONGAN BIAYA OPRASIONAL</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Karyawan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_karyawan_bk); ?></td>
            </tr>
            <tr>
                <td>5-520</td>
                <td class="text-left">Alat Tulis Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_atk_bkl); ?></td>
            </tr>
            <tr>
                <td>5-570</td>
                <td class="text-left">Biaya Sewa</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_sewa_bkl); ?></td>
            </tr>
            <tr>
                <td>5-530</td>
                <td class="text-left">Transport & Perjalanan Dinas</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_transport_bkl); ?></td>
            </tr>
            <tr>
                 <td>4-101</td>
                 <td class="text-left">Biaya Oprasional 10%</td>
                 <td class="text-left"><?= formatuang($jumlah_potongan_bkl); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>Sisa Biaya Oprasional</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($sisa_oprasional_bkl); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>5-500</strong></td>
                <td class="text-left"><strong>BIAYA USAHA</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Driver</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_driver_bkl); ?></td>
            </tr>
            <tr>
                <td>5-540</td>
                <td class="text-left">Biaya Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_biaya_kantor_bkl); ?></td>
            </tr>
            <tr>
                <td>5-550</td>
                <td class="text-left">Listrik & Telepon</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_listrik_bkl); ?></td>
            </tr>
            <tr>
                <td>5-560</td>
                <td class="text-left">Biaya Konsumsi</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_konsumsi_bkl); ?></td>
            </tr>
            <tr>
                <td>5-595</td>
                <td class="text-left">Biaya Perbaikan Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_perbaikan_bkl); ?></td>
            </tr>
            <tr>
                <td>5-596</td>
                <td class="text-left">Uang Makan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_um_bkl); ?></td>
            </tr>
            <tr>
                <td>5-597</td>
                <td class="text-left">Uang Dexlite</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_dexlite_bkl); ?></td>
            </tr>
            <tr>
                <td>5-5971</td>
                <td class="text-left">Uang BBM</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($uang_bbm_bku); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Selisih BBM</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($selisih_bbm_bkl); ?></td>
            </tr>
            <tr>
                <td>5-598</td>
                <td class="text-left">Bayar Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_kredit_bkl); ?></td>
            </tr>
            <tr>
                <td>5-599</td>
                <td class="text-left">Denda Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_denda_kredit_bkl); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Total Biaya Usaha</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_biaya_usaha_final_bkl); ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_sebelum_pajak_bkl > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_bkl); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_sebelum_pajak_bkl < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_bkl); ?></td>

                <?php }
                else if ($laba_bersih_sebelum_pajak_bkl == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
            </tr>
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH BBM</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_bbm_bkl > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_bbm_bkl); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_bbm_bkl < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_bbm_bkl); ?></td>

                <?php }
                else if ($laba_bersih_bbm_bkl == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
            </tr>
        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
<br>
<hr>
<br>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laba Rugi Tj Gerem</strong></h3>
        </div>

        <div>

        </div>



        <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-condensed"  style="color : black;">
                  <thead>
                    <tr>
                     <td><strong>Akun</strong></td>
                     <td class="text-left"><strong>Nama Akun</strong></td>
                     <td class="text-left"><strong>Debit</strong></td>
                     <td class="text-left"><strong>Kredit</strong></td>
                 </tr>
             </thead>
             <tbody>
                 <!-- foreach ($order->lineItems as $line) or some such thing here -->
                 <tr>
                    <td><strong>4-000</strong></td>
                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                </tr>
                <tr>
                 <td>4-100</td>
                 <td class="text-left">Tagihan Patra</td>
                 <td class="text-left"><?= formatuang($total_tagihan_tg); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
           
             <tr style="background-color: navy;  color:white;">
                <td><strong>LABA KOTOR</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($total_laba_kotor_tg); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>4-101</strong></td>
                <td class="text-left"><strong>PEMOTONGAN BIAYA OPRASIONAL</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Karyawan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_karyawan_tg); ?></td>
            </tr>
            <tr>
                <td>5-520</td>
                <td class="text-left">Alat Tulis Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_atk_tg); ?></td>

            </tr>
            <tr>
                <td>5-570</td>
                <td class="text-left">Biaya Sewa</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_sewa_tg); ?></td>
            </tr>
            <tr>
                <td>5-530</td>
                <td class="text-left">Transport & Perjalanan Dinas</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_transport_tg); ?></td>
            </tr>
            <tr>
                 <td>4-101</td>
                 <td class="text-left">Biaya Oprasional 10%</td>
                 <td class="text-left"><?= formatuang($jumlah_potongan_tg); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>Sisa Biaya Oprasional</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($sisa_oprasional_tg); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>5-500</strong></td>
                <td class="text-left"><strong>BIAYA USAHA</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Driver</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_driver_tg); ?></td>
            </tr>
            <tr>
                <td>5-540</td>
                <td class="text-left">Biaya Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_biaya_kantor_tg); ?></td>
            </tr>
            <tr>
                <td>5-550</td>
                <td class="text-left">Listrik & Telepon</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_listrik_tg); ?></td>
            </tr>
            <tr>
                <td>5-560</td>
                <td class="text-left">Biaya Konsumsi</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_konsumsi_tg); ?></td>
            </tr>
            
            
            <tr>
                <td>5-595</td>
                <td class="text-left">Biaya Perbaikan Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_perbaikan_tg); ?></td>
            </tr>
            <tr>
                <td>5-596</td>
                <td class="text-left">Uang Makan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_um_tg); ?></td>
            </tr>
            <tr>
                <td>5-597</td>
                <td class="text-left">Uang Dexlite</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_dexlite_tg); ?></td>
            </tr>
            <tr>
                <td>5-5971</td>
                <td class="text-left">Uang BBM</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang(0); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Selisih BBM</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="thick-line"></td>
            </tr>
            <tr>
                <td>5-598</td>
                <td class="text-left">Bayar Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_kredit_tg); ?></td>
            </tr>
            <tr>
                <td>5-599</td>
                <td class="text-left">Denda Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($denda_kredit_tg); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Total Biaya Usaha</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_biaya_usaha_final_tg); ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_sebelum_pajak_tg > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_tg); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_sebelum_pajak_tg < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_tg); ?></td>

                <?php }
                else if ($laba_bersih_sebelum_pajak_tg == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
            </tr>
        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
<br>
<hr>
<br>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laba Rugi Padalarang</strong></h3>
        </div>

        <div>

        </div>

        <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-condensed"  style="color : black;">
                  <thead>
                    <tr>
                     <td><strong>Akun</strong></td>
                     <td class="text-left"><strong>Nama Akun</strong></td>
                     <td class="text-left"><strong>Debit</strong></td>
                     <td class="text-left"><strong>Kredit</strong></td>
                 </tr>
             </thead>
             <tbody>
                 <!-- foreach ($order->lineItems as $line) or some such thing here -->
                 <tr>
                    <td><strong>4-000</strong></td>
                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                </tr>
                <tr>
                 <td>4-100</td>
                 <td class="text-left">Tagihan Patra</td>
                 <td class="text-left"><?= formatuang($total_tagihan_pa); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
           
             <tr style="background-color: navy;  color:white;">
                <td><strong>LABA KOTOR</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($total_laba_kotor_pa); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>4-101</strong></td>
                <td class="text-left"><strong>PEMOTONGAN BIAYA OPRASIONAL</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Karyawan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_karyawan_pa); ?></td>
            </tr>
            <tr>
                <td>5-520</td>
                <td class="text-left">Alat Tulis Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_atk_pa); ?></td>
            </tr>
            <tr>
                <td>5-570</td>
                <td class="text-left">Biaya Sewa</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_sewa_pa); ?></td>
            </tr>
            <tr>
                <td>5-530</td>
                <td class="text-left">Transport & Perjalanan Dinas</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_transport_pa); ?></td>
            </tr>
            <tr>
                 <td>4-101</td>
                 <td class="text-left">Biaya Oprasional 10%</td>
                 <td class="text-left"><?= formatuang($jumlah_potongan_pa); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>Sisa Biaya Oprasional</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($sisa_oprasional_pa); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>5-500</strong></td>
                <td class="text-left"><strong>BIAYA USAHA</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Driver</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_driver_pa); ?></td>
            </tr>
            <tr>
                <td>5-540</td>
                <td class="text-left">Biaya Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_biaya_kantor_pa); ?></td>
            </tr>
            <tr>
                <td>5-550</td>
                <td class="text-left">Listrik & Telepon</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_listrik_pa); ?></td>
            </tr>
            <tr>
                <td>5-560</td>
                <td class="text-left">Biaya Konsumsi</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_konsumsi_pa); ?></td>
            </tr>
            
            
            <tr>
                <td>5-595</td>
                <td class="text-left">Biaya Perbaikan Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_perbaikan_pa); ?></td>
            </tr>
            <tr>
                <td>5-596</td>
                <td class="text-left">Uang Makan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_um_pa); ?></td>
            </tr>
            <tr>
                <td>5-597</td>
                <td class="text-left">Uang Dexlite</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_dexlite_pa); ?></td>
            </tr>
            <tr>
                <td>5-5971</td>
                <td class="text-left">Uang BBM</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang(0); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Selisih BBM</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang(0); ?></td>
            </tr>
            <tr>
                <td>5-598</td>
                <td class="text-left">Bayar Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_kredit_pa); ?></td>
            </tr>
            <tr>
                <td>5-599</td>
                <td class="text-left">Denda Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($denda_kredit_pa); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Total Biaya Usaha</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_biaya_usaha_final_pa); ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_sebelum_pajak_pa > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_pa); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_sebelum_pajak_pa < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_pa); ?></td>

                <?php }
                else if ($laba_bersih_sebelum_pajak_pa == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
            </tr>
          
        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
<br>
<hr>
<br>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laba Rugi Plumpang</strong></h3>
        </div>

        <div>

        </div>



        <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-condensed"  style="color : black;">
                  <thead>
                    <tr>
                     <td><strong>Akun</strong></td>
                     <td class="text-left"><strong>Nama Akun</strong></td>
                     <td class="text-left"><strong>Debit</strong></td>
                     <td class="text-left"><strong>Kredit</strong></td>
                 </tr>
             </thead>
             <tbody>
                 <!-- foreach ($order->lineItems as $line) or some such thing here -->
                 <tr>
                    <td><strong>4-000</strong></td>
                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                </tr>
                <tr>
                 <td>4-100</td>
                 <td class="text-left">Tagihan Patra</td>
                 <td class="text-left"><?= formatuang($total_tagihan_pl); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
           
             <tr style="background-color: navy;  color:white;">
                <td><strong>LABA KOTOR</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($total_laba_kotor_pl); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>4-101</strong></td>
                <td class="text-left"><strong>PEMOTONGAN BIAYA OPRASIONAL</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Karyawan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_karyawan_pl); ?></td>
            </tr>
            <tr>
                <td>5-520</td>
                <td class="text-left">Alat Tulis Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_atk_pl); ?></td>
            </tr>
            <tr>
                <td>5-570</td>
                <td class="text-left">Biaya Sewa</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_sewa_pl); ?></td>
            </tr>
            <tr>
                <td>5-530</td>
                <td class="text-left">Transport & Perjalanan Dinas</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_transport_pl); ?></td>
            </tr>
            <tr>
                 <td>4-101</td>
                 <td class="text-left">Biaya Oprasional 10%</td>
                 <td class="text-left"><?= formatuang($jumlah_potongan_pl); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>Sisa Biaya Oprasional</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($sisa_oprasional_pl); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>5-500</strong></td>
                <td class="text-left"><strong>BIAYA USAHA</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Driver</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_driver_pl); ?></td>
            </tr>
            <tr>
                <td>5-540</td>
                <td class="text-left">Biaya Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_biaya_kantor_pl); ?></td>
            </tr>
            <tr>
                <td>5-550</td>
                <td class="text-left">Listrik & Telepon</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_listrik_pl); ?></td>
            </tr>
            <tr>
                <td>5-560</td>
                <td class="text-left">Biaya Konsumsi</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_konsumsi_pl); ?></td>
            </tr>
            
            
            <tr>
                <td>5-595</td>
                <td class="text-left">Biaya Perbaikan Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_perbaikan_pl); ?></td>
            </tr>
            <tr>
                <td>5-596</td>
                <td class="text-left">Uang Makan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_um_pl); ?></td>
            </tr>
            <tr>
                <td>5-597</td>
                <td class="text-left">Uang Dexlite</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_dexlite_pl); ?></td>
            </tr>
            <tr>
                <td>5-5971</td>
                <td class="text-left">Uang BBM</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang(0); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Selisih BBM</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang(0); ?></td>
            </tr>
            <tr>
                <td>5-598</td>
                <td class="text-left">Bayar Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_kredit_pl); ?></td>
            </tr>
            <tr>
                <td>5-599</td>
                <td class="text-left">Denda Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($denda_kredit_pl); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Total Biaya Usaha</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_biaya_usaha_final_pl); ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_sebelum_pajak_pl > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_pl); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_sebelum_pajak_pl < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_pl); ?></td>

                <?php }
                else if ($laba_bersih_sebelum_pajak_pl == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
            </tr>
        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>

<br>
<hr>
<br>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laba Rugi Ujung Berung</strong></h3>
        </div>

        <div>

        </div>



        <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-condensed"  style="color : black;">
                  <thead>
                    <tr>
                     <td><strong>Akun</strong></td>
                     <td class="text-left"><strong>Nama Akun</strong></td>
                     <td class="text-left"><strong>Debit</strong></td>
                     <td class="text-left"><strong>Kredit</strong></td>
                 </tr>
             </thead>
             <tbody>
                 <!-- foreach ($order->lineItems as $line) or some such thing here -->
                 <tr>
                    <td><strong>4-000</strong></td>
                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                </tr>
                <tr>
                 <td>4-100</td>
                 <td class="text-left">Tagihan Patra</td>
                 <td class="text-left"><?= formatuang($total_tagihan_ub); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
           
             <tr style="background-color: navy;  color:white;">
                <td><strong>LABA KOTOR</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($total_laba_kotor_ub); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>4-101</strong></td>
                <td class="text-left"><strong>PEMOTONGAN BIAYA OPRASIONAL</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Karyawan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_karyawan_ub); ?></td>
            </tr>
            <tr>
                <td>5-520</td>
                <td class="text-left">Alat Tulis Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_atk_ub); ?></td>
            </tr>
            <tr>
                <td>5-570</td>
                <td class="text-left">Biaya Sewa</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_sewa_ub); ?></td>
            </tr>
            <tr>
                <td>5-530</td>
                <td class="text-left">Transport & Perjalanan Dinas</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_transport_ub); ?></td>
            </tr>
            <tr>
                 <td>4-101</td>
                 <td class="text-left">Biaya Oprasional 10%</td>
                 <td class="text-left"><?= formatuang($jumlah_potongan_ub); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>Sisa Biaya Oprasional</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($sisa_oprasional_ub); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>5-500</strong></td>
                <td class="text-left"><strong>BIAYA USAHA</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Driver</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_driver_ub); ?></td>
            </tr>
            <tr>
                <td>5-540</td>
                <td class="text-left">Biaya Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_biaya_kantor_ub); ?></td>
            </tr>
            <tr>
                <td>5-550</td>
                <td class="text-left">Listrik & Telepon</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_listrik_ub); ?></td>
            </tr>
            <tr>
                <td>5-560</td>
                <td class="text-left">Biaya Konsumsi</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_konsumsi_ub); ?></td>
            </tr>
            
            
            <tr>
                <td>5-595</td>
                <td class="text-left">Biaya Perbaikan Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_perbaikan_ub); ?></td>
            </tr>
            <tr>
                <td>5-596</td>
                <td class="text-left">Uang Makan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_um_ub); ?></td>
            </tr>
            <tr>
                <td>5-597</td>
                <td class="text-left">Uang Dexlite</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_dexlite_ub); ?></td>
            </tr>
            <tr>
                <td>5-5971</td>
                <td class="text-left">Uang BBM</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang(0); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Selisih BBM</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang(0); ?></td>
            </tr>
            <tr>
                <td>5-598</td>
                <td class="text-left">Bayar Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_kredit_ub); ?></td>
            </tr>
            <tr>
                <td>5-599</td>
                <td class="text-left">Denda Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($denda_kredit_ub); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Total Biaya Usaha</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_biaya_usaha_final_ub); ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_sebelum_pajak_ub > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_ub); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_sebelum_pajak_ub < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_ub); ?></td>

                <?php }
                else if ($laba_bersih_sebelum_pajak_ub == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
            </tr>
        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
<br>
<hr>
<br>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laba Rugi Balongan</strong></h3>
        </div>

        <div>

        </div>



        <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-condensed"  style="color : black;">
                  <thead>
                    <tr>
                     <td><strong>Akun</strong></td>
                     <td class="text-left"><strong>Nama Akun</strong></td>
                     <td class="text-left"><strong>Debit</strong></td>
                     <td class="text-left"><strong>Kredit</strong></td>
                 </tr>
             </thead>
             <tbody>
                 <!-- foreach ($order->lineItems as $line) or some such thing here -->
                 <tr>
                    <td><strong>4-000</strong></td>
                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                </tr>
                <tr>
                 <td>4-100</td>
                 <td class="text-left">Tagihan Patra</td>
                 <td class="text-left"><?= formatuang($total_tagihan_ba); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
           
             <tr style="background-color: navy;  color:white;">
                <td><strong>LABA KOTOR</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($total_laba_kotor_ba); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>4-101</strong></td>
                <td class="text-left"><strong>PEMOTONGAN BIAYA OPRASIONAL</strong></td>
                <td class="text-left"></td>
            </tr>
            
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Karyawan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_karyawan_ba); ?></td>
            </tr>
            <tr>
                <td>5-520</td>
                <td class="text-left">Alat Tulis Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_atk_ba); ?></td>
            </tr>
            <tr>
                <td>5-570</td>
                <td class="text-left">Biaya Sewa</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_sewa_ba); ?></td>
            </tr>
            <tr>
                <td>5-530</td>
                <td class="text-left">Transport & Perjalanan Dinas</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_transport_ba); ?></td>
            </tr>
            <tr>
                 <td>4-101</td>
                 <td class="text-left">Biaya Oprasional 10%</td>
                 <td class="text-left"><?= formatuang($jumlah_potongan_ba); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>Sisa Biaya Oprasional</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($sisa_oprasional_ba); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td><strong>5-500</strong></td>
                <td class="text-left"><strong>BIAYA USAHA</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
            </tr>
            <tr>
                <td>5-510</td>
                <td class="text-left">Gaji Driver</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($gaji_driver_ba); ?></td>
            </tr>
            <tr>
                <td>5-540</td>
                <td class="text-left">Biaya Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_biaya_kantor_ba); ?></td>
            </tr>
            <tr>
                <td>5-550</td>
                <td class="text-left">Listrik & Telepon</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_listrik_ba); ?></td>
            </tr>
            <tr>
                <td>5-560</td>
                <td class="text-left">Biaya Konsumsi</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_konsumsi_ba); ?></td>
            </tr>
            
            
            <tr>
                <td>5-595</td>
                <td class="text-left">Biaya Perbaikan Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($jml_perbaikan_ba); ?></td>
            </tr>
            <tr>
                <td>5-596</td>
                <td class="text-left">Uang Makan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_um_ba); ?></td>
            </tr>
            <tr>
                <td>5-597</td>
                <td class="text-left">Uang Dexlite</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_dexlite_ba); ?></td>
            </tr>
            <tr>
                <td>5-5971</td>
                <td class="text-left">Uang BBM</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang(0); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Selisih BBM</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang(0); ?></td>
            </tr>
            <tr>
                <td>5-598</td>
                <td class="text-left">Bayar Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_kredit_ba); ?></td>
            </tr>
            <tr>
                <td>5-599</td>
                <td class="text-left">Denda Kredit </td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($denda_kredit_ba); ?></td>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Total Biaya Usaha</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_biaya_usaha_final_ba); ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
            </tr>
            <tr style="background-color: navy;  color:white;">
                <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
                <td class="thick-line"></td>
                <?php

                if ($laba_bersih_sebelum_pajak_ba > 0) { ?>

                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_ba); ?> </td>
                    <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <?php }
                else if ($laba_bersih_sebelum_pajak_ba < 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang($laba_bersih_sebelum_pajak_ba); ?></td>

                <?php }
                else if ($laba_bersih_sebelum_pajak_ba == 0) { ?>

                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                    <td class="no-line text-left"><?= formatuang(0); ?></td>
                <?php }
                ?>
            </tr>
        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
<br>
<br>

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
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
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

<!-- Core plugin JavaScript-->
<script src="/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="/sbadmin/js/sb-admin-2.min.js"></script>

</body>

</html>