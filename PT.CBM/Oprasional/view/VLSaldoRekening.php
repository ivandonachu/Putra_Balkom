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
if ($jabatan_valid == 'Kepala Oprasional') {
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
    $table = mysqli_query($koneksi, "SELECT * FROM laporan_saldo_rekening WHERE tanggal = '$tanggal_awal' ");
} else {
    $table = mysqli_query($koneksi, "SELECT * FROM laporan_saldo_rekening  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ");
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

    <title>Laporan Saldo Rekening</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKepalaOprasional">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3"> <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png"></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="DsKepalaOprasional">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 16px;">Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading" style="font-size: 15px; color:white;">
                Menu Kepala Oprasional
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" 15 aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">Oprasional</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Oprasional</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VSaldoBaru">Penggunaan Saldo</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VUangPBJ">Uang PBJ</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPBRKasir">Pengeluaran PBR/MES </a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapUang">Rekap Uang Masuk</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapTF">Rekap TF ke Bank</a>

                    </div>
                </div>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwox" 15 aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">Pengeluaran</span>
                </a>
                <div id="collapseTwox" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Pengeluaran</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranCBM">Pengeluaran CBM</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranMES">Pengeluaran MES</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPBR">Pengeluaran PBR</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranKebun">Pengeluaran Lengkiti</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranSeberuk">Pengeluaran Seberuk</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKPesanAntar">Keuangan Pesan Antar</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLSaldoRekening">Laporan Saldo Rekening</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoxx" 15 aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">Mocash</span>
                </a>
                <div id="collapseTwoxx" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Mocash</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VMocashCBM">Mocash CBM</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMocashMES">Mocash MES</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMocashPBR">Mocash PBR</a>
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
                    <?php echo "<a href='VPembelianBBM'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Laporan Saldo Rekening</h5></a>"; ?>
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
                        <?php echo "<form  method='POST' action='VSaldoRekening' style='margin-bottom: 15px;'>" ?>
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
                        </div>
                        <div class="row">
                            <div class="col-md-10">

                            </div>
                            <div class="col-md-2">
                                <!-- Button Pindah Baja -->
                                <div align="right">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Catat Laporan Rekening </button> <br> <br>
                                </div>
                                <!-- Form Modal  -->
                                <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"> Form Laporan Rekening </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <!-- Form Input Data -->
                                            <div class="modal-body" align="left">
                                                <?php echo "<form action='../proses/proses_saldo_rekening?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>
                                                <input type="hidden" name="rekening_1" value="BRI Nyoman Serli">
                                                <input type="hidden" name="rekening_2" value="BRI Cahaya Bumi Musi">
                                                <input type="hidden" name="rekening_3" value="BRI Mulia Elpiji Sejahtera">
                                                <input type="hidden" name="rekening_4" value="BRI Putra Balkom Raya">
                                                <input type="hidden" name="rekening_5" value="BRI Risa Septiana">
                                                <input type="hidden" name="rekening_6" value="BRI Rianto">
                                                <input type="hidden" name="rekening_7" value="BRI Koder">
                                                <input type="hidden" name="rekening_8" value="BRI Baharuddin">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Tanggal</label>
                                                        <input class="form-control form-control-sm" t type="date" name="tanggal" required="">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Rekening 1</label>
                                                        <input class="form-control form-control-sm" type="text" name="rekening_1" required="" value ='BRI Nyoman Serli' disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Jumlah Saldo 1</label>
                                                        <input class="form-control form-control-sm" type="number" name="jumlah_saldo_1">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Rekening 2</label>
                                                        <input class="form-control form-control-sm" type="text" name="rekening_2" required="" value ='BRI Cahaya Bumi Musi' disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Jumlah Saldo 2</label>
                                                        <input class="form-control form-control-sm" type="number" name="jumlah_saldo_2">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Rekening 3</label>
                                                        <input class="form-control form-control-sm" type="text" name="rekening_3" required="" value ='BRI Mulia Elpiji Sejahtera' disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Jumlah Saldo 3</label>
                                                        <input class="form-control form-control-sm" type="number" name="jumlah_saldo_3">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Rekening 4</label>
                                                        <input class="form-control form-control-sm" type="text" name="rekening_4" required="" value ='BRI Putra Balkom Raya' disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Jumlah Saldo 4</label>
                                                        <input class="form-control form-control-sm" type="number" name="jumlah_saldo_4">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Rekening 5</label>
                                                        <input class="form-control form-control-sm" type="text" name="rekening_5" required="" value ='BRI Risa Septiana' disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Jumlah Saldo 5</label>
                                                        <input class="form-control form-control-sm" type="number" name="jumlah_saldo_5">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Rekening 6</label>
                                                        <input class="form-control form-control-sm" type="text" name="rekening_6" required="" value ='BRI Rianto' disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Jumlah Saldo 6</label>
                                                        <input class="form-control form-control-sm" type="number" name="jumlah_saldo_6">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Rekening 7</label>
                                                        <input class="form-control form-control-sm" type="text" name="rekening_7" required="" value ='BRI Koder' disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Jumlah Saldo 7</label>
                                                        <input class="form-control form-control-sm" type="number" name="jumlah_saldo_7">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Rekening 8</label>
                                                        <input class="form-control form-control-sm" type="text" name="rekening_8" required="" value ='BRI Baharuddin' disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Jumlah Saldo 8</label>
                                                        <input class="form-control form-control-sm" type="number" name="jumlah_saldo_8">
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">CATAT</button>
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
                                        <th>Rekening</th>
                                        <th>Jumlah Saldo</th>
                                        <th>Aksi</th>
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
                                        $rekening = $data['rekening'];
                                        $jumlah_saldo = $data['jumlah_saldo'];
                                        
                                        $urut = $urut + 1;
                                        echo "<tr>
                                        <td style='font-size: 14px'>$urut</td>
                                        <td style='font-size: 14px'>$tanggal</td>
                                        <td style='font-size: 14px'>$rekening</td>
                                        <td style='font-size: 14px'>"; ?> <?= formatuang($jumlah_saldo) ?> <?php echo "</td>
                                        "; ?>
                                                                                <?php echo "<td style='font-size: 12px'>"; ?>
                                            <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_laporan']; ?>">Edit</button>

                                            <!-- Form EDIT DATA -->

                                            <div class="modal fade" id="formedit<?php echo $data['no_laporan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">Form Edit Laporan Rekenig </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true"> &times; </span>
                                                            </button>
                                                        </div>


                                                        <!-- Form Edit Data -->
                                                        <div class="modal-body">
                                                            <form action="../proses/edit_saldo_rekening" enctype="multipart/form-data" method="POST">
                                                                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                                <input type="hidden" name="no_laporan" value="<?php echo $no_laporan; ?>">
                                                                <input type="hidden" name="rekening" value="<?php echo $rekening; ?>">
                                                                
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label>Tanggal</label>
                                                                            <input class="form-control form-control-sm" type="date" name="tanggal" value="<?php echo $tanggal; ?>" required="">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Rekening</label>
                                                                        <input class="form-control form-control-sm" type="text" name="rekening" value="<?php echo $rekening; ?>" required="" disabled>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Jumlah Saldo</label>
                                                                        <input class="form-control form-control-sm" type="number"  name="jumlah_saldo" value="<?php echo $jumlah_saldo; ?>" required="">
                                                                    </div>
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


                                            <button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_laporan']; ?>" data-toggle='tooltip' title='Hapus Transaksi'></button>
                                            <div class="modal fade" id="PopUpHapus<?php echo $data['no_laporan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"> <b> Hapus </b> </h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true"> &times; </span>
                                                            </button>
                                                        </div>



                                                        <div class="modal-body">
                                                            <form action="../proses/hapus_saldo_rekening" method="POST">
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
                    </div>
                    <br>
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
    <script>
        function sum() {
            var banyak_barang = document.getElementById('qty').value;
            var harga = document.getElementById('harga').value;
            var result = parseFloat(banyak_barang) * parseFloat(harga);
            if (!isNaN(result)) {
                document.getElementById('jumlah').value = result;
            }
        }
    </script>

</body>

</html>