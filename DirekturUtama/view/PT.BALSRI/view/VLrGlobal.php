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
    // Tagihan baturaja
  $table_br = mysqli_query($koneksibalsri, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_br a INNER JOIN master_tarif_br b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data_br = mysqli_fetch_array($table_br);
  $total_tagihan_br = $data_br['total_tagihan'];

  // Tagihan lampung
  $table_lmg = mysqli_query($koneksibalsri, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan a INNER JOIN master_tarif b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data_lmg = mysqli_fetch_array($table_lmg);
  $total_tagihan_lmg = $data_lmg['total_tagihan'];

  // Tagihan palembang
  $table_plg = mysqli_query($koneksibalsri, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_p a INNER JOIN master_tarif_p b ON a.no=b.no  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data_plg = mysqli_fetch_array($table_plg);
  $total_tagihan_plg = $data_plg['total_tagihan'];

  $total_tagihan_global = $total_tagihan_br + $total_tagihan_lmg + $total_tagihan_plg;

  // Potongan global 10%
  $jumlah_potongan_global = (($total_tagihan_global * 10) / 100);

  //PENGIRIMAN
  //pengiriman baturaja
  $table2_br = mysqli_query($koneksibalsri, "SELECT SUM(dexlite) AS total_dex, SUM(um) AS uang_makan FROM pengiriman_br WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data2_br = mysqli_fetch_array($table2_br);
  $jml_dex_br = $data2_br['total_dex'];
  $total_um_br = $data2_br['uang_makan'];
 
  $total_dexlite_br = $jml_dex_br * 13250;

  //pengiriman lampung
  $table2_lmg = mysqli_query($koneksibalsri, "SELECT SUM(dexlite) AS total_dex, SUM(um) AS uang_makan FROM pengiriman WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data2_lmg = mysqli_fetch_array($table2_lmg);
  $jml_dex_lmg = $data2_lmg['total_dex'];
  $total_um_lmg = $data2_lmg['uang_makan'];
 
  $total_dexlite_lmg = $jml_dex_lmg * 13250;

   //pengiriman palembang
   $table2_plg = mysqli_query($koneksibalsri, "SELECT SUM(dexlite) AS total_dex, SUM(um) AS uang_makan FROM pengiriman_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
   $data2_plg = mysqli_fetch_array($table2_plg);
   $jml_dex_plg = $data2_plg['total_dex'];
   $total_um_plg = $data2_plg['uang_makan'];
   $total_dexlite_plg = $jml_dex_plg * 13250;
    
   $total_dexlite_global = $total_dexlite_br + $total_dexlite_plg + $total_dexlite_lmg;
    $total_um_global = $total_um_br + $total_um_lmg + $total_um_plg;

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

     $biaya_kantor_global = $jml_biaya_kantor_br + $jml_biaya_kantor_lmg + $jml_biaya_kantor_plg;

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

     $listrik_global = $jml_listrik_br + $jml_listrik_lmg + $jml_listrik_plg;

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
    //pengeluran Biaya Sewa
    $table5_plg = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_p WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
    $data5_plg = mysqli_fetch_array($table5_plg);
    $jml_sewa_plg = $data5_plg['jumlah_sewa'];
     if (!isset($data5_plg['jumlah_sewa'])) {
     $jml_sewa_plg = 0;
     }

     $biaya_sewa_global = $jml_sewa_br + $jml_sewa_lmg + $jml_sewa_plg;

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
    $atk_global = $jml_atk_br + $jml_atk_lmg + $jml_atk_plg;

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

    $transport_global = $jml_transport_br + $jml_transport_lmg + $jml_transport_plg;
    
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

     $konsumsi_global = $jml_konsumsi_br + $jml_konsumsi_lmg + $jml_konsumsi_plg;

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
    
    $perbaikan_global = $jml_perbaikan_br + $jml_perbaikan_lmg + $jml_perbaikan_plg;
    
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

    $gaji_karyawan_global = $gaji_karyawan_br + $gaji_karyawan_lmg + $gaji_karyawan_plg;

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
    
    $gaji_driver_global = $gaji_driver_br + $gaji_driver_lmg + $gaji_driver_plg;
    
    $total_gaji_karaywan_global = $gaji_karyawan_global + $gaji_driver_global;


    //totalkreditGLOBAL

        $tablee = mysqli_query($koneksibalsri, "SELECT SUM(jumlah) AS total_kredit FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
        $dataa = mysqli_fetch_array($tablee);
        $total_kredit= $dataa['total_kredit'];

        
 



}
    $total_laba_kotor = $total_tagihan_global - $jumlah_potongan_global;  
    $total_biaya_usaha_final = $total_dexlite_global + $biaya_kantor_global + $listrik_global + $biaya_sewa_global + $atk_global + $perbaikan_global + $total_um_global + $total_gaji_karaywan_global + $transport_global +  $konsumsi_global + $total_kredit;
           
    $laba_bersih_sebelum_pajak = $total_tagihan_global - $total_biaya_usaha_final;
            
?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan Laba Rugi GLOBAL</title>

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
                        <a class="collapse-item" style="font-size: 15px;" href="VTagihanP">Tagihan Pelmbang</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VTagihanBr">Tagihan Baturaja</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLrGlobal">Laba Rugi Global</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLabaRugi">Laba Rugi Lampung</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiP">Laba Rugi Palembang</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBr">Laba Rugi Baturaja</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMasterTarif">Master Tarif LMG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifP">Master Tarif PLG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBr">Master Tarif BTA</a>
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
                        <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaP">Pengiriman PLG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaBr">Pengiriman BTA</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitase">Ritase LMG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitaseP">Ritase PLG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitaseBr">Ritase BTA</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuh">Jarak Tempuh LMG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhP">Jarak Tempuh PLG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBr">Jarak Tempuh BTA</a> 
                        
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
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPul">Pengeluaran Pul LMG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulP">Pengeluaran Pul PLG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBr">Pengeluaran Pul BTA</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VGaji">Gaji LMG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VGajiP">Gaji PLG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VGajiBr">Gaji BTA</a>
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
   <?php  echo "<form  method='POST' action='VLrGlobal' style='margin-bottom: 15px;'>" ?>
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
            <h3 class="panel-title" align="Center"><strong>Laba Rugi Balsri Gloabal</strong></h3>
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
                <td><strong>LABA BERSIH SEBELUM PAJAK</strong></td>
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
                else if ($total_tagihan == 0) { ?>

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