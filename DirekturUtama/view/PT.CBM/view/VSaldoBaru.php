<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
  header("Location: logout.php");
  exit;
}
$id = $_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksicbm, "SELECT * FROM super_account WHERE username = '$id'");
$data1 = mysqli_fetch_array($result1);
$nama = $data1['nama_pemilik'];
$foto_profile = $data1['foto_profile'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Direktur Utama') {
} else {
  header("Location: logout.php");
  exit;
}


if (isset($_GET['tanggal1'])) {
  $tanggal_awal = $_GET['tanggal1'];
  $tanggal_akhir = $_GET['tanggal2'];
} elseif (isset($_POST['tanggal1'])) {
  $tanggal_awal = $_POST['tanggal1'];
  $tanggal_akhir = $_POST['tanggal2'];
} else {
  $tanggal_awal = date('Y-m-1');
  $tanggal_akhir = date('Y-m-31');
}

if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksicbm, "SELECT * FROM riwayat_saldo_armada WHERE tanggal = '$tanggal_awal' ");
  $table2 = mysqli_query($koneksicbm, "SELECT * FROM rekening ");
} else {
  $table = mysqli_query($koneksicbm, "SELECT * FROM riwayat_saldo_armada  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
  $table2 = mysqli_query($koneksicbm, "SELECT * FROM rekening ");

  // KELUARRRRRR
  //keluar cbm untuk cbm
  $table3 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_cbm FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'CBM' AND referensi = 'CBM' AND status_saldo = 'Keluar' ");
  $data3 = mysqli_fetch_array($table3);
  $jumlah_kel_cbm = $data3['jumlah_kel_cbm'];
  if (!isset($data3['jumlah_kel_cbm'])) {
    $jumlah_kel_cbm = 0;
  }

  //keluar mes untuk mes
  $table4 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_mes FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'MES' AND referensi = 'MES' AND status_saldo = 'Keluar' ");
  $data4 = mysqli_fetch_array($table4);
  $jumlah_kel_mes = $data4['jumlah_kel_mes'];
  if (!isset($data4['jumlah_kel_mes'])) {
    $jumlah_kel_mes = 0;
  }

  //keluar pbr untuk pbr
  $table5 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_pbr FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PBR' AND referensi = 'PBR' AND status_saldo = 'Keluar' ");
  $data5 = mysqli_fetch_array($table5);
  $jumlah_kel_pbr = $data5['jumlah_kel_pbr'];
  if (!isset($data5['jumlah_kel_pbr'])) {
    $jumlah_kel_pbr = 0;
  }

  //keluar pbj untuk pbj
  $table6 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_pbj FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PBJ' AND referensi = 'PBJ' AND status_saldo = 'Keluar' ");
  $data6 = mysqli_fetch_array($table6);
  $jumlah_kel_pbj = $data6['jumlah_kel_pbj'];
  if (!isset($data6['jumlah_kel_pbj'])) {
    $jumlah_kel_pbj = 0;
  }

  //keluar mt untuk mt
  $table7 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_mt FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'CBM' AND referensi = 'Melodi Tani' AND status_saldo = 'Keluar' ");
  $data7 = mysqli_fetch_array($table7);
  $jumlah_kel_mt = $data7['jumlah_kel_mt'];
  if (!isset($data7['jumlah_kel_mt'])) {
    $jumlah_kel_mt = 0;
  } //keluar balsri untuk balsri
  $table8 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_balsri_balsri FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'BALSRI' AND referensi = 'BALSRI' AND status_saldo = 'Keluar' ");
  $data8 = mysqli_fetch_array($table8);
  $jumlah_kel_balsri_balsri = $data8['jumlah_kel_balsri_balsri'];
  if (!isset($data8['jumlah_kel_balsri_balsri'])) {
    $jumlah_kel_balsri_balsri = 0;
  } //keluar balsri untuk ste
  $table9 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_balsri_ste FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'BALSRI' AND referensi = 'STE' AND status_saldo = 'Keluar' ");
  $data9 = mysqli_fetch_array($table9);
  $jumlah_kel_balsri_ste = $data9['jumlah_kel_balsri_ste'];
  if (!isset($data9['jumlah_kel_balsri_ste'])) {
    $jumlah_kel_balsri_ste = 0;
  } //keluar pribadi untuk kebun 
  $table10 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_pri FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'Kebun Lenkiti' AND status_saldo = 'Keluar' ");
  $data10 = mysqli_fetch_array($table10);
  $jumlah_kel_pri = $data10['jumlah_kel_pri'];
  if (!isset($data10['jumlah_kel_pri'])) {
    $jumlah_kel_pri = 0;
  }

  //keluar pribadi untuk kebun 
  $table101 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_pri_pri FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'PRIBADI' AND status_saldo = 'Keluar' ");
  $data101 = mysqli_fetch_array($table101);
  $jumlah_kel_pri = $data101['jumlah_kel_pri_pri'];
  if (!isset($data101['jumlah_kel_pri_pri'])) {
    $jumlah_kel_pri_pri = 0;
  }
  //keluar PBJ untuk kebun MBAH
  $table1011 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_pbj_kebunmbah FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PBJ' AND referensi = 'Kebun Mbah' AND status_saldo = 'Keluar' ");
  $data1011 = mysqli_fetch_array($table1011);
  $jumlah_kel_pbj_kebunmbah = $data1011['jumlah_kel_pbj_kebunmbah'];
  if (!isset($data1011['jumlah_kel_pbj_kebunmbah'])) {
    $jumlah_kel_pbj_kebunmbah = 0;
  }

  //keluar CBM untuk kebun MBAH
  $table1011y = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_cbm_kebunmbah FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'CBM' AND referensi = 'Kebun Mbah' AND status_saldo = 'Keluar' ");
  $data1011y = mysqli_fetch_array($table1011y);
  $jumlah_kel_cbm_kebunmbah = $data1011y['jumlah_kel_cbm_kebunmbah'];
  if (!isset($data1011y['jumlah_kel_cbm_kebunmbah'])) {
    $jumlah_kel_cbm_kebunmbah = 0;
  }

  //keluar CBM untuk kebun KELING
  $table1011x = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_cbm_keling FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'CBM' AND referensi = 'Kebun Lengkiti' AND status_saldo = 'Keluar' ");
  $data1011x = mysqli_fetch_array($table1011x);
  $jumlah_kel_cbm_keling = $data1011x['jumlah_kel_cbm_keling'];
  if (!isset($data1011x['jumlah_kel_cbm_keling'])) {
    $jumlah_kel_cbm_keling = 0;
  }

  // MASUKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK

  //MASUK cbm untuk cbm
  $table11 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_mas_cbm FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'CBM' AND referensi = 'CBM' AND status_saldo = 'Masuk' ");
  $data11 = mysqli_fetch_array($table11);
  $jumlah_mas_cbm = $data11['jumlah_mas_cbm'];
  if (!isset($data11['jumlah_mas_cbm'])) {
    $jumlah_mas_cbm = 0;
  }

  //MASUK mes untuk mes
  $table12 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_mas_mes FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'MES' AND referensi = 'MES' AND status_saldo = 'Masuk' ");
  $data12 = mysqli_fetch_array($table12);
  $jumlah_mas_mes = $data12['jumlah_mas_mes'];
  if (!isset($data12['jumlah_mas_mes'])) {
    $jumlah_mas_mes = 0;
  }

  //MASUK pbr untuk pbr
  $table13 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_mas_pbr FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PBR' AND referensi = 'PBR' AND status_saldo = 'Masuk' ");
  $data13 = mysqli_fetch_array($table13);
  $jumlah_mas_pbr = $data13['jumlah_mas_pbr'];
  if (!isset($data13['jumlah_mas_pbr'])) {
    $jumlah_mas_pbr = 0;
  }

  //MASUK pbj untuk pbj
  $table14 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_mas_pbj FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PBJ' AND referensi = 'PBJ' AND status_saldo = 'Masuk' ");
  $data14 = mysqli_fetch_array($table14);
  $jumlah_mas_pbj = $data14['jumlah_mas_pbj'];
  if (!isset($data14['jumlah_mas_pbj'])) {
    $jumlah_mas_pbj = 0;
  }

  //MASUK mt untuk mt
  $table15 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_mas_mt FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'CBM' AND referensi = 'Melodi Tani' AND status_saldo = 'Masuk' ");
  $data15 = mysqli_fetch_array($table15);
  $jumlah_mas_mt = $data15['jumlah_mas_mt'];
  if (!isset($data15['jumlah_mas_mt'])) {
    $jumlah_mas_mt = 0;
  } //MASUK balsri untuk balsri
  $table16 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_mas_balsri_balsri FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'BALSRI' AND referensi = 'BALSRI' AND status_saldo = 'Masuk' ");
  $data16 = mysqli_fetch_array($table16);
  $jumlah_mas_balsri_balsri = $data16['jumlah_mas_balsri_balsri'];
  if (!isset($data16['jumlah_mas_balsri_balsri'])) {
    $jumlah_mas_balsri_balsri = 0;
  } //MASUK balsri untuk ste
  $table17 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_mas_balsri_ste FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'BALSRI' AND referensi = 'STE' AND status_saldo = 'Masuk' ");
  $data17 = mysqli_fetch_array($table17);
  $jumlah_mas_balsri_ste = $data17['jumlah_mas_balsri_ste'];
  if (!isset($data17['jumlah_mas_balsri_ste'])) {
    $jumlah_mas_balsri_ste = 0;
  } //MASUK pribadi untuk kebun 
  $table18 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_mas_pri FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'Kebun Lenkiti' AND status_saldo = 'Masuk' ");
  $data18 = mysqli_fetch_array($table18);
  $jumlah_mas_pri = $data18['jumlah_mas_pri'];
  if (!isset($data18['jumlah_mas_pri'])) {
    $jumlah_mas_pri = 0;
  }

  //MASUK pribadi untuk kebun 
  $table19 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_mas_pri_pri FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'PRIBADI' AND status_saldo = 'Masuk' ");
  $data19 = mysqli_fetch_array($table19);
  $jumlah_mas_pri_pri = $data19['jumlah_mas_pri_pri'];
  if (!isset($data19['jumlah_mas_pri_pri'])) {
    $jumlah_mas_pri_pri = 0;
  }

  //MASUK pribadi untuk kebun 
  $table20 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_mas_pri_mbah FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'Kebun Mbah' AND status_saldo = 'Masuk' ");
  $data20 = mysqli_fetch_array($table20);
  $jumlah_mas_pri_mbah = $data20['jumlah_mas_pri_mbah'];
  if (!isset($data20['jumlah_mas_pri_mbah'])) {
    $jumlah_mas_pri_mbah = 0;
  }

  //Keluar pribadi untuk kebun 
  $table21 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_pri_mbah FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'Kebun Mbah' AND status_saldo = 'Keluar' ");
  $data21 = mysqli_fetch_array($table21);
  $jumlah_kel_pri_mbah = $data21['jumlah_kel_pri_mbah'];
  if (!isset($data21['jumlah_kel_pri_mbah'])) {
    $jumlah_kel_pri_mbah = 0;
  }
  //Keluar pribadi untuk CBM 
  $table22 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_pri_cbm FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'CBM' AND status_saldo = 'Keluar' ");
  $data22 = mysqli_fetch_array($table22);
  $jumlah_kel_pri_cbm = $data22['jumlah_kel_pri_cbm'];
  if (!isset($data22['jumlah_kel_pri_cbm'])) {
    $jumlah_kel_pri_cbm = 0;
  }
  //Keluar pribadi untuk MES 
  $table23 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_pri_mes FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'MES' AND status_saldo = 'Keluar' ");
  $data23 = mysqli_fetch_array($table23);
  $jumlah_kel_pri_mes = $data23['jumlah_kel_pri_mes'];
  if (!isset($data23['jumlah_kel_pri_mes'])) {
    $jumlah_kel_pri_mes = 0;
  }
  //Keluar pribadi untuk PBR 
  $table24 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_pri_pbr FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PRIBADI' AND referensi = 'PBR' AND status_saldo = 'Keluar' ");
  $data24 = mysqli_fetch_array($table24);
  $jumlah_kel_pri_pbr = $data24['jumlah_kel_pri_pbr'];
  if (!isset($data24['jumlah_kel_pri_pbr'])) {
    $jumlah_kel_pri_pbr = 0;
  }

  //Keluar pribadi untuk PBR 
  $table25 = mysqli_query($koneksicbm, "SELECT SUM(jumlah) AS jumlah_kel_pbr_ranau FROM riwayat_saldo_armada WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_rekening = 'PBR' AND referensi = 'Kebun Ranau' AND status_saldo = 'Keluar' ");
  $data25 = mysqli_fetch_array($table25);
  $jumlah_kel_pbr_ranau = $data25['jumlah_kel_pbr_ranau'];
  if (!isset($data25['jumlah_kel_pbr_ranau'])) {
    $jumlah_kel_pbr_ranau = 0;
  }

  // kode salado

  $CBM = 'CBM';
  $MES = 'MES';
  $PBR = 'PBR';
  $PBJ = 'PBJ';
  $MT = 'Melodi Tani';
  $BALSRI = 'BALSRI';
  $STE = 'STE';
  $PRIBADI = 'PRIBADI';
  $Kebun = 'Kebun Lengkiti';
  $Keluar = 'Keluar';
  $Masuk = 'Masuk';
  $mbah = 'Kebun Mbah';
  $ranau = 'Kebun Ranau';
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

  <title>Penggunaan Uang</title>

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
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsPTCBM.php">
        <div class="sidebar-brand-icon rotate-n-15">

        </div>
        <div class="sidebar-brand-text mx-3"> <img style="height: 55px; width: 190px;" src="gambar/Logo CBM.png"></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">


      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="DsPTCBM">
          <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
          <span style="font-size: 16px;">Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">
      <!-- Heading -->
      <div class="sidebar-heading" style="font-size: 15px; color:white;">
        Menu PT. CBM
      </div>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1" 15 aria-expanded="true" aria-controls="collapseTwo">
          <i class="fa fa-building" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">List Company</span>
        </a>
        <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Company</h6>
            <a class="collapse-item" style="font-size: 15px;" href="DsPTCBM">PT. CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/CV.PBJ/view/DsCVPBJ">PT.PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BatuBara/view/DsCVPBJ">Transport BB</a>
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.BALSRI/view/DsPTBALSRI">PT.BALSRI</a>
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
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" 15 aria-expanded="true" aria-controls="collapseTwo">
          <i class="fa fa-clipboard-list" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">Laporan Perusahan</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Laporan</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan1">Laporan Keuangan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLPenjualan1">Laporan Penjualan</a>

            <?php if ($nama == 'Nyoman Edy Susanto') {
              echo "<a class='collapse-item' style='font-size: 15px;' href='VLabaRugi'>Laba Rugi</a>";
            } ?>
            <a class="collapse-item" style="font-size: 15px;" href="VSaldoBaru">Laporan Saldo</a>
            <a class="collapse-item" style="font-size: 15px;" href="VBonKaryawan">Laporan BON </a>
            <a class="collapse-item" style="font-size: 15px;" href="VRincianSA">Alokasi SA </a>
            <a class="collapse-item" style="font-size: 15px;" href="VUangPBJ">Uang PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKeberangkatan">Uang Jalan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaran">Pengeluaran Kasir</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKasKecil">Kas Kecil</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Gaji Karyawan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranWorkshop">Pengeluaran Workshop</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2" 15 aria-expanded="true" aria-controls="collapseTwo2">
          <i class="fas fa-file-alt" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">Daftar SDM</span>
        </a>
        <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">SDM</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VAset">Aset</a>
            <a class="collapse-item" style="font-size: 15px;" href="VDokumen">Dokumen</a>
            <a class="collapse-item" style="font-size: 15px;" href="VSeluruhKaryawan">List Karyawan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VSuratKeluarMasuk">Surat Keluar Masuk</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKontrakKerja">Kontrak Kerja</a>
            <a class="collapse-item" style="font-size: 15px;" href="VSuratIzin">Surat Izin</a>
          </div>
        </div>
      </li>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo4" 15 aria-expanded="true" aria-controls="collapseTwo4">
          <i class="fas fa-file-alt" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">Rekap Gaji</span>
        </a>
        <div id="collapseTwo4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">SDM</h6>
            <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiCBM">Rekap Gaji CBM</a>
            <a class="collapse-item" style="font-size: 12pxx;" href="VRekapGajiDriverCBM">Rekap Gaji Driver CBM</a>
            <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiDriverKebun">Rekap Gaji Driver Kebun</a>
            <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiMES">Rekap Gaji MES</a>
            <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiDriverMES">Rekap Gaji Driver MES</a>
            <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiPBR">Rekap Gaji PBR</a>
            <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiDriverPBR">Rekap Gaji Driver PBR</a>
            <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiPBJ">Rekap Gaji PBJ</a>
            <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiDriverPBJ">Rekap Gaji Driver PBJ</a>
            <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiBalsri">Rekap Gaji Balsri</a>
            <a class="collapse-item" style="font-size: 12px;" href="VRekapGajiDriverBalsri">Rekap Gaji Driver Balsri</a>
          </div>
        </div>
      </li>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo5" 15 aria-expanded="true" aria-controls="collapseTwo5">
          <i class="fas fa-file-alt" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">Pengeluaran</span>
        </a>
        <div id="collapseTwo5" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">SDM</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranCBM">Pengeluaran CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranMES">Pengeluaran MES</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPBR">Pengeluaran PBR</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranKebun">Pengeluaran Kebun</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMocashCBM">Mocash CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMocashMES">Mocash MES</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMocashPBR">Mocash PBR</a>
          </div>
        </div>
      </li>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="VLaporanKeuangan">
          <i class="fas fa-file-alt" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">Laporan Rekening</span>
        </a>
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
          <?php echo "<a href='VSaldoBaru'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Penggunaan Saldo Perusahaan</h5></a>"; ?>
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


          <!-- Name Page -->
          <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
            <?php echo "<form  method='POST' action='VSaldoBaru' style='margin-bottom: 15px;'>" ?>
            <div>
              <div align="left" style="margin-left: 20px;">
                <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1">
                <span>-</span>
                <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
                <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm">Lihat</button>
              </div>
            </div>
            </form>

            <div class="row">
              <div class="col-md-8">
                <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir </a>" ?>
              </div>
            </div>


            <!-- Tabel -->
            <div style="overflow-x: auto" align='center'>
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Rekening</th>
                    <th>REF/Digunakan</th>
                    <th>Akun</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                    <th>Keterangan</th>
                    <th>File</th>

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
                    $nama_rekening = $data['nama_rekening'];
                    $referensi = $data['referensi'];
                    $nama_akun = $data['nama_akun'];
                    $jumlah = $data['jumlah'];
                    $file_bukti = $data['file_bukti'];
                    $keterangan = $data['keterangan'];
                    $status_saldo = $data['status_saldo'];
                    $urut = $urut + 1;
                    echo "<tr>
      <td style='font-size: 14px'>$urut</td>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$nama_rekening</td>
      <td style='font-size: 14px'>$referensi</td>
      <td style='font-size: 14px'>$nama_akun</td>
      
     ";


                    if ($status_saldo == 'Masuk') {
                      echo "
        <td style='font-size: 14px'>" ?> <?= formatuang($jumlah); ?> <?php echo "</td>";
                                                                  } else {
                                                                    echo "
        <td style='font-size: 14px'>" ?> <?php echo "</td>";
                                                                  }

                                                                  if ($status_saldo == 'Keluar') {
                                                                    echo "
        <td style='font-size: 14px'>" ?> <?= formatuang($jumlah); ?> <?php echo "</td>";
                                                                  } else {
                                                                    echo "
        <td style='font-size: 14px'>" ?> <?php echo "</td>";
                                                                  }

                                                                  echo "
      <td style='font-size: 14px'>$keterangan</td>
      <td style='font-size: 14px'>"; ?> <a download="/PT.CBM/Oprasional/file_oprasional/<?= $file_bukti ?>" href="/PT.CBM/Oprasional/file_oprasional/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
    </tr>";
                                                                                                                                                                        }
                                                                                                                                                                          ?>

                </tbody>
              </table>
            </div>
          </div>
          <br>
          <br>
          <div style="margin-right: 100px; margin-left: 100px;">
            <h6 align="Center">Laporan Pengeluaran</h6>
            <table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
              <thead>
                <th style='font-size: 11px' align='center'>Rekening</th>
                <th style='font-size: 11px' align='center'>Referensi</th>
                <th style='font-size: 11px' align='center'>Total Keluar</th>
                <th style='font-size: 11px' align='center'></th>
                </tr>
              </thead>
              <tbody>


                <tr>
                  <td style='font-size: 11px' align='center'>CBM</td>
                  <td style='font-size: 11px' align='center'>CBM</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_kel_cbm); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$CBM&rekening=$CBM&status_saldo=$Keluar'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>MES</td>
                  <td style='font-size: 11px' align='center'>MES</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_kel_mes); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$MES&rekening=$MES&status_saldo=$Keluar'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>PBR</td>
                  <td style='font-size: 11px' align='center'>PBR</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_kel_pbr); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$PBR&rekening=$PBR&status_saldo=$Keluar'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>PBJ</td>
                  <td style='font-size: 11px' align='center'>PBJ</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_kel_pbj); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$PBJ&rekening=$PBJ&status_saldo=$Keluar'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>PBJ</td>
                  <td style='font-size: 11px' align='center'>Kebun Mbah</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_kel_pbj_kebunmbah); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$mbah&rekening=$PBJ&status_saldo=$Keluar'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>CBM</td>
                  <td style='font-size: 11px' align='center'>Kebun Mbah</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_kel_cbm_kebunmbah); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$mbah&rekening=$CBM&status_saldo=$Keluar'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>CBM</td>
                  <td style='font-size: 11px' align='center'>Melodi Tani</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_kel_mt); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$MT&rekening=$CBM&status_saldo=$Keluar'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>BALSRI</td>
                  <td style='font-size: 11px' align='center'>BALSRI</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_kel_balsri_balsri); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$BALSRI&rekening=$BALSRI&status_saldo=$Keluar'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>BALSRI</td>
                  <td style='font-size: 11px' align='center'>STE</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_kel_balsri_ste); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$STE&rekening=$BALSRI&status_saldo=$Keluar'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>CBM</td>
                  <td style='font-size: 11px' align='center'>Kebun Lengkiti</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_kel_cbm_keling); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$Kebun&rekening=$CBM&status_saldo=$Keluar'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>PRIBADI</td>
                  <td style='font-size: 11px' align='center'>PRIBADI</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_kel_pri_pri); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$PRIBADI&rekening=$PRIBADI&status_saldo=$Keluar'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>PRIBADI</td>
                  <td style='font-size: 11px' align='center'>Kebun Mbah</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_kel_pri_mbah); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$mbah&rekening=$PRIBADI&status_saldo=$Keluar'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>PRIBADI</td>
                  <td style='font-size: 11px' align='center'>CBM</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_kel_pri_cbm); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$CBM&rekening=$PRIBADI&status_saldo=$Keluar'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>PRIBADI</td>
                  <td style='font-size: 11px' align='center'>MES</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_kel_pri_mes); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$MES&rekening=$PRIBADI&status_saldo=$Keluar'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>PRIBADI</td>
                  <td style='font-size: 11px' align='center'>PBR</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_kel_pri_pbr); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$PBR&rekening=$PRIBADI&status_saldo=$Keluar'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>PBR</td>
                  <td style='font-size: 11px' align='center'>Kebun Ranau</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_kel_pbr_ranau); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$ranau&rekening=$PBR&status_saldo=$Keluar'>Rincian</a></td>"; ?>

                </tr>


              </tbody>
            </table>
          </div>
          <br>
          <br>

          <div style="margin-right: 100px; margin-left: 100px;">
            <h6 align="Center">Laporan Pemasukan</h6>
            <table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
              <thead>
                <th style='font-size: 11px' align='center'>Rekening</th>
                <th style='font-size: 11px' align='center'>Referensi</th>
                <th style='font-size: 11px' align='center'>Total Masuk</th>
                <th style='font-size: 11px' align='center'></th>
                </tr>
              </thead>
              <tbody>


                <tr>
                  <td style='font-size: 11px' align='center'>CBM</td>
                  <td style='font-size: 11px' align='center'>CBM</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_mas_cbm); ?></td>

                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$CBM&rekening=$CBM&status_saldo=$Masuk'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>MES</td>
                  <td style='font-size: 11px' align='center'>MES</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_mas_mes); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$MES&rekening=$MES&status_saldo=$Masuk'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>PBR</td>
                  <td style='font-size: 11px' align='center'>PBR</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_mas_pbr); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$PBR&rekening=$PBR&status_saldo=$Masuk'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>PBJ</td>
                  <td style='font-size: 11px' align='center'>PBJ</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_mas_pbj); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$PBJ&rekening=$PBJ&status_saldo=$Masuk'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>CBM</td>
                  <td style='font-size: 11px' align='center'>Melodi Tani</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_mas_mt); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$MT&rekening=$MT&status_saldo=$Masuk'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>BALSRI</td>
                  <td style='font-size: 11px' align='center'>BALSRI</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_mas_balsri_balsri); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$BALSRI&rekening=$BALSRI&status_saldo=$Masuk'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>BALSRI</td>
                  <td style='font-size: 11px' align='center'>STE</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_mas_balsri_ste); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$STE&rekening=$BALSRI&status_saldo=$Masuk'>Rincian</a></td>"; ?>

                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>CBM</td>
                  <td style='font-size: 11px' align='center'>Kebun Lengkiti</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_mas_pri); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$Kebun&rekening=$CBM&status_saldo=$Masuk'>Rincian</a></td>"; ?>


                </tr>
                <tr>
                  <td style='font-size: 11px' align='center'>PRIBADI</td>
                  <td style='font-size: 11px' align='center'>PRIBADI</td>
                  <td style='font-size: 11px' align='center'><?= formatuang($jumlah_mas_pri_pri); ?></td>
                  <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$PRIBADI&rekening=$PRIBADI&status_saldo=$Masuk'>Rincian</a></td>"; ?>

                </tr>
                <td style='font-size: 11px' align='center'>PRIBADI</td>
                <td style='font-size: 11px' align='center'>Kebun Mbah</td>
                <td style='font-size: 11px' align='center'><?= formatuang($jumlah_mas_pri_mbah); ?></td>
                <?php echo "<td class='thick-line'><a href='VRincianSaldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&referensi=$mbah&rekening=$PRIBADI&status_saldo=$Masuk'>Rincian</a></td>"; ?>

                </tr>

              </tbody>
            </table>
          </div>
          <br>
          <br>





          <?php /*
<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h6 align="center">UANG CBM</h6>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Total Uang Masuk ke CBM</th>
      <th>Total Uang Keluar dari CBM</th>
      <th>Total Uang Disetor ke CBM</th>
      <th>Total Uang CBM di Tangan</th>
      <th>Rincian</th>
    </tr>
  </thead>
  <tbody>

    <?php
      echo "<tr>

      <td style='font-size: 14px'>";?> <?= formatuang($masuk_cbm_cbm + $masuk_cbm_mt + $masuk_cbm_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($masuk_pbj_cbm + $masuk_mt_cbm + $keluar_cbm_balsri + $keluar_cbm_keling + $keluar_cbm_cbm + $keluar_cbm_pbr + $keluar_cbm_mt + $keluar_cbm_pbj + $keluar_cbm_ste); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($setor_cbm_cbm + $setor_cbm_mt + $setor_cbm_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang(($masuk_cbm_cbm + $masuk_cbm_mt + $masuk_cbm_pbj + 15000000) - ($masuk_pbj_cbm + $masuk_mt_cbm + $keluar_cbm_balsri + $keluar_cbm_ste  + $setor_cbm_cbm + $setor_cbm_mt + $setor_cbm_pbj + $keluar_cbm_keling + $keluar_cbm_cbm + $keluar_cbm_pbr + $keluar_cbm_mt + $keluar_cbm_pbj)); ?> <?php echo "</td>
      <td class='text-center'><a href='VRincianCBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>
        </tr>";
  
  ?>

</tbody>
</table>
</div>

<br>

<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h6 align="center">UANG MT</h6>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Total Uang Masuk ke MT</th>
      <th>Total Uang Keluar dari MT</th>
      <th>Total Uang Disetor ke MT</th>
      <th>Total Uang MT di Tangan</th>
      <th>Rincian</th>
    </tr>
  </thead>
  <tbody>

    <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($masuk_mt_mt + $masuk_mt_cbm + $masuk_mt_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($masuk_cbm_mt + $masuk_pbj_mt + $keluar_mt_balsri + $keluar_mt_keling + $keluar_mt_mt + $keluar_mt_pbr + $keluar_mt_cbm + $keluar_mt_pbj + $keluar_mt_ste); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($setor_mt_mt + $setor_mt_cbm + $setor_mt_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang(($masuk_mt_mt + $masuk_mt_cbm + $masuk_mt_pbj)-($masuk_cbm_mt + $masuk_pbj_mt + $keluar_mt_balsri + $keluar_mt_ste + $setor_mt_mt + $setor_mt_cbm + $setor_mt_pbj + $keluar_mt_keling + $keluar_mt_mt + $keluar_mt_pbr + $keluar_mt_cbm + $keluar_mt_pbj)); ?> <?php echo "</td>
      <td class='text-center'><a href='VRincianMT?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>
        </tr>";
  
  ?>

</tbody>
</table>
</div>

<br>

<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h6 align="center">UANG PBJ</h6>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Total Uang Masuk ke PBJ</th>
      <th>Total Uang Keluar dari PBJ</th>
      <th>Total Uang Disetor ke PBJ</th>
      <th>Total Uang PBJ di Tangan</th>
      <th>Rincian</th>
    </tr>
  </thead>
  <tbody>

    <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($masuk_pbj_mt + $masuk_pbj_cbm + $masuk_pbj_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($masuk_cbm_pbj + $masuk_mt_pbj + $keluar_pbj_balsri + $keluar_pbj_keling + $keluar_pbj_pbj + $keluar_pbj_pbr + $keluar_pbj_cbm + $keluar_pbj_mt + $keluar_pbj_ste ); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($setor_pbj_mt + $setor_pbj_cbm + $setor_pbj_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang(($masuk_pbj_mt + $masuk_pbj_cbm + $masuk_pbj_pbj)-($setor_pbj_mt + $setor_pbj_cbm + $setor_pbj_pbj + $masuk_cbm_pbj + $masuk_mt_pbj + $keluar_pbj_balsri + $keluar_pbj_ste + $keluar_pbj_keling + $keluar_pbj_pbj + $keluar_pbj_pbr + $keluar_pbj_cbm + $keluar_pbj_mt )); ?> <?php echo "</td>
      <td class='text-center'><a href='VRincianPBJ?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>
        </tr>";
  
  ?>

</tbody>
</table>
</div>
<br>

<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h6 align="center">Pengeluaran Untuk Balsri</h6>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Total Uang CBM dipakai BALSRI</th>
      <th>Total Uang PBJ dipakai BALSRI</th>
      <th>Total Uang MT dipakai BALSRI</th>
    
      <th>Rincian</th>
    </tr>
  </thead>
  <tbody>

    <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_cbm_balsri); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_pbj_balsri); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_mt_balsri); ?> <?php echo "</td>
      <td class='text-center'><a href='VRincianBALSRI?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>
        </tr>";
  
  ?>

</tbody>
</table>
</div>
<br>

<div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
<h6 align="center">Pengeluaran Untuk STE</h6>
<!-- Tabel -->    
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Total Uang CBM dipakai STE</th>
      <th>Total Uang PBJ dipakai STE</th>
      <th>Total Uang MT dipakai STE</th>
    
      <th>Rincian</th>
    </tr>
  </thead>
  <tbody>

    <?php 
      echo "<tr>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_cbm_ste); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_pbj_ste); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($keluar_mt_ste); ?> <?php echo "</td>
      <td class='text-center'><a href='VRincianSTE?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>
        </tr>";
  
  ?>

</tbody>
</table>
</div>
<br>
*/ ?>





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
        buttons: ['copy', 'excel', 'csv', 'pdf', 'colvis']
      });

      table.buttons().container()
        .appendTo('#example_wrapper .col-md-6:eq(0)');
    });
  </script>

</body>

</html>