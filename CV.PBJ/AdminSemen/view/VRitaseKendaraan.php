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
if ($jabatan_valid == 'Admin Semen') {
} else {
    header("Location: logout.php");
    exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];



if (isset($_GET['tanggal1'])) {

 if (isset($_POST['nama_driver'])) {
  $tanggal_awal = $_GET['tanggal1'];
  $tanggal_akhir = $_GET['tanggal2'];
  $nama_driver_cari = $_POST['nama_driver'];
 }
 else{
  $tanggal_awal = $_GET['tanggal1'];
  $tanggal_akhir = $_GET['tanggal2'];
  $nama_driver_cari  = '';
 }

} 

elseif (isset($_POST['tanggal1'])) {
 $tanggal_awal = $_POST['tanggal1'];
 $tanggal_akhir = $_POST['tanggal2'];
 $nama_driver_cari  = '';
} 
else{
  $tanggal_awal = date('Y-m-1');
$tanggal_akhir = date('Y-m-31');
$nama_driver_cari  = '';
}


if ($tanggal_awal == $tanggal_akhir) {

  
}

else{

  $table = mysqli_query($koneksi,"SELECT no_polisi, count(*) AS total_rit FROM  pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' OR  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY no_polisi ");
  //SMBR
  $table2 = mysqli_query($koneksi,"SELECT no_polisi, count(*) AS total_rit FROM  pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB OKU TIMUR' AND plant = '79H7' OR  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB OKU TIMUR' AND plant = '79H7' GROUP BY no_polisi  ");
  $table3 = mysqli_query($koneksi,"SELECT no_polisi, count(*) AS total_rit FROM  pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB OKU SELATAN' AND plant = '79H7' OR  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB OKU SELATAN' AND plant = '79H7' GROUP BY no_polisi  ");
  $table4 = mysqli_query($koneksi,"SELECT no_polisi, count(*) AS total_rit FROM  pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB MESUJI' AND plant = '79H7' OR  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB MESUJI' AND plant = '79H7' GROUP BY no_polisi  ");
  $table5 = mysqli_query($koneksi,"SELECT no_polisi, count(*) AS total_rit FROM  pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB WAY KANAN' AND plant = '79H7' OR  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB WAY KANAN' AND plant = '79H7' GROUP BY no_polisi  ");
  $table6 = mysqli_query($koneksi,"SELECT no_polisi, count(*) AS total_rit FROM  pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB. TULANG BAWANG' AND plant = '79H7' OR  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB. TULANG BAWANG' AND plant = '79H7' GROUP BY no_polisi  ");
  $table8 = mysqli_query($koneksi,"SELECT no_polisi, count(*) AS total_rit FROM  pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB. OGAN KOM ILIR' AND plant = '79H7' OR  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB. OGAN KOM ILIR' AND plant = '79H7' GROUP BY no_polisi  ");
  $table8 = mysqli_query($koneksi,"SELECT no_polisi, count(*) AS total_rit FROM  pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB. OGAN KOM ILIR' AND plant = '79H7' OR  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB. OGAN KOM ILIR' AND plant = '79H7' GROUP BY no_polisi  ");
  $table9 = mysqli_query($koneksi,"SELECT no_polisi, count(*) AS total_rit FROM  pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB. OGAN KOM ULU' AND plant = '79H7' OR  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB.OGAN KOM ULU' AND plant = '79H7' GROUP BY no_polisi  ");
  $table10 = mysqli_query($koneksi,"SELECT no_polisi, count(*) AS total_rit FROM  pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB. PESISIR BARAT' AND plant = '79H7' OR  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB.PESISIR BARAT' AND plant = '79H7' GROUP BY no_polisi  ");
  $table11 = mysqli_query($koneksi,"SELECT no_polisi, count(*) AS total_rit FROM  pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB. LAMPUNG BARAT' AND plant = '79H7' OR  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB.LAMPUNG BARAT' AND plant = '79H7' GROUP BY no_polisi  ");
  $table13 = mysqli_query($koneksi,"SELECT no_polisi, count(*) AS total_rit FROM  pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB. LAMPUNG TIMUR' AND plant = '79H7' OR  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kota = 'KAB.LAMPUNG TIMUR' AND plant = '79H7' GROUP BY no_polisi  ");

  $table7 = mysqli_query($koneksi,"SELECT no_polisi, count(*) AS total_rit FROM  pembelian_kota_bumi WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY no_polisi  ");
  $table12 = mysqli_query($koneksi,"SELECT no_polisi, count(*) AS total_rit FROM  pembelian_lamteng WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY no_polisi  ");


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

  <title>Rit Driver</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKasir">
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
                <a class="nav-link" href="DsAdminSemen">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 16px;">Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading" style="font-size: 15px; color:white;">
                ADMIN SEMEN
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" 15 aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">Kasir</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Kasir</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Penjualan Semen</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPiutang">Piutang Semen</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Pengiriman</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenebusan">Penebusan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaran">Pengeluaran</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan">Laporan Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapDoPenjualanL">Rekap DO Penjualan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapDoPembelian">Rekap DO Pembelian</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPotonganHarga">Potongan Harga</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitDriver">Laporan Rit</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VSewaHiBlow">Uang Sewa Hi Blow</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VFilePBJ">File PBJ</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VStokGudang">Stok Gudang</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapTagihan">Rekap Tagihan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapPiutang">Rekap Piutang</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1" 15 aria-expanded="true" aria-controls="collapseTwo1">
                    <i class="fas fa-truck-moving" style="font-size: 15px; color:white;"></i>
                    <span style="font-size: 15px; color:white;">SDM</span>
                </a>
                <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VKendaraan">Kendaraan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VDriverSemen">List Driver</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VTokoDO">List Toko DO</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VListKota">List Kota</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitaseKendaraan">RIT PBR</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitaseKendaraanTarahan">RIT Tarahan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitaseKendaraanPanjang">RIT Panjang</a>
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
    <?php echo "<a href=''><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Rit Driver</h5></a>"; ?>

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

<!-- Top content -->
<div>   


 <div style="margin-right: 100px; margin-left: 100px;">

  <?php  echo "<form  method='POST' action='VRitaseKendaraan'>" ?>
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

<h5 align="center" >Rincian RIT Driver Global</h5>
<!-- Tabel -->    
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No Polisi</th>
      <th>Rit </th>
    </tr>
  </thead>
  <tbody>
  <?php 

  ?>
    <?php while($data = mysqli_fetch_array($table)){
      $no_polisi = $data['no_polisi'];
      $total_rit =$data['total_rit'];
      $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi' ");
      $data2p = mysqli_fetch_array($table2p);
      if (isset($data2p['status_kendaraan'])) {
          $pemilik = $data2p['status_kendaraan'];
          $kontrak = $data2p['kontrak'];
      } else {
          $pemilik = "";
          $kontrak  = "";
      }
      if ($pemilik == 'Bapak Nyoman Edi' || $pemilik == 'Bapak Rama' || $pemilik == 'GM Balkom'|| $pemilik == 'Pak Tanry'  ) {

      echo "<tr>

    <td style='font-size: 14px' >$no_polisi</td>
    <td style='font-size: 14px' >$total_rit</td>
    


 </tr>";
      }
}

?>
</tbody>
</table>

<br>
<hr>
<br>

<h5 align="center" >Rincian RIT Driver OKU Timur</h5>
<!-- Tabel -->    
<table id="example2" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No Polisi</th>
      <th>Rit </th>
      <th>Total Point </th>
    </tr>
  </thead>
  <tbody>
  <?php 
$total_point = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table2)){
      $no_polisi = $data['no_polisi'];
      $total_rit =$data['total_rit'];
      $total_point = $total_rit * 1;
      $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi' ");
      $data2p = mysqli_fetch_array($table2p);
      if (isset($data2p['status_kendaraan'])) {
          $pemilik = $data2p['status_kendaraan'];
          $kontrak = $data2p['kontrak'];
      } else {
          $pemilik = "";
          $kontrak  = "";
      }
       if ($pemilik == 'Bapak Nyoman Edi' || $pemilik == 'Bapak Rama' || $pemilik == 'GM Balkom'|| $pemilik == 'Pak Tanry'  ) {

      echo "<tr>

    <td style='font-size: 14px' >$no_polisi</td>
    <td style='font-size: 14px' >$total_rit</td>
    <td style='font-size: 14px' >$total_point</td>
    


 </tr>";
      }
}

