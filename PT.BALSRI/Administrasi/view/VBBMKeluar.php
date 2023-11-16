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
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Administrasi') {
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
    $lokasi = $_GET['lokasi'];
} elseif (isset($_POST['tanggal1'])) {
    $tanggal_awal = $_POST['tanggal1'];
    $tanggal_akhir = $_POST['tanggal2'];
    $lokasi = $_POST['lokasi'];
} else {
    $tanggal_awal = date('Y-m-1');
    $tanggal_akhir = date('Y-m-31');
    $lokasi = 'Palembang';
}

if ($tanggal_awal == $tanggal_akhir) {

    $table = mysqli_query($koneksi, "SELECT * FROM laporan_bbm_keluar WHERE tanggal = '$tanggal_awal' AND lokasi = '$lokasi'");
} else {

    $table = mysqli_query($koneksi, "SELECT * FROM laporan_bbm_keluar WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND lokasi = '$lokasi' ");
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

    <title>Laporan BBM Keluar <?= $lokasi ?></title>

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
                <div class="sidebar-brand-text mx-3"> <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png"></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="DsAdministrasi">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 16px;">Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading" style="font-size: 15px; color:white;">
                Menu Administrasi
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" 15 aria-expanded="true" aria-controls="collapseOne">
                    <i class="fas fa-file-invoice-dollar" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">Tagihan</span>
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
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" 15 aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-truck" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">Pengiriman</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
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
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo22" 15 aria-expanded="true" aria-controls="collapseTwo22">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">Pengeluaran</span>
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
                    </div>
                </div>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1" 15 aria-expanded="true" aria-controls="collapseTwo1">
                    <i class="fas fa-car" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">SDM</span>
                </a>
                <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VAMT">AMT</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMT">MT</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMT">MT</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VBayarKredit">Kredit Kendaraan</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1z" 15 aria-expanded="true" aria-controls="collapseTwo1z">
                    <i class="fas fa-car" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">BBM</span>
                </a>
                <div id="collapseTwo1z" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu BBM</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VStokBBM">Lap Stok BBM</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VBBMMasuk">Lap BBM Masuk</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VBBMKeluar">Lap BBM Keluar</a>
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
                    <?php echo "<a href=''><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Laporan BBM Keluar $lokasi</h5></a>"; ?>

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


                    <!-- Name Page -->
                    <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
                        <div style="margin-right: 100px; margin-left: 100px;">

                            <?php echo "<form  method='POST' action='VBBMKeluar'>" ?>
                            <div>
                                <div align="left" style="margin-left: 20px;">
                                    <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1">
                                    <span>-</span>
                                    <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
                                    <select id="lokasi" name="lokasi" s>
                                        <?php $dataSelect = $lokasi; ?>
                                        <option <?php echo ($dataSelect == 'Palembang') ? "selected" : "" ?>>Palembang</option>
                                        <option <?php echo ($dataSelect == 'Lampung') ? "selected" : "" ?>>Lampung</option>
                                        <option <?php echo ($dataSelect == 'Baturaja') ? "selected" : "" ?>>Baturaja</option>
                                        <option <?php echo ($dataSelect == 'Bengkulu') ? "selected" : "" ?>>Bengkulu</option>
                                    </select>
                                    <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm">Lihat</button>
                                </div>
                            </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
                            </div>
                            <div class="col-md-6">
                                <!-- Button Input Data Bayar -->
                                <div align="right">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Catat Laporan BBM Keluar</button> <br> <br>
                                </div>

                                <!-- Form Modal  -->
                                <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"> Form Laporan BBM Keluar </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <!-- Form Input Data -->
                                            <div class="modal-body" align="left">
                                                <?php echo "<form action='../proses/proses_bbm_keluar?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasix=$lokasi' enctype='multipart/form-data' method='POST'>";  ?>

                                                <div class="row">
                                                    <div class="col-md-4">

                                                        <label>Tanggal</label>
                                                        <div class="col-sm-10">
                                                            <input type="date" name="tanggal" required="">
                                                        </div>

                                                    </div>
                                                    <div class="col-md-4">

                                                        <label>Lokasi</label>
                                                        <select name="lokasi" class="form-control">
                                                            <?php $dataSelect = $data['lokasi']; ?>
                                                            <option <?php echo ($dataSelect == 'Palembang') ? "selected" : "" ?>>Palembang</option>
                                                            <option <?php echo ($dataSelect == 'Lampung') ? "selected" : "" ?>>Lampung</option>
                                                            <option <?php echo ($dataSelect == 'Baturaja') ? "selected" : "" ?>>Baturaja</option>
                                                            <option <?php echo ($dataSelect == 'Bengkulu') ? "selected" : "" ?>>Bengkulu</option>
                                                        </select>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Nama Barang</label>
                                                        <select name="nama_barang" class="form-control">
                                                            <option>Kempu 1</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <br>

                                                <div class="row">
                                                    <?php

                                                    if ($lokasi == 'Palembang') { ?>
                                                        <div class="col-md-6">
                                                            <label>AMT</label>
                                                            <select id="amt" name="amt" class="form-control ">
                                                                <?php
                                                                include 'koneksi.php';
                                                                $result = mysqli_query($koneksi, "SELECT * FROM driver WHERE alamat = 'Palembang'");

                                                                while ($data2 = mysqli_fetch_array($result)) {
                                                                    $nama_driver = $data2['nama_driver'];


                                                                    echo "<option> $nama_driver </option> ";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>MT</label>
                                                            <select id="mt" name="mt" class="form-control">
                                                                <?php
                                                                include 'koneksi.php';
                                                                $result = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE wilayah_operasi = 'Palembang'");

                                                                while ($data2 = mysqli_fetch_array($result)) {
                                                                    $no_polisi = $data2['no_polisi'];


                                                                    echo "<option> $no_polisi </option> ";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    <?php } else if ($lokasi == 'Lampung') { ?>
                                                        <div class="col-md-6">
                                                            <label>AMT</label>
                                                            <select id="amt" name="amt" class="form-control ">
                                                                <?php
                                                                include 'koneksi.php';
                                                                $result = mysqli_query($koneksi, "SELECT * FROM driver WHERE alamat = 'Lampung'");

                                                                while ($data2 = mysqli_fetch_array($result)) {
                                                                    $nama_driver = $data2['nama_driver'];


                                                                    echo "<option> $nama_driver </option> ";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>MT</label>
                                                            <select id="mt" name="mt" class="form-control">
                                                                <?php
                                                                include 'koneksi.php';
                                                                $result = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE wilayah_operasi = 'Lampung'");

                                                                while ($data2 = mysqli_fetch_array($result)) {
                                                                    $no_polisi = $data2['no_polisi'];


                                                                    echo "<option> $no_polisi </option> ";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    <?php } else if ($lokasi == 'Baturaja') { ?>
                                                        <div class="col-md-6">
                                                            <label>AMT</label>
                                                            <select id="amt" name="amt" class="form-control ">
                                                                <?php
                                                                include 'koneksi.php';
                                                                $result = mysqli_query($koneksi, "SELECT * FROM driver WHERE alamat = 'Baturaja'");

                                                                while ($data2 = mysqli_fetch_array($result)) {
                                                                    $nama_driver = $data2['nama_driver'];


                                                                    echo "<option> $nama_driver </option> ";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>MT</label>
                                                            <select id="mt" name="mt" class="form-control">
                                                                <?php
                                                                include 'koneksi.php';
                                                                $result = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE wilayah_operasi = 'Baturaja'");

                                                                while ($data2 = mysqli_fetch_array($result)) {
                                                                    $no_polisi = $data2['no_polisi'];


                                                                    echo "<option> $no_polisi </option> ";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    <?php } else if ($lokasi == 'Bengkulu') { ?>
                                                        <div class="col-md-6">
                                                            <label>AMT</label>
                                                            <select id="amt" name="amt" class="form-control ">
                                                                <?php
                                                                include 'koneksi.php';
                                                                $result = mysqli_query($koneksi_stre, "SELECT * FROM driver WHERE alamat = 'Bengkulu'");

                                                                while ($data2 = mysqli_fetch_array($result)) {
                                                                    $nama_driver = $data2['nama_driver'];


                                                                    echo "<option> $nama_driver </option> ";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>MT</label>
                                                            <select id="mt" name="mt" class="form-control">
                                                                <?php
                                                                include 'koneksi.php';
                                                                $result = mysqli_query($koneksi_stre, "SELECT * FROM kendaraan WHERE wilayah_operasi = 'Bengkulu'");

                                                                while ($data2 = mysqli_fetch_array($result)) {
                                                                    $no_polisi = $data2['no_polisi'];


                                                                    echo "<option> $no_polisi </option> ";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    <?php }

                                                    ?>

                                                </div>
                                                <br>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Keterangan</label>
                                                        <select name="keterangan" class="form-control">
                                                            <option>Pertashop</option>
                                                            <option>Uji Flowmet</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>BBM Keluar</label>
                                                        <input class="form-control form-control-sm" type="float" name="bbm_keluar" required="">
                                                    </div>
                                                </div>

                                                <br>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary"> Catat</button>
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
                        <table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Lokasi</th>
                                    <th>Nama Barang</th>
                                    <th>AMT</th>
                                    <th>MT</th>
                                    <th>Keterangan</th>
                                    <th>BBM Keluar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
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
                                    $lokasi = $data['lokasi'];
                                    $nama_barang = $data['nama_barang'];
                                    $amt = $data['amt'];
                                    $mt = $data['mt'];
                                    $keterangan = $data['keterangan'];
                                    $bbm_keluar = $data['bbm_keluar'];
                                    $urut = $urut + 1;

                                    echo "<tr>
                                    <td style='font-size: 14px'>$urut</td>
                                    <td style='font-size: 14px'>$tanggal</td>
                                    <td style='font-size: 14px'>$lokasi</td>
                                    <td style='font-size: 14px'>$nama_barang</td>
                                    <td style='font-size: 14px'>$amt</td>
                                    <td style='font-size: 14px'>$mt</td>
                                    <td style='font-size: 14px'>$keterangan</td>
                                    <td style='font-size: 14px'>$bbm_keluar</td>
                                    "; ?>
                                    <?php echo "<td style='font-size: 12px'>"; ?>
                                    <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_laporan']; ?>">Edit</button>

                                    <!-- Form EDIT DATA -->

                                    <div class="modal fade" id="formedit<?php echo $data['no_laporan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Laporan BBM Keluar</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                        <span aria-hidden="true"> &times; </span>
                                                    </button>
                                                </div>

                                                <!-- Form Edit Data -->
                                                <div class="modal-body">
                                                    <form action="../proses/edit_bbm_keluar" enctype="multipart/form-data" method="POST">

                                                        <input type="hidden" name="no_laporan" value="<?php echo $no_laporan; ?>">
                                                        <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                        <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                        <input type="hidden" name="lokasix" value="<?php echo $lokasi; ?>">

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>Tanggal</label>

                                                                <input class="form-control" type="date" name="tanggal" value="<?php echo $tanggal; ?>">
                                                            </div>
                                                            <div class="col-md-4">

                                                                <label>Lokasi</label>
                                                                <select name="lokasi" class="form-control">
                                                                    <?php $dataSelect = $data['lokasi']; ?>
                                                                    <option <?php echo ($dataSelect == 'Palembang') ? "selected" : "" ?>>Palembang</option>
                                                                    <option <?php echo ($dataSelect == 'Lampung') ? "selected" : "" ?>>Lampung</option>
                                                                    <option <?php echo ($dataSelect == 'Baturaja') ? "selected" : "" ?>>Baturaja</option>
                                                                    <option <?php echo ($dataSelect == 'Bengkulu') ? "selected" : "" ?>>Bengkulu</option>
                                                                </select>

                                                            </div>
                                                            <div class="col-md-4">

                                                                <label>Nama Barang</label>
                                                                <select name="nama_barang" class="form-control">
                                                                    <?php $dataSelect = $data['nama_barang']; ?>
                                                                    <option <?php echo ($dataSelect == 'Kempu 1') ? "selected" : "" ?>>Kempu 1</option>
                                                                </select>

                                                            </div>
                                                        </div>


                                                        <br>

                                                        <div class="row">
                                                            <?php

                                                            if ($lokasi == 'Palembang') { ?>
                                                                <div class="col-md-6">
                                                                    <label>AMT</label>

                                                                    <select id="amt" name="amt" class="form-control ">
                                                                        <?php
                                                                        $dataSelect = $data['amt'];
                                                                        include 'koneksi.php';
                                                                        $result = mysqli_query($koneksi, "SELECT * FROM driver WHERE alamat = 'Palembang'");

                                                                        while ($data2 = mysqli_fetch_array($result)) {
                                                                            $nama_driver = $data2['nama_driver'];

                                                                            echo "<option" ?> <?php echo ($dataSelect == $nama_driver) ? "selected" : "" ?>> <?php echo $nama_driver; ?> <?php echo "</option>";
                                                                                                                                                                                        }
                                                                                                                                                                                            ?>
                                                                    </select>


                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label>MT</label>
                                                                    <select id="mt" name="mt" class="form-control">
                                                                        <?php
                                                                        $dataSelect = $data['mt'];
                                                                        include 'koneksi.php';
                                                                        $result = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE wilayah_operasi = 'Palembang'");

                                                                        while ($data2 = mysqli_fetch_array($result)) {
                                                                            $no_polisi = $data2['no_polisi'];

                                                                            echo "<option" ?> <?php echo ($dataSelect == $no_polisi) ? "selected" : "" ?>> <?php echo $no_polisi; ?> <?php echo "</option>";
                                                                                                                                                                                    }
                                                                                                                                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            <?php } else if ($lokasi == 'Lampung') { ?>
                                                                <div class="col-md-6">
                                                                    <label>AMT</label>

                                                                    <select id="amt" name="amt" class="form-control ">
                                                                        <?php
                                                                        $dataSelect = $data['amt'];
                                                                        include 'koneksi.php';
                                                                        $result = mysqli_query($koneksi, "SELECT * FROM driver WHERE alamat = 'Lampung'");

                                                                        while ($data2 = mysqli_fetch_array($result)) {
                                                                            $nama_driver = $data2['nama_driver'];

                                                                            echo "<option" ?> <?php echo ($dataSelect == $nama_driver) ? "selected" : "" ?>> <?php echo $nama_driver; ?> <?php echo "</option>";
                                                                                                                                                                                        }
                                                                                                                                                                                            ?>
                                                                    </select>


                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label>MT</label>
                                                                    <select id="mt" name="mt" class="form-control">
                                                                        <?php
                                                                        $dataSelect = $data['mt'];
                                                                        include 'koneksi.php';
                                                                        $result = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE wilayah_operasi = 'Lampung'");

                                                                        while ($data2 = mysqli_fetch_array($result)) {
                                                                            $no_polisi = $data2['no_polisi'];

                                                                            echo "<option" ?> <?php echo ($dataSelect == $no_polisi) ? "selected" : "" ?>> <?php echo $no_polisi; ?> <?php echo "</option>";
                                                                                                                                                                                    }
                                                                                                                                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            <?php } else if ($lokasi == 'Baturaja') { ?>
                                                                <div class="col-md-6">
                                                                    <label>AMT</label>

                                                                    <select id="amt" name="amt" class="form-control ">
                                                                        <?php
                                                                        $dataSelect = $data['amt'];
                                                                        include 'koneksi.php';
                                                                        $result = mysqli_query($koneksi, "SELECT * FROM driver WHERE alamat = 'Baturaja'");

                                                                        while ($data2 = mysqli_fetch_array($result)) {
                                                                            $nama_driver = $data2['nama_driver'];

                                                                            echo "<option" ?> <?php echo ($dataSelect == $nama_driver) ? "selected" : "" ?>> <?php echo $nama_driver; ?> <?php echo "</option>";
                                                                                                                                                                                        }
                                                                                                                                                                                            ?>
                                                                    </select>


                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label>MT</label>
                                                                    <select id="mt" name="mt" class="form-control">
                                                                        <?php
                                                                        $dataSelect = $data['mt'];
                                                                        include 'koneksi.php';
                                                                        $result = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE wilayah_operasi = 'Baturaja'");

                                                                        while ($data2 = mysqli_fetch_array($result)) {
                                                                            $no_polisi = $data2['no_polisi'];

                                                                            echo "<option" ?> <?php echo ($dataSelect == $no_polisi) ? "selected" : "" ?>> <?php echo $no_polisi; ?> <?php echo "</option>";
                                                                                                                                                                                    }
                                                                                                                                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            <?php } else if ($lokasi == 'Bengkulu') { ?>
                                                                <div class="col-md-6">
                                                                    <label>AMT</label>

                                                                    <select id="amt" name="amt" class="form-control ">
                                                                        <?php
                                                                        $dataSelect = $data['amt'];
                                                                        include 'koneksi.php';
                                                                        $result = mysqli_query($koneksi, "SELECT * FROM driver WHERE alamat = 'Bengkulu'");

                                                                        while ($data2 = mysqli_fetch_array($result)) {
                                                                            $nama_driver = $data2['nama_driver'];

                                                                            echo "<option" ?> <?php echo ($dataSelect == $nama_driver) ? "selected" : "" ?>> <?php echo $nama_driver; ?> <?php echo "</option>";
                                                                                                                                                                                        }
                                                                                                                                                                                            ?>
                                                                    </select>


                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label>MT</label>
                                                                    <select id="mt" name="mt" class="form-control">
                                                                        <?php
                                                                        $dataSelect = $data['mt'];
                                                                        include 'koneksi.php';
                                                                        $result = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE wilayah_operasi = 'Bengkulu'");

                                                                        while ($data2 = mysqli_fetch_array($result)) {
                                                                            $no_polisi = $data2['no_polisi'];

                                                                            echo "<option" ?> <?php echo ($dataSelect == $no_polisi) ? "selected" : "" ?>> <?php echo $no_polisi; ?> <?php echo "</option>";
                                                                                                                                                                                    }
                                                                                                                                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            <?php }

                                                            ?>

                                                        </div>

                                                        <br>

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>Keterangan</label>
                                                                <select name="keterangan" class="form-control">
                                                                    <?php $dataSelect = $data['keterangan']; ?>
                                                                    <option <?php echo ($dataSelect == 'Pertashop') ? "selected" : "" ?>>Pertashop</option>
                                                                    <option <?php echo ($dataSelect == 'Uji Flomet') ? "selected" : "" ?>>Uji Flomet</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>BBM Keluar </label>
                                                                <input class="form-control form-control-sm" type="float" name="bbm_keluar" required="" value="<?php echo $bbm_keluar; ?>">
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"> Ubah </button>
                                                            <button type="reset" class="btn btn-danger"> RESET</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Button Hapus -->
                                    <button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_laporan']; ?>" data-toggle='tooltip' title='Hapus Data Dokumen'>Hapus</button>
                                    <div class="modal fade" id="PopUpHapus<?php echo $data['no_laporan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"> <b> Hapus Laporan BBM Keluar</b> </h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                        <span aria-hidden="true"> &times; </span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <form action="../proses/hapus_bbm_keluar" method="POST">
                                                        <input type="hidden" name="no_laporan" value="<?php echo $no_laporan; ?>">
                                                        <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                        <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                        <input type="hidden" name="lokasi" value="<?php echo $lokasi; ?>">
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