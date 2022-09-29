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
  $table  = mysqli_query($koneksicbm, "SELECT * FROM riwayat_saldo_armada WHERE tanggal = '$tanggal_awal' AND status_saldo = 'Masuk' AND nama_rekening = 'Melodi Tani' AND referensi = 'CBM' 
                                                                         OR tanggal = '$tanggal_awal' AND status_saldo = 'Masuk' AND nama_rekening = 'Melodi Tani' AND referensi = 'PBJ' 
                                                                         OR tanggal = '$tanggal_awal' AND status_saldo = 'Masuk' AND nama_rekening = 'Melodi Tani' AND referensi = 'Melodi Tani'
                                                                         OR tanggal = '$tanggal_awal' AND status_saldo = 'Masuk' AND nama_rekening = 'PBJ' AND referensi = 'Melodi Tani'
                                                                         OR tanggal = '$tanggal_awal' AND status_saldo = 'Masuk' AND nama_rekening = 'CBM' AND referensi = 'Melodi Tani'
                                                                         OR tanggal = '$tanggal_awal' AND status_saldo = 'Keluar' AND nama_rekening = 'Melodi Tani' AND referensi = 'Melodi Tani'
                                                                         OR tanggal = '$tanggal_awal' AND status_saldo = 'Keluar' AND nama_rekening = 'Melodi Tani' AND referensi = 'BALSRI'
                                                                         OR tanggal = '$tanggal_awal' AND status_saldo = 'Keluar' AND nama_rekening = 'Melodi Tani' AND referensi = 'Kebun Lengkiti'
                                                                         OR tanggal = '$tanggal_awal' AND status_saldo = 'Keluar' AND nama_rekening = 'Melodi Tani' AND referensi = 'MES/PBR'
                                                                        
                                                                           ");
  
}
else{
$table = mysqli_query($koneksicbm, "SELECT * FROM riwayat_saldo_armada  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_saldo = 'Masuk' AND nama_rekening = 'Melodi Tani' AND referensi ='CBM' 
                                                                     OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_saldo = 'Masuk' AND nama_rekening = 'Melodi Tani' AND referensi = 'PBJ' 
                                                                     OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_saldo = 'Masuk' AND nama_rekening = 'Melodi Tani' AND referensi =  'Melodi Tani'
                                                                     OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_saldo = 'Masuk' AND nama_rekening = 'PBJ' AND referensi =  'Melodi Tani'
                                                                     OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_saldo = 'Masuk' AND nama_rekening = 'CBM' AND referensi = 'Melodi Tani'
                                                                     OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_saldo = 'Keluar' AND nama_rekening = 'Melodi Tani' AND referensi =  'Melodi Tani' 
                                                                     OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_saldo = 'Keluar' AND nama_rekening = 'Melodi Tani' AND referensi =  'BALSRI'
                                                                     OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_saldo = 'Keluar' AND nama_rekening = 'Melodi Tani' AND referensi =  'Kebun Lengkiti'
                                                                     OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_saldo = 'Keluar' AND nama_rekening = 'Melodi Tani' AND referensi =  'MES/PBR' 
                                                                   
                                                                      ");

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

  <title>Rincian Saldo Melodi Tani</title>

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
               <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsStaffAdmin">
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
                     Menu PTCBM
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
                        <a class="collapse-item" style="font-size: 15px;" href="DsPTCBM">PT. CBM</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/CV.PBJ/view/DsCVPBJ">CV.PBJ</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BatuBara/view/DsCVPBJ">Transport BB</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.BALSRI/view/DsPTBALSRI">PT.BALSRI</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.MESPBR/view/DsPTPBRMES">PT. MES & PBR</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/Kebun/view/DsKebun">Kebun</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PERTASHOP/view/DsPertashop">Pertashop</a>
                        <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.STRE/view/DsPTSTRE">PT.Sri Trans Energi</a>
                    </div>
                </div>
            </li>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                  15  aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Laporan Perusahan</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Laporan</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan1">Laporan Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLPenjualan1">Laporan Penjaulan</a>
                        <?php if($nama == 'Nyoman Edy Susanto'){
                        echo"<a class='collapse-item' style='font-size: 15px;' href='VLabaRugi'>Laba Rugi</a>";
                        } ?>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenggunaanSaldo">Laporan Saldo</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VBonKaryawan">Laporan BON </a>
                    </div>
                </div>
            </li>
            
            <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2"
                  15  aria-expanded="true" aria-controls="collapseTwo2">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
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
      <?php echo "<a href='VRincianCBM'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Rincian Saldo Melodi Tani</h5></a>"; ?>
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

<!-- Top content -->
<div>   


  <!-- Name Page -->
  <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">
 <?php echo "<a href='VPenggunaanSaldo2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><button type='button' class='btn btn-primary'>Kembali</button></a>"; ?>
  </form>

  <div class="row">
    <div class="col-md-8">
     <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
   </div>
   </div>
 

<!-- Tabel -->    
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Akun</th>
      <th>REF</th>
      <th>Rekening</th>
      <th>Debit</th>
      <th>Kredit</th>
      <th>Keterangan</th>
      <th>File</th>
    </tr>
  </thead>
  <tbody>
    <?php
    //Masuk CBM Keluar CBM
    $masuk_cbm_cbm = 0;
    //Masuk CBM Keluar PBJ
    $masuk_cbm_pbj = 0;
    //mASUK cbm kELUAR MT
    $masuk_cbm_mt = 0;
    //masuk mt keluar cbm
    $masuk_mt_cbm = 0;
    //masuk mt keluar pbj
    $masuk_mt_pbj = 0;
    //masuk mt keluar mt
    $masuk_mt_mt = 0;
    //masuk pbj keluar cbm
    $masuk_pbj_cbm = 0;
    //masuk pbj keluar pbj
    $masuk_pbj_pbj = 0;
    //masuk pbj keluar mt
    $masuk_pbj_mt = 0;
    
    
    //keluar cbm masuk cbm
    $keluar_cbm_cbm = 0;
    //keluar cbm masuk pbj
    $keluar_cbm_pbj = 0;
    //keluar cbm masuk mt
    $keluar_cbm_mt = 0;
    //keluar mt masuk cbm
    $keluar_mt_cbm = 0;
    //keluar mt masuk pbj
    $keluar_mt_pbj = 0;
    //keluar mt masuk mt
    $keluar_mt_mt = 0;
    //keluar pbj masuk cbm
    $keluar_pbj_cbm = 0;
    //keluar pbj masuk pbj
    $keluar_pbj_pbj = 0;
    //keluar pbj masuk mt
    $keluar_pbj_mt = 0;

    //setor dana cbm ke cbm
    $setor_cbm_cbm = 0;
    //setor dana cbm ke pbj
    $setor_cbm_pbj = 0;
    //setor dana cbm ke mt
    $setor_cbm_mt = 0;
    //setor dana mt ke cbm
    $setor_mt_cbm = 0;
    //setor dana mt ke pbj
    $setor_mt_pbj = 0;
    //setor dana mt ke mt
    $setor_mt_mt = 0;
    //setor dana pbj ke cbm
    $setor_pbj_cbm = 0;
    //setor dana pbj ke pbj
    $setor_pbj_pbj = 0;
    //setor dana pbj ke mt
    $setor_pbj_mt = 0;

    //khusus
    //keluar cbm ke balsri
    $keluar_cbm_balsri = 0 ;
    //keluar pbj ke balsri
    $keluar_pbj_balsri = 0 ;
    //keluar mt ke balsri
    $keluar_mt_balsri = 0 ;
    //keluar cbm ke kebun lengkiti
    $keluar_cbm_keling = 0 ;
    //keluar pbj ke kebun lengkiti
    $keluar_pbj_keling = 0 ;
    //keluar mt ke kebun lengkiti
    $keluar_mt_keling = 0 ;
        //keluar cbm ke pbr
    $keluar_cbm_pbr = 0 ;
    //keluar pbj ke pbr
    $keluar_pbj_pbr = 0 ;
    //keluar mt ke pbr
    $keluar_mt_pbr = 0 ;
    //keluar cbm ke mes
    $keluar_cbm_mes = 0 ;
    //keluar pbj ke mes
    $keluar_pbj_mes = 0 ;
    //keluar mt ke mes
    $keluar_mt_mes = 0 ;
    
    $urut = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>
    <?php while($data = mysqli_fetch_array($table)){
      $no_laporan = $data['no_laporan'];
      $tanggal =$data['tanggal'];
      $referensi = $data['referensi'];
      $nama_akun = $data['nama_akun'];
      $nama_rekening = $data['nama_rekening'];
      $jumlah = $data['jumlah'];
      $file_bukti = $data['file_bukti'];
      $keterangan = $data['keterangan'];
      $status_saldo = $data['status_saldo'];
    
    //Masuk CBM Keluar CBM
    if ($status_saldo == 'Masuk' && $nama_rekening == 'CBM' && $referensi == 'CBM') {
        $masuk_cbm_cbm = $masuk_cbm_cbm + $jumlah;
      }
    //Masuk CBM Keluar PBJ
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'CBM' && $referensi == 'PBJ') {
        $masuk_cbm_pbj = $masuk_cbm_pbj + $jumlah;
      }
    //mASUK cbm kELUAR MT
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'CBM' && $referensi == 'Melodi Tani') {
        $masuk_cbm_mt = $masuk_cbm_mt + $jumlah;
      }
    //masuk mt keluar cbm
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'Melodi Tani' && $referensi == 'CBM') {
        $masuk_mt_cbm = $masuk_mt_cbm + $jumlah;
      }
    //masuk mt keluar pbj
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'Melodi Tani' && $referensi == 'PBJ') {
        $masuk_mt_pbj = $masuk_mt_pbj + $jumlah;
      }
    //masuk mt keluar mt
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'Melodi Tani' && $referensi == 'Melodi Tani') {
        $masuk_mt_mt = $masuk_mt_mt + $jumlah;
      }
    //masuk pbj keluar cbm
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'PBJ' && $referensi == 'CBM') {
        $masuk_pbj_cbm = $masuk_pbj_cbm + $jumlah;
      }
    //masuk pbj keluar pbj
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'PBJ' && $referensi == 'PBJ') {
        $masuk_pbj_pbj = $masuk_pbj_pbj + $jumlah;
      }
    //masuk pbj keluar mt
    else if ($status_saldo == 'Masuk' && $nama_rekening == 'PBJ' && $referensi == 'Melodi Tani') {
        $masuk_pbj_mt = $masuk_pbj_mt + $jumlah;
      }
    
    
    //keluar cbm masuk cbm
    if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'CBM' && $nama_akun != 'Setor ke Bank' ) {
        $keluar_cbm_cbm = $keluar_cbm_cbm + $jumlah;
      }
    //keluar cbm masuk pbj
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'PBJ' && $nama_akun != 'Setor ke Bank'  ) {
        $keluar_cbm_pbj = $keluar_cbm_pbj + $jumlah;
      }
    //keluar cbm masuk mt
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'Melodi Tani' && $nama_akun != 'Setor ke Bank' ) {
        $keluar_cbm_pbj = $keluar_cbm_pbj + $jumlah;
      }
    //keluar mt masuk cbm
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'CBM' && $nama_akun != 'Setor ke Bank' ) {
        $keluar_cbm_pbj = $keluar_cbm_pbj + $jumlah;
      }
    //keluar mt masuk pbj
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'PBJ' && $nama_akun != 'Setor ke Bank' ) {
        $keluar_cbm_pbj = $keluar_cbm_pbj + $jumlah;
      }
    //keluar mt masuk mt
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'Melodi Tani' && $nama_akun != 'Setor ke Bank' ) {
        $keluar_cbm_pbj = $keluar_cbm_pbj + $jumlah;
      }
    //keluar pbj masuk cbm
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'CBM' && $nama_akun != 'Setor ke Bank' ) {
        $keluar_cbm_pbj = $keluar_cbm_pbj + $jumlah;
      }
    //keluar pbj masuk pbj
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'PBJ' && $nama_akun != 'Setor ke Bank' ) {
        $keluar_cbm_pbj = $keluar_cbm_pbj + $jumlah;
      }
    //keluar pbj masuk mt
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'Melodi Tani' && $nama_akun != 'Setor ke Bank' ) {
        $keluar_cbm_pbj = $keluar_cbm_pbj + $jumlah;
      }
    //keluar cbm masuk balsri
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'BALSRI') {
        $keluar_cbm_balsri = $keluar_cbm_balsri + $jumlah;
      }
    //keluar pbj masuk balsri
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'BALSRI') {
        $keluar_pbj_balsri = $keluar_pbj_balsri + $jumlah;
      }
    //keluar mt masuk balsri
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'BALSRI') {
        $keluar_mt_balsri = $keluar_mt_balsri + $jumlah;
      }
    //keluar cbm masuk kebun lengkiti
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'Kebun Lengkiti') {
        $keluar_cbm_keling = $keluar_cbm_keling + $jumlah;
      }
    //keluar pbj masuk  kebun lengkiti
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'Kebun Lengkiti') {
        $keluar_pbj_keling = $keluar_pbj_keling + $jumlah;
      }
    //keluar mt masuk  kebun lengkiti
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'Kebun Lengkiti') {
        $keluar_mt_keling = $keluar_mt_keling + $jumlah;
      }
    //keluar cbm masuk balsri
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'MES/PBR') {
        $keluar_cbm_pbr = $keluar_cbm_pbr + $jumlah;
      }
    //keluar pbj masuk balsri
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'MES/PBR') {
        $keluar_pbj_pbr = $keluar_pbj_pbr + $jumlah;
      }
    //keluar mt masuk balsri
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'MES/PBR') {
        $keluar_mt_pbr = $keluar_mt_pbr + $jumlah;
      }

    
    //setor dana cbm ke cbm
    if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'CBM' && $nama_akun == 'Setor ke Bank' ) {
        $setor_cbm_cbm = $setor_cbm_cbm + $jumlah;
      }
    //setor dana cbm ke pbj
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'PBJ' && $nama_akun == 'Setor ke Bank' ) {
        $setor_cbm_pbj = $setor_cbm_pbj + $jumlah;
      }
    //setor dana cbm ke mt
   else if ($status_saldo == 'Keluar' && $nama_rekening == 'CBM' && $referensi == 'Melodi Tani' && $nama_akun == 'Setor ke Bank' ) {
        $setor_cbm_mt = $setor_cbm_mt + $jumlah;
      }
    //setor dana mt ke cbm
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'CBM' && $nama_akun == 'Setor ke Bank' ) {
        $setor_mt_cbm = $setor_mt_cbm + $jumlah;
      }
    //setor dana mt ke pbj
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'PBJ' && $nama_akun == 'Setor ke Bank' ) {
        $setor_mt_pbj = $setor_mt_pbj + $jumlah;
      }
    //setor dana mt ke mt
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'Melodi Tani' && $referensi == 'Melodi Tani' && $nama_akun == 'Setor ke Bank' ) {
        $setor_mt_mt = $setor_mt_mt + $jumlah;
      }
    //setor dana pbj ke cbm
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'CBM' && $nama_akun == 'Setor ke Bank' ) {
        $setor_pbj_cbm = $setor_pbj_cbm + $jumlah;
      }
    //setor dana pbj ke pbj
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'PBJ' && $nama_akun == 'Setor ke Bank' ) {
        $setor_pbj_pbj = $setor_pbj_pbj + $jumlah;
      }
    //setor dana pbj ke mt
    else if ($status_saldo == 'Keluar' && $nama_rekening == 'PBJ' && $referensi == 'Melodi Tani' && $nama_akun == 'Setor ke Bank' ) {
        $setor_pbj_mt = $setor_pbj_mt + $jumlah;
      }

        $urut = $urut + 1;
      echo "<tr>
      <td style='font-size: 14px'>$urut</td>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$nama_akun</td>
      <td style='font-size: 14px'>$referensi</td>
      <td style='font-size: 14px'>$nama_rekening</td>";


      if ($status_saldo == 'Masuk') {
        echo "
        <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>";
      }
      else{
        echo "
        <td style='font-size: 14px'>"?>  <?php echo "</td>";
      }

      if ($status_saldo == 'Keluar') {
        echo "
        <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>";
      }
      else{
        echo "
        <td style='font-size: 14px'>"?>  <?php echo "</td>";
      }
        
      echo "
      <td style='font-size: 14px'>$keterangan</td>
      <td style='font-size: 14px'>"; ?> <a download="/PT.CBM/Operasional//file_oprasional/<?= $file_bukti ?>" href="/PT.CBM/Operasional//file_oprasional/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>
     

    <?php echo  " </tr>";
  }
  ?>

</tbody>
</table>
</div>
<br>
<br>
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
      <td style='font-size: 14px'>";?> <?= formatuang($masuk_cbm_mt + $masuk_pbj_mt + $keluar_mt_balsri + $keluar_mt_keling + $keluar_mt_mt + $keluar_mt_pbr ); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($setor_mt_mt + $setor_mt_cbm + $setor_mt_pbj); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang(($masuk_mt_mt + $masuk_mt_cbm + $masuk_mt_pbj)-($masuk_cbm_mt + $masuk_pbj_mt + $keluar_mt_balsri + $setor_mt_mt + $setor_mt_cbm + $setor_mt_pbj + $keluar_mt_keling + $keluar_mt_mt + $keluar_mt_pbr )); ?> <?php echo "</td>
      <td class='text-center'><a href='VRincianMT?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'>Rincian</a></td>
        </tr>";
  
  ?>

</tbody>
</table>
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
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

</body>

</html>