?>
</tbody>
</table>

<br>
<hr>
<br>

<h5 align="center" >Rincian RIT Driver OKU Selatan</h5>
<!-- Tabel -->    
<table id="example3" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No Polisi</th>
      <th>Rit </th>
      <th>Total Point </th>
    </tr>
  </thead>
  <tbody>
  <?php 
$total_point = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table3)){
      $no_polisi = $data['no_polisi'];
      $total_rit =$data['total_rit'];
      $total_point = $total_rit * 1;
      $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi' ");
      $data2p = mysqli_fetch_array($table2p);
      if (isset($data2p['status_kendaraan'])) {
          $pemilik = $data2p['status_kendaraan'];
          $kontrak = $data2p['kontrak'];
      } else {
          $pemilik = "";
          $kontrak  = "";
      }
       if ($pemilik == 'Bapak Nyoman Edi' || $pemilik == 'Bapak Rama' || $pemilik == 'GM Balkom'|| $pemilik == 'Pak Tanry'  ) {

      echo "<tr>

    <td style='font-size: 14px' >$no_polisi</td>
    <td style='font-size: 14px' >$total_rit</td>
    <td style='font-size: 14px' >$total_point</td>
    


 </tr>";
      }
}

?>
</tbody>
</table>


<br>
<hr>
<br>

