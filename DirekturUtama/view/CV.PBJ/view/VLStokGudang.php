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
} elseif (isset($_POST['tanggal1'])) {
    $tanggal_awal = $_POST['tanggal1'];
    $tanggal_akhir = $_POST['tanggal2'];
} else {
    $tanggal_awal = date('Y-m-1');
    $tanggal_akhir = date('Y-m-31');
}


if ($tanggal_awal == $tanggal_akhir) {
    // Gudang Mesuji
    $table_mesuji = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Mesuji' ORDER BY no_laporan DESC LIMIT 1 ");
    // Gudang Unit 1
    $table_unit_1 = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Unit 1' ORDER BY no_laporan DESC LIMIT 1 ");
    // Gudang Bu Jipa
    $table_bu_jipa = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Bu Jipa' ORDER BY no_laporan DESC LIMIT 1 ");
    // Gudang Rawajitu
    $table_rawajitu = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Rawajitu' ORDER BY no_laporan DESC LIMIT 1 ");
    // Gudang Way Kanan
    $table_way_kanan = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Way Kanan' ORDER BY no_laporan DESC LIMIT 1 ");
    // Gudang MES
    $table_mes = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG MES' ORDER BY no_laporan DESC LIMIT 1 ");
    // Gudang Rantau Panjang
    $table_rantau_panjang = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Rantau Panjang' ORDER BY no_laporan DESC LIMIT 1 ");
    // Gudang Simpang Sender
    $table_simpang_sender = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Simpang Sender' ORDER BY no_laporan DESC LIMIT 1 ");
    // Gudang Ruko M2
    $table_ruko_m2 = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Ruko M2' ORDER BY no_laporan DESC LIMIT 1 ");
    // Gudang Kuto Sari
    $table_kuto_sari = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG Kuto Sari' ORDER BY no_laporan DESC LIMIT 1  ");
    // Gudang BK 11
    $table_bk_11 = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal ='$tanggal_awal' AND kode_gudang = 'KG BK 11' ORDER BY no_laporan DESC LIMIT 1  ");




} else {

    // Gudang Mesuji
    $table_mesuji = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_gudang = 'KG Mesuji' ORDER BY no_laporan DESC LIMIT 1 ");
    // Gudang Unit 1
    $table_unit_1 = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_gudang = 'KG Unit 1' ORDER BY no_laporan DESC LIMIT 1 ");
    // Gudang Bu Jipa
    $table_bu_jipa = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_gudang = 'KG Bu Jipa' ORDER BY no_laporan DESC LIMIT 1  ");
    // Gudang Rawajitu
    $table_rawajitu = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_gudang = 'KG Rawajitu' ORDER BY no_laporan DESC LIMIT 1  ");
    // Gudang Way Kanan
    $table_way_kanan = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_gudang = 'KG Way Kanan' ORDER BY no_laporan DESC LIMIT 1  ");
    // Gudang MES
    $table_mes = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_gudang = 'KG MES' ORDER BY no_laporan DESC LIMIT 1 ");
    // Gudang Rantau Panjang
    $table_rantau_panjang = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_gudang = 'KG Rantau Panjang' ORDER BY no_laporan DESC LIMIT 1  ");
    // Gudang Simpang Sender
    $table_simpang_sender = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_gudang = 'KG Simpang Sender' ORDER BY no_laporan DESC LIMIT 1  ");
    // Gudang Ruko M2
    $table_ruko_m2 = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_gudang = 'KG Ruko M2' ORDER BY no_laporan DESC LIMIT 1  ");
    // Gudang Kuto Sari
    $table_kuto_sari = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_gudang = 'KG Kuto Sari' ORDER BY no_laporan DESC LIMIT 1  ");
    // Gudang BK 11
    $table_bk_11 = mysqli_query($koneksipbj, "SELECT * FROM laporan_stok_harian_gudang  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND kode_gudang = 'KG BK 11' ORDER BY no_laporan DESC LIMIT 1  ");
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="/bootstrap-select/dist/css/bootstrap-select.css">

    <!-- Link datepicker -->

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

          <!-- Sidebar -->
          <ul class="navbar-nav  sidebar sidebar-dark accordion" style=" background-color: #004445" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsCVPBJ">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3"> <img style="margin-top: 50px; height: 100px; width: 110px; " src="../gambar/Logo PBJ.png"></div>
</a>
<br>

<br>
<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="DsCVPBJ">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;">Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">
<!-- Heading -->
<div class="sidebar-heading" style="font-size: 15px; color:white;">
    Menu CV.PBJ (Semen)
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
            <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.CBM/view/DsPTCBM">PT.CBM</a>
            <a class="collapse-item" style="font-size: 15px;" href="DsPBJ">CV.PBJ</a>
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
        <span style="font-size: 15px; color:white;">Report Etty</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Report</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Laporan Penjualan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Laporan Pengiriman</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKeuangan">Laporan Keuangan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluran">Laporan Pengeluaran</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranWorkshop">Pengeluaran Workshop</a>
        </div>
    </div>
</li>
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3" 15 aria-expanded="true" aria-controls="collapseTwo3">
        <i class="fa fa-clipboard-list" style="font-size: 15px; color:white;"></i>
        <span style="font-size: 15px; color:white;">Report Made Dani</span>
    </a>
    <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Report</h6>

            <a class="collapse-item" style="font-size: 15px;" href="VPenjualanL">Laporan Penjualan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPenebusanL">Laporan Penebusan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VSewaHiBlow">Sewa Hiblow</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanL">Laporan Pengiriman</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKeuanganL">Laporan Keuangan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranL">Laporan Pengeluaran</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTonasePembelian">Tonase Pembelian</a>

        </div>
    </div>
</li>
 <!-- Nav Item - Pages Collapse Menu -->
 <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo4xx" 15 aria-expanded="true" aria-controls="collapseTwo4xx">
                    <i class="fa fa-clipboard-list" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">Report Gudang</span>
                </a>
                <div id="collapseTwo4xx" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Report</h6>

                        <a class="collapse-item" style="font-size: 15px;" href="VStokMasuk">Laporan Stok Masuk</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VStokKeluar">Laporan Stok Keluar</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VStokHarian">Laporan Stok Harian</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan">Laporan Keuangan</a>

                    </div>
                </div>
            </li>
<?php if ($nama == 'Nyoman Edy Susanto') {
    echo "
<!-- Nav Item - Pages Collapse Menu -->
<li class='nav-item'>
    <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapseTwo4' 15 aria-expanded='true' aria-controls='collapseTwo4'>
        <i class='fa fa-clipboard-list' style='font-size: 15px; color:white;'></i>
        <span style='font-size: 15px; color:white;'>Report Laba Rugi</span>
    </a>
    <div id='collapseTwo4' class='collapse' aria-labelledby='headingTwo' data-parent='#accordionSidebar'>
        <div class='bg-white py-2 collapse-inner rounded'>
            <h6 class='collapse-header' style='font-size: 15px;'>Report</h6>
            <a class='collapse-item' style='font-size: 15px;' href='VLR2LBaru'>Laba Rugi</a>
            <a class='collapse-item' style='font-size: 15px;' href='VLR2L'>Laba Rugi Back Up</a>
            <a class='collapse-item' style='font-size: 15px;' href='VLRKendaraan'>Laba Rugi Kendaraan</a>
            <a class='collapse-item' style='font-size: 15px;' href='VRekapanTagihan'>Rekap Tagihan</a>
            <a class='collapse-item' style='font-size: 15px;' href='VRekapanHarga'>Rekapan Harga</a>
            <a class='collapse-item' style='font-size: 15px;' href='VRekapSparepart'>Rekap Sparepart</a>
            <a class='collapse-item' style='font-size: 15px;' href='VRekapPiutang'>Rekap Piutang</a>
            <a class='collapse-item' style='font-size: 15px;' href='VPenjualanRegion'>Penjualan Per Region</a>
        </div>
    </div>
</li>";
} ?>



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
                    <?php echo "<a href=''><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Laporan Stok Gudang </h5></a>"; ?>

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

                        <?php echo "<form  method='POST' action='VLStokGudang'>" ?>
                        <div>
                            <div align="left" style="margin-left: 20px;">
                                <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1">
                                <span>-</span>
                                <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
                                <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm">Lihat</button>
                            </div>
                        </div>
                        </form>

                        <div class="col-md-8">
                            <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
                        </div>
                        <br>

                      
                        <br>
                        <hr>
                        <br>

                        <h4 align='center'> Laporan Stok Gudang Mesuji</h4>
                        <!-- Tabel -->
                        <div style="overflow-x: auto" align='center'>
                        <table id="example1" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jenis Semen</th>
                                        <th>Stok Masuk/zak</th>
                                        <th>Stok Keluar/zak</th>
                                        <th>Total Stok/zak</th>
                                   
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
                                    <?php while ($data = mysqli_fetch_array($table_mesuji)) {
                                        $no_laporan = $data['no_laporan'];
                                        $tanggal = $data['tanggal'];
                                        $kode_gudang = $data['kode_gudang'];
                                        $jenis_semen = $data['jenis_semen'];
                                        $stok_masuk = $data['stok_masuk'];
                                        $stok_keluar = $data['stok_keluar'];
                                        $total_stok = $data['total_stok'];
                                        $urut = $urut + 1;

                                        echo "<tr>
                                            <td style='font-size: 14px' align = 'center'>$urut</td>
                                            <td style='font-size: 14px' align = 'center'>$tanggal</td>
                                            <td style='font-size: 14px' align = 'center'>$jenis_semen</td>
                                            <td style='font-size: 14px' align = 'center'>$stok_masuk</td>
                                            <td style='font-size: 14px' align = 'center'>$stok_keluar</td>
                                            <td style='font-size: 14px' align = 'center'>$total_stok</td>
                                        </tr>";
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                        <br>
                        <hr>
                        <br>

                        <h4 align='center'> Laporan Stok Gudang Unit 1</h4>
                        <!-- Tabel -->
                        <div style="overflow-x: auto" align='center'>
                        <table id="example2" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jenis Semen</th>
                                        <th>Stok Masuk/zak</th>
                                        <th>Stok Keluar/zak</th>
                                        <th>Total Stok/zak</th>
                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $urut = 0;
                                    ?>
                                    <?php while ($data = mysqli_fetch_array($table_unit_1)) {
                                        $no_laporan = $data['no_laporan'];
                                        $tanggal = $data['tanggal'];
                                        $kode_gudang = $data['kode_gudang'];
                                        $jenis_semen = $data['jenis_semen'];
                                        $stok_masuk = $data['stok_masuk'];
                                        $stok_keluar = $data['stok_keluar'];
                                        $total_stok = $data['total_stok'];
                                        $urut = $urut + 1;

                                        echo "<tr>
                                            <td style='font-size: 14px' align = 'center'>$urut</td>
                                            <td style='font-size: 14px' align = 'center'>$tanggal</td>
                                            <td style='font-size: 14px' align = 'center'>$jenis_semen</td>
                                            <td style='font-size: 14px' align = 'center'>$stok_masuk</td>
                                            <td style='font-size: 14px' align = 'center'>$stok_keluar</td>
                                            <td style='font-size: 14px' align = 'center'>$total_stok</td>
                                        </tr>";
                                    }
                                    ?>

                                </tbody>
                            </table>
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
        var table = $('#example1').DataTable({
          lengthChange: true,
          buttons: ['copy', 'excel', 'csv', 'pdf', 'colvis']
        });

        table.buttons().container()
          .appendTo('#example_wrapper .col-md-6:eq(0)');
      });
    </script>
        <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: true,
                buttons: [ 'excel']
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
        });
    </script>



</body>

</html>