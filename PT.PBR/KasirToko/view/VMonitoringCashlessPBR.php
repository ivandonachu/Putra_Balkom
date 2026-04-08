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
if ($jabatan_valid == 'Kasir') {
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

    $table = mysqli_query($koneksi, "SELECT * FROM monitoring_cashless_pbr WHERE tanggal = '$tanggal_awal'");
    $table2 = mysqli_query($koneksi, "SELECT nama_pangkalan,  SUM(jumlah) AS total_jumlah,  SUM(briva) AS total_briva,  SUM(transaksis_transfer) AS total_transfer  FROM monitoring_cashless_pbr  WHERE tanggal = '$tanggal_awal' GROUP BY nama_pangkalan");
} else {

    $table = mysqli_query($koneksi, "SELECT * FROM monitoring_cashless_pbr WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $table2 = mysqli_query($koneksi, "SELECT nama_pangkalan,  SUM(jumlah) AS total_jumlah,  SUM(briva) AS jumlah_briva,  SUM(transaksi_transfer) AS jumlah_transfer FROM monitoring_cashless_pbr  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY nama_pangkalan");
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

    <title>Monitoring Cashless PBR</title>

    <!-- Custom fonts for this template-->
    <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/sbadmin/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Custom styles for this template-->
    <link href="/sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Link Tabel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-select/dist/css/bootstrap-select.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav  sidebar sidebar-dark accordion" style=" background-color: #004445" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKasirToko.php">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3"> <img style="margin-top: 50px; height: 110px; width: 120px; " src="../gambar/Logo CBM.PNG"></div>
            </a>
            <br> <br>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="DsKasirToko.php">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 16px;">Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading" style="font-size: 15px; color:white;">
                Menu Kasir Toko
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    15 aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">Transaksi</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Transaksi</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenjualan1">Penjualan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaran1">Pengeluaran</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VKeuanganPBR">Keuangan PBR</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VKeuanganMES">Keuangan MES</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPembelian1">Pembelian</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan1">Laporan Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenggunaanSaldo">Laporan Saldo</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRiwayatDeposit1">Riwayat Deposit</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRiwayatBonPembelian1">Riwayat Bon </a>
                        <a class="collapse-item" style="font-size: 15px;" href="VBonKaryawan">Bon Karyawan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Gaji Karyawan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitDriverMES">Laporan Rit MES</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitDriverPBR">Laporan Rit PBR</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMonitoringCashlessMES">Monitor Cashless MES</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMonitoringCashlessPBR">Monitor Cashless PBR</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-dolly-flatbed" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">Pencatatan Inventory</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Inventory</h6>
                        <a class="collapse-item" href="VInventoryPerusahaan" style="font-size: 15px;">Inventory Perusahaan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRiwayatPeminjaman1">Riwayat Peminjaman</a>
                        <a class="collapse-item" href="VKonfirmasiRetur" style="font-size: 15px;">Konfirmasi Retur</a>
                        <a class="collapse-item" href="VKeberangkatan" style="font-size: 15px;">Keberangkatan</a>
                        <a class="collapse-item" href="VReturPangkalan" style="font-size: 15px;">Retur Pangkalan</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilitiesx"
                    aria-expanded="true" aria-controls="collapseUtilitiesx">
                    <i class="fas fa-clipboard-list" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">Administrasi</span>
                </a>
                <div id="collapseUtilitiesx" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Administrasi</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VPangkalan">Pangkalan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VKaryawan">Karyawan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VDriver">Driver</a>
                        <a class="collapse-item" href="VRute" style="font-size: 15px;">Rute</a>
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
                    <?php echo "<a href=''><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Monitoring Cashless PBR</h5></a>"; ?>
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline  small" style="color:white;"><?php echo "$nama"; ?></span>
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

                <!-- Top content -->
                <div>


                    <!-- Name Page -->
                    <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">


                        <?php echo "<form  method='POST' action='VMonitoringCashlessPBR' style='margin-bottom: 15px;'>" ?>
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
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i>Catat</button> <br> <br>
                                </div>
                                <!-- Form Modal  -->
                                <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"> Form Monitoring Cashless </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <!-- Form Input Data -->
                                            <div class="modal-body" align="left">
                                                <?php echo "<form action='../proses/proses_monitoring_cashless_pbr?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Tanggal</label>
                                                        <input class="form-control form-control-sm" type="date" name="tanggal" required="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Nama Pangkalan</label>
                                                        <select id="tokens" class="selectpicker form-control" name="nama_pangkalan" data-live-search="true">
                                                            <?php
                                                            include 'koneksi.php';
                                                            $result = mysqli_query($koneksi, "SELECT * FROM pangkalan");

                                                            while ($data2 = mysqli_fetch_array($result)) {
                                                                $data_pangakalan = $data2['sub_penyalur'];


                                                                echo "<option> $data_pangakalan </option> ";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>QTY</label>
                                                        <input class="form-control form-control-sm" type="number" id="qty" name="qty" required="">
                                                    </div>
                                                </div>

                                                <br>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Harga Satuan</label>
                                                        <input class="form-control form-control-sm" type="number" id="harga_satuan" name="harga_satuan" required="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Briva</label>
                                                        <input class="form-control form-control-sm" type="number" id="briva" name="briva" required="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Transfer</label>
                                                        <input class="form-control form-control-sm" type="number" id="transaksi_transfer" name="transaksi_transfer" required="" value="0">
                                                    </div>
                                                </div>

                                                <br>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Status Valid</label>
                                                        <select class="form-control form-control-sm" name="status_valid" class="form-control ">
                                                            <option>Valid</option>
                                                            <option>Tidak Valid</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Referensi</label>
                                                        <input class="form-control form-control-sm" type="text" id="referensi" name="referensi" required="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Verified/Not Verified</label>
                                                        <select class="form-control form-control-sm" name="status_verified" class="form-control ">
                                                            <option>Verified</option>
                                                            <option>Not Verified</option>
                                                        </select>
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
                                        <th>Nama Pangkalan</th>
                                        <th>QTY</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Briva</th>
                                        <th>Transfer</th>
                                        <th>Status Valid</th>
                                        <th>Referensi</th>
                                        <th>Verified/Not Verified</th>
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

                                    ?>

                                    <?php while ($data = mysqli_fetch_array($table)) {
                                        $no_transaksi = $data['no_transaksi'];
                                        $tanggal = $data['tanggal'];
                                        $nama_pangkalan = $data['nama_pangkalan'];
                                        $qty = $data['qty'];
                                        $harga_satuan = $data['harga_satuan'];
                                        $jumlah = $data['jumlah'];
                                        $briva = $data['briva'];
                                        $transaksi_transfer = $data['transaksi_transfer'];
                                        $status_valid = $data['status_valid'];
                                        $referensi = $data['referensi'];
                                        $status_verified = $data['status_valid'];
                                        $keterangan = $data['keterangan'];
                                        $file_bukti = $data['file_bukti'];
                                        $urut  = $urut + 1;

                                        echo "<tr>
                                        <td style='font-size: 14px'>$urut</td>
                                        <td style='font-size: 14px'>$tanggal</td>
                                        <td style='font-size: 14px'>$nama_pangkalan</td>
                                        <td style='font-size: 14px'>$qty</td>
                                        <td style='font-size: 14px'>$harga_satuan</td>
                                        <td style='font-size: 14px'>$jumlah</td>
                                        <td style='font-size: 14px'>$briva</td>
                                        <td style='font-size: 14px'>$transaksi_transfer</td>
                                        <td style='font-size: 14px'>$status_valid</td>
                                        <td style='font-size: 14px'>$referensi</td>
                                        <td style='font-size: 14px'>$status_verified</td>
                                        <td style='font-size: 14px'>$keterangan</td>
                                        <td style='font-size: 14px'>"; ?> <a download="/PT.PBR/KasirToko/file_toko/<?= $file_bukti ?>" href="/PT.PBR/KasirToko/file_toko/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
                                        <td style='font-size: 12px'>"; ?>

                                            <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_transaksi']; ?>">Edit</button>

                                            <!-- Form EDIT DATA -->

                                            <div class="modal fade bd-example-modal-lg" id="formedit<?php echo $data['no_transaksi']; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">Form Edit Monitoring Cashless</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true"> &times; </span>
                                                            </button>
                                                        </div>


                                                        <!-- Form Edit Data -->
                                                        <div class="modal-body">
                                                            <form action="../proses/edit_monitoring_cashless_pbr" enctype="multipart/form-data" method="POST">
                                                                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                                <input type="hidden" name="no_transaksi" value="<?php echo $no_transaksi; ?>">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label>Tanggal</label>
                                                                        <input class="form-control form-control-sm" type="date" name="tanggal" required="" value="<?php echo $tanggal; ?>">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div>
                                                                            <label>Nama Pangkalan</label>
                                                                        </div>

                                                                        <select id="tokens" class="selectpicker form-control" name="nama_pangkalan" data-live-search="true">
                                                                            <?php
                                                                            include 'koneksi.php';
                                                                            $dataSelect = $data['nama_pangkalan'];
                                                                            $result = mysqli_query($koneksi, "SELECT * FROM pangkalan");

                                                                            while ($data2 = mysqli_fetch_array($result)) {
                                                                                $nama_pangkalan = $data2['sub_penyalur'];


                                                                                echo "<option" ?> <?php echo ($dataSelect == $nama_pangkalan) ? "selected" : "" ?>> <?php echo $nama_pangkalan; ?> <?php echo "</option>";
                                                                                                                                                                                                }
                                                                                                                                                                                                    ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>QTY</label>
                                                                        <input class="form-control form-control-sm" type="number" value="<?php echo $qty; ?>" name="qty" required="">
                                                                    </div>
                                                                </div>

                                                                <br>

                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label>Harga Satuan</label>
                                                                        <input class="form-control form-control-sm" type="number" value="<?php echo $harga_satuan; ?>" name="harga_satuan" required="">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Briva</label>
                                                                        <input class="form-control form-control-sm" type="number" value="<?php echo $briva; ?>" name="briva" required="">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Transfer</label>
                                                                        <input class="form-control form-control-sm" type="number" value="<?php echo $transaksi_transfer; ?>" name="transaksi_transfer" required="">
                                                                    </div>
                                                                </div>

                                                                <br>

                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label>Status Valid</label>
                                                                        <select class="form-control form-control-sm" name="status_valid" class="form-control">
                                                                            <?php $dataSelect = $data['status_valid']; ?>
                                                                            <option <?php echo ($dataSelect == 'Valid') ? "selected" : "" ?>>Valid</option>
                                                                            <option <?php echo ($dataSelect == 'Tidak Valid') ? "selected" : "" ?>>Tidak Valid</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Referensi</label>
                                                                        <input class="form-control form-control-sm" type="number" value="<?php echo $referensi; ?>" name="referensi" required="">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Verified/Not Verified</label>
                                                                        <select class="form-control form-control-sm" name="status_verified" class="form-control">
                                                                            <?php $dataSelect = $data['status_verified']; ?>
                                                                            <option <?php echo ($dataSelect == 'Verified') ? "selected" : "" ?>>Verified</option>
                                                                            <option <?php echo ($dataSelect == 'Not Verified') ? "selected" : "" ?>>Not Verified</option>
                                                                        </select>
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

                                            <button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_transaksi']; ?>" data-toggle='tooltip' title='Hapus Pengeluaran'></button>


                                            <div class="modal fade bd-example-modal-lg" id="PopUpHapus<?php echo $data['no_transaksi']; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"> <b> Hapus Pengeluaran </b> </h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true"> &times; </span>
                                                            </button>
                                                        </div>



                                                        <div class="modal-body">
                                                            <form action="../proses/hapus_monitoring_cashless_pbr" method="POST">
                                                                <input type="hidden" name="no_transaksi" value="<?php echo $no_transaksi; ?>">
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

                        <h5 align="center">Rincian Mocash</h5>
                        <!-- Tabel -->
                        <table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                            <thead>
                                <tr>
                                    <th>Pangkalan</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_transaksi = 0;
                                $total_transfer = 0;
                                $total_briva = 0;
                                ?>
                                <?php while ($data = mysqli_fetch_array($table2)) {
                                    $nama_pangkalan = $data['nama_pangkalan'];
                                    $jumlah = $data['total_jumlah'];
                                    $jumlah_briva = $data['jumlah_briva'];
                                    $jumlah_transfer = $data['jumlah_transfer'];

                                    $total_transaksi = $total_transaksi + $jumlah;
                                    $total_transfer = $total_transfer + $jumlah_transfer;
                                    $total_briva = $total_briva + $jumlah_briva;

                                    echo "<tr>

                                <td style='font-size: 14px' >$nama_pangkalan</td>
                                <td style='font-size: 14px'>" ?> <?= formatuang($jumlah); ?> <?php echo "</td>
                
                                </tr>";
                                                                                            }
                                                                                                ?> <tr>
                                    <td style='font-size: 14px; '><strong>Total Briva</strong></td>
                                    <td style='font-size: 14px'> <strong> <?= formatuang($total_briva); ?></strong> </td>
                                </tr>
                                <tr>
                                    <td style='font-size: 14px; '><strong>Total Transfer</strong></td>
                                    <td style='font-size: 14px'> <strong> <?= formatuang($total_transfer); ?></strong> </td>
                                </tr>
                                <tr>
                                    <td style='font-size: 14px; '><strong>Sisa Saldo</strong></td>
                                    <td style='font-size: 14px'> <strong> <?= formatuang($total_transaksi); ?></strong> </td>
                                </tr>




                                </tr>
                            </tbody>
                        </table>


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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
    <script src="/sbadmin/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/sbadmin/js/sb-admin-2.min.js"></script>
    <script src="/bootstrap-select/dist/js/bootstrap-select.js"></script>
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
    <script>
        function createOptions(number) {
            var options = [],
                _options;

            for (var i = 0; i < number; i++) {
                var option = '<option value="' + i + '">Option ' + i + '</option>';
                options.push(option);
            }

            _options = options.join('');

            $('#number')[0].innerHTML = _options;
            $('#number-multiple')[0].innerHTML = _options;

            $('#number2')[0].innerHTML = _options;
            $('#number2-multiple')[0].innerHTML = _options;
        }

        var mySelect = $('#first-disabled2');

        createOptions(4000);

        $('#special').on('click', function() {
            mySelect.find('option:selected').prop('disabled', true);
            mySelect.selectpicker('refresh');
        });

        $('#special2').on('click', function() {
            mySelect.find('option:disabled').prop('disabled', false);
            mySelect.selectpicker('refresh');
        });

        $('#basic2').selectpicker({
            liveSearch: true,
            maxOptions: 1
        });
    </script>
</body>

</html>