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
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Direktur Utama') {

}

else{ header("Location: logout.php");
exit;
}

if (isset($_GET['tanggal1'])) {
   $tanggal_awal = $_GET['tanggal1'];
   $tanggal_akhir = $_GET['tanggal2'];
} 

elseif (isset($_POST['tanggal1'])) {
   $tanggal_awal = $_POST['tanggal1'];
   $tanggal_akhir = $_POST['tanggal2'];
}  

else{
    $tanggal_awal = date('Y-m-1');
  $tanggal_akhir = date('Y-m-31');
  }
function formatuang($angka){
  $uang = "Rp " . number_format($angka,2,',','.');
  return $uang;
}

  // LAMPUNG

  // Tagihan
  $table_lmg = mysqli_query($koneksibalsri, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan a INNER JOIN master_tarif b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data_lmg = mysqli_fetch_array($table_lmg);
  $total_tagihan_lmg= $data_lmg['total_tagihan'];

  // Potongan 10%
  $jumlah_potongan_lmg = (($total_tagihan_lmg * 10) / 100);

  // Tagihan spbu
  $table_spbu = mysqli_query($koneksibalsri, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_spbu a INNER JOIN master_tarif_spbu b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data_spbu = mysqli_fetch_array($table_spbu);
  $total_tagihan_spbu= $data_spbu['total_tagihan'];

  // Potongan 10%
  $jumlah_potongan_lmg = (($total_tagihan_lmg * 10) / 100);

   //pengiriman lampung
   $table2_lmg = mysqli_query($koneksibalsri, "SELECT SUM(um) AS uang_makan , SUM(jt_gps) as total_jt_gps , SUM(uj) AS total_uj  FROM pengiriman WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $total_dexlite_lmg =0;
   $data2_lmg = mysqli_fetch_array($table2_lmg);
   $total_uj_lmg = $data2_lmg['total_uj'];
   $total_jt_gps_lmg = $data2_lmg['total_jt_gps'];
   $total_um_lmg = $data2_lmg['uang_makan'];
   $total_dexlite_lmg = $total_uj_lmg - ($total_jt_gps_lmg*625);

   //pengiriman spbu
   $table2_spbu = mysqli_query($koneksibalsri, "SELECT SUM(um) AS uang_makan , SUM(jt_gps) as total_jt_gps , SUM(uj) AS total_uj  FROM pengiriman_spbu WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $total_dexlite_spbu =0;
   $data2_spbu = mysqli_fetch_array($table2_spbu);
   $total_uj_spbu = $data2_spbu['total_uj'];
   $total_jt_gps_spbu = $data2_spbu['total_jt_gps'];
   $total_um_spbu= $data2_spbu['uang_makan'];
   $total_dexlite_spbu = $total_uj_spbu - ($total_jt_gps_spbu*625);
    

    
  //pengeluran Pul Biaya Kantor
   $table3_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
   $data3_lmg = mysqli_fetch_array($table3_lmg);
   $jml_biaya_kantor_lmg = $data3_lmg['jumlah_biaya_kantor'];
    if (!isset($data3_lmg['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor_lmg = 0;
    }

   //pengeluran Pul Listrik & Telepon
   $table4_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
   $data4_lmg = mysqli_fetch_array($table4_lmg);
   $jml_listrik_lmg = $data4_lmg['jumlah_listrik'];
    if (!isset($data4_lmg['jumlah_listrik'])) {
    $jml_listrik_lmg = 0;
    }

   //pengeluran Biaya Sewa
   $table5_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
   $data5_lmg = mysqli_fetch_array($table5_lmg);
   $jml_sewa_lmg = $data5_lmg['jumlah_sewa'];
    if (!isset($data5_lmg['jumlah_sewa'])) {
    $jml_sewa_lmg = 0;
    }

   //pengeluran Alat Tulis Kantor
   $table6_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_lmg = mysqli_fetch_array($table6_lmg);
   $jml_atk_lmg = $data6_lmg['jumlah_atk'];
    if (!isset($data6_lmg['jumlah_atk'])) {
    $jml_atk_lmg = 0;
    }

    //pengeluran Transnport / Perjalanan Dinas
   $table61_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_lmg = mysqli_fetch_array($table61_lmg);
   $jml_transport_lmg = $data61_lmg['jumlah_transport'];
    if (!isset($data61_lmg['jumlah_transport'])) {
    $jml_transport_lmg = 0;
    }
    //pengeluran Biaya Konsumsi
   $table62_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_lmg = mysqli_fetch_array($table62_lmg);
   $jml_konsumsi_lmg = $data62_lmg['jumlah_konsumsi'];
    if (!isset($data62_lmg['jumlah_konsumsi'])) {
    $jml_konsumsi_lmg = 0;
    }

    //pengeluran perbaikan
   $table7_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_lmg = mysqli_fetch_array($table7_lmg);
   $jml_perbaikan_lmg = $data7_lmg['jumlah_perbaikan'];
    if (!isset($data7_lmg['jumlah_perbaikan'])) {
    $jml_perbaikan_lmg = 0;
    }
    
    
     //Gaji karyawan
   $table8_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI LMG' ");
   $data8_lmg = mysqli_fetch_array($table8_lmg);
   $gaji_karyawan_lmg = $data8_lmg['jumlah_gaji'];
    if (!isset($data8_lmg['jumlah_gaji'])) {
    $gaji_karyawan_lmg = 0;
    }
    //Gaji dRIVER
   $table9_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Driver LMG' ");
   $data9_lmg = mysqli_fetch_array($table9_lmg);
   $gaji_driver_lmg = $data9_lmg['jumlah_gaji'];
    if (!isset($data9_lmg['jumlah_gaji'])) {
    $gaji_driver_lmg = 0;
    }
    
    $total_gaji_karyawan_lmg = $gaji_karyawan_lmg;


    $table101_lmg =  mysqli_query($koneksibalsri, "SELECT mt FROM tagihan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
    //totalkredit
    $total_kredit_lmg = 0;
    while($data_lmg = mysqli_fetch_array($table101_lmg)){
        $mt_lmg = $data_lmg['mt'];
        $tablee_lmg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt_lmg'");
        $dataa_lmg = mysqli_fetch_array($tablee_lmg);
        $jml_kredit_lmg = $dataa_lmg['total_kredit'];
        if(isset($total_kredit_lmg)){
            $total_kredit_lmg += $jml_kredit_lmg;
        }
        
    }
  
    $total_oprasional_lmg =   $jml_biaya_kantor_lmg + $jml_listrik_lmg + $jml_sewa_lmg + $jml_atk_lmg + $total_gaji_karyawan_lmg + $jml_transport_lmg +  $jml_konsumsi_lmg;


    // BATURAJA

       // Tagihan
  $table_bta = mysqli_query($koneksibalsri, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_br a INNER JOIN master_tarif_br b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data_bta = mysqli_fetch_array($table_bta);
  $total_tagihan_bta = $data_bta['total_tagihan'];

  // Potongan 10%
  $jumlah_potongan_bta = (($total_tagihan_bta * 10) / 100);

  //pengiriman
  $table2_bta = mysqli_query($koneksibalsri, "SELECT SUM(dexlite) AS total_dex, SUM(um) AS uang_makan FROM pengiriman_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data2_bta = mysqli_fetch_array($table2_bta);
  $jml_dex_bta = $data2_bta['total_dex'];
  $total_um_bta = $data2_bta['uang_makan'];
 
  $total_dexlite_bta = $jml_dex_bta * 9700;
    

    
  //pengeluran Pul Biaya Kantor
   $table3_bta = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
   $data3_bta = mysqli_fetch_array($table3_bta);
   $jml_biaya_kantor_bta = $data3_bta['jumlah_biaya_kantor'];
    if (!isset($data3_bta['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor_bta = 0;
    }

   //pengeluran Pul Listrik & Telepon
   $table4_bta = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
   $data4_bta = mysqli_fetch_array($table4_bta);
   $jml_listrik_bta = $data4_bta['jumlah_listrik'];
    if (!isset($data4_bta['jumlah_listrik'])) {
    $jml_listrik_bta = 0;
    }

   //pengeluran Biaya Sewa
   $table5_bta = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
   $data5_bta = mysqli_fetch_array($table5_bta);
   $jml_sewa_bta = $data5_bta['jumlah_sewa'];
    if (!isset($data5_bta['jumlah_sewa'])) {
    $jml_sewa_bta = 0;
    }

   //pengeluran Alat Tulis Kantor
   $table6_bta = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_bta = mysqli_fetch_array($table6_bta);
   $jml_atk_bta = $data6_bta['jumlah_atk'];
    if (!isset($data6_bta['jumlah_atk'])) {
    $jml_atk_bta = 0;
    }

    //pengeluran Transnport / Perjalanan Dinas
   $table61_bta = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_bta = mysqli_fetch_array($table61_bta);
   $jml_transport_bta = $data61_bta['jumlah_transport'];
    if (!isset($data61_bta['jumlah_transport'])) {
    $jml_transport_bta = 0;
    }
    //pengeluran Biaya Konsumsi
   $table62_bta = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_bta = mysqli_fetch_array($table62_bta);
   $jml_konsumsi_bta = $data62_bta['jumlah_konsumsi'];
    if (!isset($data62_bta['jumlah_konsumsi'])) {
    $jml_konsumsi_bta = 0;
    }

    //pengeluran perbaikan
   $table7_bta = mysqli_query($koneksibalsri, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_bta = mysqli_fetch_array($table7_bta);
   $jml_perbaikan_bta = $data7_bta['jumlah_perbaikan'];
    if (!isset($data7_bta['jumlah_perbaikan'])) {
    $jml_perbaikan_bta = 0;
    }
    
    
     //Gaji karyawan
   $table8_bta = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI BTA' ");
   $data8_bta = mysqli_fetch_array($table8_bta);
   $gaji_karyawan_bta = $data8_bta['jumlah_gaji'];
    if (!isset($data8_bta['jumlah_gaji'])) {
    $gaji_karyawan_bta = 0;
    }
    //Gaji dRIVER
   $table9_bta = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Driver BTA' ");
   $data9_bta = mysqli_fetch_array($table9_bta);
   $gaji_driver_bta = $data9_bta['jumlah_gaji'];
    if (!isset($data9_bta['jumlah_gaji'])) {
    $gaji_driver_bta = 0;
    }
    
    $total_gaji_karyawan_bta = $gaji_karyawan_bta;

   

    $table101_bta =  mysqli_query($koneksibalsri, "SELECT mt FROM tagihan_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
    //totalkredit
    $total_kredit_bta = 0;
    while($data_bta = mysqli_fetch_array($table101_bta)){
        $mt_bta = $data_bta['mt'];
        $tablee_bta = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt_bta'");
        $dataa_bta = mysqli_fetch_array($tablee_bta);
        $jml_kredit_bta = $dataa_bta['total_kredit'];
        if(isset($total_kredit_bta)){
            $total_kredit_bta += $jml_kredit_bta;
        }
        
    }

    $total_oprasional_bta =   $jml_biaya_kantor_bta + $jml_listrik_bta + $jml_sewa_bta + $jml_atk_bta + $total_gaji_karyawan_bta + $jml_transport_bta +  $jml_konsumsi_bta;
  


    //Palembang
     // Tagihan
  $table_plg = mysqli_query($koneksibalsri, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_p a INNER JOIN master_tarif_p b ON a.no=b.no  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data_plg = mysqli_fetch_array($table_plg);
  $total_tagihan_plg = $data_plg['total_tagihan'];

    // Potongan 10%
    $jumlah_potongan_plg = (($total_tagihan_plg * 10) / 100);

  //pengiriman
  $table2_plg = mysqli_query($koneksibalsri, "SELECT SUM(dexlite) AS total_dex, SUM(um) AS uang_makan FROM pengiriman_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data2_plg = mysqli_fetch_array($table2_plg);
  $jml_dex_plg = $data2_plg['total_dex'];
  $total_um_plg = $data2_plg['uang_makan'];
  $total_dexlite_plg = $jml_dex_plg * 9700;
  

  //pengeluran Pul Biaya Kantor
   $table3_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
   $data3_plg = mysqli_fetch_array($table3_plg);
   $jml_biaya_kantor_plg = $data3_plg['jumlah_biaya_kantor'];
    if (!isset($data3_plg['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor_plg = 0;
    }

   //pengeluran Pul Listrik & Telepon
   $table4_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
   $data4_plg = mysqli_fetch_array($table4_plg);
   $jml_listrik_plg = $data4_plg['jumlah_listrik'];
    if (!isset($data4_plg['jumlah_listrik'])) {
    $jml_listrik_plg = 0;
    }

   //pengeluran Biaya Sewa
   $table5_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
   $data5_plg = mysqli_fetch_array($table5_plg);
   $jml_sewa_plg = $data5_plg['jumlah_sewa'];
    if (!isset($data5_plg['jumlah_sewa'])) {
    $jml_sewa_plg = 0;
    }

   //pengeluran Alat Tulis Kantor
   $table6_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_plg = mysqli_fetch_array($table6_plg);
   $jml_atk_plg = $data6_plg['jumlah_atk'];
    if (!isset($data6_plg['jumlah_atk'])) {
    $jml_atk_plg = 0;
    }

     //pengeluran Transnport / Perjalanan Dinas
   $table61_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_plg = mysqli_fetch_array($table61_plg);
   $jml_transport_plg = $data61_plg['jumlah_transport'];
    if (!isset($data61_plg['jumlah_transport'])) {
    $jml_transport_plg = 0;
    }
    //pengeluran Biaya Konsumsi
   $table62_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_plg = mysqli_fetch_array($table62_plg);
   $jml_konsumsi_plg = $data62_plg['jumlah_konsumsi'];
    if (!isset($data62_plg['jumlah_konsumsi'])) {
    $jml_konsumsi_plg = 0;
    }

    //pengeluran perbaikan
   $table7_plg = mysqli_query($koneksibalsri, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_plg = mysqli_fetch_array($table7_plg);
   $jml_perbaikan_plg = $data7_plg['jumlah_perbaikan'];
    if (!isset($data7_plg['jumlah_perbaikan'])) {
    $jml_perbaikan_plg = 0;
    }
 //Gaji karyawan
   $table8_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI PLG' ");
   $data8_plg = mysqli_fetch_array($table8_plg);
   $gaji_karyawan_plg = $data8_plg['jumlah_gaji'];
    if (!isset($data8_plg['jumlah_gaji'])) {
    $gaji_karyawan_plg = 0;
    }
    //Gaji dRIVER
   $table9_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Driver PLG' ");
   $data9_plg = mysqli_fetch_array($table9_plg);
   $gaji_driver_plg = $data9_plg['jumlah_gaji'];
    if (!isset($data9_plg['jumlah_gaji'])) {
    $gaji_driver_plg = 0;
    }
    
    $total_gaji_karyawan_plg = $gaji_karyawan_plg;
        
         //totalkredit
         $table101_plg =  mysqli_query($koneksibalsri, "SELECT mt FROM tagihan_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
    $total_kredit_plg = 0;
    while($data_plg = mysqli_fetch_array($table101_plg)){
        $mt_lmg = $data_plg['mt'];
        $tablee_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt_lmg'");
        $dataa_plg = mysqli_fetch_array($tablee_plg);
        $jml_kredit_plg= $dataa_plg['total_kredit'];
        if(isset($total_kredi_plgt)){
            $total_kredit_plg += $jml_kredit_plg;
        }
        
    }

     $total_oprasional_plg =   $jml_biaya_kantor_plg + $jml_listrik_plg + $jml_sewa_plg + $jml_atk_plg + $total_gaji_karyawan_plg + $jml_transport_plg +  $jml_konsumsi_plg;

     
    // BELITUNG

       // Tagihan
  $table_bb = mysqli_query($koneksibalsri, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_bl a INNER JOIN master_tarif_bl b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data_bb = mysqli_fetch_array($table_bb);
  $total_tagihan_bb = $data_bb['total_tagihan'];

  // Potongan 10%
  $jumlah_potongan_bb = (($total_tagihan_bb * 10) / 100);

  //pengiriman
  $table2_bb = mysqli_query($koneksibalsri, "SELECT SUM(dexlite) AS total_dex, SUM(um) AS uang_makan FROM pengiriman_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data2_bb = mysqli_fetch_array($table2_bb);
  $jml_dex_bb = $data2_bb['total_dex'];
  $total_um_bb = $data2_bb['uang_makan'];
 
  $total_dexlite_bb = $jml_dex_bb * 9700;
    

    
  //pengeluran Pul Biaya Kantor
   $table3_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
   $data3_bb = mysqli_fetch_array($table3_bb);
   $jml_biaya_kantor_bb = $data3_bb['jumlah_biaya_kantor'];
    if (!isset($data3_bb['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor_bb = 0;
    }

   //pengeluran Pul Listrik & Telepon
   $table4_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
   $data4_bb = mysqli_fetch_array($table4_bb);
   $jml_listrik_bb = $data4_bb['jumlah_listrik'];
    if (!isset($data4_bb['jumlah_listrik'])) {
    $jml_listrik_bb = 0;
    }

   //pengeluran Biaya Sewa
   $table5_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
   $data5_bb = mysqli_fetch_array($table5_bb);
   $jml_sewa_bb = $data5_bb['jumlah_sewa'];
    if (!isset($data5_bb['jumlah_sewa'])) {
    $jml_sewa_bb = 0;
    }

   //pengeluran Alat Tulis Kantor
   $table6_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_bB = mysqli_fetch_array($table6_bb);
   $jml_atk_bb = $data6_bB['jumlah_atk'];
    if (!isset($data6_bB['jumlah_atk'])) {
    $jml_atk_bb = 0;
    }

    //pengeluran Transnport / Perjalanan Dinas
   $table61_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_bb = mysqli_fetch_array($table61_bb);
   $jml_transport_bb = $data61_bb['jumlah_transport'];
    if (!isset($data61_bb['jumlah_transport'])) {
    $jml_transport_bb = 0;
    }
    //pengeluran Biaya Konsumsi
   $table62_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_bb = mysqli_fetch_array($table62_bb);
   $jml_konsumsi_bb = $data62_bb['jumlah_konsumsi'];
    if (!isset($data62_bb['jumlah_konsumsi'])) {
    $jml_konsumsi_bb = 0;
    }

    //pengeluran perbaikan
   $table7_bb = mysqli_query($koneksibalsri, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_bb = mysqli_fetch_array($table7_bb);
   $jml_perbaikan_bb = $data7_bb['jumlah_perbaikan'];
    if (!isset($data7_bb['jumlah_perbaikan'])) {
    $jml_perbaikan_bb = 0;
    }
    
    
     //Gaji karyawan
   $table8_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI BB' ");
   $data8_bb = mysqli_fetch_array($table8_bb);
   $gaji_karyawan_bb = $data8_bb['jumlah_gaji'];
    if (!isset($data8_bb['jumlah_gaji'])) {
    $gaji_karyawan_bb = 0;
    }
    //Gaji dRIVER
   $table9_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Driver BB' ");
   $data9_bb = mysqli_fetch_array($table9_bb);
   $gaji_driver_bb = $data9_bb['jumlah_gaji'];
    if (!isset($data9_bb['jumlah_gaji'])) {
    $gaji_driver_bb = 0;
    }
    
    $total_gaji_karyawan_bb = $gaji_karyawan_bta;

   

    $table101_bb =  mysqli_query($koneksibalsri, "SELECT mt FROM tagihan_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
    //totalkredit
    $total_kredit_bb = 0;
    while($data_bb = mysqli_fetch_array($table101_bb)){
        $mt_bb = $data_bb['mt'];
        $tablee_bb = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt_bb'");
        $dataa_bb = mysqli_fetch_array($tablee_bb);
        $jml_kredit_bb = $dataa_bb['total_kredit'];
        if(isset($total_kredit_bb)){
            $total_kredit_bb += $jml_kredit_bb;
        }
        
    }

    $total_oprasional_bb =   $jml_biaya_kantor_bb + $jml_listrik_bb + $jml_sewa_bb + $jml_atk_bb + $total_gaji_karyawan_bb + $jml_transport_bb +  $jml_konsumsi_bb;
  

     $total_tagihan_global = $total_tagihan_lmg + $total_tagihan_plg + $total_tagihan_bta + $total_tagihan_bb + $total_tagihan_spbu;
     $jumlah_potongan_global = (($total_tagihan_global * 10) / 100);
     $biaya_kantor_global = $jml_biaya_kantor_lmg + $jml_biaya_kantor_plg + $jml_biaya_kantor_bta + $jml_biaya_kantor_bb;
     $listrik_global = $jml_listrik_lmg + $jml_listrik_plg + $jml_listrik_bta + $jml_listrik_bb;
     $sewa_global = $jml_sewa_lmg + $jml_sewa_plg + $jml_sewa_bta + $jml_sewa_bb;
     $atk_global = $jml_atk_lmg + $jml_atk_plg + $jml_atk_bta + $jml_atk_bb;
     $gaji_karyawan_global = $total_gaji_karyawan_lmg + $total_gaji_karyawan_plg + $total_gaji_karyawan_bta + $total_gaji_karyawan_bb; 
     $transport_global = $jml_transport_lmg + $jml_transport_plg + $jml_transport_bta + $jml_transport_bb;
     $konsumsi_global = $jml_konsumsi_lmg + $jml_konsumsi_plg + $jml_konsumsi_bta + $jml_konsumsi_bb; 
     $total_oprasional_global = $total_oprasional_bta + $total_oprasional_lmg + $total_oprasional_plg + $total_oprasional_bb;
?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan Uang Oprasional</title>

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
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu PT BALSRI
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >List Perusahaan</span>
    </a>
    <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Perusahaan</h6>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.CBM/view/DsPTCBM">PT.CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/CV.PBJ/view/DsCVPBJ">CV.PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BatuBara/view/DsCVPBJ">Transport BB</a>
            <a class="collapse-item" style="font-size: 15px;" href="DsPTBALSRI">PT.BALSRI</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.MESPBR/view/DsPTPBRMES">PT. MES & PBR</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/Kebun/view/DsKebun">Kebun</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PERTASHOP/view/DsPertashop">Pertashop</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.STRE/view/DsPTSTRE">PT.Sri Trans Energi</a>
        </div>
    </div>
</li>
 <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
      15  aria-expanded="true" aria-controls="collapseOne">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Tagihan</span>
    </a>
    <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Tagihan</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VLuangOP">Lap uang Oprasional</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihan">Tagihan Lampung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanL8">Tagihan Lampung 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanP">Tagihan Pelmbang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanBr">Tagihan Baturaja</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanBl">Tagihan Babel</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLrGlobal">Laba Rugi Global</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugi">Laba Rugi Lampung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiP">Laba Rugi Palembang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBr">Laba Rugi Baturaja</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBl">Laba Rugi Babel</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarif">Master Tarif LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifL8">Master Tarif LMG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifP">Master Tarif PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBr">Master Tarif BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBl">Master Tarif BB</a>
        </div>
    </div>
</li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Pengiriman</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Pengiriman</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Pengiriman LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanL8">Pengiriman LMG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaP">Pengiriman PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaBr">Pengiriman BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaBl">Pengiriman BB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitase">Ritase LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseL8">Ritase LMG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseP">Ritase PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseBr">Ritase BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseBl">Ritase BB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuh">Jarak Tempuh LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhL8">Jarak Tempuh LMG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhP">Jarak Tempuh PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBr">Jarak Tempuh BTA</a> 
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBl">Jarak Tempuh BB</a> 
            
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
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanBl">Catat Perbaikan BB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPul">Pengeluaran Pul LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulP">Pengeluaran Pul PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBr">Pengeluaran Pul BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBl">Pengeluaran Pul BB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGaji">Gaji LMG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiL8">Gaji LMG 8KL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiP">Gaji PLG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiBr">Gaji BTA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiBl">Gaji BB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Gaji Karyawan</a>
        </div>
    </div>
</li>
 <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo13"
      15  aria-expanded="true" aria-controls="collapseTwo1">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
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
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Data Backup</span>
    </a>
    <div id="collapseOnex" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Tagihan</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VLuangOPx">Lap uang Oprasional</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanx">Tagihan Lampung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanPx">Tagihan Pelmbang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanBrx">Tagihan Baturaja</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLrGlobalx">Laba Rugi Global</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugix">Laba Rugi Lampung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiPx">Laba Rugi Palembang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBrx">Laba Rugi Baturaja</a>
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
            <img class="img-profile rounded-circle"
            src="img/undraw_profile.svg">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="userDropdown">
        <a class="dropdown-item" href="VProfile">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
        </a>
        <a class="dropdown-item" href="VSetting">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            Settings
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
   <?php  echo "<form  method='POST' action='VLuangOP' style='margin-bottom: 15px;'>" ?>
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
            <h3 class="panel-title" align="Center"><strong>Laporan Uang Oprasional Global</strong></h3>
        </div>

        <div>

        </div>

        <div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed"  style="color : black;">
    						<thead>
                                <tr>
        							<td><strong>Akun</strong></td>
        							<td class="text-center"><strong>Jumlah</strong></td>
        							<td class="text-right"><strong>Aksi</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
    							<tr>
    								<td>Total Tagihan</td>
    								<td class="text-center"><?php echo formatuang($total_tagihan_global);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRuangOPT?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr  style="background-color:    #F0F8FF; ">
        							<td> <strong>Potongan Oprasional 10%</strong> </td>
    								<td class="text-center"><strong><?php echo formatuang($jumlah_potongan_global);  ?></strong></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                
                                <tr>
        							<td>Biaya Kantor</td>
    								<td class="text-center"><?php echo formatuang($biaya_kantor_global);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Telepon & Listrik</td>
    								<td class="text-center"><?php echo formatuang($listrik_global);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Biaya Sewa</td>
    								<td class="text-center"><?php echo formatuang($sewa_global);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Alat Tulis Kantor</td>
    								<td class="text-center"><?php echo formatuang($atk_global);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Gaji Karyawan</td>
    								<td class="text-center"><?php echo formatuang($gaji_karyawan_global);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Transport / Perjalanan Dinas</td>
    								<td class="text-center"><?php echo formatuang($transport_global);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Konsumsi</td>
    								<td class="text-center"><?php echo formatuang($konsumsi_global); ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr  style="background-color:    #F0F8FF; ">
        							<td><strong>Biaya Oprasional</strong> </td>
    								<td class="text-center"><strong><?php echo formatuang($total_oprasional_global); ?></strong></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                              
    							<tr style="background-color: navy;  color:white;" >
    								<td><strong>Total Sisa Potongan </strong></td>
    								<td class="no-line text-center"><?php echo formatuang($jumlah_potongan_global - $total_oprasional_global ); ?></td>
    								<td class="thick-line"></td>
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

<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laporan Uang Oprasional Lampung</strong></h3>
        </div>

        <div>

        </div>

        <div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed"  style="color : black;">
    						<thead>
                                <tr>
        							<td><strong>Akun</strong></td>
        							<td class="text-center"><strong>Jumlah</strong></td>
        							<td class="text-right"><strong>Aksi</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
    							<tr>
    								<td>Total Tagihan</td>
    								<td class="text-center"><?php echo formatuang($total_tagihan_lmg);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRuangOPT?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr  style="background-color:    #F0F8FF; ">
        							<td> <strong>Potongan Oprasional 10%</strong> </td>
    								<td class="text-center"><strong><?php echo formatuang($jumlah_potongan_lmg);  ?></strong></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                
                                <tr>
        							<td>Biaya Kantor</td>
    								<td class="text-center"><?php echo formatuang($jml_biaya_kantor_lmg);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Telepon & Listrik</td>
    								<td class="text-center"><?php echo formatuang($jml_listrik_lmg);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Biaya Sewa</td>
    								<td class="text-center"><?php echo formatuang($jml_sewa_lmg);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Alat Tulis Kantor</td>
    								<td class="text-center"><?php echo formatuang($jml_atk_lmg);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Gaji Karyawan</td>
    								<td class="text-center"><?php echo formatuang($total_gaji_karyawan_lmg);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Transport / Perjalanan Dinas</td>
    								<td class="text-center"><?php echo formatuang($jml_transport_lmg);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Konsumsi</td>
    								<td class="text-center"><?php echo formatuang($jml_konsumsi_lmg); ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr  style="background-color:    #F0F8FF; ">
        							<td><strong>Biaya Oprasional</strong> </td>
    								<td class="text-center"><strong><?php echo formatuang($total_oprasional_lmg); ?></strong></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                              
    							<tr style="background-color: navy;  color:white;" >
    								<td><strong>Total Sisa Potongan </strong></td>
    								<td class="no-line text-center"><?php echo formatuang($jumlah_potongan_lmg - $total_oprasional_lmg ); ?></td>
    								<td class="thick-line"></td>
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

<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laporan Uang Oprasional Palembang</strong></h3>
        </div>

        <div>

        </div>

        <div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed"  style="color : black;">
    						<thead>
                                <tr>
        							<td><strong>Akun</strong></td>
        							<td class="text-center"><strong>Jumlah</strong></td>
        							<td class="text-right"><strong>Aksi</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
    							<tr>
    								<td>Total Tagihan</td>
    								<td class="text-center"><?php echo formatuang($total_tagihan_plg);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRuangOPT?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr  style="background-color:    #F0F8FF; ">
        							<td> <strong>Potongan Oprasional 10%</strong> </td>
    								<td class="text-center"><strong><?php echo formatuang($jumlah_potongan_plg);  ?></strong></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                
                                <tr>
        							<td>Biaya Kantor</td>
    								<td class="text-center"><?php echo formatuang($jml_biaya_kantor_plg);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Telepon & Listrik</td>
    								<td class="text-center"><?php echo formatuang($jml_listrik_plg);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Biaya Sewa</td>
    								<td class="text-center"><?php echo formatuang($jml_sewa_plg);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Alat Tulis Kantor</td>
    								<td class="text-center"><?php echo formatuang($jml_atk_plg);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Gaji Karyawan</td>
    								<td class="text-center"><?php echo formatuang($total_gaji_karyawan_plg);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Transport / Perjalanan Dinas</td>
    								<td class="text-center"><?php echo formatuang($jml_transport_plg);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Konsumsi</td>
    								<td class="text-center"><?php echo formatuang($jml_konsumsi_plg); ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr  style="background-color:    #F0F8FF; ">
        							<td><strong>Biaya Oprasional</strong> </td>
    								<td class="text-center"><strong><?php echo formatuang($total_oprasional_plg); ?></strong></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                              
    							<tr style="background-color: navy;  color:white;" >
    								<td><strong>Total Sisa Potongan </strong></td>
    								<td class="no-line text-center"><?php echo formatuang($jumlah_potongan_plg - $total_oprasional_plg ); ?></td>
    								<td class="thick-line"></td>
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

<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laporan Uang Oprasional Baturaja</strong></h3>
        </div>

        <div>

        </div>

        <div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed"  style="color : black;">
    						<thead>
                                <tr>
        							<td><strong>Akun</strong></td>
        							<td class="text-center"><strong>Jumlah</strong></td>
        							<td class="text-right"><strong>Aksi</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
    							<tr>
    								<td>Total Tagihan</td>
    								<td class="text-center"><?php echo formatuang($total_tagihan_bta);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRuangOPT?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr  style="background-color:    #F0F8FF; ">
        							<td> <strong>Potongan Oprasional 10%</strong> </td>
    								<td class="text-center"><strong><?php echo formatuang($jumlah_potongan_bta);  ?></strong></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                
                                <tr>
        							<td>Biaya Kantor</td>
    								<td class="text-center"><?php echo formatuang($jml_biaya_kantor_bta);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Telepon & Listrik</td>
    								<td class="text-center"><?php echo formatuang($jml_listrik_bta);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Biaya Sewa</td>
    								<td class="text-center"><?php echo formatuang($jml_sewa_bta);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Alat Tulis Kantor</td>
    								<td class="text-center"><?php echo formatuang($jml_atk_bta);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Gaji Karyawan</td>
    								<td class="text-center"><?php echo formatuang($total_gaji_karyawan_bta);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Transport / Perjalanan Dinas</td>
    								<td class="text-center"><?php echo formatuang($jml_transport_bta);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Konsumsi</td>
    								<td class="text-center"><?php echo formatuang($jml_konsumsi_bta); ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr  style="background-color:    #F0F8FF; ">
        							<td><strong>Biaya Oprasional</strong> </td>
    								<td class="text-center"><strong><?php echo formatuang($total_oprasional_bta); ?></strong></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                              
    							<tr style="background-color: navy;  color:white;" >
    								<td><strong>Total Sisa Potongan </strong></td>
    								<td class="no-line text-center"><?php echo formatuang($jumlah_potongan_bta - $total_oprasional_bta ); ?></td>
    								<td class="thick-line"></td>
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

<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title" align="Center"><strong>Laporan Uang Oprasional Belitung</strong></h3>
        </div>

        <div>

        </div>

        <div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed"  style="color : black;">
    						<thead>
                                <tr>
        							<td><strong>Akun</strong></td>
        							<td class="text-center"><strong>Jumlah</strong></td>
        							<td class="text-right"><strong>Aksi</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
    							<tr>
    								<td>Total Tagihan</td>
    								<td class="text-center"><?php echo formatuang($total_tagihan_bb);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRuangOPT?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr  style="background-color:    #F0F8FF; ">
        							<td> <strong>Potongan Oprasional 10%</strong> </td>
    								<td class="text-center"><strong><?php echo formatuang($jumlah_potongan_bb);  ?></strong></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                
                                <tr>
        							<td>Biaya Kantor</td>
    								<td class="text-center"><?php echo formatuang($jml_biaya_kantor_bb);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Telepon & Listrik</td>
    								<td class="text-center"><?php echo formatuang($jml_listrik_bb);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Biaya Sewa</td>
    								<td class="text-center"><?php echo formatuang($jml_sewa_bb);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Alat Tulis Kantor</td>
    								<td class="text-center"><?php echo formatuang($jml_atk_bb);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Gaji Karyawan</td>
    								<td class="text-center"><?php echo formatuang($total_gaji_karyawan_bb);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Transport / Perjalanan Dinas</td>
    								<td class="text-center"><?php echo formatuang($jml_transport_bb);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Konsumsi</td>
    								<td class="text-center"><?php echo formatuang($jml_konsumsi_bb); ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                                <tr  style="background-color:    #F0F8FF; ">
        							<td><strong>Biaya Oprasional</strong> </td>
    								<td class="text-center"><strong><?php echo formatuang($total_oprasional_bb); ?></strong></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
    							</tr>
                              
    							<tr style="background-color: navy;  color:white;" >
    								<td><strong>Total Sisa Potongan </strong></td>
    								<td class="no-line text-center"><?php echo formatuang($jumlah_potongan_bb - $total_oprasional_bb ); ?></td>
    								<td class="thick-line"></td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>

      
</div>
</div>
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