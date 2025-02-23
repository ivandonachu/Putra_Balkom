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

if ($jabatan_valid == 'Admin Gudang') {
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


    $table = mysqli_query($koneksi, "SELECT * FROM list_gudang ");


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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsAdminGudang">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3"> <img style="margin-top: 50px; height: 100px; width: 110px; " src="../gambar/Logo PBJ.PNG"></div>
            </a>
            <br>

            <br>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="DsAdminGudang">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 16px;">Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading" style="font-size: 15px; color:white;">
                ADMIN GUDANG
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" 15 aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">Laporan</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Laporan</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VStokHarian">Stok Harian</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VStokKeluarMasuk">Keluar Masuk</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan">Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapOpname">Laporan Opname</a>
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
                    <?php echo "<a href=''><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Laporan Opname Stok Gudang</h5></a>"; ?>

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

                        <?php echo "<form  method='POST' action='VRekapOpname'>" ?>
                        <div>
                            <div align="left" style="margin-left: 20px;">
                                <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1">
                                <span>-</span>
                                <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
                                <select id="tokens" class="selectpicker form-control-sm" name="nama_gudang" data-live-search="true">
                                    <?php
                                    include 'koneksi.php';


                                    $result = mysqli_query($koneksi, "SELECT nama_gudang FROM list_gudang");

                                    while ($data2 = mysqli_fetch_array($result)) {
                                        $nama_gudangx = $data2['nama_gudang'];

                                        if (isset($_POST['nama_gudang'])) { ?>
                                            <?php $dataSelectx = $_POST['nama_gudang'];

                                            echo "<option" ?> <?php echo ($dataSelectx == $nama_gudangx) ? "selected" : "" ?>> <?php echo $nama_gudangx; ?> <?php echo "</option>";
                                                                                                                                                        } else if (!isset($_POST['nama_gudang'])) { ?>
                                            <option value="<?= $data2['nama_gudang']; ?>"><?php echo $data2['nama_gudang']; ?></option> <?php
                                                                                                                                                        }

                                                                                                                                        ?>

                                    <?php
                                    }
                                    ?>
                                </select>
                                <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm">Lihat</button>
                            </div>
                        </div>
                        </form>

                        <div class="col-md-8">
                            <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
                        </div>
                        <br>


                        <?php

                        if ($tanggal_awal == $tanggal_akhir) {

                            while ($data = mysqli_fetch_array($table)) { 

                                $nama_gudang = $data['nama_gudang'];

                                //SMBR
                            $sql_stok_awal_smbr = mysqli_query($koneksi, "SELECT stok_awal FROM laporan_stok_harian WHERE tanggal ='$tanggal_awal' AND nama_gudang = '$nama_gudang' and jenis_semen = 'SMBR' ORDER BY no_laporan ASC LIMIT 1");
                            $data_stok_awal_smbr = mysqli_fetch_array($sql_stok_awal_smbr);

                            if (isset($data_stok_awal_smbr['stok_awal'])) {
                                $laporan_stok_awal_smbr = $data_stok_awal_smbr['stok_awal'];
                            } else {
                                $laporan_stok_awal_smbr = 0;
                            }

                            $sql_stok_akhir_smbr = mysqli_query($koneksi, "SELECT stok_akhir FROM laporan_stok_harian WHERE tanggal ='$tanggal_awal' AND nama_gudang = '$nama_gudang' and jenis_semen = 'SMBR' ORDER BY no_laporan DESC LIMIT 1");
                            $data_stok_akhir_smbr = mysqli_fetch_array($sql_stok_akhir_smbr);

                            if (isset($data_stok_akhir_smbr['stok_akhir'])) {
                                $laporan_stok_akhir_smbr = $data_stok_akhir_smbr['stok_akhir'];
                            } else {
                                $laporan_stok_akhir_smbr = 0;
                            }

                            $sql_stok_masuk_smbr = mysqli_query($koneksi, "SELECT SUM(qty_masuk) as total_qty_masuk FROM laporan_stok_masuk WHERE tanggal ='$tanggal_awal' AND nama_gudang = '$nama_gudang' and jenis_semen = 'SMBR'");
                            $data_stok_masuk_smbr = mysqli_fetch_array($sql_stok_masuk_smbr);

                            if (isset($data_stok_masuk_smbr['total_qty_masuk'])) {
                                $laporan_total_qty_masuk_smbr = $data_stok_masuk_smbr['total_qty_masuk'];
                            } else {
                                $laporan_total_qty_masuk_smbr = 0;
                            }

                            $sql_stok_keluar_smbr = mysqli_query($koneksi, "SELECT SUM(qty) as total_qty_keluar FROM laporan_stok_keluar WHERE tanggal ='$tanggal_awal' AND nama_gudang = '$nama_gudang' and jenis_semen = 'SMBR'");
                            $data_stok_keluar_smbr = mysqli_fetch_array($sql_stok_keluar_smbr);

                            if (isset($data_stok_keluar_smbr['total_qty_keluar'])) {
                                $laporan_total_qty_keluar_smbr = $data_stok_keluar_smbr['total_qty_keluar'];
                            } else {
                                $laporan_total_qty_keluar_smbr = 0;
                            }

                            //MDK
                            $sql_stok_awal_mdk = mysqli_query($koneksi, "SELECT stok_awal FROM laporan_stok_harian WHERE tanggal ='$tanggal_awal' AND nama_gudang = '$nama_gudang' and jenis_semen = 'Merdeka' ORDER BY no_laporan ASC LIMIT 1");
                            $data_stok_awal_mdk = mysqli_fetch_array($sql_stok_awal_mdk);

                            if (isset($data_stok_awal_mdk['stok_awal'])) {
                                $laporan_stok_awal_mdk = $data_stok_awal_mdk['stok_awal'];
                            } else {
                                $laporan_stok_awal_mdk = 0;
                            }

                            $sql_stok_akhir_mdk = mysqli_query($koneksi, "SELECT stok_akhir FROM laporan_stok_harian WHERE tanggal ='$tanggal_awal' AND nama_gudang = '$nama_gudang' and jenis_semen = 'Merdeka' ORDER BY no_laporan DESC LIMIT 1");
                            $data_stok_akhir_mdk = mysqli_fetch_array($sql_stok_akhir_mdk);

                            if (isset($data_stok_akhir_mdk['stok_akhir'])) {
                                $laporan_stok_akhir_mdk = $data_stok_akhir_mdk['stok_akhir'];
                            } else {
                                $laporan_stok_akhir_mdk = 0;
                            }

                            $sql_stok_masuk_mdk = mysqli_query($koneksi, "SELECT SUM(qty_masuk) as total_qty_masuk FROM laporan_stok_masuk WHERE tanggal ='$tanggal_awal' AND nama_gudang = '$nama_gudang' and jenis_semen = 'Merdeka'");
                            $data_stok_masuk_mdk = mysqli_fetch_array($sql_stok_masuk_mdk);

                            if (isset($data_stok_masuk_mdk['total_qty_masuk'])) {
                                $laporan_total_qty_masuk_mdk = $data_stok_masuk_mdk['total_qty_masuk'];
                            } else {
                                $laporan_total_qty_masuk_mdk = 0;
                            }

                            $sql_stok_keluar_mdk = mysqli_query($koneksi, "SELECT SUM(qty) as total_qty_keluar FROM laporan_stok_keluar WHERE tanggal ='$tanggal_awal' AND nama_gudang = '$nama_gudang' and jenis_semen = 'Merdeka'");
                            $data_stok_keluar_mdk = mysqli_fetch_array($sql_stok_keluar_mdk);

                            if (isset($data_stok_keluar_mdk['total_qty_keluar'])) {
                                $laporan_total_qty_keluar_mdk = $data_stok_keluar_mdk['total_qty_keluar'];
                            } else {
                                $laporan_total_qty_keluar_mdk = 0;
                            }

                            //Dynamix
                            $sql_stok_awal_dynamix = mysqli_query($koneksi, "SELECT stok_awal FROM laporan_stok_harian WHERE tanggal ='$tanggal_awal' AND nama_gudang = '$nama_gudang' and jenis_semen = 'Dynamix' ORDER BY no_laporan ASC LIMIT 1");
                            $data_stok_awal_dynamix = mysqli_fetch_array($sql_stok_awal_dynamix);

                            if (isset($data_stok_awal_dynamix['stok_awal'])) {
                                $laporan_stok_awal_dynamix = $data_stok_awal_dynamix['stok_awal'];
                            } else {
                                $laporan_stok_awal_dynamix = 0;
                            }

                            $sql_stok_akhir_dynamix = mysqli_query($koneksi, "SELECT stok_akhir FROM laporan_stok_harian WHERE tanggal ='$tanggal_awal' AND nama_gudang = '$nama_gudang' and jenis_semen = 'Dynamix' ORDER BY no_laporan DESC LIMIT 1");
                            $data_stok_akhir_dynamix = mysqli_fetch_array($sql_stok_akhir_dynamix);

                            if (isset($data_stok_akhir_dynamix['stok_akhir'])) {
                                $laporan_stok_akhir_dynamix = $data_stok_akhir_dynamix['stok_akhir'];
                            } else {
                                $laporan_stok_akhir_dynamix = 0;
                            }

                            $sql_stok_masuk_dynamix = mysqli_query($koneksi, "SELECT SUM(qty_masuk) as total_qty_masuk FROM laporan_stok_masuk WHERE tanggal ='$tanggal_awal' AND nama_gudang = '$nama_gudang' and jenis_semen = 'Dynamix'");
                            $data_stok_masuk_dynamix = mysqli_fetch_array($sql_stok_masuk_dynamix);

                            if (isset($data_stok_masuk_dynamix['total_qty_masuk'])) {
                                $laporan_total_qty_masuk_dynamix = $data_stok_masuk_dynamix['total_qty_masuk'];
                            } else {
                                $laporan_total_qty_masuk_dynamix = 0;
                            }

                            $sql_stok_keluar_dynamix = mysqli_query($koneksi, "SELECT SUM(qty) as total_qty_keluar FROM laporan_stok_keluar WHERE tanggal ='$tanggal_awal' AND nama_gudang = '$nama_gudang' and jenis_semen = 'Dynamix'");
                            $data_stok_keluar_dynamix = mysqli_fetch_array($sql_stok_keluar_dynamix);

                            if (isset($data_stok_keluar_dynamix['total_qty_keluar'])) {
                                $laporan_total_qty_keluar_dynamix = $data_stok_keluar_dynamix['total_qty_keluar'];
                            } else {
                                $laporan_total_qty_keluar_dynamix = 0;
                            } ?>

                        <br>
                        <hr>
                        <br>
                        <!-- Kotak pemasukan pengeluaran -->
                        <?php if ($tanggal_awal == $tanggal_akhir) { ?>
                            <h5 align="center" style='font-size: clamp(12px, 1vw, 18px); color: black;'>REKAP OPNAME STOK <?= $nama_gudang ?> <?= $tanggal_awal ?> </h5>

                        <?php } else { ?>

                            <h5 align="center" style='font-size: clamp(12px, 1vw, 18px); color: black;'>REKAP OPNAME STOK <?= $nama_gudang ?> <?= $tanggal_awal ?> - <?= $tanggal_akhir ?></h5>
                        <?php  }
                        ?>

                        <!-- Tabel -->
                        <table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                            <thead>
                                <tr>
                                    <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Nama Barang</th>
                                    <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>STOK AWAL</th>
                                    <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>TOTAL STOK MASUK</th>
                                    <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>TOTAL STOK KELUAR</th>
                                    <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>STOK AKHIR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> Semen Baturaja</td>
                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_stok_awal_smbr; ?> </td>
                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_total_qty_masuk_smbr; ?> </td>
                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_total_qty_keluar_smbr; ?> </td>
                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_stok_akhir_smbr; ?> </td>
                                </tr>
                                <tr>
                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> Semen Merdeka</td>
                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_stok_awal_mdk; ?> </td>
                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_total_qty_masuk_mdk; ?> </td>
                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_total_qty_keluar_mdk; ?> </td>
                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_stok_akhir_mdk; ?> </td>
                                </tr>
                                <tr>
                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> Semen Dynamix</td>
                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_stok_awal_dynamix; ?> </td>
                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_total_qty_masuk_dynamix; ?> </td>
                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_total_qty_keluar_dynamix; ?> </td>
                                    <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_stok_akhir_dynamix; ?> </td>
                                </tr>
                            </tbody>
                        </table>

                        <br>
                        <br>
                        <br>

                        <?php

                            }
                           
                            
                        } else {

                            while ($data = mysqli_fetch_array($table)) { 

                                $nama_gudang = $data['nama_gudang'];

                                  //SMBR
                            $sql_stok_awal_smbr = mysqli_query($koneksi, "SELECT stok_awal FROM laporan_stok_harian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_gudang = '$nama_gudang' and jenis_semen = 'SMBR' ORDER BY no_laporan ASC LIMIT 1");
                            $data_stok_awal_smbr = mysqli_fetch_array($sql_stok_awal_smbr);

                            if (isset($data_stok_awal_smbr['stok_awal'])) {
                                $laporan_stok_awal_smbr = $data_stok_awal_smbr['stok_awal'];
                            } else {
                                $laporan_stok_awal_smbr = 0;
                            }

                            $sql_stok_akhir_smbr = mysqli_query($koneksi, "SELECT stok_akhir FROM laporan_stok_harian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_gudang = '$nama_gudang' and jenis_semen = 'SMBR' ORDER BY no_laporan DESC LIMIT 1");
                            $data_stok_akhir_smbr = mysqli_fetch_array($sql_stok_akhir_smbr);

                            if (isset($data_stok_akhir_smbr['stok_akhir'])) {
                                $laporan_stok_akhir_smbr = $data_stok_akhir_smbr['stok_akhir'];
                            } else {
                                $laporan_stok_akhir_smbr = 0;
                            }

                            $sql_stok_masuk_smbr = mysqli_query($koneksi, "SELECT SUM(qty_masuk) as total_qty_masuk FROM laporan_stok_masuk WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_gudang = '$nama_gudang' and jenis_semen = 'SMBR'");
                            $data_stok_masuk_smbr = mysqli_fetch_array($sql_stok_masuk_smbr);

                            if (isset($data_stok_masuk_smbr['total_qty_masuk'])) {
                                $laporan_total_qty_masuk_smbr = $data_stok_masuk_smbr['total_qty_masuk'];
                            } else {
                                $laporan_total_qty_masuk_smbr = 0;
                            }

                            $sql_stok_keluar_smbr = mysqli_query($koneksi, "SELECT SUM(qty) as total_qty_keluar FROM laporan_stok_keluar WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_gudang = '$nama_gudang' and jenis_semen = 'SMBR'");
                            $data_stok_keluar_smbr = mysqli_fetch_array($sql_stok_keluar_smbr);

                            if (isset($data_stok_keluar_smbr['total_qty_keluar'])) {
                                $laporan_total_qty_keluar_smbr = $data_stok_keluar_smbr['total_qty_keluar'];
                            } else {
                                $laporan_total_qty_keluar_smbr = 0;
                            }

                            //MDK
                            $sql_stok_awal_mdk = mysqli_query($koneksi, "SELECT stok_awal FROM laporan_stok_harian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_gudang = '$nama_gudang' and jenis_semen = 'Merdeka' ORDER BY no_laporan ASC LIMIT 1");
                            $data_stok_awal_mdk = mysqli_fetch_array($sql_stok_awal_mdk);

                            if (isset($data_stok_awal_mdk['stok_awal'])) {
                                $laporan_stok_awal_mdk = $data_stok_awal_mdk['stok_awal'];
                            } else {
                                $laporan_stok_awal_mdk = 0;
                            }

                            $sql_stok_akhir_mdk = mysqli_query($koneksi, "SELECT stok_akhir FROM laporan_stok_harian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_gudang = '$nama_gudang' and jenis_semen = 'Merdeka' ORDER BY no_laporan DESC LIMIT 1");
                            $data_stok_akhir_mdk = mysqli_fetch_array($sql_stok_akhir_mdk);

                            if (isset($data_stok_akhir_mdk['stok_akhir'])) {
                                $laporan_stok_akhir_mdk = $data_stok_akhir_mdk['stok_akhir'];
                            } else {
                                $laporan_stok_akhir_mdk = 0;
                            }

                            $sql_stok_masuk_mdk = mysqli_query($koneksi, "SELECT SUM(qty_masuk) as total_qty_masuk FROM laporan_stok_masuk WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_gudang = '$nama_gudang' and jenis_semen = 'Merdeka'");
                            $data_stok_masuk_mdk = mysqli_fetch_array($sql_stok_masuk_mdk);

                            if (isset($data_stok_masuk_mdk['total_qty_masuk'])) {
                                $laporan_total_qty_masuk_mdk = $data_stok_masuk_mdk['total_qty_masuk'];
                            } else {
                                $laporan_total_qty_masuk_mdk = 0;
                            }

                            $sql_stok_keluar_mdk = mysqli_query($koneksi, "SELECT SUM(qty) as total_qty_keluar FROM laporan_stok_keluar WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_gudang = '$nama_gudang' and jenis_semen = 'Merdeka'");
                            $data_stok_keluar_mdk = mysqli_fetch_array($sql_stok_keluar_mdk);

                            if (isset($data_stok_keluar_mdk['total_qty_keluar'])) {
                                $laporan_total_qty_keluar_mdk = $data_stok_keluar_mdk['total_qty_keluar'];
                            } else {
                                $laporan_total_qty_keluar_mdk = 0;
                            }

                            //Dynamix
                            $sql_stok_awal_dynamix = mysqli_query($koneksi, "SELECT stok_awal FROM laporan_stok_harian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_gudang = '$nama_gudang' and jenis_semen = 'Dynamix' ORDER BY no_laporan ASC LIMIT 1");
                            $data_stok_awal_dynamix = mysqli_fetch_array($sql_stok_awal_dynamix);

                            if (isset($data_stok_awal_dynamix['stok_awal'])) {
                                $laporan_stok_awal_dynamix = $data_stok_awal_dynamix['stok_awal'];
                            } else {
                                $laporan_stok_awal_dynamix = 0;
                            }

                            $sql_stok_akhir_dynamix = mysqli_query($koneksi, "SELECT stok_akhir FROM laporan_stok_harian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_gudang = '$nama_gudang' and jenis_semen = 'Dynamix' ORDER BY no_laporan DESC LIMIT 1");
                            $data_stok_akhir_dynamix = mysqli_fetch_array($sql_stok_akhir_dynamix);

                            if (isset($data_stok_akhir_dynamix['stok_akhir'])) {
                                $laporan_stok_akhir_dynamix = $data_stok_akhir_dynamix['stok_akhir'];
                            } else {
                                $laporan_stok_akhir_dynamix = 0;
                            }

                            $sql_stok_masuk_dynamix = mysqli_query($koneksi, "SELECT SUM(qty_masuk) as total_qty_masuk FROM laporan_stok_masuk WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_gudang = '$nama_gudang' and jenis_semen = 'Dynamix'");
                            $data_stok_masuk_dynamix = mysqli_fetch_array($sql_stok_masuk_dynamix);

                            if (isset($data_stok_masuk_dynamix['total_qty_masuk'])) {
                                $laporan_total_qty_masuk_dynamix = $data_stok_masuk_dynamix['total_qty_masuk'];
                            } else {
                                $laporan_total_qty_masuk_dynamix = 0;
                            }

                            $sql_stok_keluar_dynamix = mysqli_query($koneksi, "SELECT SUM(qty) as total_qty_keluar FROM laporan_stok_keluar WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_gudang = '$nama_gudang' and jenis_semen = 'Dynamix'");
                            $data_stok_keluar_dynamix = mysqli_fetch_array($sql_stok_keluar_dynamix);

                            if (isset($data_stok_keluar_dynamix['total_qty_keluar'])) {
                                $laporan_total_qty_keluar_dynamix = $data_stok_keluar_dynamix['total_qty_keluar'];
                            } else {
                                $laporan_total_qty_keluar_dynamix = 0;
                            }?>

                            <br>
                            <hr>
                            <br>
                            <!-- Kotak pemasukan pengeluaran -->
                            <?php if ($tanggal_awal == $tanggal_akhir) { ?>
                                <h5 align="center" style='font-size: clamp(12px, 1vw, 18px); color: black;'>REKAP OPNAME STOK <?= $nama_gudang ?> <?= $tanggal_awal ?> </h5>
    
                            <?php } else { ?>
    
                                <h5 align="center" style='font-size: clamp(12px, 1vw, 18px); color: black;'>REKAP OPNAME STOK <?= $nama_gudang ?> <?= $tanggal_awal ?> - <?= $tanggal_akhir ?></h5>
                            <?php  }
                            ?>
    
                            <!-- Tabel -->
                            <table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                                <thead>
                                    <tr>
                                        <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>Nama Barang</th>
                                        <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>STOK AWAL</th>
                                        <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>TOTAL STOK MASUK</th>
                                        <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>TOTAL STOK KELUAR</th>
                                        <th style='font-size: clamp(12px, 1vw, 12px); color: black;'>STOK AKHIR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> Semen Baturaja</td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_stok_awal_smbr; ?> </td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_total_qty_masuk_smbr; ?> </td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_total_qty_keluar_smbr; ?> </td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_stok_akhir_smbr; ?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> Semen Merdeka</td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_stok_awal_mdk; ?> </td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_total_qty_masuk_mdk; ?> </td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_total_qty_keluar_mdk; ?> </td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_stok_akhir_mdk; ?> </td>
                                    </tr>
                                    <tr>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> Semen Dynamix</td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_stok_awal_dynamix; ?> </td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_total_qty_masuk_dynamix; ?> </td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_total_qty_keluar_dynamix; ?> </td>
                                        <td style='font-size: clamp(12px, 1vw, 12px); color: black;'> <?= $laporan_stok_akhir_dynamix; ?> </td>
                                    </tr>
                                </tbody>
                            </table>
    
                            <br>
                            <br>
                            <br>
    
                            <?php
    

                            }

                          
                        }

                        ?>

                      


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

    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: false,
                buttons: ['excel']
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
        });
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#example3').DataTable({
                lengthChange: false,
                buttons: ['excel']
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
        });
    </script>


</body>

</html>