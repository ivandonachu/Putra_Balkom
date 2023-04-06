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

if ($tanggal_awal == $tanggal_akhir) {


}
else{
    //TAGIHAN
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

    // Tagihan tanjung gerem 8kl
    $table_tg8kl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_tg_8kl a INNER JOIN master_tarif_tg_8kl b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data_tg8kl = mysqli_fetch_array($table_tg8kl);
    $total_tagihan_tg8kl = $data_tg8kl['total_tagihan'];

    // Tagihan ujung berung
    $table_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_ub a INNER JOIN master_tarif_ub b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data_ub = mysqli_fetch_array($table_ub);
    $total_tagihan_ub = $data_ub['total_tagihan'];



  $total_tagihan_global = $total_tagihan_ba + $total_tagihan_pa + $total_tagihan_pl + $total_tagihan_tg + $total_tagihan_tg8kl + $total_tagihan_ub ;

  // Potongan global 10%
  $jumlah_potongan_global = (($total_tagihan_global * 10) / 100);

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

   //pengiriman tanjung gerem 8kl
   $table2_tg8kl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(um) AS uang_makan , SUM(jt_gps) as total_jt_gps , SUM(uj) AS total_uj  FROM pengiriman_tg_8kl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $total_dexlite_tg8kl =0;
    $data2_tg8kl = mysqli_fetch_array($table2_tg8kl);
   $total_uj_tg8kl = $data2_tg8kl['total_uj'];
   $total_jt_gps_tg8kl = $data2_tg8kl['total_jt_gps'];
   $total_um_tg8kl = $data2_tg8kl['uang_makan'];
   $total_dexlite_tg8kl = $total_uj_tg8kl - ($total_jt_gps_tg8kl*625);

   //pengiriman ujung berung
   $table2_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(um) AS uang_makan , SUM(jt_gps) as total_jt_gps , SUM(uj) AS total_uj  FROM pengiriman_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $total_dexlite_ub =0;
   $data2_ub = mysqli_fetch_array($table2_ub);
   $total_uj_ub = $data2_ub['total_uj'];
   $total_jt_gps_ub = $data2_ub['total_jt_gps'];
   $total_um_ub = $data2_ub['uang_makan'];
   $total_dexlite_ub = $total_uj_ub - ($total_jt_gps_ub*625);

  
    
   $total_dexlite_global = $total_dexlite_ba + $total_dexlite_pa  + $total_dexlite_pl + $total_dexlite_tg + $total_dexlite_tg8kl + $total_dexlite_ub;
    $total_um_global = $total_um_ba + $total_um_pa + $total_um_pl + $total_um_tg + $total_um_tg8kl +  $total_um_ub;
    $total_bbm_global = 0;

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
     //pengeluran Pul Biaya Kantor tanjung gerem 8kl
    $table3_tg8kl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_tg_8kl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
    $data3_tg8kl = mysqli_fetch_array($table3_tg8kl);
    $jml_biaya_kantor_tg8kl = $data3_tg8kl['jumlah_biaya_kantor'];
     if (!isset($data3_tg8kl['jumlah_biaya_kantor'])) {
     $jml_biaya_kantor_tg8kl = 0;
     }
     //pengeluran Pul Biaya Kantor ujung berung
   $table3_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
   $data3_ub = mysqli_fetch_array($table3_ub);
   $jml_biaya_kantor_ub = $data3_ub['jumlah_biaya_kantor'];
    if (!isset($data3_ub['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor_ub = 0;
    }

     $biaya_kantor_global = $jml_biaya_kantor_ba + $jml_biaya_kantor_pa + $jml_biaya_kantor_pl + $jml_biaya_kantor_tg + $jml_biaya_kantor_tg8kl + $jml_biaya_kantor_ub;

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
     //pengeluran Pul Listrik & Telepon tanjung gerem 8kl
    $table4_tg8kl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_tg_8kl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
    $data4_tg8kl = mysqli_fetch_array($table4_tg8kl);
    $jml_listrik_tg8kl = $data4_tg8kl['jumlah_listrik'];
     if (!isset($data4_tg8kl['jumlah_listrik'])) {
     $jml_listrik_tg8kl = 0;
     }
     //pengeluran Pul Listrik & Telepon ujung berung
   $table4_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
   $data4_ub = mysqli_fetch_array($table4_ub);
   $jml_listrik_ub = $data4_ub['jumlah_listrik'];
    if (!isset($data4_ub['jumlah_listrik'])) {
    $jml_listrik_ub = 0;
    }

     $listrik_global = $jml_listrik_ba + $jml_listrik_pa + $jml_listrik_pl + $jml_listrik_tg + $jml_listrik_tg8kl + $jml_listrik_ub;

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

     //pengeluran Biaya Sewa tanjung gerem 8kl
    $table5_tg8kl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_tg_8kl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
    $data5_tg8kl = mysqli_fetch_array($table5_tg8kl);
    $jml_sewa_tg8kl = $data5_tg8kl['jumlah_sewa'];
     if (!isset($data5_tg8kl['jumlah_sewa'])) {
     $jml_sewa_tg8kl = 0;
     }
     //pengeluran Biaya Sewa ujung berung
   $table5_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
   $data5_ub = mysqli_fetch_array($table5_ub);
   $jml_sewa_ub = $data5_ub['jumlah_sewa'];
    if (!isset($data5_ub['jumlah_sewa'])) {
    $jml_sewa_ub = 0;
    }

     $biaya_sewa_global = $jml_sewa_ba + $jml_sewa_pa + $jml_sewa_pl + $jml_sewa_tg + $jml_sewa_tg8kl + $jml_sewa_ub;

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
    //pengeluran Alat Tulis Kantor tanjung gerem 8kl
   $table6_tg8kl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_tg_8kl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_tg8kl = mysqli_fetch_array($table6_tg8kl);
   $jml_atk_tg8kl = $data6_tg8kl['jumlah_atk'];
    if (!isset($data6_tg8kl['jumlah_atk'])) {
    $jml_atk_tg8kl = 0;
    }
    //pengeluran Alat Tulis Kantor ujung berung
   $table6_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6_ub = mysqli_fetch_array($table6_ub);
   $jml_atk_ub = $data6_ub['jumlah_atk'];
    if (!isset($data6_ub['jumlah_atk'])) {
    $jml_atk_ub = 0;
    }

    $atk_global = $jml_atk_ba + $jml_atk_pa + $jml_atk_pl + $jml_atk_tg + $jml_atk_tg8kl + $jml_atk_ub;

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

    //pengeluran Transnport / Perjalanan Dinas tanjung gerem 8kl
   $table61_tg8kl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul_tg_8kl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_tg8kl = mysqli_fetch_array($table61_tg8kl);
   $jml_transport_tg8kl = $data61_tg8kl['jumlah_transport'];
    if (!isset($data61_tg8kl['jumlah_transport'])) {
    $jml_transport_tg8kl = 0;
    }
    //pengeluran Transnport / Perjalanan Dinas ujung berung
   $table61_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61_ub = mysqli_fetch_array($table61_ub);
   $jml_transport_ub = $data61_ub['jumlah_transport'];
    if (!isset($data61_ub['jumlah_transport'])) {
    $jml_transport_ub = 0;
    }


    $transport_global = $jml_transport_ba + $jml_transport_pa + $jml_transport_pl + $jml_transport_tg + $jml_transport_tg8kl + $jml_transport_ub;
    
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

        //pengeluran Biaya Konsumsi tanjung gerem 8kl
   $table62_tg8kl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul_tg_8kl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_tg8kl = mysqli_fetch_array($table62_tg8kl);
   $jml_konsumsi_tg8kl = $data62_tg8kl['jumlah_konsumsi'];
    if (!isset($data62_tg8kl['jumlah_konsumsi'])) {
    $jml_konsumsi_tg8kl = 0;
    }
    //pengeluran Biaya Konsumsi ujung berung
   $table62_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62_ub = mysqli_fetch_array($table62_ub);
   $jml_konsumsi_ub = $data62_ub['jumlah_konsumsi'];
    if (!isset($data62_ub['jumlah_konsumsi'])) {
    $jml_konsumsi_ub = 0;
    }

     $konsumsi_global = $jml_konsumsi_ba + $jml_konsumsi_pa + $jml_konsumsi_pl + $jml_konsumsi_tg + $jml_konsumsi_tg8kl + $jml_konsumsi_ub;

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
    
        //pengeluran perbaikan tanjung gerem 8kl
   $table7_tg8kl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_tg_8kl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_tg8kl = mysqli_fetch_array($table7_tg8kl);
   $jml_perbaikan_tg8kl = $data7_tg8kl['jumlah_perbaikan'];
    if (!isset($data7_tg8kl['jumlah_perbaikan'])) {
    $jml_perbaikan_tg8kl = 0;
    }

    //pengeluran perbaikan ujung berung
   $table7_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_ub WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7_ub = mysqli_fetch_array($table7_ub);
   $jml_perbaikan_ub = $data7_ub['jumlah_perbaikan'];
    if (!isset($data7_ub['jumlah_perbaikan'])) {
    $jml_perbaikan_ub= 0;
    }
    
    $perbaikan_global = $jml_perbaikan_ba + $jml_perbaikan_pa + $jml_perbaikan_pl + $jml_perbaikan_tg + $jml_perbaikan_tg8kl + $jml_perbaikan_ub;
    
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

    //Gaji karyawan tanjung gerem 8kl
   $table8_tg_8kl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI TG 8KL' ");
   $data8_tg_8kl = mysqli_fetch_array($table8_tg_8kl);
   $gaji_karyawan_tg_8kl = $data8_tg_8kl['jumlah_gaji'];
    if (!isset($data8_tg_8kl['jumlah_gaji'])) {
    $gaji_karyawan_tg_8kl = 0;
    }

    //Gaji karyawan Ujung berung
   $table8_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI UB' ");
   $data8_ub = mysqli_fetch_array($table8_ub);
   $gaji_karyawan_ub = $data8_ub['jumlah_gaji'];
    if (!isset($data8_ub['jumlah_gaji'])) {
    $gaji_karyawan_ub = 0;
    }

    $gaji_karyawan_global = $gaji_karyawan_ba + $gaji_karyawan_pa + $gaji_karyawan_pl + $gaji_karyawan_tg + $gaji_karyawan_tg_8kl + $gaji_karyawan_ub;

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

         //Gaji dRIVER tanjung gerem
   $table9_tg_8kl = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Driver TG 8KL' ");
   $data9_tg_8kl = mysqli_fetch_array($table9_tg_8kl);
   $gaji_driver_tg_8kl = $data9_tg_8kl['jumlah_gaji'];
    if (!isset($data9_tg_8kl['jumlah_gaji'])) {
    $gaji_driver_tg_8kl = 0;
    }
    //Gaji dRIVER ujung berung
   $table9_ub = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI UB' ");
   $data9_ub = mysqli_fetch_array($table9_ub);
   $gaji_driver_ub = $data9_ub['jumlah_gaji'];
    if (!isset($data9_ub['jumlah_gaji'])) {
    $gaji_driver_ub = 0;
    }
    
    $gaji_driver_global = $gaji_driver_ba + $gaji_driver_pa + $gaji_driver_pl + $gaji_driver_tg + $gaji_driver_tg_8kl + $gaji_driver_ub;
    
    $total_gaji_karaywan_global = $gaji_karyawan_global + $gaji_driver_global ;


    //totalkreditGLOBAL


        $tablee = mysqli_query($koneksibalsri_jbb, "SELECT SUM(jumlah) AS total_kredit FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
        $dataa = mysqli_fetch_array($tablee);
        $total_kredit= $dataa['total_kredit'];

        $total_kredit = $total_kredit;
        
        
 



}
    $total_laba_kotor = $total_tagihan_global - $jumlah_potongan_global;  

    $total_biaya_usaha_final = $total_dexlite_global + $biaya_kantor_global + $listrik_global + $biaya_sewa_global + $atk_global + $perbaikan_global + $total_um_global + $total_gaji_karaywan_global + $transport_global +  $konsumsi_global + $total_kredit;

    $total_biaya_usaha_final_bbm = $total_bbm_global + $biaya_kantor_global + $listrik_global + $biaya_sewa_global + $atk_global + $perbaikan_global + $total_um_global + $total_gaji_karaywan_global + $transport_global +  $konsumsi_global + $total_kredit;
           
    $laba_bersih_sebelum_pajak = $total_tagihan_global - $total_biaya_usaha_final;
    $laba_bersih_sebelum_pajak_bbm = $total_tagihan_global - $total_biaya_usaha_final_bbm;
            
?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan Laba Rugi GLOBAL JBB</title>

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
    <a class="nav-link" href="DsBALSRIJBB">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

<!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu PT BALSRI JBB
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
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.BALSRI/view/DsPTBALSRI">PT.BALSRI</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.MESPBR/view/DsPTPBRMES">PT. MES & PBR</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/Kebun/view/DsKebun">Kebun</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PERTASHOP/view/DsPertashop">Pertashop</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.STRE/view/DsPTSTRE">PT.Sri Trans Energi</a>
            <a class="collapse-item" style="font-size: 15px;" href="DsBALSRIJBB">BALSRI JBB</a>
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
              echo"<a class='collapse-item' style='font-size: 15px;' href='VLuangOP'>Lap uang Oprasional</a>";
            } ?>
            <?php if($nama == 'Nyoman Edy Susanto'){
              echo" <a class='collapse-item' style='font-size: 15px;' href='VLrGlobalJBB'>LR Global JBB</a>
              <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiTG'>LR Tj Gerem</a>
              <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiPA'>LR Padalarang</a>
              <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiPL'>LR Plumpang</a>
              <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiUB'>LR Ujung Berung</a>
              <a class='collapse-item' style='font-size: 15px;' href='VLabaRugiBA'>LR Balongan</a>";
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
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanTG">Tagihan Tj Gerem</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanPA">Tagihan Padalarang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanPL">Tagihan Plumpang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanUB">Tagihan Ujung Berung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanBA">Tagihan Balongan</a>
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
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanTG">Pengiriman TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanPA">Pengiriman PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanPL">Pengiriman PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanUB">Pengiriman UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanBA">Pengiriman BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseTG">Ritase TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitasePA">Ritase PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitasePL">Ritase PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseUB">Ritase UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseBA">Ritase BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhTG">Jarak Tempuh TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhPA">Jarak Tempuh PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhPL">Jarak Tempuh PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhUB">Jarak Tempuh UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBA">Jarak Tempuh BA</a>

            
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
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanTG">Perbaikan TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanPA">Perbaikan PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanPL">Perbaikan PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanUB">Perbaikan UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanBA">Perbaikan BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulTG">Pengeluaran Pul TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulPA">Pengeluaran Pul PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulPL">Pengeluaran Pul PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulUB">Pengeluaran Pul UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBA">Pengeluaran Pul BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiTG">Gaji TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiPA">Gaji PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiPL">Gaji PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiUB">Gaji UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiBA">Gaji BA</a>
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
    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php $foto_profile = $data1['foto_profile']; ?>
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
   <?php  echo "<form  method='POST' action='VLrGlobalJBB' style='margin-bottom: 15px;'>" ?>
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
            <h3 class="panel-title" align="Center"><strong>Laba Rugi Balsri Global JBB Region Jawa</strong></h3>
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
                     <td class="text-right"><strong>Aksi</strong></td>
                 </tr>
             </thead>
             <tbody>
                 <!-- foreach ($order->lineItems as $line) or some such thing here -->
                 <tr>
                    <td><strong>4-000</strong></td>
                    <td class="text-left"><strong>PENDAPATAN</strong></td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                    <?php echo "<td class='text-right'></td>"; ?>
                </tr>
                <tr>
                 <td>4-100</td>
                 <td class="text-left">Tagihan Global</td>
                 <td class="text-left"><?= formatuang($total_tagihan_global); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
                 <?php echo "<td class='text-right'><a href='VRincianLRBTA/VRTagihan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
             </tr>
             <tr>
                 <td>4-101</td>
                 <td class="text-left">Potongan Biaya Oprasional 10%</td>
                 <td class="text-left"><?= formatuang($jumlah_potongan_global); ?></td>
                 <td class="text-left"><?= formatuang(0); ?></td>
                 <td class="text-left"></td>
             </tr>
             <tr style="background-color: navy;  color:white;">
                <td><strong>LABA KOTOR</strong></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"><?= formatuang($total_laba_kotor); ?> </td>
                <td class="no-line text-left"><?= formatuang(0); ?> </td>
                <td class="thick-line"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
                <td class="thick-line"></td>
            </tr>
            <tr>
                <td><strong>5-500</strong></td>
                <td class="text-left"><strong>BIAYA USAHA</strong></td>
                <td class="text-left"></td>
                <td class="text-left"></td>
                <?php echo "<td class='text-right'></td>"; ?>
            </tr>
            <tr>
                <td>5-510</td>
                <td class="text-left">GAJI</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_gaji_karaywan_global); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRBTA/VRGaji?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
            </tr>
            <tr>
                <td>5-520</td>
                <td class="text-left">Alat Tulis Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($atk_global); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRBTA/VRATK?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
            </tr>
            <tr>
                <td>5-530</td>
                <td class="text-left">Transport & Perjalanan Dinas</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($transport_global); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRBTA/VRPerjalanan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
            </tr>
            <tr>
                <td>5-540</td>
                <td class="text-left">Biaya Kantor</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($biaya_kantor_global); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRBTA/VRBiayaKantor?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
            </tr>
            <tr>
                <td>5-550</td>
                <td class="text-left">Listrik & Telepon</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($listrik_global); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRBTA/VRListrik?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
            </tr>
            <tr>
                <td>5-560</td>
                <td class="text-left">Biaya Konsumsi</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($konsumsi_global); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRBTA/VRKonsumsi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
            </tr>
            <tr>
                <td>5-570</td>
                <td class="text-left">Biaya Sewa</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($biaya_sewa_global); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRBTA/VRSewa?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
            </tr>
            
            <tr>
                <td>5-595</td>
                <td class="text-left">Biaya Perbaikan Kendaraan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($perbaikan_global); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRBTA/VRPerbaikan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
            </tr>
            <tr>
                <td>5-596</td>
                <td class="text-left">Uang Makan</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_um_global); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRBTA/VRMakan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
            </tr>
            <tr>
                <td>5-597</td>
                <td class="text-left">Uang Dexlite</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_dexlite_global); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRBTA/VRDexlite?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
            </tr>
            <tr>
                <td>5-5971</td>
                <td class="text-left">Uang BBM</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_bbm_global); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRBTA/VRDexlite?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
            </tr>
            <tr>
                <td>5-598</td>
                <td class="text-left">Bayar Kredit</td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_kredit); ?></td>
                <?php echo "<td class='text-right'><a href='VRincianLRBTA/VRKredit?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'></a></td>"; ?>
            </tr>
            <tr style="background-color:    #F0F8FF; ">
                <td><strong>Total Biaya Usaha</strong></td>
                <td class="thick-line"></td>
                <td class="text-left"><?= formatuang(0); ?></td>
                <td class="text-left"><?= formatuang($total_biaya_usaha_final); ?></td>
                <td class="thick-line"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
                <td class="thick-line"></td>
            </tr>
            <tr>
                <td></td>
                <td class="thick-line"></td>
                <td class="no-line text-left"></td>
                <td class="no-line text-left"></td>
                <td class="thick-line"></td>
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
                <td class="thick-line"></td>
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