<h5 align="center" >Rincian RIT Driver Mesuji</h5>
<!-- Tabel -->    
<table id="example4" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No Polisi</th>
      <th>Rit </th>
      <th>Total Point </th>
    </tr>
  </thead>
  <tbody>
  <?php 
$total_point = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table4)){
      $no_polisi = $data['no_polisi'];
      $total_rit =$data['total_rit'];
      $total_point = $total_rit * 2;
      $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi' ");
      $data2p = mysqli_fetch_array($table2p);
      if (isset($data2p['status_kendaraan'])) {
          $pemilik = $data2p['status_kendaraan'];
          $kontrak = $data2p['kontrak'];
      } else {
          $pemilik = "";
          $kontrak  = "";
      }
       if ($pemilik == 'Bapak Nyoman Edi' || $pemilik == 'Bapak Rama' || $pemilik == 'GM Balkom'|| $pemilik == 'Pak Tanry'  ) {

      echo "<tr>

    <td style='font-size: 14px' >$no_polisi</td>
    <td style='font-size: 14px' >$total_rit</td>
    <td style='font-size: 14px' >$total_point</td>
    


 </tr>";
      }
}

?>
</tbody>
</table>


<br>
<hr>
<br>

<h5 align="center" >Rincian RIT Driver Way Kanan</h5>
<!-- Tabel -->    
<table id="example5" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No Polisi</th>
      <th>Rit </th>
      <th>Total Point </th>
    </tr>
  </thead>
  <tbody>
  <?php 
$total_point = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table5)){
      $no_polisi = $data['no_polisi'];
      $total_rit =$data['total_rit'];
      $total_point = $total_rit * 1;
      $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi' ");
      $data2p = mysqli_fetch_array($table2p);
      if (isset($data2p['status_kendaraan'])) {
          $pemilik = $data2p['status_kendaraan'];
          $kontrak = $data2p['kontrak'];
      } else {
          $pemilik = "";
          $kontrak  = "";
      }
       if ($pemilik == 'Bapak Nyoman Edi' || $pemilik == 'Bapak Rama' || $pemilik == 'GM Balkom'|| $pemilik == 'Pak Tanry'  ) {

      echo "<tr>

    <td style='font-size: 14px' >$no_polisi</td>
    <td style='font-size: 14px' >$total_rit</td>
    <td style='font-size: 14px' >$total_point</td>
    


 </tr>";
      }
}

?>
</tbody>
</table>

<br>
<hr>
<br>

<h5 align="center" >Rincian RIT Driver Tulang Bawang</h5>
<!-- Tabel -->    
<table id="example6" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No Polisi</th>
      <th>Rit </th>
      <th>Total Point </th>
    </tr>
  </thead>
  <tbody>
  <?php 
$total_point = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table6)){
      $no_polisi = $data['no_polisi'];
      $total_rit =$data['total_rit'];
      $total_point = $total_rit * 2;
      $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi' ");
      $data2p = mysqli_fetch_array($table2p);
      if (isset($data2p['status_kendaraan'])) {
          $pemilik = $data2p['status_kendaraan'];
          $kontrak = $data2p['kontrak'];
      } else {
          $pemilik = "";
          $kontrak  = "";
      }
      if ($pemilik == 'Bapak Nyoman Edi' || $pemilik == 'Bapak Rama' || $pemilik == 'GM Balkom'|| $pemilik == 'Pak Tanry'  ) {

      echo "<tr>

    <td style='font-size: 14px' >$no_polisi</td>
    <td style='font-size: 14px' >$total_rit</td>
    <td style='font-size: 14px' >$total_point</td>
    


 </tr>";
      }
}

?>
</tbody>
</table>

<br>
<hr>
<br>

<h5 align="center" >Rincian RIT Driver OKI</h5>
<!-- Tabel -->    
<table id="example7" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No Polisi</th>
      <th>Rit </th>
      <th>Total Point </th>
    </tr>
  </thead>
  <tbody>
  <?php 
