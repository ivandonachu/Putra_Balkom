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


else{  header("Location: logout.php");
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

if ($tanggal_awal == $tanggal_akhir) {

  //penjualan
  $table = mysqli_query($koneksicbm, "SELECT nama, SUM(qty) AS alokasi FROM riwayat_penjualan  WHERE tanggal = '$tanggal_awal' AND penyaluran = 'Pangkalan' AND kode_baja = 'L03K01' AND nama != 'Khsus' AND nama != 'Eceran Gudang' AND nama != 'Karyawan' GRoUP BY nama ");
  $table2 = mysqli_query($koneksicbm, "SELECT nama, SUM(qty) AS alokasi FROM riwayat_penjualan  WHERE tanggal = '$tanggal_awal' AND penyaluran = 'Pangkalan' AND kode_baja = 'L12K01' GRoUP BY nama ");
  $table3 = mysqli_query($koneksicbm, "SELECT nama, SUM(qty) AS alokasi FROM riwayat_penjualan  WHERE tanggal = '$tanggal_awal' AND penyaluran = 'Pangkalan' AND kode_baja = 'B05K01' GRoUP BY nama ");
  $table4 = mysqli_query($koneksicbm, "SELECT nama, SUM(qty) AS alokasi FROM riwayat_penjualan  WHERE tanggal = '$tanggal_awal' AND penyaluran = 'Pangkalan' AND kode_baja = 'B12K01' GRoUP BY nama ");


  $table5 = mysqli_query($koneksicbm, "SELECT SUM(qty) AS alokasi FROM riwayat_penjualan  WHERE tanggal = '$tanggal_awal' AND penyaluran = 'Pangkalan' AND kode_baja = 'L03K01'  ");
  $data_alokasi03 = mysqli_fetch_array($table5);
  $total_alokasi03 = $data_alokasi03['alokasi'];
  if (!isset($data_alokasi03['alokasi'])) {
    $total_alokasi03 = 0;
  }
  $table6 = mysqli_query($koneksicbm, "SELECT SUM(qty) AS alokasi FROM riwayat_penjualan  WHERE tanggal = '$tanggal_awal' AND penyaluran = 'Pangkalan' AND kode_baja = 'L12K01' ");
  $data_alokasi12 = mysqli_fetch_array($table6);
  $total_alokasi12 = $data_alokasi12['alokasi'];
  if (!isset($data_alokasi12['alokasi'])) {
    $total_alokasi12 = 0;
  }
  $table7 = mysqli_query($koneksicbm, "SELECT SUM(qty) AS alokasi FROM riwayat_penjualan  WHERE tanggal = '$tanggal_awal' AND penyaluran = 'Pangkalan' AND kode_baja = 'B05K01' ");
  $data_alokasi05 = mysqli_fetch_array($table7);
  $total_alokasi05 = $data_alokasi05['alokasi'];
  if (!isset($data_alokasi05['alokasi'])) {
    $total_alokasi05 = 0;
  }
  $table8 = mysqli_query($koneksicbm, "SELECT SUM(qty) AS alokasi FROM riwayat_penjualan  WHERE tanggal = '$tanggal_awal' AND penyaluran = 'Pangkalan' AND kode_baja = 'B12K01' ");
  $data_alokasib12 = mysqli_fetch_array($table8);
  $total_alokasib12 = $data_alokasib12['alokasi'];
  if (!isset($data_alokasib12['alokasi'])) {
    $total_alokasib12 = 0;
  }

  //pembelian

  $table9 = mysqli_query($koneksicbm, "SELECT SUM(qty) AS alokasi FROM riwayat_pembelian  WHERE tanggal = '$tanggal_awal' AND referensi = 'CBM' AND kode_baja = 'L03K01' ");
  $data_alokasi03beli = mysqli_fetch_array($table9);
  $total_alokasi03beli = $data_alokasi03beli['alokasi'];
  if (!isset($data_alokasi03beli['alokasi'])) {
    $total_alokasi03beli = 0;
  }
  $table10 = mysqli_query($koneksicbm, "SELECT SUM(qty) AS alokasi FROM riwayat_pembelian  WHERE tanggal = '$tanggal_awal' AND referensi = 'CBM' AND kode_baja = 'L12K01' ");
  $data_alokasi12beli = mysqli_fetch_array($table10);
  $total_alokasi12beli = $data_alokasi12beli['alokasi'];
  if (!isset($data_alokasi12beli['alokasi'])) {
    $total_alokasi12beli = 0;
  }
  $table11 = mysqli_query($koneksicbm, "SELECT SUM(qty) AS alokasi FROM riwayat_pembelian  WHERE tanggal = '$tanggal_awal' AND referensi = 'CBM' AND kode_baja = 'B05K01' ");
  $data_alokasi05beli = mysqli_fetch_array($table11);
  $total_alokasi05beli = $data_alokasi05beli['alokasi'];
  if (!isset($data_alokasi05beli['alokasi'])) {
    $total_alokasi05beli = 0;
  }
  $table12 = mysqli_query($koneksicbm, "SELECT SUM(qty) AS alokasi FROM riwayat_pembelian  WHERE tanggal = '$tanggal_awal' AND referensi = 'CBM' AND kode_baja = 'B12K01' ");
  $data_alokasib12beli = mysqli_fetch_array($table12);
  $total_alokasib12beli = $data_alokasib12beli['alokasi'];
  if (!isset($data_alokasib12beli['alokasi'])) {
    $total_alokasib12beli = 0;
  }

}

else{
 //penjualan
  $table = mysqli_query($koneksicbm, "SELECT nama, SUM(qty) AS alokasi FROM riwayat_penjualan  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND penyaluran = 'Pangkalan' AND kode_baja = 'L03K01' AND nama != 'Khusus' AND nama != 'Eceran Gudang' AND nama != 'Karyawan' GRoUP BY nama ");
  $table2 = mysqli_query($koneksicbm, "SELECT nama, SUM(qty) AS alokasi FROM riwayat_penjualan  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND penyaluran = 'Pangkalan' AND kode_baja = 'L12K01' AND nama != 'Khusus' AND nama != 'Eceran Gudang' AND nama != 'Karyawan' GRoUP BY nama ");
  $table3 = mysqli_query($koneksicbm, "SELECT nama, SUM(qty) AS alokasi FROM riwayat_penjualan  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND penyaluran = 'Pangkalan' AND kode_baja = 'B05K01' AND nama != 'Khusus' AND nama != 'Eceran Gudang' AND nama != 'Karyawan'GRoUP BY nama ");
  $table4 = mysqli_query($koneksicbm, "SELECT nama, SUM(qty) AS alokasi FROM riwayat_penjualan  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND penyaluran = 'Pangkalan' AND kode_baja = 'B12K01' AND nama != 'Khusus' AND nama != 'Eceran Gudang' AND nama != 'Karyawan' GRoUP BY nama ");


  $table5 = mysqli_query($koneksicbm, "SELECT SUM(qty) AS alokasi FROM riwayat_penjualan  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND penyaluran = 'Pangkalan' AND kode_baja = 'L03K01'AND nama != 'Khusus' AND nama != 'Eceran Gudang' AND nama != 'Karyawan' ");
  $data_alokasi03 = mysqli_fetch_array($table5);
  $total_alokasi03 = $data_alokasi03['alokasi'];
  if (!isset($data_alokasi03['alokasi'])) {
    $total_alokasi03 = 0;
  }
  $table6 = mysqli_query($koneksicbm, "SELECT SUM(qty) AS alokasi FROM riwayat_penjualan  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND penyaluran = 'Pangkalan' AND kode_baja = 'L12K01' AND nama != 'Khusus' AND nama != 'Eceran Gudang' AND nama != 'Karyawan'");
  $data_alokasi12 = mysqli_fetch_array($table6);
  $total_alokasi12 = $data_alokasi12['alokasi'];
  if (!isset($data_alokasi12['alokasi'])) {
    $total_alokasi12 = 0;
  }
  $table7 = mysqli_query($koneksicbm, "SELECT SUM(qty) AS alokasi FROM riwayat_penjualan  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND penyaluran = 'Pangkalan' AND kode_baja = 'B05K01' AND nama != 'Khusus' AND nama != 'Eceran Gudang' AND nama != 'Karyawan'");
  $data_alokasi05 = mysqli_fetch_array($table7);
  $total_alokasi05 = $data_alokasi05['alokasi'];
  if (!isset($data_alokasi05['alokasi'])) {
    $total_alokasi05 = 0;
  }
  $table8 = mysqli_query($koneksicbm, "SELECT SUM(qty) AS alokasi FROM riwayat_penjualan  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND penyaluran = 'Pangkalan' AND kode_baja = 'B12K01' AND nama != 'Khusus' AND nama != 'Eceran Gudang' AND nama != 'Karyawan'");
  $data_alokasib12 = mysqli_fetch_array($table8);
  $total_alokasib12 = $data_alokasib12['alokasi'];
  if (!isset($data_alokasib12['alokasi'])) {
    $total_alokasib12 = 0;
  }

  //pembelian

  $table9 = mysqli_query($koneksicbm, "SELECT SUM(qty) AS alokasi FROM riwayat_pembelian  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'CBM' AND kode_baja = 'L03K01' ");
  $data_alokasi03beli = mysqli_fetch_array($table9);
  $total_alokasi03beli = $data_alokasi03beli['alokasi'];
  if (!isset($data_alokasi03beli['alokasi'])) {
    $total_alokasi03beli = 0;
  }
  $table10 = mysqli_query($koneksicbm, "SELECT SUM(qty) AS alokasi FROM riwayat_pembelian  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'CBM' AND kode_baja = 'L12K01' ");
  $data_alokasi12beli = mysqli_fetch_array($table10);
  $total_alokasi12beli = $data_alokasi12beli['alokasi'];
  if (!isset($data_alokasi12beli['alokasi'])) {
    $total_alokasi12beli = 0;
  }
  $table11 = mysqli_query($koneksicbm, "SELECT SUM(qty) AS alokasi FROM riwayat_pembelian  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'CBM' AND kode_baja = 'B05K01' ");
  $data_alokasi05beli = mysqli_fetch_array($table11);
  $total_alokasi05beli = $data_alokasi05beli['alokasi'];
  if (!isset($data_alokasi05beli['alokasi'])) {
    $total_alokasi05beli = 0;
  }
  $table12 = mysqli_query($koneksicbm, "SELECT SUM(qty) AS alokasi FROM riwayat_pembelian  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'CBM' AND kode_baja = 'B12K01' ");
  $data_alokasib12beli = mysqli_fetch_array($table12);
  $total_alokasib12beli = $data_alokasib12beli['alokasi'];
  if (!isset($data_alokasib12beli['alokasi'])) {
    $total_alokasib12beli = 0;
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

  <title>Rincian Alokasi SA</title>

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
    <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="gambar/Logo CBM.png" ></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">


  <!-- Nav Item - Dashboard -->
<li class="nav-item active" >
    <a class="nav-link" href="DsPTCBM">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
                <!-- Heading -->
                <div class="sidebar-heading" style="font-size: 15px; color:white;">
                     Menu PT. CBM
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
                        <a class="collapse-item" style="font-size: 15px;" href="DsPTCBM">PT. CBM</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/CV.PBJ/view/DsCVPBJ">CV.PBJ</a>
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
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                  15  aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-clipboard-list" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Laporan Perusahan</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Laporan</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan1">Laporan Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLPenjualan1">Laporan Penjualan</a>
                        
                        <?php if($nama == 'Nyoman Edy Susanto'){
                        echo"<a class='collapse-item' style='font-size: 15px;' href='VLabaRugi'>Laba Rugi</a>";
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
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2"
                  15  aria-expanded="true" aria-controls="collapseTwo2">
                    <i class="fas fa-file-alt" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Daftar SDM</span>
                </a>
                <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">SDM</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VAset">Daftar Aset</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VDokumen">Daftar Dokumen</a>
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
      <?php echo "<a href='VRincianSA'><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Alokasi SA</h5></a>"; ?>
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
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline  small"  style="color:white;"><?php echo "$nama"; ?></span>
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


   <?php  echo "<form  method='POST' action='VRincianSA' style='margin-bottom: 15px;'>" ?>
   <div>
    <div align="left" style="margin-left: 20px;"> 
      <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1"> 
      <span>-</span>
      <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
      <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm" >Lihat</button>
    </div>
  </div>
</form>
<div class="col-md-8">
 <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
</div>
<br>

<!-- Keterangan Penjualan -->
<!-- Penjaulan Isi -->
        <div class="row" style="margin-right: 20px; margin-left: 20px;">
            <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Alokasi Elpiji 3 Kg</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  $total_alokasi03 ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-shipping-fast fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Alokasi Elpiji 12 Kg</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_alokasi12 ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-shipping-fast fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Alokasi Bright Gas 5,5 Kg</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_alokasi05 ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-shipping-fast fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Alokasi Bright Gas 12 Kg</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  $total_alokasib12 ?> </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-shipping-fast fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <br>
                        <br>
                        <!-- Keterangan Penjualan -->
<!-- Penjaulan Isi -->
        <div class="row" style="margin-right: 20px; margin-left: 20px;">
            <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Penebusan SA Elpiji 3 Kg</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  $total_alokasi03beli  ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dolly fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Penebusan SA Elpiji 12 Kg</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_alokasi12beli ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dolly fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Penebusan SA Bright Gas 5,5 Kg</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_alokasi05beli ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dolly fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Penebusan SA Bright Gas 12 Kg</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  $total_alokasib12beli ?> </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dolly fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <br>
                        <br>
                        <!-- Penjaulan Isi -->
        <div class="row" style="margin-right: 20px; margin-left: 20px;">
            <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                STOK Elpiji 3 Kg</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  $total_alokasi03beli - $total_alokasi03 ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dolly fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                               </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dolly fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dolly fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                               </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dolly fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <br>
                        <br>

<div class="row">
  <div class="col-md-6">
    <h5 align="center" >Alokasi LPG 3 KG</h5>
    <!-- Tabel -->    
    <table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
      <thead>
        <tr>
          <th>Nama Pangkalan</th>
          <th>Total Alokasi</th>
          <th></th>

        </tr>
      </thead>
      <tbody>

        <?php while($data = mysqli_fetch_array($table)){
          $nama = $data['nama'];
          $alokasi =$data['alokasi'];
          $baja ='L03K01';
          echo "<tr>
          <td style='font-size: 14px' align = 'center'>$nama</td>
          <td style='font-size: 14px' align = 'center'>$alokasi</td>
          <td  align = 'center'><a href='VRincianAlokasi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&nama=$nama&baja=$baja '>Rincian</a></td>
          </tr>";
        }
        ?>

      </tbody>
    </table>
  </div>
  <div class="col-md-6">

    <h5 align="center" >Alokasi LPG 12 KG</h5>
    <!-- Tabel -->     
    <table id="example2" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
      <thead>
        <tr>
          <th>Nama Pangkalan</th>
          <th>Total Alokasi</th>
          <th></th>

        </tr>
      </thead>
      <tbody>

        <?php while($data = mysqli_fetch_array($table2)){
          $nama = $data['nama'];
          $alokasi =$data['alokasi'];
          $baja ='L12K01';
          echo "<tr>
          <td style='font-size: 14px' align = 'center'>$nama</td>
          <td style='font-size: 14px' align = 'center'>$alokasi</td>
          <td  align = 'center'><a href='VRincianAlokasi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&nama=$nama&baja=$baja '>Rincian</a></td>
          </tr>";
        }
        ?>

      </tbody>
    </table>

  </div>
</div>




<br>
<br>
<div class="row">
  <div class="col-md-6">
   <h5 align="center" >Alokasi Bright Gas 5,5 KG</h5>
   <!-- Tabel -->    
   <table id="example3" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
    <thead>
      <tr>
        <th>Nama Pangkalan</th>
        <th>Total Alokasi</th>
        <th></th>

      </tr>
    </thead>
    <tbody>

      <?php while($data = mysqli_fetch_array($table3)){
        $nama = $data['nama'];
        $alokasi =$data['alokasi'];
        $baja ='B05K01';
        echo "<tr>
        <td style='font-size: 14px' align = 'center'>$nama</td>
        <td style='font-size: 14px' align = 'center'>$alokasi</td>
        <td  align = 'center'><a href='VRincianAlokasi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&nama=$nama&baja=$baja '>Rincian</a></td>
        </tr>";
      }
      ?>

    </tbody>
  </table>

</div>
<div class="col-md-6">

 <h5 align="center" >Alokasi Bright Gas 12 KG</h5>
 <!-- Tabel -->    
 <table id="example4" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>Nama Pangkalan</th>
      <th>Total Alokasi</th>
      <th></th>

    </tr>
  </thead>
  <tbody>

    <?php while($data = mysqli_fetch_array($table4)){
      $nama = $data['nama'];
      $alokasi =$data['alokasi'];
      $baja ='B12K01';
      echo "<tr>
      <td style='font-size: 14px' align = 'center'>$nama</td>
      <td style='font-size: 14px' align = 'center'>$alokasi</td>
      <td  align = 'center'><a href='VRincianAlokasi?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&nama=$nama&baja=$baja '>Rincian</a></td>
      </tr>";
    }
    ?>

  </tbody>
</table>

</div>
</div>

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
    var table = $('#example').DataTable( {
      lengthChange: false,
      buttons: [ ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table2 = $('#example2').DataTable( {
      lengthChange: false,
      buttons: [ 'copy', 'excel', 'csv', 'pdf', 'colvis' ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table2 = $('#example3').DataTable( {
      lengthChange: false,
      buttons: [ 'copy', 'excel', 'csv', 'pdf', 'colvis' ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table2 = $('#example4').DataTable( {
      lengthChange: false,
      buttons: [ 'copy', 'excel', 'csv', 'pdf', 'colvis' ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

</body>

</html>