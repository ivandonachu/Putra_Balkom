<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
  header("Location: logout.php");
  exit;
}
$id = $_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account WHERE id_karyawan = '$id'");
$data1 = mysqli_fetch_array($result1);
$id1 = $data1['id_karyawan'];
$foto_profile = $data1['foto_profile'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Staff Admin') {
} else {
  header("Location: logout.php");
  exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];


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

  $table = mysqli_query($koneksi, "SELECT * FROM pinjam_saldo_admin  WHERE tanggal = '$tanggal_awal'");
} else {

  $table = mysqli_query($koneksi, "SELECT * FROM pinjam_saldo_admin  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");

  //balsri pinjam ke PBJ
  $table_balsri_pbj = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_balsri_pbj FROM pinjam_saldo_admin  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND rekening_dipinjam = 'PBJ' AND rekening_peminjam = 'Balsri' ");
  $data_balsri_pbj = mysqli_fetch_array($table_balsri_pbj);
  $jumlah_balsri_pbj = $data_balsri_pbj['jumlah_balsri_pbj'];
  if (!isset($data_balsri_pbj['jumlah_balsri_pbj'])) {
    $jumlah_balsri_pbj = 0;
  }

  //balsri pinjam ke cbm
  $table_balsri_cbm = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_balsri_cbm FROM pinjam_saldo_admin  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND rekening_dipinjam = 'CBM' AND rekening_peminjam = 'Balsri' ");
  $data_balsri_cbm = mysqli_fetch_array($table_balsri_cbm);
  $jumlah_balsri_cbm = $data_balsri_cbm['jumlah_balsri_cbm'];
  if (!isset($data_balsri_cbm['jumlah_balsri_cbm'])) {
    $jumlah_balsri_cbm = 0;
  }

  //balsri pinjam ke MES
  $table_balsri_mes = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_balsri_mes FROM pinjam_saldo_admin  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND rekening_dipinjam = 'MES' AND rekening_peminjam = 'Balsri' ");
  $data_balsri_mes = mysqli_fetch_array($table_balsri_mes);
  $jumlah_balsri_mes = $data_balsri_mes['jumlah_balsri_mes'];
  if (!isset($data_balsri_mes['jumlah_balsri_mes'])) {
    $jumlah_balsri_mes = 0;
  }

  //balsri pinjam ke PBR
  $table_balsri_pbr = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_balsri_pbr FROM pinjam_saldo_admin  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND rekening_dipinjam = 'PBR' AND rekening_peminjam = 'Balsri' ");
  $data_balsri_pbr = mysqli_fetch_array($table_balsri_pbr);
  $jumlah_balsri_pbr = $data_balsri_pbr['jumlah_balsri_pbr'];
  if (!isset($data_balsri_pbr['jumlah_balsri_pbr'])) {
    $jumlah_balsri_pbr = 0;
  }

  //balsri pinjam ke KEBUN LENGKITI
  $table_balsri_lengkiti = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_balsri_lengkiti FROM pinjam_saldo_admin  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND rekening_dipinjam = 'Kebun Lengkiti' AND rekening_peminjam = 'Balsri' ");
  $data_balsri_lengkiti = mysqli_fetch_array($table_balsri_lengkiti);
  $jumlah_balsri_lengkiti = $data_balsri_lengkiti['jumlah_balsri_lengkiti'];
  if (!isset($data_balsri_lengkiti['jumlah_balsri_lengkiti'])) {
    $jumlah_balsri_lengkiti = 0;
  }

  //balsri pinjam ke KEBUN SEBERUK
  $table_balsri_seberuk = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_balsri_seberuk FROM pinjam_saldo_admin  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND rekening_dipinjam = 'Kebun Seberuk' AND rekening_peminjam = 'Balsri' ");
  $data_balsri_seberuk = mysqli_fetch_array($table_balsri_seberuk);
  $jumlah_balsri_seberuk = $data_balsri_seberuk['jumlah_balsri_seberuk'];
  if (!isset($data_balsri_seberuk['jumlah_balsri_seberuk'])) {
    $jumlah_balsri_seberuk = 0;
  }

  //balsri pinjam ke REKENIGN PRiBADI
  $table_balsri_pribadi = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_balsri_pribadi FROM pinjam_saldo_admin  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND rekening_dipinjam = 'Rekening Priibadi' AND rekening_peminjam = 'Balsri' ");
  $data_balsri_pribadi = mysqli_fetch_array($table_balsri_pribadi);
  $jumlah_balsri_pribadi = $data_balsri_pribadi['jumlah_balsri_pribadi'];
  if (!isset($data_balsri_pribadi['jumlah_balsri_pribadi'])) {
    $jumlah_balsri_pribadi = 0;
  }


  //PBJ pinjam ke BALSRI
  $table_pbj_balsri = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_pbj_balsri FROM pinjam_saldo_admin  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND rekening_dipinjam = 'Balsri' AND rekening_peminjam = 'PBJ' ");
  $data_pbj_balsri = mysqli_fetch_array($table_pbj_balsri);
  $jumlah_pbj_balsri = $data_pbj_balsri['jumlah_pbj_balsri'];
  if (!isset($data_pbj_balsri['jumlah_pbj_balsri'])) {
    $jumlah_pbj_balsri = 0;
  }

  //PBJ pinjam ke cbm
  $table_pbj_cbm = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_pbj_cbm FROM pinjam_saldo_admin  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND rekening_dipinjam = 'CBM' AND rekening_peminjam = 'PBJ' ");
  $data_pbj_cbm = mysqli_fetch_array($table_pbj_cbm);
  $jumlah_pbj_cbm = $data_pbj_cbm['jumlah_pbj_cbm'];
  if (!isset($data_pbj_cbm['jumlah_pbj_cbm'])) {
    $jumlah_pbj_cbm = 0;
  }

  //PBJ pinjam ke MES
  $table_pbj_mes = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_pbj_mes FROM pinjam_saldo_admin  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND rekening_dipinjam = 'MES' AND rekening_peminjam = 'PBJ' ");
  $data_pbj_mes = mysqli_fetch_array($table_pbj_mes);
  $jumlah_pbj_mes = $data_pbj_mes['jumlah_pbj_mes'];
  if (!isset($data_pbj_mes['jumlah_pbj_mes'])) {
    $jumlah_pbj_mes = 0;
  }

  //PBJ pinjam ke PBR
  $table_pbj_pbr = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_pbj_pbr FROM pinjam_saldo_admin  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND rekening_dipinjam = 'PBR' AND rekening_peminjam = 'PBJ' ");
  $data_pbj_pbr = mysqli_fetch_array($table_pbj_pbr);
  $jumlah_pbj_pbr = $data_pbj_pbr['jumlah_pbj_pbr'];
  if (!isset($data_pbj_pbr['jumlah_pbj_pbr'])) {
    $jumlah_pbj_pbr = 0;
  }

  //PBJ pinjam ke KEBUN LENGKITI
  $table_pbj_lengkiti = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_pbj_lengkiti FROM pinjam_saldo_admin  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND rekening_dipinjam = 'Kebun Lengkiti' AND rekening_peminjam = 'PBJ' ");
  $data_pbj_lengkiti = mysqli_fetch_array($table_pbj_lengkiti);
  $jumlah_pbj_lengkiti = $data_pbj_lengkiti['jumlah_pbj_lengkiti'];
  if (!isset($data_pbj_lengkiti['jumlah_pbj_lengkiti'])) {
    $jumlah_pbj_lengkiti = 0;
  }

  //PBJ pinjam ke KEBUN SEBERUK
  $table_pbj_seberuk = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_pbj_seberuk FROM pinjam_saldo_admin  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND rekening_dipinjam = 'Kebun Seberuk' AND rekening_peminjam = 'PBJ' ");
  $data_pbj_seberuk = mysqli_fetch_array($table_pbj_seberuk);
  $jumlah_pbj_seberuk = $data_pbj_seberuk['jumlah_pbj_seberuk'];
  if (!isset($data_pbj_seberuk['jumlah_pbj_seberuk'])) {
    $jumlah_pbj_seberuk = 0;
  }

  //PBJ pinjam ke REKENIGN PRiBADI
  $table_pbj_pribadi = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_pbj_pribadi FROM pinjam_saldo_admin  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND rekening_dipinjam = 'Rekening Priibadi' AND rekening_peminjam = 'PBJ' ");
  $data_pbj_pribadi = mysqli_fetch_array($table_pbj_pribadi);
  $jumlah_pbj_pribadi = $data_pbj_pribadi['jumlah_pbj_pribadi'];
  if (!isset($data_pbj_pribadi['jumlah_pbj_pribadi'])) {
    $jumlah_pbj_pribadi = 0;
  }

    //PBR pinjam ke REKENIGN PRiBADI
    $table_pbr_pribadi = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_pbr_pribadi FROM pinjam_saldo_admin  WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND rekening_dipinjam = 'Rekening Priibadi' AND rekening_peminjam = 'PBR' ");
    $data_pbr_pribadi = mysqli_fetch_array($table_pbr_pribadi);
    $jumlah_pbr_pribadi = $data_pbr_pribadi['jumlah_pbr_pribadi'];
    if (!isset($data_pbr_pribadi['jumlah_pbr_pribadi'])) {
      $jumlah_pbr_pribadi = 0;
    }
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

  <title>Pinjam Saldo Admin</title>

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
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsStaffAdmin">
        <div class="sidebar-brand-icon rotate-n-15">

        </div>
        <div class="sidebar-brand-text mx-3"> <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png"></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="DsStaffAdmin">
          <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
          <span style="font-size: 16px;">Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading" style="font-size: 15px; color:white;">
        Menu Staff Admin
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" 15 aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-cash-register" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">Admin Karyawaan</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Gaji & Kas</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Penggajian dan Rekap</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKasKecil">Pencatatan Kas Kecil</a>
            <a class="collapse-item" style="font-size: 15px;" href="VBonKaryawan">Bon Karyawan CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="VBonKaryawanPbr">Bon Karyawan PBR MES</a>
            <a class="collapse-item" style="font-size: 15px;" href="VBonPribadi">Bon Pribadi Karyawan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKaryawan">List Karyawan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKredit">Kredit Kendaraan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPembelian">Pembelian</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranAdmin">Pengeluaran</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapPinjamSaldo">Rekap Pinjam Saldo</a>
            <a class="collapse-item" style="font-size: 12px;" href="VRekapPengembalianSaldo">Rekap Pengembalian Saldo</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitDriver">Laporan Rit</a>
            <a class="collapse-item" style="font-size: 15px;" href="VBPJSDriver">BPJS Driver</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTransportFee">Transport Fee</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwox" 15 aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-dollar-sign" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">Rekap Gaji CBM</span>
        </a>
        <div id="collapseTwox" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Rekap Gaji CBM</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiCBM">List Gaji CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiCBM">Rekap Gaji CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiDriverCBM">List Gaji Driver CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiDriverCBM">Rekap Gaji Driver CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiDriverKebun">List Gaji Driver Kebun</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiDriverKebun">Rekap Gaji Driver Kebun</a>
          </div>
        </div>
      </li>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwox1" 15 aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-dollar-sign" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">Rekap Gaji MES</span>
        </a>
        <div id="collapseTwox1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Rekap Gaji MES</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiMES">List Gaji MES</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiMES">Rekap Gaji MES</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiDriverMES">List Gaji Driver MES</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiDriverMES">Rekap Gaji Driver MES</a>
          </div>
        </div>
      </li>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2" 15 aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-dollar-sign" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">Rekap Gaji PBR</span>
        </a>
        <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Rekap Gaji PBR</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiPBR">List Gaji PBR</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiPBR">Rekap Gaji PBR</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiDriverPBR">List Gaji Driver PBR</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiDriverPBR">Rekap Gaji Driver PBR</a>
          </div>
        </div>
      </li>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3" 15 aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-dollar-sign" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">Rekap Gaji PBJ</span>
        </a>
        <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Rekap Gaji PBJ</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiPBJ">List Gaji PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiPBJ">Rekap Gaji PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiDriverPBJ">List Gaji Driver PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiDriverPBJ">Rekap Gaji Driver PBJ</a>
          </div>
        </div>
      </li>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo4" 15 aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-dollar-sign" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">Rekap Gaji Balsri</span>
        </a>
        <div id="collapseTwo4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Rekap Gaji Balsri</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiBalsri">List Gaji Balsri</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiBalsri">Rekap Gaji Balsri</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListGajiDriverBalsri">List Gaji Driver Balsri</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapGajiDriverBalsri">Rekap Gaji Driver Balsri</a>
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
          <?php echo "<a href=''><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Pinjam Saldo Admin</h5></a>"; ?>
          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>



          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">


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


            <?php echo "<form  method='POST' action='VRekapPinjamSaldo' style='margin-bottom: 15px;'>" ?>
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
                <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
              </div>
              <div class="col-md-12">

                <!-- Button Input Data Bayar -->
                <div align="right">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Catat Peminjaman </button> <br> <br>
                </div>
                <!-- Form Modal  -->
                <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title"> Form Peminjaman </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <!-- Form Input Data -->
                      <div class="modal-body" align="left">
                        <?php echo "<form action='../proses/proses_pemindahan_saldo?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

                        <div class="row">
                          <div class="col-md-6">
                            <label>Tanggal</label>
                            <input class="form-control form-control-sm" type="date" name="tanggal" required="">
                          </div>
                          <div class="col-md-6">
                            <label>Rekening Dipinjam</label>
                            <select class="form-control form-control-sm" name="rekening_dipinjam" class="form-control">
                              <option>Balsri</option>
                              <option>STRE</option>
                              <option>PBJ</option>
                              <option>CBM</option>
                              <option>PBR</option>
                              <option>MES</option>
                              <option>Kebun Lengkiti</option>
                              <option>Kebun Seberuk</option>
                              <option>Rekening Pribadi</option>
                            </select>
                          </div>
                        </div>

                        <br>

                        <div class="row">
                          <div class="col-md-6">
                            <label>Rekening Peminjam</label>
                            <select class="form-control form-control-sm" name="rekening_peminjam" class="form-control">
                              <option>Balsri</option>
                              <option>STRE</option>
                              <option>PBJ</option>
                              <option>CBM</option>
                              <option>PBR</option>
                              <option>MES</option>
                              <option>Kebun Lengkiti</option>
                              <option>Kebun Seberuk</option>
                              <option>Rekening Pribadi</option>
                            </select>
                          </div>
                          <div class="col-md-6">
                            <label>Jumlah</label>
                            <input class="form-control form-control-sm" type="number" id="jumlah" name="jumlah" required="">
                          </div>
                        </div>


                        <br>

                        <div class="row">
                          <div class="col-md-6">
                            <label>Keterangan</label>
                            <div class="form-group">
                              <textarea class="form-control form-control-sm" name="keterangan" style="width: 300px;"></textarea>
                            </div>
                          </div>
                        </div>

                        <br>

                        <div>
                          <label>Upload File</label>
                          <input type="file" name="file">
                        </div>


                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary"> CATAT</button>
                          <button type="reset" class="btn btn-danger"> RESET</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <!-- Tabel -->
            <div style="overflow-x: auto" align='center'>
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Rekening Dipinjam</th>
                    <th>Rekening Peminjam</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th>File</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  function formatuang($angka)
                  {
                    $uang = "Rp " . number_format($angka, 2, ',', '.');
                    return $uang;
                  }
                  $urut = 0;
                  $total = 0;
                  ?>

                  <?php while ($data = mysqli_fetch_array($table)) {
                    $no_laporan = $data['no_laporan'];
                    $tanggal = $data['tanggal'];
                    $rekening_dipinjam = $data['rekening_dipinjam'];
                    $rekening_peminjam = $data['rekening_peminjam'];
                    $keterangan = $data['keterangan'];
                    $jumlah = $data['jumlah'];
                    $file_bukti = $data['file_bukti'];
                    $urut  = $urut + 1;
                    echo "<tr>
      <td style='font-size: 14px'>$urut</td>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$rekening_dipinjam</td>
      <td style='font-size: 14px'>$rekening_peminjam</td>";
                    echo " <td style='font-size: 14px'>" ?> <?= formatuang($jumlah); ?> <?php echo "</td>
      <td style='font-size: 14px'>$keterangan</td>
      <td style='font-size: 14px'>"; ?> <a download="/PT.CBM/StaffAdmin/file_staff_admin/<?= $file_bukti ?>" href="/PT.CBM/StaffAdmin/file_staff_admin/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>
                      <?php echo "<td style='font-size: 12px'>"; ?>

                      <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_laporan']; ?>">Edit</button>

                      <!-- Form EDIT DATA -->

                      <div class="modal fade bd-example-modal-lg" id="formedit<?php echo $data['no_laporan']; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">Form Edit Laporan </h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                <span aria-hidden="true"> &times; </span>
                              </button>
                            </div>


                            <!-- Form Edit Data -->
                            <div class="modal-body">
                              <form action="../proses/edit_pindah_saldo" enctype="multipart/form-data" method="POST">
                                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                <input type="hidden" name="no_laporan" value="<?php echo $no_laporan; ?>">
                                <div class="row">
                                  <div class="col-md-6">
                                    <label>Tanggal</label>
                                    <input class="form-control form-control-sm" type="date" name="tanggal" required="" value="<?php echo $tanggal; ?>">
                                  </div>
                                  <div class="col-md-6">
                                    <label>Rekening Dipinjam</label>
                                    <select class="form-control form-control-sm" name="rekening_dipinjam" class="form-control">
                                      <?php $dataSelect = $data['rekening_dipinjam']; ?>
                                      <option <?php echo ($dataSelect == 'Balsri') ? "selected" : "" ?>>Balsri</option>
                                      <option <?php echo ($dataSelect == 'STRE') ? "selected" : "" ?>>STRE</option>
                                      <option <?php echo ($dataSelect == 'PBJ') ? "selected" : "" ?>>PBJ</option>
                                      <option <?php echo ($dataSelect == 'CBM') ? "selected" : "" ?>>CBM</option>
                                      <option <?php echo ($dataSelect == 'PBR') ? "selected" : "" ?>>PBR</option>
                                      <option <?php echo ($dataSelect == 'MES') ? "selected" : "" ?>>MES</option>
                                      <option <?php echo ($dataSelect == 'Kebun Seberuk') ? "selected" : "" ?>>Kebun Seberuk</option>
                                      <option <?php echo ($dataSelect == 'Kebun Lengkiti') ? "selected" : "" ?>>Kebun Lengkiti</option>
                                      <option <?php echo ($dataSelect == 'Rekening Pribadi') ? "selected" : "" ?>>Rekening Pribadi</option>
                                    </select>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col-md-6">
                                    <label>Rekening Peminjam</label>
                                    <select class="form-control form-control-sm" name="rekening_peminjam" class="form-control">
                                      <?php $dataSelect = $data['rekening_peminjam']; ?>
                                      <option <?php echo ($dataSelect == 'Balsri') ? "selected" : "" ?>>Balsri</option>
                                      <option <?php echo ($dataSelect == 'STRE') ? "selected" : "" ?>>STRE</option>
                                      <option <?php echo ($dataSelect == 'PBJ') ? "selected" : "" ?>>PBJ</option>
                                      <option <?php echo ($dataSelect == 'CBM') ? "selected" : "" ?>>CBM</option>
                                      <option <?php echo ($dataSelect == 'PBR') ? "selected" : "" ?>>PBR</option>
                                      <option <?php echo ($dataSelect == 'MES') ? "selected" : "" ?>>MES</option>
                                      <option <?php echo ($dataSelect == 'Kebun Seberuk') ? "selected" : "" ?>>Kebun Seberuk</option>
                                      <option <?php echo ($dataSelect == 'Kebun Lengkiti') ? "selected" : "" ?>>Kebun Lengkiti</option>
                                      <option <?php echo ($dataSelect == 'Rekening Pribadi') ? "selected" : "" ?>>Rekening Pribadi</option>
                                    </select>
                                  </div>
                                  <div class="col-md-6">
                                    <label>Jumlah</label>
                                    <input class="form-control form-control-sm" type="number" value="<?php echo $jumlah; ?>" name="jumlah" required="">
                                  </div>
                                </div>

                                <br>

                                <div class="row">
                                  <div class="col-md-6">
                                    <label>Keterangan</label>
                                    <div class="form-group">
                                      <textarea class="form-control form-control-sm" name="keterangan" style="width: 300px;"><?php echo $keterangan; ?></textarea>
                                    </div>
                                  </div>
                                </div>

                                <br>

                                <div>
                                  <label>Upload File</label>
                                  <input type="file" name="file">
                                </div>


                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary"> Ubah </button>
                                  <button type="reset" class="btn btn-danger"> RESET</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_laporan']; ?>" data-toggle='tooltip' title='Hapus Pengeluaran'></button>


                      <div class="modal fade bd-example-modal-lg" id="PopUpHapus<?php echo $data['no_laporan']; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title"> <b> Hapus Laporan </b> </h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                <span aria-hidden="true"> &times; </span>
                              </button>
                            </div>



                            <div class="modal-body">
                              <form action="../proses/hapus_pemindahan_saldo" method="POST">
                                <input type="hidden" name="no_laporan" value="<?php echo $no_laporan; ?>">
                                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">

                                <div class="form-group">
                                  <h6> Yakin Ingin Hapus Data? </h6>
                                </div>

                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary"> Hapus </button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                    <?php echo  " </td> </tr>";
                  }
                    ?>

                </tbody>
              </table>
            </div>

            <br>
            <hr>
            <br>
            <div style="margin-right: 100px; margin-left: 100px;">
              <h6 align="Center">List Total Peminjaman Saldo</h6>
              <div style="overflow-x: auto" align='center'>
                <table id="example1"  class="table-sm table-striped table-bordered  nowrap" style="width:550px">
                  <thead>
                    <th style='font-size: 11px'>PT Peminjam</th>
                    <th style='font-size: 11px'>PT Dipinjam</th>
                    <th style='font-size: 11px'>Jumlah Pinjam</th>
                    </tr>
                  </thead>
                  <tbody>


                    <tr>
                      <td style='font-size: 11px' align='center'>Balsri</td>
                      <td style='font-size: 11px' align='center'>PBJ</td>
                      <td style='font-size: 11px' align='center'><?= formatuang($jumlah_balsri_pbj); ?></td>
                    </tr>

                    <tr>
                      <td style='font-size: 11px' align='center'>Balsri</td>
                      <td style='font-size: 11px' align='center'>CBM</td>
                      <td style='font-size: 11px' align='center'><?= formatuang($jumlah_balsri_cbm); ?></td>
                    </tr>

                    <tr>
                      <td style='font-size: 11px' align='center'>Balsri</td>
                      <td style='font-size: 11px' align='center'>MES</td>
                      <td style='font-size: 11px' align='center'><?= formatuang($jumlah_balsri_mes); ?></td>
                    </tr>

                    <tr>
                      <td style='font-size: 11px' align='center'>Balsri</td>
                      <td style='font-size: 11px' align='center'>PBR</td>
                      <td style='font-size: 11px' align='center'><?= formatuang($jumlah_balsri_pbr); ?></td>
                    </tr>

                    <tr>
                      <td style='font-size: 11px' align='center'>Balsri</td>
                      <td style='font-size: 11px' align='center'>Kebun Lengkiti</td>
                      <td style='font-size: 11px' align='center'><?= formatuang($jumlah_balsri_lengkiti); ?></td>
                    </tr>

                    <tr>
                      <td style='font-size: 11px' align='center'>Balsri</td>
                      <td style='font-size: 11px' align='center'>Kebun Seberuk</td>
                      <td style='font-size: 11px' align='center'><?= formatuang($jumlah_balsri_seberuk); ?></td>
                    </tr>

                    <tr>
                      <td style='font-size: 11px' align='center'>Balsri</td>
                      <td style='font-size: 11px' align='center'>Rekenig Pribadi</td>
                      <td style='font-size: 11px' align='center'><?= formatuang($jumlah_balsri_pribadi); ?></td>
                    </tr>


                    <tr>
                      <td style='font-size: 11px' align='center'>PBJ</td>
                      <td style='font-size: 11px' align='center'>Balsri</td>
                      <td style='font-size: 11px' align='center'><?= formatuang($jumlah_pbj_balsri); ?></td>
                    </tr>

                    <tr>
                      <td style='font-size: 11px' align='center'>PBJ</td>
                      <td style='font-size: 11px' align='center'>CBM</td>
                      <td style='font-size: 11px' align='center'><?= formatuang($jumlah_pbj_cbm); ?></td>
                    </tr>

                    <tr>
                      <td style='font-size: 11px' align='center'>PBJ</td>
                      <td style='font-size: 11px' align='center'>MES</td>
                      <td style='font-size: 11px' align='center'><?= formatuang($jumlah_pbj_mes); ?></td>
                    </tr>

                    <tr>
                      <td style='font-size: 11px' align='center'>PBJ</td>
                      <td style='font-size: 11px' align='center'>PBR</td>
                      <td style='font-size: 11px' align='center'><?= formatuang($jumlah_pbj_pbr); ?></td>
                    </tr>

                    <tr>
                      <td style='font-size: 11px' align='center'>PBJ</td>
                      <td style='font-size: 11px' align='center'>Kebun Lengkiti</td>
                      <td style='font-size: 11px' align='center'><?= formatuang($jumlah_pbj_lengkiti); ?></td>
                    </tr>

                    <tr>
                      <td style='font-size: 11px' align='center'>PBJ</td>
                      <td style='font-size: 11px' align='center'>Kebun Seberuk</td>
                      <td style='font-size: 11px' align='center'><?= formatuang($jumlah_pbj_seberuk); ?></td>
                    </tr>

                    <tr>
                      <td style='font-size: 11px' align='center'>PBJ</td>
                      <td style='font-size: 11px' align='center'>Rekenig Pribadi</td>
                      <td style='font-size: 11px' align='center'><?= formatuang($jumlah_pbj_pribadi); ?></td>
                    </tr>
                    <tr>
                      <td style='font-size: 11px' align='center'>PBR</td>
                      <td style='font-size: 11px' align='center'>Rekenig Pribadi</td>
                      <td style='font-size: 11px' align='center'><?= formatuang($jumlah_pbr_pribadi); ?></td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
            <br>
            <hr>
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
        lengthChange: true,
        buttons: ['excel']
      });

      table.buttons().container()
        .appendTo('#example_wrapper .col-md-6:eq(0)');
    });
  </script>

  
<script>
    $(document).ready(function() {
      var table = $('#example1').DataTable({
        lengthChange: true,
        buttons: ['excel']
      });

      table.buttons().container()
        .appendTo('#example_wrapper .col-md-6:eq(0)');
    });
  </script>

</body>

</html>