$total_point = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table8)){
      $no_polisi = $data['no_polisi'];
      $total_rit =$data['total_rit'];
      $total_point = $total_rit * 2;
      $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi' ");
      $data2p = mysqli_fetch_array($table2p);
      if (isset($data2p['status_kendaraan'])) {
          $pemilik = $data2p['status_kendaraan'];
          $kontrak = $data2p['kontrak'];
      } else {
          $pemilik = "";
          $kontrak  = "";
      }
       if ($pemilik == 'Bapak Nyoman Edi' || $pemilik == 'Bapak Rama' || $pemilik == 'GM Balkom'|| $pemilik == 'Pak Tanry'  ) {
      echo "<tr>

    <td style='font-size: 14px' >$no_polisi</td>
    <td style='font-size: 14px' >$total_rit</td>
    <td style='font-size: 14px' >$total_point</td>
    


 </tr>";
      }
}

?>
</tbody>
</table>

<br>
<hr>
<br>

<h5 align="center" >Rincian RIT Driver OKU</h5>
<!-- Tabel -->    
<table id="example8" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No Polisi</th>
      <th>Rit </th>
      <th>Total Point </th>
    </tr>
  </thead>
  <tbody>
  <?php 
$total_point = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table9)){
      $no_polisi = $data['no_polisi'];
      $total_rit =$data['total_rit'];
      $total_point = $total_rit * 2;
      $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi' ");
      $data2p = mysqli_fetch_array($table2p);
      if (isset($data2p['status_kendaraan'])) {
          $pemilik = $data2p['status_kendaraan'];
          $kontrak = $data2p['kontrak'];
      } else {
          $pemilik = "";
          $kontrak  = "";
      }
       if ($pemilik == 'Bapak Nyoman Edi' || $pemilik == 'Bapak Rama' || $pemilik == 'GM Balkom'|| $pemilik == 'Pak Tanry'  ) {

      echo "<tr>

    <td style='font-size: 14px' >$no_polisi</td>
    <td style='font-size: 14px' >$total_rit</td>
    <td style='font-size: 14px' >$total_point</td>
    


 </tr>";
      }
}

?>
</tbody>
</table>

<br>
<hr>
<br>

<h5 align="center" >Rincian RIT Driver PESIBAR</h5>
<!-- Tabel -->    
<table id="example9" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No Polisi</th>
      <th>Rit </th>
      <th>Total Point </th>
    </tr>
  </thead>
  <tbody>
  <?php 
$total_point = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table10)){
      $no_polisi = $data['no_polisi'];
      $total_rit =$data['total_rit'];
      $total_point = $total_rit * 2;
      $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi' ");
      $data2p = mysqli_fetch_array($table2p);
      if (isset($data2p['status_kendaraan'])) {
          $pemilik = $data2p['status_kendaraan'];
          $kontrak = $data2p['kontrak'];
      } else {
          $pemilik = "";
          $kontrak  = "";
      }
       if ($pemilik == 'Bapak Nyoman Edi' || $pemilik == 'Bapak Rama' || $pemilik == 'GM Balkom'|| $pemilik == 'Pak Tanry'  ) {

      echo "<tr>

    <td style='font-size: 14px' >$no_polisi</td>
    <td style='font-size: 14px' >$total_rit</td>
    <td style='font-size: 14px' >$total_point</td>
    


 </tr>";
      }
}

?>
</tbody>
</table>

<br>
<hr>
<br>

<h5 align="center" >Rincian RIT Driver LAMBAR</h5>
<!-- Tabel -->    
<table id="example10" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No Polisi</th>
      <th>Rit </th>
      <th>Total Point </th>
    </tr>
  </thead>
  <tbody>
  <?php 
$total_point = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table11)){
      $no_polisi = $data['no_polisi'];
      $total_rit =$data['total_rit'];
      $total_point = $total_rit * 2;
      $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi' ");
      $data2p = mysqli_fetch_array($table2p);
      if (isset($data2p['status_kendaraan'])) {
          $pemilik = $data2p['status_kendaraan'];
          $kontrak = $data2p['kontrak'];
      } else {
          $pemilik = "";
          $kontrak  = "";
      }
      if ($pemilik == 'Bapak Nyoman Edi' || $pemilik == 'Bapak Rama' || $pemilik == 'GM Balkom'|| $pemilik == 'Pak Tanry'  ) {

      echo "<tr>

    <td style='font-size: 14px' >$no_polisi</td>
    <td style='font-size: 14px' >$total_rit</td>
    <td style='font-size: 14px' >$total_point</td>
    


 </tr>";
      }
}

?>
</tbody>
</table>

<br>
<hr>
<br>

<h5 align="center" >Rincian RIT Driver Kota Bumi</h5>
<!-- Tabel -->    
<table id="example11" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No Polisi</th>
      <th>Rit </th>
      <th>Total Point </th>
    </tr>
  </thead>
  <tbody>
  <?php 
$total_point = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table7)){
      $no_polisi = $data['no_polisi'];
      $total_rit =$data['total_rit'];
      $total_point = $total_rit * 2;
      $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi' ");
      $data2p = mysqli_fetch_array($table2p);
      if (isset($data2p['status_kendaraan'])) {
          $pemilik = $data2p['status_kendaraan'];
          $kontrak = $data2p['kontrak'];
      } else {
          $pemilik = "";
          $kontrak  = "";
      }
    if ($pemilik == 'Bapak Nyoman Edi' || $pemilik == 'Bapak Rama' || $pemilik == 'GM Balkom'|| $pemilik == 'Pak Tanry'  ) {

      echo "<tr>

    <td style='font-size: 14px' >$no_polisi</td>
    <td style='font-size: 14px' >$total_rit</td>
    <td style='font-size: 14px' >$total_point</td>
    


 </tr>";
      }
}

?>
</tbody>
</table>


<br>
<hr>
<br>

<h5 align="center" >Rincian RIT Driver LAMTENG</h5>
<!-- Tabel -->    
<table id="example12" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No Polisi</th>
      <th>Rit </th>
      <th>Total Point </th>
    </tr>
  </thead>
  <tbody>
  <?php 
$total_point = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table12)){
      $no_polisi = $data['no_polisi'];
      $total_rit =$data['total_rit'];
      $total_point = $total_rit * 2;
      $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi' ");
      $data2p = mysqli_fetch_array($table2p);
      if (isset($data2p['status_kendaraan'])) {
          $pemilik = $data2p['status_kendaraan'];
          $kontrak = $data2p['kontrak'];
      } else {
          $pemilik = "";
          $kontrak  = "";
      }
      if ($pemilik == 'Bapak Nyoman Edi' || $pemilik == 'Bapak Rama' || $pemilik == 'GM Balkom'|| $pemilik == 'Pak Tanry'  ) {

      echo "<tr>

    <td style='font-size: 14px' >$no_polisi</td>
    <td style='font-size: 14px' >$total_rit</td>
    <td style='font-size: 14px' >$total_point</td>
    


 </tr>";
      }
}

?>
</tbody>
</table>


<br>
<hr>
<br>

<h5 align="center" >Rincian RIT Driver Lamtim</h5>
<!-- Tabel -->    
<table id="example13" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No Polisi</th>
      <th>Rit </th>
      <th>Total Point </th>
    </tr>
  </thead>
  <tbody>
  <?php 
$total_point = 0;
  ?>
    <?php while($data = mysqli_fetch_array($table13)){
      $no_polisi = $data['no_polisi'];
      $total_rit =$data['total_rit'];
      $total_point = $total_rit * 2;
      $table2p = mysqli_query($koneksi, "SELECT status_kendaraan , kontrak FROM kendaraan_sl WHERE no_polisi  = '$no_polisi' ");
      $data2p = mysqli_fetch_array($table2p);
      if (isset($data2p['status_kendaraan'])) {
          $pemilik = $data2p['status_kendaraan'];
          $kontrak = $data2p['kontrak'];
      } else {
          $pemilik = "";
          $kontrak  = "";
      }
    if ($pemilik == 'Bapak Nyoman Edi' || $pemilik == 'Bapak Rama' || $pemilik == 'GM Balkom'|| $pemilik == 'Pak Tanry'  ) {

      echo "<tr>

    <td style='font-size: 14px' >$no_polisi</td>
    <td style='font-size: 14px' >$total_rit</td>
    <td style='font-size: 14px' >$total_point</td>
    


 </tr>";
      }
}

?>
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
      lengthChange: true,
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example2').DataTable( {
      lengthChange: true,
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example3').DataTable( {
      lengthChange: true,
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example4').DataTable( {
      lengthChange: true,
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example5').DataTable( {
      lengthChange: true,
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example6').DataTable( {
      lengthChange: true,
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example7').DataTable( {
      lengthChange: true,
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example8').DataTable( {
      lengthChange: true,
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example9').DataTable( {
      lengthChange: true,
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example10').DataTable( {
      lengthChange: true,
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>


<script>
  $(document).ready(function() {
    var table = $('#example11').DataTable( {
      lengthChange: true,
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example12').DataTable( {
      lengthChange: true,
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>
<script>
  $(document).ready(function() {
    var table = $('#example113').DataTable( {
      lengthChange: true,
      buttons: ['excel']
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>



</body>

</html>